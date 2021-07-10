<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherAccountController extends Controller
{
    public function index(){
        return view('teacher.accounts.account');
    }
    
}
