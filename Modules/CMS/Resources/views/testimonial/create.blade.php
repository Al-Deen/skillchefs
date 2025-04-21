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
                route('admin.testimonial.index') =>  ___('common.Testimonial List'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('admin.testimonial.store') }}" enctype="multipart/form-data" method="post">
                    @csrf

                    {{-- Style Two --}}
                    <div class="row mb-3 row mb-3 d-flex justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="name" class="form-label ">{{ ___('common.name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                        list="datalistOptions" id="name"
                                        placeholder="{{ ___('placeholder.Enter Name') }}">
                                    @error('name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="status" class="form-label ">{{ ___('common.Status') }}
                                        <span class="fillable">*</span></label>
                                    <select class="form-select ot-input select2 @error('status_id') is-invalid @enderror"
                                        id="status_id" required name="status_id">
                                        <option value="1">{{ ___('common.Active') }}</option>
                                        <option value="2">{{ ___('common.Inactive') }}</option>
                                    </select>
                                    @error('status_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="rating" class="form-label ">{{ ___('common.Rating') }}
                                        <span class="fillable">*</span></label>
                                    <select class="form-select ot-input select2 @error('rating') is-invalid @enderror"
                                        id="status" required name="rating">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    @error('rating')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="designation" class="form-label ">{{ ___('common.Designation') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('designation') is-invalid @enderror"
                                        name="designation" list="datalistOptions" id="designation"
                                        placeholder="{{ ___('placeholder.Enter Designation') }}">
                                    @error('designation')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="content" class="form-label ">{{ ___('common.Content') }} <span
                                            class="fillable">*</span></label>
                                    <textarea class="form-control ot-textarea @error('content') is-invalid @enderror" name="content" list="datalistOptions"
                                        rows="9" id="content" placeholder="{{ ___('placeholder.Enter Content') }}"></textarea>
                                    @error('content')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <label for="image_id" class="form-label ">{{ ___('course.Image') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <div data-name="image_id" class="file @error('image_id') is-invalid @enderror"
                                        data-height="200px "></div>
                                    <small
                                        class="text-muted">{{ ___('placeholder.NB : Image will not more than 1mb') }}</small>
                                    @error('image_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror


                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary" type="submit">
                                    {{ @$data['button'] }}
                                </button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <!--  category create end -->
    </div>
@endsection
