<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;
use Session;

class ManagerController extends Controller
{

    public function ApproveLeaveManager(Request $request)
    {
        // dd($request->all());
       
        if($request->position==0){
            if($request->approvestatus==2){
                DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid1)->update(['STATUS_APPROVER'=>2]);
            }else{
                DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>3,'APPROVER_COMMENT'=>$request->APPROVER_COMMENT]);
            }

            return redirect('approvemanager')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');

        }else{
            if($request->approvestatus==2){
                DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid1)->update(['STATUS_APPROVER'=>4]);
            }else{
                DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>5,'APPROVER_COMMENT'=>$request->APPROVER_COMMENT]);
            }

            return redirect('approvedirector')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');

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
    


    public function SearchLeaveReportDepid(Request $request){
        $odl = (((int)$request->year)-543)-1;
        $year = (((int)$request->year)-543);
        if($request->round==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }
        if($request->typedata==1){

            $sql = \App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                                ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                                ->whereBetween('ABSENT_START', [$datestart, $dateend])
                                // ->Where('ABSENT_START', '>=', $datestart)
                                // ->where('ABSENT_END', '<=', $dateend)
                                ->where('absentdetail.USER_ID', '=', Session::get('userid'))
                                
                                ->orderBy('ABSENT_START','DESC')->get();

        }else{

            $sql = \App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                                ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                                ->whereBetween('ABSENT_START', [$datestart, $dateend])
                                // ->Where('ABSENT_START', '>=', $datestart)
                                // ->where('ABSENT_END', '<=', $dateend)
                                ->where('user.DEP_ID', '=', Session::get('userdep'))
                                ->where('absentdetail.USER_ID', '!=', Session::get('userid'))
                                
                                ->orderBy('ABSENT_START','DESC')->get();

        }
        // dd($datestart.'----'.$dateend);
       

        // dd($sql );
       
        if(count($sql)==0){
            return 1;
        }else{
            echo ' 
                    <table id="responsive-table" class="display table dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr style="text-align: center">
                                <td>ลำดับที่</td>
                                <td>วันที่ยื่นเรื่องลา</td>';
                                if($request->typedata!=1){
                                    echo ' <td>ชื่อ - นามสกุล</td>';
                                }
                                
                        echo '  <td>รายการลา</td>
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
                                                <td><br>'.self::Dateformat($item->created_at).'</td>';
                                                if($request->typedata!=1){
                                                    echo '<td><br>'.$item->USER_FNAME.' - '.$item->USER_LNAME.'</td>';
                                                }
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



    public function SearchWorkeport(Request $request){
        $odl = (((int)$request->year)-543)-1;
        $year = (((int)$request->year)-543);
       
       
        if($request->round==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }
        if($request->typedata==1){
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
            
            $sql = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                        ->where('EmpCode',$start->USER_EMP_ID)->get();
           

        }else{
            $start = DB::Table('user')->where('DEP_ID',Session::get('userdep'))->where('USER_ID','!=',Session::get('userid'))->get();
            $pluck = $start->pluck('USER_EMP_ID');

            $sql = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                    ->whereIn('EmpCode',$pluck)->orderBy('EmpCode','ASC')->get();
           
        }
      
       
        if(count($sql)==0){
            return 1;
        }else{
            echo ' 
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
            ';
        }
        
    }


    public function Index(){
    

        $month = intval(date('m'));
        if($month>=4&&$month<=9){
            $x=2; //round
        }else{
            $x=1;
        }
        $title = date('Y');
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

       


       
        return view('manager.indexmanager',$data);
    }


    public function Detailmanager(Request $request){
        $sql = DB::Table('absentdetail')->leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                    ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                    ->where('absentdetail.ABSENT_ID',$request->id)
                    ->first();

        echo '
        
                    <div class="form-group row">
                        <div class="col-3">
                            <label for="recipient-name" class="col-form-label">ชื่อ นามสกุล</label>

                        </div>
                        <div class="col-5">';
                        if(!empty($sql->USER_DISPLAYNAME)){
                            echo '<p style="margin-top: 5px">'.$sql->USER_DISPLAYNAME.'</p>';

                        }else{
                            echo '<p style="margin-top: 5px">'.$sql->USER_FNAME.' - '.$sql->USER_LNAME.'</p>';

                        }
                            
                        echo '</div>

                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <label for="recipient-name" class="col-form-label">วันที่ยื่นเรื่องลา</label>

                        </div>
                        <div class="col-3">
                            <p style="margin-top: 5px">'.self::Dateformat($sql->created_at).'</p>

                        
                        
                        </div>

                    </div>


                    <div class="form-group row">
                        <div class="col-3">
                            <label for="recipient-name" class="col-form-label">ระยะวันที่ลา</label>
                        </div>
                        <div class="col-5">';
                        if($sql->ABSENT_NUMBER>1){
                            echo '<p style="margin-top: 7px">'.self::Dateformat($sql->ABSENT_START).' - '.self::Dateformat($sql->ABSENT_END).'</p>';

                        }else{
                            echo ' <p style="margin-top: 7px">'.$sql->ABSENT_START.'</p>';

                        }
                        echo '</div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <label for="recipient-name" class="col-form-label">จำนวนวันลา</label>
                        </div>
                        <div class="col-3">
                            <p style="margin-top: 7px">'.$sql->ABSENT_NUMBER.' วัน</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <label for="recipient-name" class="col-form-label">ประเภทการลา</label>
                        </div>
                        <div class="col-5">
                            <p style="margin-top: 7px">'.$sql->ABSENTTYPE_NAME.'</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-3">
                            <label for="recipient-name" class="col-form-label">เหตุผล</label>
                        </div>
                        <div class="col-6">';
                        if(!empty($sql->ABSENT_REASON)){
                            echo '<p style="margin-top: 7px">'.$sql->ABSENT_REASON.'</p>';
                        }else{
                            echo '<p style="margin-top: 7px">-</p>';

                        }
                        echo '</div>
                    </div>';

        
        
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
        
        if($request->typedata==1){
            $sql = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
          
           

        }else{
            $sql = DB::Table('user')->where('DEP_ID',Session::get('userdep'))->where('USER_ID','!=',Session::get('userid'))->get();
           
           
        }

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
          
        </div>';


        }else{

            return 1;


        }
      
                    
        
    }

}