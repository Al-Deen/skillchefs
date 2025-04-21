@extends('panel.student.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- Content Wrapper -->
    <div class="row">
        <!-- Section Tittle -->
        <div class="col-xl-12">
            <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                <h2 class="title font-600 mb-20">{{ ___('student.Settings') }}</h2>
            </div>
        </div>
        <div class="col-xl-12">

            <!-- Student Setting TAB -->
            <ul class="nav course-details-tabs setting-tab mb-40" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('student.setting', ['edit']) }}"
                        class="nav-link {{ url()->current() === route('student.setting', ['edit']) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-user-add-line"></i>
                        <span>{{ ___('student.Edit Profile') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('student.setting', ['security']) }}"
                        class="nav-link {{ url()->current() === route('student.setting', ['security']) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-lock-line"></i>
                        <span>{{ ___('student.Security') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('student.setting', ['educations']) }}"
                        class="nav-link {{ url()->current() === route('student.setting', ['educations']) ? 'active' : '' }} "
                        type="button" role="tab"> <i class="ri-book-open-line"></i>
                        <span>{{ ___('student.Educations') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('student.setting', ['experiences']) }}"
                        class="nav-link {{ url()->current() === route('student.setting', ['experiences']) ? 'active' : '' }} "
                        type="button"role="tab">
                        <i class="ri-briefcase-line"></i>
                        <span>{{ ___('student.Experiences') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('student.setting', ['skills']) }}"
                        class="nav-link {{ url()->current() === route('student.setting', ['skills']) ? 'active' : '' }} "
                        type="button" role="tab">
                        <i class="ri-tools-line"></i>
                        <span>{{ ___('student.Skills & Expertise') }}</span>
                    </a>
                </li>
                @if (module('TwoFA') && setting('two_fa_setup'))
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('student.setting', ['two_fa']) }}"
                            class="nav-link {{ url()->current() === route('student.setting', ['two_fa']) ? 'active' : '' }} "
                            type="button" role="tab"><i class="ri-shield-check-line"></i>
                            <span>{{ ___('student.Two Factor Authentication') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                @if (url()->current() === route('student.setting', ['edit']))
                    <div class="tab-pane fade show active">

                        <!-- General info start -->
                        <form action="{{ route('student.update_profile') }}" method="POST" class="settings-general-info"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Section Tittle -->
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <!-- Personal Info -->
                                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                                        <h4 class="title text-capitalize font-600">
                                            {{ ___('student.Personal Information') }}
                                        </h4>
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.Your Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control ot-contact-input @error('name') is-invalid @enderror"
                                            type="text" name="name" value="{{ auth()->user()->name }}"
                                            placeholder="{{ ___('student.Name') }}">
                                        @error('name')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.Phone') }} <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control ot-contact-input @error('phone') is-invalid @enderror"
                                            type="string" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                            placeholder="{{ ___('student.Phone') }}">
                                        @error('phone')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.Date Of Birth') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input date-picker @error('date_of_birth') is-invalid @enderror"
                                            date-picker type="text" name="date_of_birth"
                                            value="{{ date_picker_format(@$data['student']->date_of_birth) }}"
                                            placeholder="{{ ___('student.Date Of Birth') }}">
                                        @error('date_of_birth')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.Gender') }} <span
                                                class="text-danger">*</span></label>
                                        <select class="select_2 @error('gender') is-invalid @enderror" name="gender">
                                            <option value="{{ App\Enums\Gender::MALE }}"
                                                @if (@$data['student']->gender == App\Enums\Gender::MALE) {{ 'selected' }} @endif>
                                                {{ ___('student.Male') }}</option>
                                            <option value="{{ App\Enums\Gender::FEMALE }}"
                                                @if (@$data['student']->gender == App\Enums\Gender::FEMALE) {{ 'selected' }} @endif>
                                                {{ ___('student.Female') }}</option>
                                            <option value="{{ App\Enums\Gender::OTHERS }}"
                                                @if (@$data['student']->gender == App\Enums\Gender::OTHERS) {{ 'selected' }} @endif>
                                                {{ ___('student.Others') }}</option>
                                        </select>
                                        @error('gender')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <!-- Address -->
                                    <div class="small-tittle-two border-bottom mb-20 pb-8 pt-24">
                                        <h4 class="title text-capitalize font-600">{{ ___('student.Address') }}</h4>
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.address') }}</label>
                                        <input class="form-control ot-contact-input @error('address') is-invalid @enderror"
                                            type="text" name="address" value="{{ @$data['student']->address }}"
                                            placeholder="{{ ___('student.Enter your Address') }}">
                                        @error('address')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.Country') }} <span
                                                class="text-danger">*</span></label>
                                        <!-- Select2 -->
                                        <select class="country_list @error('country_id') is-invalid @enderror"
                                            name="country_id">
                                            <option value="">{{ ___('placeholder.Select Country') }}</option>
                                            @if (@$data['student']->country_id)
                                                <option value="{{ @$data['student']->country_id }}" selected>
                                                    {{ @$data['student']->country->name }}</option>
                                            @endif
                                        </select>
                                        @error('country_id')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-xl-6 col-lg-12">
                                    <!-- About My Self -->
                                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                                        <h4 class="title text-capitalize font-600">{{ ___('student.About Information') }}
                                        </h4>
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.Designation') }}</label>
                                        <input
                                            class="form-control ot-contact-input @error('designation') is-invalid @enderror"
                                            type="text" name="designation"
                                            value="{{ @$data['student']->designation ?? old('designation') }}"
                                            placeholder="{{ ___('student.UI/UX Designer | Product Design | Mobile App Expert') }}">
                                        @error('designation')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.About') }}</label>
                                        <textarea class="ot-contact-textarea @error('about_me') is-invalid @enderror"
                                            placeholder="{{ ___('student.About My Self') }}" name="about_me" id="about_me" cols="8" rows="4">{{ @$data['student']->about_me ?? old('about_me') }}</textarea>
                                        @error('about_me')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- uplode image -->
                                    <div class="ot-contact-form mb-24">
                                        <label for="profile_image" class="form-label ">{{ ___('student.Profile Image') }}
                                        </label>
                                        <div @if (@$data['student']->user->image) data-val="{{ showImage(@$data['student']->user->image->original) }}" @endif
                                            data-name="profile_image"
                                            class="file @error('profile_image') is-invalid @enderror"
                                            data-height="200px ">
                                        </div>
                                        <small
                                            class="text-muted">{{ ___('placeholder.NB : Profile size will 100px x 100px and not more than 1mb') }}</small>
                                        @error('profile_image')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Switch Box -->
                                <div class="col-lg-12">
                                    <div class="btn-wrapper mt-6">
                                        <button class="btn-primary-fill">{{ ___('student.Save & Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- General info end -->

                    </div>
                @elseif (url()->current() === route('student.setting', ['security']))
                    <div class="tab-pane fade show active">
                        <!-- Security -->
                        <form action="{{ route('student.update_password') }}" class="Security" method="post">
                            @csrf
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                                        <h4 class="title text-capitalize font-600">{{ ___('student.Change Password') }}
                                        </h4>
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.Old Password') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input @error('old_password') is-invalid @enderror"
                                            type="password" name="old_password" placeholder="************************">

                                        @error('old_password')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.New Password') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input @error('password') is-invalid @enderror"
                                            type="password" name="password" placeholder="************************">
                                        @error('password')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('student.Re-Enter Password') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input @error('password_confirmation') is-invalid @enderror"
                                            type="password" name="password_confirmation"
                                            placeholder="************************">
                                        @error('password_confirmation')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                                        <button class="btn-primary-fill">{{ ___('common.update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Security end -->
                    </div>
                @elseif (url()->current() === route('student.setting', ['educations']))
                    <div class="tab-pane fade show active">
                        <!-- Educations -->
                        <div class="col-xl-12">
                            <div
                                class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">

                                <div class="country d-flex align-items-center ">
                                    <i class="ri-book-open-line"></i>
                                    <span class="country text-title font-600 ml-10">{{ ___('student.Educations') }}</span>
                                </div>
                                <button class="btn-primary-outline"
                                    onclick="mainModalOpen(`{{ route('student.addInstitute') }}`)"><i
                                        class="ri-add-line"></i> {{ ___('student.add new') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            @if (@$data['student']->education)
                                @foreach (@$data['student']->education as $key => $institute)
                                    <div class="col-xl-12">
                                        <div
                                            class="single-education mb-30 d-flex justify-content-between align-items-start">

                                            <div class="education-cap">
                                                <h4 class="text-18 text-tile mb-15">
                                                    <a href="#">
                                                        {{ @$institute['name'] }}
                                                    </a>
                                                </h4>
                                                <p class="pera text-primary mb-6">
                                                    {{ @$institute['degree'] }} - {{ @$institute['program'] }}

                                                </p>
                                                <p class="pera mb-20">
                                                    {{ date('M y', strtotime(@$institute['start_date'])) }} -
                                                    @if (@$institute['current'])
                                                        {{ ___('student.Continue') }}
                                                    @else
                                                        {{ date('M y', strtotime(@$institute['end_date'])) }}
                                                    @endif
                                                </p>
                                                <p class="pera mb-6">
                                                    <?= @$institute['description'] ?>
                                                </p>
                                            </div>

                                            {{-- Button --}}
                                            <div class="d-flex gap-10">
                                                <button class="btn text-primary border-0 p-0 action-success"
                                                    onclick="mainModalOpen(`{{ route('student.edit.institute', [$key]) }}`)"><i
                                                        class="ri-pencil-line"></i></button>
                                                <button class="btn text-tertiary border-0 p-0 action-danger"
                                                    onclick="destroyFunction(`{{ route('student.delete.institute', [$key]) }}` )"><i
                                                        class="ri-delete-bin-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Educations end -->
                        </div>
                    </div>
                @elseif (url()->current() === route('student.setting', ['experiences']))
                    {{-- Experience Section --}}
                    <div class="tab-pane fade show active">
                        <div class="col-xl-12">
                            <div
                                class="small-tittle-two border-bottom d-flex align-items-center justify-content-between mb-20 pb-8">

                                <div class="country d-flex align-items-center mb-10">
                                    <i class="ri-briefcase-line"></i>
                                    <span
                                        class="country text-title font-600 ml-10">{{ ___('student.Experiences') }}</span>
                                </div>
                                <button class="btn-primary-outline mb-6"
                                    onclick="mainModalOpen(`{{ route('student.add.experience') }}`)"><i
                                        class="ri-add-line"></i> {{ ___('student.add new') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            @if (@$data['student']->experience)
                                @foreach (@$data['student']->experience as $key => $experience)
                                    <div class="col-xl-12">
                                        <div
                                            class="single-education mb-30 d-flex justify-content-between align-items-start">
                                            <div class="education-cap">
                                                <h4 class="text-18 text-tile mb-15">
                                                    <a href="#">
                                                        {{ @$experience['title'] }}
                                                    </a>
                                                </h4>
                                                <p class="pera text-primary mb-6">
                                                    {{ @$experience['name'] }} -
                                                    <span
                                                        class="text-title text-capitalize">{{ str_replace('_', ' ', @$experience['employee_type']) }}</span>

                                                </p>
                                                <p class="pera mb-6">
                                                    {{ date('M y', strtotime(@$experience['start_date'])) }} -
                                                    @if (@$experience['current'])
                                                        {{ ___('student.Present') }} .
                                                        {{ \Carbon\Carbon::parse(@$experience['start_date'])->diffForHumans() }}
                                                    @else
                                                        {{ date('M y', strtotime(@$experience['end_date'])) }}
                                                    @endif
                                                </p>
                                                <p class="pera mb-20">
                                                    {{ @$experience['location'] }}
                                                </p>
                                                <p class="pera mb-6">
                                                    <?= @$experience['description'] ?>
                                                </p>
                                            </div>

                                            {{-- Button --}}
                                            <div class="d-flex gap-10">
                                                <button class="btn text-primary border-0 p-0 action-success"
                                                    onclick="mainModalOpen(`{{ route('student.edit.experience', [$key]) }}`)"><i
                                                        class="ri-pencil-line"></i></button>
                                                <button class="btn text-tertiary border-0 p-0 action-danger"
                                                    onclick="destroyFunction(`{{ route('student.delete.experience', [$key]) }}` )"><i
                                                        class="ri-delete-bin-line"></i></button>
                                            </div>


                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Educations end -->
                        </div>
                    </div>
                    {{-- End Experiences --}}
                @elseif (url()->current() === route('student.setting', ['skills']))
                    <!-- Skills & Expertise -->
                    <div class="tab-pane fade show active">
                        <div class="row">
                            <div class="col-xl-12">
                                <!-- Title -->

                                <div class="col-xl-12">
                                    <div
                                        class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">

                                        <div class="country d-flex align-items-center ">
                                            <i class="ri-tools-line"></i>
                                            <span class="country text-title font-600 ml-10">
                                                {{ ___('student.Skills & Expertise') }}
                                            </span>
                                        </div>
                                        <button class="btn-primary-outline"
                                            onclick="mainModalOpen(`{{ route('student.add.skill') }}`)"><i
                                                class="ri-add-line"></i> {{ ___('student.add new') }}</button>
                                    </div>
                                </div>
                                <!-- add -->
                                <div class="single-education mb-30 d-flex justify-content-between align-items-start">
                                    <div class="tag-area3">
                                        <ul class="listing">
                                            @if (@$data['student']->skills)
                                                @foreach (@$data['student']->skills as $key => $skill)
                                                    <li class="single-list">{{ @$skill['value'] }}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    @if (@$data['student']->skills)
                                        <div class="d-flex gap-10">
                                            <button class="btn text-primary border-0 p-0 action-success"
                                                onclick="mainModalOpen(`{{ route('student.add.skill') }}`)"><i
                                                    class="ri-pencil-line"></i></button>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Skills & Expertise --}}
                @elseif (module('TwoFA') && setting('two_fa_setup') && url()->current() === route('student.setting', ['two_fa']))
                    <!-- Two-Factor-Authentication -->
                    @include('twofa::partials.student.settings_tab')
                    <!-- End Two-Factor-Authentication -->
                @endif
            </div>
            <!-- End-of Student Setting TAB -->

        </div>
    </div>
    <!-- end  -->

@endsection

@section('scripts')
    <script src="{{ asset('frontend/js/student/main.js') }}" type="module"></script>
@endsection
