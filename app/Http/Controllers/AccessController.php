<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ICSClasses\Helper;
use Carbon\Carbon;

class AccessController extends Controller
{
    protected $request = [];

    public function construct(Request $request){
        $this->middleware('authAccount', ['except' => ['sign_out', 'get_details']]);
        $this->request = $request;
    }

    public function index(){
        return view('login');
    }

    public function authenticate(Request $request){
       

        $username = $request->get('username');
        $password = $request->get('password');

        $user = DB::table('accounts')
                ->where(['username' => $username, 'hash_password' => sha1($password)])
                ->select('user_id', 'type', 'is_approved')
                ->first();

        if($user != null){

            if($user->is_approved != 0){
                if($user->type == 'admin'){
                    $table = 'admin';
                    $col = 'admin_id';
                }elseif($user->type == 'teacher'){
                    $table = 'teachers';
                    $col = 'teacher_id';
                }elseif($user->type == 'student'){
                    $table = 'students';
                    $col = 'stud_id';
                }

                $acc = DB::table('accounts')
                            ->join($table, 'accounts.user_id', '=', $table.'.'.$col)
                            ->where([$table.'.'.$col =>  $user->user_id, 'accounts.type' => $user->type])
                            ->first();

                if ($acc->is_active != 0) {
                    $request->session()->put('user', $acc);
                    return response()->json(array('status' => true, 'type' => $acc->type)); 
                } else {
                    return response()->json(array('status' => false, 'message' => 'Your account has been deactivated. Kindly contact your Administrator.'));  
                }
            }else{
                return response()->json(array('status' => false, 'message' => 'Sorry, your account is currently inactive. System Administrator has not yet approved your account information.'));  
            }
        }else{
            return response()->json(array('status' => false, 'message' => 'Invalid Account Information'));  
        }
    }

    public function sign_out(Request $request){
        $request->session()->forget('user');
        return redirect('/');
    }

    public function get_details(Request $request, Helper $helper){
        return response()->json(array('details' => $helper->get_current_account($request->session()->get('user'))));
    }

    public function render_register(){
        return view('register');
    }

    public function save_new_account(Request $request){
       
        return DB::transaction(function () use($request) {

            $account = $request->get("account");

            $student_id = $account['student_id'];
            $lastname = $account['lastname'];
            $firstname = $account['firstname'];
            $middlename = $account['middlename'];
            $gender = $account['gender'];
            $birthdate = $account['birthdate'];
            $emailaddress = $account['emailaddress'];
            $username = $account['username'];
            $password = $account['password'];

            $saveNewStudent = DB::table('students')
                ->insertGetId([
                    'student_id' => $student_id,
                    'last_name' => $lastname,
                    'first_name' => $firstname,
                    'middle_name' => $middlename,
                    'gender' => $gender,
                    'birthdate' => $birthdate,
                    'is_active' => 1,
                    'created_at' => Carbon::now()
                ]);

            $saveNewAccount = DB::table('accounts')
                ->insert([
                    'user_id' => $saveNewStudent,
                    'type' => 'student',
                    'username' => $username,
                    'password' => $password,
                    'email_address' => $emailaddress,
                    'hash_password' => sha1($password),
                    'created_at' => Carbon::now(),
                    'is_approved' => 0
                ]);

            return response()->json(['status' => $saveNewAccount]);  
        });
        
    }

    public function verify_student_id_exists(Request $request) {

        $student_id = $request->get('studentId');

        $verify_existence = DB::table('students')
            ->where(['student_id' => $student_id])
            ->first();

        $result = ($verify_existence != null);
        return response()->json(['result' => $result]);
    }
}
