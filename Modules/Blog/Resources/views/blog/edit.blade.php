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
                route('dashboard')  => ___('common.Dashboard'),
                route('blog.index') =>___('blog.Blog'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category edit start -->
        <div class="card ot-card">

            <div class="card-body">
                <form action="{{ route('blog.update',$data['blog']->id) }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    {{-- Style Two --}}
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xl-12 col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Title') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                        list="datalistOptions" id="title"
                                        placeholder="{{ ___('placeholder.Enter Title') }}" value="{{@$data['blog']->title}}">
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
                                        <option @if(@$data['blog']->status_id == '1') {{'selected'}} @endif value="1">{{ ___('common.Active') }}</option>
                                        <option @if(@$data['blog']->status_id == '2') {{'selected'}} @endif value="2">{{ ___('common.Inactive') }}</option>
                                    </select>
                                    @error('status_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="status" class="form-label ">{{ ___('blog.Category') }}<span
                                            class="fillable">*</span></label>
                                    <select class="form-select ot-input select2 @error('blog_categories_id') is-invalid @enderror"
                                        id="blogCatId"  name="blog_categories_id">
                                        @if($data['categoriesArr'])
                                        @foreach($data['categoriesArr'] as $catId => $category)
                                        <option @if(@$data['blog']->blog_categories_id == $catId) {{'selected'}} @endif value="{{$catId}}">{{ $category }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('blog_categories_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3 custom-height">
                                    <label for="status" class="form-label ">{{ ___('blog.description') }}<span
                                            class="fillable">*</span></label>
                                    <textarea id="description" name="description" rows="4" cols="10" class="ckeditor-editor @error('description') is-invalid @enderror">{!!@$data['blog']->description ?? old('description')!!}</textarea>
                                    @error('description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <label for="icon" class="form-label ">{{ ___('blog.Image') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <div @if (@$data['blog']->iconImage) data-val="{{ (showImage(@$data['blog']->iconImage->original)) }}" @endif
                                        data-name="image_id" class="file @error('image_id') is-invalid @enderror"
                                        data-height="200px"></div>
                                    <small
                                        class="text-muted">{{ ___('placeholder.NB : Image will not more than 1mb') }}</small>
                                    @error('image_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Meta Title') }} </label>
                                    <input class="form-control ot-input @error('meta_title') is-invalid @enderror" name="meta_title"
                                        list="datalistOptions" id="title"
                                        placeholder="{{ ___('placeholder.Enter Meta Title') }}" value="{{@$data['blog']->meta_title ?? old('meta_title')}}">
                                    @error('meta_title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="title" class="form-label ">{{ ___('common.Meta Keyword') }} </label>
                                    <input class="form-control ot-input @error('meta_keywords') is-invalid @enderror" name="meta_keywords"
                                        list="datalistOptions" id="meta_keywords"
                                        placeholder="{{ ___('placeholder.Enter Meta Keywords') }}" value="{{@$data['blog']->meta_keywords ?? old('meta_keywords')}}">
                                    @error('meta_keywords')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3 custom-height">
                                    <label for="status" class="form-label ">{{ ___('blog.Meta Description') }}</label>
                                    <textarea id="metaDescription" rows="4" cols="10" name="meta_description" class="ckeditor-editor @error('meta_description') is-invalid @enderror">{!!@$data['blog']->meta_description ?? old('meta_description')!!}</textarea>
                                    @error('meta_description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-6 col-md-6">
                                    <label for="icon" class="form-label ">{{ ___('blog.Meta Image') }}
                                    </label>
                                    <div @if (@$data['blog']->metaImage) data-val="{{ (showImage(@$data['blog']->metaImage->original)) }}" @endif
                                        data-name="meta_image_id" class="file @error('meta_image_id') is-invalid @enderror"
                                        data-height="200px"></div>
                                    <small
                                        class="text-muted">{{ ___('placeholder.NB : Image will not more than 1mb') }}</small>
                                    @error('meta_image_id')
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

        <!--  category edit end -->
    </div>
@endsection
