<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class AdminMessageController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->helper = $helper;
        $this->request = $request;
    }

    public function render_inbox(){
        return view('admin.messages.inbox');
    }

    public function render_sent(){
        return view('admin.messages.sent');
    }

    public function render_compose(){
        return view('admin.messages.compose');
    }

    public function render_read_message($id){
        return view('admin.messages.read_message', ['message' => ['id' => $id]]);
    }

    public function render_reply_message($id){
        return view('admin.messages.reply_message',['message' => ['id' => $id]]);
    }

    public function render_sent_message($id){
        return view('admin.messages.sent_message', ['sent_item' => ['id' => $id]]);
    }

    public function send_message(){

        $message = $this->request->message;
        $contact = $message['contact'];
        $text = $message['message'];

        $account = $this->helper->get_current_account();
        $sendMessage = DB::table('messages')
            ->insert([
                'sender_id' => $account->account_id,
                'send_to_id' => $contact,
                'message' => $text,
                'sent_at' => Carbon::now()
            ]);

        return response()->json(['status' => $sendMessage]);
    }

    public function get_inbox_messages(){

        $account = $this->helper->get_current_account();
        $inboxMessages = DB::table('messages')
            ->join('accounts','messages.send_to_id','=','accounts.account_id')
            ->where(['send_to_id' => $account->account_id])
            ->get();

        $inboxMessages->map(function($message){

            $sender = $this->helper->get_user_info($message->sender_id);
            $fullname = $sender->last_name.", ".$sender->first_name;
            $message->sender = $fullname;
        });

        return response()->json(['messages' => $inboxMessages]);
    }

    public function get_sent_items(){

        $account = $this->helper->get_current_account();
        $sentItems = DB::table('messages')
            ->join('accounts','messages.sender_id','=','accounts.account_id')
            ->where(['sender_id' => $account->account_id])
            ->get();

        $sentItems->map(function($message){
            
            $receiver = $this->helper->get_user_info($message->send_to_id);
            $fullname = $receiver->last_name.", ".$receiver->first_name;
            $message->receiver = $fullname;
        });
            
        return response()->json(['sent_items' => $sentItems]);
    }

    public function get_current_message($id){

        $current_message = DB::table('messages')
            ->join('accounts', 'messages.sender_id','=','accounts.account_id')
            ->where(['message_id' => $id])
            ->first();

        $sender_info = $this->helper->get_user_info($current_message->account_id);
        $sender_name =  $sender_info->last_name.', '.$sender_info->first_name;

        $current_message->email_address = $sender_info->email_address;
        $current_message->sender_name = $sender_name;

        $sender = $this->helper->get_user_info($current_message->sender_id);

        return response()->json(['current_message' => $current_message, 'sender' => $sender]);
    }

    public function send_reply_message(){
        $message_details = $this->request->message_details;
        $current_account = $this->helper->get_current_account();

        $saveMessage = DB::table('messages')
            ->insert([
                'sender_id' => $current_account->account_id,
                'send_to_id' => $message_details['send_to_id'],
                'message' => $message_details['text'],
                'sent_at' => Carbon::now()
            ]);
        return response()->json(['message' => $this->request->message_details]);
    }

    public function remove_sent_item($id){

        $removeSentItem = DB::table('messages')
            ->where(['message_id' => $id])
            ->delete();

        return response()->json(['status' => true]);
    }

    public function remove_message($id) {

        $removeMessage = DB::table('messages')
            ->where(['message_id' => $id])
            ->delete();

        return response()->json(['status' => true]);
    }

    public function get_current_sent_item($id){

        $current_sent_item = DB::table('messages')
            ->where(['message_id' => $id])
            ->first();

        return response()->json(['sent_item' => $current_sent_item]);
    }

    public function forward_message() {

        $account = $this->helper->get_current_account();
        $detail = $this->request->message;

        $saveMessage = DB::table('messages')
            ->insert([
                'sender_id' => $account->account_id,
                'send_to_id' => $detail['contact'],
                'message' => $detail['text'],
                'sent_at' => Carbon::now() 
            ]);

        return response()->json(['status' => true]);
    }
}
