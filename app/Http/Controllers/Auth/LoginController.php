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
        if($user->USER_STATUS==1){
            return back()->with('error','บัญชีนี้ถูกปิดการใช้งาน');
        }else{
            if(!empty($user) ){
                if($user->USER_PASSWORD==$request->Password){
                
                    Session::put('userid',$user->USER_ID);
                    Session::put('userfn',$user->USER_FNAME);
                    Session::put('userln',$user->USER_LNAME);
                    Session::put('userdep',$user->DEP_ID);
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
                            'userid' => $user->USER_ID,
                        );
                    }elseif(!empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && empty($data1->DIRECTORAUTHORITY_ID)){
                        $arr = array(
                            'admin' => 1,
                            'manager' => 0,
                            'director' => 0,
                            'user' => 1,
                            'userid' => $user->USER_ID,
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
                            'userid' => $user->USER_ID,
                            
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
                            'userid' => $user->USER_ID,
                            
                        );
                    }elseif(!empty($data1->ADMINAUTHORITY_ID) && empty($data1->MANAGERAUTHORITY_ID) && !empty($data1->DIRECTORAUTHORITY_ID)){
                        $arr = array(
                            'admin' => 1,
                            'manager' => 0,
                            'director' => 1,
                            'user' => 0,
                            'userid' => $user->USER_ID,
                            
                        );
                    }
                    return view('selectauthority',$arr);
                }else{
                    return back();
                }
            }else{
                return back();
    
            } 
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
