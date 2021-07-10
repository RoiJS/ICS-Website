<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;


class AdminAnnouncementController extends Controller
{
    protected $request = [];

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function render_announcements(){
        return view('admin.announcements.announcements');
    }

    public function render_add_announcement(){
        return view('admin.announcements.add_announcement');
    }

    public function render_edit_announcement($id){
        return view('admin.announcements.edit_announcement', ['announcement' => ['id' => $id]]);
    }

    public function get_announcements(){
        $announcements = DB::table('announcements')->orderBy('announcement_id','desc')->get();
        return response()->json(['announcements' => $announcements], 200);
    }

    public function save_new_announcement(Helper $helper, Directory $directory){
       
       return DB::transaction(function () use($helper, $directory) {

            $title = $this->request->get('title');
            $description = $this->request->get('description');

            if($this->request->hasFile('image')){
                $file = $this->request->file('image');
                $filename = $file->getClientOriginalName();
                $gen_filename = $helper->generateFileName($file, 'announcements', 'generated_filename');
                $size = $file->getSize();

                $file->move($directory->getPath('announcements'), $gen_filename);

            }else{
                $filename = '';
                $gen_filename = '';
                $size = 0;
            }

            $insertParams = [
                'title' => $title, 
                'description' => $description,
                'created_at' => Carbon::now(), 
                'post_status' => 0
            ];

            if ($this->request->hasFile('image')) {
                $insertParams += [
                    'original_filename' => $file->getClientOriginalName(), 
                    'generated_filename' => $gen_filename, 
                    'size' => $size
                ];
            }

            $saveNewAnnouncement = DB::table('announcements')->insert($insertParams);

            return response()->json(['status' => $saveNewAnnouncement], 200); 
       });
    }

    public function get_current_announcement(){
        $announcement_id = $this->request->get('announcement_id');

        $announcement = DB::table('announcements')->where(['announcement_id' => $announcement_id])->first();
        return response()->json(['announcement' => $announcement], 200);
    }

    public function save_update_announcement(Helper $helper, Directory $directory){
            
        return DB::transaction(function () use($helper, $directory){

            $id = $this->request->get('announcement_id');
            $title = $this->request->get('title');
            $description = $this->request->get('description');
            
            // $deleteImage = false;
            $updateImage = 0;
            if($this->request->hasFile('image')){

                $file = $this->request->file('image');
                $filename = $file->getClientOriginalName();
                $gen_filename = $helper->generateFileName($file, 'announcements', 'generated_filename');
                $size = $file->getSize();

                $file->move($directory->getPath('announcements'), $gen_filename);

                $updateImage = DB::table('announcements')
                    ->where(['announcement_id' => $id])
                    ->update([
                        'original_filename' => $filename,
                        'generated_filename' => $gen_filename,
                        'size' => $size
                    ]);

                //$deleteImage = $helper->unlinkFile('announcements', 'announcement_id', $id, $directory->getPath('announcements'), 'generated_filename');
            }

            $saveUpdateAnnouncement = DB::table('announcements')
                ->where(['announcement_id' => $id])
                ->update([
                    'title' => $title,
                    'description' => $description,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json(['status' => [/*$deleteImage,*/ $updateImage, $saveUpdateAnnouncement]], 200);
        }); 
    }

    public function remove_announcement($id, Helper $helper, Directory $directory){

       return DB::transaction(function () use($id, $helper, $directory){
           $removeAnnouncement = DB::table('announcements')
            ->where(['announcement_id' => $id])
            ->delete();
            //$removeImage = $helper->unlinkFile('announcements', 'announcement_id', $id, $directory->getPath('announcements'), 'generated_filename');
            
            return response()->json(['status' => [[/*$removeImage,*/$removeAnnouncement]]]);    
        });
    }

}
