@extends('organization::panel.organization.layouts.master')
@section('title', @$data['title'])

@section('content')
    <!-- Content Wrapper -->
    <div class="row">
        <!-- Section Tittle -->
        <div class="col-xl-12">
            <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                <h2 class="title font-600 mb-20">{{ ___('organization.Settings') }}</h2>
            </div>
        </div>
        <div class="col-xl-12">
            <!-- organization Setting TAB -->
            <ul class="nav course-details-tabs setting-tab mb-40" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.setting', ['edit']) }}"
                        class="nav-link {{ url()->current() === route('organization.setting', ['edit']) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-user-add-line"></i>
                        <span>{{ ___('organization.Edit Profile') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.setting', ['security']) }}"
                        class="nav-link {{ url()->current() === route('organization.setting', ['security']) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-lock-line"></i>
                        <span>{{ ___('organization.Security') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.setting', ['skills']) }}"
                        class="nav-link {{ url()->current() === route('organization.setting', ['skills']) ? 'active' : '' }} "
                        type="button" role="tab">
                        <i class="ri-tools-line"></i>
                        <span>{{ ___('organization.Skills & Expertise') }}</span>
                    </a>
                </li>
                @if (module('LiveClass'))
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('organization.setting', ['live-class']) }}"
                            class="nav-link {{ url()->current() === route('organization.setting', ['live-class']) ? 'active' : '' }} "
                            type="button" role="tab">
                            <i class="ri-live-line"></i>
                            <span>{{ ___('organization.Live_Class') }}</span>
                        </a>
                    </li>
                @endif
                @if (module('TwoFA') && setting('two_fa_setup'))
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('organization.setting', ['two_fa']) }}" class="nav-link {{ url()->current() === route('organization.setting', ['two_fa']) ? 'active' : '' }} "
                           type="button" role="tab"><i class="ri-shield-check-line"></i>
                            <span>{{ ___('organization.Two Factor Authentication') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
            <div class="tab-content" id="myTabContent">
                @if (url()->current() === route('organization.setting', ['edit']))
                    <div class="tab-pane fade show active">
                        <!-- General info start -->
                        <form action="{{ route('organization.update_profile') }}" method="POST"
                            class="settings-general-info" enctype="multipart/form-data">
                            @csrf
                            <!-- Section Tittle -->
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">
                                    <!-- Personal Info -->
                                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                                        <h4 class="title text-capitalize font-600">
                                            {{ ___('organization.Personal Information') }}
                                        </h4>
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('organization.Your Name') }} <span
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
                                        <label class="ot-contact-label">{{ ___('organization.Phone') }} <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control ot-contact-input @error('phone') is-invalid @enderror"
                                            type="string" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                            placeholder="{{ ___('organization.Phone') }}">
                                        @error('phone')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('organization.Date Of Birth') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input date-picker @error('date_of_birth') is-invalid @enderror"
                                            date-picker type="text" name="date_of_birth"
                                            value="{{ date_picker_format(@$data['organization']->date_of_birth) }}"
                                            placeholder="{{ ___('organization.Date Of Birth') }}">
                                        @error('date_of_birth')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('organization.Gender') }} <span
                                                class="text-danger">*</span></label>
                                        <select class="select2 @error('gender') is-invalid @enderror" name="gender">
                                            <option value="{{ App\Enums\Gender::MALE }}"
                                                @if (@$data['organization']->gender == App\Enums\Gender::MALE) {{ 'selected' }} @endif>
                                                {{ ___('organization.Male') }}</option>
                                            <option value="{{ App\Enums\Gender::FEMALE }}"
                                                @if (@$data['organization']->gender == App\Enums\Gender::FEMALE) {{ 'selected' }} @endif>
                                                {{ ___('organization.Female') }}</option>
                                            <option value="{{ App\Enums\Gender::OTHERS }}"
                                                @if (@$data['organization']->gender == App\Enums\Gender::OTHERS) {{ 'selected' }} @endif>
                                                {{ ___('organization.Others') }}</option>
                                        </select>
                                        @error('gender')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <!-- Address -->
                                    <div class="small-tittle-two border-bottom mb-20 pb-8 pt-24">
                                        <h4 class="title text-capitalize font-600">{{ ___('organization.Address') }}</h4>
                                    </div>
                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('organization.address') }}</label>
                                        <input class="form-control ot-contact-input @error('address') is-invalid @enderror"
                                            type="text" name="address" value="{{ @$data['organization']->address }}"
                                            placeholder="{{ ___('organization.Enter your Address') }}">
                                        @error('address')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <div class="ot-contact-form">
                                            <label class="ot-contact-label">{{ ___('organization.Country') }} <span
                                                    class="text-danger">*</span></label>
                                            <!-- Select2 -->
                                            <select class="country_list @error('country_id') is-invalid @enderror"
                                                name="country_id">
                                                <option value="">{{ ___('placeholder.Select Country') }}</option>
                                                @if (@$data['organization']->country_id)
                                                    <option value="{{ @$data['organization']->country_id }}" selected>
                                                        {{ @$data['organization']->country->name }}</option>
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
                                            {{ ___('organization.About Information') }}
                                        </h4>
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('organization.Designation') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input @error('designation') is-invalid @enderror"
                                            type="text" name="designation"
                                            value="{{ @$data['organization']->designation ?? old('designation') }}"
                                            placeholder="{{ ___('organization.UI/UX Designer | Product Design | Mobile App Expert') }}">
                                        @error('designation')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('organization.About') }}</label>
                                        <textarea class="ot-contact-textarea @error('about_me') is-invalid @enderror"
                                            placeholder="{{ ___('organization.About My Self') }}" name="about_me" id="" rows="10">{{ @$data['organization']->about_me ?? old('about_me') }}</textarea>
                                        @error('about_me')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- uplode image -->
                                    <div class="ot-contact-form mb-24">
                                        <label for="profile_image"
                                            class="form-label ">{{ ___('organization.Profile Image') }}
                                        </label>
                                        <div @if ($data['organization']->user->image) data-val="{{ showImage($data['organization']->user->image->original) }}" @endif
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
                                            class="btn-primary-fill mt-6 mr-10">{{ ___('organization.Save & Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- General info end -->

                    </div>
                @elseif (url()->current() === route('organization.setting', ['security']))
                    <div class="tab-pane fade show active">
                        <!-- Security -->
                        <form action="{{ route('organization.update_password') }}" class="Security" method="post">
                            @csrf
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                                        <h4 class="title text-capitalize font-600">{{ ___('organization.Change Password') }}
                                        </h4>
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('organization.Old Password') }} <span
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
                                        <label class="ot-contact-label">{{ ___('organization.New Password') }} <span
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
                                        <label class="ot-contact-label">{{ ___('organization.Re-Enter Password') }} <span
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


                @elseif (url()->current() === route('organization.setting', ['skills']))
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
                                                {{ ___('organization.Skills & Expertise') }}
                                            </span>
                                        </div>
                                        <button class="btn-primary-outline"
                                            onclick="mainModalOpen(`{{ route('organization.add.skill') }}`)"><i
                                                class="ri-add-line"></i> {{ ___('organization.add new') }}</button>
                                    </div>
                                </div>
                                <!-- add -->
                                <div class="single-education mb-30 d-flex justify-content-between align-items-start">
                                    <div class="tag-area3">
                                        <ul class="listing">
                                            @if (@$data['organization']->skills)
                                                @foreach (@$data['organization']->skills as $key => $skill)
                                                    <li class="single-list">{{ @$skill['value'] }}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="d-flex gap-10">
                                        <button class="btn text-primary border-0 p-0 action-success"
                                            onclick="mainModalOpen(`{{ route('organization.add.skill') }}`)"><i
                                                class="ri-pencil-line"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Skills & Expertise --}}
                @elseif (module('LiveClass') && url()->current() === route('organization.setting', ['live-class']))
                    <!-- live-class -->
                    <div class="tab-pane fade show active">
                        @if (module('ZoomMeeting'))
                            <form action="{{ route('organization.frontend_zoom_live_class_settings.update') }}" method="POST"
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
                                                class="btn-primary-fill mt-6 mr-10">{{ ___('organization.Save & Update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                    {{-- End live-class --}}
                @elseif (module('TwoFA') && setting('two_fa_setup') && url()->current() === route('organization.setting', ['two_fa']))
                    <!-- Two-Factor-Authentication -->
                    @include('twofa::partials.organization.settings_tab')
                    <!-- End Two-Factor-Authentication -->
                @endif
            </div>
            <!-- End-of organization Setting TAB -->
        </div>
    </div>
    <!-- end  -->
@endsection

@section('scripts')
@endsection
