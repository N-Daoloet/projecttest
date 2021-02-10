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
                                        <div class="row" id="groupbtn" style="display: none" >
                                            <div class="col-8"></div>
                                            <div class="col-4 form-inline">
                                                <button class="btn btn-danger" type="button" style="margin-left: 15%;" onclick="btncancleall();">ยกเลิก</button>
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
        if(year=='') {
            alert('กรุณาเลือกปีงบประมาณ');
        }else if(perid==''){
            alert('กรุณาเลือกประเภทบุคลากร');
            
        }else{
            $.ajax({
                url: '{{ url("searchleavesick")}}',
                type: 'GET',
                dataType: 'HTML',
                data : {'year':year,'perid':perid},
                success: function(data) {
                    $('#datauser').html(data);
                    document.getElementById('divold').style.display = '';
                    document.getElementById('groupbtn').style.display = '';
                }
            });
        }
        
    }
    function btnedit(type,id){

        if(type==1 && id==1){
            document.getElementById('sickedit1').style.display = 'none';
            document.getElementById('sicktext1').style.display = 'none';
            document.getElementById('sicktext2').style.display = 'none';
            document.getElementById('sicksubmit1').style.display = '';
            document.getElementById('sickinput1').style.display = '';
            document.getElementById('sickinput2').style.display = '';
            document.getElementById('sicktxtinput1').disabled = false;
            document.getElementById('sicktxtinput2').disabled = false;
            $('#sicktxtinput1').attr('required','required');
            $('#sicktxtinput2').attr('required','required');


        }else if(type==1 && id==2){
            document.getElementById('sickedit2').style.display = 'none';
            document.getElementById('sicktext3').style.display = 'none';
            document.getElementById('sicktext4').style.display = 'none';
            document.getElementById('sicksubmit2').style.display = '';
            document.getElementById('sickinput3').style.display = '';
            document.getElementById('sickinput4').style.display = '';
            document.getElementById('sicktxtinput3').disabled = false;
            document.getElementById('sicktxtinput4').disabled = false;
            $('#sicktxtinput3').prop('required','required');
            $('#sicktxtinput4').prop('required','required');

        }else if(type==2 && id==1){
            document.getElementById('vacaedit1').style.display = 'none';
            document.getElementById('vacatext1').style.display = 'none';
            document.getElementById('vacatext2').style.display = 'none';
            document.getElementById('vacasubmit1').style.display = '';
            document.getElementById('vacainput1').style.display = '';
            document.getElementById('vacainput2').style.display = '';
            document.getElementById('vacatxtinput1').disabled = false;
            document.getElementById('vacatxtinput2').disabled = false;
            $('#vacatxtinput1').prop('required','required');
            $('#vacatxtinput2').prop('required','required');

        }else if(type==2 && id==2){
            document.getElementById('vacaedit2').style.display = 'none';
            document.getElementById('vacatext3').style.display = 'none';
            document.getElementById('vacatext4').style.display = 'none';
            document.getElementById('vacasubmit2').style.display = '';
            document.getElementById('vacainput3').style.display = '';
            document.getElementById('vacainput4').style.display = '';
            document.getElementById('vacatxtinput3').disabled = false;
            document.getElementById('vacatxtinput4').disabled = false;
            $('#vacatxtinput3').prop('required','required');
            $('#vacatxtinput4').prop('required','required');

        }else if(type==3 && id==1){
            document.getElementById('priedit1').style.display = 'none';
            document.getElementById('pritext1').style.display = 'none';
            document.getElementById('pritext2').style.display = 'none';
            document.getElementById('prisubmit1').style.display = '';
            document.getElementById('priinput1').style.display = '';
            document.getElementById('priinput2').style.display = '';
            document.getElementById('pritxtinput1').disabled = false;
            document.getElementById('pritxtinput2').disabled = false;
            $('#pritxtinput1').prop('required','required');
            $('#pritxtinput2').prop('required','required');

        }else if(type==3 && id==2){
            document.getElementById('priedit'+id).style.display = 'none';
            document.getElementById('pritext3').style.display = 'none';
            document.getElementById('pritext4').style.display = 'none';
            document.getElementById('prisubmit'+id).style.display = '';
            document.getElementById('priinput3').style.display = '';
            document.getElementById('priinput4').style.display = '';
            document.getElementById('pritxtinput3').disabled = false;
            document.getElementById('pritxtinput4').disabled = false;
            $('#pritxtinput3').prop('required','required');
            $('#pritxtinput4').prop('required','required');

        }else if(type==4 && id==1){
            document.getElementById('babyedit1').style.display = 'none';
            document.getElementById('babytext1').style.display = 'none';
            document.getElementById('babytext2').style.display = 'none';
            document.getElementById('babysubmit1').style.display = '';
            document.getElementById('babyinput1').style.display = '';
            document.getElementById('babyinput2').style.display = '';
            document.getElementById('babytxtinput1').disabled = false;
            document.getElementById('babytxtinput2').disabled = false;
            $('#babytxtinput1').prop('required','required');
            $('#babytxtinput2').prop('required','required');

        }else if(type==4 && id==2){
            document.getElementById('babyedit2').style.display = 'none';
            document.getElementById('babytext3').style.display = 'none';
            document.getElementById('babytext4').style.display = 'none';
            document.getElementById('babysubmit2').style.display = '';
            document.getElementById('babyinput3').style.display = '';
            document.getElementById('babyinput4').style.display = '';
            document.getElementById('babytxtinput3').disabled = false;
            document.getElementById('babytxtinput4').disabled = false;
            $('#babytxtinput3').prop('required','required');
            $('#babytxtinput4').prop('required','required');

        }else if(type==5 && id==1){
            document.getElementById('matedit1').style.display = 'none';
            document.getElementById('mattext1').style.display = 'none';
            document.getElementById('mattext2').style.display = 'none';
            document.getElementById('matsubmit1').style.display = '';
            document.getElementById('matinput1').style.display = '';
            document.getElementById('matinput2').style.display = '';
            document.getElementById('mattxtinput1').disabled = false;
            document.getElementById('mattxtinput2').disabled = false;
            $('#mattxtinput1').prop('required','required');
            $('#mattxtinput2').prop('required','required');

        }else if(type==5 && id==2){
            document.getElementById('matedit2').style.display = 'none';
            document.getElementById('mattext3').style.display = 'none';
            document.getElementById('mattext4').style.display = 'none';
            document.getElementById('matsubmit2').style.display = '';
            document.getElementById('matinput3').style.display = '';
            document.getElementById('matinput4').style.display = '';
            document.getElementById('mattxtinput3').disabled = false;
            document.getElementById('mattxtinput4').disabled = false;
            $('#mattxtinput3').prop('required','required');
            $('#mattxtinput4').prop('required','required');

        }else if(type==6 && id==1){
            document.getElementById('ordiedit1').style.display = 'none';
            document.getElementById('orditext1').style.display = 'none';
            document.getElementById('orditext2').style.display = 'none';
            document.getElementById('ordisubmit1').style.display = '';
            document.getElementById('ordiinput1').style.display = '';
            document.getElementById('ordiinput2').style.display = '';
            document.getElementById('orditxtinput1').disabled = false;
            document.getElementById('orditxtinput2').disabled = false;
            $('#orditxtinput1').prop('required','required');
            $('#orditxtinput2').prop('required','required');

        }else if(type==6 && id==2){
            document.getElementById('ordiedit2').style.display = 'none';
            document.getElementById('orditext3').style.display = 'none';
            document.getElementById('orditext4').style.display = 'none';
            document.getElementById('ordisubmit2').style.display = '';
            document.getElementById('ordiinput3').style.display = '';
            document.getElementById('ordiinput4').style.display = '';
            document.getElementById('orditxtinput3').disabled = false;
            document.getElementById('orditxtinput4').disabled = false;
            $('#orditxtinput3').prop('required','required');
            $('#orditxtinput4').prop('required','required');

        }
        
    }

    function btncancle(type,id){
        if(type==1 && id==1){
            document.getElementById('sickedit'+id).style.display = '';
            document.getElementById('sicktext1').style.display = '';
            document.getElementById('sicktext2').style.display = '';
            document.getElementById('sicksubmit'+id).style.display = 'none';
            document.getElementById('sickinput1').style.display = 'none';
            document.getElementById('sickinput2').style.display = 'none';
            document.getElementById('sicktxtinput1').disabled = true;
            document.getElementById('sicktxtinput2').disabled = true;

        }else if(type==1 && id==2){
            document.getElementById('sickedit'+id).style.display = '';
            document.getElementById('sicktext3').style.display = '';
            document.getElementById('sicktext4').style.display = '';
            document.getElementById('sicksubmit'+id).style.display = 'none';
            document.getElementById('sickinput3').style.display = 'none';
            document.getElementById('sickinput4').style.display = 'none';
            document.getElementById('sicktxtinput3').disabled = true;
            document.getElementById('sicktxtinput4').disabled = true;

        }else if(type==2 && id==1){
            document.getElementById('vacaedit'+id).style.display = '';
            document.getElementById('vacatext1').style.display = '';
            document.getElementById('vacatext2').style.display = '';
            document.getElementById('vacasubmit'+id).style.display = 'none';
            document.getElementById('vacainput1').style.display = 'none';
            document.getElementById('vacainput2').style.display = 'none';
            document.getElementById('vacatxtinput1').disabled = true;
            document.getElementById('vacatxtinput2').disabled = true;

        }else if(type==2 && id==2){
            document.getElementById('vacaedit'+id).style.display = '';
            document.getElementById('vacatext3').style.display = '';
            document.getElementById('vacatext4').style.display = '';
            document.getElementById('vacasubmit'+id).style.display = 'none';
            document.getElementById('vacainput3').style.display = 'none';
            document.getElementById('vacainput4').style.display = 'none';
            document.getElementById('vacatxtinput3').disabled = true;
            document.getElementById('vacatxtinput4').disabled = true;

        }else if(type==3 && id==1){
            document.getElementById('priedit'+id).style.display = '';
            document.getElementById('pritext1').style.display = '';
            document.getElementById('pritext2').style.display = '';
            document.getElementById('prisubmit'+id).style.display = 'none';
            document.getElementById('priinput1').style.display = 'none';
            document.getElementById('priinput2').style.display = 'none';
            document.getElementById('pritxtinput1').disabled = true;
            document.getElementById('pritxtinput2').disabled = true;

        }else if(type==3 && id==2){
            document.getElementById('priedit'+id).style.display = '';
            document.getElementById('pritext3').style.display = '';
            document.getElementById('pritext4').style.display = '';
            document.getElementById('prisubmit'+id).style.display = 'none';
            document.getElementById('priinput3').style.display = 'none';
            document.getElementById('priinput4').style.display = 'none';
            document.getElementById('pritxtinput3').disabled = true;
            document.getElementById('pritxtinput4').disabled = true;

        }else if(type==4 && id==1){
            document.getElementById('babyedit'+id).style.display = '';
            document.getElementById('babytext1').style.display = '';
            document.getElementById('babytext2').style.display = '';
            document.getElementById('babysubmit'+id).style.display = 'none';
            document.getElementById('babyinput1').style.display = 'none';
            document.getElementById('babyinput2').style.display = 'none';
            document.getElementById('babytxtinput1').disabled = true;
            document.getElementById('babytxtinput2').disabled = true;

        }else if(type==4 && id==2){
            document.getElementById('babyedit'+id).style.display = '';
            document.getElementById('babytext3').style.display = '';
            document.getElementById('babytext4').style.display = '';
            document.getElementById('babysubmit'+id).style.display = 'none';
            document.getElementById('babyinput3').style.display = 'none';
            document.getElementById('babyinput4').style.display = 'none';
            document.getElementById('babytxtinput3').disabled = true;
            document.getElementById('babytxtinput4').disabled = true;

        }else if(type==5 && id==1){
            document.getElementById('matedit'+id).style.display = '';
            document.getElementById('mattext1').style.display = '';
            document.getElementById('mattext2').style.display = '';
            document.getElementById('matsubmit'+id).style.display = 'none';
            document.getElementById('matinput1').style.display = 'none';
            document.getElementById('matinput2').style.display = 'none';
            document.getElementById('mattxtinput1').disabled = true;
            document.getElementById('mattxtinput2').disabled = true;

        }else if(type==5 && id==2){
            document.getElementById('matedit'+id).style.display = '';
            document.getElementById('mattext3').style.display = '';
            document.getElementById('mattext4').style.display = '';
            document.getElementById('matsubmit'+id).style.display = 'none';
            document.getElementById('matinput3').style.display = 'none';
            document.getElementById('matinput4').style.display = 'none';
            document.getElementById('mattxtinput3').disabled = true;
            document.getElementById('mattxtinput4').disabled = true;

        }else if(type==6 && id==1){
            document.getElementById('ordiedit'+id).style.display = '';
            document.getElementById('orditext1').style.display = '';
            document.getElementById('orditext2').style.display = '';
            document.getElementById('ordisubmit'+id).style.display = 'none';
            document.getElementById('ordiinput1').style.display = 'none';
            document.getElementById('ordiinput2').style.display = 'none';
            document.getElementById('orditxtinput1').disabled = true;
            document.getElementById('orditxtinput2').disabled = true;

        }else if(type==6 && id==2){
            document.getElementById('ordiedit'+id).style.display = '';
            document.getElementById('orditext3').style.display = '';
            document.getElementById('orditext4').style.display = '';
            document.getElementById('ordisubmit'+id).style.display = 'none';
            document.getElementById('ordiinput3').style.display = 'none';
            document.getElementById('ordiinput4').style.display = 'none';
            document.getElementById('orditxtinput3').disabled = true;
            document.getElementById('orditxtinput4').disabled = true;

        }
        
    }
</script>
</html>
@stop
