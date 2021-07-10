<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;
use \DB;

use Carbon\Carbon;

class StudentProfileController extends Controller
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
        return view('student.profile.profile');
    }

    public function render_personal_information(){
        return view('student.profile.personal_information');
    }

    public function render_account_information(){
        return view('student.profile.account_information');
    }

    public function render_profile_picture(){
        return view('student.profile.profile_picture');
    }

    public function get_student_profile(){

        $account = $this->helper->get_current_account();

        $profile = DB::table('students')
            ->join('accounts', function($join) use ($account){
                $join->on('students.stud_id', '=', 'accounts.user_id')
                    ->where(['type' => 'student', 'user_id' => $account->stud_id]);
            })
            ->first();

            return response()->json(['profile' => $profile]);
    }

    public function save_update_logo(){
        if($this->request->hasFile('image')){

            $account = $this->helper->get_current_account();
            $image = $this->request->file('image');
            $gen_file = $this->helper->generateFileName($image, 'students');
            $image->move($this->directory->getPath('students'), $gen_file);

            $saveUpdateProfilePic = DB::table('students')
                ->where(['stud_id' => $account->stud_id])
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

            $id = $info['stud_id'];
            $student_id = $info['student_id'];
            $lastname = $info['last_name'];
            $firstname = $info['first_name'];
            $middlename = $info['middle_name'];
            $gender = $info['gender'];
            $birthdate = $info['birthdate'];

            $saveUpdatePersonalInfo = DB::table('students')
                ->where(['stud_id' => $id])
                ->update([
                    'student_id' => $student_id,
                    'last_name' => $lastname,
                    'first_name' => $firstname,
                    'middle_name' => $middlename,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json(['status' => $saveUpdatePersonalInfo]);  
        });
    }

    public function save_update_account_info(){

        return DB::transaction(function () {

            $info = $this->request->get('info');

            $id = $info['stud_id'];
            $username = $info['username'];
            $email_address = $info['email_address'];
            $password = $info['password'];
            $hash_password = sha1($password);

            $saveUpdateAccountInfo = DB::table('accounts')  
                ->where([
                    'user_id' => $id,
                    'type' => 'student'
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
