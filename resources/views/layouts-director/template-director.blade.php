<!DOCTYPE html>
<html lang="en">

<head>
    <title>ระบบบริหารจัดการข้อมูลการมาปฏิบัติงานของบุคลากร สำนักคอมพิวเตอร์และเทคโนโลยีสารสนเทศ</title>
    @include('layouts-director.stylesheet-director')
    @yield('stylesheet-director')   
</head>

<body>
    @include('layouts-director.left-sidebar-director')
    @include('layouts-director.header-director')
    @yield('content-director')
    @include('layouts-director.scripts-director')
    @yield('scripts-director')

</body>

</html>
