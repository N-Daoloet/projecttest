<!DOCTYPE html>
<html lang="en">

<head>
    <title>ระบบบริหารจัดการข้อมูลการมาปฏิบัติงานของบุคลากร สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ</title>
    @include('layouts-manager.stylesheet-manager')
    @yield('stylesheet-manager')   
</head>

<body>
    @include('layouts-manager.left-sidebar-manager')
    @include('layouts-manager.header-manager')
    @yield('content-manager')
    @include('layouts-manager.scripts-manager')
    @yield('scripts-manager')

</body>

</html>
