<!-- [ Header ] start -->
<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
        <a href="index.html" class="b-brand">
           <div class="b-bg">
               <i class="feather icon-trending-up"></i>
           </div>
           <span class="b-title">Datta Able</span>
       </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#!">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Session::get('userfn')}}  {{Session::get('userln')}} 
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <ul class="pro-body">
                            <li><a href="{{route('intro')}}" class="dropdown-item"><i class="feather icon-log-out"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<!-- [ Header ] end -->
