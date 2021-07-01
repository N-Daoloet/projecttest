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
                                        <h5>รายงานผลการลา</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">ฝ่าย</label>
                                                    <select  class="form-control" style="background-color:#ffffff" id="department">
                                                        <option value="">กรุณาเลือก</option>
                                                        @foreach ($data as $item)
                                                            <option value="{{$item->DEP_ID }}">{{$item->DEP_NAME}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                               
                                                <label for="exampleFormControlSelect1">ตั้งแต่</label>
                                                <select  class="form-control" style="background-color:#ffffff" id="round">
                                                    <option value="">กรุณาเลือก</option>
                                                    <option value="1">รอบที่ 1 (ตุลาคม-มีนาคม)</option>
                                                    <option value="2">รอบที่ 2 (เมษายน-กันยายน)</option>
                                                   
                                                </select>
                                            </div>

                                            <?php 
                                                $year = intval(date("Y"))+543;
                                               
                                            ?>
                                            <div class="col-md-2">
                                                <label for="exampleFormControlSelect1">ปีงบประมาณ</label>
                                                <select class="form-control" id="year" name="year" >
                                                    <option value="">กรุณาเลือก</option>
                                                    <option value="{{$year}}">{{$year}}</option>
                                                    <option value="{{$year+1}}">{{$year+1}}</option> 
                                                </select><br>
                                            </div>
                                           
                                            <div class="col-md-2">
                                                <label class="form-label">&nbsp;&nbsp;</label><br>
                                                <button class="btn btn-primary" type="button" onclick="search();">ค้นหา</button>
                                            </div>
                                            
                                        </div> 
                                    </div>


                                    <div class="card-block">
                                        <div class="table-responsive" id="datauser">
                                        </div>
                                    </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#responsive-table').DataTable();
    } );

    function search (){
            var year = document.getElementById('year').value;
            var department = document.getElementById('department').value;
            var round = document.getElementById('round').value;
            if(department =='' || round =='' || year==''){
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            }else{
                $.ajax({
                url: '{{ url("searchleavereport")}}',
                type: 'GET',
                dataType: 'HTML',
                data : {'department':department,'round':round,'year':year},
                success: function(data) {
                    if(data==1){
                        alert('ไม่พบข้อมูล');

                    }else{
                        $('#datauser').html(data);
                        $('#responsive-table').DataTable();

                    }
                  
                }
            });
            }
        }


</script>
</body>
</html>
@stop
