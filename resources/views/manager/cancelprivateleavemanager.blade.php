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
                                        <h5>ยกเลิกใบลากิจส่วนตัว</h5>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr style="text-align: center">
                                                        <td>ลำดับที่</td>
                                                        <td>วันที่ลา</td>
                                                        <td>จำนวนวัน</td>
                                                        <td>วันที่ยื่นเรื่องลา</td>
                                                        <td>สถานะ</td>
                                                        <td>การจัดการ</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php $i=1;?>
                                                  @foreach ($data as $item)
                                                  <tr style="text-align: center">
                                                    <td><br>{{$i}}   {{$item->ASABSENT_ID}}</th>
                                                    @if(!empty($item->ABSENT_END))
                                                      <td align="center"><br>{!!UserController::Dateformat($item->ABSENT_START)!!} ถึง {!!UserController::Dateformat($item->ABSENT_END)!!}</td>
                                                    @else
                                                      <td align="center"><br>{!!UserController::Dateformat($item->ABSENT_START)!!}</td>
                                                    @endif
                                                    <td><br>{{$item->ABSENT_NUMBER}}&nbsp;&nbsp;วัน</td>
                                                    <td align="center"><br>{!!UserController::Dateformat($item->created_at)!!}</td>
                                                    @if($item->STATUS_APPROVER==3)
                                                      <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยหัวหน้าฝ่าย</td>
                                                      <td><br><button type="button" class="btn btn-outline-secondary btn-sm" onclick="reason({{$item->ABSENT_ID}});">หมายเหตุ</button></td> 
                                                    @elseif($item->STATUS_APPROVER==5)
                                                        <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยผู้อำนวยการ</td>
                                                        <td><br><button type="button" class="btn btn-outline-secondary btn-sm" onclick="reason({{$item->ABSENT_ID}});">หมายเหตุ</button></td> 
                                                    @elseif($item->STATUS_APPROVER==2)
                                                        <td  style="text-align: center;color:blue"><br>รออนุมัติจากผู้อำนวยการ</td>
                                                        <td align="center"></td>
                                                    @elseif($item->STATUS_APPROVER==4)
                                                        <td align="center"><br><span class="badge badge-pill badge-success">อนุมัติ</span></td>
                                                        <td align="center"></td>
                                                    @elseif($item->STATUS_APPROVER==0)
                                                        <td  style="text-align: center;color:blue"><br>รอเจ้าหน้าที่บุคคลตรวจสอบ</td>
                                                        <td align="center"><br><button type="button" class="btn btn-outline-danger btn-sm" onclick="cancle({{$item->ABSENT_ID}});"><i class="feather icon-x"></i>ยกเลิก</button></td>
                                                  
                                                    @elseif($item->STATUS_APPROVER==6)
                                                        <td style="text-align: center;color:blue"><br>รออนุมัติจากหัวหน้าฝ่าย</td>
                                                        <td align="center"></td>
                                                        @elseif($item->STATUS_APPROVER==7)
                                                        <td style="text-align: center;color:red"><br>ไม่อนุมัติ โดยเจ้าหน้าที่บุคคล</td>
                                                        <td><br><button type="button" class="btn btn-outline-secondary btn-sm" onclick="reason({{$item->ABSENT_ID}});">หมายเหตุ</button></td>  
                                                    @else
                                                        <td style="text-align: center;color:red"><br>ยกเลิกโดยผู้ใช้</td>
                                                        <td><br><button type="button" class="btn btn-outline-primary btn-sm" onclick="reason({{$item->ABSENT_ID}});">หมายเหตุ</button></td>
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

    @foreach ($data as $items)

    <div class="modal fade" id="reason{{$items->ABSENT_ID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              รายละเอียด
          </div>
          <div class="modal-body">
          @if($items->STATUS_APPROVER>1)
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">เหตุผลที่ไม่อนุมัติการลา</label>
              <textarea type="text" name="ABSENT_REASON" class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>{{$items->APPROVER_COMMENT}}</textarea>
            </div>
          @else
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">เหตุผลที่ยกเลิกการลา</label>
              <textarea type="text" name="ABSENT_REASON" class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>{{$items->ABSENT_CANCLE}}</textarea>
            </div>
          @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            
          </div>
        </div>
      </div>
    </div>
@endforeach

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{url('cancleofid')}}" method="POST">
            @csrf
                <div class="modal-body">
                <input type="hidden" name="typeabsent" value="6">
                <input type="hidden" name="position" value="1"> {{-- 1manager 0user --}}
                
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">เหตุผลในการยกเลิกใบลา</label>
                    <input type="hidden" name="absentid" id="absentid">
                    <textarea type="text" name="ABSENT_CANCLE" class="form-control" id="exampleFormControlTextarea1" rows="3" ></textarea>
                </div>
            
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                
                </div>
            </form>
        </div>
        </div>
    </div>

</section>

<script>
    function cancle(id){
      document.getElementById('absentid').value=id;
      $('#exampleModal').modal('show');
    }

    function reason(id){
      $('#reason'+id).modal('show');
    }
</script>
<!-- [ Main Content ] end -->


@stop
