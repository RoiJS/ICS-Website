<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;

class HomeController extends Controller
{
    public function index(){
        $announcements = DB::table('announcements') 
            ->where(['post_status' => 1])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        return view('home.home.home',['announcements' => $announcements]);
    }
}
