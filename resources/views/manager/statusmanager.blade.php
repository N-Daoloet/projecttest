@extends('layouts-manager.template-manager')
@section('content-manager')
<?php  use \App\Http\Controllers\UserController; ?>


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
                                        <h5>ตรวจสอบสถานะการลา</h5>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                  <tr style="text-align: center">
                                                    <td>ลำดับที่</td>
                                                    <td>วันที่ยื่นเรื่องลา</td>
                                                    <td>วันที่ลา</td>
                                                    <td>จำนวนวัน</td>
                                                    <td>ประเภทการลา</td>
                                                    <td>ไฟล์แนบ</td>
                                                    <td>สถานะ</td>
                                                    <td>หมายเหตุ</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1;?>
                                                    @foreach ($data as $item)
                                                    <tr>
                                                      <td align="center" scope="row"><br>{{$i}}</th>
                                                      <td align="center"><br>{!!UserController::Dateformat($item->created_at)!!}</td>
                                                      @if(!empty($item->ABSENT_END))
                                                        <td align="center"><br>{!!UserController::Dateformat($item->ABSENT_START)!!} ถึง {!!UserController::Dateformat($item->ABSENT_END)!!}</td>
                                                      @else
                                                        <td align="center"><br>{!!UserController::Dateformat($item->ABSENT_START)!!}</td>
                                                      @endif
                                                      
                                                      <td align="center"><br>{{$item->ABSENT_NUMBER}}</td>
                                                      <td align="center"><br>{{$item->ABSENTTYPE_NAME}}</td>
                                                      @if(!empty($item->ABSENT_FILE))
                                                        <td align="center"><br>&nbsp;&nbsp;<a href="assets/fileupload/{{$item->ABSENT_FILE}}" download type="button" class="btn btn-outline-primary btn-sm"><i class="feather icon-file-text"></i>โหลดไฟล์แนบ</a></td>
                                                      @else
                                                        <td align="center"><br>-</td>
                                                      @endif
                                                      {{-- <td align="center"><br>{{$item->created_at}}</td> --}}
                                                      @if($item->STATUS_APPROVER==3)
                                                        <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยหัวหน้าฝ่าย</td>
                                                        <td style="text-align: center;color:red"><br>&nbsp;&nbsp;{{$item->APPROVER_COMMENT}}</td>   
                                                      @elseif($item->STATUS_APPROVER==5)
                                                        <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยผู้อำนวยการ</td>
                                                        <td style="text-align: center;color:red"><br>&nbsp;&nbsp;{{$item->APPROVER_COMMENT}}</td>   
                                                      @elseif($item->STATUS_APPROVER==2)
                                                        <td  style="text-align: center;color:blue"><br>รออนุมัติจากผู้อำนวยการ</td>
                                                        <td align="center"></td>
                                                        @elseif($item->STATUS_APPROVER==4)
                                                        <td align="center"><br><span class="badge badge-pill badge-success">อนุมัติ</span></td>
                                                        <td align="center"></td>
                                                      @elseif($item->STATUS_APPROVER==6)
                                                        <td style="text-align: center;color:blue"><br>รออนุมัติจากหัวหน้าฝ่าย</td>
                                                        <td align="center"></td>
                                                      @elseif($item->STATUS_APPROVER==0)
                                                        <td  style="text-align: center;color:blue"><br>รอเจ้าที่งานบุคคลตรวจสอบ</td>
                                                        <td align="center"></td>
                                                      @elseif($item->STATUS_APPROVER==7)
                                                        <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยเจ้าที่งานบุคคล</td>
                                                        <td style="text-align: center;color:red"><br>&nbsp;&nbsp;{{$item->APPROVER_COMMENT}}</td>   
                                                      @else
                                                        <td style="text-align: center;color:red"><br>ยกเลิกโดยผู้ใช้</td>
                                                        <td style="text-align: center;color:red"><br>&nbsp;&nbsp;{{$item->ABSENT_CANCLE}}</td>

                                                      @endif
                                                      
                                                    </tr>
                                                    <?php $i=$i+1;?>
                                                  @endforeach
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


@stop
