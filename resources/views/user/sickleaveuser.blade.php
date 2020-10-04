@extends('layouts-user.template-user')
@section('content-user')
<!-- [ Main Content ] start -->
<section class="pcoded-main-container">
    <script>
        var A = "{{Session::get('success')}}";
        if(A){
            alert(A);
        }
    </script>
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
                                    <form action="{{url('saveabsent')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-block">
                                            <input type="hidden" name="ABSENTYPE_ID" value="1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ชื่อ - นามสกุล</label>
                                                        <input type="text" class="form-control" name="validation-email" value="{{Session::get('userfn')}}  {{Session::get('userln')}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ตำแหน่ง</label>
                                                        <input type="password" class="form-control" name="validation-password" placeholder=" " readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">สังกัด</label>
                                                        <input type="password" class="form-control" name="validation-password-confirmation" placeholder=" " readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ตั้งแต่</label>
                                                        <input type="date" class="form-control" id="datestart" name="ABSENT_START">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ถึง</label>
                                                        <input type="date" class="form-control" id="dateend" name="ABSENT_END" >
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ขอลาป่วยเนื่องจาก</label>
                                                        <input type="text" class="form-control" name="validation-required" name="ABSENT_REASON" onkeyup="datediff();">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">กำหนด (วัน)</label>
                                                        <input type="text" class="form-control" id="datenumber" name="ABSENT_NUMBER" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">สามารถติดต่อข้าพเจ้าได้ที่</label>
                                                        <input type="text" class="form-control"  value="{{$data->USER_EMAIL}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">เบอร์โทรศัพท์</label>
                                                        <input type="text" class="form-control"  value="{{$data->USER_PHONE}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">File</label>
                                                        <div>
                                                            <input type="file" class="validation-file " name="preview_image" >
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div> 
                                         
                                        </div>
                                        <div class="col-md-12">
                                            &nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                                <button class="btn btn-primary" type="submit">ยื่นใบลา</button>
                                                <a href="{{route ('indexuser')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a>             
                                        </div>
                                    </form> 
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
<script language="javascript" type="text/javascript">
    function datediff(){
        var date1 = document.getElementById('datestart').value; //start
        var date2 = document.getElementById('dateend').value; //end
        console.log(date1);
        console.log(date2);
        date1 = date1.split("-");
        date2 = date2.split("-");
        // console.log(date1);
        // console.log(date2);
        sDate = new Date(date1[0],date1[1]-1,date1[2]); 
        eDate = new Date(date2[0],date2[1]-1,date2[2]); 
        var daysDiff = (Math.round((eDate-sDate)/86400000))+1;
        // alert(daysDiff);
        document.getElementById('datenumber').value=daysDiff;
    }
</script>   
</body>
</html>
@stop
