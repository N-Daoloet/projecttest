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
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>จัดการบัญชีผู้ใช้</h5>
                                    </div>
                                    <br>
                                    <div class="container" id="datacheck">    
                                        <form action={{route('post')}} method="post" name="test">
                                            @csrf
                                            <table class="table table-bordered" >
                                            <tr style="text-align: center;">
                                                <td rowspan="2"><br>ลำดับที่</td>
                                                <td rowspan="2"><br>สถานะ</td>
                                                {{-- <td rowspan="2" align="center"><br>บัญชีผู้ใช้</td> --}}
                                                <td rowspan="2"><br>ชื่อ - นามสกุล</td>
                                                <td colspan="4">สิทธิ์การใช้งาน</td>
                                                <td rowspan="2"><br>Action</td>
                                            </tr> 
                                            <tr style="text-align: center;">
                                                <td>บุคลากร</td>
                                                <td>หัวหน้าฝ่าย</td>
                                                <td>ผู้บริหาร</td>
                                                <td>ผู้ดูแลระบบ</td>
                                            </tr>
                                            <?php $i=1; ?> 
                                            @foreach($sql as $key => $sqls)
                                                <tr style="text-align: center">
                                                    <td>{{$i}}</td>
                                                    @if($sqls->USER_STATUS===1)
                                                        <td style="color:red">ปิดการใช้งาน</td>
                                                    @else
                                                        <td >เปิดการใช้งาน</td>
                                                    @endif   
                                                    {{-- <td align="center">{{$sqls->USER_USERNAME}}</td> --}}
                                                    <td>{{$sqls->USER_FNAME}} {{$sqls->USER_LNAME}}</td>
                                                    <td><input type="checkbox" disabled Checked></td>
                                                    <div class="checkbox-wrapper">
                                                        <?php $data1 = DB::table('managerauthority')->where('USER_ID',$sqls->USER_ID)->first();?>
                                                        <?php $data2 = DB::table('directorauthority')->where('USER_ID',$sqls->USER_ID)->first();?>
                                                        <?php $data3 = DB::table('adminauthority')->where('USER_ID',$sqls->USER_ID)->first();?>
                                                            
                                                        @if(!empty($data1))
                                                            <td><input type="checkbox" onchange="testdata(this,1);" id="authority1" name="authority1[]" value="{{$sqls->USER_ID}}" checked ></td>
                                                        @else
                                                            <td><input type="checkbox" name="authority1[]" value="{{$sqls->USER_ID}}" ></td>
                                                        @endif

                                                        @if(!empty($data2))
                                                            <td><input type="checkbox" onchange="testdata(this,2)"; id="authority2" name="authority2[]" value="{{$sqls->USER_ID}}" checked></td>
                                                        @else
                                                            <td><input type="checkbox" name="authority2[]" value="{{$sqls->USER_ID}}" ></td>
                                                        @endif

                                                        @if(!empty($data3))
                                                            <td><input type="checkbox" onchange="testdata(this,3)"; id="authority3" name="authority3[]" value="{{$sqls->USER_ID}}" checked></td>
                                                        @else
                                                            <td><input type="checkbox" name="authority3[]" value="{{$sqls->USER_ID}}" ></td>
                                                        @endif
                                                    </div>
                                                    <td>
                                                          
                                                        <input id="user{{$sqls->USER_ID}}" type="checkbox" {{$sqls->USER_STATUS==1?'checked':''}} onclick="changestatususer({{$sqls->USER_ID}},'{{$sqls->USER_FNAME}}','{{$sqls->USER_LNAME}}');" >
                                                      
                                                        {{-- <a href="/delete/{{$sqls->USER_ID}}"><button type="button" class="btn btn-outline-danger btn-sm"><i class="feather feather icon-trash-2"></i>ปิดการใช้งาน</button></a> --}}
                                                    </td>
                                                </tr>
                                            <?php $i++ ?>
                                            @endforeach
                                          </table>
                                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                          <button class="btn btn-primary" type="submit">ยืนยันการจัดการ</button>    
                                          <a href="{{route ('manageaccount')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a> 
                                        </form>                       
                                      </div>
                                      <br>
                                </div>
                            </div>
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
    function changestatususer(val1,val2,val3){
        var isChecked = $('#user'+val1).is(":checked");
        if(isChecked==false){
            // console.log('nochecked');
            var result = confirm("คุณต้องการเปิดการใช้งานของ   "+val2+'   '+val3+"   ใช่หรือไม่?");
                if (result) {
                    $.ajax({
                        url: "{{url('changestatususer')}}/1/" + encodeURIComponent(val1),
                        type: 'GET',
                        dataType: 'HTML',
                        success: function(data) {
                            alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }else{
                    document.getElementById('user'+val1).checked = false;
                }
        }else{
            // console.log('checked');
            var result = confirm("คุณต้องการปิดการใช้งานของ   "+val2+'   '+val3+"   ใช่หรือไม่?");
            if (result) {
                    $.ajax({
                        url: "{{url('changestatususer')}}/2/" + encodeURIComponent(val1),
                        type: 'GET',
                        dataType: 'HTML',
                        success: function(data) {
                            alert('บันทึกข้อมูลเรียบร้อยแล้ว');
                            window.location.reload();
                        }
                    });
                }else{
                    document.getElementById('user'+val1).checked = true;
                }

        }

    }
    
    // $('#authority1').change(function() {
    function testdata(x,chk){
        // console.log(chk);
        $.ajax({
            url: "{{url('passdata')}}/" + encodeURIComponent(x.value)+'/'+chk,
            type: 'GET',
            dataType: 'HTML',
            async: true,
       
            // success: function(data) {
            //     alert('ลบข้อมูลเรียบร้อยแล้ว');
            //     $("#datacheck").load(location.href + " #datacheck");
            // }
        });
    }
    // });
        
</script>
</html>
@stop
