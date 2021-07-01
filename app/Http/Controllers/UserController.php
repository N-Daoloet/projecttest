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
        // dd($request->all());
        $absent = new Absent;
        $absent->USER_ID = Session::get('userid');   
        $absent->created_at = date('Y-m-d H:i:s'); 
        $absent->updated_at = date('Y-m-d H:i:s'); 
        
        if($request->position==0){
            $absent->STATUS_APPROVER = 0; 

        }else{
            $absent->STATUS_APPROVER = 2; 

        }
        $absent->ABSENT_PHONE = $request->ABSENT_PHONE; 
        $absent->ABSENTYPE_ID = $request->ABSENTYPE_ID;   
        $absent->ABSENT_START = $request->ABSENT_START;

        if((int)$request->ABSENT_NUMBER>1){
            $absent->ABSENT_END = $request->ABSENT_END;

        }
       

        $absent->ABSENT_NUMBER = $request->ABSENT_NUMBER;
        
        // if(isset($request->ABSENT_TIMESTART)){   
        //     $absent->ABSENT_TIMESTART = $request->ABSENT_TIMESTART;
        // }
        // if(isset($request->ABSENT_TIMEEND)){   
        //     $absent->ABSENT_TIMEEND = $request->ABSENT_TIMEEND;
        // }

        if($request->ABSENTYPE_ID==1){
            if($request->private==0){

                if(isset($request->file)){


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
                        $request->file->move(public_path('assets/fileupload'), $newFilename);
                        $absent->ABSENT_FILE =  $newFilename;
                        $absent->APPROVER_CHECK = 1;
            
                        // $absent->save();
    
                       
                    }
    
    
                }else{
    
                    if(isset($request->ABSENT_REASON)){   
                        $absent->ABSENT_REASON = $request->ABSENT_REASON;
                    }
                    if(isset($request->daytype)){   
                        $absent->ABSENT_HAFT = $request->daytype;
                    }
                    $absent->APPROVER_CHECK = 1;
                   
        
                    // $absent->save();
                   
                }
            }else{
                 
                $absent->APPROVER_CHECK = 2;
                

                if(isset($request->ABSENT_REASON)){   
                    $absent->ABSENT_REASON = $request->ABSENT_REASON;
                }
                if(isset($request->daytype)){   
                    $absent->ABSENT_HAFT = $request->daytype;
                }
                // $absent->save();

            }

            
            $absent->save();

            if($request->position==0){
                if($request->private==0){
                    return redirect('sickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');

                }else{
                    return redirect('privateleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');

                }
    
            }else{
                if($request->private==0){
                    return redirect('sickleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');

                }else{
                    return redirect('privateleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');

                }
    
            }

            

        }elseif($request->ABSENTYPE_ID==2){
            
            if(isset($request->daytype)){   
                $absent->ABSENT_HAFT = $request->daytype;
            }
            $absent->save();

            if($request->position==0){
                return redirect('vacationleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');
    
            }else{
                return redirect('vacationleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');
    
            }

        // }
        // elseif($request->ABSENTYPE_ID==3){
           
            
        //     if(isset($request->ABSENT_REASON)){   
        //         $absent->ABSENT_REASON = $request->ABSENT_REASON;
        //     }
        //     if(isset($request->daytype)){   
        //         $absent->ABSENT_HAFT = $request->daytype;
        //     }
        //     $absent->save();
        //     return redirect('privateleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');


        }elseif($request->ABSENTYPE_ID==3){  //ลาคลอด
            if(isset($request->daytype)){   
                $absent->ABSENT_HAFT = $request->daytype;
            }
            if(isset($request->ABSENT_REASON)){   
                $absent->ABSENT_REASON = $request->ABSENT_REASON;
            }
            $absent->save();

            if($request->position==0){
                return redirect('maternityleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');
    
            }else{
                return redirect('maternityleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');
    
            }



        }elseif($request->ABSENTYPE_ID==4){ //ลาช่วยคลอด
            
            if(isset($request->ABSENT_BABY)){  
                   
                $absent->ABSENT_BABY = $request->ABSENT_BABY;
            }
            if(isset($request->ABSENT_WIFE)){  
                   
                $absent->ABSENT_WIFE = $request->ABSENT_WIFE;
            }
            if(isset($request->daytype)){   
                $absent->ABSENT_HAFT = $request->daytype;
            }

            $absent->save();

            if($request->position==0){
                return redirect('babyuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');
    
            }else{
                return redirect('babymanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');
    
            }


        }elseif($request->ABSENTYPE_ID==5){ //ลาบวช
           
            $absent->save();

            if($request->position==0){
                return redirect('ordinationleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');
    
            }else{
                return redirect('ordinationleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว รออนุมัติ');
    
            }

        }
      

        
    }

    public function Cancleofid(Request $request)
    {
        // dd($request->all());
        DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>1,'ABSENT_CANCLE'=>$request->ABSENT_CANCLE]);
        if($request->position==0){
            if($request->typeabsent==1){

                return redirect('cancelsickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==2){
                return redirect('cancelvacationleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==3){
                return redirect('cancelmaternityleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==4){
                return redirect('cancelbabyuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==5){
                return redirect('cancelordinationleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==6){
                return redirect('cancelsickleaveuser')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }
        }else{
            if($request->typeabsent==1){

                return redirect('cancelsickleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==2){
                return redirect('cancelvacationleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==3){
                return redirect('cancelmaternityleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==4){
                return redirect('cancelbabymanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==5){
                return redirect('cancelordinationleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }else if($request->typeabsent==6){
                return redirect('cancelsickleavemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    
            }
        }
        
    }


    public static function Dateformat($var){
        $date = date_format(date_create($var),'d-m-Y');
        $day = explode('-',date_format(date_create($var), 'Y-m-d'));/////var is column name
    
        $year = $day[0]+543;
       
        $date_text = $day[2].'-'.$day[1].'-'.$year;
        // dd($date_text);
        return $date_text;

    }




    public function Calculatedate(Request $request){
        
        $strStartDate = $request->dstart;
        $strEndDate = $request->dend;
        $check = 0;
        $intWorkDay = 0;
        $intHoliday = 0;
        $intPublicHoliday = 0;
        $intTotalDay = ((strtotime($strEndDate) - strtotime($strStartDate))/  ( 60 * 60 * 24 )) + 1; 

        while (strtotime($strStartDate) <= strtotime($strEndDate)) {
            // $check++;
            $DayOfWeek = date("w", strtotime($strStartDate));
            // $strSQL = DB::connection('sqlsrv')->table('dbo.Holiday')->where('HolidayDate',$strStartDate)->get();
            
            if($DayOfWeek == 0 or $DayOfWeek ==6)  // 0 = Sunday, 6 = Saturday;
            {
                $intHoliday++;
                // $check = 0;
                
            }
            elseif(self::CheckPublicHoliday($strStartDate))
            {
                $intPublicHoliday++;
                
            }
            else
            {
                $intWorkDay++;
                
            }
            //$DayOfWeek = date("l", strtotime($strStartDate)); // return Sunday, Monday,Tuesday....

            $strStartDate = date ("Y-m-d", strtotime("+1 day", strtotime($strStartDate)));
        }
       

        return $intWorkDay;

    }

    public function CheckPublicHoliday($strChkDate){
        $strSQL = DB::connection('sqlsrv')->table('dbo.Holiday')->where('HolidayDate',$strChkDate)->get();
    
        if(count($strSQL)>0)
        {
            return true;
        }
        else
        {
            return false;
        }
       
    }


    public function Index(){
        date_default_timezone_set('Asia/Bangkok');
        $title = date('Y');
        $month = intval(date('m'));
        if($month>=4&&$month<=9){
            $x=2; //round
        }else{
            $x=1;
        }

        $y = (int)date("Y")+543;
        $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();

        $odl = ((int)$title)-1;
        $year = ((int)$title);
        if($x==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }


        // $datestart = '2019-04-1';
        // $dateend =  '2019-04-30';
       
        $first = date("Y-m-d", strtotime("first day of this  month"));
        $last = date("Y-m-d", strtotime("last day of this  month"));
        $sql = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$first, $last])
                ->where('processType',1)->where('EmpCode',$start->USER_EMP_ID)->get();
        $sql1 = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$first, $last])
                ->where('processType',4)->where('EmpCode',$start->USER_EMP_ID)->get(); //late
        

        $sql2 = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                ->where('processType',1)->where('EmpCode',$start->USER_EMP_ID)->get();
        $sql3 = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                ->where('processType',4)->where('EmpCode',$start->USER_EMP_ID)->get(); //late
        

        // dd(count($sql));
       
       

        $sick= DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',1)
                ->whereIn('STATUS_APPROVER',[0,2,4])
                ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                ->first();
        $vacation = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',2)
                ->whereIn('STATUS_APPROVER',[0,2,4])
                ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                ->first();
        $mat = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',3)
                ->whereIn('STATUS_APPROVER',[0,2,4])
                ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                ->first();
        $baby = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',4)
                ->whereIn('STATUS_APPROVER',[0,2,4])
                ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                ->first();
        $dateinterval = date_diff(date_create($start->USER_START_DATE), date_create(date("Y-m-d")));
        
        if((int)$dateinterval->format('%y')>0){
            $limitsick =  DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                        ->where('sickprivate_more',$x)->where('sickprivate_year',$y)
                        ->first();

            $limitvaca = DB::Table('limitvacation')->where('id_group',session::get('usergroup'))->where('vacation_round',$x)
                        ->where('vacation_more',$x)->where('vacation_year',$y)
                        ->first();


        }else{
            if((int)$dateinterval->format('%m')>5){
                $limitsick =  DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                        ->where('sickprivate_more',$x)->where('sickprivate_year',$y)
                        ->first();

                $limitvaca = DB::Table('limitvacation')->where('id_group',session::get('usergroup'))->where('vacation_round',$x)
                        ->where('vacation_more',$x)->where('vacation_year',$y)
                        ->first();

            }else{
                $limitsick =  DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                        ->where('sickprivate_less',$x)->where('sickprivate_year',$y)
                        ->first();

            $limitvaca = DB::Table('limitvacation')->where('id_group',session::get('usergroup'))->where('vacation_round',$x)
                        ->where('vacation_less',$x)->where('vacation_year',$y)
                        ->first();


            }
        }

        

        // dd($limitsick);


       
        $limitmat =  DB::Table('limitmaternity')->where('id_group',session::get('usergroup'))->where('maternity_round',$x)
                        ->where('maternity_year',$y)
                        ->first();
                    
        $limitbaby = DB::Table('limitbaby')->where('id_group',session::get('usergroup'))->where('baby_round',$x)->where('baby_year',$y)->first();
        $ordi = 0;
        $limitordi = 0;


        if(session::get('usergroup')==4){
            $ordi = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',5)
                        ->whereIn('STATUS_APPROVER',[0,2,4])
                        ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                        ->first();

            $limitordi = DB::Table('limitordination')->where('id_group',session::get('usergroup'))
                            ->where('ordination_round',$x)->where('ordination_year',$y)
                            ->first();
                    
        }
        $data = array(

            'data' => DB::Table('user')->where('USER_ID',Session::get('userid'))->first(),
            'sick' => $sick,
            'vacation' => $vacation,
            'baby' => $baby,
            'mat' => $mat,
            'ordi' => $ordi,
            'limitsick' => $limitsick,
            'limitvaca' => $limitvaca,
            'limitmat' => $limitmat,
            'limitbaby' =>$limitbaby,
            'limitordi' =>$limitordi,
            'work' =>count($sql),
            'late' =>count($sql1),
            'workround' =>count($sql2),
            'lateround' =>count($sql3)
        );

       


       
        return view('user.indexuser',$data);
    }


    public function SearchworkReportuser(Request $request){
        $odl = (((int)$request->year)-543)-1;
        $year = (((int)$request->year)-543);
        if($request->round==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }
        
        $sql = DB::Table('user')->where('USER_ID','=',Session::get('userid'))->first();
       
        $sql2 = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                ->where('processType',1)->where('EmpCode',$sql->USER_EMP_ID)->get();
        $sql3 = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                ->where('processType',4)->where('EmpCode',$sql->USER_EMP_ID)->get(); //late


        $sick = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                    ->whereBetween('ABSENT_START', [$datestart, $dateend])
                    ->where('ABSENTYPE_ID',1)->where('APPROVER_CHECK',1)->whereIn('STATUS_APPROVER',[0,2,4,6])
                    ->where('USER_ID', '=',$sql->USER_ID)->groupBy('USER_ID')->first();

        $private = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                    ->whereBetween('ABSENT_START', [$datestart, $dateend])
                    ->where('ABSENTYPE_ID',1)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                    ->where('USER_ID', '=',$sql->USER_ID)->groupBy('USER_ID')->first();

        $vacation = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                    ->whereBetween('ABSENT_START', [$datestart, $dateend])
                    ->where('ABSENTYPE_ID',2)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                    ->where('USER_ID', '=',$sql->USER_ID)->groupBy('USER_ID')->first();

        $matt = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                    ->whereBetween('ABSENT_START', [$datestart, $dateend])
                    ->where('ABSENTYPE_ID',3)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                    ->where('USER_ID', '=',$sql->USER_ID)->groupBy('USER_ID')->first();

        $baby= \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                    ->whereBetween('ABSENT_START', [$datestart, $dateend])
                    ->where('ABSENTYPE_ID',4)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                    ->where('USER_ID', '=',$sql->USER_ID)->groupBy('USER_ID')->first();

        $ordi = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                    ->whereBetween('ABSENT_START', [$datestart, $dateend])
                    ->where('ABSENTYPE_ID',5)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                    ->where('USER_ID', '=',$sql->USER_ID)->groupBy('USER_ID')->first();
        
            


            echo '
        
                <div class="col-md-12">
                <br>
                <hr style="background-color: #3f4d67;width:900px">
                    <div class="card-block table-border-style">
                        <div class="table-responsive">
                            
                            <br><br>
                            <table id="responsive-table" class="table table-bordered">
                                <thead>
                                    <tr style="text-align: center">
                                        <td rowspan="2"><br>ชื่อ - นามสกุล</td>
                                        <td rowspan="2"><br>สาย</td>
                                        <td rowspan="2"><br>ขาด</td>
                                        <td colspan="2"><br>ลาป่วย</td>
                                        <td colspan="2"><br>ลากิจ</td>
                                        <td colspan="2"><br>ลาคลอดบุตร</td>
                                        <td colspan="2"><br>ลาไปช่วยเหลือภริยาที่คลอดบุตร</td>
                                        <td colspan="2"><br>ลาอุปสมบท</td>
                                        <td rowspan="2"><br>ลาพักผ่อน</td>
                                        <td rowspan="2"><br>เหลือ</td>
                                    </tr> 
                                
                                    <tr style="text-align: center">
                                        <td>วัน</td>
                                        <td>ครั้ง</td>
                                        <td>วัน</td>
                                        <td>ครั้ง</td>
                                        <td>วัน</td>
                                        <td>ครั้ง</td>
                                        <td>วัน</td>
                                        <td>ครั้ง</td>
                                        <td>วัน</td>
                                        <td>ครั้ง</td>
                                    </tr>
                                
                                    
                                </thead>
                                <tbody>';
                                if(!empty($sql )){
                                    
                                        


                                    echo '<tr style="text-align: center"> 
                                            <td>'.$sql->USER_FNAME.' - '.$sql->USER_LNAME.'</td>
                                                    
                                            <td>'.count($sql2).'</td>
                                            <td>'.count($sql3).'</td>
                                            <td>'.(!empty($sick->countday)?$sick->countday:'0').'</td>
                                            <td>'.(!empty($sick->countday)?$sick->countterm:'0').'</td>
                                            <td>'.(!empty($private->countday)?$private->countday:'0').'</td>
                                            <td>'.(!empty($private->countday)?$private->countterm:'0').'</td>
                                            <td>'.(!empty($matt->countday)?$matt->countday:'0').'</td>
                                            <td>'.(!empty($matt->countday)?$matt->countterm:'0').'</td>
                                            <td>'.(!empty($baby->countday)?$baby->countday:'0').'</td>
                                            <td>'.(!empty($baby->countday)?$baby->countterm:'0').'</td>
                                            <td>'.(!empty($ordi->countday)?$ordi->countday:'0').'</td>
                                            <td>'.(!empty($ordi->countday)?$ordi->countterm:'0').'</td>
                                            <td>'.(!empty($vacation->countday)?$vacation->countday:'0').'</td>
                                            <td>'.(!empty($vacation->countday)?$vacation->countterm:'0').'</td>
                                                
                                            
                                    </tr>';
                                    
                                }else{
                                    return 1;
                                }
                                        
                                
                            
                                echo '</tbody>
                            </table>
                        </div>
                    </div>
                
                </div>
            ';


       
      
                    
        
    }

   

}