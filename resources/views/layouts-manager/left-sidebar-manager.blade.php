<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="#" class="b-brand">
                <span class="b-title-center">
                    <br><br>
                    <img src="assets/images/kmutnb.png" height= "70" alt="Logo"><br>
                    <img src="assets/images/text-logo.png" height= "42" alt="Logo">
                </span>
            </a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <br><br><br>
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item {{request()->routeIS('indexmanager') ? 'bg-c': ''}}"> 
                    <a href="{{route ('indexmanager')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">หน้าหลัก</span></a>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->routeIS('sickleavemanager','vacationleavemanager','privateleavemanager','maternityleavemanager','babymanager','ordinationleavemanager') ? 'bg-c': ''}}">
                    <a class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">ยื่นใบลา</span></a>
                    <ul class="pcoded-submenu">
                        <li class="{{request()->routeIS('sickleavemanager') ? 'bg-c': ''}}"><a href="{{route ('sickleavemanager')}}" class="">ลาป่วย</a></li>
                        <li class="{{request()->routeIS('vacationleavemanager') ? 'bg-c': ''}}"><a href="{{route ('vacationleavemanager')}}" class="">ลาพักผ่อน</a></li>
                        <li class="{{request()->routeIS('privateleavemanager') ? 'bg-c': ''}}"><a href="{{route ('privateleavemanager')}}" class="">ลากิจส่วนตัว</a></li>
                        <li class="{{request()->routeIS('maternityleavemanager') ? 'bg-c': ''}}"><a href="{{route ('maternityleavemanager')}}" class="">ลาคลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('babymanager') ? 'bg-c': ''}}"><a href="{{route ('babymanager')}}" class="">ลาไปช่วยเหลือภริยาที่คลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('ordinationleavemanager') ? 'bg-c': ''}}"><a href="{{route ('ordinationleavemanager')}}" class="">ลาอุปสมบท (*)</a></li>
                    </ul>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->routeIS('cancelsickleave','cancelvacationleave','cancelprivateleave','cancelmaternityleave','cancelbaby','cancelordinationleave') ? 'bg-c': ''}}">
                    <a class="nav-link"><span class="pcoded-micon"><i class="feather icon-x"></i></span><span class="pcoded-mtext">ยกเลิกใบลา</span></a>
                    <ul class="pcoded-submenu">
                        <li class="{{request()->routeIS('cancelsickleavemanager') ? 'bg-c': ''}}"><a href="{{route ('cancelsickleavemanager')}}" class="">ลาป่วย</a></li>
                        <li class="{{request()->routeIS('cancelvacationleavemanager') ? 'bg-c': ''}}"><a href="{{route ('cancelvacationleavemanager')}}" class="">ลาพักผ่อน</a></li>
                        <li class="{{request()->routeIS('cancelprivateleavemanager') ? 'bg-c': ''}}"><a href="{{route ('cancelprivateleavemanager')}}" class="">ลากิจส่วนตัว</a></li>
                        <li class="{{request()->routeIS('cancelmaternityleavemanager') ? 'bg-c': ''}}"><a href="{{route ('cancelmaternityleavemanager')}}" class="">ลาคลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('cancelbabymanager') ? 'bg-c': ''}}"><a href="{{route ('cancelbabymanager')}}" class="">ลาไปช่วยเหลือภริยาที่คลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('cancelordinationleavemanager') ? 'bg-c': ''}}"><a href="{{route ('cancelordinationleavemanager')}}" class="">ลาอุปสมบท (*)</a></li>
                    </ul>
                </li>
                <li data-username="widget Statistic Data Table User card Chart" class="nav-item {{request()->routeIS('statusmanager') ? 'bg-c': ''}}">
                    <a href="{{route ('statusmanager')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-loader"></i></span><span class="pcoded-mtext">ตรวจสอบสถานะการลา</span></a>
                </li>
                <li data-username="widget Statistic Data Table User card Chart" class="nav-item {{request()->routeIS('approvemanager') ? 'bg-c': ''}}">
                    <a href="{{route ('approvemanager')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-check-square"></i></span><span class="pcoded-mtext">อนุมัติการลา</span></a>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item {{request()->routeIS('reportleavemanager') ? 'bg-c': ''}}">
                    <a href="{{route ('reportleavemanager')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-signal"></i></span><span class="pcoded-mtext">รายงานผลการลา</span></a>
                </li>
                <li data-username="advance components Alert gridstack lightbox modal notification pnotify rating rangeslider slider syntax highlighter Tour Tree view Nestable Toolbar" class="nav-item {{request()->routeIS('workingmanager') ? 'bg-c': ''}}">
                    <a href="{{route ('workingmanager')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-clipboard"></i></span><span class="pcoded-mtext">ตรวจสอบการมาปฏิบัติงาน</span></a>
                </li>  
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->