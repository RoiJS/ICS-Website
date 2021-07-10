<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;

class HelperController extends Controller
{
    protected $helper = [];
    protected $request = [];

     public function __construct(Helper $helper, Request $request){
        $this->helper = $helper;
        $this->request = $request;
    }

    public function post_unpost_module(){

        $postUnpost = $this->helper->post_unpost_module(
            $this->request->get('table'),
            $this->request->get('id'),
            $this->request->get('column'),
            $this->request->get('status'),
            $this->request->get('track_update_column')
        );

        return response()->json(['data' => $postUnpost], 200);
    }

    public function static_status(){
        $category = $this->request->get('category');
        $count = DB::table($category)->count();
        return response()->json(array('category' => $category, 'count' => $count));
    }

    public function get_current_account_profile_pic(){
        $account = $this->helper->get_current_account();
        return response()->json(['account' => ["image" => $account->image, "type" => $account->type]]);
    }

    public function get_current_semester(){
        return response()->json(['current_semester' => $this->helper->get_current_semester()]);
    }

    public function get_current_school_year(){
        return response()->json(['current_school_year' => $this->helper->get_current_school_year()]);
    }

    public function get_current_account(){
        return response()->json(['account' => $this->helper->get_current_account()]);
    }

    public function get_current_user_info(){
        return response()->json(['user_info' => $this->helper->get_user_info($this->request->account_id)]);
    }

    public function get_ics_details(){
        $ics_details = DB::table('ics_details')
            ->first();
        return response()->json(['ics_details' => $ics_details]);
    }
    
    public function get_official_logo(){
        $logo = DB::table('ics_details')->select('ics_logo')->first();
        return response()->json(['logo' => $logo], 200);
    }

    public function register_last_viewed_chat() {
        
        $current_account = $this->helper->get_current_account();
        $class_id = $this->request->class_id;

        $register = collect(DB::select(DB::raw("CALL RegisterLastViewedChat($class_id, $current_account->account_id)")));

        return $register;
    }
    
    public function update_last_viewed_chat() {
        
        $current_account = $this->helper->get_current_account();
        $class_id = $this->request->class_id;

        $register = collect(DB::select(DB::raw("CALL UpdateLastViewChat($class_id, $current_account->account_id)")));

        return $register;
    }

    public function get_new_messages() {
        
        $chat_id = $this->request->chat_id;
        $class_id = $this->request->class_id;
        $account = $this->helper->get_current_account();

        $newMessages = collect(DB::select(DB::raw("CALL GetLastestMessages($class_id, $chat_id)")));

        $messagesFromCurrentUser = $newMessages->map(function($n) use($account) {
            return $n->account_id == $account->account_id;
        });

        $newMessages->map(function($message){
            
            $account = $this->helper->get_current_account();
            $sender = $this->helper->get_user_info($message->account_id); 

            $message->sender = [
                "last_name" => $sender->last_name, 
                "first_name" => $sender->first_name, 
                "middle_name" => $sender->middle_name,
                "image" => $sender->image,
                "type" => $sender->type
            ];

            $message->is_sender = ($account->account_id == $message->account_id);
            
        });
        
        return response()->json(['messagesFromCurrentUser' => $messagesFromCurrentUser, 'newMessages' => $newMessages], 200);
    }

    public function monitor_new_message(){
        
        $class_id = $this->request->class_id;
        $message_count = $this->request->message_count;

        $current_message_count =  DB::table('chat')
            ->join('accounts', 'chat.account_id','=', 'accounts.account_id')
            ->where(['class_id' => $class_id])
            ->count(); 

        $result = ($message_count < $current_message_count);

        return response()->json(['result' => $result]);
    }
    
    public function get_new_messages_count(){
        
        $class_id = $this->request->class_id;
        $account = $this->helper->get_current_account();

        $new_messages_count =  DB::table('last_viewed_chats')
            ->where(['class_id' => $class_id, 'account_id' => $account->account_id])
            ->select(DB::raw("(current_chat_id - last_chat_id) as new_messages_count")); 

        return response()->json(['new_messages_count' => $new_messages_count]);
    }

    public function register_activity() {

        $activity_description = $this->request->activityDescription;
        $account = $this->helper->get_current_account();

        $register_activity = DB::table('activity_logs')
            ->insert([
                'account_id' => $account->account_id,
                'activity_description' => $activity_description
            ]);

        return response()->json(['status' => $register_activity]);
    }

    public function get_activities() {

        $account = $this->helper->get_current_account();
        $activity_from = $this->request->activity_from;        
        $activity_to = $this->request->activity_to;
        
        $activities = collect(DB::select(DB::raw("CALL GetActivityLogs($account->account_id, $activity_from, $activity_to)")));
        $absoluteCount = DB::select(DB::raw("CALL GetActivityLogsAbsoluteCount($account->account_id)"));

        return response()->json(['activities' => $activities, "absoluteCount" => $absoluteCount[0]->absoluteCount]);
    }

    public function clear_activities() {
        $account = $this->helper->get_current_account();

        $removeActivties = DB::table('activity_logs')
            ->where(['account_id' => $account->account_id])
            ->delete();

        return response()->json(['status' => ($removeActivties > 1)]);
    }

    public function register_notification() {
        
        $account = $this->helper->get_current_account();
        $notify_to = $this->request->notify_to;
        $notify_to_user_type = $this->request->notify_to_user_type;
        $path = $this->request->path;
        $description = $this->request->description;
        $notify_to_account_info = $this->helper->get_account_info($notify_to, $notify_to_user_type);

        $register_notification = DB::table('notifications')
            ->insertGetId([
               'notification_from' => $account->account_id, 
               'notification_from_user_type' => $account->type, 
               'notification_to' => $notify_to_account_info->account_id, 
               'notification_to_user_type' => $notify_to_user_type, 
               'path' => $path, 
               'description' => $description, 
            ]);

        return response()->json(['status' => ($register_notification > 0)]);
    }
    
    public function register_send_unsend_homework_notification() {

        $account = $this->helper->get_current_account();
        $class_id = $this->request->class_id;
        $path = $this->request->path;
        $description = $this->request->description;

        $classStudents = DB::table('class_lists')
            ->where(['class_id' => $class_id, 'is_approved' => 1])
            ->get();
          
        $classStudents->map(function($student) use($account, $path, $description) {

            $notify_to_account_info = $this->helper->get_account_info($student->student_id, 'student');

            $register_notification = DB::table('notifications')
                ->insertGetId([
                    'notification_from' => $account->account_id,
                    'notification_from_user_type' => $account->type,  
                    'notification_to' => $notify_to_account_info->account_id, 
                    'notification_to_user_type' => 'student', 
                    'path' => $path, 
                    'description' => $description
                ]);
        });

        return response()->json(['status' => true]);
    }
    
    public function register_approved_disapproved_homework_notification() {

        $account = $this->helper->get_current_account();
        $homework_id = $this->request->homework_id;
        $path = $this->request->path;
        $description = $this->request->description;

        $homeworkStudents = DB::table('submitted_homeworks')
            ->where(['homework_id' => $homework_id])
            ->get();
          
        $homeworkStudents->map(function($student) use($account, $path, $description) {

            $notify_to_account_info = $this->helper->get_account_info($student->student_id, 'student');

            $register_notification = DB::table('notifications')
                ->insertGetId([
                    'notification_from' => $account->account_id,
                    'notification_from_user_type' => $account->type,  
                    'notification_to' => $notify_to_account_info->account_id, 
                    'notification_to_user_type' => 'student', 
                    'path' => $path, 
                    'description' => $description
                ]);
        });

        return response()->json(['status' => true]);
    }
    
    public function read_notifications() {

        $account = $this->helper->get_current_account();
        $notification_id = $this->request->notification_id;

        if ($notification_id != null) {
            $condition = ['notification_id' => $notification_id];
        } else {
             $condition = ['notification_to' => $account->account_id];
        } 
        
        $read_notification = DB::table('notifications')
            ->where($condition)
            ->update(['is_read' => 1]);

        return response()->json(['status' => true]);
    }
   
    public function clear_notifications() {

        $account = $this->helper->get_current_account();
        
        $clear_notification = DB::table('notifications')
            ->where(['notification_to' => $account->account_id])
            ->delete();

        return response()->json(['status' => ($clear_notification > 0)]);
    }
    
    public function get_notifications() {

        $account = $this->helper->get_current_account();
        $notification_from = $this->request->notification_from;        
        $notification_to = $this->request->notification_to;
        
        $notifications = collect(DB::select(DB::raw("CALL GetNotifications($account->account_id, $notification_from, $notification_to)")));
        $absoluteCount = DB::select(DB::raw("CALL GetNotificationsAbsoluteCount($account->account_id)"));
        $unreadNotificationsCount = DB::select(DB::raw("CALL GetUnreadNotifications($account->account_id)"));

        return response()->json([
                'notifications' => $notifications, 
                "absoluteCount" => $absoluteCount[0]->absoluteCount,
                "unreadNotificationsCount" => $unreadNotificationsCount[0]->unreadNotificationsCount
            ]);
    }

    public function monitor_new_notifications() {

        $account = $this->helper->get_current_account();
        $absoluteCount = $this->request->absoluteCount;

        $new_notifications = DB::table('notifications')
            ->where([
                'notification_to' => $account->account_id
            ])
            ->count();

        return response()->json(['status' => ($new_notifications > $absoluteCount)]);
    }
}
