<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;
use Carbon\Carbon;
use App\ICSClasses\Helper;
use App\ICSClasses\Directory;


class AdminICSDetailsController extends Controller
{
    public function render_ics_details(){
        $ics_details = DB::table('ics_details')->where(['ics_detail_id' => 1])->first();

        return view('admin.ics_details.ics_details', ['detail' => $ics_details]);
    }

    public function get_details(){
        $details = DB::table('ics_details')->first();
        return response()->json(['details' => $details], 200);
    }  

    public function save_new_details(Request $request){
       $detail_type =  $request->get('detail_type');
       $new_data =  $request->get('new_data');

       DB::table('ics_details')->where(['ics_detail_id' => 1])->update([$detail_type => $new_data, $detail_type.'_updated_at' => Carbon::now()]);
    }

    public function get_official_logo(){
        $logo = DB::table('ics_details')->select('ics_logo')->first();
        return response()->json(['logo' => $logo], 200);
    }

    public function save_new_logo(Request $request, Helper $helper, Directory $directory){

        return DB::transaction(function () use($request, $helper, $directory) {

            $saveUpdateLogo = 0;

            if($request->hasFile('logo')){
                $logo = $request->file('logo');
                $gen_filename = $helper->generateFileName($logo, 'ics_details', 'ics_logo');
                $logo->move($directory->getPath('ics_logo'), $gen_filename);

                $saveUpdateLogo = DB::table('ics_details')
                    ->update(['ics_logo' => $gen_filename]);
            }   

            return response()->json(['status' => $saveUpdateLogo]);
        });
        
    }
}
