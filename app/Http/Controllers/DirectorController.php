<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;
use Session;

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

    public static function Dateformat($var){
        $date = date_format(date_create($var),'d-m-Y');
        $day = explode('-',date_format(date_create($var), 'Y-m-d'));/////var is column name
    
        $year = $day[0]+543;
       
        $date_text = $day[2].'-'.$day[1].'-'.$year;
        // dd($date_text);
        return $date_text;

    }

    public function SearchLeaveReportDirector(Request $request){
        $odl = (((int)$request->year)-543)-1;
        $year = (((int)$request->year)-543);
        if($request->round==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }
        

        $sql = \App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                            ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                            ->whereBetween('ABSENT_START', [$datestart, $dateend])
                            ->where('user.DEP_ID', '=', Session::get('userdep'))
                            ->orderBy('ABSENT_START','DESC')->get();

       
        if(count($sql)==0){
            return 1;
        }else{
            echo ' 
                    <table id="responsive-table" class="display table dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr style="text-align: center">
                                <td>ลำดับที่</td>
                                <td>วันที่ยื่นเรื่องลา</td>
                                <td>ชื่อ - นามสกุล</td>
                                <td>รายการลา</td>
                                <td>ไฟล์แนบ</td>
                                <td>ผลการลา</td>
                                <td>หมายเหตุ</td>
                            
                            </tr>
                        </thead>
                        <tbody>';
                            $i=1;
                            if(count($sql)>0){
                                foreach ($sql as $item){
                                    echo '<tr style="text-align: center">
                                                <td><br>'.$i.'</td>
                                                <td><br>'.self::Dateformat($item->created_at).'</td>
                                                <td><br>'.$item->USER_FNAME.' - '.$item->USER_LNAME.'</td>';
                                                
                                                if(!empty($item->ABSENT_END)){
                                                    echo '<td>'.$item->ABSENTTYPE_NAME.'<br>'.self::Dateformat($item->ABSENT_START).' ถึง '.self::Dateformat($item->ABSENT_END).'<br>จำนวน '.$item->ABSENT_NUMBER.' วัน</td>';
                                                }else{
                                                    echo '<td>'.$item->ABSENTTYPE_NAME.'<br>'.self::Dateformat($item->ABSENT_START).' <br>จำนวน '.$item->ABSENT_NUMBER.' วัน</td>';
                                                }
                                                if(!empty($item->ABSENT_FILE)){
                                                    echo ' <td align="center"><br>&nbsp;&nbsp;<a href="assets/fileupload/'.$item->ABSENT_FILE.'" download type="button" class="btn btn-outline-primary btn-sm"><i class="feather icon-file-text"></i>โหลดไฟล์แนบ</a></td>';
                                                }else{
                                                    echo ' <td align="center"><br>-</td>';
                                                }

                                                if($item->STATUS_APPROVER==3){
                                                    echo ' <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยหัวหน้าฝ่าย</td>
                                                        <td style="text-align: center;color:red"><br>&nbsp;&nbsp;'.$item->APPROVER_COMMENT.'</td>   ';
                                                }else if($item->STATUS_APPROVER==5){
                                                    echo ' <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยผู้อำนวยการ</td>
                                                            <td style="text-align: center;color:red"><br>&nbsp;&nbsp;'.$item->APPROVER_COMMENT.'</td>   ';
                                                }else if($item->STATUS_APPROVER==2){
                                                    echo ' <td  style="text-align: center;color:blue"><br>รออนุมัติจากผู้อำนวยการ</td>
                                                            <td align="center"></td>';
                                                }else if($item->STATUS_APPROVER==4){
                                                    echo ' <td align="center"><br><span class="badge badge-pill badge-success">อนุมัติ</span></td>
                                                            <td align="center"></td>';
                                                }else if($item->STATUS_APPROVER==0){
                                                    echo ' <td style="text-align: center;color:blue"><br>รออนุมัติจากหัวหน้าฝ่าย</td>
                                                            <td align="center"></td>';
                                                }else{
                                                    echo ' <td style="text-align: center;color:red"><br>ยกเลิกโดยผู้ใช้</td>
                                                            <td style="text-align: center;color:red"><br>&nbsp;&nbsp;'.$item->ABSENT_CANCLE.'</td>';
                                                }
                                    echo '  </tr>';
                                    $i=$i+1;
                                }
                            }
                           
                        echo '</tbody>
                    </table>
            ';
        }
        
    }


    public function SearchWorkReportDirector(Request $request){
        $odl = (((int)$request->year)-543)-1;
        $year = (((int)$request->year)-543);
        if($request->round==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }
        

        $start = DB::Table('user')->where('DEP_ID',Session::get('userdep'))->where('USER_ID','!=',Session::get('userid'))->get();
        $pluck = $start->pluck('USER_EMP_ID');

        $sql = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                ->whereIn('EmpCode',$pluck)->orderBy('EmpCode','ASC')->get();

       
        if(count($sql)==0){
            return 1;
        }else{
            echo ' 
            <div class="col-md-12">
                
            <hr style="background-color: #3f4d67;width:900px">
            <br> <br>
                    <table id="responsive-table" class="display table dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr style="text-align: center">
                                <td>ลำดับที่</td>
                                <td>วันที่</td>
                                <td>ชื่อ - นามสกุล</td>
                                <td>เวลาเข้างาน</td>
                                <td>เวลาออกงาน</td>
                                <td>หมายเหตุ</td>
                            </tr>
                        </thead>
                        <tbody>';
                            $i=1;
                            if(count($sql)>0){
                                foreach ($sql as $item){
                                    echo '<tr style="text-align: center">
                                                <td><br>'.$i.'</td>
                                                <td><br>'.self::Dateformat($item->workDate).'</td>
                                                <td><br>'.$item->EmpName.'</td>
                                                <td><br>'.(!empty($item->inTime)?$item->inTime:'-').'</td>
                                                <td><br>'.(!empty($item->outTime)?$item->outTime:'-').'</td>
                                                <td><br>'.(!empty($item->comment)?$item->comment:'-').'</td>
                                    </tr>';
                                    $i=$i+1;
                                }
                            }
                           
                        echo '</tbody>
                    </table>
                    </div>
            ';
        }
        
    }


    public function SearchworkSummary(Request $request){
        $odl = (((int)$request->year)-543)-1;
        $year = (((int)$request->year)-543);
        if($request->round==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }
        
        $sql = DB::Table('user')->where('DEP_ID',Session::get('userdep'))->where('USER_ID','!=',Session::get('userid'))->get();
       
      
  
        if(count($sql)>0){


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
                                if(count($sql )>0){
                                    foreach ($sql  as $item){
                                        $sql2 = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                                                    ->where('processType',1)->where('EmpCode',$item->USER_EMP_ID)->get();
                                        $sql3 = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                                                    ->where('processType',4)->where('EmpCode',$item->USER_EMP_ID)->get(); //late
                        
                                        
                                        $sick = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                                                        ->whereBetween('ABSENT_START', [$datestart, $dateend])
                                                        ->where('ABSENTYPE_ID',1)->where('APPROVER_CHECK',1)->whereIn('STATUS_APPROVER',[0,2,4,6])
                                                        ->where('USER_ID', '=',$item->USER_ID)->groupBy('USER_ID')->first();

                                        $private = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                                                        ->whereBetween('ABSENT_START', [$datestart, $dateend])
                                                        ->where('ABSENTYPE_ID',1)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                                                        ->where('USER_ID', '=',$item->USER_ID)->groupBy('USER_ID')->first();

                                        $vacation = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                                                        ->whereBetween('ABSENT_START', [$datestart, $dateend])
                                                        ->where('ABSENTYPE_ID',2)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                                                        ->where('USER_ID', '=',$item->USER_ID)->groupBy('USER_ID')->first();

                                        $matt = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                                                        ->whereBetween('ABSENT_START', [$datestart, $dateend])
                                                        ->where('ABSENTYPE_ID',3)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                                                        ->where('USER_ID', '=',$item->USER_ID)->groupBy('USER_ID')->first();

                                        $baby= \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                                                        ->whereBetween('ABSENT_START', [$datestart, $dateend])
                                                        ->where('ABSENTYPE_ID',4)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                                                        ->where('USER_ID', '=',$item->USER_ID)->groupBy('USER_ID')->first();

                                        $ordi = \App\Absent::select(DB::raw("SUM(ABSENT_NUMBER) as countday"),DB::raw("COUNT(*) as countterm"))
                                                        ->whereBetween('ABSENT_START', [$datestart, $dateend])
                                                        ->where('ABSENTYPE_ID',5)->where('APPROVER_CHECK',2)->whereIn('STATUS_APPROVER',[0,2,4,6])
                                                        ->where('USER_ID', '=',$item->USER_ID)->groupBy('USER_ID')->first();


                                            echo '<tr style="text-align: center"> 
                                                    <td>'.$item->USER_FNAME.' - '.$item->USER_LNAME.'</td>
                                                            
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
                                    }
                                }
                                        
                                
                            
                                echo '</tbody>
                            </table>
                        </div>
                    </div>
                
                </div>
            ';


        }else{

            return 1;


        }
      
                    
        
    }

}