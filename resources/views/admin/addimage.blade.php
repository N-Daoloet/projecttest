@extends('layouts-admin.template-admin')
@section('content-admin')
<script>
    var A = "{{Session::get('success')}}";
    if(A){
        alert(A);
    }
</script>
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                         <!-- [ Main Content ] start -->
                         <div class="row">
                            <!-- [ file-upload ] start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>อัปโหลดรูปภาพที่ 1</h5>
                                    </div>
                                    <div class="card-block">
                                        <form id="send" action="{{url('updateimage')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="fallback">
                                                <input type="file" name="preview_image" required />
                                            </div>
                                        </form>

                                        <div class="text-center m-t-20">
                                            <button type="button" class="btn btn-primary" onclick="send();">อัปโหลด</button>
                                            <a href="{{route ('addimage')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a> 
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>อัปโหลดรูปภาพที่ 2</h5>
                                    </div>
                                    <div class="card-block">
                                        <form id="send" action="{{url('updateimage')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="fallback">
                                                <input type="file" name="preview_image" required />
                                            </div>
                                        </form>

                                        <div class="text-center m-t-20">
                                            <button type="button" class="btn btn-primary" onclick="send();">อัปโหลด</button>
                                            <a href="{{route ('addimage')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a> 
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>อัปโหลดรูปภาพที่ 3</h5>
                                    </div>
                                    <div class="card-block">
                                        <form id="send" action="{{url('updateimage')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="fallback">
                                                <input type="file" name="preview_image" required />
                                            </div>
                                        </form>

                                        <div class="text-center m-t-20">
                                            <button type="button" class="btn btn-primary" onclick="send();">อัปโหลด</button>
                                            <a href="{{route ('addimage')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a> 
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- [ file-upload ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function send(){
        $('#send').submit();
    }
</script>
<!-- [ Main Content ] end -->
@stop