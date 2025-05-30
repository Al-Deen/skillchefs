<body class="light-mode {{ @findDirectionOfLang() }}" dir="{{ @findDirectionOfLang() }}">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe
            src="https://www.googletagmanager.com/ns.html?id=GTM-PGLJB2JH"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <header>
        <div class="header-area header-sticky">
            <div class="main-header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="menu-wrapper d-flex align-items-center justify-content-between">

                                <!-- Logo -->
                                <div class="logo large-device d-none d-sm-block light-logo">
                                    {{ lightLogo() }}
                                </div>

                                 <!-- Logo -->
                                <div class="logo large-device d-none d-sm-block dark-logo">
                                    {{ darkLogo() }}
                                </div>


                                <!-- Logo Mobile-->
                                <div class="logo d-block d-sm-none">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ @showImage(setting('favicon'), 'favicon.png') }}"></a>
                                </div>
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-lg-block">
                                    <nav>
                                        <ul class="listing" id="navigation">
                                            <li class="single-list">
                                                <!-- Search -->
                                                <form action="{{ route('frontend.search') }}" class="header-search">
                                                    <div class="input-form">
                                                        <input type="text" name="query"
                                                            placeholder="{{ ___('frontend.Search') }} ..."
                                                            value="{{ @$_GET['query'] }}">
                                                        <div class="icon">
                                                            <i class="ri-search-line"></i>
                                                        </div>
                                                    </div>
                                                </form>
                                            </li>
{{--                                            <li class="single-list active">--}}
{{--                                                <a href="{{ route('home') }}"--}}
{{--                                                    class="single">{{ ___('frontend.Home') }}</a>--}}
{{--                                            </li>--}}


                                            <li class="single-list">
                                                <a href="javascript:;" class="single" data-bs-toggle="modal" data-bs-target="#supportModal">
                                                    {{ ___('frontend.Support') }}
                                                </a>
                                            </li>



                                            <div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 rounded-4">

                                                        @if(isset($data['liveSupportData']))
                                                        <div class="modal-body text-center p-4">
                                                            <p class="mb-1 text-muted small">
                                                                <h4 class="text-secondary">{{ $data['liveSupportData']->support?->title }}</h4>
                                                                 <h5 class="text-secondary">Course: {{  $data['liveSupportData']->support?->course->title }}</h5>
                                                                <strong>Instructor:</strong> {{ $data['liveSupportData']->support?->user->name }}<br>
                                                            </p>

                                                            <h5 class="fw-bold mb-0">Your Serial</h5>
                                                            <h2 class="display-4 fw-bold mb-3">{{ $data['liveSupportSerial'] ?? 'N/A' }}</h2>

                                                            <p class="text-muted small mb-4">
                                                            Your support will begin in approximately   <strong class="text-primary">{{ $data['waitingTime'] ?? 'N/A' }}</strong> minutes.
                                                            </p>

                                                            <div class="d-flex justify-content-between mx-5 mb-4">
                                                                <div>
                                                                    <div class="text-success fw-bold">Session Start</div>
                                                                    <div>
                                                                        {{ @$data['liveSupportData']->support?->start_time ? \Carbon\Carbon::parse(@$data['liveSupportData']->support?->start_time)->format('h:i A') : 'N/A' }}
                                                                    </div>

                                                                </div>
                                                                <div>
                                                                    <div class="text-danger fw-bold">Session End</div>
                                                                    <div>  {{ @$data['liveSupportData']->support?->end_time ? \Carbon\Carbon::parse(@$data['liveSupportData']->support?->end_time)->format('h:i A') : 'N/A' }}</div>
                                                                </div>
                                                            </div>

                                                            <!-- Buttons -->
                                                            <div class="d-flex justify-content-center gap-10">
                                                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Leave</button>
                                                                <a target="_blank" href="{{  @$data['liveSupportData']->support?->support_link }}" class="btn btn-primary px-4">Join Now</a>
                                                            </div>
                                                        </div>
                                                        @else
                                                            <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 15px 20px; border-radius: 8px; max-width: 400px; margin: 20px auto; text-align: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                                <h6 style="color: red; font-weight: 600; font-size: 1.1rem; margin: 0;">
                                                                    Support is currently unavailable. Please check back later.
                                                                </h6>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>




                                            <li class="single-list">
                                                <a href="javascript:;"
                                                    class="single menu-categories">{{ ___('frontend.Skills') }}</a>

                                            </li>

                                            <li class="single-list">
                                                <a href="{{ route('all.books') }}"
                                                   class="single">{{ ___('frontend.Books') }}</a>
                                            </li>

                                            <li class="single-list">
                                                <ul>
                                                    <li class="single-list ">
                                                        <a href="javascript:void(0)" class="single">
                                                            More <span class="dropdown-arrow">&#9662;</span>
                                                        </a>
                                                        <ul class="submenu">
                                                            <li class="single-list">
                                                                <a href="{{ route('becomeInstructor') }}" class="single">
                                                                    {{ ___('frontend.Become An Instructor') }}
                                                                </a>
                                                            </li>

                                                            <li class="single-list">
                                                                <a href="{{ route('becomeAmbassador') }}" class="single">
                                                                    {{ ___('frontend.Become An Ambassador') }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>

                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <!-- Cart -->
                                <ul class="cart">
                                    <!-- Mode Change -->
                                    <li class="cart-list">
                                        <button class="single change-mode m-0 p-2 border-0">
                                            <i class="ri-sun-line"></i>
                                        </button>
                                    </li>

                                    <!-- Language -->
                                    <li class="cart-list">
                                        <select class="language-select select_2" id="language-select">
                                            @foreach (language() as $language)
                                                <option value="{{ $language->code }}"
                                                    {{ $language->code == session()->get('locale') ? 'selected' : '' }}>
                                                    {{ $language->name }}</option>
                                            @endforeach

                                        </select>
                                    </li>

                                    <!-- shopping-cart -->
                                    <li class="cart-list shopping-cart position-relative"><a
                                            href="{{ route('cart.index') }}" class="cart-items ">
                                            <i class="ri-shopping-cart-line"></i><span class="count"
                                                id="total_cart">{{ count(Session()->get('cart') ?? []) }}</span></a>
                                    </li>

                                    <!-- Bookmark -->
{{--                                    <li class="cart-list shopping-cart position-relative"><a--}}
{{--                                            href="{{ route('frontend.bookmark') }}" class="cart-items">--}}
{{--                                            <i class="ri-heart-line"></i>--}}
{{--                                            <span class="count" id="bookmarks">--}}
{{--                                                @auth--}}
{{--                                                    {{ auth()->user()->bookmarks()->count() }}--}}
{{--                                                @else--}}
{{--                                                    0--}}
{{--                                                @endauth--}}
{{--                                            </span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}


                                    @auth
                                        @if (auth()->user()->role_id == App\Enums\Role::STUDENT)
                                            @include('panel.student.include.profile_menu')
                                        @elseif (auth()->user()->role_id == App\Enums\Role::INSTRUCTOR)
                                            @include('panel.instructor.include.profile_menu')
                                        @elseif (module('Organization') && auth()->user()->role_id == App\Enums\Role::ORGANIZATION)
                                            @include('organization::panel.organization.include.profile_menu')
                                        @else
                                            @include('panel.instructor.include.admin_profile_menu')
                                        @endif

                                    @endauth

                                    @guest

                                        <li class="cart-list">
                                            <a href="{{ route('frontend.signIn') }}" class="btn-primary-fill ml-20">
                                                {{ ___('frontend.Sign In') }}
                                            </a>
                                        </li>
                                    @endguest
                                </ul>

                            </div>
                            <!-- Mobile Menu -->
                            <div class="div">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Munu Footer -->
        @include('frontend.include.mobile_footer_menu')
        <!-- /End-of footer Menu -->
    </header>

