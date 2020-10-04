@extends('layouts-director.template-director')
@section('content-director')
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
                                        <h5>ตรวจสอบการมาปฏิบัติงาน</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-1"></div>
                                            <div class="col-md-6">
                                                <form>
                                                    <div class="form">
                                                        <label for="exampleFormControlSelect1">ตั้งแต่</label>
                                                        <input type="text" class="form-control" id="d_toggle">
                                                    </div><br>
                                                    <div class="form">
                                                        <label for="exampleFormControlSelect1">ถึง</label>
                                                        <input type="text" class="form-control" id="d_disable">
                                                    </div><br>
                                                <label for="exampleFormControlSelect1">เลือกรูปแบบการแสดงรายงาน</label>
                                                <br><br>&emsp;&emsp;
                                                <img src="assets/images/report/csv.png" height= "45" alt="Logo">&emsp;&emsp;
                                                <img src="assets/images/report/pdf.png" height= "45" alt="Logo">&emsp;&emsp;
                                                <img src="assets/images/report/chart.png" height= "45" alt="Logo">&emsp;&emsp;
                                                <img src="assets/images/report/html.png" height= "45" alt="Logo">
                                                </form>
                                                <br>
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
