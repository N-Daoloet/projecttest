@extends('layouts-user.template-user')
@section('content-user')
<!-- [ Main Content ] start -->
<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content"> 
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!-- [ Form Validation ] start -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>ลาป่วย</h5>
                                    </div>
                                    <div class="card-block">
                                        <form id="validation-form123" action="#!">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">ชื่อ - นามสกุล</label>
                                                        <input type="text" class="form-control" name="validation-email" placeholder=" ">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">ตำแหน่ง</label>
                                                        <input type="password" class="form-control" name="validation-password" placeholder=" ">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">สังกัด</label>
                                                        <input type="password" class="form-control" name="validation-password-confirmation" placeholder=" ">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">ขอลาป่วยเนื่องจาก</label>
                                                        <input type="text" class="form-control" name="validation-required" placeholder=" ">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">ตั้งแต่</label>
                                                        <input type="text" class="form-control" id="d_toggle">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">ถึง</label>
                                                        <input type="text" class="form-control" id="d_disable">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">กำหนด (วัน)</label>
                                                        <input type="text" class="form-control" id="d_disable">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">สามารถติดต่อข้าพเจ้าได้ที่</label>
                                                        <input type="text" class="form-control" id="d_disable">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">เบอร์โทรศัพท์</label>
                                                        <input type="text" class="form-control" id="d_disable">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">File</label>
                                                        <div>
                                                            <input type="file" class="validation-file" name="validation-file">
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div> 
                                        </form>  
                                    </div>
                                    <div class="col-md-12">
                                        &nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                            <a href=" " class="btn btn-primary" type="submit">ยื่นใบลา</button>
                                            <a href="{{route ('indexuser')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a>             
                                    </div>
                                </div>
                            </div>
                            <!-- [ Form Validation ] end -->
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
@stop
