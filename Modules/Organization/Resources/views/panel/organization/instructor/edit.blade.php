@extends('organization::panel.organization.layouts.master')
@section('title', @$data['title'])

@section('content')
    <!-- Content Wrapper -->
    <div class="row">
        <!-- Section Tittle -->
        <div class="col-xl-12">
            <div class="section-tittle-two d-flex align-items-center justify-content-between flex-wrap mb-10">
                <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
            </div>
        </div>
        <div class="col-xl-12">

            <!-- instructor Setting TAB -->
            <ul class="nav course-details-tabs setting-tab mb-40" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.instructor.edit', [$data['user_id'], 'general']) }}"
                        class="nav-link {{ url()->current() === route('organization.instructor.edit', [$data['user_id'], 'general']) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-user-add-line"></i>
                        <span>{{ ___('organization.Edit Profile') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.instructor.edit', [$data['user_id'], 'security']) }}"
                        class="nav-link {{ url()->current() === route('organization.instructor.edit', [$data['user_id'], 'security']) ? 'active' : '' }}"
                        type="button" role="tab">
                        <i class="ri-lock-line"></i>
                        <span>{{ ___('organization.Security') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.instructor.edit', [$data['user_id'], 'educations']) }}"
                        class="nav-link {{ url()->current() === route('organization.instructor.edit', [$data['user_id'], 'educations']) ? 'active' : '' }} "
                        type="button" role="tab"> <i class="ri-book-open-line"></i>
                        <span>{{ ___('organization.Educations') }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.instructor.edit', [$data['user_id'], 'experiences']) }}"
                        class="nav-link {{ url()->current() === route('organization.instructor.edit', [$data['user_id'], 'experiences']) ? 'active' : '' }} "
                        type="button"role="tab">
                        <i class="ri-open-arm-line"></i>
                        <span>{{ ___('organization.Experiences') }} </span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('organization.instructor.edit', [$data['user_id'], 'skills']) }}"
                        class="nav-link {{ url()->current() === route('organization.instructor.edit', [$data['user_id'], 'skills']) ? 'active' : '' }} "
                        type="button" role="tab">
                        <i class="ri-tools-line"></i>
                        <span>{{ ___('organization.Skills & Expertise') }}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                @if (url()->current() === route('organization.instructor.edit', [$data['user_id'], 'general']))
                    <div class="tab-pane fade show active">
                        <!-- General info start -->
                        <form action="{{ route('organization.instructor.update_profile', $data['user_id']) }}" method="POST"
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
                                            type="text" name="name" value="{{ @$data['instructor']->user->name }}"
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
                                            type="string" name="phone" value="{{ @$data['instructor']->user->phone ?? '' }}"
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
                                            value="{{ date_picker_format(@$data['instructor']->date_of_birth) }}"
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
                                                @if (@$data['instructor']->gender == App\Enums\Gender::MALE) {{ 'selected' }} @endif>
                                                {{ ___('organization.Male') }}</option>
                                            <option value="{{ App\Enums\Gender::FEMALE }}"
                                                @if (@$data['instructor']->gender == App\Enums\Gender::FEMALE) {{ 'selected' }} @endif>
                                                {{ ___('organization.Female') }}</option>
                                            <option value="{{ App\Enums\Gender::OTHERS }}"
                                                @if (@$data['instructor']->gender == App\Enums\Gender::OTHERS) {{ 'selected' }} @endif>
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
                                            type="text" name="address" value="{{ @$data['instructor']->address }}"
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
                                            {{ ___('organization.About Information') }}
                                        </h4>
                                    </div>

                                    <div class="ot-contact-form mb-24">
                                        <label class="ot-contact-label">{{ ___('organization.Designation') }} <span
                                                class="text-danger">*</span></label>
                                        <input
                                            class="form-control ot-contact-input @error('designation') is-invalid @enderror"
                                            type="text" name="designation"
                                            value="{{ @$data['instructor']->designation ?? old('designation') }}"
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
                                            placeholder="{{ ___('organization.About My Self') }}" name="about_me" id="" rows="10">{{ @$data['instructor']->about_me ?? old('about_me') }}</textarea>
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
                                            class="btn-primary-fill mt-6 mr-10">{{ ___('organization.Save & Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- General info end -->

                    </div>
                @elseif (url()->current() === route('organization.instructor.edit', [$data['user_id'], 'security']))
                    <div class="tab-pane fade show active">
                        <!-- Security -->
                        <form action="{{ route('organization.instructor.update_password', $data['user_id']) }}" class="Security" method="post">
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
                @elseif (url()->current() === route('organization.instructor.edit', [$data['user_id'], 'educations']))
                    <div class="tab-pane fade show active">
                        <!-- Educations -->
                        <div class="col-xl-12">
                            <div
                                class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">

                                <div class="country d-flex align-items-center ">
                                    <i class="ri-book-open-line"></i>
                                    <span
                                        class="country text-title font-600 ml-10">{{ ___('organization.Educations') }}</span>
                                </div>
                                <button class="btn-primary-outline"
                                    onclick="mainModalOpen(`{{ route('organization.instructor.addInstitute', $data['user_id']) }}`)"><i
                                        class="ri-add-line"></i> {{ ___('organization.add new') }}</button>
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
                                                        {{ ___('organization.Continue') }}
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
                                                    onclick="mainModalOpen(`{{ route('organization.instructor.edit.institute', [$key, $data['user_id']]) }}`)"><i
                                                        class="ri-pencil-line"></i></button>
                                                <button class="btn text-tertiary border-0 p-0 action-danger"
                                                    onclick="destroyFunction(`{{ route('organization.instructor.delete.institute', [$key, $data['user_id']]) }}` )"><i
                                                        class="ri-delete-bin-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Educations end -->
                        </div>
                    </div>
                @elseif (url()->current() === route('organization.instructor.edit', [$data['user_id'], 'experiences']))
                    {{-- Experience Section --}}
                    <div class="tab-pane fade show active">
                        <div class="col-xl-12">
                            <div
                                class="small-tittle-two border-bottom d-flex align-items-center justify-content-between mb-20 pb-8">

                                <div class="country d-flex align-items-center mb-10">
                                    <i class="ri-open-arm-line"></i>
                                    <span
                                        class="country text-title font-600 ml-10">{{ ___('organization.Experiences') }}</span>
                                </div>
                                <button class="btn-primary-outline mb-6"
                                    onclick="mainModalOpen(`{{ route('organization.instructor.add.experience', $data['user_id']) }}`)"><i
                                        class="ri-add-line"></i> {{ ___('organization.add new') }}</button>
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
                                                        {{ ___('organization.Present') }} .
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
                                                    onclick="mainModalOpen(`{{ route('organization.instructor.edit.experience', [$key, $data['user_id']]) }}`)"><i
                                                        class="ri-pencil-line"></i></button>
                                                <button class="btn text-tertiary border-0 p-0 action-danger"
                                                    onclick="destroyFunction(`{{ route('organization.instructor.delete.experience', [$key, $data['user_id']]) }}` )"><i
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
                @elseif (url()->current() === route('organization.instructor.edit', [$data['user_id'], 'skills']))
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
                                            onclick="mainModalOpen(`{{ route('organization.instructor.add.skill', $data['user_id']) }}`)"><i
                                                class="ri-add-line"></i> {{ ___('organization.add new') }}</button>
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
                                            onclick="mainModalOpen(`{{ route('organization.instructor.add.skill', $data['user_id']) }}`)"><i
                                                class="ri-pencil-line"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- End Skills & Expertise --}}
                @endif
            </div>
            <!-- End-of instructor Setting TAB -->
        </div>
    </div>
    <!-- end  -->
@endsection

@section('scripts')
@endsection
