<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\ICSClasses\Helper;
use \DB;

class AdminAccountApprovalController extends Controller
{
    protected $request = [];

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function render_accounts_approval(){
        return view('admin.students.approve_student_accounts');
    }

    public function list_of_accounts_approval(){

        $accounts_approval = DB::table('accounts')
            ->join('students', 'accounts.user_id','=','students.stud_id')
            ->where(['is_approved' => 0, 'type' => 'student'])
            ->orderBy('accounts.created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json(['accounts_approval' => $accounts_approval]);

    }

    public function approve_account(){
        $account_id = $this->request->account_id;
        $approveAccount = DB::table('accounts')
            ->where(['account_id' => $account_id])
            ->update(['is_approved' => 1]);
            
        return response()->json(['status' => $approveAccount]);
    }
}
