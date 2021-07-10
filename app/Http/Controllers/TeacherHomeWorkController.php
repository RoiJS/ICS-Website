<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class TeacherHomeWorkController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function render_homeworks($id){
        $subject = collect($this->helper->get_subject_info($id));
        return view('teacher.subjects.homeworks.homeworks', ['subject' => $subject, 'id' => $id]);
    }

    public function render_add_homework($id){
        $subject = collect($this->helper->get_subject_info($id));
        return view('teacher.subjects.homeworks.add_homework', ['subject' => $subject, 'id' => $id]);
    }

    public function render_view_homework($id, $homework_id){
        $subject = collect($this->helper->get_subject_info($id));
        $homework = DB::table('homeworks')
            ->where(['homework_id' => $homework_id])
            ->select('title','homework_id', 'due_at')
            ->first();

        return view('teacher.subjects.homeworks.view_homework', ['subject' => $subject, 'id' => $id, 'homework' => $homework]);
    }

    public function render_edit_homework($id, $homework_id){
        $subject = collect($this->helper->get_subject_info($id));
        return view('teacher.subjects.homeworks.edit_homework', ['subject' => $subject, 'id' => $id, 'homework_id' => $homework_id]);
    }

}
