<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function checklogin(Request $request){
        $email=  $request->Email;
        $user = DB::table('user')->where('USER_EMAIL', $email)->first();
        // dd($user);
        if($user->USER_STATUS==1){
            return back()->with('error','บัญชีนี้ถูกปิดการใช้งาน');
        }else{
            if(!empty($user)){

                $access_token = 'mg0QCvTND40vINcyqg89CL96XZbN7Kpd'; // <----- API - Access Token Here
                $scopes 	= 'personel,student,templecturer'; 	// <----- Scopes for search account type
                $username 	= ''.$user->USER_USERNAME.''; // <----- Username for authen
                $password 	= ''.$user->USER_PASSWORD.''; 	// <----- Password for authen
                $api_url = 'https://api.account.kmutnb.ac.th/api/account-api/user-authen'; // <----- API URL
                
                $ch = curl_init();// Initiate connection
                curl_setopt($ch, CURLOPT_URL, $api_url); // set url
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // 10s timeout time for cURL connection
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Allow https verification if true
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Verify the certificate's name against host 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// Set so curl_exec returns the result instead of outputting it.
                curl_setopt($ch, CURLOPT_POST, true);// Set post method
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // automatically follow Location: headers (ie redirects)
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('scopes' => $scopes, 'username' => $username, 'password' => $password));
                
                if(($response = curl_exec($ch)) === false){
                    echo 'Curl error: ' . curl_errno($ch) . ' - ' . curl_error($ch);
                }else{
                    $json_data = json_decode($response, true);
                    if(!isset($json_data['api_status'])){
                        return back()->with('error','ระบบไม่พร้อมให้บริการ');

                    }elseif($json_data['api_status'] == 'success'){
                        if($user->USER_PASSWORD==$request->Password){
                
                            Session::put('userid',$user->USER_ID);
                            Session::put('userfn',$user->USER_FNAME);
                            Session::put('userln',$user->USER_LNAME);
                            Session::put('displayname',$json_data['userInfo']['displayname']);
                            Session::put('userdep',$user->DEP_ID);
                            Session::put('userper',$user->PERTYPE_ID);
                            $arr = array(
                                'admin' => 0,
                                'manager' => 0,
                                'director' => 0,
                                'user' => 0,
                                
                            );
                            $data1 = DB::Table('user')->leftJoin('adminauthority','user.USER_ID','=','adminauthority.USER_ID')
                                        ->leftJoin('directorauthority','user.USER_ID','=','directorauthority.USER_ID')
                                        ->leftJoin('managerauthority','user.USER_ID','=','managerauthority.USER_ID')
                                        ->where('user.USER_ID',$user->USER_ID)->first();
                            if(empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
                            
                                Session::put('type','user');
                                return redirect('indexuser');
                            }elseif(!empty($data1->ADMINAUTHORITY_ID) && !empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
                                $arr = array(
                                    'admin' => 1,
                                    'manager' => 1,
                                    'director' => 1,
                                    'user' => 0,
                                    'userid' => Session::get('userid'),
                                );
                            }elseif(!empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
                                $arr = array(
                                    'admin' => 1,
                                    'manager' => 0,
                                    'director' => 0,
                                    'user' => 1,
                                    'userid' => Session::get('userid'),
                                );
                            }elseif(empty($data1->ADMINAUTHORITY_ID) && !empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
                                
                                Session::put('type','manager');
                                return redirect('indexmanager');
                            }elseif(!empty($data1->ADMINAUTHORITY_ID) && !empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
                                $arr = array(
                                    'admin' => 1,
                                    'manager' => 1,
                                    'director' => 0,
                                    'user' => 0,
                                    'userid' => Session::get('userid'),
                                    
                                );
                            }elseif(empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
                                
                                Session::put('type','director');
                                return redirect('approvedirector');
                            }elseif(empty($data1->ADMINAUTHORITY_ID) && !empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
                                $arr = array(
                                    'admin' => 0,
                                    'manager' => 1,
                                    'director' => 1,
                                    'user' => 0,
                                    'userid' => Session::get('userid'),
                                    
                                );
                            }elseif(!empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
                                $arr = array(
                                    'admin' => 1,
                                    'manager' => 0,
                                    'director' => 1,
                                    'user' => 0,
                                    'userid' => Session::get('userid'),
                                    'message' => $json_data['api_message'],
                                    
                                );
                            }

                            // dd($arr);
                            return view('selectauthority',$arr);
        
                        }else{
                            return back()->with('error','ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');
                        }

                        // echo 'Login success';
                        // echo "<br />=============================";
                        // echo "<br />Username: " . $json_data['userInfo']['username'];
                        // echo "<br />Displayname: " . $json_data['userInfo']['displayname'];
                        // echo "<br />Firstname EN: " . $json_data['userInfo']['firstname_en'];
                        // echo "<br />Lirstname EN: " . $json_data['userInfo']['lastname_en'];
                        // echo "<br />pid: " . $json_data['userInfo']['pid'];
                        // echo "<br />Email: " . $json_data['userInfo']['email'];
                        // echo "<br />Birthdate: " . $json_data['userInfo']['birthdate'];
                        // echo "<br />Account type: " . $json_data['userInfo']['account_type'];
                    }elseif($json_data['api_status'] == 'fail'){
                        // echo "API Error: " . $json_data['api_status_code'] . ' - ' . $json_data['api_message'];
                        return back()->with('error', $json_data['api_message']);

                    }else{
                        return back()->with('error','ระบบไม่พร้อมให้บริการ');

                    }
                }
                curl_close($ch);


            }else{
                return back()->with('error','ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');
            }

            // if(!empty($user)){

            //     if($user->USER_PASSWORD==$request->Password){
        
            //         Session::put('userid',$user->USER_ID);
            //         Session::put('userfn',$user->USER_FNAME);
            //         Session::put('userln',$user->USER_LNAME);
            //         Session::put('displayname','test');
            //         Session::put('userdep',$user->DEP_ID);
            //         Session::put('userper',$user->PERTYPE_ID);
            //         $arr = array(
            //             'admin' => 0,
            //             'manager' => 0,
            //             'director' => 0,
            //             'user' => 0,
                        
            //         );
            //         $data1 = DB::Table('user')->leftJoin('adminauthority','user.USER_ID','=','adminauthority.USER_ID')
            //                     ->leftJoin('directorauthority','user.USER_ID','=','directorauthority.USER_ID')
            //                     ->leftJoin('managerauthority','user.USER_ID','=','managerauthority.USER_ID')
            //                     ->where('user.USER_ID',$user->USER_ID)->first();
            //         if(empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
                        
            //             Session::put('type','user');
            //             return redirect('indexuser');
            //         }elseif(!empty($data1->ADMINAUTHORITY_ID) && !empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
            //             $arr = array(
            //                 'admin' => 1,
            //                 'manager' => 1,
            //                 'director' => 1,
            //                 'user' => 0,
            //                 'userid' => Session::get('userid'),
            //             );
            //         }elseif(!empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
            //             $arr = array(
            //                 'admin' => 1,
            //                 'manager' => 0,
            //                 'director' => 0,
            //                 'user' => 1,
            //                 'userid' => Session::get('userid'),
            //             );
            //         }elseif(empty($data1->ADMINAUTHORITY_ID) && !empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
                        
            //             Session::put('type','manager');
            //             return redirect('indexmanager');
            //         }elseif(!empty($data1->ADMINAUTHORITY_ID) && !empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
            //             $arr = array(
            //                 'admin' => 1,
            //                 'manager' => 1,
            //                 'director' => 0,
            //                 'user' => 0,
            //                 'userid' => Session::get('userid'),
                            
            //             );
            //         }elseif(empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
                        
            //             Session::put('type','director');
            //             return redirect('approvedirector');
            //         }elseif(empty($data1->ADMINAUTHORITY_ID) && !empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
            //             $arr = array(
            //                 'admin' => 0,
            //                 'manager' => 1,
            //                 'director' => 1,
            //                 'user' => 0,
            //                 'userid' => Session::get('userid'),
                            
            //             );
            //         }elseif(!empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
            //             $arr = array(
            //                 'admin' => 1,
            //                 'manager' => 0,
            //                 'director' => 1,
            //                 'user' => 0,
            //                 'userid' => Session::get('userid'),
            //                 'message' => $json_data['api_message'],
                            
            //             );
            //         }

            //         // dd($arr);
            //         return view('selectauthority',$arr);



            //     }else{
            //         return back()->with('error','ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');
        
            //     } 

                
        
            // } 
        }
       
    }

    public function checklogin2(Request $request){
        if($request->privilege==1){
            Session::put('type','admin');
            return redirect('addimage');
        }elseif($request->privilege==2){
            Session::put('type','director');
            return redirect('approvedirector');
        }elseif($request->privilege==3){
            Session::put('type','manager');
            return redirect('indexmanager');
        }else{
            Session::put('type','1');
            return redirect('indexuser');
        }

        
        // $user = DB::table('user')->where('USER_EMAIL', $email)->first();
        // return view('user.index');
    }

    public function checkuser(Request $request){
        $user = DB::table('user')->where('USER_EMAIL', $email)->first();
        return view('user.index');
    }

}
