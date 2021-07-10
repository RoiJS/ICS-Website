<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class StudentClassController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function index($id){
        $subject = collect($this->helper->get_subject_info($id));
        return view('student.subjects.class_list.classes', ['subject' => $subject, 'id' => $id]);
    }
}
