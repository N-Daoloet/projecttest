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
        dd($request->all());
        $absent = new Absent;
        $absent->USER_ID = Session::get('userid');   
        $absent->STATUS_APPROVER = 0; 
        $absent->ABSENT_PHONE = $request->ABSENT_PHONE; 
  
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
        if(isset($request->ABSENT_TIMESTART)){   
            $absent->ABSENT_TIMESTART = $request->ABSENT_TIMESTART;
        }
        if(isset($request->ABSENT_TIMEEND)){   
            $absent->ABSENT_TIMEEND = $request->ABSENT_TIMEEND;
        }

        if($request->ABSENTYPE_ID==1){
            $validator = Validator::make($request->all(), [
                'file' => 'mimes:pdf',
            ]);
            
            $messages = $validator->messages();
            if ($validator->fails())
            {
                return back()->with('success','กรุณาอัพโหลดเฉพาะไฟล์ PDF ขนาดไม่เกิน 5MB');
    
            }else{
                
                if(isset($request->ABSENT_REASON)){   
                    $absent->ABSENT_REASON = $request->ABSENT_REASON;
                }
                if(isset($request->daytype)){   
                    $absent->ABSENT_HAFT = $request->daytype;
                }
                $newFilename = time().$request->file->getClientOriginalName();
                $request->file->move(public_path('assets\fileupload'), $newFilename);
                $absent->ABSENT_FILE =  $newFilename;
    
                $absent->save();
                return redirect('sickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }
        }elseif($request->ABSENTYPE_ID==2){
            
            if(isset($request->daytype)){   
                $absent->ABSENT_HAFT = $request->daytype;
            }
            $absent->save();
            return redirect('vacationleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
            

        }elseif($request->ABSENTYPE_ID==3){
           
            
            if(isset($request->ABSENT_REASON)){   
                $absent->ABSENT_REASON = $request->ABSENT_REASON;
            }
            if(isset($request->daytype)){   
                $absent->ABSENT_HAFT = $request->daytype;
            }
            $absent->save();
            return redirect('privateleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');


        }elseif($request->ABSENTYPE_ID==4){
           
            if(isset($request->ABSENT_REASON)){   
                $absent->ABSENT_REASON = $request->ABSENT_REASON;
            }
            $absent->save();
            return redirect('maternityleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');

        }elseif($request->ABSENTYPE_ID==5){
            
            if(isset($request->ABSENT_BABY)){  
                   
                $absent->ABSENT_BABY = $request->ABSENT_BABY;
            }
            if(isset($request->ABSENT_WIFE)){  
                   
                $absent->ABSENT_WIFE = $request->ABSENT_WIFE;
            }
            $absent->save();
            return redirect('babyuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
        }elseif($request->ABSENTYPE_ID==6){
           
            $absent->save();
            return redirect('ordinationleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
        }
      

        
    }

    public function Cancleofid(Request $request)
    {
        // dd($request->all());
        DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>1,'ABSENT_CANCLE'=>$request->ABSENT_CANCLE]);
        return redirect('cancelsickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }


    public static function Dateformat($var){
        $date = date_format(date_create($var),'d-m-Y');
        $day = explode('-',date_format(date_create($var), 'Y-m-d'));/////var is column name
    
        $year = $day[0]+543;
       
        $date_text = $day[2].'-'.$day[1].'-'.$year;
        // dd($date_text);
        return $date_text;

    }
   

}