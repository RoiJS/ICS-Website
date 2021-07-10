<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;
use \DB;

class AdminStudentController extends Controller
{
    protected $request = [];
    protected $helper = [];
    protected $directory = [];

    public function __construct(Request $request, Helper $helper, Directory $directory){
        $this->request = $request;
        $this->helper = $helper;
        $this->directory = $directory;
    }

    public function render_students(){
        return view('admin.students.students');    
    }

    public function render_add_student(){
        return view('admin.students.add_student');
    }

    public function render_view_student($id){
        return view('admin.students.view_student', ['student_id' => ['id' => $id]]);
    }

    public function render_edit_student($id){
        return view('admin.students.edit_student', ['student_id' => ['id' => $id]]);
    }

    public function save_new_student(){

        return DB::transaction(function () {

            $student_id = $this->request->student_id;
            $lastname = $this->request->last_name;
            $firstname = $this->request->first_name;
            $middlename = $this->request->middle_name;
            $gender =  $this->request->gender;
            $birthdate = $this->request->birthdate;
            $enrolled_curriculum_year = $this->request->enrolled_curriculum_year;

            $username = $this->request->username;
            $emailaddress = $this->request->email_address;
            $password = $this->request->password;

            if($this->request->hasFile('image')){

                $file = $this->request->file('image');
                $filename = $file->getClientOriginalName();
                $gen_filename = $this->helper->generateFileName($file, 'students');
                $size = $file->getSize();

                $file->move($this->directory->getPath('students'), $gen_filename);
            }else{
                $filename = '';
                $gen_filename = '';
                $size = 0;
            }

            $saveNewStudent = DB::table('students') 
                ->insertGetId([
                    'student_id' => $student_id,
                    'last_name' => $lastname,
                    'first_name' => $firstname,
                    'middle_name' => $middlename,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'image' => $gen_filename,
                    'created_at' => Carbon::now(),
                    'is_active' => 1,
                    'curriculum_year' => $enrolled_curriculum_year
                ]);

            $saveNewAccount = DB::table('accounts')
                ->insert([
                    'user_id' => $saveNewStudent,
                    'type' => 'student',
                    'username' => $username,
                    'password' => $password,
                    'email_address' => $emailaddress,
                    'hash_password' => sha1($password),
                    'created_at' => carbon::now()
                ]);

            return response()->json(['status' => [$saveNewStudent, $saveNewAccount]]);   
        });
    }

    public function get_students(){

        $student_id = $this->request->student_id;

        $query = DB::table('students')   
            ->join('accounts', function($join){
                $join->on('students.stud_id','=','accounts.user_id')
                ->where(['type' => 'student', 'is_approved' => 1]);
            })
            ->orderBy('last_name', 'asc');
        
        if($student_id != null) {
           $query->where('students.stud_id', $student_id);
        }

        $students = $query->get();
        
        return response()->json(['students' => $students]);
    }

    public function get_current_student(){
        $id = $this->request->id;

        $student = DB::table('students')    
            ->join('accounts', function($join) use($id){
                $join->on('students.stud_id','=','accounts.user_id')
                ->where(['students.stud_id' => $id, 'accounts.type' => 'student']);
            })
            ->first();

        $student_id = $student->stud_id;
        $semester = $this->helper->get_current_semester();
        $school_year = $this->helper->get_current_school_year();
    
        // Get subjects
        // FIXED: subject relation to loads
        $subjects = DB::table('students')
            ->join('class_lists', 'students.stud_id', '=', 'class_lists.student_id') 
            ->join('classes', 'classes.class_id', '=', 'class_lists.class_id') 
            ->join('loads', 'loads.load_id', '=', 'classes.load_id')
            ->join('curriculum_subjects', 'curriculum_subjects.curriculum_subject_id', '=', 'loads.curriculum_subject_id')
            ->join('curriculum_year_sem', 'curriculum_year_sem.curriculum_year_sem_id', '=', 'curriculum_subjects.curriculum_year_sem_id')
            ->join('subjects', 'subjects.subject_id', '=', 'curriculum_subjects.subject_id')
            ->where([
                'students.stud_id' => $student_id, 
                'classes.semester_id' => $semester->semester_id, 
                'classes.school_year_id' => $school_year->school_year_id, 
                'class_lists.is_approved' => 1
            ])
            ->select(
                'section',
                'year_level',
                'subjects.subject_id',
                'subjects.subject_code',
                'subjects.subject_description',
                'subjects.lec_units',
                'subjects.lab_units',
                'loads.start_time',
                'loads.end_time'
            )
            ->get(); 
        
        $subjects->map(function($subject){
            $subject->year_level_name = $this->helper->str_ordinal($subject->year_level);
        });

        $student->subjects = $subjects;   

        return response()->json(['student' => $student]);
    }

    public function save_update_student(){
        
         return DB::transaction(function () {

            $stud_id = $this->request->stud_id;
            $lastname = $this->request->last_name;
            $firstname = $this->request->first_name;
            $middlename = $this->request->middle_name;
            $gender =  $this->request->gender;
            $birthdate = $this->request->birthdate;
            $enrolled_curriculum_year = $this->request->enrolled_curriculum_year;

            $username = $this->request->username;
            $emailaddress = $this->request->email_address;
            $password = $this->request->password;

            $updateImage = 0;
           if($this->request->hasFile('image')){

                $file = $this->request->file('image');
                $gen_filename = $this->helper->generateFileName($file, 'students');

                $file->move($this->directory->getPath('students'), $gen_filename);

                $updateImage = DB::table('students')
                    ->where(['stud_id' => $stud_id])
                    ->update([
                        'image' => $gen_filename
                    ]);
            }

            $saveUpdateStudent = DB::table('students') 
                ->where(['stud_id' => $stud_id])
                ->update([
                    'last_name' => $lastname,
                    'first_name' => $firstname,
                    'middle_name' => $middlename,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'curriculum_year' => $enrolled_curriculum_year,
                    'updated_at' => Carbon::now()
                ]);

            $saveUpdateStudenAccount = DB::table('accounts')
                ->where(['user_id' => $stud_id, 'type' => 'student'])
                ->update([
                    'username' => $username,
                    'password' => $password,
                    'hash_password' => sha1($password),
                    'email_address' => $emailaddress,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json(['status' => [$updateImage, $saveUpdateStudent, $saveUpdateStudenAccount]]);   
        });

    }

    public function deactivate_student(){

        $student_id = $this->request->studentId;
        
        $status = DB::table('students')
                ->where(["stud_id" => $student_id])
                ->update(["is_active" => 0]);

        return response()->json(['status' => $status]);
    }
    
    public function activate_student(){

        $student_id = $this->request->studentId;
        
        $status = DB::table('students')
        ->where(["stud_id" => $student_id])
        ->update(["is_active" => 1]);

        return response()->json(['status' => $status]);
    }

    public function verify_student_id_exists() {
        $student_id = $this->request->studentId;
        $verify_existence = DB::table('students')
            ->where(['student_id' => $student_id])
            ->first();

        $result = ($verify_existence != null);
        return response()->json(['result' => $result]);
    }
}

