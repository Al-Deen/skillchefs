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
                route('dashboard')      => ___('common.Dashboard'),
                route('brand.index')    => ___('brand.Brand'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('brand.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    {{-- Style Two --}}
                    <div class="col-lg-12">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-xl-12 col-md-6">
                                        <label for="icon" class="form-label ">{{ ___('brand.Image') }}
                                            <span class="fillable">*</span>
                                        </label>
                                        <div data-name="image_id" class="file @error('image_id') is-invalid @enderror"
                                            data-height="200px"></div>
                                        <small
                                            class="text-muted">{{ ___('placeholder.NB : Icon size will 200px x 50px and not more than 1mb') }}</small>
                                        @error('image_id')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-6 col-md-6 mb-3">
                                        <label for="status" class="form-label ">{{ ___('common.Serial') }}<span
                                                class="fillable">*</span></label>
                                        <input type="number"
                                            class="form-control ot-input @error('serial') is-invalid @enderror"
                                            name="serial" list="datalistOptions" id="serial"
                                            placeholder="{{ ___('placeholder.Serial') }}" value="{{ old('serial') }}">
                                        @error('serial')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-xl-6 col-md-6 mb-3">
                                        <label for="status" class="form-label ">{{ ___('common.Status') }}<span
                                                class="fillable">*</span></label>
                                        <select
                                            class="form-select ot-input select2 @error('status_id') is-invalid @enderror"
                                            id="status" required name="status_id">
                                            <option @if (old('status_id') == '1') {{ 'selected' }} @endif
                                                value="1">{{ ___('common.Active') }}</option>
                                            <option @if (old('status_id') == '2') {{ 'selected' }} @endif
                                                value="2">{{ ___('common.Inactive') }}</option>
                                        </select>
                                        @error('status_id')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="text-left">
                                    <button class="btn btn-lg ot-btn-primary" type="submit">
                                        </span>{{ @$data['button'] }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <!--  category create end -->
    </div>
@endsection
