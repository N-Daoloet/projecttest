@extends('layouts-admin.template-admin')
@section('content-admin')
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
                                        <h5>ตรวจสอบการลาของบุคลากร</h5>
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
                                                            <td align="center"><br>{{$item->USER_FNAME}} - {{$item->USER_LNAME}}</td>
                                                            <td align="center">{{$item->ABSENTTYPE_NAME}}<br>{{$item->ABSENT_START}} ถึง {{$item->ABSENT_END}}<br>จำนวน {{$item->ABSENT_NUMBER}} วัน</td>
                                                            <td align="center"><br>&nbsp;&nbsp;<button type="button" class="btn btn-outline-primary btn-sm"><i class="feather icon-file-text"></i>ไฟล์แนบ</button></td>
                                                            <td align="center"><br>{{$item->created_at}}</td>
                                                            
                                                                <form action="{{url('approveleave')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="absentid1" id="absentid1" value="{{$item->ABSENT_ID}}">
                                                                    <input type="hidden" name="approveleave" value="1">
                                                                    <td align="center"><br><button class="btn btn-outline-warning btn-sm" type="submit"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                                                   </td>

                                                                </form>
                                                          
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5>เหตุผลที่ไม่อนุมัติการลา</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{url('approveleave')}}" method="POST">
            <div class="modal-body">
           
                @csrf
                <div class="form-group">
                <label for="recipient-name" class="col-form-label"><p id="demo"></p></label>
                <input type="hidden" name="absentid" id="absentid" >
                <input type="hidden" name="approveleave" value="2">

                <textarea type="text" name="APPROVER_COMMENT" class="form-control" id="exampleFormControlTextarea1" rows="3" ></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-primary">ยืนยัน</button>
            </div>
        </form>
      </div>
    </div>
</div>

<script>
    function send(id,val1,val2,val3){
        document.getElementById('demo').innerHTML = 'การ' +val1+'ของ   '+val2+'   '+val3;
        document.getElementById('absentid').value = id;
        $('#exampleModal').modal('show');
    }
</script>
</body>
</html>
@stop
