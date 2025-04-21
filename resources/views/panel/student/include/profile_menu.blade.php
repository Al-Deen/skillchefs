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
                                <a href="{{ route('student.profile') }}" class="user-sub-info">
                                    <div class="user-img">
                                        <img src="{{ showImage(auth()->user()->image->original ?? '', 'default-1.jpeg') }}"
                                            class="img-cover" alt="{{ auth()->user()->name ?? '' }}">
                                    </div>
                                    <div class="user-details">
                                        <span class="name">{{ auth()->user()->name ?? '' }}</span>
                                    </div>
                                </a>

                                <!-- user Score -->
                                <div class="score">
                                    <span class="title">{{ ___('student.My Points') }}</span>
                                    <span
                                        class="title">{{ number_format(auth()->user()->student ? auth()->user()->student->points : 0) }}</span>
                                </div>

                                <div class="pages">
                                    <p class="pera">{{ ___('student.pages') }}</p>
                                </div>

                                <!-- Profile List -->
                                <ul class="profileListing">
                                    <li class="list">
                                        <a class="list-items" href="{{ route('student.dashboard') }}">
                                            <i class="ri-dashboard-line"></i>{{ ___('frontend.Dashboard') }}
                                        </a>
                                    </li>
                                    <li class="list">
                                        <a class="list-items" href="{{ route('student.profile') }}">
                                            <i class="ri-contacts-line"></i>{{ ___('frontend.My Profile') }}
                                        </a>
                                    </li>
                                    <li class="list">
                                        <a class="list-items" href="{{ route('student.course') }}">
                                            <i class="ri-book-open-line"></i>
                                            {{ ___('frontend.Courses') }} </a>
                                    </li>
                                    <li class="list">
                                        <a class="list-items" href="{{ route('student.setting', ['edit']) }}">
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
                                    <span class="title">{{ ___('student.Sign out') }}</span>
                                </a>

                                <form action="{{ route('student.logout') }}" method="POST" id="logoutForm">
                                    @csrf
                                </form>


                            </div>
                        </li>
