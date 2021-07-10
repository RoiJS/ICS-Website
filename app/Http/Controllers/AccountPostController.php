<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class AccountPostController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function save_new_post(){
        
        return DB::transaction(function () {
            $account = $this->helper->get_current_account();

            $post = $this->request->post_details;

            $description = $post['description'];
            $class_id = $post['class_id'];

            $saveNewPost = DB::table('posts')
                ->insert([
                    'class_id' => $class_id,
                    'account_id' => $account->account_id,
                    'description' => $description,
                    'post_at' => Carbon::now()
                ]);

            return response()->json(['status' => $saveNewPost]);
        });
    }

    public function get_posts(){
        
        $classId = $this->request->class_id;
        $postFrom = $this->request->post_from;
        $postTo = $this->request->post_to;
        
        $account = $this->helper->get_current_account();

        $posts = collect(DB::select(DB::raw("CALL GetPosts($classId, $postFrom, $postTo)")));
        $absoluteCount = DB::select(DB::raw("CALL GetPostsAbsoluteCount($classId)"));

        $posts->map(function($post) use ($account){
            $user = $this->helper->get_user_info($post->account_id);

            $comments = DB::table('comments')
                ->where(['post_id' => $post->post_id])
                ->get();

            $comments->map(function($comment) use ($account){
                $user = $this->helper->get_user_info($comment->account_id);
                $commenter = [
                    "last_name" => $user->last_name, 
                    "first_name" => $user->first_name, 
                    "middle_name" => $user->middle_name,
                    "image" => $user->image,
                    "type" => $user->type
                ];

                $comment->commenter = $commenter;
                $comment->is_edit = false;
                $comment->is_comment = $user->account_id == $account->account_id ? true : false;
            });     

            $post->poster = [
                    "last_name" => $user->last_name, 
                    "first_name" => $user->first_name, 
                    "middle_name" => $user->middle_name,
                    "image" => $user->image,
                    "type" => $user->type
                ];

            $post->comments = $comments;
            $post->is_poster = $account->account_id == $post->account_id ? true : false;
        });

        return response()->json(['posts' => $posts, "absoluteCount" => $absoluteCount[0]->absoluteCount]);
    }

    public function remove_post($id){

        $removeComments = DB::table('comments')
            ->where(['post_id' => $id])
            ->delete();

        $removePost = DB::table('posts')
            ->where(['post_id' => $id])
            ->delete();

        return response()->json(['status' => $removePost]);
    }

    public function get_comments(){

        $account = $this->helper->get_current_account();
        $post_id = $this->request->post_id;

        $comments = DB::table('comments')
            ->where(['post_id' => $post_id])
            ->get();

        $comments->map(function($comment){
            $user = $this->helper->get_user_info($comment->account_id);
            $comment->is_sender = $user->account_id == $account->account_id ? true : false;
        });

        return response()->json(['comments' => $comments]);  
        
    }

    public function get_post_details(){

        $post_id = $this->request->post_id;
        $post = DB::table('posts')
            ->where(['post_id' => $post_id])
            ->first();

        return response()->json(['post' => $post]);
    }

    public function save_update_post(){
        $post = $this->request->post;
        $post_id = $post['post_id'];
        $description = $post['description'];

        $saveUpdatePost = DB::table('posts')
            ->where(['post_id' => $post_id])
            ->update([
                'description' => $description,
                'updated_at' => Carbon::now()
            ]);

        return response()->json(['status' => $saveUpdatePost]);
    }
}
