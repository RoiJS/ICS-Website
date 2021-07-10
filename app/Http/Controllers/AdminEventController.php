<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;
use Carbon\Carbon;


class AdminEventController extends Controller
{
    protected $request = [];
    protected $helper = [];
    protected $directory = [];

    public function __construct(Request $request, Helper $helper, Directory $directory){
        $this->request = $request;
        $this->helper = $helper;
        $this->directory = $directory;
    }

    public function render_events(){
        return view('admin.events.events');
    }

    public function render_edit_event($id){
        return view('admin.events.edit_event', ['event' => ['id' => $id]]);
    }

    public function get_events(){
        $events = DB::table('events')->orderBy('date_from','desc')->get();
        return response()->json(['events' => $events]);
    }

    public function save_new_event(){
        $event = $this->request->get('event');

        $description = $event['description'];
        $dates = explode(" - ", $event['dates']);
        $date_from = Carbon::parse($dates[0])->format('Y-m-d');
        $date_to = Carbon::parse($dates[1])->format('Y-m-d');
        $color = $event['color'];

        $saveNewEvent = DB::table('events')
            ->insert([
                'description' => $description,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'color' => $color,
                'created_at' => Carbon::now()
            ]);

        return response()->json(['status' => $saveNewEvent]);
    }

    public function remove_event($id){
        $removeEvent = DB::table('events')  
            ->where(['event_id' => $id])
            ->delete();

        return response()->json(['status' => $removeEvent]);
    }

    public function get_event($id){
        $event = DB::table('events')
            ->where(['event_id' => $id])
            ->first();

        return response()->json(['event' => $event]);
    }

    public function save_update_event(){
        $event = $this->request->get('event');

        $event_id = $event['event_id'];
        $description = $event['description'];
        $dates = explode(" - ", $event['dates']);
        $date_from = Carbon::parse($dates[0])->format('Y-m-d');
        $date_to = Carbon::parse($dates[1])->format('Y-m-d');
        $color = $event['color'];

        $saveUpdateEvent = DB::table('events')
            ->where(['event_id' => $event_id])
            ->update([
                'description' => $description,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'color' => $color,
                'updated_at' => Carbon::now()
            ]);

        return response()->json(['status' => $saveUpdateEvent]);
    }
}
