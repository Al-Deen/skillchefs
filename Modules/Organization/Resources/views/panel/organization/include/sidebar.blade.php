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
                        <a href="{{ route('organization.dashboard') }}">
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
                        <li class="list {{ is_active(['organization.dashboard']) }}">
                            <a href="{{ route('organization.dashboard') }}" class="single">
                                <i class="ri-dashboard-line"></i>
                                {{ ___('common.Dashboard') }}
                            </a>
                        </li>
                        <li class="list {{ is_active(['organization.profile']) }}">
                            <a href="{{ route('organization.profile') }}" class="single">
                                <i class="ri-user-line"></i>
                                {{ ___('common.My Profile') }}
                            </a>
                        </li>
                        <li class="list {{ is_active(['organization.instructor']) }}">
                            <a href="{{ route('organization.instructor') }}" class="single">
                                <i class="ri-team-line"></i>
                                {{ ___('common.Instructor') }}
                            </a>
                        </li>
                        <li class="list {{ is_active(['organization.ai_support']) }}">
                            <a href="{{ route('organization.ai_support') }}" class="single">
                                <i class="ri-gps-line"></i>
                                {{ ___('organization.AI Support') }}
                            </a>
                        </li>
                        <li
                            class="list {{ is_active(['organization.courses', 'organization.add_course', 'organization/edit-course*', 'organization/live-class/*']) }}">
                            <a href="{{ route('organization.courses') }}" class="single">
                                <i class="ri-pantone-line"></i>
                                {{ ___('sidebar.My Courses') }}
                            </a>
                        </li>
                        @if (module('LiveClass'))
                            <li class="list {{ is_active(['organization/live-class-list']) }}">
                                <a href="{{ route('organization.frontend_live_class_list.index', ['type=upcoming']) }}"
                                    class="single">
                                    <i class="ri-live-line"></i>
                                    {{ ___('live_class.Live_Classes') }}
                                </a>
                            </li>
                        @endif
                        <!-- event Layout Start -->
                        @if (module('Event'))
                            @include('event::backend.instructor.partials.sidebar')
                        @endif
                        <!-- event Layout End -->
                        <li class="list {{ is_active(['frontend/bookmark*']) }}">
                            <a href="{{ route('frontend.bookmark') }}" class="single">
                                <i class="ri-book-open-line"></i>
                                {{ ___('student.Bookmarks') }}
                            </a>
                        </li>
                        <li
                            class="list {{ is_active(['organization.assignment.index', 'organization/assignment*']) }}">
                            <a href="{{ route('organization.assignment.index') }}" class="single">
                                <i class="ri-edit-box-line"></i>
                                {{ ___('sidebar.Assignments') }}
                            </a>
                        </li>

                        <li class="list {{ is_active(['organization.quiz.index', 'organization/quiz*']) }}">
                            <a href="{{ route('organization.quiz.index') }}" class="single"> <i
                                    class="ri-edit-line"></i>
                                {{ ___('sidebar.Quizzes') }} </a>
                        </li>
                        <li class="list {{ is_active(['organization.enrolled_students']) }}">
                            <a href="{{ route('organization.enrolled_students') }}" class="single">
                                <i class="ri-book-open-line"></i>
                                {{ ___('sidebar.Enrolled Students') }} </a>
                        </li>
                        <li class="list {{ is_active(['organization.course_sales']) }}">
                            <a href="{{ route('organization.course_sales') }}" class="single">
                                <i class="ri-bookmark-3-line"></i>
                                {{ ___('sidebar.Course Sales') }} </a>
                        </li>
                        @if (module('Subscription'))
                            <li class="list {{ is_active(['subscription.organization.index']) }}">
                                <a href="{{ route('subscription.organization.index') }}" class="single">
                                    <i class="ri-trophy-line"></i>
                                    {{ ___('sidebar.Course_Subscription') }} </a>
                            </li>
                        @endif
                        <li
                            class="list has-children {{ is_active(['organization.sales_report.course', 'organization.payouts_list', 'organization.payout_settings', 'panel/event/financial/sales-report*', 'organization/financial/payout-details*'], 'open show') }}">
                            <a href="javascript:void(0)" class="single">
                                <i class="ri-line-height"></i>
                                {{ ___('sidebar.Financial') }}
                            </a>
                            <ul class="submenu">
                                <li class="list {{ is_active(['organization.sales_report.course', 'instructor.sales_report.event'], 'selected') }}">
                                    <a href="{{ route('organization.sales_report.course') }}" class="child-single">
                                        {{ ___('sidebar.Sales Reports') }}
                                    </a>
                                </li>
                                <li
                                    class="list {{ is_active(['organization.payouts_list', 'organization/financial/payout-details*'], 'selected') }}">
                                    <a href="{{ route('organization.payouts_list') }}" class="child-single">
                                        {{ ___('sidebar.Payouts') }}
                                    </a>
                                </li>
                                <li class="list {{ is_active(['organization.payout_settings'], 'selected') }}">
                                    <a href="{{ route('organization.payout_settings') }}" class="child-single">
                                        {{ ___('sidebar.Payout Settings') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="list {{ is_active(['organization.course_reviews']) }}">
                            <a href="{{ route('organization.course_reviews') }}" class="single">
                                <i class="ri-star-smile-fill"></i>
                                {{ ___('organization.Course Reviews') }}
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
                            <li class="list {{ is_active(['instructor.live_chat', 'instructor/live-chat*']) }}">
                                <a href="{{ route('instructor.live_chat') }}" class="single">
                                    <i class="ri-messenger-line"></i>
                                    {{ ___('live_chat.live_chat') }}
                                </a>
                            </li>
                            {{-- Chats --}}
                        @endif
                        <li class="list {{ is_active(['organization.setting']) }}">
                            <a href="{{ route('organization.setting', ['edit']) }}" class="single">
                                <i class="ri-settings-4-line"></i>
                                {{ ___('common.settings') }}
                            </a>
                        </li>
                        <li class="list logout">
                            <a href="#" onclick="document.getElementById('logoutForm').submit();"
                                class="single"><i class="ri-logout-circle-r-line"></i> {{ ___('instructor.Sign_Out') }}
                            </a>
                        </li>

                        <form action="{{ route('instructor.logout') }}" method="POST" id="logoutForm">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End-of Panel Sidebar -->
