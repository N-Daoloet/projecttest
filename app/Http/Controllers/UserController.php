<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use App\Absent;
use Session;

class UserController extends Controller
{
    public function SaveAbsent(Request $request){
        $absent = new Absent;
        // dd(Session::get('userid'));
        
        $absent->USER_ID = Session::get('userid');   
        
        if(isset($request->ABSENTYPE_ID)){
            $absent->ABSENTYPE_ID = $request->ABSENTYPE_ID;   
        }
        if(isset($request->ABSENT_START)){   
            $absent->ABSENT_START = $request->ABSENT_START;
        }
        if(isset($request->ABSENT_END)){
            $absent->ABSENT_END = $request->ABSENT_END;
        }
        if(isset($request->ABSENT_NUMBER)){       
            $absent->ABSENT_NUMBER = $request->ABSENT_NUMBER;
        }
        if(isset($request->ABSENT_REASON)){   
            $absent->ABSENT_REASON = $request->ABSENT_REASON;
        }
        
        if($request->preview_image !== null){
            $newFilename = 'Usersick/'.time().$request->preview_image->getClientOriginalName();
            Storage::put($newFilename, file_get_contents($request->preview_image));
            $absent->ABSENT_IMAGE = $newFilename;
        }
        $absent->save();
        return redirect('sickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function Cancleofid(Request $request)
    {
        // dd($request->all());
        DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>3,'ABSENT_CANCLE'=>$request->ABSENT_CANCLE]);
        return redirect('cancelsickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }
   

}