@extends('layouts-manager.template-manager')
@section('content-manager')
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
                                        <h5>อนุมัติผลการลา</h5>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table  id="responsive-table" class="display table dt-responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr style="text-align: center">
                                                        <td>ลำดับที่</td>
                                                        <td>ชื่อ-นามสกุล</td>
                                                        <td>รายการลา</td>
                                                        <td>ไฟล์แนบ</td>
                                                        <td>วันที่ยื่นเรื่องลา</td>
                                                        <td>การจัดการ</td>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1;?>
                                                  @foreach ($data as $item)
                                                    <tr style="text-align: center">
                                                        <td scope="row"><br>{{$i}}</th>
                                                        <td><br>{{$item->USER_FNAME}}-{{$item->USER_LNAME}}</td>
                                                        @if(!empty($item->ABSENT_END))
                                                            <td>{{$item->ABSENTTYPE_NAME}}<br>{{date_format(date_create($item->ABSENT_START),'d-m-Y')}} ถึง {{date_format(date_create($item->ABSENT_END),'d-m-Y')}}<br>จำนวน {{$item->ABSENT_NUMBER}} วัน</td>
                                                        @else
                                                            <td>{{$item->ABSENTTYPE_NAME}}<br>{{date_format(date_create($item->ABSENT_START),'d-m-Y')}} <br>จำนวน {{$item->ABSENT_NUMBER}} วัน</td>
                                                        @endif

                                                        @if(!empty($item->ABSENT_FILE))
                                                            <td><br>&nbsp;&nbsp;<a href="assets/fileupload/{{$item->ABSENT_FILE}}" download type="button" class="btn btn-outline-primary btn-sm"><i class="feather icon-file-text"></i>โหลดไฟล์แนบ</a></td>
                                                        @else
                                                            <td align="center"><br>-</td>
                                                        @endif


                                                        <td><br>{{$item->created_at}}</td>
                                                        @if($item->STATUS_APPROVER==1)
                                                            <td><br>ยกเลิกโดยผู้ใช้</td>
                                                        @elseif($item->STATUS_APPROVER==2)
                                                            <td><br>อนุมัติ โดยหัวหน้าฝ่าย</td>
                                                        @elseif($item->STATUS_APPROVER==4)
                                                            <td><br>อนุมัติ โดยผู้อำนวยการ</td>
                                                        @elseif($item->STATUS_APPROVER==5)
                                                            <td><br>ไม่อนุมัติ โดยผู้อำนวยการ</td>
                                                        @elseif($item->STATUS_APPROVER==3)
                                                            <td><br>ไม่อนุมัติ โดยหัวหน้าฝ่าย</td>
                                                        @elseif($item->STATUS_APPROVER==7)
                                                            <td><br>ไม่อนุมัติ โดยเจ้าหน้าที่งานบุคคล</td>
                                                        @elseif($item->STATUS_APPROVER==0)
                                                            <td><br>รอเจ้าหน้าที่งานบุคคลตรวจสอบ</td>
                                                        @elseif($item->STATUS_APPROVER==6)
                                                        <td><br>
                                                                <button class="btn btn-outline-info btn-sm" type="button" onclick="btnmodal({{$item->ABSENT_ID}});"><i class="feather icon-edit-2"></i>ดูรายละเอียด</button><br>
                                                                <button class="btn btn-outline-success btn-sm" type="button" onclick="btnsumit({{$item->ABSENT_ID}},'{{$item->ABSENTTYPE_NAME}}','{{$item->USER_FNAME}}','{{$item->USER_LNAME}}');"><i class="feather icon-edit-2"></i>อนุมัติ</button>
                                                                <br><button class="btn btn-outline-danger btn-sm" type="button" onclick="send({{$item->ABSENT_ID}},'{{$item->ABSENTTYPE_NAME}}','{{$item->USER_FNAME}}','{{$item->USER_LNAME}}');"><i class="feather icon-x"></i>ไม่อนุมัติ</button>
                                                            </td>

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

<form action="{{url('approveleavemanager')}}" method="POST" id="absentform">
    @csrf
    <input type="hidden" name="absentid1" id="absentid1">
    <input type="hidden" name="approvestatus" value="2">
    <input type="hidden" name="position" value="0">

</form>
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
        <form action="{{url('approveleavemanager')}}" method="POST">
            <div class="modal-body">
           
                @csrf
                <div class="form-group">
                {{-- <label for="recipient-name" class="col-form-label"><p id="demo"></p></label> --}}
                <input type="hidden" name="absentid" id="absentid" >
                <input type="hidden" name="approvestatus" value="3">

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


<div class="modal fade" id="detailab" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                รายละเอียดการลา
            </div>
            <div class="modal-body">
                <div id="detailback">

                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function() {
        $('#responsive-table').dataTable();
    } );

    function btnmodal(id){
        $.ajax({
            url: '{{ url("detailmanager")}}',
            type: 'GET',
            dataType: 'HTML',
            data : {'id':id},
            success: function(data) {
                $('#detailback').html(data);
                $('#detailab').modal('show');

                
            }
        });
    }


    function send(id,val1,val2,val3){
        // document.getElementById('demo').innerHTML = 'การ' +val1+'ของ   '+val2+'   '+val3;
        document.getElementById('absentid').value = id;
        $('#exampleModal').modal('show');
    }

    function btnsumit(val,val1,val2,val3){
        var r = confirm("คุณต้องการอนุมัติ การ"+val1+"ของ"+val2+'-'+val3+" ใช่หรือไม่ ?");
        if (r == true) {
            document.getElementById('absentid1').value = val;
            $('#absentform').submit();
        } else {
            return false;
        }
    }
</script>

</body>
</html>
@stop
