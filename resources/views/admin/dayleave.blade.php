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
                                                <div class="col-md-3">
                                                    <label for="exampleFormControlSelect1">ปีงบประมาณ</label>
                                                    <select class="form-control" id="year" name="year" >
                                                        <option value="">กรุณาเลือก</option>
                                                        <option value="{{$year}}">{{$year}}</option>
                                                        <option value="{{$year+1}}">{{$year+1}}</option> 
                                                    </select><br>
                                                </div>
                                                <div class="col-md-3">
                                                            
                                                    <label for="exampleFormControlSelect1">ประเภทบุคลากร</label>
                                                        <select class="form-control" id="perid" name="perid">
                                                            <option value="">กรุณาเลือก</option>
                                                            @foreach($personal as $personal)
                                                                <option value="{{$personal->PERTYPE_ID}}">{{$personal->PERTYPE_NAME}}</option>
                                                            @endforeach 
                                                        </select><br><br>
                                                </div>

                                                <div class="col-md-2">

                                                    <button class="btn btn-primary" type="button" style="margin-top: 27px" onclick="search();">ค้นหา</button>
                                                </div>
                                            </div> 
                                        </div>
                                    
                                        <div class="card-block" id="divold" style="display:none">
                                            {{-- <hr style="background-color: red">  --}}
                                            {{-- <br> --}}
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
                                                <a href="{{route('dayleave')}}" class="btn btn-danger" type="button" style="margin-left: 15%;">ยกเลิก</a>
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
    function btnedit(type){

        if(type==1){
            $('.sicktext').css("display", "none");
            $('.sickinput').css("display", "");
            $('#sickedit').css("display", "none");
            $('#sickcancel').css("display", "");
            


        }else if(type==2 ){
            $('.vacatext').css("display", "none");
            $('.vacainput').css("display", "");
            $('#vacaedit').css("display", "none");
            $('#vacacancel').css("display", "");
            

        }else if(type==3 ){
            $('.babytext').css("display", "none");
            $('.babyinput').css("display", "");
            $('#babyedit').css("display", "none");
            $('#babycancel').css("display", "");
            

        }else if(type==4 ){
            $('.mattext').css("display", "none");
            $('.matinput').css("display", "");
            $('#matedit').css("display", "none");
            $('#matcancel').css("display", "");

    

        }else if(type==5 ){
            $('.orditext').css("display", "none");
            $('.ordiinput').css("display", "");
            $('#ordiedit').css("display", "none");
            $('#ordicancel').css("display", "");
        }
        
    }

    function btncancle(type){
        if(type==1){
            $('.sicktext').css("display", "");
            $('.sickinput').css("display", "none");
            $('#sickedit').css("display", "");
            $('#sickcancel').css("display", "none");
            


        }else if(type==2 ){
            $('.vacatext').css("display", "");
            $('.vacainput').css("display", "none");
            $('#vacaedit').css("display", "");
            $('#vacacancel').css("display", "none");
            

        }else if(type==3 ){
            $('.babytext').css("display", "");
            $('.babyinput').css("display", "none");
            $('#babyedit').css("display", "");
            $('#babycancel').css("display", "none");
            

        }else if(type==4 ){
            $('.mattext').css("display", "");
            $('.matinput').css("display", "none");
            $('#matedit').css("display", "");
            $('#matcancel').css("display", "none");

    

        }else if(type==5 ){
            $('.orditext').css("display", "");
            $('.ordiinput').css("display", "none");
            $('#ordiedit').css("display", "");
            $('#ordicancel').css("display", "none");
        }
        
    }
</script>
</html>
@stop
