<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;

class StudentDashboardController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function render_dashboard(){
        return view('student.dashboard.dashboard');
    }

    public function get_student_subjects(){

       return DB::transaction(function () {

            $subjects = $this->helper->get_student_subjects_for_this_sem_and_sy();
            $account = $this->helper->get_current_account();

            $subjects->map(function($subject) use($account){
                $student_num = DB::table('class_lists')
                    ->where(['class_id' => $subject->class_id])
                    ->count();
                
                $posts_num = DB::table('posts')     
                    ->where(['class_id' => $subject->class_id])
                    ->count();

                $homeworks_num = DB::table('homeworks')
                    ->where(['class_id' => $subject->class_id])
                    ->count();

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
                ->select('chat_id');

                $subject->student_num = $student_num;
                $subject->posts_num = $posts_num;
                $subject->homeworks_num = $homeworks_num;
                $subject->new_messages_count = $current_viewed_chat != null ?  ($latest_chat->chat_id - $current_viewed_chat->current_chat_id) : count($chat_count);
            });

            return response()->json(['subjects' => $subjects]);   
        });
        
    }
}
