<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentMessageController extends Controller
{
    public function render_inbox(){
        return view('student.messages.inbox');
    }

    public function render_compose(){
        return view('student.messages.compose');
    }

    public function render_sent(){
        return view('student.messages.sent');
    }

    public function render_read_message($id){
        return view('student.messages.read_message', ['message' => ['id' => $id]]);
    }

    public function render_reply_message($id){
        return view('student.messages.reply_message',['message' => ['id' => $id]]);
    }

    public function render_sent_message($id){
        return view('student.messages.sent_message', ['sent_item' => ['id' => $id]]);
    }
}
