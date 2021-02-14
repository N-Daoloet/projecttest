    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">                    
                <a href="{{route('addimage')}}" class="b-brand">
                    <span class="b-title-center">
                        <img src="assets/images/logokmutnb1.jpg" height= "120" alt="Logo"><br>
                    </span>
                </a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item pcoded-menu-caption">
                        <label>การตั้งค่า</label>
                    </li>
                    <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item {{request()->routeIS('addimage') ? 'bg-c': ''}}"> 
                        <a href="{{route ('addimage')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-image"></i></span><span class="pcoded-mtext">อัปโหลดรูปภาพ</span></a>
                    </li> 
                    <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item {{request()->routeIS('adduser') ? 'bg-c': ''}}"> 
                        <a href="{{route ('adduser')}}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-user-plus"></i></span><span class="pcoded-mtext">เพิ่มข้อมูลผู้ใช้</span></a>
                    </li>
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item  {{request()->routeIS('manageaccount') ? 'bg-c': ''}}">
                        <a href="{{route ('manageaccount')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">จัดการบัญชีผู้ใช้</span></a>
                    </li>
                    <li data-username="widget Statistic Data Table User card Chart" class="nav-item {{request()->routeIS('dayleave') ? 'bg-c': ''}}">
                        <a href="{{route ('dayleave')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-edit-1"></i></span><span class="pcoded-mtext">กำหนดจำนวนวันลาในปีงบประมาณ</span></a>
                    </li>  
                    <li data-username="widget Statistic Data Table User card Chart" class="nav-item">
                        <a href="" class="nav-link"><span class="pcoded-micon"><i class="feather icon-calendar"></i></span><span class="pcoded-mtext">กำหนดวันหยุดราชการ</span></a>
                    </li>
                    <li class="nav-item pcoded-menu-caption">
                        <label>การใช้งาน</label>
                    </li>
                    {{-- <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->routeIS('checkleave')? 'bg-c': ''}}">
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
                    </li> --}}
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item {{request()->routeIS('checkleave') ? 'bg-c': ''}}">
                        <a href="{{route ('checkleave')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-signal"></i></span><span class="pcoded-mtext">ตรวจสอบการลาของบุคลากร</span></a>
                    </li>

                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item {{request()->routeIS('reportleaveadmin') ? 'bg-c': ''}}">
                        <a href="{{route ('reportleaveadmin')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-signal"></i></span><span class="pcoded-mtext">รายงานผลการลา</span></a>
                    </li>
                    <li data-username="advance components Alert gridstack lightbox modal notification pnotify rating rangeslider slider syntax highlighter Tour Tree view Nestable Toolbar" class="nav-item {{request()->routeIS('workingadmin') ? 'bg-c': ''}}">
                        <a href="{{route ('workingadmin')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-clipboard"></i></span><span class="pcoded-mtext">ตรวจสอบการมาปฏิบัติงาน</span></a>
                    </li>
                    <li data-username="advance components Alert gridstack lightbox modal notification pnotify rating rangeslider slider syntax highlighter Tour Tree view Nestable Toolbar" class="nav-item {{request()->routeIS('workingadmin') ? 'bg-c': ''}}">
                        
                    </li>
                </ul>
            </div> --}}
        </div>
    </nav>
    <!-- [ navigation menu ] end -->

    <!-- [ chat user list ] start -->
    <section class="header-user-list">    
        <div class="h-list-body">
            <div class="main-friend-cont scroll-div">
            </div>
        </div>
    </section>
    <!-- [ chat user list ] end -->

    <!-- [ chat message ] start -->
    <section class="header-chat">
        <div class="h-list-body">
            <div class="main-chat-cont scroll-div">
            </div>
        </div>
    </section>
    <!-- [ chat message ] end -->


    <div class="md-overlay"></div>

<!-- [ navigation menu ] start -->
