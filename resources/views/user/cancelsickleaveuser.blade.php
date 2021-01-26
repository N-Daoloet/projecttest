@extends('layouts-user.template-user')
@section('content-user')
<!-- [ Main Content ] start -->
<section class="pcoded-main-container">
    <script>
        var A = "{{Session::get('success')}}";
        if(A){
            alert(A);
        }
    </script>
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
                                        <h5>ยกเลิกใบลาป่วย</h5>
                                        {{-- {{dd($data)}} --}}
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
                                                      <td><br>{{$item->ABSENT_START}} ถึง {{$item->ABSENT_END}}</td>
                                                      <td><br>{{$item->ABSENT_NUMBER}}&nbsp;&nbsp;วัน</td>
                                                      <td><br>{{$item->created_at}}</td>
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
                                                    @elseif($item->STATUS_APPROVER==0)
                                                      <td style="text-align: center;color:blue"><br>รออนุมัติจากหัวหน้าฝ่าย</td>
                                                      <td align="center"></td>
                                                    @else
                                                      <td style="text-align: center;color:red"><br>ยกเลิกโดยผู้ใช้</td>
                                                      <td><button type="button" class="btn btn-secondary" onclick="reason({{$item->ABSENT_ID}});">หมายเหตุ</button></td>

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
    @foreach ($data as $item)

      <div class="modal fade" id="reason{{$item->ABSENT_ID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                รายละเอียด
            </div>
            <div class="modal-body">
            
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">เหตุผลที่ยกเลิกการลา</label>
                <textarea type="text" name="ABSENT_REASON" class="form-control" id="exampleFormControlTextarea1" rows="3" readonly>{{$item->ABSENT_CANCLE}}</textarea>
              </div>
          
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
      console.log(id);
      $('#reason'+id).modal('show');
    }
</script>
<!-- [ Main Content ] end -->


@stop
