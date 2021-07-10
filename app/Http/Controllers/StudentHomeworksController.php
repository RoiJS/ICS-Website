<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class StudentHomeworksController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function render_homeworks($id){
        $subject = collect($this->helper->get_subject_info($id));
        return view('student.subjects.homeworks.homeworks', ['subject' => $subject, 'id' => $id]);
    }

    public function render_view_homework($id, $homework_id){
        $subject = collect($this->helper->get_subject_info($id));
        $homework = DB::table('homeworks')
            ->where(['homework_id' => $homework_id])
            ->select('title','homework_id')
            ->first();

        return view('student.subjects.homeworks.view_homework', ['subject' => $subject, 'id' => $id, 'homework' => $homework]);
    }
}
