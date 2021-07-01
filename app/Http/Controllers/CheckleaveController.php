<?php

namespace App\Http\Controllers;

use DB;
use Image;
use Storage;
use App\Absent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckleaveController extends Controller
{ 
   
    public function Search(Request $request){
        $year=0;
        if($request->year<=2564){
            $year = $request->year;
        }else{
            $year = $request->year-1;

        }

        $group = DB::Table('group_personal')->where('id_personal',$request->perid)->first();
        // dd($year)/;
        $sick1 = DB::Table('limitsickprivate')->where('id_group',$group->id_group)->where('sickprivate_less',NULL)->where('sickprivate_more',NULL)
                    ->where('sickprivate_year',$year)->where('sickprivate_round',1)->first();
        $sick2 = DB::Table('limitsickprivate')->where('id_group',$group->id_group)->where('sickprivate_less',NULL)->where('sickprivate_more',NULL)
                    ->where('sickprivate_year',$year)->where('sickprivate_round',2)->first();

        $vacation1 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_less',NULL)->where('vacation_more',NULL)
                    ->where('vacation_year',$year)->where('vacation_round',1)->first();
        $vacation2 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_less',NULL)->where('vacation_more',NULL)
                    ->where('vacation_year',$year)->where('vacation_round',2)->first();

        // $data3 = DB::Table('limitprivate')->leftJoin('group_personal','limitprivate.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('private_year',$year)->get();
        
        //ลาคลอด
        $data41 = DB::Table('limitmaternity')->where('id_group',$group->id_group)->where('maternity_round',1)->where('maternity_year',$year)->first();
        $data42 = DB::Table('limitmaternity')->where('id_group',$group->id_group)->where('maternity_round',2)->where('maternity_year',$year)->first();

        $data51 = DB::Table('limitbaby')->where('id_group',$group->id_group)->where('baby_round',1)->where('baby_year',$year)->first();
        $data52 = DB::Table('limitbaby')->where('id_group',$group->id_group)->where('baby_round',2)->where('baby_year',$year)->first();

        $data61 = DB::Table('limitordination')->where('id_group',$group->id_group)->where('ordination_round',1)->where('ordination_year',$year)->first();
        $data62 = DB::Table('limitordination')->where('id_group',$group->id_group)->where('ordination_round',2)->where('ordination_year',$year)->first();
        // dd($request->perid);
            echo '
                    <table class="table table-bordered" style="width:100%">                                        
                        <tr style="text-align: center"> 
                            <td style="width:25% ">ประเภทการลา</td>
                            <td style="width:10% ">จำนวนครั้งสูงสุด</td>
                            <td style="width:10% " >จำนวนวันลาสูงสุด</td>
                            <td style="width:10% ">รอบ</td> 
                            <td style="width:35% !important">การจัดการ</td> 
                        </tr>
                        <tbody>';


                        // ลาป่วย + ลากิจส่วนตัว
                        if($request->perid==3 || $request->perid==4 ){
                            $less1 = DB::Table('limitsickprivate')->where('id_group',$group->id_group)->where('sickprivate_year',$year)
                                            ->where('sickprivate_less',1)->first();
                            $less2 = DB::Table('limitsickprivate')->where('id_group',$group->id_group)->where('sickprivate_year',$year)
                                            ->where('sickprivate_less',2)->first();


                            $more1 = DB::Table('limitsickprivate')->where('id_group',$group->id_group)->where('sickprivate_year',$year)
                                            ->where('sickprivate_more',1)->first();
                            $more2 = DB::Table('limitsickprivate')->where('id_group',$group->id_group)->where('sickprivate_year',$year)
                                        ->where('sickprivate_more',2)->first();
                                            // dd( $more);

                            echo '
                                    <tr>
                                        <td colspan="4" style="text-align: center">ลาป่วย + ลากิจส่วนตัว</td>
                                        <td style="width:35% !important">

                                            <div class="text-center" id="sickedit" style="display: ">
                                                <button class="btn btn-outline-warning" type="button"  onclick="btnedit(1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                            </div>

                                            <div id="sickcancel" style="display: none" class="text-center">
                                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(1);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">  1.1  ลาป่วย + ลากิจ  (น้อยกว่า 6 เดือน)</div></td>
                                        
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">-</div>
                                            
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($less1)?$less1->sickprivate_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput" style="display:none ">
                                                <input type="number" class="form-control" name="sicklesssixlimit1" value="'.(!empty($less1)?$less1->sickprivate_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">-</div>
                                            
                                           
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($less2)?$less2->sickprivate_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput" style="display:none ">
                                                <input type="number" class="form-control" name="sicklesssixlimit2" value="'.(!empty($less2)?$less2->sickprivate_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>

                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">1.2  ลาป่วย + ลากิจ  (มากกว่า 6 เดือน)</div></td>
                                        
                                        <td style="width:10% ">
                                            <div class="text-center"  style="display: ">-</div>
                                            
                                           
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($more1)?$more1->sickprivate_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput"  style="display:none ">
                                                <input type="number" class="form-control" name="sickmoresixlimit1" value="'.(!empty($more1)?$more1->sickprivate_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">-</div>
                                           
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($more2)?$more2->sickprivate_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput" style="display:none ">
                                                <input type="number" class="form-control" name="sickmoresixlimit2" value="'.(!empty($more2)?$more2->sickprivate_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                ';
                                
                            
                        }else if( $request->perid==2){

                            echo '
                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">ลาป่วย + ลากิจส่วนตัว</div></td>
                                        
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($sick1)?$sick1->sickprivate_number:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput" style="display:none ">
                                                <input type="number" class="form-control" name="sicknumber1" value="'.(!empty($sick1)?$sick1->sickprivate_number:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($sick1)?$sick1->sickprivate_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput" style="display:none ">
                                                <input type="number" class="form-control"  name="sicklimit1" value="'.(!empty($sick1)?$sick1->sickprivate_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            <div class="text-center" id="sickedit" style="display: ">
                                                <button class="btn btn-outline-warning" type="button"  onclick="btnedit(1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                            </div>
                                            <div id="sickcancel" style="display: none" class="text-center">
                                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(1);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($sick2)?$sick2->sickprivate_number:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput"  style="display:none ">
                                                <input type="number" class="form-control" name="sicknumber2" value="'.(!empty($sick2)?$sick2->sickprivate_number:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($sick2)?$sick2->sickprivate_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput" style="display:none ">
                                                <input type="number" class="form-control" name="sicklimit2" value="'.(!empty($sick2)?$sick2->sickprivate_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                        
                                        </td>
                                    </tr>
                                ';


                        }else{
                            echo '
                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">ลาป่วย + ลากิจส่วนตัว</div></td>
                                        
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">- </div>
                                            
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($sick1)?$sick1->sickprivate_limit:'-').'
                                                
                                            </div>
                                             
                                            <div class="text-center sickinput" style="display:none ">
                                                <input type="number" class="form-control"  name="sicklimit1" value="'.(!empty($sick1)?$sick1->sickprivate_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            <div class="text-center" id="sickedit" style="display: ">
                                                <button class="btn btn-outline-warning" type="button"  onclick="btnedit(1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                            </div>
                                            <div id="sickcancel" style="display: none" class="text-center">
                                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(1);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">-</div>
                                          
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center sicktext" style="display: ">
                                                '.(!empty($sick2)?$sick2->sickprivate_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center sickinput" style="display:none ">
                                                <input type="number" class="form-control" name="sicklimit2" value="'.(!empty($sick2)?$sick2->sickprivate_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                           
                                        </td>
                                    </tr>
                                ';
                                    
                           
                        }

                            
                        // ลาพักผ่อน

                        if($request->perid==2){
                            // dd($group->id_group);
                            
                            $lessvaca1 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_year',$year)
                                            ->where('vacation_less',1)->first();
                            $lessvaca2 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_year',$year)
                                            ->where('vacation_less',2)->first();

                            // dd($lessvaca2);
                            
                            $morevaca1 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_year',$year)
                                            ->where('vacation_more',1)->first();
                            $morevaca2 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_year',$year)
                                            ->where('vacation_more',2)->first();
                                        // dd( $more);


                            echo '  
                                    <tr>
                                        <td colspan="4" style="text-align: center">ลาพักผ่อน</td>
                                        <td style="width:35% !important">
                                            <div class="text-center" id="vacaedit" style="display: ">
                                                <button class="btn btn-outline-warning " type="button"  onclick="btnedit(2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                            </div>
                                            <div id="vacacancel" style="display: none" class="text-center">
                                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(2);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">1.1  ลาพักผ่อน (น้อยกว่า 10 ปี)</div></td>
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">- </div>
                                            
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($lessvaca1)?$lessvaca1->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput" style="display:none ">
                                                <input type="number" class="form-control" name="vacalesstenlimit1" value="'.(!empty($lessvaca1)?$lessvaca1->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">-</div>
                                           
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext"  style="display: ">
                                                '.(!empty($lessvaca2)?$lessvaca2->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput"  style="display:none ">
                                                <input type="number"  class="form-control" name="vacalesstenlimit2" value="'.(!empty($lessvaca2)?$lessvaca2->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>

                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">1.2  ลาพักผ่อน (มากกว่า 10 ปี)</div></td>
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">-</div>
                                          
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($morevaca1)?$morevaca1->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput" style="display:none ">
                                                <input type="number"  class="form-control" name="vacamoretenlimit1" value="'.(!empty($morevaca1)?$morevaca1->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">-</div>
                                            
                                            
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($morevaca2)?$morevaca2->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput" style="display:none ">
                                                <input type="number"  class="form-control" name="vacamoretenlimit2" value="'.(!empty($morevaca2)?$morevaca2->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                ';
                        }else if($request->perid==3 || $request->perid==4){
                            $lessvaca1 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_year',$year)
                                            ->where('vacation_less',1)->first();
                            $lessvaca2 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_year',$year)
                                            ->where('vacation_less',2)->first();


                            $morevaca1 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_year',$year)
                                            ->where('vacation_more',1)->first();
                            $morevaca2 = DB::Table('limitvacation')->where('id_group',$group->id_group)->where('vacation_year',$year)
                                            ->where('vacation_more',2)->first();

                            echo '  
                                    <tr>
                                        <td colspan="4" style="text-align: center">ลาพักผ่อน</td>
                                        <td style="width:35% !important">
                                            <div class="text-center" id="vacaedit" style="display: ">
                                                <button class="btn btn-outline-warning " type="button"  onclick="btnedit(2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                            </div>
                                            <div id="vacacancel" style="display: none" class="text-center">
                                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(2);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">1.1  ลาพักผ่อน (น้อยกว่า 6 เดือน)</div></td>
                                        <td style="width:10% ">
                                            <div class="text-center " style="display: ">-</div>
                                        
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($lessvaca1)?$lessvaca1->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput" style="display:none ">
                                                <input type="number"  class="form-control" name="vacalesssixlimit1" value="'.(!empty($lessvaca1)?$lessvaca1->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center " style="display: ">- </div>
                                        
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($lessvaca2)?$lessvaca2->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput"  style="display:none ">
                                                <input type="number"  class="form-control" name="vacalesssixlimit2" value="'.(!empty($lessvaca2)?$lessvaca2->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>

                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">1.2  ลาพักผ่อน (มากกว่า 6 เดือน)</div></td>
                                        <td style="width:10% ">
                                            <div class="text-center" style="display: ">-</div>
                                            
                                        
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($morevaca1)?$morevaca1->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput"  style="display:none ">
                                                <input type="number" class="form-control" name="vacamoresixlimit1" value="'.(!empty($morevaca1)?$morevaca1->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center"  style="display: ">-</div>
                                            
                                        
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($morevaca2)?$morevaca2->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput"  style="display:none ">
                                                <input type="number"  class="form-control" name="vacamoresixlimit2" value="'.(!empty($morevaca2)?$morevaca2->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                                ';
                        }else{
                            echo ' 
                                    <tr style="text-align: center">
                                        <td style="width:25% "><div style="margin-top: 7px">ลาพักผ่อน</div></td>
                                        <td style="width:10% ">
                                            <div class="text-center " style="display: ">-</div>
                                            
                                          
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($vacation1)?$vacation1->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput"  style="display:none ">
                                                <input type="number" class="form-control" name="vacalimit1" value="'.(!empty($vacation1)?$vacation1->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                        <td style="width:35% !important">
                                            <div class="text-center" id="vacaedit" style="display: ">
                                                <button class="btn btn-outline-warning " type="button"  onclick="btnedit(2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                            </div>
                                            <div id="vacacancel" style="display: none" class="text-center">
                                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(2);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="text-align: center">
                                        <td ></td>
                                        <td style="width:10% ">
                                            <div class="text-center " style="display: ">-</div>
                                            
                                         
                                        </td>
                                        <td style="width:10% ">
                                            <div class="text-center vacatext" style="display: ">
                                                '.(!empty($vacation2)?$vacation2->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center vacainput"  style="display:none ">
                                                <input type="number" class="form-control" name="vacalimit2" value="'.(!empty($vacation2)?$vacation2->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>
                                        </td>
                                        <td ><div style="margin-top: 7px">2</div></td>
                                        <td style="width:35% !important">
                                            
                                        </td>
                                    </tr>
                            
                            ';
                        }
                                


                        // ลาคลอดบุตร

                    echo '
                            <tr style="text-align: center">
                                <td style="width:25% "><div style="margin-top: 7px">ลาคลอดบุตร</div></td>
                                <td style="width:10% ">
                                    <div class="text-center" style="display: ">- </div>
                                    
                                </td>
                                <td style="width:10% ">
                                    <div class="text-center babytext"  style="display: ">
                                        '.(!empty($data41)?$data41->maternity_limit:'-').'
                                        
                                    </div>
                                    
                                    <div class="text-center babyinput"  style="display:none ">
                                        <input type="number"  class="form-control" name="limit7" value="'.(!empty($data41)?$data41->maternity_limit:'-').'" style="width: 100px;text-align:center;">
                                    </div>
                                </td>
                                <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                <td style="width:35% !important">
                                    <div class="text-center" id="babyedit" style="display: ">
                                        <button class="btn btn-outline-warning" type="button"  onclick="btnedit(3);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                    </div>
                                    <div id="babycancel" style="display: none" class="text-center">
                                        <button class="btn btn-outline-danger" type="button" onclick="btncancle(3);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                    </div>
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                <td ></td>
                                <td style="width:10% ">
                                    <div class="text-center" style="display: ">-</div>
                                    
                                </td>
                                <td style="width:10% ">
                                    <div class="text-center babytext"  style="display: ">
                                        '.(!empty($data42)?$data42->maternity_limit:'-').'
                                        
                                    </div>
                                    
                                    <div class="text-center babyinput" style="display:none ">
                                        <input type="number" class="form-control" name="limit8" value="'.(!empty($data42)?$data42->maternity_limit:'-').'" style="width: 100px;text-align:center;">
                                    </div>
                                </td>
                                <td ><div style="margin-top: 7px">2</div></td>
                                <td style="width:35% !important">
                                   
                                </td>
                            </tr>



                            <tr style="text-align: center">
                                <td style="width:25% "><div style="margin-top: 7px">ลาไปช่วยเหลือภริยาที่คลอดบุตร</div></td>
                                <td style="width:10% "> 
                                    <div class="text-center" style="display: ">-</div>
                                 
                                </td>
                                <td style="width:10% ">
                                    <div class="text-center mattext" style="display: ">
                                        '.(!empty($data51)?$data51->baby_limit:'-').'
                                        
                                    </div>
                                    
                                    <div class="text-center matinput "  style="display:none ">
                                        <input type="number" class="form-control" name="limit9" value="'.(!empty($data51)?$data51->baby_limit:'-').'" style="width: 100px;text-align:center;">
                                    </div>
                                </td>
                                <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                <td style="width:35% !important">
                                    <div class="text-center" id="matedit" style="display: ">
                                        <button class="btn btn-outline-warning" type="button"  onclick="btnedit(4);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                    </div>
                                    <div id="matcancel" style="display: none" class="text-center">
                                        <button class="btn btn-outline-danger" type="button" onclick="btncancle(4);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                    </div>
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                <td ></td>
                                <td style="width:10% ">
                                    <div class="text-center" style="display: ">- </div>
                                    
                                </td>
                                <td style="width:10% ">
                                    <div class="text-center mattext"  style="display: ">
                                        '.(!empty($data52)?$data52->baby_limit:'-').'
                                        
                                    </div>
                                    
                                    <div class="text-center matinput" style="display:none ">
                                        <input type="number" class="form-control" name="limit10" value="'.(!empty($data52)?$data52->baby_limit:'-').'" style="width: 100px;text-align:center;">
                                    </div>
                                </td>
                                <td ><div style="margin-top: 7px">2</div></td>
                                <td style="width:35% !important">
                                   
                                </td>
                            </tr>';


                            
                            if( $request->perid==5 || $request->perid==6 ){
                                echo ' 
                                        <tr style="text-align: center">
                                            <td style="width:25% "><div style="margin-top: 7px">ลาอุปสมบท</div></td>
                                            <td style="width:10% ">
                                                <div class="text-center " style="display: ">-</div>
                                              
                                            </td>
                                            <td style="width:10% ">
                                                <div class="text-center orditext" style="display: ">
                                                    '.(!empty($data61)?$data61->ordination_limit:'-').'
                                                    
                                                </div>
                                                
                                                <div class="text-center ordiinput"  style="display:none ">
                                                    <input type="number" class="form-control" name="limit11" value="'.(!empty($data61)?$data61->ordination_limit:'-').'" style="width: 100px;text-align:center;">
                                                </div>
                                            </td>
                                            <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                            <td style="width:35% !important">
                                                <div class="text-center" id="ordiedit" style="display: ">
                                                    <button class="btn btn-outline-warning " type="button"  onclick="btnedit(5);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                                </div>
                                                <div id="ordicancel" style="display: none" class="text-center">
                                                    <button class="btn btn-outline-danger" type="button" onclick="btncancle(5);"><i class="feather icon-x-circle"></i>ยกเลิก</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="text-align: center">
                                            <td ></td>
                                            <td style="width:10% ">
                                                <div class="text-center"  style="display: ">-</div>
                                                
                                            </td>
                                            <td style="width:10% ">
                                                <div class="text-center orditext" style="display: ">
                                                    '.(!empty($data62)?$data62->ordination_limit:'-').'
                                                    
                                                </div>
                                                
                                                <div class="text-center ordiinput" style="display:none ">
                                                    <input type="n2mber" cl2="form-control" name="limit12" value="'.(!empty($data62)?$data62->ordination_limit:'-').'" style="width: 100px;text-align:center;">
                                                </div>
                                            </td>
                                            <td ><div style="margin-top: 7px">2</div></td>
                                            <td style="width:35% !important">
                                                
                                            </td>
                                        </tr>
                                    ';
                            }


                           
                                
                            echo '</tbody>
                    </table>

            ';
    }

    public static function Dateformat($var){
        $date = date_format(date_create($var),'d-m-Y');
        $day = explode('-',date_format(date_create($var), 'Y-m-d'));/////var is column name
    
        $year = $day[0]+543;
       
        $date_text = $day[2].'-'.$day[1].'-'.$year;
        // dd($date_text);
        return $date_text;

    }




    public function SearchLeaveReport(Request $request){
        $odl = (((int)$request->year)-543)-1;
        $year = (((int)$request->year)-543);
        if($request->round==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }
        // dd($datestart.'----'.$dateend);
        $sql = \App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                            ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                            ->whereBetween('ABSENT_START', [$datestart, $dateend])
                            // ->Where('ABSENT_START', '>=', $datestart)
                            // ->where('ABSENT_END', '<=', $dateend)
                            ->where('user.DEP_ID', '=', $request->department)
                            
                            ->orderBy('ABSENT_START','DESC')->get();


        // dd($sql );
       
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
                                                }else if($item->STATUS_APPROVER==6){
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


    public function SearchLeaveCheck(Request $request){
        
        $sql = \App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                                ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                                ->whereBetween('ABSENT_START', [$request->datestart, $request->dateend])
                                ->where('absentdetail.ABSENTYPE_ID', '=', $request->absenttype)
                                
                                ->orderBy('ABSENT_START','DESC')->get();
        // dd($sql);

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
                                <td>การจัดการ</td>
                            
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
                                                    echo '<td><br>'.self::Dateformat($item->ABSENT_START).' ถึง '.self::Dateformat($item->ABSENT_END).'<br>จำนวน '.$item->ABSENT_NUMBER.' วัน</td>';
                                                }else{
                                                    echo '<td><br>'.self::Dateformat($item->ABSENT_START).' <br>จำนวน '.$item->ABSENT_NUMBER.' วัน</td>';
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
                                                }else if($item->STATUS_APPROVER==7){
                                                    echo ' <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยเจ้าหน้าที่ฝ่ายบุคคล</td>
                                                            <td style="text-align: center;color:red"><br>&nbsp;&nbsp;'.$item->APPROVER_COMMENT.'</td>   ';
                                                            
                                                }else if($item->STATUS_APPROVER==0){
                                                    echo ' <td style="text-align: center;color:blue"><br>รอตรวจสอบ</td>
                                                            <td align="center"></td>';
                                                }else if($item->STATUS_APPROVER==6){
                                                    echo ' <td style="text-align: center;color:blue"><br>ผ่านการตรวจสอบแล้ว</td>
                                                            <td align="center"></td>';
                                                }else{
                                                    echo ' <td style="text-align: center;color:red"><br>ยกเลิกโดยผู้ใช้</td>
                                                            <td style="text-align: center;color:red"><br>&nbsp;&nbsp;'.$item->ABSENT_CANCLE.'</td>';
                                                }
                                                if($item->STATUS_APPROVER==0){
                                                    if($request->absenttype==3 || $request->absenttype==4 || $request->absenttype==5){
                                                        echo '   <td><br>    <button class="btn btn-outline-info btn-sm" type="button" onclick="btnmodal('.$item->ABSENT_ID.');"><i class="feather icon-edit-2"></i>ดูรายละเอียด</button><br>
                                                                             <button class="btn btn-outline-warning btn-sm" type="button" onclick="btnedit('.$item->ABSENT_ID.','.$item->ABSENTYPE_ID.');"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                                                             <br>
                                                                             <button class="btn btn-outline-success btn-sm" type="button" onclick="btnsumit('.$item->ABSENT_ID.','.$item->USER_ID.');"><i class="feather icon-edit-2"></i>ผ่าน</button>
                                                                             <br> <button class="btn btn-outline-danger btn-sm" type="button" onclick="btncancel('.$item->ABSENT_ID.','.$item->USER_ID.');"><i class="feather icon-x"></i>ไม่ผ่าน</button>
                                                                 </td>';
                                                     }else{
                                                         echo ' <td><br><button class="btn btn-outline-info btn-sm" type="button" onclick="btnmodal('.$item->ABSENT_ID.');"><i class="feather icon-edit-2"></i>ดูรายละเอียด</button>
                                                                         <br><button class="btn btn-outline-success btn-sm" type="button" onclick="btnsumit('.$item->ABSENT_ID.','.$item->USER_ID.');"><i class="feather icon-edit-2"></i>ผ่าน</button>
                                                                         <br><button class="btn btn-outline-danger btn-sm" type="button" onclick="btncancel('.$item->ABSENT_ID.','.$item->USER_ID.');"><i class="feather icon-x"></i>ไม่ผ่าน</button>
                                                                 </td>';
                                                     }
                                                }else{
                                                    echo ' <td><br><button class="btn btn-outline-info btn-sm" type="button" onclick="btnmodal('.$item->ABSENT_ID.');"><i class="feather icon-edit-2"></i>ดูรายละเอียด</button>';

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


    public function Detailadmin(Request $request){
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
    
    
}