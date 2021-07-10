<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;

class AdminSubjectController extends Controller
{
    protected $request = [];

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function render_subjects(){
        return view('admin.subjects.subjects');
    }

    public function render_edit_subject($id){
        return view('admin.subjects.edit_subject', ['subject' => ['id' => $id]]);
    }

    public function get_subjects(){
        $subjects = DB::table('subjects')
            ->orderBy('subject_description','desc')
            ->get();

        return response()->json(['subjects' => $subjects]);
    }

    public function remove_subject($id){
        $removeSubject = DB::table('subjects')
            ->where(['subject_id' => $id])
            ->delete();
        return response()->json(['status' => $removeSubject]);
    }

    public function get_current_subject($id){
        $subject = DB::table('subjects')
            ->where(['subject_id' => $id])
            ->first();

        return response()->json(['subject' => $subject]);
    }
    
    public function save_new_subject(){

        return DB::transaction(function () {

            $subject = $this->request->get('subject');
            $code = $subject['subject_code'];
            $description = $subject['subject_description'];
            $lec_unit = $subject['lec_unit'] ? $subject['lec_unit'] : 0;
            $lab_unit = $subject['lab_unit'] ? $subject['lab_unit'] : 0;

            $saveNewSubject = DB::table('subjects')
                ->insert([
                    'subject_code' => $code,
                    'subject_description' => $description,
                    'lec_units' => $lec_unit,
                    'lab_units' => $lab_unit
                ]);

            return response()->json(['status' => $saveNewSubject]);   
        });
    }

    public function save_update_subject(){
        
        return DB::transaction(function () {

            $subject = $this->request->get('subject');

            $id = $subject['subject_id'];
            $code = $subject['subject_code'];
            $description = $subject['subject_description'];
            $lec_unit = $subject['lec_units'];
            $lab_unit = $subject['lab_units'];

            $saveUpdateSubject = DB::table('subjects')
                ->where(['subject_id' => $id])
                ->update([
                    'subject_code' => $code,
                    'subject_description' => $description,
                    'lec_units' => $lec_unit,
                    'lab_units' => $lab_unit
                ]);

            return response()->json(['status' => $saveUpdateSubject]);
        });

    }

    public function verify_subject_loaded() {

        $subjectId = $this->request->get('subjectId');
        
        $enrolledSubjects = DB::table('loads')
                    ->where(['subject_id' => $subjectId])
                    ->first();
        
        $status = $enrolledSubjects != null;

        return response()->json(['status' => $status]);
    }
}
