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
                            <!-- [ Fixed Columns ] start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>กำหนดจำนวนวันลาในปีงบประมาณ</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                            <div class="col-xl-6">
                                                <table class="table table-bordered" >
                                                    <tr>
                                                        <td>&emsp;&emsp;&emsp;ประเภทการลา&emsp;&emsp;&emsp;</td>
                                                        <td>&emsp;จำนวนวันลาสูงสุดในแต่ละรอบปีงบประมาณ&emsp;</td>
                                                        <td>&emsp;&emsp;&emsp;&emsp;ปีงบประมาณ&emsp;&emsp;&emsp;&emsp;</td> 
                                                    </tr>
                                                    <tr>
                                                        <td align="center">ลาป่วย</td>
                                                        <td>
                                                            <div class="text-center">35&emsp;วัน &emsp;&emsp;<button class="btn btn-outline-warning btn-sm" type="submit"><i class="feather icon-edit-2"></i>แก้ไข</button></div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">&emsp;2/2561&emsp;&emsp;<button class="btn btn-outline-warning btn-sm" type="submit"><i class="feather icon-edit-2"></i>แก้ไข</button></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">ลาพักผ่อน</td>
                                                        <td>
                                                            <div class="text-center">35&emsp;วัน&emsp;&emsp;<button class="btn btn-outline-warning btn-sm" type="submit"><i class="feather icon-edit-2"></i>แก้ไข</button></div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">&emsp;1/2562&emsp;&emsp;<button class="btn btn-outline-warning btn-sm" type="submit"><i class="feather icon-edit-2"></i>แก้ไข</button></div>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td align="center">ลากิจส่วนตัว</td>
                                                        <td>
                                                            <div class="text-center">40&emsp;วัน &emsp;&emsp;<button class="btn btn-outline-warning btn-sm" type="submit"><i class="feather icon-edit-2"></i>แก้ไข</button></div>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">&emsp;2/2563&emsp;&emsp;<button class="btn btn-outline-warning btn-sm" type="submit"><i class="feather icon-edit-2"></i>แก้ไข</button></div>
                                                        </td> 
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary" type="submit">ยืนยัน</button>
                                        <a href="" class="btn btn-secondary" type="back">ย้อนกลับ</a>                          
                                    </div><br><br>
                                </div>
                            </div>
                            <!-- [ Fixed Columns ] end -->
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
<script>
  
</script>
</html>
@stop
