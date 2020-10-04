@extends('layouts-manager.template-manager')
@section('content-manager')
<!DOCTYPE html>
<html lang="en">
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ Transactions chart ] starts-->
                                <div class="col-md-6 col-xl-6">
                                        <div class="card Recent-Users">
                                            <div class="card-header">
                                                <h5>การมาปฏิบัติงาน</h5>
                                            </div>
                                            <div class="card-block px-0 py-3">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            <tr class="unread">
                                                                <td>
                                                                    <h6 class="mb-1">จำนวนวันที่มาปฏิบัติงานสาย (เดือน)</h6>
                                                                </td>
                                                                <td><a href="#!" class="label theme-bg2 text-white f-12">15</a></td>
                                                                <td>
                                                                    <h6 class="mb-1">วัน</h6>
                                                                </td>
                                                            </tr>
                                                            <tr class="unread">
                                                                <td>
                                                                    <h6 class="mb-1">จำนวนวันที่มาปฏิบัติงานสาย (รอบงบประมาณ)</h6>
                                                                </td>
                                                                <td><a href="#!" class="label theme-bg2 text-white f-12">15</a></td>
                                                                <td>
                                                                    <h6 class="mb-1">วัน</h6>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>กราฟการมาปฏิบัติงาน</h5>
                                            </div>
                                            <div class="card-block">
                                                <canvas id="chart-bar-1" style="width: 100%; height: 300px"></canvas>
                                            </div>
                                        </div>  
                                             
                                </div>
                                <!-- [ Transactions chart ] end -->
                                <!--[ Recent Users ] start-->
                                <div class="col-xl-6 col-md-6">
                                    <div class="card Recent-Users">
                                        <div class="card-header">
                                            <h5>การลาประเภทต่างๆ</h5>
                                        </div>
                                        <div class="card-block px-0 py-3">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <tbody>
                                                        <tr class="unread">
                                                            <td><img class="rounded-circle" style="width:40px;" src="assets/images/leave/fever.png" alt="activity-user"></td>
                                                            <td>
                                                                <h6 class="mb-1">ลาป่วย</h6>
                                                                <p class="m-0">คงเหลือ</p>
                                                            </td>
                                                            <td><a href="#!" class="label theme-bg text-white f-12">&nbsp;10&nbsp;</a></td>
                                                            <td>
                                                                <h6 class="mb-1">วัน</h6>
                                                            </td>
                                                        </tr>
                                                        <tr class="unread">
                                                            <td><img class="rounded-circle" style="width:40px;" src="assets/images/leave/beach.png" alt="activity-user"></td>
                                                            <td>
                                                                <h6 class="mb-1">ลาพักผ่อน</h6>
                                                                <p class="m-0">คงเหลือ</p>
                                                            </td>
                                                            <td><a href="#!" class="label theme-bg text-white f-12">&nbsp;20&nbsp;</a></td>
                                                            <td>
                                                                <h6 class="mb-1">วัน</h6>
                                                            </td>
                                                        </tr>
                                                        <tr class="unread">
                                                            <td><img class="rounded-circle" style="width:40px;" src="assets/images/leave/road.png" alt="activity-user"></td>
                                                            <td>
                                                                <h6 class="mb-1">ลากิจส่วนตัว</h6>
                                                                <p class="m-0">คงเหลือ</p>
                                                            </td>
                                                            <td><a href="#!" class="label theme-bg text-white f-12">&nbsp;15&nbsp;</a></td>
                                                            <td>
                                                                <h6 class="mb-1">วัน</h6>
                                                            </td>
                                                        </tr>
                                                        <tr class="unread">
                                                            <td><img class="rounded-circle" style="width:40px;" src="assets/images/leave/pregnant.png" alt="activity-user"></td>
                                                            <td>
                                                                <h6 class="mb-1">ลาคลอดบุตร</h6>
                                                                <p class="m-0">คงเหลือ</p>
                                                            </td>
                                                            <td><a href="#!" class="label theme-bg text-white f-12">&nbsp;20&nbsp;</a></td>
                                                            <td>
                                                                <h6 class="mb-1">วัน</h6>
                                                            </td>
                                                        </tr>
                                                        <tr class="unread">
                                                            <td><img class="rounded-circle" style="width:40px;" src="assets/images/leave/baby.png" alt="activity-user"></td>
                                                            <td>
                                                                <h6 class="mb-1">ลาไปช่วยภริยาคลอดบุตร</h6>
                                                                <p class="m-0">คงเหลือ</p>
                                                            </td>
                                                            <td><a href="#!" class="label theme-bg text-white f-12">&nbsp;-&nbsp;</a></td>
                                                            <td>
                                                                <h6 class="mb-1">วัน</h6>
                                                            </td>
                                                        </tr>
                                                        <tr class="unread">
                                                            <td><img class="rounded-circle" style="width:40px;" src="assets/images/leave/monk.png" alt="activity-user"></td>
                                                            <td>
                                                                <h6 class="mb-1">ลาอุปสมบท</h6>
                                                                <p class="m-0">คงเหลือ</p>
                                                            </td>
                                                            <td><a href="#!" class="label theme-bg text-white f-12">&nbsp;-&nbsp;</a></td>
                                                            <td>
                                                                <h6 class="mb-1">วัน</h6>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--[ Recent Users ] end-->
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
</html>
@stop