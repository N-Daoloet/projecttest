<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Storage;
use Image;
use App\Staff;

class AdminController extends Controller
{

    public function updateimage(Request $request){
        // dd();
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

        $access_token = 'mg0QCvTND40vINcyqg89CL96XZbN7Kpd'; // <----- API - Access Token Here
        $username 	= ''.$ict.''; // <----- Username for search

        $api_url = 'https://api.account.kmutnb.ac.th/api/account-api/user-info'; // <----- API URL

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('username' => $username));

        if(($response = curl_exec($ch)) === false){
             echo '0';
        }else{
            $json_data = json_decode($response, true);
            if(!isset($json_data['api_status'])){
                echo '0';
                
        // <input type="hidden" name="userid" value="'.$json_data['userInfo']['pid'].'">
            }elseif($json_data['api_status'] == 'success'){
            //   dd($json_data);
                $sql = DB::connection('sqlsrv')->table('dbo.NGAC_USERINFO')->select('Name','ID')->where('AuthType',1)->get();

                echo '
                            <br>';
                            if(!empty($user))
                                echo '<input type="hidden" id="havedata" value="1">';
                            else{
                                echo '<input type="hidden" id="havedata" value="0">';

                            }
                    echo    '<div class="form">
                                <div class="row form-group"> 
                                    <div class="col-6">
                                        <label for="exampleFormControlSelect1">บัญชีผู้ใช้</label>
                                        <input type="text" class="form-control" id="" name="username" value="'.$json_data['userInfo']['username'].'" readonly><br>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">อีเมล</label>
                                        <input type="text" class="form-control" id="" name="email" value="'.$json_data['userInfo']['email'].'" readonly><br>
                                    </div>
                                </div>

                                <div class="row form-group"> 
                                    <div class="col-6">
                                        <label class="form-label">ชื่อ-นามสกุล (ไทย)</label>
                                        <input type="text" class="form-control" id="" name="displayname" value="'.$json_data['userInfo']['displayname'].'" readonly><br>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">ชื่อ-นามสกุล (อังกฤษ)</label>
                                        <input type="text" class="form-control" id="" name="firstlast" value="'.$json_data['userInfo']['firstname_en'].'  '.$json_data['userInfo']['lastname_en'].'" readonly><br>
                                    </div>
                                </div>

                                <div class="row form-group"> 
                                    <div class="col-6">
                                        <label for="exampleFormControlSelect1">สังกัดฝ่าย</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="depid" style="background-color:#ffffff" required>
                                            <option value="">กรุณาเลือก</option>';
                                                foreach($dep as $department){
                                                    if(!empty($user)){
                                                        echo '<option value="'.$department->DEP_ID.'" '.($user->DEP_ID==$department->DEP_ID?'selected':'').'>'.$department->DEP_NAME.'</option>';

                                                    }else{
                                                        echo '<option value="'.$department->DEP_ID.'">'.$department->DEP_NAME.'</option>';

                                                    }
                                                }
                                        echo '</select>
                                    </div>
                                    <div class="col-6">
                                        <label for="exampleFormControlSelect1">ประเภทบุคลากร</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="perid" style="background-color:#ffffff" required>
                                            <option value="">กรุณาเลือก</option>';
                                            foreach($per as $personal){
                                                if(!empty($user)){
                                                    echo ' <option value="'.$personal->PERTYPE_ID.'" '.($user->PERTYPE_ID==$personal->PERTYPE_ID?'selected':'').'>'.$personal->PERTYPE_NAME.'</option>';

                                                }else{
                                                    echo ' <option value="'.$personal->PERTYPE_ID.'">'.$personal->PERTYPE_NAME.'</option>';

                                                }
                                            }
                                        echo '</select>
                                    </div>

                                
                                </div> 
                                
                                <div class="row form-group"> 
                                    <div class="col-6">
                                    <br>
                                        <label class="form-label">วันที่บรรจุ</label>
                                        <input type="date" class="form-control" id="" name="startdate" value="'.(!empty($user->USER_START_DATE)?$user->USER_START_DATE:'').'" style="background-color:#ffffff" required>
                                    </div> 
                                   
                                 
                                    <div class="col-6">
                                    <br>
                                        <label class="form-label">รายชื่อจากเครื่องสแกนลายนิ้วมือ</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="empid" style="background-color:#ffffff">
                                        <option value="">กรุณาเลือก</option>';
                                        foreach($sql as $sqls){
                                            if(!empty($user)){
                                                echo '<option value="'.$sqls->ID.'" '.($user->USER_EMP_ID==$sqls->ID?'selected':'').'>'.$sqls->Name.'</option>';

                                            }else{
                                                echo '<option value="'.$sqls->ID.'">'.$sqls->Name.'</option>';

                                            }
                                        }

                                            
                                    echo '</select>
                                    </div> 
                                   
                                </div>
                                
                                
                                
                            </div>
                                   
                                </div>
                                    
                                    <input type="hidden" class="form-control" id="" name="firstname" value="'.$json_data['userInfo']['firstname_en'].'" ><br>
                                    <input type="hidden" class="form-control" id="" name="lastname" value="'.$json_data['userInfo']['lastname_en'].'" ><br>
                                   
                                    <button class="btn btn-primary" type="button" onclick="submitformuser();">เพิ่ม</button>
                                </div>
                            </div>
                
                ';
            }elseif($json_data['api_status'] == 'fail'){
                echo '0';

            }else{
                echo '0';

            }	
        }
        curl_close($ch);

       
    }
    
    public function updateuser(Request $request){
        // dd( $request->all());
        $sql = DB::Table('user')->where('USER_USERNAME',$request->username)->first();
        if(empty($sql)){
            $user = new Staff;
            $user->USER_USERNAME = $request->username;
            $user->USER_DISPLAYNAME = $request->displayname;
            $user->USER_EMAIL = $request->email;
            $user->USER_FNAME = $request->firstname;
            $user->USER_LNAME = $request->lastname;
            $user->USER_START_DATE = $request->startdate;
            $user->DEP_ID = $request->depid;
            $user->PERTYPE_ID = $request->perid;
            $user->USER_EMP_ID = $request->empid;
            $user->save();
            
        }else{
            if(isset($request->depid)){
                DB::table('user')->where('USER_USERNAME', $request->username)->update(['DEP_ID' => $request->depid]);
    
            }
            if(isset($request->perid)){
                DB::table('user')->where('USER_USERNAME', $request->username)->update(['PERTYPE_ID' => $request->perid]);
    
            }
    
            if(isset($request->startdate)){
                DB::table('user')->where('USER_USERNAME', $request->username)->update(['USER_START_DATE' => $request->startdate]);
    
            }

            if(isset($request->empid)){
                DB::table('user')->where('USER_USERNAME', $request->username)->update(['USER_EMP_ID' => $request->empid]);
    
            }
        }
        
        
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
                ->orderBy('USER_STATUS','ASC')
                ->get();

        // dd($sql);

        if(count($sql)>0){
            echo '
            <br>
                    <div class="col-md-12">
                        <hr style="background-color: #3f4d67;width:900px">
                            <div class="card-block table-border-style">
                                <div class="table-responsive">
                                    <table id="responsive-table" class="table table-bordered">
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
                                                <td>ผู้อำนวยการ</td>
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
                                                        <td>'.$sqls->USER_FNAME.' '.$sqls->USER_LNAME.'</td>
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
                                                            <button id="user" type="button" value="'.$sqls->USER_ID.'" onclick="changestatususer(this,1);" class="btn btn-outline-primary btn-sm">ปรับปรุงสถานะ</button>
                                                        </td>';
                                                    }else{
                                                    echo '<td>
                                                            <button id="user" type="button" value="'.$sqls->USER_ID.'" onclick="changestatususer(this,2);" class="btn btn-outline-primary btn-sm" >ปรับปรุงสถานะ</button>
                                                        </td>';
                                                    }
                                                
                                                    echo '</tr>';
                                                    $i++ ;
                                        }
                                    
                                    echo '</tbody>
                                    </table>
                                </div>
                            </div>
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                            <button class="btn btn-primary" type="submit">ยืนยันการจัดการ</button>  
                    </div>
                   
                
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

        $group = DB::Table('group_personal')->where('id_personal',$request->perid)->first();

        if($request->perid == 3 || $request->perid == 4){

            if(isset($request->sicklesssixlimit1)){
                $sql = DB::Table('limitsickprivate')
                            ->where([
                                ['sickprivate_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['sickprivate_round','=', 1],
                                ['sickprivate_less','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitsickprivate')->where('sickprivate_year',$request->year)
                        ->where('id_group',$group->id_group)->where('sickprivate_round',1)->where('sickprivate_less',1)
                        ->update(['sickprivate_limit'=>$request->sicklesssixlimit1]);
                }else{
                    DB::Table('limitsickprivate')->insert(['sickprivate_year'=>$request->year,'id_group'=>$group->id_group,
                    'sickprivate_less'=>1,'sickprivate_round'=>1,'sickprivate_number'=>NULL,'sickprivate_limit'=>$request->sicklesssixlimit1]);
                }

            }

            if(isset($request->sicklesssixlimit2)){
                $sql = DB::Table('limitsickprivate')
                            ->where([
                                ['sickprivate_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['sickprivate_round','=', 2],
                                ['sickprivate_less','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitsickprivate')->where('sickprivate_year',$request->year)
                        ->where('id_group',$group->id_group)->where('sickprivate_round',2)->where('sickprivate_less',2)
                        ->update(['sickprivate_limit'=>$request->sicklesssixlimit2]);
                }else{
                    DB::Table('limitsickprivate')->insert(['sickprivate_year'=>$request->year,'id_group'=>$group->id_group,
                    'sickprivate_less'=>2,'sickprivate_round'=>2,'sickprivate_number'=>NULL,'sickprivate_limit'=>$request->sicklesssixlimit2]);
                }

            }


            if(isset($request->sickmoresixlimit1)){
                $sql = DB::Table('limitsickprivate')
                            ->where([
                                ['sickprivate_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['sickprivate_round','=', 1],
                                ['sickprivate_more','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitsickprivate')->where('sickprivate_year',$request->year)
                        ->where('id_group',$group->id_group)->where('sickprivate_round',1)->where('sickprivate_more',1)
                        ->update(['sickprivate_limit'=>$request->sickmoresixlimit1]);
                }else{
                    DB::Table('limitsickprivate')->insert(['sickprivate_year'=>$request->year,'id_group'=>$group->id_group,
                    'sickprivate_more'=>1,'sickprivate_round'=>1,'sickprivate_number'=>NULL,'sickprivate_limit'=>$request->sickmoresixlimit1]);
                }

            }

            if(isset($request->sickmoresixlimit2)){
                $sql = DB::Table('limitsickprivate')
                            ->where([
                                ['sickprivate_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['sickprivate_more','=', 2],
                                ['sickprivate_round','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitsickprivate')->where('sickprivate_year',$request->year)
                        ->where('id_group',$group->id_group)->where('sickprivate_round',2)->where('sickprivate_more',2)
                        ->update(['sickprivate_limit'=>$request->sickmoresixlimit2]);
                }else{
                    DB::Table('limitsickprivate')->insert(['sickprivate_year'=>$request->year,'id_group'=>$group->id_group,
                    'sickprivate_more'=>2,'sickprivate_round'=>2,'sickprivate_number'=>NULL,'sickprivate_limit'=>$request->sickmoresixlimit2]);
                }

            }





            if(isset($request->vacalesssixlimit1)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_less','=', 1],
                                ['vacation_round','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',1)->where('vacation_less',1)
                        ->update(['vacation_limit'=>$request->vacalesssixlimit1]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,'vacation_less'=>1,
                                                'vacation_round'=>1,'vacation_number'=>NULL,'vacation_limit'=>$request->vacalesssixlimit1]);
                }
    
            }
    
            if(isset($request->vacalesssixlimit2)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_less','=', 2],
                                ['vacation_round','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)->where('vacation_less',2)
                        ->where('id_group',$group->id_group)->where('vacation_round',2)
                        ->update(['vacation_limit'=>$request->vacalesssixlimit2]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,'vacation_less'=>2,
                                                'vacation_round'=>2,'vacation_number'=>NULL,'vacation_limit'=>$request->vacalesssixlimit2]);
                }
    
            }


            if(isset($request->vacamoresixlimit1)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_more','=', 1],
                                ['vacation_round','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',1)->where('vacation_more',1)
                        ->update(['vacation_limit'=>$request->vacamoresixlimit1]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,'vacation_more'=>1,
                                                'vacation_round'=>1,'vacation_number'=>NULL,'vacation_limit'=>$request->vacamoresixlimit1]);
                }
    
            }
    
            if(isset($request->vacamoresixlimit2)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_more','=', 2],
                                ['vacation_round','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',2)->where('vacation_more',2)
                        ->update(['vacation_limit'=>$request->vacamoresixlimit2]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,'vacation_more'=>2,
                                                'vacation_round'=>2,'vacation_number'=>NULL,'vacation_limit'=>$request->vacamoresixlimit2]);
                }
    
            }

        }else if($request->perid == 2){
            if(isset($request->sicknumber1)){
                $sql = DB::Table('limitsickprivate')
                            ->where([
                                ['sickprivate_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['sickprivate_round','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitsickprivate')->where('sickprivate_year',$request->year)
                        ->where('id_group',$group->id_group)->where('sickprivate_round',1)
                        ->update(['sickprivate_number'=>$request->sicknumber1,'sickprivate_limit'=>$request->sicklimit1]);
                }else{
                    DB::Table('limitsickprivate')->insert(['sickprivate_year'=>$request->year,'id_group'=>$group->id_group,
                                                'sickprivate_round'=>1,'sickprivate_number'=>$request->sicknumber1,'sickprivate_limit'=>$request->sicklimit1]);
                }
            }

            if(isset($request->sicknumber2)){
                $sql = DB::Table('limitsickprivate')
                            ->where([
                                ['sickprivate_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['sickprivate_round','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitsickprivate')->where('sickprivate_year',$request->year)
                        ->where('id_group',$group->id_group)->where('sickprivate_round',2)
                        ->update(['sickprivate_number'=>$request->sicknumber2,'sickprivate_limit'=>$request->sicklimit2]);
                }else{
                    DB::Table('limitsickprivate')->insert(['sickprivate_year'=>$request->year,'id_group'=>$group->id_group,
                                                'sickprivate_round'=>2,'sickprivate_number'=>$request->sicknumber2,'sickprivate_limit'=>$request->sicklimit2]);
                }
            }
        

        }else{
            if(isset($request->sicklimit1)){
                $sql = DB::Table('limitsickprivate')
                            ->where([
                                ['sickprivate_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['sickprivate_round','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitsickprivate')->where('sickprivate_year',$request->year)
                        ->where('id_group',$group->id_group)->where('sickprivate_round',1)
                        ->update(['sickprivate_limit'=>$request->sicklimit1]);
                }else{
                    DB::Table('limitsickprivate')->insert(['sickprivate_year'=>$request->year,'id_group'=>$group->id_group,
                                                'sickprivate_round'=>1,'sickprivate_number'=> NULL,'sickprivate_limit'=>$request->sicklimit1]);
                }
            }

            if(isset($request->sicklimit2)){
                $sql = DB::Table('limitsickprivate')
                            ->where([
                                ['sickprivate_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['sickprivate_round','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitsickprivate')->where('sickprivate_year',$request->year)
                        ->where('id_group',$group->id_group)->where('sickprivate_round',2)
                        ->update(['sickprivate_limit'=>$request->sicklimit2]);
                }else{
                    DB::Table('limitsickprivate')->insert(['sickprivate_year'=>$request->year,'id_group'=>$group->id_group,
                                                'sickprivate_round'=>2,'sickprivate_number'=>NULL,'sickprivate_limit'=>$request->sicklimit2]);
                }
            }


            if(isset($request->vacalimit1)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_round','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',1)
                        ->update(['vacation_limit'=>$request->vacalimit1]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,
                                                'vacation_round'=>1,'vacation_number'=>NULL,'vacation_limit'=>$request->vacalimit1]);
                }
    
            }

            if(isset($request->vacalimit2)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_round','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',2)
                        ->update(['vacation_limit'=>$request->vacalimit2]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,
                                                'vacation_round'=>2,'vacation_number'=>NULL,'vacation_limit'=>$request->vacalimit2]);
                }
    
            }
            
        }
    
       


       
        if($request->perid == 2){
            if(isset($request->vacalesstenlimit1)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_less','=', 1],
                                ['vacation_round','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',1)->where('vacation_less',1)
                        ->update(['vacation_limit'=>$request->vacalesstenlimit1]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,'vacation_round'=>1,
                        'vacation_less'=>1,'vacation_number'=>NULL,'vacation_limit'=>$request->vacalesstenlimit1]);
                }
    
            }
    
            if(isset($request->vacalesstenlimit2)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_round','=', 2],
                                ['vacation_less','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',2)->where('vacation_less',2)
                        ->update(['vacation_limit'=>$request->vacalesstenlimit2]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,'vacation_round'=>2,
                        'vacation_less'=>2,'vacation_number'=>NULL,'vacation_limit'=>$request->vacalesstenlimit2]);
                }
    
            }


            if(isset($request->vacamoretenlimit1)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_more','=', 1],
                                ['vacation_round','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',1)->where('vacation_more',1)
                        ->update(['vacation_limit'=>$request->vacamoretenlimit1]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,'vacation_more'=>1,
                        'vacation_round'=>1,'vacation_number'=>NULL,'vacation_limit'=>$request->vacamoretenlimit1]);
                }
    
            }
    
            if(isset($request->vacamoretenlimit2)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_more','=', 2],
                                ['vacation_round','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',2)->where('vacation_more',2)
                        ->update(['vacation_limit'=>$request->vacamoretenlimit2]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,'vacation_more'=>2,
                        'vacation_round'=>2,'vacation_number'=>NULL,'vacation_limit'=>$request->vacamoretenlimit2]);
                }
    
            }
    
        }else{

            if(isset($request->vacalimit1)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_round','=', 1]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',1)
                        ->update(['vacation_limit'=>$request->vacalimit1]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,
                                                'vacation_round'=>1,'vacation_number'=>NULL,'vacation_limit'=>$request->vacalimit1]);
                }
    
            }

            if(isset($request->vacalimit2)){
                $sql = DB::Table('limitvacation')
                            ->where([
                                ['vacation_year', '=', $request->year],
                                ['id_group', '=', $group->id_group],
                                ['vacation_round','=', 2]
                            ])->first();
                if(!empty($sql)){
                    DB::Table('limitvacation')->where('vacation_year',$request->year)
                        ->where('id_group',$group->id_group)->where('vacation_round',2)
                        ->update(['vacation_limit'=>$request->vacalimit2]);
                }else{
                    DB::Table('limitvacation')->insert(['vacation_year'=>$request->year,'id_group'=>$group->id_group,
                                                'vacation_round'=>2,'vacation_number'=>NULL,'vacation_limit'=>$request->vacalimit2]);
                }
    
            }

        }



        


       

            

        if(isset($request->limit7)){
            $sql = DB::Table('limitmaternity')
                        ->where([
                            ['maternity_year', '=', $request->year],
                            ['id_group', '=', $group->id_group],
                            ['maternity_round','=', 1]
                        ])->first();
            if(!empty($sql)){
                DB::Table('limitmaternity')->where('maternity_year',$request->year)
                    ->where('id_group',$group->id_group)->where('maternity_round',1)
                    ->update(['maternity_limit'=>$request->limit7]);
            }else{
                DB::Table('limitmaternity')->insert(['maternity_year'=>$request->year,'id_group'=>$group->id_group,
                'maternity_round'=>1,'maternity_number'=>NULL,'maternity_limit'=>$request->limit7]);
            }

        }


        if(isset($request->limit8)){
            $sql = DB::Table('limitmaternity')
                        ->where([
                            ['maternity_year', '=', $request->year],
                            ['id_group', '=', $group->id_group],
                            ['maternity_round','=', 2]
                        ])->first();
            if(!empty($sql)){
                DB::Table('limitmaternity')->where('maternity_year',$request->year)
                    ->where('id_group',$group->id_group)->where('maternity_round',2)
                    ->update(['maternity_limit'=>$request->limit8]);
            }else{
                DB::Table('limitmaternity')->insert(['maternity_year'=>$request->year,'id_group'=>$group->id_group,
                'maternity_round'=>2,'maternity_number'=>NULL,'maternity_limit'=>$request->limit8]);
            }

        }



        if(isset($request->limit9)){
            $sql = DB::Table('limitbaby')
                        ->where([
                            ['baby_year', '=', $request->year],
                            ['id_group', '=', $group->id_group],
                            ['baby_round','=', 1]
                        ])->first();
            if(!empty($sql)){
                DB::Table('limitbaby')->where('baby_year',$request->year)
                    ->where('id_group',$group->id_group)->where('baby_round',1)
                    ->update(['baby_limit'=>$request->limit9]);
            }else{
                DB::Table('limitbaby')->insert(['baby_year'=>$request->year,'id_group'=>$group->id_group,'baby_round'=>1,
                'baby_number'=>NULL,'baby_limit'=>$request->limit9]);
            }

        }


        if(isset($request->limit10)){
            $sql = DB::Table('limitbaby')
                        ->where([
                            ['baby_year', '=', $request->year],
                            ['id_group', '=', $group->id_group],
                            ['baby_round','=', 2]
                        ])->first();
            if(!empty($sql)){
                DB::Table('limitbaby')->where('baby_year',$request->year)
                    ->where('id_group',$group->id_group)->where('baby_round',2)
                    ->update(['baby_limit'=>$request->limit10]);
            }else{
                DB::Table('limitbaby')->insert(['baby_year'=>$request->year,'id_group'=>$group->id_group,'baby_round'=>2,
                'baby_number'=>NULL,'baby_limit'=>$request->limit10]);
            }

        }



        if(isset($request->limit11)){
            $sql = DB::Table('limitordination')
                        ->where([
                            ['ordination_year', '=', $request->year],
                            ['id_group', '=', $group->id_group],
                            ['ordination_round','=', 1]
                        ])->first();
            if(!empty($sql)){
                DB::Table('limitordination')->where('ordination_year',$request->year)
                    ->where('id_group',$group->id_group)->where('ordination_round',1)
                    ->update(['ordination_limit'=>$request->limit11]);
            }else{
                DB::Table('limitordination')->insert(['ordination_year'=>$request->year,'id_group'=>$group->id_group,
                'ordination_round'=>1,'ordination_number'=>NULL,'ordination_limit'=>$request->limit11]);
            }

        }


        if(isset($request->number12)){
            $sql = DB::Table('limitordination')
                        ->where([
                            ['ordination_year', '=', $request->year],
                            ['id_group', '=', $group->id_group],
                            ['ordination_round','=', 2]
                        ])->first();
            if(!empty($sql)){
                DB::Table('limitordination')->where('ordination_year',$request->year)
                    ->where('id_group',$group->id_group)->where('ordination_round',2)
                    ->update(['ordination_limit'=>$request->limit12]);
            }else{
                DB::Table('limitordination')->insert(['ordination_year'=>$request->year,'id_group'=>$group->id_group,
                'ordination_round'=>2,'ordination_number'=>NULLL,'ordination_limit'=>$request->limit12]);
            }

        }

        return redirect('dayleave')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');

       
    }


    public function Cancelbyadmin(Request $request)
    {
        // dd($request->all());absentid
        
        DB::Table('absentdetail')->where('ABSENT_ID',$request->absentid)->update(['STATUS_APPROVER'=>7,'ABSENT_CANCLE'=>$request->APPROVER_COMMENT]);
        return redirect()->route('checkleave')->with('success','บันทึกข้อมูลเรียบร้อยแล้ว');
        
        
    }

    public function Approveadmin(Request $request)
    {
        // dd($request->all());
        $chk = DB::Table('managerauthority')->where('USER_ID',$request->uid)->first();
        if(!empty($chk)){
            DB::Table('absentdetail')->where('ABSENT_ID',$request->id)->update(['STATUS_APPROVER'=>2]);

        }else{
            DB::Table('absentdetail')->where('ABSENT_ID',$request->id)->update(['STATUS_APPROVER'=>6]);

        }

        return 1;

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
        
        $user =  DB::Table('user')->where('DEP_ID', '=', $request->department)->get();

        if(count($user)>0){


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
                        if(count($user )>0){
                            foreach ($user  as $item){
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


    public function SearchWorkReport(Request $request){
        $odl = (((int)$request->year)-543)-1;
        $year = (((int)$request->year)-543);
       
       
        if($request->round==1){
            $datestart = ''.$odl.'-10-1';
            $dateend = ''.$year.'-03-31';
        }else{
            $datestart = ''.$year.'-04-1';
            $dateend = ''.$year.'-09-30';
        }
  
            $start = DB::Table('user')->where('DEP_ID', '=', $request->department)->get();

            $pluck = $start->pluck('USER_EMP_ID'); //convert to array

            $sql = DB::connection('sqlsrv')->table('dbo.EmpProcess')->whereBetween('workDate', [$datestart, $dateend])
                    ->whereIn('EmpCode',$pluck)->orderBy('EmpCode','ASC')->get();
           
        
      
       
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
                            
                           
                        echo '</tbody>
                    </table>
            ';
        }
        
    }
  
}