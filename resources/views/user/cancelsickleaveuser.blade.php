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
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <td align="center">ลำดับที่</td>
                                                        <td align="center">วันที่ลา</td>
                                                        <td align="center">จำนวนวัน</td>
                                                        <td align="center">วันที่ยื่นเรื่องลา</td>
                                                        <td align="center">สถานะ</td>
                                                        <td align="center">การจัดการ</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php $i=1;?>
                                                  @foreach ($data as $item)
                                                    <tr>
                                                      <td align="center" scope="row"><br>{{$i}}</th>
                                                      <td align="center"><br>{{$item->ABSENT_START}} ถึง {{$item->ABSENT_END}}</td>
                                                      <td align="center"><br>{{$item->ABSENT_NUMBER}}&nbsp;&nbsp;วัน</td>
                                                      <td align="center"><br>{{$item->created_at}}</td>
                                                      @if($item->STATUS_APPROVER==1)
                                                        <td style="text-align: center;color:red"><br>ไม่อนุมัติ</td>
                                                        <td style="text-align: center;color:red"><br>&nbsp;&nbsp;{{$item->APPROVER_COMMENT}}</td>   

                                                      @elseif($item->STATUS_APPROVER==2)
                                                        <td align="center"><br><span class="badge badge-pill badge-success">อนุมัติ</span></td>
                                                        <td align="center"></td>
                                                      @elseif($item->STATUS_APPROVER==0)
                                                        <td style="text-align: center;color:blue"><br>รออนุมัติ</td>
                                                        <td align="center"><br>&nbsp;&nbsp;<button class="btn btn-outline-danger btn-sm" type="button" onclick="cancle({{$item->ABSENT_ID}});"><i class="feather icon-x"></i>ยกเลิก</button>    
                                                      @else
                                                        <td style="text-align: center;color:red"><br>ยกเลิกแล้ว</td>
                                                        <td style="text-align: center;color:red"><br>&nbsp;&nbsp;{{$item->ABSENT_CANCLE}}</td>

                                                      @endif
                                                      
                                                    </tr>
                                                    <?php $i=$i+1;?>
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
<script>
    function cancle(id){
      document.getElementById('absentid').value=id;
      $('#exampleModal').modal('show');
    }
</script>
<!-- [ Main Content ] end -->


@stop
