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
                route('dashboard')                  => ___('common.Dashboard'),
                route('slider.index')               => ___('slider.Slider'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('slider.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    {{-- Style Two --}}
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Title') }} </label>
                                    <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                        list="datalistOptions" id="title"
                                        placeholder="{{ ___('placeholder.Enter Title') }}" value="{{old('title')}}">
                                    @error('title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Sub Title') }} </label>
                                    <input class="form-control ot-input @error('sub_title') is-invalid @enderror" name="sub_title"
                                        list="datalistOptions" id="sub_title"
                                        placeholder="{{ ___('placeholder.Sub Title') }}" value="{{old('sub_title')}}">
                                    @error('sub_title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Button Text') }} </label>
                                    <input class="form-control ot-input @error('button_text') is-invalid @enderror" name="button_text"
                                        list="datalistOptions" id="button_text"
                                        placeholder="{{ ___('placeholder.Button Text') }}" value="{{old('button_text')}}">
                                    @error('button_text')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Button Url') }} </label>
                                    <input class="form-control ot-input @error('button_url') is-invalid @enderror" name="button_url"
                                        list="datalistOptions" id="button_url"
                                        placeholder="{{ ___('placeholder.Button Url') }}" value="{{old('button_url')}}">
                                    @error('button_url')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="status" class="form-label ">{{ ___('common.Status') }}<span
                                            class="fillable">*</span></label>
                                    <select class="form-select ot-input select2 @error('status_id') is-invalid @enderror"
                                        id="status" required name="status_id">
                                        <option @if(old('status_id') == '1') {{'selected'}} @endif value="1">{{ ___('common.Active') }}</option>
                                        <option @if(old('status_id') == '2') {{'selected'}} @endif value="2">{{ ___('common.Inactive') }}</option>
                                    </select>
                                    @error('status_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="status" class="form-label ">{{ ___('common.Serial') }}<span
                                            class="fillable">*</span></label>
                                            <input type="number" class="form-control ot-input @error('serial') is-invalid @enderror" name="serial"
                                            list="datalistOptions" id="serial"
                                            placeholder="{{ ___('placeholder.Serial') }}" value="{{old('serial')}}">
                                        @error('serial')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3 custom-height">
                                    <label for="status" class="form-label ">{{ ___('slider.description') }}</label>
                                    <textarea id="description" name="description" class="ot-textarea form-control @error('description') is-invalid @enderror" rows="9">{!!old('description')!!}</textarea>
                                    @error('description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <label for="icon" class="form-label ">{{ ___('slider.Image') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <div data-name="image_id" class="file @error('image_id') is-invalid @enderror" data-height="200px"></div>
                                    <small
                                        class="text-muted">{{ ___('placeholder.NB : Icon size will 1260px x 400px and not more than 2mb') }}</small>
                                    @error('image_id')
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

        <!--  category create end -->
    </div>
@endsection
