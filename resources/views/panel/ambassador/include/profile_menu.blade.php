                        <!-- After Login -->
                        <li class="cart-list onhover-dropdown">
                            <!-- User Profile -->
                            <div class="user-info">
                                <div class="user-img">
                                    <img src="{{ showImage(auth()->user()->image->original ?? '', 'default-1.jpeg') }}"
                                        class="img-cover" alt="{{ auth()->user()->name ?? '' }}">
                                </div>
                            </div>
                            <div class="onhover-dropdown-show dropdown-list-style white-bg">
                                <!-- User info -->
                                <a href="{{ route('ambassador.profile') }}" class="user-sub-info border-0 pb-0">
                                    <div class="user-img">
                                        <img src="{{ showImage(auth()->user()->image->original ?? '', 'default-1.jpeg') }}"
                                            class="img-cover" alt="{{ auth()->user()->name ?? '' }}">
                                    </div>
                                    <div class="user-details">
                                        <span class="name">{{ auth()->user()->name ?? '' }}</span>
                                    </div>
                                </a>

                                <div class="pages">
                                    <p class="pera">{{ ___('frontend.pages') }}</p>
                                </div>

                                <!-- Profile List -->
                                <ul class="profileListing">
                                    <li class="list">
                                        <a class="list-items" href="{{ route('ambassador.dashboard') }}">
                                            <i class="ri-dashboard-line"></i>Dashboard
                                        </a>
                                    </li>
                                    <li class="list">
                                        <a class="list-items" href="{{ route('ambassador.profile') }}">
                                            <i class="ri-contacts-line"></i>My Profile
                                        </a>
                                    </li>
{{--                                    <li class="list">--}}
{{--                                        <a class="list-items" href="{{ route('ambassador.courses') }}">--}}
{{--                                            <i class="ri-book-open-line"></i>--}}
{{--                                            {{ ___('sidebar.My Courses') }}--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
                                    <li class="list">
                                        <a class="list-items" href="{{ route('ambassador.setting', ['edit']) }}">
                                            <i class="ri-settings-2-line"></i> {{ ___('frontend.Settings') }}
                                        </a>
                                    </li>
                                </ul>

                                <!-- Change Mode -->
                                <div
                                    class="border-top mt-10 mb-15 pt-10 pb-0 d-flex justify-content-between align-items-center">
                                    <div class="change-mode p-2">
                                        <h6 class="toggle-mode">
                                            <span class="light">{{ ___('frontend.Light') }}</span>
                                            <span class="dark">{{ ___('frontend.Dark') }}</span>
                                            {{ ___('frontend.Mode') }}
                                        </h6>
                                    </div>
                                    <button class="single change-mode m-0 p-2">
                                        <i class="ri-sun-line"></i>
                                    </button>
                                </div>
                                <!-- Log Out -->
                                <a href="#" class="signout-btn"
                                    onclick="document.getElementById('logoutForm').submit();">
                                    <span class="title"><i class="ri-logout-circle-r-line"></i></span>
                                    <span class="title">{{ ___('frontend.sign out') }}</span>
                                </a>

                                <form action="{{ route('ambassador.logout') }}" method="POST" id="logoutForm">
                                    @csrf
                                </form>


                            </div>
                        </li>
