<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function render_settings(){
        return view('admin.settings.settings');
    }

    public function render_semester(){
        return view('admin.settings.set_semester');
    }

    public function render_school_year(){
        return view('admin.settings.set_school_year');
    }
    
    public function render_curriculum(){
        return view('admin.settings.set_curriculum');
    }
}
