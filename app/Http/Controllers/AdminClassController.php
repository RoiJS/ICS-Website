<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;

class AdminClassController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    }

    public function render_classes(){
        return view('admin.classes.classes'); 
    }

    public function set_class_details(){
        
        $class_detail = $this->request->class_details;
        $course_id = $class_detail['course_id'];
        $curriculum_subject_id = $class_detail['curriculum_subject_id'];
        $section = $class_detail['section'];

        $semester_id = $class_detail['semester_id'];
        $school_year_id = $class_detail['school_year_id'];

      $class_details = DB::table('classes')
            ->join('loads','classes.load_id','=','loads.load_id')
            ->join('curriculum_subjects','curriculum_subjects.curriculum_subject_id','=','loads.curriculum_subject_id')
            ->join('curriculum_year_sem','curriculum_year_sem.curriculum_year_sem_id','=','curriculum_subjects.curriculum_year_sem_id')
            ->join('subjects','curriculum_subjects.subject_id','=','subjects.subject_id')
            ->join('teachers','classes.teacher_id','=','teachers.teacher_id')
            ->where([
                'classes.semester_id' => $semester_id, 
                'classes.school_year_id' => $school_year_id, 
                'course_id' => $course_id,
                'curriculum_subjects.curriculum_subject_id' => $curriculum_subject_id,
                'section' => $section
            ])
            ->first();

        if ($class_details != null) $class_details->year_level_name = $this->helper->str_ordinal($class_details->year_level);

        return response()->json(['class_details' => $class_details]);
    }

    public function get_official_class_list($id){
        
        $class_list = DB::table('class_lists')
            ->join('classes','class_lists.class_id','=','classes.class_id')
            ->join('students','class_lists.student_id','=','students.stud_id')
            ->where(['classes.class_id' => $id])
            ->get();

        return response()->json(['class_list' => $class_list]);
    }

    public function add_student_class(){
        $stud_id = $this->request->stud_id;
        $class_id = $this->request->class_id;

        $addStudentClass = DB::table('class_lists') 
            ->insert([
                'class_id' => $class_id,
                'student_id' => $stud_id,
                'is_approved' => 1
            ]);
        
        return response()->json(['status' => $addStudentClass]);
    }

    public function remove_student_class($id){
        $removeStudentClass = DB::table('class_lists')  
            ->where(['class_list_id' => $id])
            ->delete();

        return response()->json(['status' => $removeStudentClass]);
    }

    public function get_sections(){
        $sections = DB::table('loads')
            ->select(DB::raw("DISTINCT(section) as section"))
            ->get();
        
        return response()->json(['sections' => $sections]);
    }
}
