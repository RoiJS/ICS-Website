<?php

    namespace App\ICSClasses;

    use \DB;
    use \File;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class Helper {

        protected $request = [];

        public function __construct(Request $request){
            $this->request = $request;
        }

        public function get_current_semester(){
            return DB::table('semesters')->where(['is_current_semester' => 1])->first();
        }

        public function get_current_school_year(){
            return DB::table('school_years')->where(['is_current_sy' => 1])->first(); 
        }

        public function post_unpost_module($table, $id, $column, $status, $track_update_column){
            return $status = DB::table($table)
                ->where([$column => $id])
                ->update([
                    'post_status' => $status,
                    $track_update_column => Carbon::now()
                ]);
        }

        public function generateFileName($file, $table_name, $col_name = 'image'){
            $extension = $file->getClientOriginalExtension();

            do{
                $random = rand(1,1000000000).'_'.rand(1,1000000000).'_'.rand(1,1000000000);
                $count = DB::table($table_name)->where($col_name, 'LIKE', '%'.$random.'%')->count();
            }while($count > 0);

            return $random.".".$extension;
        }

        public function unlinkFile($table_name, $col_name, $id, $sources, $file = 'image'){
            $delete_status = false;
            $getFile = DB::table($table_name)->where([$col_name => $id])->select($file)->first();

            if($getFile->$file != ''){
                $delete_status = true;
                File::delete($sources.$getFile->$file);
            }

            return $delete_status;
        }

        public function get_current_account() {

            $account = $this->request->session()->get('user');
            $id = $account->user_id;
            $type = $account->type;

            if($type == 'admin'){
                $table_name = 'admin';
                $col_name = 'admin_id';
            }elseif($type == 'teacher'){
                $table_name = 'teachers';
                $col_name = 'teacher_id';
            }elseif($type == 'student'){
                $table_name = 'students';
                $col_name = 'stud_id';
            }

            $account = DB::table($table_name)
                ->join('accounts', function($join) use($table_name, $col_name, $id, $type){
                    $join->on($table_name.".".$col_name, '=', 'accounts.user_id')
                    ->where([$col_name => $id, 'type' => $type]);
                })
                ->first();

            return $account;
        }

        public function get_user_info($account_id) {

            $account = DB::table('accounts')
                ->where(['account_id' => $account_id])
                ->first();

            $id = $account->user_id;
            $type = $account->type;

            if($type == 'admin'){
                $table_name = 'admin';
                $col_name = 'admin_id';
            }elseif($type == 'teacher'){
                $table_name = 'teachers';
                $col_name = 'teacher_id';
            }elseif($type == 'student'){
                $table_name = 'students';
                $col_name = 'stud_id';
            }

            $user_info = DB::table($table_name)
                ->join('accounts', function($join) use($table_name, $col_name, $id, $type){
                    $join->on($table_name.".".$col_name, '=', 'accounts.user_id')
                    ->where([$col_name => $id, 'type' => $type]);
                })
                ->first();

            return $user_info;
        }


        public function get_faculty_subjects_for_this_sem_and_sy(){

            $account = $this->get_current_account();
            $semester = $this->get_current_semester();
            $school_year = $this->get_current_school_year();

            return DB::table('classes')
                ->join('loads','classes.load_id','=','loads.load_id')
                ->join('curriculum_subjects','curriculum_subjects.curriculum_subject_id','=','loads.curriculum_subject_id')
                ->join('subjects','curriculum_subjects.subject_id','=','subjects.subject_id')
                ->where([
                    'classes.semester_id' => $semester->semester_id, 
                    'classes.school_year_id' => $school_year->school_year_id, 
                    'teacher_id' => $account->teacher_id
                ])
                ->select(DB::raw('subjects.*'),'class_id')
                ->get();

        }

        public function get_student_subjects_for_this_sem_and_sy(){

            $account = $this->get_current_account();
            $semester = $this->get_current_semester();
            $school_year = $this->get_current_school_year();

            return DB::table('class_lists')
                ->join('classes','classes.class_id','=','class_lists.class_id')
                ->join('loads','classes.load_id','=','loads.load_id')
                ->join('subjects','loads.subject_id','=','subjects.subject_id')
                ->where([
                    'classes.semester_id' => $semester->semester_id, 
                    'classes.school_year_id' => $school_year->school_year_id, 
                    'class_lists.student_id' => $account->stud_id,
                    'class_lists.is_approved' => 1
                ])

                ->select(DB::raw('subjects.*'),'class_lists.class_id')
                ->get();

        }

        public function get_subject_info($class_id){

            $subjectInfo = DB::table('classes')
                ->join('loads','classes.load_id','=','loads.load_id')
                ->join('subjects','loads.subject_id','=','subjects.subject_id')
                ->where(['classes.class_id' => $class_id])
                ->select(DB::raw('subjects.subject_description as description, subjects.subject_code as code, teacher_id'), DB::raw('subjects.subject_code as code'))
                ->first();

            return $subjectInfo;
        } 

        public function get_account_info($user_id, $type){

            $account_info = DB::table('accounts')
                ->where(['user_id' => $user_id, 'type' => $type])
                ->first();

            return $account_info; 
        }

        public function str_ordinal($value, $superscript = false)
        {
            $number = abs($value);
     
            $indicators = ['th','st','nd','rd','th','th','th','th','th','th'];
     
            $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
            if ($number % 100 >= 11 && $number % 100 <= 13) {
                $suffix = $superscript ? '<sup>th</sup>' : 'th';
            }
     
            return number_format($number) . $suffix;
        }

    }
