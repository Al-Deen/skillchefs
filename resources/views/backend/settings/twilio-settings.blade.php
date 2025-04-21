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
                <form action="{{ route('settings.twilio-settings') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        {{-- Twilio SID start --}}
                        <div class="col-12 col-md-4 col-xl-4 col-lg-4">
                            <label for="twilio_sid" class="form-label">{{ ___('settings.Twilio SID') }} <span class="fillable">*</span></label>
                            <input type="text" name="twilio_sid" class="form-control ot-input @error('twilio_sid') is-invalid @enderror"
                                placeholder="{{ ___('settings.twilio_sid') }}" id="twilio_sid" value="{{ old('twilio_sid', setting('twilio_sid')) }}">
                            @error('twilio_sid')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- Twilio SID end --}}

                        {{-- Twilio Token start --}}
                        <div class="col-12 col-md-4 col-xl-4 col-lg-4">
                            <label for="twilio_token" class="form-label">{{ ___('settings.Twilio Token') }} <span class="fillable">*</span></label>
                            <input type="text" name="twilio_token" class="form-control ot-input @error('twilio_token') is-invalid @enderror"
                                placeholder="{{ ___('settings.twilio_token') }}" id="twilio_token" value="{{ old('twilio_token', setting('twilio_token')) }}">
                            @error('twilio_token')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- Twilio Token start --}}

                        {{-- Twilio From start --}}
                        <div class="col-12 col-md-4 col-xl-4 col-lg-4 mb-3">
                            <label for="twilio_number_from" class="form-label">{{ ___('settings.Twilio Number From') }} <span class="fillable">*</span></label>
                            <input type="text" name="twilio_number_from" class="form-control ot-input @error('twilio_number_from') is-invalid @enderror"
                                placeholder="{{ ___('settings.twilio_number_from') }}" id="twilio_number_from" value="{{ old('twilio_number_from', setting('twilio_number_from')) }}">
                            @error('twilio_number_from')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- Twilio From start --}}
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
