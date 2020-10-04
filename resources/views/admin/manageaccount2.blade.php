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
                                            <tr>
                                                <td rowspan="2" align="center"><br>ลำดับที่</td>
                                                <td rowspan="2" align="center"><br>บัญชีผู้ใช้</td>
                                                <td rowspan="2" align="center"><br>ชื่อ - นามสกุล</td>
                                                <td colspan="4" align="center">สิทธิ์การใช้งาน</td>
                                                <td rowspan="2" align="center"><br>Action</td>
                                            </tr> 
                                            <tr>
                                                <td align="center">บุคลากร</td>
                                                <td align="center">หัวหน้าฝ่าย</td>
                                                <td align="center">ผู้บริหาร</td>
                                                <td align="center">ผู้ดูแลระบบ</td>
                                            </tr>
                                            <?php $i=1; ?> 
                                            @foreach($sql as $key => $sqls)
                                                <tr>
                                                    <td align="center">{{$i}}</td>
                                                    <td align="center">{{$sqls->USER_USERNAME}}</td>
                                                    <td align="center">{{$sqls->USER_FNAME}} {{$sqls->USER_LNAME}}</td>
                                                    <td align="center"><input type="checkbox" disabled Checked></td>
                                                    <div class="checkbox-wrapper">
                                                        <?php $data1 = DB::table('managerauthority')->where('USER_ID',$sqls->USER_ID)->first();?>
                                                        <?php $data2 = DB::table('directorauthority')->where('USER_ID',$sqls->USER_ID)->first();?>
                                                        <?php $data3 = DB::table('adminauthority')->where('USER_ID',$sqls->USER_ID)->first();?>
                                                            
                                                        @if(!empty($data1))
                                                            <td align="center"><input type="checkbox" onchange="testdata(this,1);" id="authority1" name="authority1[]" value="{{$sqls->USER_ID}}" checked ></td>
                                                        @else
                                                            <td align="center"><input type="checkbox" name="authority1[]" value="{{$sqls->USER_ID}}" ></td>
                                                        @endif

                                                        @if(!empty($data2))
                                                            <td align="center"><input type="checkbox" onchange="testdata(this,2)"; id="authority2" name="authority2[]" value="{{$sqls->USER_ID}}" checked></td>
                                                        @else
                                                            <td align="center"><input type="checkbox" name="authority2[]" value="{{$sqls->USER_ID}}" ></td>
                                                        @endif

                                                        @if(!empty($data3))
                                                            <td align="center"><input type="checkbox" onchange="testdata(this,3)"; id="authority3" name="authority3[]" value="{{$sqls->USER_ID}}" checked></td>
                                                        @else
                                                            <td align="center"><input type="checkbox" name="authority3[]" value="{{$sqls->USER_ID}}" ></td>
                                                        @endif
                                                    </div>
                                                    <td align="center">&emsp;
                                                        <a href="/delete/{{$sqls->USER_ID}}"><button type="button" class="btn btn-outline-danger btn-sm"><i class="feather feather icon-trash-2"></i>ลบผู้ใช้</button></a>
                                                    </td>
                                                </tr>
                                            <?php $i++ ?>
                                            @endforeach
                                          </table>
                                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
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
