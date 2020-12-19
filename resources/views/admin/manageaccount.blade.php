@extends('layouts-admin.template-admin')
@section('content-admin')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!-- [ form-element ] start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>จัดการบัญชีผู้ใช้</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-1"></div>
                                            <div class="col-md-6">
                                                <form action="{{route('manageaccount2')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form">
                                                        <label for="exampleFormControlSelect1">สังกัดฝ่าย</label>
                                                        <select class="form-control" id="exampleFormControlSelect1" name="department">
                                                            <option value="1">สำนักงานผู้อำนวยการ</option>
                                                            <option value="2">ฝ่ายพัฒนาระบบสารสนเทศ</option>
                                                            <option value="3">ฝ่ายวิศวกรรมระบบเครือข่าย</option>
                                                            <option value="4">ฝ่ายบริการวิชาการและส่งเสริมการวิจัย</option>
                                                            <option value="5">ฝ่ายเทคโนโลยีสารสนเทศ วิทยาเขตปราจีนบุรี</option>
                                                            <option value="6">ฝ่ายเทคโนโลยีสารสนเทศ วิทยาเขตระยอง</option>
                                                        </select><br>
                                                        <label for="exampleFormControlSelect1">ประเภทบุคลากร</label>
                                                        <select class="form-control" id="exampleFormControlSelect1" name="person">
                                                            <option value="1">ผู้บริหารสำนักคอมพิวเตอร์ฯ</option>
                                                            <option value="2">พนักงานมหาวิทยาลัย</option>
                                                            <option value="3">พนักงานพิเศษ (รอบเช้า)</option>
                                                            <option value="4">พนักงานพิเศษ (รอบบ่าย)</option>
                                                            <option value="5">นักศึกษาฝึกงาน/สหกิจศึกษา</option>
                                                            <option value="6">นักศึกษาช่วยงานวิชาการ</option>
                                                        </select><br><br>
                                                        <button class="btn btn-primary" type="submit">ค้นหา</button>
                                                        <a href="{{route ('manageaccount')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a>  
                                                    </div>
                                                </form>

                                            </div>
                                            
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <!-- [ form-element ] end -->
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

</body>
</html>
@stop
