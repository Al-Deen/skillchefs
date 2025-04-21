<div class="mobile-menu-footer">
    <div class="container-fluid-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-mobile-wrapper">
                    <ul class="listing">
                        @if (auth()->check())
                            @if (auth()->user()->role_id == App\Enums\Role::STUDENT)
                                <li class="single-list">
                                    <a href="{{ route('student.dashboard') }}" class="active">
                                        <i class="ri-dashboard-line"></i>
                                        <span>{{ ___('frontend.Dashboard') }} </span>
                                    </a>
                                </li>
                                <li class="single-list">
                                    <a href="{{ route('student.profile') }}">
                                        <i class="ri-user-line"></i>
                                        <span>{{ ___('frontend.Profile') }}</span>
                                    </a>
                                </li>
                                <li class="single-list">
                                    <a href="{{ url('/') }}" class="home-btn">
                                        <i class="ri-home-4-line"></i>
                                    </a>
                                </li>
                                <li class="single-list counter">
                                    <a href="{{ route('cart.index') }}">
                                        <i class="ri-shopping-cart-line"></i>
                                        <span>{{ ___('frontend.Cart') }}</span>
                                        <span class="count">{{ count(Session()->get('cart') ?? []) }}</span>
                                    </a>
                                </li>
                                <li class="single-list counter">
                                    <a href="{{ route('student.course') }}">
                                        <i class="ri-book-open-line"></i>
                                        <span>{{ ___('frontend.Courses') }}</span>
                                    </a>
                                </li>
                            @elseif (auth()->user()->role_id == App\Enums\Role::INSTRUCTOR)
                                <li class="single-list">
                                    <a href="{{ route('instructor.dashboard') }}" class="active">
                                        <i class="ri-dashboard-line"></i>
                                        <span>{{ ___('instructor.Dashboard') }} </span>
                                    </a>
                                </li>
                                <li class="single-list">
                                    <a href="{{ route('instructor.profile') }}">
                                        <i class="ri-user-line"></i>
                                        <span>{{ ___('frontend.Profile') }}</span>
                                    </a>
                                </li>
                                <li class="single-list">
                                    <a href=" {{ url('/') }} " class="home-btn">
                                        <i class="ri-home-4-line"></i>
                                    </a>
                                </li>
                                <li class="single-list counter">
                                    <a href="{{ route('instructor.courses') }}">
                                        <i class="ri-book-open-line"></i>
                                        <span>{{ ___('sidebar.Courses') }}</span>
                                    </a>
                                </li>
                                <li class="single-list counter">
                                    <a href="student_notification.php">
                                        <i class="ri-settings-2-line"></i>
                                        <span> {{ ___('frontend.Settings') }}</span>
                                    </a>
                                </li>
                            @elseif (auth()->user()->role_id == App\Enums\Role::ORGANIZATION)
                                <li class="single-list">
                                    <a href="{{ route('organization.dashboard') }}" class="active">
                                        <i class="ri-dashboard-line"></i>
                                        <span>{{ ___('organization.Dashboard') }} </span>
                                    </a>
                                </li>
                                <li class="single-list">
                                    <a href="{{ route('organization.profile') }}">
                                        <i class="ri-user-line"></i>
                                        <span>{{ ___('frontend.Profile') }}</span>
                                    </a>
                                </li>
                                <li class="single-list">
                                    <a href=" {{ url('/') }} " class="home-btn">
                                        <i class="ri-home-4-line"></i>
                                    </a>
                                </li>
                                <li class="single-list counter">
                                    <a href="{{ route('organization.courses') }}">
                                        <i class="ri-book-open-line"></i>
                                        <span>{{ ___('sidebar.Courses') }}</span>
                                    </a>
                                </li>
                                <li class="single-list counter">
                                    <a href="{{ route('organization.setting') }}">
                                        <i class="ri-settings-2-line"></i>
                                        <span> {{ ___('frontend.Settings') }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="single-list">
                                    <a href="{{ route('dashboard') }}" class="active">
                                        <i class="ri-dashboard-line"></i>
                                        <span>{{ ___('frontend.Dashboard') }} </span>
                                    </a>
                                </li>
                                <li class="single-list">
                                    <a class="single change-mode">
                                        <i class="ri-sun-line"></i>
                                        <span>{{ ___('frontend.Dark_Mode') }}</span>
                                    </a>
                                </li>
                                <li class="single-list">
                                    <a href="{{ url('/') }}" class="home-btn">
                                        <i class="ri-home-4-line"></i>
                                    </a>
                                </li>

                                <li class="single-list">
                                    <a href="{{ route('my.profile') }}" class="active">
                                        <i class="ri-user-line"></i>
                                        <span>{{ ___('frontend.Profile') }}</span>
                                    </a>
                                </li>
                                <li class="single-list counter">
                                    <a href="javascript:;" onclick="document.getElementById('logoutForm').submit();">
                                        <i class="ri-logout-circle-r-line"></i>
                                        <span>
                                            {{ ___('frontend.sign out') }}
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="single-list">
                                <a href="{{ route('frontend.signIn') }}" class="active">
                                    <i class="ri-user-line"></i>
                                    <span>{{ ___('frontend.Profile') }}</span>
                                </a>
                            </li>
                            <li class="single-list">
                                <a class="single change-mode">
                                    <i class="ri-sun-line"></i>
                                    <span>{{ ___('frontend.Dark_Mode') }}</span>
                                </a>
                            </li>
                            <li class="single-list">
                                <a href="{{ url('/') }}" class="home-btn">
                                    <i class="ri-home-4-line"></i>
                                </a>
                            </li>
                            <li class="single-list counter">
                                <a href="{{ route('cart.index') }}">
                                    <i class="ri-shopping-cart-line"></i>
                                    <span>{{ ___('frontend.Cart') }}</span>
                                    <span class="count">{{ count(Session()->get('cart') ?? []) }}</span>
                                </a>
                            </li>
                            <li class="single-list counter">
                                <a href="{{ route('frontend.bookmark') }}">
                                    <i class="ri-heart-line"></i>
                                    <span>{{ ___('frontend.Bookmark') }}</span>
                                    <span class="count" id="bookmarks">
                                        @auth
                                            {{ auth()->user()->bookmarks()->count() }}
                                        @else
                                            0
                                        @endauth
                                    </span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
