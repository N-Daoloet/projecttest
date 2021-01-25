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
                                <form action="{{url('updatelimitabsent')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="leaveid" value="{{$leaveid}}">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>กำหนดจำนวนวันลาในปีงบประมาณ</h5>
                                        </div>
                                        <?php 
                                            $month = intval(date('m'));
                                            $year = intval(date("Y"))+543;
                                            // $year = '2564';
                                            if($month>=4&&$month<=9){
                                                $x=2;
                                            }else{
                                                $x=1;
                                            }
                                        ?>
                                        <div class="card-body">
                                            <div class="row"> 
                                                <div class="col-md-1"></div>
                                                <div class="col-md-6">
                                                        <div class="form">
                                                            <label for="exampleFormControlSelect1">ปีงบประมาณ</label>
                                                            <select class="form-control" id="year" name="year" >
                                                                <option value="">กรุณาเลือก</option>
                                                                <option value="{{$year}}">{{$year}}</option>
                                                                <option value="{{$year+1}}">{{$year+1}}</option> 
                                                            </select><br>
                                                            
                                                            <label for="exampleFormControlSelect1">ประเภทบุคลากร</label>
                                                                <select class="form-control" id="perid" name="perid">
                                                                    <option value="">กรุณาเลือก</option>
                                                                    @foreach($personal as $personal)
                                                                        <option value="{{$personal->PERTYPE_ID}}">{{$personal->PERTYPE_NAME}}</option>
                                                                    @endforeach 
                                                                </select><br><br>
                                                            <button class="btn btn-primary" type="button" onclick="search();">ค้นหา</button>
                                                        </div>
                                                </div>
                                            </div> 
                                        </div>
                                    
                                        <div class="card-block" id="divold" style="display:none">
                                            <hr style="background-color: red"> 
                                            <br>
                                            <div class="row">
                                                <div class="col-1"></div>
                                                <div class="col-10" id="datauser" >
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row" id="btnsave"  style="display:none ">
                                            <div class="col-8"></div>
                                            <div class="col-4 form-inline">
                                                <button href="#" class="btn btn-danger" type="button" style="margin-left: 15%;" onclick="btncancle(3);">ยกเลิก</button>
                                                <button class="btn btn-success" type="submit" >ยืนยัน</button>

                                            </div>
                                            
                                        </div>
                                        <br><br>
                                    </div>

                                </form>
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
    function search(){
        var year = document.getElementById('year').value;
        var perid = document.getElementById('perid').value;
        var leaveid = "{{$leaveid}}";
        if(year=='') {
            alert('กรุณาเลือกปีงบประมาณ');
        }else if(perid==''){
            alert('กรุณาเลือกประเภทบุคลากร');
            
        }else{
            $.ajax({
                url: '{{ url("searchleavesick")}}',
                type: 'GET',
                dataType: 'HTML',
                data : {'year':year,'perid':perid,'leaveid':leaveid},
                success: function(data) {
                    document.getElementById('divold').style.display = '';
                    $('#datauser').html(data);
                }
            });
        }
        
    }
    function btnedit(id){

        if(id==1){
            document.getElementById('buttonedit'+id).style.display = 'none';
            document.getElementById('text1').style.display = 'none';
            document.getElementById('text2').style.display = 'none';
            document.getElementById('buttonsubmit'+id).style.display = '';
            document.getElementById('input1').style.display = '';
            document.getElementById('input2').style.display = '';
            document.getElementById('txtinput1').disabled = false;
            document.getElementById('txtinput2').disabled = false;
            $('#txtinput1').attr('required','required');
            $('#txtinput2').attr('required','required');
            document.getElementById('btnsave').style.display = '';


        }else{
            document.getElementById('buttonedit'+id).style.display = 'none';
            document.getElementById('text3').style.display = 'none';
            document.getElementById('text4').style.display = 'none';
            document.getElementById('buttonsubmit'+id).style.display = '';
            document.getElementById('input3').style.display = '';
            document.getElementById('input4').style.display = '';
            document.getElementById('txtinput3').disabled = false;
            document.getElementById('txtinput4').disabled = false;
            $('#txtinput3').prop('required','required');
            $('#txtinput4').prop('required','required');
            document.getElementById('btnsave').style.display = '';

        }
        
    }

    function btncancle(id){
        if(id==1){
            document.getElementById('buttonedit'+id).style.display = '';
            document.getElementById('text1').style.display = '';
            document.getElementById('text2').style.display = '';
            document.getElementById('buttonsubmit'+id).style.display = 'none';
            document.getElementById('input1').style.display = 'none';
            document.getElementById('input2').style.display = 'none';
            document.getElementById('txtinput1').disabled = true;
            document.getElementById('txtinput2').disabled = true;
            

        }else if(id==2){
            document.getElementById('buttonedit'+id).style.display = '';
            document.getElementById('text3').style.display = '';
            document.getElementById('text4').style.display = '';
            document.getElementById('buttonsubmit'+id).style.display = 'none';
            document.getElementById('input3').style.display = 'none';
            document.getElementById('input4').style.display = 'none';
            document.getElementById('txtinput3').disabled = true;
            document.getElementById('txtinput4').disabled = true;
            


        }else{
            document.getElementById('buttonedit1').style.display = '';
            document.getElementById('buttonedit2').style.display = '';
            document.getElementById('text1').style.display = '';
            document.getElementById('text2').style.display = '';
            document.getElementById('buttonsubmit1').style.display = 'none';
            document.getElementById('buttonsubmit2').style.display = 'none';
            document.getElementById('input1').style.display = 'none';
            document.getElementById('input2').style.display = 'none';
            document.getElementById('txtinput1').disabled = true;
            document.getElementById('txtinput2').disabled = true;
            document.getElementById('text3').style.display = '';
            document.getElementById('text4').style.display = '';
            document.getElementById('input3').style.display = 'none';
            document.getElementById('input4').style.display = 'none';
            document.getElementById('txtinput3').disabled = true;
            document.getElementById('txtinput4').disabled = true;
        }
        
    }
</script>
</html>
@stop
