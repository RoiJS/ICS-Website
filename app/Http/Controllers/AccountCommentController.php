<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class AccountCommentController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function send_new_comment(){

        $account = $this->helper->get_current_account();

        $comment = $this->request->comment;

        $post_id= $comment['post_id'];
        $comment_desc = $comment['comment'];

        $saveNewComment = DB::table('comments')
            ->insertGetId([
                'post_id' => $post_id,
                'account_id' => $account->account_id,
                'comment' => $comment_desc,
                'commented_at' => Carbon::now()
            ]);

        $newComment = DB::table("comments")
            ->where(['comment_id' => $saveNewComment])
            ->first();

        $user = $this->helper->get_user_info($newComment->account_id);
        $commenter = [
            "last_name" => $user->last_name, 
            "first_name" => $user->first_name, 
            "middle_name" => $user->middle_name,
            "image" => $user->image,
            "type" => $user->type
        ];

        $newComment->commenter = $commenter;
        $newComment->is_edit = false;
        $newComment->is_comment = $user->account_id == $account->account_id; 

        return response()->json(['comment' => $newComment]);
    }

    public function save_edit_comment(){
        $comment = $this->request->comment;
        $comment_id = $comment['comment_id'];
        $comment_desc = $comment['comment'];

        $savepUpdateComment = DB::table('comments')
            ->where([
                'comment_id' => $comment_id
            ])
            ->update([
                'comment' => $comment_desc,
                'updated_at' => Carbon::now()
            ]);
            
        return response()->json(['status' => $savepUpdateComment]);
    }

    public function remove_comment($comment_id){
        $removeComment = DB::table('comments')
            ->where(['comment_id' => $comment_id])
            ->delete();

        return response()->json(['status' => $removeComment]);
    }
}
