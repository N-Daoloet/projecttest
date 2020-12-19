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
Route::get('/clc', function() {

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
        'data1' => DB::Table('banner')->where('id_banner',1)->first(),
        'data2' => DB::Table('banner')->where('id_banner',2)->first(),
        'data3' => DB::Table('banner')->where('id_banner',3)->first(),
    );
    // dd($data['data']);
    return view('intro',$data);
})->name('intro');

Route::get('login', function () {
    return view('login');
})->name('login');

Route::post('login', 'Auth\LoginController@checklogin');

//เลือกสิทธิ์
Route::get('selectauthority', function () {
    return view('selectauthority');
})->name('selectauthority');

Route::post('selectlogin','Auth\LoginController@checklogin2');







/////////////////////////////////user///////////////////////////////////
//index
Route::get('indexuser', function () {
    $data = array(
        'data' => DB::Table('user')->where('USER_ID',Session::get('userid'))->first(),
    );
    return view('user.indexuser',$data);
})->name('indexuser');


//ยื่นใบลา
Route::get('sickleaveuser', function () {
    $data = array(
        'data' => DB::Table('user')
                    ->leftJoin('personal','user.PERTYPE_ID','=','personal.PERTYPE_ID')
                    ->leftJoin('department','user.DEP_ID','=','department.DEP_ID')
                    ->where('USER_ID',Session::get('userid'))->first(),
        );
    return view('user.sickleaveuser',$data);
})->name('sickleaveuser');
Route::post('saveabsentsick','UserController@SaveAbsent');


Route::get('vacationleaveuser', function () {
    return view('user.vacationleaveuser');
})->name('vacationleaveuser');
Route::get('privateleaveuser', function () {
    return view('user.privateleaveuser');
})->name('privateleaveuser');
Route::get('maternityleaveuser', function () {
    return view('user.maternityleaveuser');
})->name('maternityleaveuser');
Route::get('babyuser', function () {
    return view('user.babyuser');
})->name('babyuser');
Route::get('ordinationleaveuser', function () {
    return view('user.ordinationleaveuser');
})->name('ordinationleaveuser');


//ยกเลิกใบลา
Route::get('cancelsickleaveuser', function () {
    $data = array(
        'data' => App\Absent::where('USER_ID',Session::get('userid'))->where('ABSENTYPE_ID',1)->get(),
    );
    // dd($data['data']);
    return view('user.cancelsickleaveuser',$data);
})->name('cancelsickleaveuser');

Route::post('cancleofid','UserController@Cancleofid');


Route::get('cancelvacationleaveuser', function () {
    return view('user.cancelvacationleaveuser');
})->name('cancelvacationleaveuser');
Route::get('cancelprivateleaveuser', function () {
    return view('user.cancelprivateleaveuser');
})->name('cancelprivateleaveuser');
Route::get('cancelmaternityleaveuser', function () {
    return view('user.cancelmaternityleaveuser');
})->name('cancelmaternityleaveuser');
Route::get('cancelbabyuser', function () {
    return view('user.cancelbabyuser');
})->name('cancelbabyuser');
Route::get('cancelordinationleaveuser', function () {
    return view('user.cancelordinationleaveuser');
})->name('cancelordinationleaveuser');

//สถานะการลา
Route::get('statususer', function () {
    $data = array(
        'data' => App\Absent::where('USER_ID',Session::get('userid'))
        ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')->get(),
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

/////////////////////////////////////////////manager/////////////////////////////////////////////
//index
Route::get('indexmanager', function () {
   
    return view('manager.indexmanager');
})->name('indexmanager');

//ยื่นใบลา
Route::get('sickleavemanager', function () {
    return view('manager.sickleavemanager');
})->name('sickleavemanager');
Route::get('vacationleavemanager', function () {
    return view('manager.vacationleavemanager');
})->name('vacationleavemanager');
Route::get('privateleavemanager', function () {
    return view('manager.privateleavemanager');
})->name('privateleavemanager');
Route::get('maternityleavemanager', function () {
    return view('manager.maternityleavemanager');
})->name('maternityleavemanager');
Route::get('babymanager', function () {
    return view('manager.babymanager');
})->name('babymanager');
Route::get('ordinationleavemanager', function () {
    return view('manager.ordinationleavemanager');
})->name('ordinationleavemanager');

//ยกเลิกใบลา
Route::get('cancelsickleavemanager', function () {
    return view('manager.cancelsickleavemanager');
})->name('cancelsickleavemanager');
Route::get('cancelvacationleavemanager', function () {
    return view('manager.cancelvacationleavemanager');
})->name('cancelvacationleavemanager');
Route::get('cancelprivateleavemanager', function () {
    return view('manager.cancelprivateleavemanager');
})->name('cancelprivateleavemanager');
Route::get('cancelmaternityleavemanager', function () {
    return view('manager.cancelmaternityleavemanager');
})->name('cancelmaternityleavemanager');
Route::get('cancelbabymanager', function () {
    return view('manager.cancelbabymanager');
})->name('cancelbabymanager');
Route::get('cancelordinationleavemanager', function () {
    return view('manager.cancelordinationleavemanager');
})->name('cancelordinationleavemanager');

//สถานะการลา
Route::get('statusmanager', function () {
    return view('manager.statusmanager');
})->name('statusmanager');

//รายงานการลา
Route::get('reportleavemanager', function () {
    return view('manager.reportleavemanager');
})->name('reportleavemanager');

//รายงานการมาปฏิบัติงาน
Route::get('workingmanager', function () {
    return view('manager.workingmanager');
})->name('workingmanager');

//การอนุมัติ
Route::get('approvemanager', function () {
    $data = array(
        'data' => App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                    ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                    ->where('user.DEP_ID',Session::get('userdep'))->get(),

        'count' => App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                    ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                    ->where('user.DEP_ID',Session::get('userdep'))
                    ->where('STATUS_APPROVER',0)
                    ->get(),
    );
    // dd($data['data']);
    return view('manager.approvemanager',$data);
})->name('approvemanager');

Route::post('approveleavemanager', 'ManagerController@ApproveLeaveManager');

/////////////////////////////////////////////////director/////////////////////////////////////////
//รายงานการลา
Route::get('reportleavedirector', function () {
    return view('director.reportleavedirector');
})->name('reportleavedirector');

//รายงานการมาปฏิบัติงาน
Route::get('workingdirector', function () {
    return view('director.workingdirector');
})->name('workingdirector');

//การอนุมัติ
Route::get('approvedirector', function () {
    $data = array(
        'data' => App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                    ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                    ->where('user.DEP_ID',Session::get('userdep'))
                    ->whereIn('STATUS_APPROVER',[2,4,5])->get(),
    );

    return view('director.approvedirector',$data);
})->name('approvedirector');
Route::post('approveleavedirector', 'DirectorController@ApproveLeaveDirector');





/////////////////////////////////////////////////admin///////////////////////////////////////
Route::get('addimage', function () {
    $data = array(
        'data1' => DB::Table('banner')->where('id_banner',1)->first(),
        'data2' => DB::Table('banner')->where('id_banner',2)->first(),
        'data3' => DB::Table('banner')->where('id_banner',3)->first(),
    );
    // dd($data['data']);
    return view('admin.addimage',$data);
})->name('addimage');

Route::post('updateimage', 'AdminController@updateimage')->name('updateimage');

Route::get('adduser', function () {
    return view('admin.adduser');
})->name('adduser');
Route::get('changestatususer/{chk}/{id}', 'AdminController@ChangeStatusUser');

Route::post('adduser2', 'AdminController@adduser')->name('adduser2');

Route::post('updateuser', 'AdminController@updateuser')->name('updateuser');

Route::get('manageaccount', function () {
    return view('admin.manageaccount');
})->name('manageaccount');

Route::get('dayleave', function () {
    $data = array(
        'data' => DB::Table('absenttype')->get(),
    );
    return view('admin.dayleave',$data);
})->name('dayleave');

Route::post('updatelimitabsent', 'AdminController@UpdateLimitAbsent');
Route::post('manageaccount2', 'AdminController@manageraccount')->name('manageaccount2');

Route::get('/delete/{USER_ID}', 'AdminController@delete');

Route::post('post', 'AdminController@store')->name('post');

Route::get('passdata/{id}/{chk}', 'AdminController@Passdata');

//รายงานการมาปฏิบัติงาน
Route::get('checkleave/{id}', function ($id) {
    $data = array(
        'data' => App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                            ->leftJoin('absenttype','absentdetail.ABSENTYPE_ID','=','absenttype.ABSENTTYPE_ID')
                            ->where('ABSENTYPE_ID',$id)
                            ->get(),
    );
    return view('admin.checkleave',$data);
})->name('checkleave');




Route::get('reportleaveadmin', function () {
    return view('admin.reportleaveadmin');
})->name('reportleaveadmin');

//รายงานการมาปฏิบัติงาน
Route::get('workingadmin', function () {
    return view('admin.workingadmin');
})->name('workingadmin');
