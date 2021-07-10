<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class HomeAnnouncementController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function get_latest_announcments(){
        $announcements = DB::table('announcements') 
            ->where(['post_status' => 1])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json(['announcements' => $announcements]);
    }

    public function render_announcements(){
        return view('home.announcements.announcements');
    }

    public function get_all_announcements(){
        $announcements = DB::table('announcements')
            ->where(['post_status' => 1])
            ->orderBy('created_at','desc')
            ->get();

        return response()->json(['announcements' => $announcements]);
    }

    public function render_read_announcement($id){
        return view('home.announcements.read_announcement', ['announcement_id' => $id]);
    }

    public function get_announcement_details(){
        $announcement_id  = $this->request->announcement_id;

        $announcement = DB::table('announcements')
            ->where(['announcement_id' => $announcement_id])
            ->first();

        return response()->json(['announcement' => $announcement]);
    }
}
