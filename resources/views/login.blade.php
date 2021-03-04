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


    <script>
        var err = "{{Session::get('error')}}";
        if(err){
            alert(err);
        }   
    </script>

</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img src="assets/images/kmutnb.png" height= "70" alt="Logo"><br>
                        <img src="assets/images/logo-kmutnb.png" height="70" alt="Logo">
                    </div>
                    <form action="{{url('/login')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" name="Username">
                        </div>
                        <div class="input-group mb-4">
                            <input type="password" class="form-control" placeholder="Password" name="Password">
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script><script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/pcoded.min.js"></script>

</body>
</html>
