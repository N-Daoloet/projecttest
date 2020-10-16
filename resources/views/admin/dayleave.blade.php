@extends('layouts-admin.template-admin')
@section('content-admin')
<script>
    var A = "{{Session::get('success')}}";
    if(A){
        alert(A);
    }
</script>
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
                            <!-- [ Fixed Columns ] start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>กำหนดจำนวนวันลาในปีงบประมาณ</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-1"></div>
                                            <div class="col-xl-10">
                                                <?php 
                                                    $month = intval(date('m'));
                                                    // $year = intval(date("Y"))+543;
                                                    // $year = '2564';
                                                    if($month>=4&&$month<=9){
                                                        $x=2;
                                                    }else{
                                                        $x=1;
                                                    }
                                                ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr style="text-align: center"> 
                                                            <th>ประเภทการลา</th>
                                                            <th>จำนวนวันลาสูงสุดในแต่ละรอบปีงบประมาณ</th>
                                                            <th>รอบ</th> 
                                                            <th>ปีงบประมาณ</th> 
                                                            <th>การจัดการ</th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $item)
                                                            <form action="{{url('updatelimitabsent')}}" method="POST">
                                                                @csrf
                                                                <tr style="text-align: center">
                                                                    <td ><div style="margin-top: 7px">{{$item->ABSENTTYPE_NAME}}</div></td>
                                                                    <?php $sql = DB::Table('limitabsenttype')->where('ABSENTTYPE_ID',$item->ABSENTTYPE_ID)->where('LIMITABSENTTYPE_ROUND',$x)->first();?>
                                                                    <td>
                                                                        <div class="text-center" id="text{{$sql->LIMITABSENTTYPE_ID}}" style="display: ">
                                                                            {{$sql->LIMITABSENTTYPE_NUMBER}}&emsp;วัน 
                                                                            
                                                                        </div>
                                                                        <div class="text-center" id="input{{$sql->LIMITABSENTTYPE_ID}}" style="display:none ">
                                                                            <input type="number" class="form-control" name="number" value="{{$sql->LIMITABSENTTYPE_NUMBER}}" style="width: 100px;text-align:center;margin-left: 70px;">
                                                                        </div>
                                                                    </td>
                                                                    <td ><div style="margin-top: 7px">{{$sql->LIMITABSENTTYPE_ROUND}}</div>
                                                                        <input type="hidden" name="LIMITABSENTTYPE_ID" value="{{$sql->LIMITABSENTTYPE_ID}}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control-plaintext" name="year" value="{{$sql->LIMITABSENTTYPE_BUDGETYEAR}}" style="text-align: center;color:#888888" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center" id="buttonedit{{$sql->LIMITABSENTTYPE_ID}}" style="display: ">
                                                                            <button class="btn btn-outline-warning btn-sm" type="button"  onclick="btnedit({{$sql->LIMITABSENTTYPE_ID}});"><i class="feather icon-edit-2"></i>แก้ไข</button>
                                                                        </div>
                                                                        <div id="buttonsubmit{{$sql->LIMITABSENTTYPE_ID}}" style="display: none" class="form-inline">
                                                                            <button class="btn btn-outline-success" type="submit" >ยืนยัน</button>
                                                                            <button class="btn btn-outline-danger" type="button" onclick="btncancle({{$sql->LIMITABSENTTYPE_ID}});">ยกเลิก</button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </form>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                </div>
                            </div>
                            <!-- [ Fixed Columns ] end -->
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
    function btnedit(id){
        document.getElementById('buttonedit'+id).style.display = 'none';
        document.getElementById('text'+id).style.display = 'none';
        document.getElementById('buttonsubmit'+id).style.display = '';
        document.getElementById('input'+id).style.display = '';
    }

    function btncancle(id){
        document.getElementById('buttonedit'+id).style.display = '';
        document.getElementById('text'+id).style.display = '';
        document.getElementById('buttonsubmit'+id).style.display = 'none';
        document.getElementById('input'+id).style.display = 'none';
    }
</script>
</html>
@stop
