<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;

class AdminController extends Controller
{

    public function updateimage(Request $request){
        if($request->preview_image !== null){
            $imageName = time().'.'.$request->preview_image->extension();  
            $request->preview_image->move(public_path('assets\images\Banner'), $imageName);
            DB::Table('banner')->where('id_banner',$request->id_banner)->update(['image'=>$imageName]);
        }
        return redirect('addimage')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function adduser($ict){
        $user = DB::table('user')->where('USER_USERNAME', $ict)->first();
        $dep = DB::table('department')->get();
        $per = DB::table('personal')->get();
       
        if(!empty($user)){
            echo '
                        <br>
                        <div class="form">
                            <div class="form-group"> 
                                <label for="exampleFormControlSelect1">บัญชีผู้ใช้</label>
                                <input type="text" class="form-control" id="" name="firstname" value="'.$user->USER_USERNAME.'" readonly><br>
                                <label class="form-label">ชื่อ-นามสกุล</label>
                                <input type="hidden" name="userid" value="'.$user->USER_ID.'">
                                <input type="text" class="form-control" id="" name="firstname" value="'.$user->USER_FNAME.'-'.$user->USER_LNAME.'" readonly><br>
                                <label for="exampleFormControlSelect1">สังกัดฝ่าย</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="depid" required>
                                    <option value="">กรุณาเลือก</option>';
                                    foreach($dep as $department){
                                       echo '<option value="'.$department->DEP_ID.'" '.($user->DEP_ID==$department->DEP_ID?'selected':'').'>'.$department->DEP_NAME.'</option>';
                                    }
                                echo '</select>
                                <br>
                                <label for="exampleFormControlSelect1">ประเภทบุคลากร</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="perid" required>
                                    <option value="">กรุณาเลือก</option>';
                                    foreach($per as $personal){
                                       echo ' <option value="'.$personal->PERTYPE_ID.'" '.($user->PERTYPE_ID==$personal->PERTYPE_ID?'selected':'').'>'.$personal->PERTYPE_NAME.'</option>';
                                    }
                                echo '</select><br><br>
                                    <button class="btn btn-primary" type="submit">เพิ่ม</button>
                                </div>
                        </div>
                    </form>
            
            ';
        }else{
            echo '0';
        }
    }
    
    public function updateuser(Request $request){
        DB::table('user')->where('USER_ID', $request->userid)->update(['DEP_ID' => $request->depid,'PERTYPE_ID'=>$request->perid]);
        return back()->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function ChangeStatusUser($chk,$id){
        if($chk==1){
            DB::table('user')->where('USER_ID', $id)->update(['USER_STATUS' => NULL]);
        }else{
            DB::table('user')->where('USER_ID', $id)->update(['USER_STATUS' => 1]);
        }
    }

    public function manageraccount($dep,$per){
        $sql = DB::table('user')
                ->where('DEP_ID',$dep)
                ->where('PERTYPE_ID',$per)
                ->orderBy('USER_STATUS','DESC')
                ->get();

        // dd($sql);

        if(count($sql)>0){
            echo '
            <br>
                <table id="table" class="table table-bordered" >
                    <thead>
                        <tr style="text-align: center;">
                            <td rowspan="2"><br>ลำดับที่</td>
                            <td rowspan="2"><br>สถานะ</td>
                            <td rowspan="2"><br>บัญชีผู้ใช้</td>
                            <td rowspan="2"><br>ชื่อ - นามสกุล</td>
                            <td colspan="4">สิทธิ์การใช้งาน</td>
                            <td rowspan="2"><br>การจัดการ</td>
                        </tr> 
                        <tr style="text-align: center;">
                            <td>บุคลากร</td>
                            <td>หัวหน้าฝ่าย</td>
                            <td>ผู้บริหาร</td>
                            <td>ผู้ดูแลระบบ</td>
                        </tr>
                    </thead>
                    <tbody>';
                    $i=1;
                    foreach($sql as $sqls){
                        $data1 = DB::table('managerauthority')->where('USER_ID',$sqls->USER_ID)->first();
                        $data2 = DB::table('directorauthority')->where('USER_ID',$sqls->USER_ID)->first();
                        $data3 = DB::table('adminauthority')->where('USER_ID',$sqls->USER_ID)->first();
                        echo '  <tr style="text-align: center"> 
                                    <td>'.$i.'</td>';
                                    if($sqls->USER_STATUS==1){
                                        echo ' <td style="color:red">ปิดการใช้งาน</td>';
                                    }else{
                                        echo '<td >เปิดการใช้งาน</td>';
                                    }  
                        echo'       <td>'.$sqls->USER_USERNAME.'
                                        <input type="hidden" id="userid'.$sqls->USER_ID.'" value="'.$sqls->USER_ID.'">
                                        <input type="hidden" id="userfname'.$sqls->USER_ID.'" value="'.$sqls->USER_FNAME.'">
                                        <input type="hidden" id="userlname'.$sqls->USER_ID.'" value="'.$sqls->USER_LNAME.'">
                                    </td>
                                    <td>'.$sqls->USER_FNAME.' - '.$sqls->USER_LNAME.'</td>
                                    <td><input type="checkbox" disabled Checked></td>
                                    <div class="checkbox-wrapper">';
                                
                                        if(!empty($data1)){
                                            echo '<td><input type="checkbox" onchange="testdata(this,1);" id="authority1" name="authority1[]" value="'.$sqls->USER_ID.'" checked ></td>';
                                        }else{
                                            echo '<td><input type="checkbox" name="authority1[]" value="'.$sqls->USER_ID.'" ></td>';
                                        }

                                        if(!empty($data2)){
                                            echo '<td><input type="checkbox" onchange="testdata(this,2)"; id="authority2" name="authority2[]" value="'.$sqls->USER_ID.'" checked></td>';
                                        }else{
                                            echo '<td><input type="checkbox" name="authority2[]" value="'.$sqls->USER_ID.'" ></td>';
                                        }

                                        if(!empty($data3)){
                                            echo '<td><input type="checkbox" onchange="testdata(this,3)"; id="authority3" name="authority3[]" value="'.$sqls->USER_ID.'" checked></td>';
                                        }else{
                                            echo '<td><input type="checkbox" name="authority3[]" value="'.$sqls->USER_ID.'" ></td>';
                                        }
                                echo'</div>';
                                if($sqls->USER_STATUS==1){
                                echo '<td>
                                        <button id="user" type="button" value="'.$sqls->USER_ID.'" onclick="changestatususer(this,1);" class="btn btn-outline-success btn-sm">เปิดการใช้งาน</button>
                                    </td>';
                                }else{
                                echo '<td>
                                        <button id="user" type="button" value="'.$sqls->USER_ID.'" onclick="changestatususer(this,2);" class="btn btn-outline-danger btn-sm" >ปิดการใช้งาน</button>
                                    </td>';
                                }
                            
                                echo '</tr>';
                                $i++ ;
                    }
                 
                echo '</tbody>
                </table>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                <button class="btn btn-primary" type="submit">ยืนยันการจัดการ</button>  
            ';
        }else{
            echo '0';
        }
       
    }
    
    public function delete($USER_ID){
        DB::table('user')->where('USER_ID', $USER_ID)->delete();
        return redirect()->route('manageaccount');
    }

    public function store(Request $request){
        if(isset($request['authority1'])){
            foreach($request['authority1'] as $data){
                $sql = DB::table('managerauthority')->where('USER_ID',$data)->first();
                if(empty($sql)){
                    DB::table('managerauthority')->insert(['USER_ID'=>$data]);
                }
            }
        }
        if(isset($request['authority2'])){
            foreach($request['authority2'] as $data){
                $sql = DB::table('directorauthority')->where('USER_ID',$data)->first();
                if(empty($sql)){
                    DB::table('directorauthority')->insert(['USER_ID'=>$data]);
                }
            }
        }
        if(isset($request['authority3'])){
            foreach($request['authority3'] as $data){
                // DB::table('user')->where('USER_ID',$data)->update(['AUTHORITY_ID'=>3]);
                $sql = DB::table('adminauthority')->where('USER_ID',$data)->first();
                if(empty($sql)){
                    DB::table('adminauthority')->insert(['USER_ID'=>$data]);
                }
            }
        }
        return redirect('manageaccount')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }


    public function Passdata($id,$chk){
        if($chk==1){
            DB::table('managerauthority')->where('USER_ID',$id)->delete();
        }
        if($chk==2){
            DB::table('directorauthority')->where('USER_ID',$id)->delete();
        }
        if($chk==3){
            DB::table('adminauthority')->where('USER_ID',$id)->delete();
        }
        return "0";
    }

    
    public function UpdateLimitAbsent(Request $request){
        // dd($request->all());
        $year = intval(date("Y"))+543;
        DB::table('limitabsenttype')->where('LIMITABSENTTYPE_ID', $request->LIMITABSENTTYPE_ID)->update(['LIMITABSENTTYPE_NUMBER' => $request->number,'LIMITABSENTTYPE_BUDGETYEAR'=>$year]);
        return redirect('dayleave')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
    }
  
}