<!-- [ navigation menu ] start -->

<?php


    $count = App\Absent::leftJoin('user','absentdetail.USER_ID','=','user.USER_ID')
                    ->where('user.DEP_ID',Session::get('userdep'))
                    ->where('STATUS_APPROVER','=',2)
                    ->where('absentdetail.USER_ID','!=',Session::get('userid'))

                    ->get();

        
                  

?>

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
                    <a href="{{route ('approvedirector')}}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-check-square"></i></span>
                        @if(count($count)>0)
                            <span class="pcoded-mtext">อนุมัติการลา &nbsp;&nbsp;<i class="feather icon-alert-triangle" style="color: yellow"></i></span>
                            {{-- <span class="pcoded-mtext">อนุมัติการลา <i class="feather icon-bell" style="color: red"></i></span> --}}
                        @else
                            <span class="pcoded-mtext">อนุมัติการลา </span>
                        @endif
                    </a>
                </li>

                <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item pcoded-hasmenu {{request()->routeIS('reportleavedirector,workingdirector')? 'bg-c': ''}}">
                    <a class="nav-link">
                        <span class="pcoded-micon">
                            <i class="feather icon-file-text"></i>
                        </span>
                        <span class="pcoded-mtext">รายงาน </span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{request()->routeIS('reportleavedirector') ? 'bg-c': ''}}"><a href="{{route('reportleavedirector')}}" >รายงานการลา</a></li>
                        <li class="{{request()->routeIS('workingdirector') ? 'bg-c': ''}}"><a href="{{route('workingdirector')}}" >รายงานการมาปฏิบัติงาน</a></li>
                        <li class="{{request()->routeIS('summarydirector') ? 'bg-c': ''}}"><a href="{{route('summarydirector')}}" >รายงานสรุปจำนวนวันปฎิบัติราชการ</a></li>
                    </ul>
                </li>

                {{-- <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item {{request()->routeIS('reportleavedirector') ? 'bg-c': ''}}">
                    <a href="{{route ('reportleavedirector')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-signal"></i></span><span class="pcoded-mtext">รายงานผลการลา</span></a>
                </li>
                <li data-username="advance components Alert gridstack lightbox modal notification pnotify rating rangeslider slider syntax highlighter Tour Tree view Nestable Toolbar" class="nav-item {{request()->routeIS('workingdirector') ? 'bg-c': ''}}">
                    <a href="{{route ('workingdirector')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-clipboard"></i></span><span class="pcoded-mtext">ตรวจสอบการมาปฏิบัติงาน</span></a>
                </li>   --}}
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->