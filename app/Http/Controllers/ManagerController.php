<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;

class ManagerController extends Controller
{

    public function ApproveLeaveManager(Request $request)
    {
        // dd($request->all());
        if($request->approvestatus==2){
            DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid1)->update(['STATUS_APPROVER'=>2]);
        }else{
            DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>3,'APPROVER_COMMENT'=>$request->APPROVER_COMMENT]);
        }
        return redirect('approvemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }

}