<?php

namespace App\Http\Controllers;

use App\ICSClasses\Helper;
use Illuminate\Http\Request;
use \DB;

class AdminLoadController extends Controller
{
    protected $helper = [];
    protected $request = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    }

    public function render_load(){
        return view('admin.faculty.load');
    }

    public function get_faculty_subjects(){

        $faculty_id = $this->request->faculty_id;
        $semester_id = $this->request->semester_id;
        $school_year_id = $this->request->school_year_id;
        
        $faculty_subjects = DB::table('classes')
            ->join('loads','loads.load_id','=', 'classes.load_id')
            ->join('curriculum_subjects','loads.curriculum_subject_id','=', 'curriculum_subjects.curriculum_subject_id')
            ->join('curriculum_year_sem','curriculum_year_sem.curriculum_year_sem_id','=', 'curriculum_subjects.curriculum_year_sem_id')
            ->join('subjects','curriculum_subjects.subject_id','=','subjects.subject_id')
            ->where(['classes.semester_id' => $semester_id, 'classes.school_year_id' => $school_year_id, 'teacher_id' => $faculty_id])
            ->get();

        $faculty_subjects->map(function($subject){
            $subject->year_level_name = $this->helper->str_ordinal($subject->year_level);
        });

        return response()->json(['faculty_subjects' => $faculty_subjects]);
    }

    public function save_new_faculty_subject(){
        return DB::transaction(function () {

            $load = $this->request->load;

            $faculty_id = $load['faculty_id'];
            $semester_id = $load['semester_id'];
            $school_year_id = $load['school_year_id'];

            $course_id = $load['course_id'];
            $subject_id = $load['subject_id'];
            $curriculum_subject_id = $load['curriculum_subject_id'];

            $saveLoad = DB::table('loads')
                ->insertGetId([
                    'course_id' => $course_id,
                    'subject_id' => $subject_id,
                    'curriculum_subject_id' => $curriculum_subject_id,
                ]);

            $saveClass = DB::table('classes')
                ->insertGetId([
                    'load_id' => $saveLoad,
                    'semester_id' => $semester_id,
                    'school_year_id' => $school_year_id,
                    'teacher_id' => $faculty_id
                ]);

            return response()->json([
                'status' => ($saveLoad > 1 && $saveClass > 1), 
                'class_id' => $saveClass
            ]);
        });
    }

    public function save_update_faculty_subject(){

        return DB::transaction(function () {

            $subject = $this->request->subject;

            $load_id = $subject['load_id'];
            $section = $subject['section'];
            $monday = $subject['monday'] == true ? 1 : 0;
            $tuesday = $subject['tuesday'] == true ? 1 : 0;
            $wednesday = $subject['wednesday'] == true ? 1 : 0;
            $thursday = $subject['thursday'] == true ? 1 : 0;
            $friday = $subject['friday'] == true ? 1 : 0;
            $saturday = $subject['saturday'] == true ? 1 : 0;
            $start_time = $subject['_new_start_time'];
            $end_time = $subject['_new_end_time'];
            $room = $subject['room'];

            $saveUpdateFacultySubject = DB::table('loads')
                ->where(['load_id' => $load_id])
                ->update([
                    'section' => $section,
                    'monday' => $monday,
                    'tuesday' => $tuesday,
                    'wednesday' => $wednesday,
                    'thursday' => $thursday,
                    'friday' => $friday,
                    'saturday' => $saturday,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'room' => $room
                ]);

            return response()->json(['status' => $saveUpdateFacultySubject]);
        });
    }

    public function remove_faculty_subject($id){
        $removeFacultySubject = DB::table('loads')
            ->where(['load_id' => $id])
            ->delete(); 

        return response()->json(['status' => $removeFacultySubject]);
    }

    public function get_sections(){
        $sections = DB::table('loads')
            ->select(DB::raw("DISTINCT(section) as section"))
            ->get();
        
        return response()->json(['sections' => $sections]);
    }

    public function verify_if_subject_exist_from_other_faculty(){
        
        $faculty_id = $this->request->faculty_id;
        $curriculum_subject_id = $this->request->curriculum_subject_id;
        $section = $this->request->section;
        $semester = $this->helper->get_current_semester();
        $school_year = $this->helper->get_current_school_year();

        $class_load = DB::table('classes')
            ->join('loads', 'classes.load_id', '=', 'loads.load_id')
            ->where([
                ['teacher_id', '!=', $faculty_id],
                ['curriculum_subject_id', '=', $curriculum_subject_id],
                ['section', '=', $section],
                ['semester_id', '=', $semester->semester_id],
                ['school_year_id', '=', $school_year->school_year_id]
            ])
            ->get();

        return response()->json(['class_load' => $class_load]);
    }
}
