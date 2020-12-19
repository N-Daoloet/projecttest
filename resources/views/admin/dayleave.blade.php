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
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-1"></div>
                                            <div class="col-md-6">
                                                <form action="{{route('post')}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form">
                                                        <label for="exampleFormControlSelect1">ปีงบประมาณ</label>
                                                        <select class="form-control" id="exampleFormControlSelect1" name="department">
                                                            <option value="">กรุณาเลือก</option>
                                                            <option value="1">2563</option>
                                                            <option value="2">2564</option> 
                                                        </select><br>
                                                        <label for="exampleFormControlSelect1">รอบ</label>
                                                        <select class="form-control" id="exampleFormControlSelect1" name="person">
                                                            <option value="">กรุณาเลือก</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                        </select><br>
                                                        <label for="exampleFormControlSelect1">ประเภทบุคลากร</label>
                                                            <select class="form-control" id="exampleFormControlSelect1" name="perid">
                                                                <option value="">กรุณาเลือก</option>
                                                                <option value="">...</option>
                                                                {{-- @foreach($per as $personal)
                                                                    <option value="{{$personal->PERTYPE_ID}}">{{$personal->PERTYPE_NAME}}</option>
                                                                @endforeach --}}
                                                            </select><br><br>
                                                        <button class="btn btn-primary" type="submit">ค้นหา</button>
                                                        {{-- <a href="{{route ('manageaccount')}}" class="btn btn-secondary" type="back">ย้อนกลับ</a>   --}}
                                                    </div>
                                                </form>

                                            </div>
                                            
                                        </div> 
                                    </div>
                                    <hr style="background-color: red">
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
                                                    <tr style="text-align: center"> 
                                                        <td>ประเภทการลา</td>
                                                        <td>จำนวนครั้งสูงสุด</td>
                                                        <td>จำนวนวันลาสูงสุด</td>
                                                        <td>การจัดการ</td> 
                                                    </tr>
                                                    <tbody>
                                                        @foreach ($data as $item)
                                                            <form action="{{url('updatelimitabsent')}}" method="POST">
                                                                @csrf
                                                                <tr style="text-align: center">
                                                                    <td ><div style="margin-top: 7px">{{$item->ABSENTTYPE_NAME}}</div></td>
                                                                    <?php $sql = DB::Table('limitabsenttype')->where('ABSENTTYPE_ID',$item->ABSENTTYPE_ID)->where('LIMITABSENTTYPE_ROUND',$x)->first();?>
                                                                    <td>
                                                                        <div class="text-center" id="text{{$sql->LIMITABSENTTYPE_ID}}" style="display: ">
                                                                            {{$sql->LIMITABSENTTYPE_NUMBER}} 
                                                                            
                                                                        </div>
                                                                        <div class="text-center" id="input{{$sql->LIMITABSENTTYPE_ID}}" style="display:none ">
                                                                            <input type="number" class="form-control" name="number" value="{{$sql->LIMITABSENTTYPE_NUMBER}}" style="width: 100px;text-align:center;margin-left: 70px;">
                                                                        </div>
                                                                    </td>
                                                                    <td ><div style="margin-top: 7px">{{$sql->LIMITABSENTTYPE_ROUND}}</div>
                                                                        <input type="hidden" name="LIMITABSENTTYPE_ID" value="{{$sql->LIMITABSENTTYPE_ID}}">   
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
