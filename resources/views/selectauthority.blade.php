<!DOCTYPE html>
<html lang="en">

<head>
    <title>ระบบบริหารจัดการข้อมูลการมาปฏิบัติงานของบุคลากร สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content="CodedThemes" />

    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&display=swap" rel="stylesheet">

</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4" >
                        <div class="text-center">
                            <img src="assets/images/kmutnb.png" height= "70" alt="Logo"><br>
                            <img src="assets/images/logo-kmutnb.png" height="70" alt="Logo">
                        </div>
                    </div>
                    <div class="text-center">
                        <h6><b>กรุณาเลือกสิทธิ์ที่จะเข้าใช้งาน</b></h6><br>
                    </div>
                    <form action="{{url('selectlogin')}}" method="POST">
                        @csrf
                        <?php 
                            $sql = DB::Table('department')->where('DEP_ID',$userid)->first();
                            $sql1 = DB::Table('personal')->where('PERTYPE_ID',$userid)->first();
                        ?>
                        @if(!empty($admin))
                            <input type="radio" id="male" name="privilege" value="1">
                            <label for="radio-d-fill-3" class="cr">ตำแหน่ง : </label>
                            <label for="radio-d-fill-3" class="cr">ผู้ดูเเลระบบ</label>
                        <br>
                        @endif
                    
                        @if(!empty($director))
                            <input type="radio" id="female" name="privilege" value="2">
                            <label for="radio-d-fill-4" class="cr">ตำแหน่ง : </label>
                            <label for="radio-d-fill-4" class="cr">ผู้อำนวยการ</label>
                        <br>
                        @endif
                        
                        @if(!empty($manager))
                            <input type="radio" id="manager" name="privilege" value="3">
                            <label for="radio-d-fill-5" class="cr">ตำแหน่ง : </label>
                            <label for="radio-d-fill-5" class="cr">หัวหน้าฝ่าย</label>
                        <br>
                        @endif
                        @if($user==1)
                            <input type="radio" id="other" name="privilege" value="4">
                            <label for="radio-d-fill-6" class="cr">ตำแหน่ง : </label>
                            <label for="radio-d-fill-6" class="cr">บุคลากร</label><br>
                            <label for="radio-d-fill-6" class="cr">หน่วยงาน : {{$sql->DEP_NAME}}</label><br>
                            <label for="radio-d-fill-6" class="cr">ประเภทบุคลากร : {{$sql1->PERTYPE_NAME}}</label>
                        @endif
                        {{-- @if(!empty($data->ADMINAUTHORITY_ID))
                            <div class="form-group radio radio-primary d-inline">
                                <input type="radio" name="admin" id="radio-d-fill-3" value="1">
                                <label for="radio-d-fill-3" class="cr">ตำแหน่ง : </label>
                                <label for="radio-d-fill-3" class="cr">ผู้ดูเเลระบบ</label>
                            </div><br><br>
                        @endif
                        @if(!empty($data->DIRECTORAUTHORITY_ID))
                            <div class="form-group radio radio-primary d-inline">
                                <input type="radio" name="director" id="radio-d-fill-4" value="2">
                                <label for="radio-d-fill-4" class="cr">ตำแหน่ง : </label>
                                <label for="radio-d-fill-4" class="cr">ผู้อำนวยการ</label>
                            </div><br><br>
                        @endif
                        @if(!empty($data->MANAGERAUTHORITY_ID))
                            <div class="form-group radio radio-primary d-inline">
                                <input type="radio" name="manager" id="radio-d-fill-5" value="3">
                                <label for="radio-d-fill-5" class="cr">ตำแหน่ง : </label>
                                <label for="radio-d-fill-5" class="cr">หัวหน้าฝ่าย</label>
                            </div><br><br>
                        @endif
                        
                        <div class="form-group radio radio-primary d-inline">
                            <input type="radio" name="person" id="radio-d-fill-6" value="4" >
                            <label for="radio-d-fill-6" class="cr">ตำแหน่ง : </label>
                            <label for="radio-d-fill-6" class="cr">บุคลากร</label><br>
                            <label for="radio-d-fill-6" class="cr">หน่วยงาน : {{$sql->DEP_NAME}}</label><br>
                            <label for="radio-d-fill-6" class="cr">ประเภทบุคลากร : {{$sql1->PERTYPE_NAME}}</label>
                        </div><br><br> --}}
                        <div class="text-center">
                            <button class="btn btn-primary shadow-2 mb-4" type="submit">ตกลง</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script><script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script>
        $('#radio-d-fill-3').change(function(){
            document.getElementById("radio-d-fill-4").checked = false;
            document.getElementById("radio-d-fill-5").checked = false;
            document.getElementById("radio-d-fill-6").checked = false;
        });
        $('#radio-d-fill-4').change(function(){
            document.getElementById("radio-d-fill-3").checked = false;
            document.getElementById("radio-d-fill-5").checked = false;
            document.getElementById("radio-d-fill-6").checked = false;
        });
        $('#radio-d-fill-3').change(function(){
            document.getElementById("radio-d-fill-3").checked = false;
            document.getElementById("radio-d-fill-4").checked = false;
            document.getElementById("radio-d-fill-6").checked = false;
        });
        $('#radio-d-fill-6').change(function(){
            document.getElementById("radio-d-fill-3").checked = false;
            document.getElementById("radio-d-fill-4").checked = false;
            document.getElementById("radio-d-fill-5").checked = false;
        });

    </script>
</body>
</html>
