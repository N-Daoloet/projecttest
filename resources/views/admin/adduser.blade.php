@extends('layouts-admin.template-admin')
@section('content-admin')
<script>
    var err = "{{Session::get('error')}}";
    var succ = "{{Session::get('success')}}";
    if(err){
        alert(err);
    }else if(succ){
        alert(succ);
    }
</script>
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
                                        <h5>เพิ่มข้อมูลผู้ใช้</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-1"></div>
                                            <div class="col-md-6">
                                                <div class="form">
                                                    <div class="form-group">
                                                        <label class="form-label">บัญชีผู้ใช้</label>
                                                        <input type="text" class="form-control" id="usr" name="username" placeholder="บัญชีผู้ใช้"><br><br>
                                                        {{-- <label class="form-label">ชื่อผู้ใช้</label>
                                                        <input type="text" class="form-control" id="" name="firstname" placeholder="ชื่อ"><br>
                                                        <label class="form-label">นามสกุลผู้ใช้งาน</label>
                                                        <input type="text" class="form-control" id="" name="lastname" placeholder="นามสกุล"><br><br> --}}
                                                        <button class="btn btn-primary" type="button" onclick="search();">ค้นหา</button>
                                                        {{-- <a href="{{route ('adduser')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a>    --}}
                                                    </div>
                                                </div>
                                                <br>
                                                <div id="datauser" style="display: none">
                                                    <form action="{{route('updateuser')}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div id="formuser"></div>
                                                    </form>
                                                </div>
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
<script>
    function search(){
        var usr = document.getElementById('usr').value;
        $.ajax({
            url: '{{ url("adduser2")}}/' + encodeURIComponent(usr),
            type: 'GET',
            dataType: 'HTML',
            success: function(data) {
                if(data=='0'){
                    window.location.reload();
                }else{
                    document.getElementById('datauser').style.display ="";
                    $('#formuser').html(data);
                }
                
            }
        });
    }
</script>
</body>
</html>
@stop
