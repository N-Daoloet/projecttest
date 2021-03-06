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
                                        <h5>ตรวจสอบการลาของบุคลากร [ ลา... ]</h5>
                                    </div>
                                    <br>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">ตั้งแต่</label>
                                                    <input type="date" class="form-control" style="background-color:#ffffff" class="form-control" id="datestart" name="ABSENT_START" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">ถึง</label>
                                                    <input type="date" class="form-control" style="background-color:#ffffff" class="form-control" id="dateend" name="ABSENT_END" onchange="datediff();" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-3">
                                                <label class="form-label">&nbsp;&nbsp;</label><br>
                                                <button class="btn btn-primary" type="button" onclick="search();">ค้นหา</button>
                                            </div>
                                            <div id="datauser" style="display: none">
                                                    <hr style="background-color: #3f4d67;width:800px">
                                                    <form action={{route('post')}} method="post" name="test">
                                                        @csrf
                                                        <div id="formuser"></div>
                                                    </form>
                                                </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table id="responsive-table" class="display table dt-responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr style="text-align: center">
                                                        <td>ลำดับที่</td>
                                                        <td>วันที่ยื่นเรื่องลา</td>
                                                        <td>ชื่อ - นามสกุล</td>
                                                        <td>รายการลา</td>
                                                        <td>ไฟล์แนบ</td>
                                                        <td>การจัดการ</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1;?>
                                                    @foreach ($data as $item)
                                                        <tr style="text-align: center">
                                                            <td scope="row"><br>{{$i}}</th>
                                                     
                                                            <td><br>{{$item->USER_FNAME}} - {{$item->USER_LNAME}}</td>
                                                            @if(!empty($item->ABSENT_END))
                                                                <td>{{$item->ABSENTTYPE_NAME}}<br>{{date_format(date_create($item->ABSENT_START),'d-m-Y')}} ถึง {{date_format(date_create($item->ABSENT_END),'d-m-Y')}}<br>จำนวน {{$item->ABSENT_NUMBER}} วัน</td>
                                                            @else
                                                                <td>{{$item->ABSENTTYPE_NAME}}<br>{{date_format(date_create($item->ABSENT_START),'d-m-Y')}} <br>จำนวน {{$item->ABSENT_NUMBER}} วัน</td>
                                                            @endif
                                                            <td><br>&nbsp;&nbsp;<a href="assets/fileupload/{{$item->ABSENT_FILE}}" download type="button" class="btn btn-outline-primary btn-sm"><i class="feather icon-file-text"></i>โหลดไฟล์แนบ</a></td>
                                                                <form action="{{url('approveleave')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="absentid1" id="absentid1" value="{{$item->ABSENT_ID}}">
                                                                    <input type="hidden" name="approveleave" value="1">
                                                                    <td><br><button class="btn btn-outline-warning btn-sm" type="submit"><i class="feather icon-edit-2"></i>แก้ไข</button>
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

@stop
