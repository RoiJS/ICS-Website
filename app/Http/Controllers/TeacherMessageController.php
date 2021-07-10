<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherMessageController extends Controller
{
    public function render_inbox(){
        return view('teacher.messages.inbox');
    }

    public function render_sent(){
        return view('teacher.messages.sent');
    }

    public function render_compose(){
        return view('teacher.messages.compose');
    }

    public function render_view_message($id){
        $id = ['id' => $id];
        return view('teacher.messages.read_message', ['message' => $id]);
    }

    public function render_reply_message($id){
        $id = ['id' => $id];
        return view('teacher.messages.reply_message', ['message' => $id]);
    }

    public function render_sent_message($id){
        return view('teacher.messages.sent_message', ['sent_item' => ['id' => $id]]);
    }
}
