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
                <li data-username="widget Statistic Data Table User card Chart" class="nav-item {{request()->routeIS('approvedirector') ? 'bg-c': ''}}">
                    <a href="{{route ('approvedirector')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-check-square"></i></span><span class="pcoded-mtext">อนุมัติการลา</span></a>
                </li>
                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item {{request()->routeIS('reportleavedirector') ? 'bg-c': ''}}">
                    <a href="{{route ('reportleavedirector')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-signal"></i></span><span class="pcoded-mtext">รายงานผลการลา</span></a>
                </li>
                <li data-username="advance components Alert gridstack lightbox modal notification pnotify rating rangeslider slider syntax highlighter Tour Tree view Nestable Toolbar" class="nav-item {{request()->routeIS('workingdirector') ? 'bg-c': ''}}">
                    <a href="{{route ('workingdirector')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-clipboard"></i></span><span class="pcoded-mtext">ตรวจสอบการมาปฏิบัติงาน</span></a>
                </li>  
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->