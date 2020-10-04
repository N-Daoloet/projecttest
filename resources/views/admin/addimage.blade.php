@extends('layouts-admin.template-admin')
@section('content-admin')
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
                                        <h5>อัปโหลดรูปภาพ</h5>
                                    </div>
                                    <div class="card-block">
                                        <form action="assets/plugins/fileupload/js/file-upload.php" class="dropzone">
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>
                                        </form>
                                        <div class="text-center m-t-20">
                                            <button class="btn btn-primary">อัปโหลด</button>
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
<!-- [ Main Content ] end -->
@stop