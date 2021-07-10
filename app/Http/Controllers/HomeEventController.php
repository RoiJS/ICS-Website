<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use \DB;
use Carbon\Carbon;

class HomeEventController extends Controller
{
    protected $request = [];
    protected $helper = [];

    public function __construct(Request $request, Helper $helper){
        $this->request = $request;
        $this->helper = $helper;
    } 

    public function render_events(){
        return view('home.events.events');
    }

    public function get_latest_events(){
        $events = DB::table('events')
            ->where("date_from", ">", Carbon::now())
            ->limit(5)
            ->orderBy('date_from', 'asc')
            ->get();

        return response()->json(['events' => $events]);
    }

    public function get_all_events(){
        $events = DB::table('events')
            ->where("date_from", ">", Carbon::now())
            ->orderBy('date_from', 'asc')
            ->get();

        return response()->json(['events' => $events]);
    } 
}
