<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;
use Carbon\Carbon;

class AdminProfileController extends Controller
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
        return view('admin.profile.profile');
    }

    public function render_personal_information(){
        return view('admin.profile.personal_information');
    }
    
    public function render_account_information(){
        return view('admin.profile.account_information');
    }

    public function render_profile_picture(){
        return view('admin.profile.profile_picture');
    }

    public function get_admin_profile(){

        $profile = DB::table('admin')
            ->join('accounts', function($join){
                $join->on('admin.admin_id', '=', 'accounts.user_id')
                    ->where(['type' => 'admin']);
            })
            ->first();

            return response()->json(['profile' => $profile]);
    }

    public function save_update_logo(){
        if($this->request->hasFile('image')){

            $image = $this->request->file('image');
            $gen_file = $this->helper->generateFileName($image, 'admin');
            $image->move($this->directory->getPath('admin'), $gen_file);

            $saveUpdateProfilePic = DB::table('admin')
                ->where(['admin_id' => 1])
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
            $id = $info['admin_id'];
            $lastname = $info['last_name'];
            $firstname = $info['first_name'];
            $middlename = $info['middle_name'];

            $saveUpdatePersonalInfo = DB::table('admin')
                ->where(['admin_id' => $id])
                ->update([
                    'last_name' => $lastname,
                    'first_name' => $firstname,
                    'middle_name' => $middlename,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json(['status' => $saveUpdatePersonalInfo]);  
        });
    }

    public function save_update_account_info(){

        return DB::transaction(function () {

            $info = $this->request->get('info');

            $id = $info['admin_id'];
            $username = $info['username'];
            $email_address = $info['email_address'];
            $password = $info['password'];
            $hash_password = sha1($password);

            $saveUpdateAccountInfo = DB::table('accounts')  
                ->where([
                    'user_id' => $id,
                    'type' => 'admin'
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
