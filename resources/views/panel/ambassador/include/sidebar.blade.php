<!-- Admin Contents S t a r t -->
<div class="container-fluid">
    <div class="admin-wrapper white-bg">


        <!-- Panel Sidebar Start -->
        <div class="sidebar-body-overlay"></div>
        <div class="panel-sidebar">
            <div class="panel-sidebar-close-main">
                <!-- Mobile Device Close Icon -->
                <div class="close-sidebar"><i class="ri-close-line"></i></div>

                <!-- Top -->
                <div class="panel-sidebar-top">
                    <div class="thumb">
                        <a href="{{ route('ambassador.dashboard') }}">
                            <img src="{{ showImage(setting('light_logo'), 'logo.png') }}" class="logo_custom" alt="img">
                        </a>
                    </div>
                </div>
                <div class="panel-pages">
                    <span class="title">{{ ___('common.pages') }} </span>
                </div>

                <!-- Page List -->
                <div class="panel-sidebar-mid nice-scrolls">
                    <ul class="panel-sidebar-list">
                        <li class="list {{ is_active(['ambassador.dashboard']) }}">
                            <a href="{{ route('ambassador.dashboard') }}" class="single">
                                <i class="ri-dashboard-line"></i>
                                {{ ___('common.Dashboard') }}
                            </a>
                        </li>
                        <li class="list {{ is_active(['ambassador.profile']) }}">
                            <a href="{{ route('ambassador.profile') }}" class="single">
                                <i class="ri-user-line"></i>
                                {{ ___('common.My Profile') }}
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Bottom -->
                <div class="panel-pages">
                    <span class="title">{{ ___('common.Insight') }} </span>
                </div>
            </div>
        </div>
        <!-- End-of Panel Sidebar -->
