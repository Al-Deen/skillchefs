<header class="header">
    {{-- Header Left --}}
    <div class="header_control_left d-flex gap-2 align-items-center">
        <button
            class="half-expand-toggle sidebar-toggle arrow-toggle-btn d-none d-lg-flex align-items-center justify-content-center ">
            <i class="las la-angle-double-left"></i>
        </button>

        {{-- Home BTN --}}
        <a href="{{ url('/') }}" target="_blank"
            class="home-btn sm-done d-lg-flex align-items-center justify-content-center">
            <i class="las la-home"></i>
        </a>
    </div>

    <button class="close-toggle sidebar-toggle arrow-toggle-btn  p-0">
        <i class="las la-angle-double-left"></i>
    </button>

    {{-- Header Right --}}
    <div class="header-controls flex-fill justify-content-end">

        <!-- Language -->
        <div class="header-control-item">
            <div class="single-select">
                <select name="language" class="select2 language-change" id="language-change">
                    <i class="las la-angle-down"></i>
                    @foreach (language() as $language)
                        <option value="{{ $language->code }}"
                            {{ $language->code == session()->get('locale') ? 'selected' : '' }}>
                            {{ $language->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Light/Dark Mode -->
        <div class="header-control-item">
            <div class=" dropdown theme_dropdown">
                <a id="button" class="btn " href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <i class="lar la-sun"></i>
                </a>
                <ul class="dropdown-menu " data-popper-placement="bottom-start">
                    <li class="dropdown-item active theme_list" data-theme-style="default-theme"> <i
                            class="lar la-sun"></i> {{ ___('common.Light') }}</li>
                    <li class="dropdown-item theme_list" data-theme-style="dark-theme"> <i class="lar la-moon"></i>
                        {{ ___('common.Dark') }}</li>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Full Screen -->
        <div class="header-control-item">
            <div class="item-content dropdown md-none theme_dropdown">
                <button class="mt-0 btn" onclick="javascript:toggleFullScreen()">
                    <i class="expand_icon las la-expand"></i>
                </button>
            </div>
        </div>

        <!-- User -->
        <div class="header-control-item">
            <div class="item-content">
                <button class="profile-navigate mt-0 p-0" type="button" id="profile_expand" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="profile-photo user-card">
                        <img src="{{ @showImage(Auth::user()->image->original) }}" alt="{{ Auth::user()->name }}">
                    </div>
                </button>
                <div class="dropdown-menu dropdown-menu-end profile-expand-dropdown top-navbar-dropdown-menu ot-card"
                    aria-labelledby="profile_expand">
                    <div class="profile-expand-container">
                        <div class="profile-expand-list d-flex flex-column">
                            <a class="profile-expand-item {{ set_menu(['my.profile'], 'active') }}"
                                href="{{ route('my.profile') }}">
                                <i class="las la-user"></i>
                                <span>{{ ___('common.my_profile') }}</span>
                            </a>
                            <a class="profile-expand-item {{ set_menu(['passwordUpdate'], 'active') }}"
                                href="{{ route('passwordUpdate') }}">
                                <i class="las la-lock"></i>
                                <span>{{ ___('common.update_password') }}</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="profile-expand-item">
                                    <i class="las la-sign-out-alt"></i>
                                    <span>
                                        {{ ___('common.logout') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
