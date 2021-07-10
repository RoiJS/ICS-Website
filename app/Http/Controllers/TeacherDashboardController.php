<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;

class TeacherDashboardController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function render_dashboard(){
        return view('teacher.dashboard.dashboard');
    }

    public function get_faculty_subjects(){

       return DB::transaction(function () {

            $account = $this->helper->get_current_account();
            $semester = $this->helper->get_current_semester();
            $school_year = $this->helper->get_current_school_year();

            // FIXED: subject relation to loads
            $subjects = DB::table('classes')
                ->join('loads','classes.load_id','=','loads.load_id')
                ->join('curriculum_subjects','curriculum_subjects.curriculum_subject_id','=','loads.curriculum_subject_id')
                ->join('subjects','curriculum_subjects.subject_id','=','subjects.subject_id')
                ->where([
                    'classes.semester_id' => $semester->semester_id, 
                    'classes.school_year_id' => $school_year->school_year_id, 
                    'teacher_id' => $account->teacher_id
                ])
                ->select(DB::raw('subjects.*'),'class_id')
                ->get();

            
            $subjects->map(function($subject) use ($account){
                $student_num = DB::table('class_lists')
                    ->where(['class_id' => $subject->class_id, 'is_approved' => 1])
                    ->count();
                
                $posts_num = DB::table('posts')     
                    ->where(['class_id' => $subject->class_id])
                    ->count();

                $homeworks_num = DB::table('homeworks')
                    ->where(['class_id' => $subject->class_id])
                    ->count();
                
                $new_messages_count = DB::table('last_viewed_chats')
                ->where(['class_id' => $subject->class_id, 'account_id' => $account->account_id])
                ->select(DB::raw("(current_chat_id - last_chat_id) as count"))
                ->get();

                $current_viewed_chat = DB::table('last_viewed_chats')
                ->where(['class_id' => $subject->class_id, 'account_id' => $account->account_id])
                ->select('current_chat_id')
                ->first();
                
                $latest_chat = DB::table('chat')
                ->where(['class_id' => $subject->class_id])
                ->select('chat_id')
                ->orderBy("send_at", "desc")
                ->first();

                $chat_count = DB::table('chat')
                ->where(['class_id' => $subject->class_id])
                ->count();

                $subject->student_num = $student_num;
                $subject->posts_num = $posts_num;
                $subject->homeworks_num = $homeworks_num;
                $subject->new_messages_count = $current_viewed_chat != null && $latest_chat != null ?  ($latest_chat->chat_id - $current_viewed_chat->current_chat_id) : $chat_count;
            });

            return response()->json(['subjects' => $subjects]);   
        });
        
    }
}
