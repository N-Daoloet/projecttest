<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;

class CheckleaveController extends Controller
{ 
    // echo ' <td style="width:25% "><div style="margin-top: 7px">ลาป่วย</div></td>';
    // echo '<td style="width:25% "><div style="margin-top: 7px">ลาพักผ่อน</div></td>';
    // echo '<td style="width:25% "><div style="margin-top: 7px">ลากิจส่วนตัว</div></td>';
    // echo '<td style="width:25% "><div style="margin-top: 7px">ลาคลอดบุตร</div></td>';
    // echo '<td style="width:25% "><div style="margin-top: 7px">ลาไปช่วยเหลือภริยาที่คลอดบุตร</div></td>';
    // echo '<td style="width:25% "><div style="margin-top: 7px">ลาอุปสมบท</div></td>';
    public function Search(Request $request){
        // dd($request->all());
            $data1 = DB::Table('limitsick')->leftJoin('group_personal','limitsick.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('sick_year',$request->year)->get();
            $data2 = DB::Table('limitvacation')->leftJoin('group_personal','limitvacation.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('vacation_year',$request->year)->get();
            $data3 = DB::Table('limitprivate')->leftJoin('group_personal','limitprivate.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('private_year',$request->year)->get();
            $data5 = DB::Table('limitmaternity')->leftJoin('group_personal','limitmaternity.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('maternity_year',$request->year)->get();
            $data4 = DB::Table('limitbaby')->leftJoin('group_personal','limitbaby.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('baby_year',$request->year)->get();
            $data6 = DB::Table('limitordination')->leftJoin('group_personal','limitordination.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('ordination_year',$request->year)->get();
            // dd($data);
            echo '
            <table class="table table-bordered" style="width:100%">                                        
                <tr style="text-align: center"> 
                    <td style="width:25% ">ประเภทการลา</td>
                    <td style="width:10% ">จำนวนครั้งสูงสุด</td>
                    <td style="width:10% " >จำนวนวันลาสูงสุด</td>
                    <td style="width:10% ">รอบ</td> 
                    <td style="width:35% !important">การจัดการ</td> 
                </tr>
                <tbody>
                    
                    <tr style="text-align: center">
                        <td style="width:25% "><div style="margin-top: 7px">ลาป่วย</div></td>
                        
                        <td style="width:10% ">
                            <div class="text-center" id="sicktext1" style="display: ">
                                '.(count($data1)>0?$data1[0]->sick_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="sickinput1" style="display:none ">
                                <input type="number" id="sicktxtinput1" class="form-control" name="number1" value="'.(count($data1)>0?$data1[0]->sick_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="sicktext2" style="display: ">
                                '.(count($data1)>0?$data1[0]->sick_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="sickinput2" style="display:none ">
                                <input type="number" id="sicktxtinput2" class="form-control" name="limit1" value="'.(count($data1)>0?$data1[0]->sick_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="sickedit1" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(1,1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="sicksubmit1" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(1,1);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <td ></td>
                        <td style="width:10% ">
                            <div class="text-center" id="sicktext3" style="display: ">
                                '.(count($data1)>1?$data1[1]->sick_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="sickinput3" style="display:none ">
                                <input type="number" id="sicktxtinput3" class="form-control" name="number2" value="'.(count($data1)>1?$data1[1]->sick_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="sicktext4" style="display: ">
                                '.(count($data1)>1?$data1[1]->sick_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="sickinput4" style="display:none ">
                                <input type="number" id="sicktxtinput4" class="form-control" name="limit2" value="'.(count($data1)>1?$data1[1]->sick_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td ><div style="margin-top: 7px">2</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="sickedit2" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(1,2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="sicksubmit2" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(1,2);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>

                    <tr style="text-align: center">
                        <td style="width:25% "><div style="margin-top: 7px">ลาพักผ่อน</div></td>
                        <td style="width:10% ">
                            <div class="text-center" id="vacatext1" style="display: ">
                                '.(count($data2)>0?$data2[0]->vacation_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="vacainput1" style="display:none ">
                                <input type="number" id="vacatxtinput1" class="form-control" name="number3" value="'.(count($data2)>0?$data2[0]->vacation_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="vacatext2" style="display: ">
                                '.(count($data2)>0?$data2[0]->vacation_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="vacainput2" style="display:none ">
                                <input type="number" id="vacatxtinput2" class="form-control" name="limit3" value="'.(count($data2)>0?$data2[0]->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="vacaedit1" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(2,1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="vacasubmit1" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(2,1);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <td ></td>
                        <td style="width:10% ">
                            <div class="text-center" id="vacatext3" style="display: ">
                                '.(count($data2)>1?$data2[1]->vacation_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="vacainput3" style="display:none ">
                                <input type="number" id="vacatxtinput3" class="form-control" name="number4" value="'.(count($data2)>1?$data2[1]->vacation_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="vacatext4" style="display: ">
                                '.(count($data2)>1?$data2[1]->vacation_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="vacainput4" style="display:none ">
                                <input type="number" id="vacatxtinput4" class="form-control" name="limit4" value="'.(count($data2)>1?$data2[1]->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td ><div style="margin-top: 7px">2</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="vacaedit2" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(2,2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="vacasubmit2" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(2,2);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>

                    <tr style="text-align: center">
                        <td style="width:25% "><div style="margin-top: 7px">ลากิจส่วนตัว</div></td>
                        <td style="width:10% ">
                            <div class="text-center" id="pritext1" style="display: ">
                                '.(count($data3)>0?$data3[0]->private_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="priinput1" style="display:none ">
                                <input type="number" id="pritxtinput1" class="form-control" name="number5" value="'.(count($data3)>0?$data3[0]->private_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="pritext2" style="display: ">
                                '.(count($data3)>0?$data3[0]->private_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="priinput2" style="display:none ">
                                <input type="number" id="pritxtinput2" class="form-control" name="limit5" value="'.(count($data3)>0?$data3[0]->private_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="priedit1" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(3,1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="prisubmit1" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(3,1);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <td ></td>
                        <td style="width:10% ">
                            <div class="text-center" id="pritext3" style="display: ">
                                '.(count($data3)>1?$data3[1]->private_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="priinput3" style="display:none ">
                                <input type="number" id="pritxtinput3" class="form-control" name="number6" value="'.(count($data3)>1?$data3[1]->private_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="pritext4" style="display: ">
                                '.(count($data3)>1?$data3[1]->private_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="priinput4" style="display:none ">
                                <input type="number" id="pritxtinput4" class="form-control" name="limit6" value="'.(count($data3)>1?$data3[1]->private_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td ><div style="margin-top: 7px">2</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="priedit2" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(3,2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="prisubmit2" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(3,2);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>

                    <tr style="text-align: center">
                        <td style="width:25% "><div style="margin-top: 7px">ลาคลอดบุตร</div></td>
                        <td style="width:10% ">
                            <div class="text-center" id="babytext1" style="display: ">
                                '.(count($data4)>0?$data4[0]->baby_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="babyinput1" style="display:none ">
                                <input type="number" id="babytxtinput1" class="form-control" name="number7" value="'.(count($data4)>0?$data4[0]->baby_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="babytext2" style="display: ">
                                '.(count($data4)>0?$data4[0]->baby_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="babyinput2" style="display:none ">
                                <input type="number" id="babytxtinput2" class="form-control" name="limit7" value="'.(count($data4)>0?$data4[0]->baby_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="babyedit1" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(4,1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="babysubmit1" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(4,1);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <td ></td>
                        <td style="width:10% ">
                            <div class="text-center" id="babytext3" style="display: ">
                                '.(count($data4)>1?$data4[1]->baby_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="babyinput3" style="display:none ">
                                <input type="number" id="babytxtinput3" class="form-control" name="number8" value="'.(count($data4)>1?$data4[1]->baby_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="babytext4" style="display: ">
                                '.(count($data4)>1?$data4[1]->baby_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="babyinput4" style="display:none ">
                                <input type="number" id="babytxtinput4" class="form-control" name="limit8" value="'.(count($data4)>1?$data4[1]->baby_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td ><div style="margin-top: 7px">2</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="babyedit2" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(4,2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="babysubmit2" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(4,2);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>

                    <tr style="text-align: center">
                        <td style="width:25% "><div style="margin-top: 7px">ลาไปช่วยเหลือภริยาที่คลอดบุตร</div></td>
                        <td style="width:10% ">
                            <div class="text-center" id="mattext1" style="display: ">
                                '.(count($data5)>0?$data5[0]->maternity_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="matinput1" style="display:none ">
                                <input type="number" id="mattxtinput1" class="form-control" name="number9" value="'.(count($data5)>0?$data5[0]->maternity_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="mattext2" style="display: ">
                                '.(count($data5)>0?$data5[0]->maternity_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="matinput2" style="display:none ">
                                <input type="number" id="mattxtinput2" class="form-control" name="limit9" value="'.(count($data5)>0?$data5[0]->maternity_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="matedit1" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(5,1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="matsubmit1" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(5,1);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <td ></td>
                        <td style="width:10% ">
                            <div class="text-center" id="mattext3" style="display: ">
                                '.(count($data5)>1?$data5[1]->maternity_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="matinput3" style="display:none ">
                                <input type="number" id="mattxtinput3" class="form-control" name="number10" value="'.(count($data5)>1?$data5[1]->maternity_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="mattext4" style="display: ">
                                '.(count($data5)>1?$data5[1]->maternity_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="matinput4" style="display:none ">
                                <input type="number" id="mattxtinput4" class="form-control" name="limit10" value="'.(count($data5)>1?$data5[1]->maternity_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td ><div style="margin-top: 7px">2</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="matedit2" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(5,2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="matsubmit2" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(5,2);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>

                    <tr style="text-align: center">
                        <td style="width:25% "><div style="margin-top: 7px">ลาอุปสมบท</div></td>
                        <td style="width:10% ">
                            <div class="text-center" id="orditext1" style="display: ">
                                '.(count($data6)>0?$data6[0]->ordination_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="ordiinput1" style="display:none ">
                                <input type="number" id="orditxtinput1" class="form-control" name="number11" value="'.(count($data6)>0?$data6[0]->ordination_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="orditext2" style="display: ">
                                '.(count($data6)>0?$data6[0]->ordination_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="ordiinput2" style="display:none ">
                                <input type="number" id="orditxtinput2" class="form-control" name="limit11" value="'.(count($data6)>0?$data6[0]->ordination_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="ordiedit1" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(6,1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="ordisubmit1" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(6,1);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>
                    <tr style="text-align: center">
                        <td ></td>
                        <td style="width:10% ">
                            <div class="text-center" id="orditext3" style="display: ">
                                '.(count($data6)>1?$data6[1]->ordination_number:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="ordiinput3" style="display:none ">
                                <input type="number" id="orditxtinput3" class="form-control" name="number12" value="'.(count($data6)>1?$data6[1]->ordination_number:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td style="width:10% ">
                            <div class="text-center" id="orditext4" style="display: ">
                                '.(count($data6)>1?$data6[1]->ordination_limit:'-').'
                                
                            </div>
                            
                            <div class="text-center" id="ordiinput4" style="display:none ">
                                <input type="number" id="orditxtinput4" class="form-control" name="limit12" value="'.(count($data6)>1?$data6[1]->ordination_limit:'-').'" style="width: 100px;text-align:center;">
                            </div>
                        </td>
                        <td ><div style="margin-top: 7px">2</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="ordiedit2" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(6,2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="ordisubmit2" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(6,2);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>
                        
              </tbody>
            </table>

    ';
    }

    
}