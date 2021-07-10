<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;

class AdminCourseController extends Controller
{
    protected $request = [];

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function render_courses(){
        return view('admin.courses.courses');
    }

    public function get_courses(){
        $courses = DB::table('courses')
            ->orderBy('description', 'desc')
            ->get();

        return response()->json(['courses' => $courses]);
    }

    public function save_new_course(){
        $course = $this->request->get('course');
        $description = $course['description'];

        $saveNewCourse = DB::table('courses')
            ->insert([
                'description' => $description
            ]);

        return response()->json(['status' => $saveNewCourse]);
    }

    public function save_update_course(){

        return DB::transaction(function () {
            $course = $this->request->course;

            $id = $course['course_id'];
            $description = $course['description'];

            $saveUpdateCourse = DB::table('courses')
                ->where(['course_id' => $id])
                ->update([
                    'description' => $description
                ]);

            return response()->json(['status' => $saveUpdateCourse]);
        });
    }

    public function delete_course($id) {

        return DB::transaction(function() use($id) {

            $deleteCourse = DB::table('courses')
                ->where(['course_id' => $id])
                ->delete();

            return response()->json(['status' => $deleteCourse]);
        });
    } 

    public function verify_designated_course() {
        $courseId = $this->request->courseId;
        $status = $this->   verify_if_course_is_used($courseId);
        return response()->json(['status' => $status]);
    }

    private function verify_if_course_is_used($courseId) {

        $courseOnCurriculum = DB::table('curriculum')
            ->where(['course_id' => $courseId])
            ->first();

         $courseOnLoad = DB::table('loads')
            ->where(['course_id' => $courseId])
            ->first();

        return $courseOnCurriculum != null || $courseOnLoad != null;
    }
}
