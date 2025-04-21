@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])

@section('content')
    <!-- Content Wrapper -->
    <div class="row">
        <!-- Section Tittle -->
        <div class="col-xl-12">
            <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                <h2 class="title font-600 mb-20">{{ ___('instructor.Settings') }}</h2>
            </div>
        </div>
        <div class="col-xl-12">

            <!-- instructor Setting TAB -->
            <ul class="nav course-details-tabs setting-tab mb-40" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.setting', ['edit']) }}"
                        class="nav-link {{ url()->current() === route('instructor.setting', ['edit']) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-user-add-line"></i>
                        <span>{{ ___('instructor.Edit Profile') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.setting', ['security']) }}"
                        class="nav-link {{ url()->current() === route('instructor.setting', ['security']) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-lock-line"></i>
                        <span>{{ ___('instructor.Security') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.setting', ['educations']) }}"
                        class="nav-link {{ url()->current() === route('instructor.setting', ['educations']) ? 'active' : '' }} "
                        type="button" role="tab"> <i class="ri-book-open-line"></i>
                        <span>{{ ___('instructor.Educations') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.setting', ['experiences']) }}"
                        class="nav-link {{ url()->current() === route('instructor.setting', ['experiences']) ? 'active' : '' }} "
                        type="button"role="tab">
                        <i class="ri-open-arm-line"></i>
                        <span>{{ ___('instructor.Experiences') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('instructor.setting', ['skills']) }}"
                        class="nav-link {{ url()->current() === route('instructor.setting', ['skills']) ? 'active' : '' }} "
                        type="button" role="tab">
                        <i class="ri-tools-line"></i>
                        <span>{{ ___('instructor.Skills & Expertise') }}</span>
                    </a>
                </li>
                @if (module('LiveClass'))
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('instructor.setting', ['live-class']) }}"
                            class="nav-link {{ url()->current() === route('instructor.setting', ['live-class']) ? 'active' : '' }} "
                            type="button" role="tab">
                            <i class="ri-live-line"></i>
                            <span>{{ ___('instructor.Live_Class') }}</span>
                        </a>
                    </li>
                @endif
                @if (module('TwoFA') && setting('two_fa_setup'))
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('instructor.setting', ['two_fa']) }}" class="nav-link {{ url()->current() === route('instructor.setting', ['two_fa']) ? 'active' : '' }} "
                           type="button" role="tab"><i class="ri-shield-check-line"></i>
                            <span>{{ ___('instructor.Two Factor Authentication') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                @if (url()->current() === route('instructor.setting', ['edit']))
                    <div class="tab-pane fade show active">

                        <!-- General info start -->
                        <form action="{{ route('instructor.update_profile') }}" method="POST"
                            class="settings-general-info" enctype="multipart/form-data">
                            @csrf
                            <!-- Section Tittle -->
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <!-- Personal Info -->
                                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                                        <h4 class="title text-capitalize font-600">
                                            {{ ___('instructor.Personal Information') }}
                                        </h4>
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('instructor.Your Name') }} <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control ot-contact-input @error('name') is-invalid @enderror"
                                            type="text" name="name" value="{{ auth()->user()->name }}"
                                            placeholder="{{ ___('common.Name') }}">
                                        @error('name')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('instructor.Phone') }} <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control ot-contact-input @error('phone') is-invalid @enderror"
                                            type="string" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                            placeholder="{{ ___('instructor.Phone') }}">
                                        @error('phone')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('instructor.Date Of Birth') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input date-picker @error('date_of_birth') is-invalid @enderror"
                                            date-picker type="text" name="date_of_birth"
                                            value="{{ date_picker_format(@$data['instructor']->date_of_birth) }}"
                                            placeholder="{{ ___('instructor.Date Of Birth') }}">
                                        @error('date_of_birth')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('instructor.Gender') }} <span
                                                class="text-danger">*</span></label>
                                        <select class="select2 @error('gender') is-invalid @enderror" name="gender">
                                            <option value="{{ App\Enums\Gender::MALE }}"
                                                @if (@$data['instructor']->gender == App\Enums\Gender::MALE) {{ 'selected' }} @endif>
                                                {{ ___('instructor.Male') }}</option>
                                            <option value="{{ App\Enums\Gender::FEMALE }}"
                                                @if (@$data['instructor']->gender == App\Enums\Gender::FEMALE) {{ 'selected' }} @endif>
                                                {{ ___('instructor.Female') }}</option>
                                            <option value="{{ App\Enums\Gender::OTHERS }}"
                                                @if (@$data['instructor']->gender == App\Enums\Gender::OTHERS) {{ 'selected' }} @endif>
                                                {{ ___('instructor.Others') }}</option>
                                        </select>
                                        @error('gender')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <!-- Address -->
                                    <div class="small-tittle-two border-bottom mb-20 pb-8 pt-24">
                                        <h4 class="title text-capitalize font-600">{{ ___('instructor.Address') }}</h4>
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('instructor.address') }}</label>
                                        <input class="form-control ot-contact-input @error('address') is-invalid @enderror"
                                            type="text" name="address" value="{{ @$data['instructor']->address }}"
                                            placeholder="{{ ___('instructor.Enter your Address') }}">
                                        @error('address')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <div class="ot-contact-form">
                                            <label class="ot-contact-label">{{ ___('instructor.Country') }} <span
                                                    class="text-danger">*</span></label>
                                            <!-- Select2 -->
                                            <select class="country_list @error('country_id') is-invalid @enderror"
                                                name="country_id">
                                                <option value="">{{ ___('placeholder.Select Country') }}</option>
                                                @if (@$data['instructor']->country_id)
                                                    <option value="{{ @$data['instructor']->country_id }}" selected>
                                                        {{ @$data['instructor']->country->name }}</option>
                                                @endif
                                            </select>
                                            @error('country_id')
                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-6 col-lg-12">
                                    <!-- About My Self -->
                                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                                        <h4 class="title text-capitalize font-600">
                                            {{ ___('instructor.About Information') }}
                                        </h4>
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('instructor.Designation') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input @error('designation') is-invalid @enderror"
                                            type="text" name="designation"
                                            value="{{ @$data['instructor']->designation ?? old('designation') }}"
                                            placeholder="{{ ___('instructor.UI/UX Designer | Product Design | Mobile App Expert') }}">
                                        @error('designation')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('instructor.About') }}</label>
                                        <textarea class="ot-contact-textarea @error('about_me') is-invalid @enderror"
                                            placeholder="{{ ___('instructor.About My Self') }}" name="about_me" id="" rows="10">{{ @$data['instructor']->about_me ?? old('about_me') }}</textarea>
                                        @error('about_me')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- uplode image -->
                                    <div class="ot-contact-form mb-24">
                                        <label for="profile_image"
                                            class="form-label ">{{ ___('instructor.Profile Image') }}
                                        </label>
                                        <div @if ($data['instructor']->user->image) data-val="{{ showImage($data['instructor']->user->image->original) }}" @endif
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
                                    <div class="btn-wrapper">
                                        <button
                                            class="btn-primary-fill mt-6 mr-10">{{ ___('instructor.Save & Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- General info end -->

                    </div>
                @elseif (url()->current() === route('instructor.setting', ['security']))
                    <div class="tab-pane fade show active">
                        <!-- Security -->
                        <form action="{{ route('instructor.update_password') }}" class="Security" method="post">
                            @csrf
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                                        <h4 class="title text-capitalize font-600">{{ ___('instructor.Change Password') }}
                                        </h4>
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('instructor.Old Password') }} <span
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
                                        <label class="ot-contact-label">{{ ___('instructor.New Password') }} <span
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
                                        <label class="ot-contact-label">{{ ___('instructor.Re-Enter Password') }} <span
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
                                    <div class="btn-wrapper mt-20">
                                        <button class="btn-primary-fill">{{ ___('common.update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Security end -->
                    </div>
                @elseif (url()->current() === route('instructor.setting', ['educations']))
                    <div class="tab-pane fade show active">
                        <!-- Educations -->
                        <div class="col-xl-12">
                            <div
                                class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">

                                <div class="country d-flex align-items-center ">
                                    <i class="ri-book-open-line"></i>
                                    <span
                                        class="country text-title font-600 ml-10">{{ ___('instructor.Educations') }}</span>
                                </div>
                                <button class="btn-primary-outline"
                                    onclick="mainModalOpen(`{{ route('instructor.addInstitute') }}`)"><i
                                        class="ri-add-line"></i> {{ ___('instructor.add new') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            @if (@$data['instructor']->education)
                                @foreach (@$data['instructor']->education as $key => $institute)
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
                                                        {{ ___('instructor.Continue') }}
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
                                                    onclick="mainModalOpen(`{{ route('instructor.edit.institute', [$key]) }}`)"><i
                                                        class="ri-pencil-line"></i></button>
                                                <button class="btn text-tertiary border-0 p-0 action-danger"
                                                    onclick="destroyFunction(`{{ route('instructor.delete.institute', [$key]) }}` )"><i
                                                        class="ri-delete-bin-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Educations end -->
                        </div>
                    </div>
                @elseif (url()->current() === route('instructor.setting', ['experiences']))
                    {{-- Experience Section --}}
                    <div class="tab-pane fade show active">
                        <div class="col-xl-12">
                            <div
                                class="small-tittle-two border-bottom d-flex align-items-center justify-content-between mb-20 pb-8">

                                <div class="country d-flex align-items-center mb-10">
                                    <i class="ri-open-arm-line"></i>
                                    <span
                                        class="country text-title font-600 ml-10">{{ ___('instructor.Experiences') }}</span>
                                </div>
                                <button class="btn-primary-outline mb-6"
                                    onclick="mainModalOpen(`{{ route('instructor.add.experience') }}`)"><i
                                        class="ri-add-line"></i> {{ ___('instructor.add new') }}</button>
                            </div>
                        </div>
                        <div class="row">
                            @if (@$data['instructor']->experience)
                                @foreach (@$data['instructor']->experience as $key => $experience)
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
                                                        {{ ___('instructor.Present') }} .
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
                                                    onclick="mainModalOpen(`{{ route('instructor.edit.experience', [$key]) }}`)"><i
                                                        class="ri-pencil-line"></i></button>
                                                <button class="btn text-tertiary border-0 p-0 action-danger"
                                                    onclick="destroyFunction(`{{ route('instructor.delete.experience', [$key]) }}` )"><i
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
                @elseif (url()->current() === route('instructor.setting', ['skills']))
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
                                                {{ ___('instructor.Skills & Expertise') }}
                                            </span>
                                        </div>
                                        <button class="btn-primary-outline"
                                            onclick="mainModalOpen(`{{ route('instructor.add.skill') }}`)"><i
                                                class="ri-add-line"></i> {{ ___('instructor.add new') }}</button>
                                    </div>
                                </div>
                                <!-- add -->
                                <div class="single-education mb-30 d-flex justify-content-between align-items-start">
                                    <div class="tag-area3">
                                        <ul class="listing">
                                            @if (@$data['instructor']->skills)
                                                @foreach (@$data['instructor']->skills as $key => $skill)
                                                    <li class="single-list">{{ @$skill['value'] }}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="d-flex gap-10">
                                        <button class="btn text-primary border-0 p-0 action-success"
                                            onclick="mainModalOpen(`{{ route('instructor.add.skill') }}`)"><i
                                                class="ri-pencil-line"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Skills & Expertise --}}
                @elseif (module('LiveClass') && url()->current() === route('instructor.setting', ['live-class']))
                    <!-- live-class -->
                    <div class="tab-pane fade show active">
                        @if (module('ZoomMeeting'))
                            <form action="{{ route('frontend_zoom_live_class_settings.update') }}" method="POST"
                                class="settings-general-info" enctype="multipart/form-data">
                                @csrf
                                <!-- Section Tittle -->
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <!-- Personal Info -->
                                        <div class="small-tittle-two border-bottom mb-20 pb-8">
                                            <h4 class="title text-capitalize font-600">
                                                {{ ___('live_class.Zoom') }}
                                            </h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="ot-contact-form mb-24">
                                                    <label class="ot-contact-label">
                                                        {{ ___('live_class.Approval_Type') }}
                                                    </label>
                                                    <select
                                                        class="form-select ot-input select2 @error('approval_type') is-invalid @enderror"
                                                        id="approval_type" required name="approval_type">
                                                        <option value="0"
                                                            {{ @$data['user']->zoomSetting->approval_type == 0 ? 'selected' : '' }}>
                                                            {{ ___('live_class.Automatically') }}
                                                        </option>
                                                        <option
                                                            value="1"{{ old('approval_type', @$data['user']->zoomSetting->approval_type) == 1 ? 'selected' : '' }}>
                                                            {{ ___('live_class.Manually Approve') }}
                                                        </option>
                                                        <option value="2"
                                                            {{ old('approval_type', @$data['user']->zoomSetting->approval_type) == 2 ? 'selected' : '' }}>
                                                            {{ ___('live_class.No Registration Required') }}
                                                        </option>
                                                    </select>
                                                    @error('approval_type')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>

                                            </div>
                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="auto_recording"
                                                    class="form-label ">{{ ___('live_class.Auto Recording') }}</label>
                                                <select
                                                    class="form-select ot-input select2 @error('auto_recording') is-invalid @enderror"
                                                    id="auto_recording" required name="auto_recording">
                                                    <option value="none"
                                                        {{ old('auto_recording', @$data['user']->zoomSetting->auto_recording) == 'none' ? 'selected' : '' }}>
                                                        {{ ___('live_class.None') }}
                                                    </option>
                                                    <option
                                                        value="local"{{ old('auto_recording', @$data['user']->zoomSetting->auto_recording) == 'local' ? 'selected' : '' }}>
                                                        {{ ___('live_class.Local') }}
                                                    </option>
                                                    <option value="cloud"
                                                        {{ old('auto_recording', @$data['user']->zoomSetting->auto_recording) == 'cloud' ? 'selected' : '' }}>
                                                        {{ ___('live_class.Cloud') }}
                                                    </option>
                                                </select>
                                                @error('auto_recording')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="audio"
                                                    class="form-label ">{{ ___('live_class.Audio Options') }}</label>
                                                <select
                                                    class="form-select ot-input select2 @error('audio') is-invalid @enderror"
                                                    id="audio" required name="audio">
                                                    <option value="both"
                                                        {{ old('audio', @$data['user']->zoomSetting->audio) == 'both' ? 'selected' : '' }}>
                                                        {{ ___('live_class.Both') }}
                                                    </option>
                                                    <option value="telephony"
                                                        {{ old('audio', @$data['user']->zoomSetting->audio) == 'telephony' ? 'selected' : '' }}>
                                                        {{ ___('live_class.Telephony') }}
                                                    </option>
                                                    <option value="voip"
                                                        {{ old('audio', @$data['user']->zoomSetting->audio) == 'voip' ? 'selected' : '' }}>
                                                        {{ ___('live_class.Voip') }}
                                                    </option>
                                                </select>
                                                @error('audio')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="package_id"
                                                    class="form-label ">{{ ___('live_class.Package') }}</label>
                                                <select
                                                    class="form-select ot-input select2 @error('package_id') is-invalid @enderror"
                                                    id="package_id" required name="package_id">
                                                    <option value="1"
                                                        {{ old('package_id', @$data['user']->zoomSetting->package_id) == 1 ? 'selected' : '' }}>
                                                        {{ ___('live_class.Basic (Free)') }}
                                                    </option>
                                                    <option value="2"
                                                        {{ old('package_id', @$data['user']->zoomSetting->package_id) == 2 ? 'selected' : '' }}>
                                                        {{ ___('live_class.Pro') }}
                                                    </option>
                                                    <option
                                                        value="3"{{ old('package_id', @$data['user']->zoomSetting->package_id) == 3 ? 'selected' : '' }}>
                                                        {{ ___('live_class.Business') }}
                                                    </option>
                                                    <option value="4"
                                                        {{ old('package_id', @$data['user']->zoomSetting->package_id) == 4 ? 'selected' : '' }}>
                                                        {{ ___('live_class.Enterprise') }}
                                                    </option>
                                                </select>
                                                @error('package_id')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="host_video"
                                                    class="form-label ">{{ ___('live_class.Host Video') }}</label>
                                                <select
                                                    class="form-select ot-input select2 @error('host_video') is-invalid @enderror"
                                                    id="host_video" required name="host_video">
                                                    <option @if (@$data['user']->zoomSetting->host_video == '1') {{ 'selected' }} @endif
                                                        value="1">
                                                        {{ ___('common.Active') }}</option>
                                                    <option @if (@$data['user']->zoomSetting->host_video == '0') {{ 'selected' }} @endif
                                                        value="0">
                                                        {{ ___('common.Inactive') }}</option>
                                                </select>
                                                @error('host_video')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="participant_video"
                                                    class="form-label ">{{ ___('live_class.Participant Video') }}</label>
                                                <select
                                                    class="form-select ot-input select2 @error('participant_video') is-invalid @enderror"
                                                    id="participant_video" required name="participant_video">
                                                    <option @if (@$data['user']->zoomSetting->participant_video == '1') {{ 'selected' }} @endif
                                                        value="1">
                                                        {{ ___('common.Active') }}</option>
                                                    <option @if (@$data['user']->zoomSetting->participant_video == '0') {{ 'selected' }} @endif
                                                        value="0">
                                                        {{ ___('common.Inactive') }}</option>
                                                </select>
                                                @error('participant_video')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="join_before_host"
                                                    class="form-label ">{{ ___('live_class.Join Before Host') }}</label>
                                                <select
                                                    class="form-select ot-input select2 @error('join_before_host') is-invalid @enderror"
                                                    id="join_before_host" required name="join_before_host">
                                                    <option @if (@$data['user']->zoomSetting->join_before_host == '1') {{ 'selected' }} @endif
                                                        value="1">
                                                        {{ ___('common.Active') }}</option>
                                                    <option @if (@$data['user']->zoomSetting->join_before_host == '0') {{ 'selected' }} @endif
                                                        value="0">
                                                        {{ ___('common.Inactive') }}</option>
                                                </select>
                                                @error('join_before_host')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="waiting_room"
                                                    class="form-label ">{{ ___('live_class.Waiting Room') }}</label>
                                                <select
                                                    class="form-select ot-input select2 @error('waiting_room') is-invalid @enderror"
                                                    id="waiting_room" required name="waiting_room">
                                                    <option @if (@$data['user']->zoomSetting->waiting_room == '1') {{ 'selected' }} @endif
                                                        value="1">
                                                        {{ ___('common.Active') }}</option>
                                                    <option @if (@$data['user']->zoomSetting->waiting_room == '0') {{ 'selected' }} @endif
                                                        value="0">
                                                        {{ ___('common.Inactive') }}</option>
                                                </select>
                                                @error('waiting_room')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="mute_upon_entry"
                                                    class="form-label ">{{ ___('live_class.Mute Upon Entry') }}</label>
                                                <select
                                                    class="form-select ot-input select2 @error('mute_upon_entry') is-invalid @enderror"
                                                    id="mute_upon_entry" required name="mute_upon_entry">
                                                    <option @if (@$data['user']->zoomSetting->mute_upon_entry == '1') {{ 'selected' }} @endif
                                                        value="1">
                                                        {{ ___('common.Active') }}</option>
                                                    <option @if (@$data['user']->zoomSetting->mute_upon_entry == '0') {{ 'selected' }} @endif
                                                        value="0">
                                                        {{ ___('common.Inactive') }}</option>
                                                </select>
                                                @error('mute_upon_entry')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="account_id" class="form-label ">
                                                    {{ ___('live_class.Zoom_Account_ID') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input
                                                    class="form-control ot-input @error('account_id') is-invalid @enderror"
                                                    name="account_id" list="datalistOptions" id="account_id"
                                                    placeholder="{{ ___('placeholder.Enter Zoom_account_id') }}"
                                                    value="{{ @$data['user']->zoomSetting->account_id ?? old('account_id') }}">
                                                @error('account_id')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="client_id" class="form-label ">
                                                    {{ ___('live_class.Zoom_Client_ID') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input
                                                    class="form-control ot-input @error('client_id') is-invalid @enderror"
                                                    name="client_id" list="datalistOptions" id="client_id"
                                                    placeholder="{{ ___('placeholder.Enter Zoom_client_id') }}"
                                                    value="{{ @$data['user']->zoomSetting->client_id ?? old('client_id') }}">
                                                @error('client_id')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-6 col-md-6 mb-3">
                                                <label for="client_secret" class="form-label ">
                                                    {{ ___('common.Zoom_Secret_ID') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input
                                                    class="form-control ot-input @error('client_secret') is-invalid @enderror"
                                                    name="client_secret" list="datalistOptions" id="client_secret"
                                                    placeholder="{{ ___('placeholder.Enter_zoom_client_secret') }}"
                                                    value="{{ @$data['user']->zoomSetting->client_secret ?? old('client_secret') }}">
                                                @error('client_secret')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>


                                    </div>
                                    <!-- Switch Box -->
                                    <div class="col-lg-12">
                                        <div class="btn-wrapper">
                                            <button
                                                class="btn-primary-fill mt-6 mr-10">{{ ___('instructor.Save & Update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                    {{-- End live-class --}}
                @elseif (module('TwoFA') && setting('two_fa_setup') && url()->current() === route('instructor.setting', ['two_fa']))
                    <!-- Two-Factor-Authentication -->
                    @include('twofa::partials.instructor.settings_tab')
                    <!-- End Two-Factor-Authentication -->
                @endif
            </div>
            <!-- End-of instructor Setting TAB -->
        </div>
    </div>
    <!-- end  -->
@endsection

@section('scripts')
@endsection
