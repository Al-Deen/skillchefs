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
                        <a href="{{ route('student.dashboard') }}">
                            <img src="{{ showImage(setting('light_logo'), 'logo.png') }}" class="logo_custom" alt="img">
                        </a>
                    </div>
                </div>
                <div class="panel-pages">
                    <span class="title">{{ ___('common.pages') }} </span>
                </div>

                <!-- Page List -->
                <div class="panel-sidebar-mid nice-scroll">
                    <ul class="panel-sidebar-list">
                        <li class="list {{ is_active(['student.dashboard']) }}">
                            <a href="{{ route('student.dashboard') }}" class="single">
                                <i class="ri-dashboard-line"></i>
                                {{ ___('common.Dashboard') }}
                            </a>
                        </li>
                        <li class="list {{ is_active(['student.profile']) }}">
                            <a href="{{ route('student.profile') }}" class="single">
                                <i class="ri-user-line"></i>
                                {{ ___('common.My Profile') }}
                            </a>
                        </li>
                        <li class="list {{ is_active(['student.course']) }}">
                            <a href="{{ route('student.course') }}" class="single">
                                <i class="ri-book-open-line"></i>
                                {{ ___('student.My Courses') }}
                            </a>
                        </li>
                        @if (module('LiveClass'))
                            <li class="list {{ is_active(['student.live_class_list.index']) }}">
                                <a href="{{ route('student.live_class_list.index', ['type=upcoming']) }}"
                                    class="single">
                                    <i class="ri-live-line"></i>
                                    {{ ___('live_class.Live_Classes') }}
                                </a>
                            </li>
                        @endif
                        <li class="list {{ is_active(['student.course_activities']) }}">
                            <a href="{{ route('student.course_activities') }}" class="single">
                                <i class="ri-refresh-line"></i>
                                {{ ___('student.Course Activities ') }}
                            </a>
                        </li>
                        @if (module('Subscription'))
                        <li class="list {{ is_active(['student.package']) }}">
                            <a href="{{ route('student.package') }}" class="single">
                                <i class="ri-trophy-line"></i>
                                {{ ___('student.My_Packages') }}
                            </a>
                        </li>
                        @endif
                        @if (module('Event'))
                        <li class="list {{ is_active(['student.event']) }}">
                            <a href="{{ route('student.event') }}" class="single">
                                <i class="ri-calendar-2-line"></i>
                                {{ ___('student.My_Events') }}
                            </a>
                        </li>
                        @endif
                        <li class="list {{ is_active(['student.certificates', 'student/certificate/*']) }}">
                            <a href="{{ route('student.certificates') }}" class="single">
                                <i class="ri-bookmark-3-line"></i>
                                {{ ___('sidebar.Certificates') }} </a>
                        </li>
                        <li class="list {{ is_active(['frontend.bookmark']) }}">
                            <a href="{{ route('frontend.bookmark') }}" class="single">
                                <i class="ri-book-open-line"></i>
                                {{ ___('student.Bookmarks') }}
                            </a>
                        </li>

                        <li class="list {{ is_active(['student.leader_board']) }}">
                            <a href="{{ route('student.leader_board') }}" class="single">
                                <i class="ri-git-branch-line"></i>
                                {{ ___('student.Leaderboard') }}
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Bottom -->
                <div class="panel-pages">
                    <span class="title">{{ ___('common.Insight') }} </span>
                </div>
                <!-- Page List -->
                <div class="panel-sidebar-bottom mb-20">
                    <ul class="panel-sidebar-list">

                        @if (module('LiveChat'))
                            <!-- Chats -->
                            <li class="list {{ is_active(['student.live_chat', 'student/live-chat*']) }}">
                                <a href="{{ route('student.live_chat') }}" class="single">
                                    <i class="ri-messenger-line"></i>
                                    {{ ___('live_chat.live_chat') }}
                                </a>
                            </li>
                            {{-- Chats --}}
                        @endif
                        <li class="list {{ is_active(['student.setting']) }}">
                            <a href="{{ route('student.setting', ['edit']) }}" class="single"> <i
                                    class="ri-settings-4-line"></i>
                                {{ ___('common.settings') }}
                            </a>
                        </li>
                        <li class="list logout">
                            <a type="button" onclick="document.getElementById('logoutForm').submit();"
                                class="single"><i class="ri-logout-circle-r-line"></i> {{ ___('student.Logout') }} </a>
                        </li>

                        <form action="{{ route('student.logout') }}" method="POST" id="logoutForm">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End-of Panel Sidebar -->
