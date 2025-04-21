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
                route('languages.index') => ___('language.languages'),
                '#' => @$data['title'],
            ],
        
            'buttons' => 1,
        ])
        {{-- breadecrumb Area E n d --}}

        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('languages.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.enter_name') }}">
                                    @error('name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleDataList" class="form-label ">{{ ___('language.code') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('code') is-invalid @enderror" name="code"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('language.enter_code') }}">
                                    @error('code')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="validationServer04" class="form-label">{{ ___('language.flag_icon') }} <span
                                            class="fillable">*</span></label>
                                    <select
                                        class="form-select ot-input select2 @error('flagIcon') is-invalid @enderror"
                                        name="flagIcon" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('common.select') }}</option>
                                        @foreach ($data['flagIcons'] as $row)
                                            <option value="{{ $row->icon_class }}" data-icon="{{ $row->icon_class }}">
                                                {{ $row->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('flagIcon')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                <div class="col-md-6 direction-button">

                                    <label for="validationServer04"
                                        class="form-label">{{ ___('language.direction') }}</label>

                                    <div class="input-check-radio">
                                        <div class="form-check d-flex align-items-center">
                                            <input type="radio" class="form-check-input mt-0 mr-4 read common-key"
                                                name="direction" value="{{ App\Enums\Direction::RTL }}" id="rtl_direction">
                                            <label class="custom-control-label"
                                                for="rtl_direction">{{ ___('language.rtl') }}</label>
                                        </div>
                                    </div>

                                    <div class="input-check-radio">
                                        <div class="form-check d-flex align-items-center">
                                            <input type="radio" class="form-check-input mt-0 mr-4 read common-key"
                                                name="direction" value="{{ App\Enums\Direction::LTR }}" id="ltr_direction">
                                            <label class="custom-control-label"
                                                for="ltr_direction">{{ ___('language.ltr') }}</label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary">{{ ___('common.submit') }}</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
