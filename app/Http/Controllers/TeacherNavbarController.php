<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;

class TeacherNavbarController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function get_faculty_subjects(){
        $subjects = $this->helper->get_faculty_subjects_for_this_sem_and_sy();
        return response()->json(['subjects' => $subjects]);
    }

    public function get_number_of_subjects(){
        $number_of_subjects = $this->helper->get_faculty_subjects_for_this_sem_and_sy()->count();
        return response()->json(['number_of_subjects' => $number_of_subjects]);   
    } 
}
