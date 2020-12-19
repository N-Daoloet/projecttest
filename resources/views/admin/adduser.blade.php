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
                                                <form action="{{route('adduser2')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form">
                                                        <div class="form-group">
                                                            <label class="form-label">บัญชีผู้ใช้</label>
                                                            <input type="text" class="form-control" id="" name="username" placeholder="บัญชีผู้ใช้"><br><br>
                                                            {{-- <label class="form-label">ชื่อผู้ใช้</label>
                                                            <input type="text" class="form-control" id="" name="firstname" placeholder="ชื่อ"><br>
                                                            <label class="form-label">นามสกุลผู้ใช้งาน</label>
                                                            <input type="text" class="form-control" id="" name="lastname" placeholder="นามสกุล"><br><br> --}}
                                                            <button class="btn btn-primary" type="submit">ค้นหา</button>
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
