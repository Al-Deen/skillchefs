@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
    <div class="page-content">

        {{-- breadecrumb Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                '#' => @$data['title'],
            ],

            'buttons' => 1,
        ])
        {{-- breadecrumb Area E n d --}}

        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('settings.general-settings') }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    <div class="row mb-3">

                        <div class="col-lg-12 mb-20">
                            <div class="card-header">
                                <h4>{{ ___('settings.General') }}</h4>
                            </div>
                        </div>
                        <!--Application Name Start -->
                        <div class="col-md-6 col-xl-6 col-lg-6 mb-3">
                            <label for="inputname" class="form-label">{{ ___('settings.application_name') }} <span
                                    class="fillable">*</span></label>
                            <input type="text" name="application_name"
                                class="form-control ot-input @error('application_name') is-invalid @enderror"
                                value="{{ Setting('application_name') }}"
                                placeholder="{{ ___('settings.enter_you_application_name') }}">
                            @error('application_name')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!--Application Name End -->

                        <!--application_details Start -->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="inputname" class="form-label">{{ ___('settings.footer_text') }} <span
                                    class="fillable">*</span></label>
                            <input type="text" name="footer_text"
                                class="form-control ot-input @error('footer_text') is-invalid @enderror"
                                value="{{ Setting('footer_text') }}"
                                placeholder="{{ ___('settings.enter_your_footer_text') }}">
                            @error('footer_text')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!--application_details Start -->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="application_details" class="form-label">{{ ___('settings.Application_Details') }}
                                <span class="fillable">*</span></label>
                            <textarea name="application_details"
                                class="ot-textarea form-control  @error('application_details') is-invalid @enderror" id="application_details"
                                cols="5" rows="5">{{ Setting('application_details') }}</textarea>
                            @error('application_details')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class=" col-md-6 col-xl-6 mb-3 ">
                            <label for="application_map" class="form-label">{{ ___('settings.Application_Map_Address') }}
                                <span class="fillable">*</span></label>
                            <textarea name="application_map" class="ot-textarea form-control  @error('application_map') is-invalid @enderror"
                                id="application_map" cols="5" rows="5">{{ Setting('application_map') }}</textarea>
                            @error('application_map')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>






                        <!--White Logo Start -->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3">
                            <label class="form-label" for="light_logo">{{ ___('settings.Logo') }} </label>
                            {{-- File Uplode --}}
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control" type="text" placeholder="{{ ___('settings.browse_logo') }}"
                                    readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="fileBrouse">{{ ___('common.browse') }}</label>
                                    <input type="file" class="d-none form-control" name="light_logo" id="fileBrouse"
                                        accept="image/*">
                                </button>
                            </div>
                        </div>
                        <!--White Logo End -->

                        <!--White Logo Start -->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3">
                            <label class="form-label" for="dark_logo">{{ ___('settings.Dark Logo') }} </label>
                            {{-- File Uplode --}}
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control" type="text" placeholder="{{ ___('settings.browse_logo') }}"
                                    readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="fileBrouse2">{{ ___('common.browse') }}</label>
                                    <input type="file" class="d-none form-control" name="dark_logo" id="fileBrouse2"
                                        accept="image/*">
                                </button>
                            </div>
                        </div>
                        <!--White Logo End -->

                        <!--Favicon Start -->
                        <div class="col-md-6 favicon-uploader">
                            <div class="d-flex flex-column">
                                <label class="form-label" for="favicon">{{ ___('settings.favicon') }}</label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control" type="text"
                                        placeholder="{{ ___('settings.browse_favicon') }}" readonly=""
                                        id="placeholder3">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="btn btn-lg ot-btn-primary"
                                            for="fileBrouse3">{{ ___('common.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="favicon" id="fileBrouse3"
                                            accept="image/*">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--Favicon End -->
                        <!-- Default Langauge Start-->
                        <div class="col-md-6 default-langauge mb-3">
                            <div class="d-flex flex-column">
                                <label for="default langauge" class="form-label">{{ ___('settings.default_language') }}
                                    <span class="fillable">*</span></label>
                                <select name="default_language" id="defaultlangaugeId"
                                    class="form-select ot-input select2 @error('default_language') is-invalid @enderror">

                                    @foreach ($data['languages'] as $row)
                                        <option value="{{ $row->code }}" data-icon="{{ $row->icon_class }}"
                                            {{ Setting('default_language') == $row->code ? 'selected' : '' }}>
                                            {{ $row->name }}</option>
                                    @endforeach
                                    </option>

                                </select>
                            </div>
                        </div>
                        <!-- Default Langauge End-->

                        <!-- date_formats Start-->
                        <div class="col-md-6 default-langauge mb-3">
                            <div class="d-flex flex-column">
                                <label for="date_formats" class="form-label">{{ ___('settings.date_formats') }}
                                    <span class="fillable">*</span></label>
                                <select name="date_formats" id="date_formats"
                                    class="form-select ot-input select2 @error('date_formats') is-invalid @enderror">
                                    @foreach ($data['date_formats'] as $key => $date_format)
                                        <option value="{{ $date_format->format }}"
                                            {{ Setting('date_formats') == $date_format->format ? 'selected' : '' }}>
                                            {{ $date_format->format }}
                                        </option>
                                    @endforeach
                                    </option>

                                </select>
                            </div>
                        </div>
                        <!-- date_formats End-->

                        <!-- Currency Start-->
                        <div class="col-md-6 default-langauge mb-3">
                            <div class="d-flex flex-column">
                                <label for="currency" class="form-label">{{ ___('settings.currency') }}
                                    <span class="fillable">*</span></label>
                                <select name="currency" id="currency"
                                    class="form-select ot-input select2 @error('currency') is-invalid @enderror">
                                    @foreach ($data['currencies'] as $key => $currency)
                                        <option value="{{ $currency->code }}"
                                            {{ Setting('currency') == $currency->code ? 'selected' : '' }}>
                                            {{ $currency->name }} ({{ @$currency->symbol }})
                                        </option>
                                    @endforeach
                                    </option>

                                </select>
                            </div>
                        </div>
                        <!-- Currency End-->

                        <!-- country Start-->
                        <div class="col-md-6 default-langauge mb-3">
                            <div class="d-flex flex-column">
                                <label for="country" class="form-label">{{ ___('settings.country') }}
                                    <span class="fillable">*</span></label>
                                <select name="country" id="country"
                                    class="form-select ot-input select2 @error('country') is-invalid @enderror">
                                    @foreach ($data['countries'] as $key => $country)
                                        <option value="{{ $country->name }}"
                                            {{ setting('country') == $country->name ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                    </option>

                                </select>
                            </div>
                        </div>
                        <!-- country End-->

                        <!-- Timezone Start-->
                        <div class="col-md-6 default-langauge mb-3">
                            <div class="d-flex flex-column">
                                <label for="timezone" class="form-label">{{ ___('settings.timezone') }}
                                    <span class="fillable">*</span></label>
                                <select name="timezone" id="timezone"
                                    class="form-select ot-input select2 @error('timezone') is-invalid @enderror">
                                    @foreach ($data['timezones'] as $key => $timezone)
                                        <option value="{{ $timezone }}"
                                            {{ (setting('timezone') ?? config('app.timezone')) == $timezone ? 'selected' : '' }}>
                                            {{ $timezone }}
                                        </option>
                                    @endforeach
                                    </option>

                                </select>
                            </div>
                        </div>
                        <!-- Timezone End-->



                        <!-- Email Address Start-->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="email_address" class="form-label">{{ ___('settings.Email_Address') }} <span
                                    class="fillable">*</span></label>
                            <input type="email" name="email_address"
                                class="form-control ot-input @error('email_address') is-invalid @enderror"
                                value="{{ Setting('email_address') }}"
                                placeholder="{{ ___('settings.enter_contact_email_address') }}">
                            @error('email_address')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Email Address End -->
                        <!-- Office Address Start-->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="office_address" class="form-label">{{ ___('settings.Office_Address') }} <span
                                    class="fillable">*</span></label>
                            <input type="text" name="office_address"
                                class="form-control ot-input @error('office_address') is-invalid @enderror"
                                value="{{ Setting('office_address') }}"
                                placeholder="{{ ___('settings.enter_contact_office_address') }}">
                            @error('office_address')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Office Address End -->

                        <!-- Phone Number Start-->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="phone_number" class="form-label">{{ ___('settings.Phone_Number') }} <span
                                    class="fillable">*</span></label>
                            <input type="text" name="phone_number"
                                class="form-control ot-input @error('phone_number') is-invalid @enderror"
                                value="{{ Setting('phone_number') }}"
                                placeholder="{{ ___('settings.enter_contact_phone_number') }}">
                            @error('phone_number')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Phone Number End -->
                        <!-- Office Time Start-->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="office_hours" class="form-label">{{ ___('settings.Office_Hours') }} <span
                                    class="fillable">*</span></label>
                            <input type="text" name="office_hours"
                                class="form-control ot-input @error('office_hours') is-invalid @enderror"
                                value="{{ Setting('office_hours') }}"
                                placeholder="{{ ___('settings.enter_contact_office_hours') }}">
                            @error('office_hours')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Office Time End -->
                        <!-- Open AI key Start-->
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="OPEN_AI_KEY" class="form-label">{{ ___('settings.OPEN_AI_KEY') }} </label>
                            <input type="text" name="OPEN_AI_KEY"
                                class="form-control ot-input @error('OPEN_AI_KEY') is-invalid @enderror"
                                value="{{ Setting('OPEN_AI_KEY') }}"
                                placeholder="{{ ___('settings.enter_OPEN_AI_KEY') }}">
                            @error('OPEN_AI_KEY')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Open AI key End -->

                        <!--empty_table Start -->
                        <div class="col-md-6 favicon-uploader">
                            <div class="d-flex flex-column">
                                <label class="form-label" for="empty_table">{{ ___('settings.Empty_Table') }}</label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control" type="text" placeholder="{{ ___('common.browse') }}"
                                        readonly="" id="placeholder4">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="btn btn-lg ot-btn-primary"
                                            for="fileBrouse4">{{ ___('common.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="empty_table"
                                            id="fileBrouse4" accept="image/*">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--empty_table End -->

                        <!-- Payment Gateway Start-->
                        <div class="col-md-6 default-langauge mb-3">
                            <div class="d-flex flex-column">
                                <label for="payment_gateway" class="form-label">{{ ___('settings.Payment Gateway') }}
                                    <span class="fillable">*</span></label>
                                <select name="payment_gateway" id="payment_gateway"
                                    class="form-select ot-input select2 @error('payment_gateway') is-invalid @enderror">
                                        <option value="1"
                                            {{ Setting('payment_gateway') == true ? 'selected' : '' }}>
                                            On
                                        </option>
                                        <option value="0"
                                            {{ Setting('payment_gateway') == false ? 'selected' : '' }}>
                                            Off
                                        </option>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- Payment Gateway End-->
                    </div>



                    <div class="row mb-3">
                        <div class="col-lg-12 mb-20">
                            <div class="card-header">
                                <h4>{{ ___('settings.Signup with OTP verification') }}</h4>
                            </div>
                        </div>
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_primary" class="form-label">{{ ___('settings.Instructor account') }}</label>
                            <select name="instructor_otp_verification" id="instructor_otp_verification"
                                    class="form-select ot-input select2 @error('instructor_otp_verification') is-invalid @enderror">
                                    <option value="0"{{ Setting('instructor_otp_verification') === "0" ? 'selected' : '' }}>{{ ___('settings.None')}}</option>
                                    <option value="1"{{ Setting('instructor_otp_verification') === "1" ? 'selected' : '' }}>{{ ___('settings.Email')}}</option>
                                    <option value="2"{{ Setting('instructor_otp_verification') === "2" ? 'selected' : '' }}>{{ ___('settings.SMS')}}</option>
                                    <option value="3"{{ Setting('instructor_otp_verification') === "3" ? 'selected' : '' }}>{{ ___('settings.Both')}}</option>
                                </option>
                            </select>
                        </div>
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_primary" class="form-label">{{ ___('settings.Student account') }}</label>
                            <select name="student_otp_verification" id="student_otp_verification"
                                    class="form-select ot-input select2 @error('student_otp_verification') is-invalid @enderror">
                                    <option value="0"{{ Setting('student_otp_verification') === "0" ? 'selected' : '' }}>{{ ___('settings.None')}}</option>
                                    <option value="1"{{ Setting('student_otp_verification') === "1" ? 'selected' : '' }}>{{ ___('settings.Email')}}</option>
                                    <option value="2"{{ Setting('student_otp_verification') === "2" ? 'selected' : '' }}>{{ ___('settings.SMS')}}</option>
                                    <option value="3"{{ Setting('student_otp_verification') === "3" ? 'selected' : '' }}>{{ ___('settings.Both')}}</option>
                                </option>
                            </select>
                        </div>
                    </div>



                    <div class="row mb-3">

                        <div class="col-lg-12 mb-20">
                            <div class="card-header">
                                <h4>{{ ___('settings.Theme') }} <small>({{ ___('settings.Dark_mode') }}) -
                                        {{ ___('settings.Frontend') }}</small></h4>
                            </div>
                        </div>

                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_primary" class="form-label">{{ ___('settings.Primary_Color') }}</label>
                            <input type="text" name="ot_primary" placeholder="{{ ___('settings.Primary_Color') }}"
                                value="{{ Setting('ot_primary') }}"
                                class="form-control ot-input @error('ot_primary') is-invalid @enderror">
                            @error('ot_primary')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_primary_rgb"
                                class="form-label">{{ ___('settings.Primary_Color_RGB') }}</label>
                            <input type="text" name="ot_primary_rgb"
                                placeholder="{{ ___('settings.Primary_color_rgb') }}"
                                value="{{ Setting('ot_primary_rgb') }}"
                                class="form-control ot-input @error('ot_primary_rgb') is-invalid @enderror">
                            @error('ot_primary_rgb')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_secondary" class="form-label">{{ ___('settings.Secondary_color') }}</label>
                            <input type="text" name="ot_secondary" value="{{ Setting('ot_secondary') }}"
                                placeholder="{{ ___('settings.Secondary_color') }}"
                                class="form-control ot-input @error('ot_secondary') is-invalid @enderror">
                            @error('ot_secondary')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_secondary_rgb"
                                class="form-label">{{ ___('settings.Secondary_Color_RGB') }}</label>
                            <input type="text" name="ot_secondary_rgb" value="{{ Setting('ot_secondary_rgb') }}"
                                placeholder="{{ ___('settings.Secondary_Color_RGB') }}"
                                class="form-control ot-input @error('ot_secondary_rgb') is-invalid @enderror">
                            @error('ot_secondary_rgb')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_tertiary" class="form-label">{{ ___('settings.Tertiary_color') }}</label>
                            <input type="text" name="ot_tertiary" placeholder="{{ ___('settings.Tertiary_color') }}"
                                value="{{ Setting('ot_tertiary') }}"
                                class="form-control ot-input @error('ot_tertiary') is-invalid @enderror">
                            @error('ot_tertiary')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_tertiary_rgb"
                                class="form-label">{{ ___('settings.Tertiary_Color_RGB') }}</label>
                            <input type="text" name="ot_tertiary_rgb"
                                placeholder="{{ ___('settings.Tertiary_Color_RGB') }}"
                                value="{{ Setting('ot_tertiary_rgb') }}"
                                class="form-control ot-input @error('ot_tertiary_rgb') is-invalid @enderror">
                            @error('ot_tertiary_rgb')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class=" col-md-6 col-xl-6 col-lg-6 mb-3 ">
                            <label for="ot_primary_btn"
                                class="form-label">{{ ___('settings.Primary_Color_Button') }}</label>
                            <input type="text" name="ot_primary_btn"
                                placeholder="{{ ___('settings.Primary_Color_Button') }}"
                                value="{{ Setting('ot_primary_btn') }}"
                                class="form-control ot-input @error('ot_primary_btn') is-invalid @enderror">
                            @error('ot_primary_btn')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <!-- Update Button Start-->
                            <div class="text-end">
                                @if (hasPermission('general_settings_update'))
                                    <button class="btn btn-lg ot-btn-primary">{{ ___('common.update') }}</button>
                                @endif
                            </div>
                            <!-- Update Button End-->
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
