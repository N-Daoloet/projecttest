<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;

class CheckleaveController extends Controller
{
    public function Search(Request $request){
        // dd($request->all());
        if($request->leaveid==1){
            $data = DB::Table('limitsick')->leftJoin('group_personal','limitsick.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('sick_year',$request->year)->get();
        }else if($request->leaveid==2){
            $data = DB::Table('limitvacation')->leftJoin('group_personal','limitvacation.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('vacation_year',$request->year)->get();
        }else if($request->leaveid==3){
            $data = DB::Table('limitprivate')->leftJoin('group_personal','limitprivate.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('private_year',$request->year)->get();
        }else if($request->leaveid==4){
            $data = DB::Table('limitmaternity')->leftJoin('group_personal','limitmaternity.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('maternity_year',$request->year)->get();
        }else if($request->leaveid==5){
            $data = DB::Table('limitbaby')->leftJoin('group_personal','limitbaby.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('baby_year',$request->year)->get();
        }else{
            $data = DB::Table('limitordination')->leftJoin('group_personal','limitordination.id_group','=','group_personal.id_group')->where('id_personal',$request->perid)->where('ordination_year',$request->year)->get();
        }
            // dd($data);
            echo '
            <table class="table table-bordered" style="width:100%">                                        
                <tr style="text-align: center"> 
                    <td style="width:25% ">ประเภทการลา</td>
                    <td style="width:10% ">ประจำปี</td>
                    <td style="width:10% ">จำนวนครั้งสูงสุด</td>
                    <td style="width:10% " >จำนวนวันลาสูงสุด</td>
                    <td style="width:10% ">รอบ</td> 
                    <td style="width:35% !important">การจัดการ</td> 
                </tr>
                <tbody>
                      
                    <tr style="text-align: center">';
                        if($request->leaveid==1){
                            echo ' <td style="width:25% "><div style="margin-top: 7px">ลาป่วย</div></td>';
                        }else if($request->leaveid==2){
                            echo '<td style="width:25% "><div style="margin-top: 7px">ลาพักผ่อน</div></td>';
                        }else if($request->leaveid==3){
                            echo '<td style="width:25% "><div style="margin-top: 7px">ลากิจส่วนตัว</div></td>';
                        }else if($request->leaveid==4){
                            echo '<td style="width:25% "><div style="margin-top: 7px">ลาคลอดบุตร</div></td>';
                        }else if($request->leaveid==5){
                            echo '<td style="width:25% "><div style="margin-top: 7px">ลาไปช่วยเหลือภริยาที่คลอดบุตร</div></td>';
                        }else{
                            echo '<td style="width:25% "><div style="margin-top: 7px">ลาอุปสมบท</div></td>';
                        }
                        echo '  <td style="width:10% ">
                                    <div class="text-center">
                                        '.$request->year.'
                                        
                                    </div>
                                   
                                </td>
                                <td style="width:10% ">';
                                    if($request->leaveid==1){
                                        echo '  <div class="text-center" id="text1" style="display: ">
                                                    '.(count($data)>0?$data[0]->sick_number:'-').'
                                                    
                                                </div>
                                                
                                                <div class="text-center" id="input1" style="display:none ">
                                                    <input type="number" id="txtinput1" class="form-control" name="number1" value="'.(count($data)>0?$data[0]->sick_number:'-').'" style="width: 100px;text-align:center;">
                                                </div>';

                                    }else if($request->leaveid==2){
                                        echo '  <div class="text-center" id="text1" style="display: ">
                                                    '.(count($data)>0?$data[0]->vacation_number:'-').'
                                                    
                                                </div>
                                                
                                                <div class="text-center" id="input1" style="display:none ">
                                                    <input type="number" id="txtinput1" class="form-control" name="number1" value="'.(count($data)>0?$data[0]->vacation_number:'-').'" style="width: 100px;text-align:center;">
                                                </div>';

                                    }else if($request->leaveid==3){
                                        echo '  <div class="text-center" id="text1" style="display: ">
                                                    '.(count($data)>0?$data[0]->private_number:'-').'
                                                    
                                                </div>
                                                
                                                <div class="text-center" id="input1" style="display:none ">
                                                    <input type="number" id="txtinput1" class="form-control" name="number1" value="'.(count($data)>0?$data[0]->private_number:'-').'" style="width: 100px;text-align:center;">
                                                </div>';

                                    }else if($request->leaveid==4){
                                        echo '  <div class="text-center" id="text1" style="display: ">
                                                    '.(count($data)>0?$data[0]->maternity_number:'-').'
                                                    
                                                </div>
                                                
                                                <div class="text-center" id="input1" style="display:none ">
                                                    <input type="number" id="txtinput1" class="form-control" name="number1" value="'.(count($data)>0?$data[0]->maternity_number:'-').'" style="width: 100px;text-align:center;">
                                                </div>';

                                    }else if($request->leaveid==5){
                                        echo '  <div class="text-center" id="text1" style="display: ">
                                                    '.(count($data)>0?$data[0]->baby_number:'-').'
                                                    
                                                </div>
                                                
                                                <div class="text-center" id="input1" style="display:none ">
                                                    <input type="number" id="txtinput1" class="form-control" name="number1" value="'.(count($data)>0?$data[0]->baby_number:'-').'" style="width: 100px;text-align:center;">
                                                </div>';

                                    }else{
                                        echo '  <div class="text-center" id="text1" style="display: ">
                                                    '.(count($data)>0?$data[0]->ordination_number:'-').'
                                                    
                                                </div>
                                                
                                                <div class="text-center" id="input1" style="display:none ">
                                                    <input type="number" id="txtinput1" class="form-control" name="number1" value="'.(count($data)>0?$data[0]->ordination_number:'-').'" style="width: 100px;text-align:center;">
                                                </div>';
                                    }
                                    
                                   echo' 
                                </td>
                                <td style="width:10% ">';

                                        if($request->leaveid==1){
                                            echo '  <div class="text-center" id="text2" style="display: ">
                                                        '.(count($data)>0?$data[0]->sick_limit:'-').'
                                                        
                                                    </div>
                                                    
                                                    <div class="text-center" id="input2" style="display:none ">
                                                        <input type="number" id="txtinput2" class="form-control" name="limit1" value="'.(count($data)>0?$data[0]->sick_limit:'-').'" style="width: 100px;text-align:center;">
                                                    </div>';

                                        }else if($request->leaveid==2){
                                            echo '  <div class="text-center" id="text2" style="display: ">
                                                        '.(count($data)>0?$data[0]->vacation_limit:'-').'
                                                        
                                                    </div>
                                                    
                                                    <div class="text-center" id="input2" style="display:none ">
                                                        <input type="number" id="txtinput2" class="form-control" name="limit1" value="'.(count($data)>0?$data[0]->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                                    </div>';

                                        }else if($request->leaveid==3){
                                            echo '  <div class="text-center" id="text2" style="display: ">
                                                        '.(count($data)>0?$data[0]->private_limit:'-').'
                                                        
                                                    </div>
                                                    
                                                    <div class="text-center" id="input2" style="display:none ">
                                                        <input type="number" id="txtinput2" class="form-control" name="limit1" value="'.(count($data)>0?$data[0]->private_limit:'-').'" style="width: 100px;text-align:center;">
                                                    </div>';

                                        }else if($request->leaveid==4){
                                            echo '  <div class="text-center" id="text2" style="display: ">
                                                        '.(count($data)>0?$data[0]->maternity_limit:'-').'
                                                        
                                                    </div>
                                                    
                                                    <div class="text-center" id="input2" style="display:none ">
                                                        <input type="number" id="txtinput2" class="form-control" name="limit1" value="'.(count($data)>0?$data[0]->maternity_limit:'-').'" style="width: 100px;text-align:center;">
                                                    </div>';

                                        }else if($request->leaveid==5){
                                            echo '  <div class="text-center" id="text2" style="display: ">
                                                        '.(count($data)>0?$data[0]->baby_limit:'-').'
                                                        
                                                    </div>
                                                    
                                                    <div class="text-center" id="input2" style="display:none ">
                                                        <input type="number" id="txtinput2" class="form-control" name="limit1" value="'.(count($data)>0?$data[0]->baby_limit:'-').'" style="width: 100px;text-align:center;">
                                                    </div>';

                                        }else{
                                            echo '  <div class="text-center" id="text2" style="display: ">
                                                        '.(count($data)>0?$data[0]->ordination_limit:'-').'
                                                        
                                                    </div>
                                                    
                                                    <div class="text-center" id="input2" style="display:none ">
                                                        <input type="number" id="txtinput2" class="form-control" name="limit1" value="'.(count($data)>0?$data[0]->ordination_limit:'-').'" style="width: 100px;text-align:center;">
                                                    </div>';
                                        }
                                
                                    echo 
                                '</td>
                                <td style="width:10% " ><div style="margin-top: 7px">1</div></td>
                                <td style="width:35% !important">
                                    <div class="text-center" id="buttonedit1" style="display: ">
                                        <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(1);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                    </div>
                                    <div id="buttonsubmit1" style="margin-left: 30%;display: none" class="form-inline">
                                        <button class="btn btn-outline-danger" type="button" onclick="btncancle(1);">ยกเลิก</button>
                                    </div>
                                </td>
                    </tr>
                    <tr style="text-align: center">
                    
                        <td ></td>
                        <td>
                            <div class="text-center" >
                                '.$request->year.' 
                                
                            </div>
                           
                        </td>
                        <td style="width:10% ">';
                            if($request->leaveid==1){
                                echo '  <div class="text-center" id="text3" style="display: ">
                                            '.(count($data)>1?$data[1]->sick_number:'-').'
                                            
                                        </div>
                                        
                                        <div class="text-center" id="input3" style="display:none ">
                                            <input type="number" id="txtinput3" class="form-control" name="number2" value="'.(count($data)>1?$data[1]->sick_number:'-').'" style="width: 100px;text-align:center;">
                                        </div>';

                            }else if($request->leaveid==2){
                                echo '  <div class="text-center" id="text3" style="display: ">
                                            '.(count($data)>1?$data[1]->vacation_number:'-').'
                                            
                                        </div>
                                        
                                        <div class="text-center" id="input3" style="display:none ">
                                            <input type="number" id="txtinput3" class="form-control" name="number2" value="'.(count($data)>1?$data[1]->vacation_number:'-').'" style="width: 100px;text-align:center;">
                                        </div>';

                            }else if($request->leaveid==3){
                                echo '  <div class="text-center" id="text3" style="display: ">
                                            '.(count($data)>1?$data[1]->private_number:'-').'
                                            
                                        </div>
                                        
                                        <div class="text-center" id="input3" style="display:none ">
                                            <input type="number" id="txtinput3" class="form-control" name="number2" value="'.(count($data)>1?$data[1]->private_number:'-').'" style="width: 100px;text-align:center;">
                                        </div>';

                            }else if($request->leaveid==4){
                                echo '  <div class="text-center" id="text3" style="display: ">
                                            '.(count($data)>1?$data[1]->maternity_number:'-').'
                                            
                                        </div>
                                        
                                        <div class="text-center" id="input3" style="display:none ">
                                            <input type="number" id="txtinput3" class="form-control" name="number2" value="'.(count($data)>1?$data[1]->maternity_number:'-').'" style="width: 100px;text-align:center;">
                                        </div>';

                            }else if($request->leaveid==5){
                                echo '  <div class="text-center" id="text3" style="display: ">
                                            '.(count($data)>1?$data[1]->baby_number:'-').'
                                            
                                        </div>
                                        
                                        <div class="text-center" id="input3" style="display:none ">
                                            <input type="number" id="txtinput3" class="form-control" name="number2" value="'.(count($data)>1?$data[1]->baby_number:'-').'" style="width: 100px;text-align:center;">
                                        </div>';

                            }else{
                                echo '  <div class="text-center" id="text3" style="display: ">
                                            '.(count($data)>1?$data[1]->ordination_number:'-').'
                                            
                                        </div>
                                        
                                        <div class="text-center" id="input3" style="display:none ">
                                            <input type="number" id="txtinput3" class="form-control" name="number2" value="'.(count($data)>1?$data[1]->ordination_number:'-').'" style="width: 100px;text-align:center;">
                                        </div>';
                            }
                            
                            echo' 
                        </td>
                        <td style="width:10% ">';

                                if($request->leaveid==1){
                                    echo '  <div class="text-center" id="text4" style="display: ">
                                                '.(count($data)>1?$data[1]->sick_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center" id="input4" style="display:none ">
                                                <input type="number" id="txtinput4" class="form-control" name="limit2" value="'.(count($data)>1?$data[1]->sick_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>';

                                }else if($request->leaveid==2){
                                    echo '  <div class="text-center" id="text4" style="display: ">
                                                '.(count($data)>1?$data[1]->vacation_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center" id="input4" style="display:none ">
                                                <input type="number" id="txtinput4" class="form-control" name="limit2" value="'.(count($data)>1?$data[1]->vacation_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>';

                                }else if($request->leaveid==3){
                                    echo '  <div class="text-center" id="text4" style="display: ">
                                                '.(count($data)>1?$data[1]->private_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center" id="input4" style="display:none ">
                                                <input type="number" id="txtinput4" class="form-control" name="limit2" value="'.(count($data)>1?$data[1]->private_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>';

                                }else if($request->leaveid==4){
                                    echo '  <div class="text-center" id="text4" style="display: ">
                                                '.(count($data)>1?$data[1]->maternity_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center" id="input4" style="display:none ">
                                                <input type="number" id="txtinput4" class="form-control" name="limit2" value="'.(count($data)>1?$data[1]->maternity_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>';

                                }else if($request->leaveid==5){
                                    echo '  <div class="text-center" id="text4" style="display: ">
                                                '.(count($data)>1?$data[1]->baby_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center" id="input4" style="display:none ">
                                                <input type="number" id="txtinput4" class="form-control" name="limit2" value="'.(count($data)>1?$data[1]->baby_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>';

                                }else{
                                    echo '  <div class="text-center" id="text4" style="display: ">
                                                '.(count($data)>1?$data[1]->ordination_limit:'-').'
                                                
                                            </div>
                                            
                                            <div class="text-center" id="input4" style="display:none ">
                                                <input type="number" id="txtinput4" class="form-control" name="limit2" value="'.(count($data)>1?$data[1]->ordination_limit:'-').'" style="width: 100px;text-align:center;">
                                            </div>';
                                }
                        
                            echo 
                        '</td>
                        <td ><div style="margin-top: 7px">2</div></td>
                        <td style="width:35% !important">
                            <div class="text-center" id="buttonedit2" style="display: ">
                                <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit(2);"><i class="feather icon-edit-2"></i>แก้ไข</button>
                            </div>
                            <div id="buttonsubmit2" style="margin-left: 30%;display: none" class="form-inline">
                                <button class="btn btn-outline-danger" type="button" onclick="btncancle(2);">ยกเลิก</button>
                            </div>
                        </td>
                    </tr>
                        
                </tbody>
            </table>

    ';
    }

    
}