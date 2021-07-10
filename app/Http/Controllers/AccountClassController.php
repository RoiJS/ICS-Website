<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class AccountClassController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function get_class_list(){
        $class_id = $this->request->class_id;

        $class_list = DB::table('class_lists')
            ->join('students','class_lists.student_id','=','students.stud_id')
            ->where(['class_id' => $class_id])
            ->get();
            
        
        return response()->json(['classes' => $class_list]);
    }

    public function remove_student($id){
        $removeStudent = DB::table('class_lists')
            ->where(['class_list_id' => $id])
            ->delete();

        return response()->json(['status' => $removeStudent]);
    }

    public function get_student_list(){

        $class_id = $this->request->class_id;

        $students = DB::table('students')
            ->join('accounts','students.stud_id','=','accounts.user_id')
            ->where(['type' => 'student'])
            ->orderBy('last_name', 'asc')
            ->get();

        $students->map(function($student) use ($class_id){
            $verify = DB::table('class_lists')
                ->where(['class_id' => $class_id, 'student_id' => $student->stud_id])
                ->count();

                $student->is_enrolled = $verify > 0 ? true : false;
        });

        return response()->json(['students' => $students]);
    }

    public function enroll_student(){

        $enrollment_info = $this->request->enrollment_info;

        $class_id = $enrollment_info['class_id'];
        $student_id = $enrollment_info['student_id'];

        $enrollStudent = DB::table('class_lists')
            ->insert([
                'class_id' => $class_id,
                'student_id' => $student_id
            ]);

        return response()->json(['status' => $enrollStudent]);
    }

    public function unenroll_student(){

        $enrollment_info = $this->request->enrollment_info;

        $class_id = $enrollment_info['class_id'];
        $student_id = $enrollment_info['student_id'];

        $unenrollStudent = DB::table('class_lists')
            ->where(['class_id' => $class_id, 'student_id' => $student_id])
            ->delete();

        return response()->json(['status' => $unenrollStudent]);
    }
}
