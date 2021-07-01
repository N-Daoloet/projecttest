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
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item {{request()->routeIS('indexuser') ? 'bg-c': ''}}"> 
                    <a href="{{route ('indexuser')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">หน้าหลัก</span></a>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->routeIS('sickleaveuser','vacationleaveuser','privateleaveuser','maternityleaveuser','babyuser','ordinationleaveuser') ? 'bg-c': ''}}">
                    <a class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">ยื่นใบลา</span></a>
                    <ul class="pcoded-submenu">
                        <li class="{{request()->routeIS('sickleaveuser') ? 'bg-c': ''}}"><a href="{{route ('sickleaveuser')}}">ลาป่วย</a></li>
                        <li class="{{request()->routeIS('vacationleaveuser') ? 'bg-c': ''}}"><a href="{{route ('vacationleaveuser')}}">ลาพักผ่อน</a></li>
                        <li class="{{request()->routeIS('privateleaveuser') ? 'bg-c': ''}}"><a href="{{route ('privateleaveuser')}}">ลากิจส่วนตัว</a></li>
                        <li class="{{request()->routeIS('maternityleaveuser') ? 'bg-c': ''}}"><a href="{{route ('maternityleaveuser')}}">ลาคลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('babyuser') ? 'bg-c': ''}}"><a href="{{route ('babyuser')}}">ลาไปช่วยเหลือภริยาที่คลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('ordinationleaveuser') ? 'bg-c': ''}}"><a href="{{route ('ordinationleaveuser')}}">ลาอุปสมบท (*)</a></li>
                    </ul>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->routeIS('cancelsickleaveuser','cancelvacationleaveuser','cancelprivateleaveuser','cancelmaternityleaveuser','cancelbabyuser','cancelordinationleaveuser') ? 'bg-c': ''}}">
                    <a class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-x"></i>
                        </span>
                        <span class="pcoded-mtext">ยกเลิกใบลา</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{request()->routeIS('cancelsickleaveuser') ? 'bg-c': ''}}"><a href="{{route ('cancelsickleaveuser')}}">ลาป่วย</a></li>
                        <li class="{{request()->routeIS('cancelvacationleaveuser') ? 'bg-c': ''}}"><a href="{{route ('cancelvacationleaveuser')}}">ลาพักผ่อน</a></li>
                        <li class="{{request()->routeIS('cancelprivateleaveuser') ? 'bg-c': ''}}"><a href="{{route ('cancelprivateleaveuser')}}">ลากิจส่วนตัว</a></li>
                        <li class="{{request()->routeIS('cancelmaternityleaveuser') ? 'bg-c': ''}}"><a href="{{route ('cancelmaternityleaveuser')}}">ลาคลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('cancelbabyuser') ? 'bg-c': ''}}"><a href="{{route ('cancelbabyuser')}}">ลาไปช่วยเหลือภริยาที่คลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('cancelordinationleaveuser') ? 'bg-c': ''}}"><a href="{{route ('cancelordinationleaveuser')}}">ลาอุปสมบท (*)</a></li>
                    </ul>
                </li>
                <li data-username="widget Statistic Data Table User card Chart" class="nav-item {{request()->routeIS('statususer') ? 'bg-c': ''}}">
                    <a href="{{route ('statususer')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-loader"></i></span><span class="pcoded-mtext">ตรวจสอบสถานะการลา</span></a>
                </li>

                {{-- <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->routeIS('reportleaveuser,workinguser')? 'bg-c': ''}}">
                    <a class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-file-text"></i>
                        </span>
                        <span class="pcoded-mtext">รายงาน</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{request()->routeIS('reportleaveuser') ? 'bg-c': ''}}"><a href="{{route('reportleaveuser')}}" >รายงานการลา</a></li>
                        <li class="{{request()->routeIS('workinguser') ? 'bg-c': ''}}"><a href="{{route('workinguser')}}" >รายงานการมาปฏิบัติงาน</a></li>
                    </ul>
                </li> --}}


                {{-- <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item {{request()->routeIS('reportleaveuser') ? 'bg-c': ''}}">
                    <a href="{{route ('reportleaveuser')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-signal"></i></span><span class="pcoded-mtext">รายงานผลการลา</span></a>
                </li>
                <li data-username="advance components Alert gridstack lightbox modal notification pnotify rating rangeslider slider syntax highlighter Tour Tree view Nestable Toolbar" class="nav-item {{request()->routeIS('workinguser') ? 'bg-c': ''}}">
                    <a href="{{route ('workinguser')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-clipboard"></i></span><span class="pcoded-mtext">ตรวจสอบการมาปฏิบัติงาน</span></a>
                </li>   --}}
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->