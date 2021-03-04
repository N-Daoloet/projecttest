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

        $access_token = 'mg0QCvTND40vINcyqg89CL96XZbN7Kpd'; // <----- API - Access Token Here
        $scopes 	= 'personel,student,templecturer'; 	// <----- Scopes for search account type
        $username 	= ''.$request->Username.''; // <----- Username for authen
        $password 	= ''.$request->Password.''; 	// <----- Password for authen
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
            // dd($json_data);
            if(!isset($json_data['api_status'])){
                return back()->with('error','ระบบไม่พร้อมให้บริการ');

            }elseif($json_data['api_status'] == 'success'){
                $user = DB::Table('user')->where('USER_USERNAME',$request->Username)->first();
                // dd($user);
                if(empty($user)){
                    return back()->with('error','ไม่พบผู้ใช้');
                }elseif($user->USER_STATUS==1){
                    return back()->with('error','บัญชีนี้ถูกปิดการใช้งาน');
                
                }else{
                   

                        Session::put('userid',$user->USER_ID);
                        Session::put('userfn',$user->USER_FNAME);
                        Session::put('userln',$user->USER_LNAME);
                        Session::put('displayname',$user->USER_DISPLAYNAME);
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
                    
                }
            
                return redirect('adduser');
               
            }elseif($json_data['api_status'] == 'fail'){
                // echo "API Error: " . $json_data['api_status_code'] . ' - ' . $json_data['api_message'];
                return back()->with('error', $json_data['api_message']);

            }else{
                return back()->with('error','ระบบไม่พร้อมให้บริการ');

            }
        }
        curl_close($ch);

       
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
