<!DOCTYPE html>
<html lang="en">

<head>
    <title>ระบบบริหารจัดการข้อมูลการมาปฏิบัติงานของบุคลากร สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ</title>
    @include('layouts-user.stylesheet-user')
    @yield('stylesheet-user')   
</head>

<body>
    @include('layouts-user.left-sidebar-user')
    @include('layouts-user.header-user')
    @yield('content-user')
    @include('layouts-user.scripts-user')
    @yield('scripts-user')

</body>

</html>
