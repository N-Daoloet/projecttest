@extends('layouts-admin.template-admin')
@section('content-admin')
<script>
    var A = "{{Session::get('success')}}";
    if(A){
        alert(A);
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                                        <form action="{{url('updateimage')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id_banner" value="1">
                                            <div class="fallback" id="img1" style="display: ">
                                                @if(!empty($data1->image))
                                                    <div  style="text-align: center" >
                                                        <img src="assets/images/Banner/{{$data1->image}}"width="auto" height="450px" >
                                                    </div>
                                                @else
                                                    <input type="file" name="preview_image" required />
                                                @endif
                                            </div>
                                            <div class="fallback" id="edit1" style="display:none">
                                                <input type="file" name="preview_image" required />
                                            </div>

                                            <div class="text-center m-t-20" id="btnedit1">
                                                @if(empty($data1->image))
                                                    <button type="submit" class="btn btn-primary" >อัปโหลด</button>
                                                @else
                                                    <button type="button" class="btn btn-warning" id="btn1" >แก้ไข</button>
                                                @endif
                                            </div>

                                            <div class="text-center m-t-20" id="btnup1" style="display: none">
                                                <button type="submit" class="btn btn-primary" >อัปโหลด</button>
                                                <button type="button" class="btn btn-danger" id="cancel1" >ยกเลิก</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header">
                                        <h5>อัปโหลดรูปภาพที่ 2</h5>
                                    </div>
                                    <div class="card-block">
                                        <form action="{{url('updateimage')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id_banner" value="2">
                                            <div class="fallback" id="img2" style="display: ">
                                                @if(!empty($data2->image))
                                                    <div  style="text-align: center" >
                                                        <img src="assets/images/Banner/{{$data2->image}}"width="auto" height="450px" >
                                                    </div>
                                                @else
                                                    <input type="file" name="preview_image" required />
                                                @endif
                                            </div>
                                            <div class="fallback" id="edit2" style="display:none">
                                                <input type="file" name="preview_image" required />
                                            </div>

                                            <div class="text-center m-t-20" id="btnedit2">
                                                @if(empty($data2->image))
                                                    <button type="submit" class="btn btn-primary" >อัปโหลด</button>
                                                @else
                                                    <button type="button" class="btn btn-warning" id="btn2" >แก้ไข</button>
                                                @endif
                                            </div>

                                            <div class="text-center m-t-20" id="btnup2" style="display: none">
                                                <button type="submit" class="btn btn-primary" >อัปโหลด</button>
                                                <button type="button" class="btn btn-danger" id="cancel2" >ยกเลิก</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>อัปโหลดรูปภาพที่ 3</h5>
                                    </div>
                                    <div class="card-block">
                                        <form action="{{url('updateimage')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id_banner" value="3">
                                            <div class="fallback" id="img3" style="display: ">
                                                @if(!empty($data3->image))
                                                    <div  style="text-align: center" >
                                                        <img src="assets/images/Banner/{{$data3->image}}"width="auto" height="450px" >
                                                    </div>
                                                @else
                                                    <input type="file" name="preview_image" required />
                                                @endif
                                            </div>
                                            <div class="fallback" id="edit3" style="display:none">
                                                <input type="file" name="preview_image" required />
                                            </div>

                                            <div class="text-center m-t-20" id="btnedit3">
                                                @if(empty($data3->image))
                                                    <button type="submit" class="btn btn-primary" >อัปโหลด</button>
                                                @else
                                                    <button type="button" class="btn btn-warning" id="btn3" >แก้ไข</button>
                                                @endif
                                            </div>

                                            <div class="text-center m-t-20" id="btnup3" style="display: none">
                                                <button type="submit" class="btn btn-primary" >อัปโหลด</button>
                                                <button type="button" class="btn btn-danger" id="cancel3" >ยกเลิก</button>
                                            </div>

                                        </form>
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
    

    $('#btn1').click(function(){
        document.getElementById('img1').style.display="none";
        document.getElementById('edit1').style.display="";
        document.getElementById('btnedit1').style.display="none";
        document.getElementById('btnup1').style.display="";
    });

    $('#cancel1').click(function(){
        document.getElementById('img1').style.display="";
        document.getElementById('edit1').style.display="none";
        document.getElementById('btnedit1').style.display="";
        document.getElementById('btnup1').style.display="none";
    });




    $('#btn2').click(function(){
        document.getElementById('img2').style.display="none";
        document.getElementById('edit2').style.display="";
        document.getElementById('btnedit2').style.display="none";
        document.getElementById('btnup2').style.display="";
    });

    $('#cancel2').click(function(){
        document.getElementById('img2').style.display="";
        document.getElementById('edit2').style.display="none";
        document.getElementById('btnedit2').style.display="";
        document.getElementById('btnup2').style.display="none";
    });




    $('#btn3').click(function(){
        document.getElementById('img3').style.display="none";
        document.getElementById('edit3').style.display="";
        document.getElementById('btnedit3').style.display="none";
        document.getElementById('btnup3').style.display="";
    });

    $('#cancel3').click(function(){
        document.getElementById('img3').style.display="";
        document.getElementById('edit3').style.display="none";
        document.getElementById('btnedit3').style.display="";
        document.getElementById('btnup3').style.display="none";
    });
</script>
<!-- [ Main Content ] end -->
@stop