<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;
use \DB;

use Carbon\Carbon;

class TeacherProfileController extends Controller
{
    protected $request = [];
    protected $helper = [];
    protected $directory = [];

    public function __construct(Request $request, Helper $helper, Directory $directory){
        $this->request = $request;
        $this->helper = $helper;
        $this->directory = $directory;
    } 

    public function render_profile(){
        return view('teacher.profile.profile');
    }

    public function render_personal_information(){
        return view('teacher.profile.personal_information');
    }

    public function render_account_information(){
        return view('teacher.profile.account_information');
    }

    public function render_profile_picture(){
        return view('teacher.profile.profile_picture');
    }

    public function get_teacher_profile(){

        $account = $this->helper->get_current_account();

        $profile = DB::table('teachers')
            ->join('accounts', function($join) use ($account){
                $join->on('teachers.teacher_id', '=', 'accounts.user_id')
                    ->where(['type' => 'teacher', 'user_id' => $account->teacher_id]);
            })
            ->first();

            return response()->json(['profile' => $profile]);
    }

    public function save_update_logo(){
        if($this->request->hasFile('image')){

            $account = $this->helper->get_current_account();
            $image = $this->request->file('image');
            $gen_file = $this->helper->generateFileName($image, 'teachers');
            $image->move($this->directory->getPath('faculty'), $gen_file);

            $saveUpdateProfilePic = DB::table('teachers')
                ->where(['teacher_id' => $account->teacher_id])
                ->update([
                    'image' => $gen_file,
                    'updated_at' => Carbon::now()
                ]);
        }
        return response()->json(['status' => $saveUpdateProfilePic]);
    }

    public function save_update_personal_info(){

        return DB::transaction(function () {

            $info = $this->request->get('info');

            $id = $info['teacher_id'];
            $faculty_id = $info['faculty_id'];
            $lastname = $info['last_name'];
            $firstname = $info['first_name'];
            $middlename = $info['middle_name'];
            $gender = $info['gender'];
            $birthdate = $info['birthdate'];
            $academic_rank = $info['academic_rank'];
            $designation = $info['designation'];

            $saveUpdatePersonalInfo = DB::table('teachers')
                ->where(['teacher_id' => $id])
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

            return response()->json(['status' => $saveUpdatePersonalInfo]);  
        });
    }

    public function save_update_account_info(){

        return DB::transaction(function () {

            $info = $this->request->get('info');

            $id = $info['teacher_id'];
            $username = $info['username'];
            $email_address = $info['email_address'];
            $password = $info['password'];
            $hash_password = sha1($password);

            $saveUpdateAccountInfo = DB::table('accounts')  
                ->where([
                    'user_id' => $id,
                    'type' => 'teacher'
                ])
                ->update([
                    'username' => $username,
                    'email_address' => $email_address,
                    'password' => $password,
                    'hash_password' => $hash_password,
                    'updated_at' => Carbon::now()
                ]);

                return response()->json(['status' => $saveUpdateAccountInfo]);
        });

    }
}
