<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class AccountChatController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function get_conversation(){
        
        return DB::transaction(function () {

            $class_id = $this->request->class_id;
            $chat_from = $this->request->chat_from;
            $chat_to = $this->request->chat_to;

            $conversations = collect(DB::select(DB::raw("CALL GetChats($class_id, $chat_from, $chat_to)")));
            $absoluteCount = DB::select(DB::raw("CALL GetChatAbsoluteCount($class_id)"));

            $conversations->map(function($conversation){

                $account = $this->helper->get_current_account();
                $sender = $this->helper->get_user_info($conversation->account_id); 

                $conversation->sender = [
                    "last_name" => $sender->last_name, 
                    "first_name" => $sender->first_name, 
                    "middle_name" => $sender->middle_name,
                    "image" => $sender->image,
                    "type" => $sender->type
                ];

                $conversation->is_sender = ($account->account_id == $conversation->account_id);
                
            });

            return response()->json(['conversations' => $conversations, 'absoluteCount' => $absoluteCount[0]->absoluteCount]);
        });
    }

    public function send_chat(){

        $account = $this->helper->get_current_account();
        $class_id = $this->request->class_id;
        $message = $this->request->message;
        
        $saveChat = DB::table('chat')   
            ->insert([
                'class_id' => $class_id,
                'account_id' => $account->account_id,
                'message' => $message,
                'send_at' => Carbon::now()
            ]);

        return response()->json(['status' => $saveChat]);
    }

    public function monitor_new_message(){
        
        $class_id = $this->request->class_id;
        $message_count = $this->request->message_count;

        $current_message_count =  DB::table('chat')
            ->join('accounts', 'chat.account_id','=', 'accounts.account_id')
            ->where(['class_id' => $class_id])
            ->count(); 

        $result = $message_count < $current_message_count ? true : false;

        return response()->json(['result' => $result]);
    }

    public function monitor_other_subject_new_message(){

        return DB::transaction(function () {

            $new_groupchats = collect($this->request->groupchats);
            
            $groupchats = $new_groupchats->map(function($groupchat){
                $chat_num = DB::table('chat')
                    ->where(['class_id' => $groupchat['class_id']])
                    ->count();

                $groupchat['new_chat_num'] = $chat_num - $groupchat['chat_num'];
                
                return $groupchat;
            });
           
            return response()->json(['new_messages' => $groupchats]);
        });
        
    }

    public function get_total_number_messages(){

        $subjects =  $this->helper->get_faculty_subjects_for_this_sem_and_sy();

        $subjects->map(function($subject){

            $chat_num = DB::table('chat')
                ->where(['class_id' => $subject->class_id])
                ->count();

            $subject->chat_num = $chat_num;
        });
        
        $total_chat_num = $subjects->pluck('chat_num')->sum();

        return response()->json(['total_chat_num' => $total_chat_num]);
    }

    public function clear_all_conversations($id){
        
        $clearAllConversations = DB::table('chat')  
            ->where(['class_id' => $id])
            ->delete();

        return response()->json(['status' => $clearAllConversations]);
    }

}

