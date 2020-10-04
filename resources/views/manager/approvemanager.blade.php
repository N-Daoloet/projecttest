@extends('layouts-manager.template-manager')
@section('content-manager')
<!-- [ Main Content ] start -->
<section class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!-- [ Hover-table ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>อนุมัติผลการลา</h5>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <td align="center">ลำดับที่</td>
                                                        <td align="center">ชื่อ-นามสกุล</td>
                                                        <td align="center">รายการลา</td>
                                                        <td align="center">ไฟล์แนบ</td>
                                                        <td align="center">วันที่ยื่นเรื่องลา</td>
                                                       
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td align="center" scope="row"><br>1</th>
                                                        <td align="center"><br>ณัฐธิดา - หงษ์ไทย</td>
                                                        <td>ลาป่วย<br>13/04/2563 ถึง 16/04/2563<br>จำนวน 4 วัน</td>
                                                        <td align="center"><br>&nbsp;&nbsp;<button type="button" class="btn btn-outline-primary btn-sm"><i class="feather icon-file-text"></i>ไฟล์แนบ</button></td>
                                                        <td align="center"><br>13/04/2563 18:13:02</td>
                                                        
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Hover-table ] end --> 
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ Main Content ] end -->

</body>
</html>
@stop
