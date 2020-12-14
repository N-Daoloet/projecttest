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
                                        <h5>เพิ่มข้อมูลผู้ใช้</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-1"></div>
                                            <div class="col-md-6">
                                                <form action="{{route('updateuser')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form">
                                                        <div class="form-group">
                                                            <label class="form-label">ชื่อ-นามสกุล</label>
                                                            <input type="hidden" name="userid" value="{{$user->USER_ID}}">
                                                            <input type="text" class="form-control" id="" name="firstname" value="{{$user->USER_FNAME}} - {{$user->USER_LNAME}}"><br>
                                                            <label for="exampleFormControlSelect1">บัญชีผู้ใช้</label>
                                                            <input type="text" class="form-control" id="" name="firstname" value="{{!empty($user->USER_USERNAME)?$user->USER_USERNAME:''}}"><br>
                                                            <label for="exampleFormControlSelect1">สังกัดฝ่าย</label>
                                                            <select class="form-control" id="exampleFormControlSelect1" name="depid">
                                                                <option value="">กรุณาเลือก</option>
                                                                @foreach($dep as $department)
                                                                    <option value="{{$department->DEP_ID}}">{{$department->DEP_NAME}}</option>
                                                                @endforeach
                                                            </select>
                                                            <br>
                                                            <label for="exampleFormControlSelect1">ประเภทบุคลากร</label>
                                                            <select class="form-control" id="exampleFormControlSelect1" name="perid">
                                                                <option value="">กรุณาเลือก</option>
                                                                @foreach($per as $personal)
                                                                    <option value="{{$personal->PERTYPE_ID}}">{{$personal->PERTYPE_NAME}}</option>
                                                                @endforeach
                                                            </select><br><br>
                                                                <button class="btn btn-primary" type="submit">เพิ่ม</button>
                                                                <a href="{{route ('adduser')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a>  
                                                            </div>
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
