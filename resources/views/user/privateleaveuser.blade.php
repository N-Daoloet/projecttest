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
                                        <h5>ลากิจส่วนตัว</h5>
                                    </div>
                                    <form action="{{url('saveabsentsick')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-block">
                                            <input type="hidden" name="ABSENTYPE_ID" value="1">
                                            <input type="hidden" name="position" value="0">
                                            {{-- 0user 1manager --}}
                                            <input type="hidden" name="private" value="1">
                                            {{-- //0ป่วย 1ลากิจ --}}


                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ชื่อ - นามสกุล</label>
                                                        <input type="text" class="form-control" name="" placeholder=" " value="{{Session::get('userfn')}}  {{Session::get('userln')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ตำแหน่ง</label>
                                                        <input type="text" class="form-control" value="{{$personal->PERTYPE_NAME}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">สังกัด</label>
                                                        <input type="text" class="form-control" value="{{$department->DEP_NAME}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">สามารถติดต่อข้าพเจ้าได้ที่</label>
                                                        <input type="text" class="form-control"  value="{{$user->USER_EMAIL}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">เบอร์โทรศัพท์</label>
                                                        <input type="number" class="form-control" name="ABSENT_PHONE" value="" style="background-color:#ffffff" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ช่วงเวลา</label>
                                                        <select class="form-control" name="daytype" id="daytype" style="background-color:#ffffff" {{((int)$usedab->followers) > ((int)$limit->sickprivate_limit) && Session::get('usergroup')==2?'disabled':''}} required>
                                                            <option value="5">กรุณาเลือก</option>
                                                            <option value="1">ครึ่งเช้า</option>
                                                            <option value="2">ครึ่งบ่าย</option>
                                                            <option value="0">วันเดียว</option>
                                                            <option value="3">หลายวัน</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php 
                                                    $md = date("Y-m-d");
                                                ?>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ตั้งแต่</label>
                                                        {{-- <input type="date" class="form-control" style="background-color:#ffffff" class="form-control" id="datestart" name="ABSENT_START" readonly> --}}
                                                        <input type="date" class="form-control" style="background-color:#ffffff" class="form-control" min="{{$md}}" id="datestart" name="ABSENT_START" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">ถึง</label>
                                                        <input type="date" class="form-control" style="background-color:#ffffff" class="form-control" min="{{$md}}" id="dateend" name="ABSENT_END" onchange="datediff();" readonly>
                                                        {{-- <input type="date" class="form-control" style="background-color:#ffffff" class="form-control" id="dateend" name="ABSENT_END" onchange="datediff();" readonly> --}}
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="form-label">ตั้งแต่เวลา</label>
                                                        <input type="time" class="form-control timehaft" id="haft" style="background-color:#ffffff"  name="ABSENT_TIMESTART" value="mor" >
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="form-label">ถึง</label>
                                                        <input type="time" class="form-control timehaft" id="hafteve" style="background-color:#ffffff"  name="ABSENT_TIMEEND" value=""  max="12:00" >
                                                    </div>
                                                </div> --}}
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">กำหนด</label>
                                                        <input type="text" class="form-control" id="datenumber" name="ABSENT_NUMBER" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">ขอลากิจส่วนตัวเนื่องจาก</label>
                                                        <input type="text" class="form-control" name="ABSENT_REASON" style="background-color:#ffffff" required>
                                                    </div>
                                                </div> 
                                        </div>
                                        <div class="col-md-12"><br>
                                            &nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                            
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script language="javascript" type="text/javascript">

    $("#datestart").change(function(){

        var x = document.getElementById("datestart").value;
        document.getElementById("dateend").min = x;
    });
        
    var timetext = '';
    var test = '13:00';

    $('#haft').timepicker({
        'timeFormat': 'HH:mm',
        'minTime': '07:00',
        'interval': 60,
        'maxTime': '17:00',
      
        change: function(time) {
        //    console.log(time.getHours()+1);
            timetext = time.getHours()+1 +':00';
            // $('#timeset').val(timetext);
        }

    });

    $('#hafteve').timepicker({
        'timeFormat': 'HH:mm',
        'minTime': '07:00',
        'interval': 60,
        'maxTime': '17:00',
        change : caltime
    });




    var daysum = 0;
    var chk = 0;
    var daysumold = 0;
    var limit = "{{$limit->sickprivate_limit}}";

    $('#daytype').change(function(){
        if($(this).val() == '1' || $(this).val() == '2' ){
            $('#datestart').prop('required',true);
            $('#datestart').prop('readonly',false);
            $('#dateend').prop('readonly',true);
            $('#dateend').css("background-color", "#e9ecef");
            $('#datenumber').val(0.5);
            if($(this).val() == '1'){
                $('#haft').val("09:00");
                $('#hafteve').val("12:00");
            }else{
                $('#haft').val("13:00");
                $('#hafteve').val("16:30");
            }
            $('.timehaft').prop('readonly',true);
            $('.timehaft').css("background-color", "#e9ecef");
           
           
        }else if($(this).val() == '0'){
            $('#datestart').prop('required',true);
            $('#datestart').prop('readonly',false);
            $('#dateend').prop('readonly',true);
            $('#dateend').css("background-color", "#e9ecef");
            $('#datenumber').val(1);
            $('#haft').val("08:30");
            $('#hafteve').val("16:30");
            $('.timehaft').prop('readonly',true);
            $('.timehaft').css("background-color", "#e9ecef");
            
        }else if($(this).val() == '5'){
            $('#datenumber').val('');
            $('#haft').val('');
            $('#hafteve').val('');
            $('#datestart').prop('readonly',true);
            $('#dateend').prop('readonly',true);
            $('.timehaft').prop('readonly',true);

        }else{
            $('#datestart').prop('required',true);
            $('#datestart').prop('readonly',false);
            $('#dateend').prop('required',true);
            $('#dateend').prop('readonly',false);
            $('#dateend').css("background-color", "white");
            $('#datenumber').val('');
            $('#haft').val('');
            $('#hafteve').val('');
            $('.timehaft').prop('readonly',false);
            $('.timehaft').css("background-color", "white");
           
        }

    });

    function datediff(){
        var date1 = document.getElementById('datestart').value; //start
        var date2 = document.getElementById('dateend').value; //end
        

        $.ajax({
            url: '{{ url("calculatedate")}}',
            type: 'GET',
            dataType: 'HTML',
            data: {'dstart':date1,'dend':date2},
            success: function(data) {

                if(parseInt(data) > parseInt(limit)){
                    alert('จำนวนวันลาเกินที่กำหนด กรุณาเลือกวันที่ใหม่');
                    // $('#datenumber').focus();
                    // $('#datestart').val('');
                    $('#dateend').val('');
                    $('#datenumber').val('');

                }else{
                        document.getElementById('datenumber').value=data;
                        daysum = parseInt(data);
                        daysumold = daysum;
                }

                
            }
        });

        // date1 = date1.split("-");
        // date2 = date2.split("-");
        // console.log(date1);
        // console.log(date2);
    
        // sDate = new Date(date1[0],date1[1]-1,date1[2]); 
        // eDate = new Date(date2[0],date2[1]-1,date2[2]); 
        // var daysDiff = (Math.round((eDate-sDate)/86400000))+1;
        // daysum = daysDiff;
        // daysumold = daysum;
       
       
        // alert(daysDiff);
    }

    function caltime(){


        var min = $('#haft').val();
        var max = $('#hafteve').val();
        
       

        if(max > min && max > '12:00'){
            if(chk==0 ){
                daysum = daysum+0.5;
                // document.getElementById('datenumber').value=daysum;
                chk = 1;

            }else{
               
                // document.getElementById('datenumber').value=daysum;

            }

            if(daysum > parseInt(limit)){
                alert('จำนวนวันลาเกินที่กำหนด กรุณาเลือกวันที่ใหม่');
                $('#dateend').val('');
                $('#haft').val('');
                $('#hafteve').val('');
                $('#datenumber').val('');

            }else{
                document.getElementById('datenumber').value=daysum;
                
            }


           

        }else{
            // console.log(daysumold);
            if(chk==1){
                daysum = daysum-0.5;

            }
            document.getElementById('datenumber').value=daysumold;
            chk = 0;
            
        }

        

    }
  

    // $('#hafteve').change(function(){
       
    //     var min = $('#haft').val();
    //     if($(this).val() > min && $(this).val() > '12:00'){
    //         if(chk==0 ){
    //             daysum = daysum+0.5;
    //             document.getElementById('datenumber').value=daysum;
    //             chk = 1;

    //         }else{
               
    //             document.getElementById('datenumber').value=daysum;

    //         }
    //     }else{
    //         // console.log(daysumold);
    //         if(chk==1){
    //             daysum = daysum-0.5;

    //         }
    //         document.getElementById('datenumber').value=daysumold;
    //         chk = 0;
    //     }


    // });
   
    const input = document.getElementById('input')
    input.addEventListener('change', (event) => {
        const target = event.target
            if (target.files && target.files[0]) {

            /*Maximum allowed size in bytes
                5MB Example
                Change first operand(multiplier) for your needs*/
            const maxAllowedSize = 5 * 1024 * 1024;
            if (target.files[0].size > maxAllowedSize) {
                // Here you can ask your users to load correct file
                target.value = ''
                alert('ไฟล์มีขนาดเกิน 5 MB กรุณาอัพโหลดใหม่');
            }
        }
    });


    
</script>   
</body>
</html>
@stop
