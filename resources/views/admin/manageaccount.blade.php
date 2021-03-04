@extends('layouts-admin.template-admin')
@section('content-admin')
<!-- data tables css -->
<!-- [ Main Content ] start -->
<script>
    var err = "{{Session::get('error')}}";
    var succ = "{{Session::get('success')}}";
    if(err){
        alert(err);
    }else if(succ){
        alert(succ);
    }
</script>
<!-- datatable Js -->
<script src="assets/plugins/data-tables/js/datatables.min.js"></script>
<script src="assets/js/pages/tbl-datatable-custom.js"></script>
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
                                                <div class="form">
                                                    <label for="exampleFormControlSelect1">สังกัดฝ่าย</label>
                                                    <select class="form-control" id="select1" name="department">
                                                        <option value="1">สำนักงานผู้อำนวยการ</option>
                                                        <option value="2">ฝ่ายพัฒนาระบบสารสนเทศ</option>
                                                        <option value="3">ฝ่ายวิศวกรรมระบบเครือข่าย</option>
                                                        <option value="4">ฝ่ายบริการวิชาการและส่งเสริมการวิจัย</option>
                                                        <option value="5">ฝ่ายเทคโนโลยีสารสนเทศ วิทยาเขตปราจีนบุรี</option>
                                                        <option value="6">ฝ่ายเทคโนโลยีสารสนเทศ วิทยาเขตระยอง</option>
                                                    </select><br>
                                                    <label for="exampleFormControlSelect1">ประเภทบุคลากร</label>
                                                    <select class="form-control" id="select2" name="person">
                                                        <option value="1">ผู้บริหารสำนักคอมพิวเตอร์ฯ</option>
                                                        <option value="2">พนักงานมหาวิทยาลัย</option>
                                                        <option value="3">พนักงานพิเศษ (รอบเช้า)</option>
                                                        <option value="4">พนักงานพิเศษ (รอบบ่าย)</option>
                                                        <option value="5">นักศึกษาฝึกงาน/สหกิจศึกษา</option>
                                                        <option value="6">นักศึกษาช่วยงานวิชาการ</option>
                                                    </select><br><br>
                                                    <button class="btn btn-primary" type="button" onclick="search();">ค้นหา</button>
                                                    {{-- <a href="{{route ('manageaccount')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a>   --}}
                                                </div>
                                                <br>
                                            </div>
                                            <div id="datauser" style="display: none">
                                                <form action={{route('post')}} method="post" name="test">
                                                    @csrf
                                                    <div id="formuser"></div>
                                                </form>
                                            </div>
                                            {{-- <div class="col-md-1"></div>s --}}
                                            
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $('#responsive-table').DataTable();
    } );
    
    function changestatususer(a,chk){
        var val1 = document.getElementById('userid'+a.value).value;
        var val2 = document.getElementById('userfname'+a.value).value;
        var val3 = document.getElementById('userlname'+a.value).value;
        if(chk==1){
            // console.log('nochecked');
            var result = confirm("คุณต้องการเปิดการใช้งานของ   "+val2+'   '+val3+"   ใช่หรือไม่?");
            if (result) {
                $.ajax({
                    url: "{{url('changestatususer')}}/1/" + encodeURIComponent(val1),
                    type: 'GET',
                    dataType: 'HTML',
                    success: function(data) {
                        alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                        window.location.reload();
                    }
                });
            }else{
                return false;
            }
        }else{
            var result = confirm("คุณต้องการปิดการใช้งานของ   "+val2+'   '+val3+"   ใช่หรือไม่?");
            if (result) {
                    $.ajax({
                        url: "{{url('changestatususer')}}/2/" + encodeURIComponent(val1),
                        type: 'GET',
                        dataType: 'HTML',
                        success: function(data) {
                            alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }else{
                    return false;
                }
        }
    }


    function search(){
        var dep = $("#select1 :selected").val();
        var per = $("#select2 :selected").val();
        
        $.ajax({
            url: '{{ url("manageaccount2")}}/' + encodeURIComponent(dep)+ '/' + per,
            type: 'GET',
            dataType: 'HTML',
            success: function(data) {
                if(data=='0'){
                    alert('ไม่พบข้อมูล');
                    // window.location.reload();
                }else{
                    document.getElementById('datauser').style.display ="";
                    function changestatususer(chk,val1,val2,val3){
                        if(chk==1){
                            // console.log('nochecked');
                            var result = confirm("คุณต้องการเปิดการใช้งานของ   "+val2+'   '+val3+"   ใช่หรือไม่?");
                            if (result) {
                                $.ajax({
                                    url: "{{url('changestatususer')}}/1/" + encodeURIComponent(val1),
                                    type: 'GET',
                                    dataType: 'HTML',
                                    success: function(data) {
                                        alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                                        window.location.reload();
                                    }
                                });
                            }else{
                                return false;
                            }
                        }else{
                            var result = confirm("คุณต้องการปิดการใช้งานของ   "+val2+'   '+val3+"   ใช่หรือไม่?");
                            if (result) {
                                    $.ajax({
                                        url: "{{url('changestatususer')}}/2/" + encodeURIComponent(val1),
                                        type: 'GET',
                                        dataType: 'HTML',
                                        success: function(data) {
                                            alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                                            window.location.reload();
                                        }
                                    });
                                }else{
                                    return false;
                                }
                        }
                    }
                    $('#formuser').html(data);
                    $('#responsive-table').DataTable();
                    
                   
                }
                
            }
        });
    }
</script>
</body>
</html>
@stop
