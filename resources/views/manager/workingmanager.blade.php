@extends('layouts-manager.template-manager')
@section('content-manager')
<!-- [ Main Content ] start -->
<style>
    .bd-example-modal-lg .modal-dialog{
    display: table;
    position: relative;
    margin: 0 auto;
    top: calc(50% - 24px);
  }
  
  .bd-example-modal-lg .modal-dialog .modal-content{
    background-color: transparent;
    border: none;
  }
</style>
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
                                        <h5>ตรวจสอบการมาปฏิบัติงาน</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">ประเภทข้อมูล</label>
                                                    <select  class="form-control" style="background-color:#ffffff" id="typedata">
                                                        <option value="">กรุณาเลือก</option>
                                                        <option value="1">ข้อมูลบุคคล</option>
                                                        <option value="2">{{$data->DEP_NAME}}</option>
                                                        
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

<div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1" id="waitreport">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <div class="spinner-border text-dark"  role="status">
                <span class="sr-only">Loading...</span>
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
            var typedata = document.getElementById('typedata').value;
            var round = document.getElementById('round').value;
            if(typedata =='' || round =='' || year==''){
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            }else{
                $('#waitreport').modal({
                            backdrop: 'static',
                            keyboard: false, 
                            show: true
                        });

                $.ajax({
                url: '{{ url("searchworkeport")}}',
                type: 'GET',
                dataType: 'HTML',
                data : {'typedata':typedata,'round':round,'year':year},
                success: function(data) {
                    if(data==1){
                        $('#waitreport').modal('hide');

                        alert('ไม่พบข้อมูล');

                    }else{
                        $('#datauser').html(data);
                        $('#responsive-table').DataTable();
                        $('#waitreport').modal('hide');

                    }
                  
                }
            });
            }
        }


</script>
</body>
</html>
@stop
