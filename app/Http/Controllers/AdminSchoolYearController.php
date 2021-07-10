<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;
use App\ICSClasses\Helper;

class AdminSchoolYearController extends Controller
{
    protected $helper = [];
    protected $request = [];

    public function __construct(Helper $helper, Request $request){
        $this->helper = $helper;
        $this->request = $request;
    }

    public function get_current_school_year(){
        return response()->json(['current_school_year' => $this->helper->get_current_school_year()]);
    }

    public function save_new_school_year(){
        $start = $this->request->start;
        $end = $this->request->end;


        $saveNewSchoolYear = DB::table('school_years')
            ->insert([
                'sy_from' => $start,
                'sy_to' => $end
            ]);

        return response()->json(['status' => $saveNewSchoolYear]);
    }

    public function set_new_school_year(){

        $id = $this->request->school_year_id;

        return DB::transaction(function () use($id) {
            $resetSchoolYear = DB::table('school_years')
                ->update(['is_current_sy' => 0]);

            $setNewSchoolYear = DB::table('school_years')
            ->where(['school_year_id' => $id])
            ->update([
                'is_current_sy' => 1
            ]); 
            
            return response()->json(['status' => $setNewSchoolYear]);
        });
    }

    public function get_school_year(){
        $school_years = DB::table('school_years')
            ->orderBy('sy_from', 'desc')
            ->get();

        return response()->json(['school_years' => $school_years]);
    }

    public function remove_school_year($id){

        $removeSchoolYear = DB::table('school_years')
            ->where(['school_year_id' => $id])
            ->delete();

        return response()->json(['status' => $removeSchoolYear]);
    }

    public function save_update_school_year(){

        $school_year = $this->request->school_year;
        $id = $school_year['school_year_id'];
        $sy_from = $school_year['sy_from'];
        $sy_to = $school_year['sy_to'];

        $saveUpdateSchoolYear = DB::table('school_years')   
            ->where(['school_year_id' => $id])
            ->update([
                'sy_from' => $sy_from,
                'sy_to' => $sy_to
            ]);

        return response()->json(['status' => $saveUpdateSchoolYear]);
    }
    
    public function validate_used_school_year() {

        $school_year_id = $this->request->get('schoolYearId');
        $status = $this->validate_used_school_year_in_class_and_curriculum($school_year_id);

        return response()->json(['status' => $status]);
    }

    private function validate_used_school_year_in_class_and_curriculum($schoolYearId) {

        $classes_sy = DB::table('classes')
                ->where(['school_year_id' => $schoolYearId])
                ->first();

        $curriculum_sy = DB::table('curriculum')
            ->where(['school_year_id' => $schoolYearId])
            ->first();

        return $classes_sy != null || $curriculum_sy != null;
    }
}
