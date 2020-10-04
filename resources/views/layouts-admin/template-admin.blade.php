<!DOCTYPE html>
<html lang="en">

<head>
    <title>ระบบบริหารจัดการข้อมูลการมาปฏิบัติงานของบุคลากร สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ</title>
    @include('layouts-admin.stylesheet-admin')
    @yield('stylesheet-admin')   
</head>

<body>
    @include('layouts-admin.left-sidebar-admin')
    @include('layouts-admin.header-admin')
    @yield('content-admin')
    @include('layouts-admin.scripts-admin')
    @yield('scripts-admin')

</body>

</html>
