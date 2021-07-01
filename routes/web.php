<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// severname : DESKTOP-KPIPSBH\SQLEXPRESS
// username : DESKTOP-KPIPSBH\s5904
Route::get('/clc', function() {
   
    $sql = DB::connection('sqlsrv')->table('dbo.NGAC_USERINFO')->select('Name')->get();
    dd($sql);
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
        // Artisan::call('view:clear');
        // session()->forget('key');
    return "Cleared!";
});

Route::get('/', function () {
    $data = array(
        'data1' => DB::connection('mysql')->table('banner')->where('id_banner',1)->first(),
        'data2' => DB::connection('mysql')->table('banner')->where('id_banner',2)->first(),
        'data3' => DB::connection('mysql')->table('banner')->where('id_banner',3)->first(),
    );
    Session::flush();
    return view('intro',$data);
})->name('intro');

Route::get('login', function () {
    // Session::flush();
    return view('login');
})->name('login');

Route::post('login', 'Auth\LoginController@checklogin');

//เลือกสิทธิ์
Route::get('selectauthority', function () {
    return view('selectauthority');
})->name('selectauthority');

Route::post('selectlogin','Auth\LoginController@checklogin2');




Route::post('saveabsentsick','UserController@SaveAbsent');


Route::get('calculatedate','UserController@Calculatedate');


/////////////////////////////////user///////////////////////////////////
Route::group(['middleware'=>['UserLogin']],function(){

        //index

        Route::get('indexuser','UserController@Index')->name('indexuser');


        //ยื่นใบลา
        Route::get('sickleaveuser', function () {
            // $sql = DB::Table('group_personal')->leftJoin()->get();
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2; //round
            }else{
                $x=1;
            }

            $y = (int)date("Y")+543;
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();

            $dateinterval = date_diff(date_create($start->USER_START_DATE), date_create(date("Y-m-d")));
            $usedab = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',1)
                                    ->whereIn('STATUS_APPROVER',[0,2,4])
                                    ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                                    ->first();
            // dd($usedab->followers);
        
            if((int)$dateinterval->format('%y')>0){
            //more
                // dd($x);
                $data = array(
                    'user' => $start,
                    'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                    'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                    'usedab' => $usedab,
                    'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                    ->where('sickprivate_more',$x)->where('sickprivate_year',$y)->first(),
                
                );
            }else{
                if((int)$dateinterval->format('%m')>5){
                    $data = array(
                        'user' => $start,
                        'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                        'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                        'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                        ->where('sickprivate_more',$x)->where('sickprivate_year',$y)->first(),
                        'usedab' => $usedab,
                    
                    );

                }else{
                    //less
                    $data = array(
                        'user' => $start,
                        'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                        'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                        'usedab' => $usedab,
                        'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                        ->where('sickprivate_less',$x)->where('sickprivate_year',$y)->first(),
                        
                    );

                }
            }
            // dd($data);
            if(empty($data['limit'])){
                return redirect('indexuser')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('user.sickleaveuser',$data);

            }
        })->name('sickleaveuser');




        Route::get('vacationleaveuser', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2;
            }else{
                $x=1;
            }
            $y = (int)date("Y")+543;
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();

            $dateinterval = date_diff(date_create($start->USER_START_DATE), date_create(date("Y-m-d")));
            $usedab = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',2)
                                    ->whereIn('STATUS_APPROVER',[0,2,4])
                                    ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                                    ->first();

            if((int)$dateinterval->format('%y')>0){
            //more
                // dd($x);
                $data = array(
                    'user' => $start,
                    'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                    'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                    'usedab' => $usedab,
                    'limit' => DB::Table('limitvacation')->where('id_group',session::get('usergroup'))->where('vacation_round',$x)
                                    ->where('vacation_more',$x)->where('vacation_year',$y)->first(),
                
                );
            }else{
                if((int)$dateinterval->format('%m')>5){
                    $data = array(
                        'user' => $start,
                        'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                        'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                        'limit' => DB::Table('limitvacation')->where('id_group',session::get('usergroup'))->where('vacation_round',$x)
                                        ->where('vacation_more',$x)->where('vacation_year',$y)->first(),
                        'usedab' => $usedab,
                    
                    );

                }else{
                    if(Session::get('usergroup')==3){
                        return redirect('indexuser')->with('error','ยังไม่สามารถทำการลาได้ เนื่องจากยังทำงานไม่ครบ 6 เดือน');

                    }else{
                        $data = array(
                            'user' => $start,
                            'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                            'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                            'usedab' => $usedab,
                            'limit' => DB::Table('limitvacation')->where('id_group',session::get('usergroup'))->where('vacation_round',$x)
                                            ->where('vacation_less',$x)->where('vacation_year',$y)->first(),
                            
                        );


                    }


                    //less
                    
                }
            }
                // dd($x);
            if(empty($data['limit'])){
                return redirect('indexuser')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('user.vacationleaveuser',$data);

            }
            
        })->name('vacationleaveuser');


        Route::get('privateleaveuser', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2; //round
            }else{
                $x=1;
            }

            $y = (int)date("Y")+543;
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();

            $dateinterval = date_diff(date_create($start->USER_START_DATE), date_create(date("Y-m-d")));
            $usedab = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',1)
                            ->whereIn('STATUS_APPROVER',[0,2,4])
                            ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                            ->first();


            if((int)$dateinterval->format('%y')>0){
            //more
                // dd($x);
                $data = array(
                    'user' => $start,
                    'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                    'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                    'usedab' => $usedab,
                    'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                    ->where('sickprivate_more',$x)->where('sickprivate_year',$y)->first(),
                
                );
            }else{
                if((int)$dateinterval->format('%m')>5){
                    $data = array(
                        'user' => $start,
                        'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                        'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                        'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                        ->where('sickprivate_more',$x)->where('sickprivate_year',$y)->first(),
                        'usedab' => $usedab,
                    
                    );

                }else{
                    //less
                    $data = array(
                        'user' => $start,
                        'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                        'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                        'usedab' => $usedab,
                        'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                        ->where('sickprivate_less',$x)->where('sickprivate_year',$y)->first(),
                        
                    );

                }
            }
            if(empty($data['limit'])){
                return redirect('indexuser')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('user.privateleaveuser',$data);

            }


        })->name('privateleaveuser');


        Route::get('maternityleaveuser', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2;
            }else{
                $x=1;
            }
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
            $y = (int)date("Y")+543;
            $usedab = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',3)
                        ->whereIn('STATUS_APPROVER',[0,2,4])
                        ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                        ->first();


        
            $data = array(
                'user' => $start,
                'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                'usedab' => $usedab,
                'limit' => DB::Table('limitmaternity')->where('id_group',session::get('usergroup'))->where('maternity_round',$x)
                                ->where('maternity_year',$y)->first(),
                                
                
            );

            if(empty($data['limit'])){
                return redirect('indexuser')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('user.maternityleaveuser',$data);

            }
        
            
        })->name('maternityleaveuser');


        Route::get('babyuser', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2;
            }else{
                $x=1;
            }
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
            $y = (int)date("Y")+543;
            $usedab = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',4)
                            ->whereIn('STATUS_APPROVER',[0,2,4])
                            ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                            ->first();


        
            $data = array(
                'user' => $start,
                'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                'usedab' => $usedab,
                'limit' => DB::Table('limitbaby')->where('id_group',session::get('usergroup'))->where('baby_round',$x)->where('baby_year',$y)->first(),
                
            );

            if(empty($data['limit'])){
                return redirect('indexuser')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('user.babyuser',$data);

            }

        })->name('babyuser');


        Route::get('ordinationleaveuser', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2;
            }else{
                $x=1;
            }
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
            $y = (int)date("Y")+543;
        
            $data = array(
                'user' => $start,
                'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                // 'usedab' => DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',5)->get(),
                // 'limit' => DB::Table('limitordination')->where('id_group',session::get('usergroup'))->where('ordination_round',$x)->where('ordination_year',$y)->first(),
                
            );

            return view('user.ordinationleaveuser',$data);

        })->name('ordinationleaveuser');


        //ยกเลิกใบลา
        Route::get('cancelsickleaveuser', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',1)->where('APPROVER_CHECK',1)->get(),
            );
            // dd($data['data']);
            return view('user.cancelsickleaveuser',$data);
        })->name('cancelsickleaveuser');

        Route::post('cancleofid','UserController@Cancleofid');


        Route::get('cancelvacationleaveuser', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',2)->get(),
            );

            return view('user.cancelvacationleaveuser',$data);
        })->name('cancelvacationleaveuser');


        Route::get('cancelprivateleaveuser', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',1)->where('APPROVER_CHECK',2)->get(),
            );

            return view('user.cancelprivateleaveuser',$data);

        })->name('cancelprivateleaveuser');


        Route::get('cancelmaternityleaveuser', function () { //ลาคลอด
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',3)->get(),
            );
            // dd($data['data']);
            return view('user.cancelmaternityleaveuser',$data);
        })->name('cancelmaternityleaveuser');


        Route::get('cancelbabyuser', function () { //ช่วยคลอด
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',4)->get(),
            );
            // dd($data['data']);
            return view('user.cancelbabyuser',$data);

        
        })->name('cancelbabyuser');


        Route::get('cancelordinationleaveuser', function () { //ลาบวช
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',5)->get(),
            );
            // dd($data['data']);
            return view('user.cancelordinationleaveuser',$data);

        
        })->name('cancelordinationleaveuser');

        //สถานะการลา
        Route::get('statususer', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))
                            ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                            ->orderBy('ABSENT_START','DESC')->get(),
            );
            return view('user.statususer',$data);
        })->name('statususer');

        //รายงานการลา
        Route::get('reportleaveuser', function () {
            return view('user.reportleaveuser');
        })->name('reportleaveuser');

        //รายงานการมาปฏิบัติงาน
        Route::get('workinguser', function () {
            return view('user.workinguser');
        })->name('workinguser');

        //การอนุมัติ
        Route::get('approveuser', function () {
            return view('user.approveuser');
        })->name('approveuser');

        Route::get('searchworkreportuser', 'UserController@SearchworkReportuser');

});





/////////////////////////////////////////////manager/////////////////////////////////////////////

Route::group(['middleware'=>['ManagerLogin']],function(){

        //index
        Route::get('indexmanager','ManagerController@Index')->name('indexmanager');

        //ยื่นใบลา
        Route::get('sickleavemanager', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2; //round
            }else{
                $x=1;
            }

            $y = (int)date("Y")+543;
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();

            $dateinterval = date_diff(date_create($start->USER_START_DATE), date_create(date("Y-m-d")));
            $usedab = DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',1)
                                    ->whereIn('STATUS_APPROVER',[0,2,4])
                                    ->select( DB::raw('SUM(ABSENT_NUMBER) as followers'))
                                    ->first();
            // dd($usedab->followers);
        
            if((int)$dateinterval->format('%y')>0){
            //more
                // dd($x);
                $data = array(
                    'user' => $start,
                    'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                    'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                    'usedab' => $usedab,
                    'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                    ->where('sickprivate_more',$x)->where('sickprivate_year',$y)->first(),
                
                );
            }else{
                if((int)$dateinterval->format('%m')>5){
                    $data = array(
                        'user' => $start,
                        'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                        'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                        'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                        ->where('sickprivate_more',$x)->where('sickprivate_year',$y)->first(),
                        'usedab' => $usedab,
                    
                    );

                }else{
                    //less
                    $data = array(
                        'user' => $start,
                        'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                        'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                        'usedab' => $usedab,
                        'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                                        ->where('sickprivate_less',$x)->where('sickprivate_year',$y)->first(),
                        
                    );

                }
            }
            if(empty($data['limit'])){
                return redirect('indexmanager')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('manager.sickleavemanager',$data);

            }
                
            
        })->name('sickleavemanager');


        Route::get('vacationleavemanager', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2;
            }else{
                $x=1;
            }
            $y = (int)date("Y")+543;
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();

            $dateinterval = date_diff(date_create($start->USER_START_DATE), date_create(date("Y-m-d")));
            // dd(session::get('usergroup'));
            if((int)$dateinterval->format('%y')>9){
            //more
                // dd($x);
                $data = array(
                    'user' => $start,
                    'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                    'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                    'usedab' => $usedab,
                    'limit' => DB::Table('limitvacation')->where('id_group',session::get('usergroup'))->where('vacation_round',$x)
                                    ->where('vacation_more',$x)->where('vacation_year',$y)->first(),
                
                );
            }else{
            
                    //less
                    return redirect('indexmanager')->with('error','ยังไม่สามารถทำการลาได้ เนื่องจากยังทำงานไม่ครบ 6 เดือน');

                    // $data = array(
                    //     'user' => $start,
                    //     'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                    //     'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                    //     'usedab' => $usedab,
                    //     'limit' => DB::Table('limitvacation')->where('id_group',session::get('usergroup'))->where('vacation_round',$x)
                    //                     ->where('vacation_less',$x)->where('vacation_year',$y)->first(),
                        
                    // );

                
            }

            if(empty($data['limit'])){
                return redirect('indexmanager')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('manager.vacationleavemanager',$data);

            }


        })->name('vacationleavemanager');


        Route::get('privateleavemanager', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2; //round
            }else{
                $x=1;
            }
            $y = (int)date("Y")+543;
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
            $data = array(
                'user' => $start,
                'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                'usedab' => $usedab,
                'limit' => DB::Table('limitsickprivate')->where('id_group',session::get('usergroup'))->where('sickprivate_round',$x)
                            ->where('sickprivate_year',$y)->first(),
            
            );

            if(empty($data['limit'])){
                return redirect('indexmanager')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('manager.privateleavemanager',$data);

            }


        })->name('privateleavemanager');


        Route::get('maternityleavemanager', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2;
            }else{
                $x=1;
            }
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
            $y = (int)date("Y")+543;
        
            $data = array(
                'user' => $start,
                'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                'usedab' => DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',3)->get(),
                'limit' => DB::Table('limitmaternity')->where('id_group',session::get('usergroup'))->where('maternity_round',$x)
                                ->where('maternity_year',$y)->first(),
                                
                
            );

            if(empty($data['limit'])){
                return redirect('indexmanager')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('manager.maternityleavemanager',$data);

            }

            
        })->name('maternityleavemanager');


        Route::get('babymanager', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2;
            }else{
                $x=1;
            }
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
            $y = (int)date("Y")+543;
        
            $data = array(
                'user' => $start,
                'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                'usedab' => DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',4)->get(),
                'limit' => DB::Table('limitbaby')->where('id_group',session::get('usergroup'))->where('baby_round',$x)->where('baby_year',$y)->first(),
                
            );

            if(empty($data['limit'])){
                return redirect('indexmanager')->with('error','ยังไม่สามารถทำการลาได้');
            }else{
                return view('manager.babymanager',$data);

            }

        })->name('babymanager');


        Route::get('ordinationleavemanager', function () {
            $month = intval(date('m'));
            if($month>=4&&$month<=9){
                $x=2;
            }else{
                $x=1;
            }
            $start = DB::Table('user')->where('USER_ID',Session::get('userid'))->first();
            $y = (int)date("Y")+543;
        
            $data = array(
                'user' => $start,
                'personal' => DB::Table('personal')->where('PERTYPE_ID',session::get('userper'))->first(),
                'department' => DB::Table('department')->where('DEP_ID',session::get('userdep'))->first(),
                // 'usedab' => DB::Table('absentdetail')->where('USER_ID',session::get('userid'))->where('ABSENTYPE_ID',5)->get(),
                // 'limit' => DB::Table('limitordination')->where('id_group',session::get('usergroup'))->where('baby_round',$x)->where('baby_year',$y)->first(),
                
            );


            return view('manager.ordinationleavemanager',$data);
        })->name('ordinationleavemanager');

        //ยกเลิกใบลา
        Route::get('cancelsickleavemanager', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',1)->get(),
            );

            return view('manager.cancelsickleavemanager',$data);
        })->name('cancelsickleavemanager');

        Route::get('cancelvacationleavemanager', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',2)->get(),
            );

            return view('manager.cancelvacationleavemanager',$data);
        })->name('cancelvacationleavemanager');

        Route::get('cancelprivateleavemanager', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',1)->where('APPROVER_CHECK',2)->get(),
            );
            return view('manager.cancelprivateleavemanager',$data );
        })->name('cancelprivateleavemanager');

        Route::get('cancelmaternityleavemanager', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',3)->get(),
            );
            return view('manager.cancelmaternityleavemanager',$data);
        })->name('cancelmaternityleavemanager');

        Route::get('cancelbabymanager', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',4)->get(),
            );
            return view('manager.cancelbabymanager',$data);
        })->name('cancelbabymanager');

        Route::get('cancelordinationleavemanager', function () {
            $data = array(
                'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',5)->get(),
            );
            return view('manager.cancelordinationleavemanager',$data);
        })->name('cancelordinationleavemanager');

        //สถานะการลา
        Route::get('statusmanager', function () {
            $data = array(
                'data' => App\Absent::where('absentdetail.USER_ID',Session::get('userid'))
                            ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                            ->orderBy('ABSENT_START','DESC')->get(),
            );
            return view('manager.statusmanager',$data);
        })->name('statusmanager');

        //รายงานการลา
        Route::get('reportleavemanager', function () {
            $data = array(
                'data' => DB::Table('department')->where('DEP_ID',Session::get('userdep'))->first(),
                // 'data' => DB::Table('department')->get(),
            );

            return view('manager.reportleavemanager',$data);
        })->name('reportleavemanager');
        Route::get('searchleavereportdepid', 'ManagerController@SearchLeaveReportDepid');



        //รายงานการมาปฏิบัติงาน
        Route::get('workingmanager', function () {
            $data = array(
                'data' => DB::Table('department')->where('DEP_ID',Session::get('userdep'))->first(),
                // 'data' => DB::Table('department')->get(),
            );
            return view('manager.workingmanager',$data);
        })->name('workingmanager');
        Route::get('searchworkeport', 'ManagerController@SearchWorkeport');



        //การอนุมัติ
        Route::get('approvemanager', function () {
            $user =  DB::Table('user')->where('DEP_ID',Session::get('userdep'))->where('user.DEP_ID','!=',Session::get('userid'))->first();
            
            $data = array(
                'data' => App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                            ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                            ->where('user.DEP_ID',Session::get('userdep'))
                            ->orderBy('ABSENT_START','DESC')->where('absentdetail.USER_ID','!=',Session::get('userid'))->get(),

                
            );
            // dd($data['data']);
            return view('manager.approvemanager',$data);
        })->name('approvemanager');

        Route::post('approveleavemanager', 'ManagerController@ApproveLeaveManager');
        Route::get('detailmanager', 'ManagerController@Detailmanager');


        Route::get('searchsummarymanager', 'ManagerController@SearchworkSummary');


        Route::get('summarymanager', function () {
            $data = array(
                'data' => DB::Table('department')->where('DEP_ID',Session::get('userdep'))->first(),
                // 'data' => DB::Table('department')->get(),
            );
            return view('manager.summarymanager', $data );
        })->name('summarymanager');

});





/////////////////////////////////////////////////director/////////////////////////////////////////
Route::group(['middleware'=>['DirectorLogin']],function(){

        //รายงานการลา
        Route::get('reportleavedirector', function () {
            
            return view('director.reportleavedirector');
        })->name('reportleavedirector');
        Route::get('searchleavereportdirector', 'DirectorController@SearchLeaveReportDirector');



        //รายงานการมาปฏิบัติงาน
        Route::get('workingdirector', function () {
        

            return view('director.workingdirector');
        })->name('workingdirector');
        Route::get('searchworkreportdirector', 'DirectorController@SearchWorkReportDirector');



        //การอนุมัติ
        Route::get('approvedirector', function () {
            $data = array(
                'data' => App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                            ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                            ->where('user.DEP_ID',Session::get('userdep'))
                            ->where('absentdetail.USER_ID','!=',Session::get('userid'))
                            ->where('STATUS_APPROVER','>',2)->get(),
            );

            return view('director.approvedirector',$data);
        })->name('approvedirector');
        Route::post('approveleavedirector', 'DirectorController@ApproveLeaveDirector');

        Route::get('searchsummarydirector', 'DirectorController@SearchworkSummary');


        Route::get('summarydirector', function () {
            
            return view('director.summarydirector');
        })->name('summarydirector');



});


/////////////////////////////////////////////////admin///////////////////////////////////////

Route::group(['middleware'=>['AdminLogin']],function(){
        Route::get('addimage', function () {
            $data = array(
                'data1' => DB::Table('banner')->where('id_banner',1)->first(),
                'data2' => DB::Table('banner')->where('id_banner',2)->first(),
                'data3' => DB::Table('banner')->where('id_banner',3)->first(),
            );
            // dd($data['data']);
            return view('admin.addimage',$data);
        })->name('addimage');


        Route::post('cancelbyadmin','AdminController@Cancelbyadmin');
        Route::get('approveadmin','AdminController@Approveadmin');


        Route::post('updateimage', 'AdminController@updateimage')->name('updateimage');

        Route::get('adduser', function () {
            $data = array(
                "datauer" => 1,
                "dep" => DB::table('department')->get(),
                "per" => DB::table('personal')->get(),
                "user" => DB::table('user')
                            ->leftJoin('department','user.DEP_ID','=','department.DEP_ID')
                            ->leftJoin('personal','user.PERTYPE_ID','=','personal.PERTYPE_ID')
                            ->orderBy('USER_ID','DESC')->get(),
            ); 
            // dd($data['user']);
            return view('admin.adduser',$data);
        })->name('adduser');

        Route::get('changestatususer/{chk}/{id}', 'AdminController@ChangeStatusUser');

        Route::get('adduser2/{ict}', 'AdminController@adduser');

        Route::post('updateuser', 'AdminController@updateuser')->name('updateuser');

        Route::get('manageaccount', function () {
            return view('admin.manageaccount');
        })->name('manageaccount');

        Route::get('dayleave', function () {
            $data = array(
                'personal' => DB::Table('personal')->get(),
            );
            return view('admin.dayleave',$data);
        })->name('dayleave');

        Route::get('searchleavesick', 'CheckleaveController@Search');


        Route::post('updatelimitabsent', 'AdminController@UpdateLimitAbsent');
        Route::get('manageaccount2/{dep}/{per}', 'AdminController@manageraccount');

        Route::get('/delete/{USER_ID}', 'AdminController@delete');

        Route::post('post', 'AdminController@store')->name('post');

        Route::get('passdata/{id}/{chk}', 'AdminController@Passdata');

        //รายงานการมาปฏิบัติงาน

        Route::get('checkleave', function () {
            $data = array(
                'data' => DB::Table('absenttype')->get(),
            );
            return view('admin.checkleave',$data);
        })->name('checkleave');

        // Route::get('checkleave', function () {
        //     $data = array(
        //         'data' => App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
        //                 ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
        //                 ->where('ABSENTYPE_ID',1)
        //                 ->orderBy('ABSENT_START','DESC')
        //                 ->get(),
        //     );
        //     return view('admin.checkleave',$data);
        // })->name('checkleave');
        
        Route::get('searchleavecheck', 'CheckleaveController@SearchLeaveCheck');
        Route::get('detailadmin', 'CheckleaveController@Detailadmin');




        Route::get('reportleaveadmin', function () {

            $data = array(
                'data' => DB::Table('department')->get(),
            );
            return view('admin.reportleaveadmin',$data);
        })->name('reportleaveadmin');

        Route::get('searchleavereport', 'CheckleaveController@SearchLeaveReport');



        //รายงานการมาปฏิบัติงาน
        Route::get('workingadmin', function () {
            $data = array(
                'data' => DB::Table('department')->get(),
                // 'data' => DB::Table('department')->get(),
            );
            return view('admin.workingadmin', $data );
        })->name('workingadmin');

        Route::get('searchworkreportadmin', 'AdminController@SearchWorkReport');


        Route::get('searchsummaryadmin', 'AdminController@SearchworkSummary');


        Route::get('summaryadmin', function () {
            $data = array(
                'data' => DB::Table('department')->get(),
                // 'data' => DB::Table('department')->get(),
            );
            return view('admin.summary', $data );
        })->name('summaryadmin');


});
