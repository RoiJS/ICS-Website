<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;
use Carbon\Carbon;
use \DB;

class AdminFacultyController extends Controller
{
    protected $request = [];
    protected $helper = [];
    protected $directory = [];

    public function __construct(Request $request, Helper $helper, Directory $directory){
        $this->request = $request;
        $this->helper = $helper;
        $this->directory = $directory;
    }

    public function render_faculty(){
        return view('admin.faculty.faculty');
    }

    public function render_add_faculty(){
        return view('admin.faculty.add_faculty');
    }

    public function render_view_faculty($id){
        return view('admin.faculty.view_faculty', ['faculty' => ['id' => $id]]);
    }

    public function render_edit_faculty($id){
        return view('admin.faculty.edit_faculty', ['faculty' => ['id' => $id]]);
    }

    public function get_faculty(){

        $faculties = DB::table('teachers')  
            ->join('accounts', function($join){
                $join->on('teachers.teacher_id','=','accounts.user_id')
                ->where(['accounts.type' => 'teacher']);
            })
            ->orderBy('last_name', 'asc')
            ->get();

        return response()->json(['faculties' => $faculties]);
    }

    public function save_new_faculty(){

       return DB::transaction(function () {

            $faculty_id = $this->request->faculty_id;
            $lastname = $this->request->lastname;
            $firstname = $this->request->firstname;
            $middlename = $this->request->middlename;
            $gender = $this->request->gender;
            $birthdate = $this->request->birthdate;
            $academic_rank = $this->request->academic_rank;
            $designation = $this->request->designation;
            
            $email_address = $this->request->email_address;
            $username = $this->request->username;
            $password = $this->request->password;

            if($this->request->hasFile('image')){
                $file = $this->request->file('image');
                $image = $this->helper->generateFileName($this->request->file('image'), 'teachers');
                $file->move($this->directory->getPath('faculty'), $image);
            }else{
                $image = '';
            }

            $saveNewTeacher = DB::table('teachers')
                ->insertGetId([
                    'faculty_id' => $faculty_id,
                    'last_name' => $lastname,
                    'first_name' => $firstname,
                    'middle_name' => $middlename,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'academic_rank' => $academic_rank,
                    'designation' => $designation,
                    'image' => $image,
                    'created_at' => Carbon::now(),
                    'is_active' => 1
                ]);

            $saveNewTeacherAccount = DB::table('accounts')  
                ->insert([
                    'user_id' => $saveNewTeacher,
                    'type' => 'teacher',
                    'username' => $username,
                    'password' => $password,
                    'email_address' => $email_address,
                    'hash_password' => sha1($password),
                    'created_at' => Carbon::now()
                ]);

            return response()->json(['status' => [$saveNewTeacher, $saveNewTeacherAccount]]);  
        });
       
    }

    public function get_current_faculty(){
        $id = $this->request->id;
        $faculty = DB::table('teachers')
            ->join('accounts', function($join) use($id) {
                $join->on('teachers.teacher_id','=','accounts.user_id')
                     ->where(['teachers.teacher_id' => $id, 'type' => 'teacher']);
            })
            ->first();
        $faculty->fullname = $faculty->last_name.", ".$faculty->first_name." ".substr($faculty->middle_name, 0, 1).".";

        $teacher_id = $faculty->teacher_id;
        $semester = $this->helper->get_current_semester();
        $school_year = $this->helper->get_current_school_year();

        $faculty_subjects = DB::table('classes')
            ->join('loads','loads.load_id', '=', 'classes.load_id')
            ->join('curriculum_subjects','curriculum_subjects.curriculum_subject_id', '=', 'loads.curriculum_subject_id')
            ->join('subjects','subjects.subject_id', '=', 'curriculum_subjects.subject_id')
            ->join('curriculum_year_sem','curriculum_year_sem.curriculum_year_sem_id', '=', 'curriculum_subjects.curriculum_year_sem_id')
            // ->join('subjects','loads.subject_id','=','subjects.subject_id')
            ->where([
                'classes.semester_id' => $semester->semester_id, 
                'classes.school_year_id' => $school_year->school_year_id, 
                'teacher_id' => $teacher_id
                ])
            ->get();

        $faculty_subjects->map(function($subject){
            $subject->year_level_name = $this->helper->str_ordinal($subject->year_level);
        });

        $faculty->subjects = $faculty_subjects;

        return response()->json(['faculty' => $faculty]);
    }

    public function save_update_faculty(){

       return DB::transaction(function () {

            $teacher_id = $this->request->teacher_id;
            $faculty_id = $this->request->faculty_id;
            $lastname = $this->request->last_name;
            $firstname = $this->request->first_name;
            $middlename = $this->request->middle_name;
            $gender = $this->request->gender;
            $birthdate = $this->request->birthdate;
            $academic_rank = $this->request->academic_rank;
            $designation = $this->request->designation;
            
            $email_address = $this->request->email_address;
            $username = $this->request->username;
            $password = $this->request->password; 

            $updateFacultyImage = 0;
            
            if($this->request->hasFile('image')){
                $file = $this->request->file('image');
                $image = $this->helper->generateFileName($this->request->file('image'), 'teachers');
                $file->move($this->directory->getPath('faculty'), $image);

                $updateFacultyImage = DB::table('teachers')
                    ->where(['teacher_id' => $teacher_id])
                    ->update([
                        'image' => $image
                    ]);
            }

            $saveUpdateTeacher = DB::table('teachers')
                ->where(['teacher_id' => $teacher_id])
                ->update([
                    'faculty_id' => $faculty_id,
                    'last_name' => $lastname,
                    'first_name' => $firstname,
                    'middle_name' => $middlename,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'academic_rank' => $academic_rank,
                    'designation' => $designation,
                    'updated_at' => Carbon::now()
                ]);

            $saveUpdateFacultyAccount = DB::table('accounts')
                ->where([
                    'user_id' => $teacher_id,
                    'type' => 'teacher'
                ])
                ->update([
                    'username' => $username,
                    'password' => $password,
                    'email_address' => $email_address,
                    'hash_password' => sha1($password),
                    'updated_at' => Carbon::now()
                ]);

                return response()->json(['status' => [$updateFacultyImage, $saveUpdateTeacher, $saveUpdateFacultyAccount]]);
        });
    }

    public function activate_faculty() {
        $teacher_id = $this->request->id;
        $activate_faculty = DB::table('teachers')
            ->where(['teacher_id' => $teacher_id])
            ->update(['is_active' => 1]);

        $status = ($activate_faculty > 0);
        return response()->json(['status' => $status]);        
    }

    public function deactivate_faculty() {
        $teacher_id = $this->request->id;
        $activate_faculty = DB::table('teachers')
            ->where(['teacher_id' => $teacher_id])
            ->update(['is_active' => 0]);

        $status = ($activate_faculty > 0);
        return response()->json(['status' => $status]);        
    }

    public function verify_teacher_id_exists() {
        $faculty_id = $this->request->teacherId;
        $verify_existence = DB::table('teachers')
            ->where(['faculty_id' => $faculty_id])
            ->first();

        $result = ($verify_existence != null);
        return response()->json(['result' => $result]);
    }
}
