<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use DB;

class AdminCurriculumController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    }

    public function render_curriculum(){
        return view('admin.curriculum.curriculum');
    }

    public function get_curriculum_subjects(){

        $course = $this->request->course['course_id'];
        $school_year = $this->request->school_year;
        $semester = $this->request->semester['semester_id'];
        $year_level = $this->request->year_level;
        $condition = [
                'course_id' => $course, 
                'curriculum_year' => $school_year,
                'curriculum_year_sem.semester_id' => $semester
            ];
        
            
        if($year_level != null) $condition += ['year_level' => $year_level];
            
        $curriculum_subjects = DB::table('curriculum')
            ->join('curriculum_year_sem','curriculum_year_sem.curriculum_id','=','curriculum.curriculum_id')
            ->join('curriculum_subjects','curriculum_year_sem.curriculum_year_sem_id','=','curriculum_subjects.curriculum_year_sem_id')
            ->join('subjects','curriculum_subjects.subject_id','=','subjects.subject_id')
            ->where($condition)
            ->orderBy('year_level', 'asc')
            ->select(
                'curriculum_subjects.curriculum_subject_id',
                'subjects.subject_id',
                'subject_code',
                'subject_description',
                'lec_units',
                'lab_units', 
                'year_level'
            )
            ->get();

        $curriculum_subjects->map(function($subject){
            $subject->year_level_name = $this->helper->str_ordinal($subject->year_level);
        });

        return response()->json(['curriculum_subjects' => $curriculum_subjects]);
    }

    public function save_curriculum_subjects(){

       return  DB::transaction(function () {

            $subject = $this->request->subject;
            $course = $this->request->course['course_id'];
            $curriculum_year = $this->request->school_year;
            $semester = $this->request->semester['semester_id'];
            $year_level = $this->request->year_level;  

            $saveCurriculum = DB::table('curriculum')
                ->insertGetId([
                    'course_id' => $course,
                    'school_year_id' => 0,
                    'curriculum_year' => $curriculum_year
                ]);

            $saveCurriculumYearSem = DB::table('curriculum_year_sem')
                ->insertGetId([
                    'curriculum_id' => $saveCurriculum,
                    'year_level' => $year_level,
                    'semester_id' => $semester
                ]);

            $saveNewCurriculumSubjects = DB::table('curriculum_subjects')
                ->insert([
                    'curriculum_year_sem_id' => $saveCurriculumYearSem,
                    'subject_id' => $subject                    
                ]);

            return response()->json(['status' => [$saveCurriculum, $saveCurriculumYearSem, $saveNewCurriculumSubjects]]);
        });
        
    }

    public function remove_curriculum_subject($id){
        $removeCurriculumSubject = DB::table('curriculum_subjects')
            ->where(['curriculum_subject_id' => $id])
            ->delete();

        return response()->json(['status' => $removeCurriculumSubject]);
    }

    public function get_curriculum_school_years(){

        $curriculum_school_years = DB::table('curriculum')
            ->join('school_years','curriculum.school_year_id','=','school_years.school_year_id')
            ->select('school_years.school_year_id', 'sy_from',  DB::raw('CONCAT(sy_from," - ", sy_to) as school_year'))
            ->distinct()
            ->orderBy('sy_from','desc')
            ->get(); 

        return response()->json(['curriculum_school_years' => $curriculum_school_years]);
    }

    public function verify_subject_exists(){

        $subject_id = $this->request->details["subjectId"];
        $course_id = $this->request->details["courseId"];
        $semester_id = $this->request->details["semesterId"];
        $curriculum_year = $this->request->details["schoolyear"];
        
        $verify_existence = DB::table('curriculum')
            ->join('curriculum_year_sem', 'curriculum_year_sem.curriculum_id', '=', 'curriculum.curriculum_id')
            ->join('curriculum_subjects', 'curriculum_subjects.curriculum_year_sem_id', '=', 'curriculum_year_sem.curriculum_year_sem_id')
            ->where([
                'subject_id' => $subject_id,
                'course_id' => $course_id,
                'semester_id' => $semester_id,
                'curriculum_year' => $curriculum_year,
            ])
            ->first();

        $result = $verify_existence != null;

        return response()->json(['result' => $result]);
    }

    public function verify_subject_exists_in_loads() {

        $curriculum_subject_id = $this->request->curriculum_subject_id;

        $verify_existence = DB::table('loads')
            ->where([
                'curriculum_subject_id' => $curriculum_subject_id
            ])
            ->first();

        $result = $verify_existence != null;

        return response()->json(['result' => $result]);
    }

    public function get_curriculum_years() {

        $curriculum_years = DB::table('curriculum')
            ->select('curriculum_year')
            ->distinct()
            ->orderBy('curriculum_year', 'desc')
            ->get();

        return response()->json(['curriculum_years' => $curriculum_years]);
    }
    
    public function get_curriculum_year_levels() {

        $curriculum_year_levels = DB::table('curriculum_year_sem')
            ->select('year_level')
            ->distinct()
            ->orderBy('year_level', 'asc')
            ->get();

        $curriculum_year_levels->map(function($year_level){
            $year_level->year_level_name = $this->helper->str_ordinal($year_level->year_level);
        });

        return response()->json(['curriculum_year_levels' => $curriculum_year_levels]);
    }

    public function print_curriculum_page($course_description, $course, $curriculum_year) {
        
        $formatted_object = [];

        $curriculum_subjects = collect(DB::select(DB::raw("CALL GetCurriculumSubjectDetails($curriculum_year, $course)")));

        $curriculum_subjects->map(function($c) { $c->year_level_name = $this->get_year_level_name($c->year_level); });

        $curriculum_subjects_list = [];

        foreach ($curriculum_subjects as $key => $value) {

            if (array_key_exists($value->year_level_name, $curriculum_subjects_list) == false) {
                $curriculum_subjects_list[$value->year_level_name] = [];
                $curriculum_subjects_list[$value->year_level_name][$value->semester] = [];
                $curriculum_subjects_list[$value->year_level_name][$value->semester]['subjects'] = [];
                $curriculum_subjects_list[$value->year_level_name][$value->semester]['subjects'] += [$value];
                $curriculum_subjects_list[$value->year_level_name][$value->semester]['units_overall_total'] = $value->total_units;
            } else {
                if (array_key_exists($value->semester, $curriculum_subjects_list[$value->year_level_name]) == false) {
                    $curriculum_subjects_list[$value->year_level_name][$value->semester] = [];
                    $curriculum_subjects_list[$value->year_level_name][$value->semester]['subjects'] = [];
                    $curriculum_subjects_list[$value->year_level_name][$value->semester]['subjects'] += [$value];
                    $curriculum_subjects_list[$value->year_level_name][$value->semester]['units_overall_total'] = $value->total_units;
                } else {
                    $curriculum_subjects_list[$value->year_level_name][$value->semester]['units_overall_total'] += $value->total_units;
                    array_push($curriculum_subjects_list[$value->year_level_name][$value->semester]['subjects'], $value);
                }
            }
        }

        return view('admin.curriculum.print_curriculum', [
                'course_description' => $course_description,
                'curriculum_year' => $curriculum_year,
                'curriculum_subjects_list' => $curriculum_subjects_list
            ]);
    }

    private function get_year_level_name($year_level) {

        switch ($year_level) {
            case 1:
                return "First year";
                break;
            case 2:
                return "Second year";
                break;
            case 3:
                return "Third year";
                break;
            case 4:
                return "Fourth year";
                break;
            case 5:
                return "Fifth year";
                break;
        }
    }
}
