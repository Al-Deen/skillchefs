@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/summernote/summernote.css') }}">
@endpush
@section('content')
    <div class="page-content">

        {{-- breadecrumb Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                route('pages.index') => ___('page.Page'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('pages.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    {{-- Style Two --}}
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Title') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                        list="datalistOptions" id="title"
                                        placeholder="{{ ___('placeholder.Enter Title') }}" value="{{ old('title') }}">
                                    @error('title')
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
                                        <option @if (old('status_id') == '1') {{ 'selected' }} @endif value="1">
                                            {{ ___('common.Active') }}</option>
                                        <option @if (old('status_id') == '2') {{ 'selected' }} @endif
                                            value="2">
                                            {{ ___('common.Inactive') }}</option>
                                    </select>
                                    @error('status_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="section" class="form-label ">{{ ___('common.Section') }}</label>
                                    <select class="form-select ot-input select2 @error('section') is-invalid @enderror"
                                        id="section" name="section[]" multiple>
                                        @foreach ($data['sections'] as $section)
                                            <option value="{{ $section->id }}">
                                                {{ $section->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="type" class="form-label ">{{ ___('common.Type') }}<span
                                            class="fillable">*</span></label>
                                    <select
                                        class="form-select ot-input select2 @error('type') is-invalid @enderror page_content_type"
                                        id="type" required name="type">
                                        <option @if (old('type') == '1') {{ 'selected' }} @endif
                                            value="1">
                                            {{ ___('common.Content') }}</option>
                                        <option @if (old('type') == '2') {{ 'selected' }} @endif
                                            value="2">
                                            {{ ___('common.Image') }}</option>
                                        <option @if (old('type') == '3') {{ 'selected' }} @endif
                                            value="3">
                                            {{ ___('common.Image And Content') }}</option>
                                    </select>
                                    @error('type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>




                                <div class="col-xl-12 col-md-12 mb-3 custom-height page-type-image d-none">
                                    <label for="content" class="form-label ">{{ ___('common.Image') }}<span
                                            class="fillable">*</span></label>
                                    <div data-name="image" class="file @error('image') is-invalid @enderror"
                                        data-height="200px "></div>
                                    @error('image')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-12 col-md-12 mb-3 both-type">
                                    <label for="widget_type" class="form-label ">{{ ___('common.Widget_Type') }}<span
                                            class="fillable">*</span></label>
                                    <select class="form-select ot-input select2 @error('widget_type') is-invalid @enderror"
                                        id="widget_type" required name="widget_type">
                                        <option @if (old('widget_type') == '1') {{ 'selected' }} @endif
                                            value="1">
                                            {{ ___('common.Full-Width') }}</option>
                                        <option @if (old('widget_type') == '2') {{ 'selected' }} @endif
                                            value="2">
                                            {{ ___('common.Half-Width') }}</option>
                                    </select>
                                    @error('widget_type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>



                                <div class="col-xl-12 col-md-6 mb-3 page-type-content">
                                    <label for="content" class="form-label ">{{ ___('page.Content') }}<span
                                            class="fillable">*</span></label>
                                    <textarea class="form-control summernote @error('content') is-invalid @enderror" name="content"
                                        list="datalistOptions" rows="9" id="content" placeholder="{{ ___('placeholder.Enter Content') }}"></textarea>
                                    @error('content')
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
@push('script')
    <script src="{{ asset('backend/assets/summernote/summernote.js') }}"></script>
@endpush
