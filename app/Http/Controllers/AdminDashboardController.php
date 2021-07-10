<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function render_dashboard(Request $request){
        return view('admin.dashboard.dashboard');
    }
}
