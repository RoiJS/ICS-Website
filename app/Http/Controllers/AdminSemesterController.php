<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;
use App\ICSClasses\Helper;

class AdminSemesterController extends Controller
{
    protected $helper = [];
    protected $request = [];

    public function __construct(Helper $helper, Request $request){
        
        $this->helper = $helper;
        $this->request = $request;
    }
    
    public function get_current_semester(){
       return response()->json(['current_semester' => $this->helper->get_current_semester()]);
    }

    public function get_semesters(){
        $semesters = DB::table('semesters')
            ->orderBy('semester', 'asc')
            ->get();
        return response()->json(['semesters' => $semesters]);
    }

    public function save_update_current_semester(){

       return  DB::transaction(function () {

            $resetSemester = DB::table('semesters')->update(['is_current_semester' => 0]);
            $semester = $this->request->get('semester');
            $id = $semester['semester_id'];

            $saveUpdateCurrentSemester = DB::table('semesters')
                ->where(['semester_id' => $id])
                ->update(['is_current_semester' => 1]);

            return response()->json(['status' => $saveUpdateCurrentSemester], 200);
        });
        
    }

    public function save_new_semester(){

        $semester = $this->request->semester;
        $sem = $semester['semester'];

        $saveNewSemester = DB::table('semesters')    
            ->insert([
                'semester' => $sem
            ]);

        return response()->json(['status' => $saveNewSemester]);
    }

    public function remove_semester($id){
        $removeSemester = DB::table('semesters')
            ->where(['semester_id' => $id])
            ->delete();

        return response()->json(['status' => $removeSemester]);
    }

    public function save_update_semester(){
        
        $semester = $this->request->semester;
        $id = $semester['semester_id'];
        $sem = $semester['semester'];

        $saveUpdateSemester = DB::table('semesters')
            ->where(['semester_id' => $id])
            ->update([
                'semester' => $sem
            ]);

        return response()->json(['status' => $saveUpdateSemester]);
    }

    public function validate_assigned_semested(){

        $semesterId = $this->request->get('semesterId');
        $status = $this->validate_semester_on_classes_semester($semesterId);

        return response()->json(['status' => $status ]);
    }

    private function validate_semester_on_classes_semester($semesterId) {

        $classes_sem = DB::table('classes')
        ->where(['semester_id' => $semesterId])
        ->first();

        return $classes_sem != null;   
    }
}