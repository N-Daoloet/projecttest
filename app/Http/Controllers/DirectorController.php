<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;

class DirectorController extends Controller
{

    public function ApproveLeaveDirector(Request $request)
    {
        // dd($request->all());
        if($request->approvestatus==4){
            DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid1)->update(['STATUS_APPROVER'=>4]);
        }else{
            DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>5,'APPROVER_COMMENT'=>$request->APPROVER_COMMENT]);
        }
        return redirect('approvedirector')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }

}