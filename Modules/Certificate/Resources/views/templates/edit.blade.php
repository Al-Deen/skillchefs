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
                route('admin.certificate.template.index') => ___('certificate.Certificate Template List'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">
                <div class="row mb-5">
                    <div class="ol-lg-12">
                        <h3 class="mb-20">
                            {{ ___('placeholder.Text Generate Hints') }}
                        </h3>
                        <div class="d-flex justify-content-between">
                            <span class="table-span-text">
                                {{ ___('certificate.Student Name') }} : <strong>{{ ___('certificate.[name]') }}</strong>
                            </span>
                            <span class="table-span-text">
                                {{ ___('certificate.Course Name') }} : <strong>{{ ___('certificate.[course]') }}</strong>
                            </span>
                            <span class="table-span-text">
                                {{ ___('certificate.instructor Name') }} : <strong>{{ ___('certificate.[instructor]') }}</strong>
                            </span>
                            <span class="table-span-text">
                                {{ ___('certificate.Date') }} : <strong>{{ ___('certificate.[date]') }}</strong>
                            </span>
                        </div>

                    </div>
                </div>
                <form action="{{ route('admin.certificate.template.update', $data['template']->id ) }}" enctype="multipart/form-data" method="post">
                    @csrf

                    {{-- Style Two --}}
                    <div class="row mb-3 row mb-3 d-flex justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xl-12 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Title') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                        list="datalistOptions" id="title" value="{{ $data['template']->title }}"
                                        placeholder="{{ ___('placeholder.Enter Title') }}">
                                    @error('title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="status" class="form-label ">{{ ___('common.Status') }}
                                        <span class="fillable">*</span></label>
                                    <select class="form-select ot-input select2 @error('status_id') is-invalid @enderror"
                                        id="status" required name="status_id">
                                        <option value="1" {{ $data['template']->status_id == 1 ? 'selected' : '' }}>{{ ___('common.Active') }}</option>
                                        <option value="2"  {{ $data['template']->status_id == 2 ? 'selected' : '' }}>{{ ___('common.Inactive') }}</option>
                                    </select>
                                    @error('status_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="default_id" class="form-label ">{{ ___('common.Default') }}
                                        <span class="fillable">*</span></label>
                                    <select class="form-select ot-input select2 @error('default_id') is-invalid @enderror"
                                        id="default_id" required name="default_id">
                                        <option value="11"  {{ $data['template']->default_id == 11 ? 'selected' : '' }}>{{ ___('common.Yes') }}</option>
                                        <option value="10"  {{ $data['template']->default_id == 10 ? 'selected' : '' }}>{{ ___('common.No') }}</option>
                                    </select>
                                    @error('default_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <label for="text" class="form-label ">{{ ___('course.Text') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <textarea class="ot-textarea form-control " name="text" id="text" rows="8"
                                        placeholder="{{ ___('placeholder.This is to certify that [name] has successfully completed the course [course] on [date].') }}">{{ $data['template']->text }}</textarea>
                                    @error('text')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror


                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <label for="template" class="form-label ">{{ ___('course.Template') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <div @if (@$data['template']->image) data-val="{{ (showImage(@$data['template']->image->original)) }}" @endif
                                     data-name="template" class="file @error('template') is-invalid @enderror"
                                        data-height="200px "></div>
                                    <small
                                        class="text-muted">{{ ___('placeholder.NB : Template type must be png format and not more than 1mb') }}</small>
                                    @error('template')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror


                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">

                            <button class="btn btn-lg ot-btn-primary" type="submit">
                                </span>{{ @$data['button'] }}</button>
                        </div>
                    </div>
            </div>
        </div>

        <!--  category create end -->
    </div>
@endsection
