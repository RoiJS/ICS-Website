<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class StudentEnrollSubjectsController extends Controller
{
     protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function render_enroll_subjects(){
        return view('student.enroll_subjects');
    }

    public function get_subjects($course, $yearLevel){


        $school_year = $this->helper->get_current_school_year();
        $semester = $this->helper->get_current_semester();
        
        $condition = [
            'classes.school_year_id' => $school_year->school_year_id,
            'classes.semester_id' => $semester->semester_id
        ];

        if ($course != 0) $condition += ['curriculum.course_id' => $course];

        if ($yearLevel != 0) $condition += ['curriculum_year_sem.year_level' => $yearLevel];

        $subjects = DB::table('classes')
            ->join('loads','classes.load_id','=','loads.load_id')
            ->join('curriculum_subjects','curriculum_subjects.curriculum_subject_id','=','loads.curriculum_subject_id')
            ->join('subjects','curriculum_subjects.subject_id','=','subjects.subject_id')
            ->join('teachers','teachers.teacher_id','=','classes.teacher_id')
            ->join('curriculum_year_sem','curriculum_year_sem.curriculum_year_sem_id','=','curriculum_subjects.curriculum_year_sem_id')
            ->join('curriculum','curriculum_year_sem.curriculum_id','=','curriculum.curriculum_id')
            ->where($condition)
            ->orderBy('year_level', 'asc')
            ->get();

        $subjects->map(function($subject){

            $account = $this->helper->get_current_account();
            $user = $this->helper->get_user_info($account->account_id);

            $verify = DB::table('class_lists')
                ->where(['class_id' => $subject->class_id, 'student_id' => $user->stud_id])
                ->first();

            $subject->is_enrolled = ($verify != null && $verify->is_approved == 1);

            if ($verify == null) { 
                $subject->is_enrolled = -1; // Student is not yet enrolled
            } else if ($verify != null && $verify->is_approved == 0) {
                $subject->is_enrolled = 0; // Student is enrolled but request status is unpprove
            } else if ($verify != null && $verify->is_approved == 1) {
                $subject->is_enrolled = 1; // Student is enrolled and request status is approved
            }

            $subject->year_level_name = $this->helper->str_ordinal($subject->year_level);
        });

        return response()->json(['subjects' => $subjects]);
    }    

    public function enroll_subject(){

        $class_id = $this->request->class_id;
        $account = $this->helper->get_current_account();
        $user = $this->helper->get_user_info($account->account_id);

        $enrollSubject = DB::table('class_lists')
            ->insert([
                'class_id' => $class_id,
                'student_id' => $user->stud_id,
                'is_approved' => 0,
                'requested_at' => Carbon::now()
            ]);
        return response()->json(['status' => $enrollSubject]);
    }

    public function unenroll_subject(){

        $class_id = $this->request->class_id;
        $account = $this->helper->get_current_account();
        $user = $this->helper->get_user_info($account->account_id);

        $unenrollSubject = DB::table('class_lists')
            ->where(['class_id' => $class_id, 'student_id' => $user->stud_id])
            ->delete();

        return response()->json(['status' => $unenrollSubject]);
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

    public function get_courses(){
        $courses = DB::table('courses')
            ->orderBy('description', 'desc')
            ->get();

        return response()->json(['courses' => $courses]);
    }
}
