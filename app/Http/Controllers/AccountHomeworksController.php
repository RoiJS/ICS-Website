<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;
use \DB;
use Carbon\Carbon;

class AccountHomeworksController extends Controller
{

    protected $request = [];
    protected $helper = [];
    protected $directory = [];

    public function __construct(Request $request, Helper $helper, Directory $directory){
        $this->request = $request;
        $this->helper = $helper;
        $this->directory = $directory;
    } 

    public function save_new_homework(){

        $class_id = $this->request->class_id;
        $title = $this->request->title;
        $description = $this->request->description;
        $is_submit = $this->request->is_submit == "true" ? 1 : 0;
        $send_at = $is_submit == 1 ? Carbon::now() : NULL;
        $due_date = $this->request->due_date;

        $saveNewHomework = DB::table('homeworks')
            ->insertGetId([
                'class_id' => $class_id,
                'title' => $title,
                'description' => $description,
                'send_at' => $send_at,
                'due_at' => $due_date,
                'created_at' => Carbon::now(),
                'send_status' => $is_submit
            ]); 

        
        return response()->json(['homework_id' => $saveNewHomework]);
    }

    public function upload_homework_file(){

        $homework_id = $this->request->homework_id;
        $file = $this->request->file('file');
        $filename = $file->getClientOriginalName();
        $filetype = $file->getType();
        $size = $file->getSize();

        $gen_filename = $this->helper->generateFileName($file, 'homework_uploaded_files', 'generated_file_name');
        $size = $file->getSize();

        $file->move($this->directory->getPath('send_homeworks'), $gen_filename);

        $uploadHomeworkFile = DB::table('homework_uploaded_files')
            ->insert([
                'homework_id' =>$homework_id,
                'file_type' => $filetype,
                'size' => $size,
                'original_file_name' => $filename,
                'generated_file_name' => $gen_filename
            ]);

        return response()->json(['status' => $uploadHomeworkFile]);
    }

    public function get_homeworks(){

        return DB::transaction(function () {

            $class_id = $this->request->class_id;

            $homeworks = DB::table('homeworks')
                ->where(['class_id' => $class_id])
                ->orderBy('created_at', 'desc')
                ->get();

            $homeworks->map(function($homework) use($class_id){
                
                // 1st Phase
                $submitted_homeworks = DB::table('submitted_homeworks')
                    ->where(['homework_id' => $homework->homework_id])
                    ->get();

                $submitted_homeworks->map(function($submitted_homework) use($homework, $class_id){
                    $verify = DB::table('class_lists')
                        ->where(['class_id' => $class_id, 'student_id' => $submitted_homework->student_id])
                        ->count();

                    if($verify == 0) {
                        DB::table('submitted_homeworks')
                            ->where(['homework_id' => $homework->homework_id, 'student_id' => $submitted_homework->student_id])
                            ->delete();

                        DB::table('submitted_homework_files')
                            ->where(['submitted_homework_id' => $submitted_homework->submitted_homework_id])
                            ->delete();
                    }
                });
                
                $enroll_students = DB::table('class_lists')
                    ->where(['class_id' => $class_id])
                    ->get();

                //2nd Phase
                $enroll_students->map(function($student) use($homework){
                    $verify = DB::table('submitted_homeworks')
                        ->where(['homework_id' => $homework->homework_id, 'student_id' => $student->student_id])
                        ->first();

                    if($verify == null){
                       $submitted_homework_id = DB::table('submitted_homeworks')
                            ->insertGetId([
                                'homework_id' => $homework->homework_id,
                                'student_id' => $student->student_id
                            ]);

                        DB::table('submitted_homework_files')
                            ->insert([
                                'submitted_homework_id' => $submitted_homework_id,
                                'size' => 0
                            ]);
                    }else{

                        $verify_submitted_homework_id = DB::table('submitted_homework_files')
                            ->where(['submitted_homework_id' => $verify->submitted_homework_id])
                            ->first();
                        
                        if($verify_submitted_homework_id == null){
                            DB::table('submitted_homework_files')
                            ->insert([
                                'submitted_homework_id' => $verify->submitted_homework_id,
                                'size' => 0
                            ]);
                        }
                    }
                });


                $no_of_students = DB::table('submitted_homeworks')
                    ->where(['homework_id' => $homework->homework_id])
                    ->count();

                $no_of_students_submitted = DB::table('submitted_homeworks')
                    ->where(['homework_id' => $homework->homework_id, 'is_submitted' => 1])
                    ->count();
                
                $homework->no_of_students_submitted = $no_of_students_submitted;
                $homework->no_of_students_submitted_percentage = number_format((($no_of_students_submitted / $no_of_students) * 100 ), 0,".","")."%";

            });

            return response()->json(['homeworks' => $homeworks]);     
        });
        
    }

    public function send_homework(){
        $homework_id = $this->request->homework_id;
        $sendHomework = DB::table('homeworks')
            ->where(['homework_id' => $homework_id])
            ->update([
                'send_status' => 1,
                'send_at' => Carbon::now()
            ]);

        return response()->json(['status' => $sendHomework]);
    }

    public function unsend_homework(){
        $homework_id = $this->request->homework_id;
        $unsendHomework = DB::table('homeworks')
            ->where(['homework_id' => $homework_id])
            ->update([
                'send_status' => 0,
                'send_at' => NULL
            ]);
        return response()->json(['status' => $unsendHomework]);
    }

    public function remove_homework($id){

        return DB::transaction(function () use($id) {

            $submitted_homeworks = DB::table('submitted_homeworks')
                ->where(['homework_id' => $id])
                ->get();

            $submitted_homeworks->map(function($homework){
                DB::table('submitted_homework_files')
                    ->where(['submitted_homework_id' => $homework->submitted_homework_id])
                    ->delete();
            });

            DB::table('submitted_homeworks')
                ->where(['homework_id' => $id])
                ->delete();

            DB::table('homework_uploaded_files')
                ->where(['homework_id' => $id])
                ->delete();

           $removeHomework = DB::table('homeworks')
                ->where(['homework_id' => $id])
                ->delete();

            return response()->json(['status' => $removeHomework]); 
        });
    }

    public function get_homework_details(){
        $homework_id = $this->request->homework_id;
        $get_submitted_homeworks = $this->request->get_submitted_homeworks;

        $account = $this->helper->get_current_account();
         

        $homework = DB::table('homeworks')
            ->join('submitted_homeworks','homeworks.homework_id','=','submitted_homeworks.homework_id')
            ->where(['homeworks.homework_id' => $homework_id])
            ->first();

        $homework->is_due = (date('Y-m-d') == date('Y-m-d', strtotime($homework->due_at)));
        
        $files = DB::table('homework_uploaded_files')
            ->where(['homework_id' => $homework_id])
            ->get();

        $return_data = ['homework' => $homework, 'files' => $files];

        if($get_submitted_homeworks) {
            $student = $this->helper->get_user_info($account->account_id);
            $submitted_homework = DB::table("submitted_homeworks")
                ->join("submitted_homework_files", "submitted_homeworks.submitted_homework_id", "=", "submitted_homework_files.submitted_homework_id")
                ->where(['student_id' => $student->stud_id, 'homework_id' => $homework_id])
                ->first();
                $return_data += ['submitted_homework' => $submitted_homework];
        }

        return response()->json($return_data);
    }

    public function save_update_homework(){
        $homework = $this->request->homework;

        $class_id = $homework['class_id'];
        $homework_id = $homework['homework_id'];
        $title = $homework['title'];
        $description = $homework['description'];
        $is_submit = $homework['is_submit'] == "true" ? 1 : 0;
        $send_at = $is_submit == 1 ? Carbon::now() : NULL;
        $due_date = $homework['due_date'];

        $saveUpdateHomework = DB::table('homeworks')
            ->where(['homework_id' => $homework_id])
            ->update([
                'title' => $title,
                'description' => $description,
                'send_status' => $is_submit,
                'send_at' => $send_at,
                'due_at' =>  $due_date
            ]);

        return response()->json(['homework_id' => $homework_id]);
    }


    public function get_submitted_homeworks(){
        $homework_id = $this->request->homework_id;

        $submitted_homeworks = DB::table('submitted_homeworks')
            ->join('students', 'submitted_homeworks.student_id','=','students.stud_id')
            ->join('submitted_homework_files','submitted_homeworks.submitted_homework_id', '=', 'submitted_homework_files.submitted_homework_id')
            ->join('homeworks','homeworks.homework_id', '=', 'submitted_homeworks.homework_id')
            ->where(['homeworks.homework_id' => $homework_id])
            ->orderBy('last_name', 'asc')
            ->get();

        return response()->json(['submitted_homeworks' => $submitted_homeworks]);
    }

    public function approved_homework(){

        $submitted_homework_id = $this->request->submitted_homework_id;
        $approved_status = $this->request->approved_status == "true" ? 1 : 0;
        $date_approved = $approved_status == 1 ? Carbon::now() : NULL;

        $approvedStatus = DB::table('submitted_homeworks')
            ->where(['submitted_homework_id' => $submitted_homework_id])
            ->update([
                'approved_status' => $approved_status,
                'date_approved' => $date_approved
            ]);

        return response()->json(['status' => $approvedStatus]);
    }

    public function get_student_homeworks(){
        
        $account = $this->helper->get_current_account();
        $student = $this->helper->get_user_info($account->account_id); 
        $class_id = $this->request->class_id;

        $homeworks = DB::table('homeworks')
            ->join('submitted_homeworks', 'homeworks.homework_id','=','submitted_homeworks.homework_id')
            ->join('submitted_homework_files', 'submitted_homeworks.submitted_homework_id', '=', 'submitted_homework_files.submitted_homework_id')
            ->where(['class_id' => $class_id, 'student_id' => $student->stud_id, 'send_status' => 1])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['homeworks' => $homeworks]);
    }

    public function submit_file(){
        $account = $this->helper->get_current_account();
        $student = $this->helper->get_user_info($account->account_id);
        $homework_id = $this->request->homework_id;

        $submitted_homework = DB::table('submitted_homeworks')
            ->where(['homework_id' => $homework_id, 'student_id' => $student->stud_id])
            ->select('submitted_homework_id')
            ->first();

        $saveSubmittion = DB::table('submitted_homeworks')
            ->where(['submitted_homework_id' => $submitted_homework->submitted_homework_id])
            ->update([
                'is_submitted' => 1,
                'date_submitted' => Carbon::now()
            ]);

        $file = $this->request->file('file');
        $filename = $file->getClientOriginalName();
        $filetype = $file->getType();
        $size = $file->getSize();

        $gen_filename = $this->helper->generateFileName($file, 'submitted_homework_files', 'generated_file_name');
        $size = $file->getSize();

        $file->move($this->directory->getPath('submitted_homeworks'), $gen_filename);

        $saveFile = DB::table('submitted_homework_files')
            ->where(['submitted_homework_id' => $submitted_homework->submitted_homework_id])
            ->update([
                'file_type' => $filetype,
                'original_file_name' => $filename,
                'generated_file_name' => $gen_filename,
                'size' => $size
            ]);

        return response()->json(['status' => $saveFile]);
    }
}
