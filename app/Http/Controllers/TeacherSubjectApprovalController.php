<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class TeacherSubjectApprovalController extends Controller
{
    
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function render_subjects_approval(){
        return view('teacher.approve_student_subjects');
    }

    public function get_subjects_approval(){
        $account = $this->helper->get_current_account();
        $user = $this->helper->get_user_info($account->account_id);
        $semester = $this->helper->get_current_semester();
        $school_year = $this->helper->get_current_school_year();
        
        // FIXED: subjects relation to loads 
        $subjects = DB::table('classes')
            ->join('class_lists','classes.class_id','=','class_lists.class_id')
            ->join('students','class_lists.student_id','=','students.stud_id')
            ->join('loads','classes.load_id','=','loads.load_id')
            ->join('curriculum_subjects','curriculum_subjects.curriculum_subject_id','=','loads.curriculum_subject_id')
            ->join('subjects','curriculum_subjects.subject_id','=','subjects.subject_id')
            ->where([
                'classes.semester_id' => $semester->semester_id,
                'classes.school_year_id' => $school_year->school_year_id,
                'is_approved' => 0
            ])
            ->get();

        return response()->json(['subjects' => $subjects]);
    }

    public function approve_subject(){
        $class_list_id = $this->request->class_list_id;

        $approveSubject = DB::table('class_lists')   
            ->where(['class_list_id' => $class_list_id])
            ->update([
                'is_approved' => 1
            ]);
        return response()->json(['status' => $approveSubject]);
    }
}
