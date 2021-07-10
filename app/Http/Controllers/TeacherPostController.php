<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class TeacherPostController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function index($id){
        $subject = collect($this->helper->get_subject_info($id));

        if (count($subject) > 0){
            return view('teacher.subjects.posts.posts', ['subject' => $subject, 'id' => $id]);
        } else {
            return redirect('/teacher');
        }
    }

    public function render_add_post($id){
        $subject = collect($this->helper->get_subject_info($id));
        return view('teacher.subjects.posts.add_post', ['subject' => $subject, 'id' => $id]);
    }

    public function render_edit_post($id, $post_id){
        $subject = collect($this->helper->get_subject_info($id));
        return view('teacher.subjects.posts.edit_post', ['subject' => $subject, 'id' => $id, 'post_id' => $post_id]);
    }
}
