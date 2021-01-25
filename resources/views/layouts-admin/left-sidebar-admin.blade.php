<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="{{route('addimage')}}" class="b-brand">
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
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item {{request()->routeIS('addimage') ? 'bg-c': ''}}"> 
                    <a href="{{route ('addimage')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-image"></i></span><span class="pcoded-mtext">อัปโหลดรูปภาพ</span></a>
                </li>
                <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item {{request()->routeIS('adduser') ? 'bg-c': ''}}"> 
                    <a href="{{route ('adduser')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-user-plus"></i></span><span class="pcoded-mtext">เพิ่มข้อมูลผู้ใช้</span></a>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item  {{request()->routeIS('manageaccount') ? 'bg-c': ''}}">
                    <a href="{{route ('manageaccount')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">จัดการบัญชีผู้ใช้</span></a>
                </li>
                {{-- <li data-username="widget Statistic Data Table User card Chart" class="nav-item {{request()->routeIS('dayleave') ? 'bg-c': ''}}">
                    <a href="{{route ('dayleave')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-edit-1"></i></span><span class="pcoded-mtext">กำหนดจำนวนวันลาในปีงบประมาณ</span></a>
                </li> --}}
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->url('dayleavesick','dayleavevacation','dayleaveprivate','dayleavematernity','dayleavebaby','dayleaveordination')? 'bg-c': ''}}">
                    <a class="nav-link"><span class="pcoded-micon"><i class="feather icon-edit-1"></i></span><span class="pcoded-mtext">กำหนดจำนวนวันลาในปีงบประมาณ</span></a>
                    <ul class="pcoded-submenu">
                        <li class="{{request()->routeIS('dayleavesick') ? 'bg-c': ''}}"><a href="{{route('dayleavesick')}}" >ลาป่วย</a></li>
                        <li class="{{request()->routeIS('dayleavevacation') ? 'bg-c': ''}}"><a href="{{route('dayleavevacation')}}" >ลาพักผ่อน</a></li>
                        <li class="{{request()->routeIS('dayleaveprivate') ? 'bg-c': ''}}"><a href="{{route('dayleaveprivate')}}" >ลากิจส่วนตัว</a></li>
                        <li class="{{request()->routeIS('dayleavematernity') ? 'bg-c': ''}}"><a href="{{route('dayleavematernity')}}" >ลาคลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('dayleavebaby') ? 'bg-c': ''}}"><a href="{{route('dayleavebaby')}}" >ลาไปช่วยเหลือภริยาที่คลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('dayleaveordination') ? 'bg-c': ''}}"><a href="{{route('dayleaveordination')}}" >ลาอุปสมบท (*)</a></li>
                    </ul>
                </li>
                <li data-username="widget Statistic Data Table User card Chart" class="nav-item">
                    <a href="" class="nav-link"><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">กำหนดวันหยุดราชการ</span></a>
                </li>
                <li class="nav-item pcoded-menu-caption">
                    <label>การใช้งาน</label>
                </li>
                {{-- <li data-username="advance components Alert gridstack lightbox modal notification pnotify rating rangeslider slider syntax highlighter Tour Tree view Nestable Toolbar" class="nav-item {{request()->routeIS('checkleave') ? 'bg-c': ''}}">
                    <a href="{{route ('checkleave')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-check-square"></i></span><span class="pcoded-mtext">ตรวจสอบการลาของบุคลากร</span></a>
                </li> --}}
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->routeIS('checkleave')? 'bg-c': ''}}">
                    <a class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-file-text"></i>
                        </span>
                        <span class="pcoded-mtext">ตรวจสอบการลาของบุคลากร</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{request()->routeIS('checkleave') ? 'bg-c': ''}}"><a href="{{route('checkleave', ['id' => '1'])}}" >ลาป่วย</a></li>
                        <li class="{{request()->routeIS('checkleave') ? 'bg-c': ''}}"><a href="{{route('checkleave', ['id' => '2'])}}" >ลาพักผ่อน</a></li>
                        <li class="{{request()->routeIS('checkleave') ? 'bg-c': ''}}"><a href="{{route('checkleave', ['id' => '3'])}}" >ลากิจส่วนตัว</a></li>
                        <li class="{{request()->routeIS('checkleave') ? 'bg-c': ''}}"><a href="{{route('checkleave', ['id' => '4'])}}" >ลาคลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('checkleave') ? 'bg-c': ''}}"><a href="{{route('checkleave', ['id' => '5'])}}" >ลาไปช่วยเหลือภริยาที่คลอดบุตร (*)</a></li>
                        <li class="{{request()->routeIS('checkleave') ? 'bg-c': ''}}"><a href="{{route('checkleave', ['id' => '6'])}}" >ลาอุปสมบท (*)</a></li>
                    </ul>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item {{request()->routeIS('reportleaveadmin') ? 'bg-c': ''}}">
                    <a href="{{route ('reportleaveadmin')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-signal"></i></span><span class="pcoded-mtext">รายงานผลการลา</span></a>
                </li>
                <li data-username="advance components Alert gridstack lightbox modal notification pnotify rating rangeslider slider syntax highlighter Tour Tree view Nestable Toolbar" class="nav-item {{request()->routeIS('workingadmin') ? 'bg-c': ''}}">
                    <a href="{{route ('workingadmin')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-clipboard"></i></span><span class="pcoded-mtext">ตรวจสอบการมาปฏิบัติงาน</span></a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->