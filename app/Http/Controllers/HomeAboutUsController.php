<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeAboutUsController extends Controller
{
    public function render_about_us(){
        return view('home.about_us.about_us');
    }
}
