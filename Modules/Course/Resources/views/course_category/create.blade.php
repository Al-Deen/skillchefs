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
                route('course-category.index')      => ___('course.Course Category'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('course-category.store') }}" enctype="multipart/form-data" method="post">
                    @csrf

                    {{-- Style Two --}}
                    <div class="row mb-3 row mb-3 d-flex justify-content-center">
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="title" class="form-label ">{{ ___('common.Title') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                list="datalistOptions" id="title"
                                placeholder="{{ ___('placeholder.Enter Title') }}">
                            @error('title')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="parent_id" class="form-label ">{{ ___('common.Parent Category') }}</label>
                            <select class="form-select ot-input select2 @error('parent_id') is-invalid @enderror"
                                id="parent_id" name="parent_id">
                                <option selected="" disabled="" value="">
                                    {{ ___('placeholder.Select Parent Category') }}
                                </option>
                                @foreach ($data['categories'] as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
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
                                <option value="1">{{ ___('common.Active') }}</option>
                                <option value="2">{{ ___('common.Inactive') }}</option>
                            </select>
                            @error('status_id')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-6">
                            <label for="icon" class="form-label ">{{ ___('course.Icon') }}
                                <span class="fillable">*</span>
                            </label>
                            <div data-name="icon" class="file @error('icon') is-invalid @enderror" data-height="200px "></div>
                            <small
                                class="text-muted">{{ ___('placeholder.NB : Icon size will 35px x 35px and not more than 1mb') }}</small>
                            @error('icon')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror


                        </div>
                        <div class="col-lg-12 mt-3">
                            <button class="btn btn-lg ot-btn-primary" type="submit">
                                </span>{{ @$data['button'] }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--  category create end -->
    </div>
@endsection
