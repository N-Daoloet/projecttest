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
                                                        <td align="center">การจัดการ</td>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1;?>
                                                  @foreach ($data as $item)
                                                    <tr>
                                                        <td align="center" scope="row"><br>{{$i}}</th>
                                                            <td align="center"><br>{{$item->USER_FNAME}}-{{$item->USER_LNAME}}</td>
                                                            <td align="center">{{$item->ABSENTTYPE_NAME}}<br>{{$item->ABSENT_START}} ถึง {{$item->ABSENT_END}}<br>จำนวน {{$item->ABSENT_NUMBER}} วัน</td>
                                                        <td align="center"><br>&nbsp;&nbsp;<button type="button" class="btn btn-outline-primary btn-sm"><i class="feather icon-file-text"></i>ไฟล์แนบ</button></td>

                                                        <td align="center"><br>{{$item->created_at}}</td>
                                                        @if($item->STATUS_APPROVER==3)
                                                            <td align="center"><br>ยกเลิกโดยผู้ใช้</td>
                                                        @elseif($item->STATUS_APPROVER==2)
                                                            <td align="center"><br>อนุมัติ</td>
                                                        @elseif($item->STATUS_APPROVER==1)
                                                            <td align="center"><br>ไม่อนุมัติ</td>
                                                        @elseif($item->STATUS_APPROVER==0)
                                                            <form action="{{url('approveleave')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="absentid1" id="absentid1" value="{{$item->ABSENT_ID}}">
                                                                <input type="hidden" name="approveleave" value="1">
                                                                <td align="center"><br><button class="btn btn-outline-success btn-sm" type="submit"><i class="feather icon-edit-2"></i>อนุมัติ</button>
                                                                <button class="btn btn-outline-danger btn-sm" type="button" onclick="send({{$item->ABSENT_ID}},'{{$item->ABSENTTYPE_NAME}}','{{$item->USER_FNAME}}','{{$item->USER_LNAME}}');"><i class="feather icon-x"></i>ไม่อนุมัติ</button></td>

                                                            </form>
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

</body>
</html>
@stop
