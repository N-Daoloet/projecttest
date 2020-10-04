<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{

    public function updateimage(Request $request){
       
    }

    public function adduser(Request $request){
        $user = DB::table('user')->where('USER_FNAME', $request->firstname)->where('USER_LNAME', $request->lastname)->first();
        $data = array(
            "user" => $user,
            "dep" => DB::table('department')->get(),
            "per" => DB::table('personal')->get(),
        ); 
        if(!empty($user)){
            return view('admin.adduser2',$data);
        }else{
            return back();
        }
    }
    
    public function updateuser(Request $request){
        DB::table('user')->where('USER_ID', $request->userid)->update(['DEP_ID' => $request->depid,'PERTYPE_ID'=>$request->perid]);
        return view('admin.adduser');
    }

    public function manageraccount(Request $request){

        $data = array(
            "sql" => DB::table('user')->where('DEP_ID',$request->department)->where('PERTYPE_ID',$request->person)->get(),
            // "au1" => DB::table('managerauthority')->get(),
            // "au2" => DB::table('directorauthority')->get(),
            // "au3" => DB::table('adminauthority')->get(),
        );  
        return view('admin.manageaccount2',$data);
    }
    
    public function delete($USER_ID){

        DB::table('user')->where('USER_ID', $USER_ID)->delete();
        return redirect()->route('manageaccount');
    }

    public function store(Request $request){
  
        if(isset($request['authority1'])){
            foreach($request['authority1'] as $data){
                // DB::table('user')->where('USER_ID',$data)->update(['AUTHORITY_ID'=>1]);
                $sql = DB::table('managerauthority')->where('USER_ID',$data)->first();
         
                if(empty($sql)){
                    DB::table('managerauthority')->insert(['USER_ID'=>$data]);
                }

                // DB::table('user')->whereNotIn('USER_ID',$data)->update('AUTHORITY_ID',NULL);
            }
        }
        if(isset($request['authority2'])){
            foreach($request['authority2'] as $data){
                $sql = DB::table('directorauthority')->where('USER_ID',$data)->first();
                if(empty($sql)){
                    DB::table('directorauthority')->insert(['USER_ID'=>$data]);
                }
                // DB::table('user')->whereNotIn('USER_ID',$data)->update('AUTHORITY_ID',NULL);
            }
        }
        if(isset($request['authority3'])){
            foreach($request['authority3'] as $data){
                // DB::table('user')->where('USER_ID',$data)->update(['AUTHORITY_ID'=>3]);
                $sql = DB::table('adminauthority')->where('USER_ID',$data)->first();
                if(empty($sql)){
                    DB::table('adminauthority')->insert(['USER_ID'=>$data]);
                }

                // DB::table('user')->whereNotIn('USER_ID',$data)->update('AUTHORITY_ID',NULL);
            }
        }
        // dd($request['authority2']);
        // if(isset($request['authority1'])){
        //     DB::table('user')->whereIn('USER_ID',$request['authority1'])->update(['AUTHORITY_ID'=>1]);
        //     // DB::table('user')->whereNotIn('USER_ID',$request['authority1'])->update(['AUTHORITY_ID'=>NULL]);
        // }
        // if(isset($request['authority2'])){
        //     DB::table('user')->whereIn('USER_ID',$request['authority2'])->update(['AUTHORITY_ID'=>2]);
        //     // DB::table('user')->whereNotIn('USER_ID',$request['authority2'])->update(['AUTHORITY_ID'=>NULL]);
        // }
        // if(isset($request['authority3'])){
        //     DB::table('user')->whereIn('USER_ID',$request['authority3'])->update(['AUTHORITY_ID'=>3]);
        //     // DB::table('user')->whereNotIn('USER_ID',$request['authority3'])->update(['AUTHORITY_ID'=>NULL]);
        // }
        return redirect('manageaccount');
    }


    public function Passdata($id,$chk){
        //     DB::table('user')->whereIn('USER_ID',$request['authority3'])->update(['AUTHORITY_ID'=>3]);
        if($chk==1){
            DB::table('managerauthority')->where('USER_ID',$id)->delete();

        }
        if($chk==2){
            DB::table('directorauthority')->where('USER_ID',$id)->delete();

        }
        if($chk==3){
            DB::table('adminauthority')->where('USER_ID',$id)->delete();

        }
       
        return "0";
        // DB::table('user')->where('USER_ID', $USER_ID)->delete();
        // return redirect()->route('manageaccount');
    }

   
  
}