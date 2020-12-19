<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;

class AdminController extends Controller
{

    public function updateimage(Request $request){
        if($request->preview_image !== null){
            $imageName = time().'.'.$request->preview_image->extension();  
            $request->preview_image->move(public_path('assets\images\Banner'), $imageName);
            DB::Table('banner')->where('id_banner',$request->id_banner)->update(['image'=>$imageName]);
        }
        return redirect('addimage')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
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

    public function ChangeStatusUser($chk,$id){
        if($chk==1){
            DB::table('user')->where('USER_ID', $id)->update(['USER_STATUS' => NULL]);
        }else{
            DB::table('user')->where('USER_ID', $id)->update(['USER_STATUS' => 1]);
        }
    }

    public function manageraccount(Request $request){
        $data = array(
            "sql" => DB::table('user')
            ->where('DEP_ID',$request->department)
            ->where('PERTYPE_ID',$request->person)
            ->orderBy('USER_STATUS','DESC')
            ->get(),
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
                $sql = DB::table('managerauthority')->where('USER_ID',$data)->first();
                if(empty($sql)){
                    DB::table('managerauthority')->insert(['USER_ID'=>$data]);
                }
            }
        }
        if(isset($request['authority2'])){
            foreach($request['authority2'] as $data){
                $sql = DB::table('directorauthority')->where('USER_ID',$data)->first();
                if(empty($sql)){
                    DB::table('directorauthority')->insert(['USER_ID'=>$data]);
                }
            }
        }
        if(isset($request['authority3'])){
            foreach($request['authority3'] as $data){
                // DB::table('user')->where('USER_ID',$data)->update(['AUTHORITY_ID'=>3]);
                $sql = DB::table('adminauthority')->where('USER_ID',$data)->first();
                if(empty($sql)){
                    DB::table('adminauthority')->insert(['USER_ID'=>$data]);
                }
            }
        }
        return redirect('manageaccount');
    }


    public function Passdata($id,$chk){
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
    }

    
    public function UpdateLimitAbsent(Request $request){
        // dd($request->all());
        $year = intval(date("Y"))+543;
        DB::table('limitabsenttype')->where('LIMITABSENTTYPE_ID', $request->LIMITABSENTTYPE_ID)->update(['LIMITABSENTTYPE_NUMBER' => $request->number,'LIMITABSENTTYPE_BUDGETYEAR'=>$year]);
        return redirect('dayleave')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }
  
}