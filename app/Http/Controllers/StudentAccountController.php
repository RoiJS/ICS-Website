<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentAccountController extends Controller
{
    public function index(){
        return view('student.accounts.account');
    }
}
