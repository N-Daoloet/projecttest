<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use App\Absent;
use Session;
use Validator;

class UserController extends Controller
{
    public function SaveAbsent(Request $request){
        
        $validator = Validator::make($request->all(), [
            'file' => 'mimes:pdf',
        ]);
        // $validator = Validator::make(
        //     [
        //     'file' => 'mimes|pdf',
        //     ]
        // );
        $messages = $validator->messages();
        if ($validator->fails())
        {
            return back()->with('success','กรุณาอัพโหลดเฉพาะไฟล์ PDF ขนาดไม่เกิน 5MB');

        }else{
            $absent = new Absent;
        // dd($request->ABSENT_REASON);
            $absent->USER_ID = Session::get('userid');   
            $absent->STATUS_APPROVER = 0;   
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
            $newFilename = time().$request->file->getClientOriginalName();
            $request->file->move(public_path('assets\fileupload'), $newFilename);
            $absent->ABSENT_FILE =  $newFilename;

            // $absent->save();
            return redirect('sickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');

        }
        // if($request->certificate !== null){
        //     $newFilename = 'StoreBusiness/'.time().$request->certificate->getClientOriginalName();
        //     Storage::put($newFilename, file_get_contents($request->certificate));
        //     $StoreBusinessContent->certificate = $newFilename;
        //     }
                

                $RequestItem->filepath = $newFilename;

        
    }

    public function Cancleofid(Request $request)
    {
        // dd($request->all());
        DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>1,'ABSENT_CANCLE'=>$request->ABSENT_CANCLE]);
        return redirect('cancelsickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }
   

}