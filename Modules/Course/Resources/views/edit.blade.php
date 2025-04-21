@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/mult-step.css') }}">
@endpush
@section('content')
    <div class="page-content">

        {{-- breadecrumb Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                route('course.index') => ___('common.Courses'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}
        <input type="hidden" id="course_id" value="{{ @$data['course']->id }}">
        <!-- Form with multiStep S t a r t-->
        <section class="form-with-multistep">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <div class="multiStep-wrapper  border-bottom table-responsive">
                                    <div class="multiStep-wrapper-flex">
                                        <div class="multiStep-wrapper-left h-calc radius-8">
                                            <ul class="step-list-wrapper list-style-none d-flex ">

                                                <li class="single-step-list-step tab1 ">
                                                    <span
                                                        class="single-multiStep-request-list-item-number __course_edit active">
                                                        <div class="single-wrap">
                                                            <i class="las la-dice"></i>
                                                            <span>{{ ___('course.General') }}</span>
                                                        </div>
                                                    </span>
                                                </li>
                                                <li class="single-step-list-step tab2">
                                                    <span class="single-multiStep-request-list-item-number __course_edit ">
                                                        <div class="single-wrap">
                                                            <i class="las la-dice"></i>
                                                            <span>{{ ___('course.Requirements') }}</span>
                                                        </div>
                                                    </span>
                                                </li>
                                                <li class="single-step-list-step tab3">
                                                    <span class="single-multiStep-request-list-item-number __course_edit ">
                                                        <div class="single-wrap">
                                                            <i class="las la-dice"></i>
                                                            <span>{{ ___('course.Price') }}</span>
                                                        </div>
                                                    </span>
                                                </li>
                                                <li class="single-step-list-step tab4">
                                                    <span class="single-multiStep-request-list-item-number __course_edit ">
                                                        <div class="single-wrap">
                                                            <i class="las la-dice"></i>
                                                            <span>{{ ___('course.Media') }}</span>
                                                        </div>
                                                    </span>
                                                </li>
                                                <li class="single-step-list-step tab5">
                                                    <span class="single-multiStep-request-list-item-number __course_edit ">
                                                        <div class="single-wrap">
                                                            <i class="las la-dice"></i>
                                                            <span>{{ ___('course.SEO') }}</span>
                                                        </div>
                                                    </span>
                                                </li>
                                                <li class="single-step-list-step tab6">
                                                    <span class="single-multiStep-request-list-item-number __course_edit ">
                                                        <div class="single-wrap">
                                                            <i class="las la-dice"></i>
                                                            <span>{{ ___('course.Complete') }}</span>
                                                        </div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="multiStep-wrapper">
                                    <form action="{{ route('course.update', @$data['course']->id) }}" method="post"
                                        enctype="multipart/form-data" id="courseSubmit">
                                        @method('PUT')
                                        @csrf
                                        <div class="multiStep-wrapper-flex">
                                            <!-- Start general form -->
                                            <div class="multiStep-wrapper-contents step1 active">
                                                <div class="mb-24 border-0 pt-0">

                                                    <div class="row">

                                                        {{-- start title  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="title"
                                                                class="form-label ">{{ ___('course.Course Title') }}
                                                                <span class="fillable">*</span></label>
                                                            <input
                                                                class="form-control ot-input @error('title') is-invalid @enderror"
                                                                name="title" list="datalistOptions" id="title"
                                                                value="{{ @$data['course']->title }}"
                                                                placeholder="{{ ___('placeholder.Enter Title') }}">
                                                            @error('title')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end title  --}}

                                                        {{-- start course type  --}}
                                                        <div class="col-xl-6 col-md-6 mb-3">
                                                            <label for="course_type"
                                                                class="form-label ">{{ ___('course.Course Type') }}
                                                                <span class="fillable">*</span></label>
                                                            <select
                                                                class="form-select select2 @error('course_type') is-invalid @enderror"
                                                                id="course_type" name="course_type">
                                                                @foreach (courseType() as $type)
                                                                    <option value="{{ $type->id }}"
                                                                        {{ @$data['course']->course_type == $type->id ? ' selected="selected"' : '' }}>
                                                                        {{ $type->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('course_type')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end course type  --}}

                                                        {{-- start cinstructor  --}}
                                                        <div class="col-xl-6 col-md-6 mb-3">
                                                            <label for="instructor"
                                                                class="form-label ">{{ ___('common.Instructor') }}
                                                                <span class="fillable">*</span></label>
                                                            <select
                                                                class="form-select ot-input instructor_select @error('instructor') is-invalid @enderror"
                                                                id="instructor" name="instructor"
                                                                data-href="{{ route('ajax-instructor-list') }}">
                                                                @if (@$data['course']->instructor)
                                                                    <option value="{{ @$data['course']->instructor->id }}"
                                                                        selected>
                                                                        {{ @$data['course']->instructor->name }}
                                                                    </option>
                                                                @else
                                                                    <option selected="" disabled="" value="">
                                                                        {{ ___('common.Select Instructor') }}
                                                                    </option>
                                                                @endif
                                                            </select>
                                                            @error('instructor')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end cinstructor  --}}

                                                        {{-- start course level  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="course_level"
                                                                class="form-label ">{{ ___('course.Course Level') }}
                                                                <span class="fillable">*</span></label>
                                                            <select
                                                                class="form-select ot-input select2 @error('course_level') is-invalid @enderror"
                                                                id="course_level" name="course_level">
                                                                @foreach (courseLevel() as $level)
                                                                    <option value="{{ $level->id }}"
                                                                        {{ @$data['course']->level_id == $level->id ? ' selected="selected"' : '' }}>
                                                                        {{ $level->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('course_level')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end course level  --}}

                                                        {{-- start short description  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="short_description"
                                                                class="form-label ">{{ ___('common.Short Description') }}
                                                                <span class="fillable">*</span></label>
                                                            <textarea class="form-control ot-textarea @error('short_description') is-invalid @enderror" name="short_description"
                                                                id="short_description" rows="5" placeholder="{{ ___('placeholder.Enter Short Description') }}"><?= @$data['course']->short_description ?></textarea>
                                                            @error('short_description')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end short description  --}}

                                                        {{-- start description  --}}

                                                        <div class="col-lg-12 col-md-6 mb-3">
                                                            <label for="description"
                                                                class="form-label ">{{ ___('common.Description') }}
                                                                <span class="fillable">*</span></label>
                                                            <textarea class="form-control ckeditor-editor @error('description') is-invalid @enderror" name="description"
                                                                id="description" rows="5" placeholder="{{ ___('placeholder.Enter Description') }}"><?= @$data['course']->description ?></textarea>
                                                            @error('description')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end description  --}}

                                                        {{-- start category  --}}

                                                        <div class="col-lg-6 col-md-6 mb-3">
                                                            <label for="category_id"
                                                                class="form-label ">{{ ___('common.Category') }} <span
                                                                    class="fillable">*</span></label>
                                                            <select
                                                                class="form-select ot-input select2 @error('category') is-invalid @enderror"
                                                                id="category" name="category">
                                                                @foreach ($data['categories'] as $category)
                                                                    <?= categoryBacktracking($category->id, '', @$data['course']->course_category_id) ?>
                                                                @endforeach
                                                            </select>
                                                            @error('category')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end category  --}}

                                                        {{-- start status  --}}
                                                        <div class="col-lg-6 col-md-6 mb-3">
                                                            <label for="status_id"
                                                                class="form-label ">{{ ___('common.Status') }}<span
                                                                    class="fillable">*</span></label>
                                                            <select
                                                                class="form-select ot-input select2 @error('status_id') is-invalid @enderror"
                                                                id="status_id" required name="status_id">
                                                                <option value="1"
                                                                    {{ $data['course']->status_id == 1 ? 'selected' : '' }}>
                                                                    {{ ___('common.Active') }}</option>
                                                                <option value="2"
                                                                    {{ $data['course']->status_id == 2 ? 'selected' : '' }}>
                                                                    {{ ___('common.Inactive') }}</option>
                                                            </select>
                                                            @error('status_id')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end status  --}}

                                                        {{-- start visibility  --}}
                                                        <div class="col-lg-6 col-md-6 mb-3">
                                                            <label for="visibility_id"
                                                                class="form-label ">{{ ___('common.Visibility') }}<span
                                                                    class="fillable">*</span></label>
                                                            <select
                                                                class="form-select ot-input select2 @error('visibility_id') is-invalid @enderror"
                                                                id="visibility_id" required name="visibility_id">
                                                                @foreach (courseVisibility() as $visibility)
                                                                    <option value="{{ $visibility->id }}"
                                                                        {{ @$data['course']->visibility_id == $visibility->id ? ' selected="selected"' : '' }}>
                                                                        {{ $visibility->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('visibility_id')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end visibility  --}}

                                                        {{-- start language  --}}
                                                        <div class="col-lg-6 col-md-6 mb-3">
                                                            <label for="language"
                                                                class="form-label ">{{ ___('common.Language') }}<span
                                                                    class="fillable">*</span></label>
                                                            <select
                                                                class="form-select ot-input select2 @error('language_id') is-invalid @enderror"
                                                                id="language" required name="language_id">
                                                                @foreach ($data['languages'] as $language)
                                                                    <option value="{{ $language->code }}"
                                                                        {{ @$data['course']->language == $language->code ? ' selected="selected"' : '' }}>
                                                                        {{ $language->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('language_id')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End general form -->
                                            <!-- Start requirements form-->
                                            <div class="multiStep-wrapper-contents step2 ">
                                                <div class="mb-24 border-0 pt-0">

                                                    <div class="row">
                                                        {{-- start Requirements  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="requirements"
                                                                class="form-label ">{{ ___('course.Course Requirements') }}
                                                            </label>
                                                            <textarea class="form-control ckeditor-editor @error('requirements') is-invalid @enderror" name="requirements"
                                                                id="requirements" rows="5"><?= @$data['course']->requirements ?></textarea>

                                                            @error('requirements')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end Requirements  --}}
                                                        {{-- start Requirements  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="outcomes"
                                                                class="form-label ">{{ ___('course.Course Outcomes') }}
                                                            </label>

                                                            <textarea class="form-control ckeditor-editor @error('outcomes') is-invalid @enderror" name="outcomes"
                                                                id="requirements" rows="5"><?= @$data['course']->outcomes ?></textarea>
                                                            @error('outcomes')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- end Requirements  --}}

                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End requirements form-->
                                            <!-- Start price form-->
                                            <div class="multiStep-wrapper-contents step3 ">
                                                <!-- Form -->
                                                <div class="mb-24 border-0 pt-0">

                                                    <div class="row">

                                                        {{-- start  price free  --}}

                                                        <div class="col-xl-12 col-md-6 mb-3 d-flex">
                                                            <div class="input-check-radio">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="1" id="is_free_course"
                                                                        {{ @$data['course']->is_free == 1 ? ' checked="checked"' : '' }}
                                                                        name="is_free">
                                                                    <label class="form-check-label"
                                                                        for="is_free_course">{{ ___('course.Is it free course') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- end price free  --}}

                                                        {{-- start  price  --}}
                                                        <div
                                                            class="col-xl-12 col-md-6 mb-3 price_div {{ @$data['course']->is_free == 1 ? 'd-none' : '' }} ">
                                                            <label for="price"
                                                                class="form-label ">{{ ___('course.Course Price') }}
                                                            </label>
                                                            <input
                                                                class="form-control ot-input @error('title') is-invalid @enderror"
                                                                name="price" list="datalistOptions" id="price"
                                                                min="0" type="number"
                                                                value="{{ @$data['course']->price }}"
                                                                placeholder="{{ ___('placeholder.Enter Price') }}">
                                                            @error('price')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>

                                                        {{-- end price  --}}

                                                        {{-- start  is discount  --}}

                                                        <div
                                                            class="col-xl-12 col-md-6 mb-3 d-flex price_div {{ @$data['course']->is_free == 1 ? 'd-none' : '' }}">
                                                            <div class="input-check-radio">
                                                                <div
                                                                    class="form-check price_div {{ @$data['course']->is_free == 1 ? 'd-none' : '' }}">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="11" id="is_discount"
                                                                        {{ @$data['course']->is_discount == 11 ? ' checked="checked"' : '' }}
                                                                        name="is_discount">
                                                                    <label class="form-check-label"
                                                                        for="is_discount">{{ ___('course.Check discount price') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        {{-- start  discount  --}}
                                                        <div
                                                            class="col-xl-6 col-md-6 mb-3 price_div {{ @$data['course']->is_free == 1 ? 'd-none' : '' }}">
                                                            <label for="discount_price"
                                                                class="form-label ">{{ ___('course.Course Discount') }}
                                                            </label>
                                                            <input
                                                                class="form-control ot-input @error('title') is-invalid @enderror"
                                                                name="discount_price" list="datalistOptions"
                                                                id="discount_price" min="0" type="number"
                                                                value="{{ @$data['course']->discount_price }}"
                                                                placeholder="{{ ___('placeholder.Enter Discount') }}">
                                                            @error('discount_price')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        {{-- end discount  --}}

                                                        {{-- start  discount type  --}}
                                                        <div
                                                            class="col-xl-6 col-md-6 mb-3 price_div {{ @$data['course']->is_free == 1 ? 'd-none' : '' }}">
                                                            <label for="discount_type"
                                                                class="form-label ">{{ ___('course.Discount Type') }}
                                                            </label>
                                                            <select
                                                                class="form-control select2 ot-input @error('title') is-invalid @enderror"
                                                                name="discount_type" list="datalistOptions"
                                                                id="discount_type"
                                                                placeholder="{{ ___('placeholder.Enter Discount Type') }}">
                                                                <option value="1"
                                                                    {{ $data['course']->discount_type == 1 ? 'selected' : '' }}>
                                                                    {{ ___('course.Fixed') }}</option>
                                                                <option value="2"
                                                                    {{ $data['course']->discount_type == 2 ? 'selected' : '' }}>
                                                                    {{ ___('course.Percentage') }}</option>
                                                            </select>
                                                            @error('discount_type')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>




                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End price form -->
                                            <!-- Start media form-->
                                            <div class="multiStep-wrapper-contents step4 ">
                                                <!-- Form -->
                                                <div class="mb-24 border-0 pt-0">

                                                    <div class="row">

                                                        {{-- start  course preview  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="course_preview"
                                                                class="form-label ">{{ ___('course.Course Preview Type') }}
                                                            </label>
                                                            <select
                                                                class="form-control select2 ot-input @error('title') is-invalid @enderror"
                                                                name="course_preview" list="datalistOptions"
                                                                id="course_preview">
                                                                <option selected="" disabled="" value="">
                                                                    {{ ___('placeholder.Select Option') }}
                                                                </option>
                                                                @foreach (coursePreviewType() as $type)
                                                                    <option value="{{ $type->id }}"
                                                                        {{ $data['course']->course_overview_type == $type->id ? ' selected="selected"' : '' }}>
                                                                        {{ $type->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('course_preview')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        {{-- start course preview  --}}

                                                        {{-- start  video url  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3 video_url">
                                                            <label for="video_url"
                                                                class="form-label ">{{ ___('course.Video URL') }}
                                                            </label>
                                                            <input
                                                                class="form-control ot-input @error('title') is-invalid @enderror"
                                                                name="video_url" list="datalistOptions" id="video_url"
                                                                type="text" value="{{ @$data['course']->video_url }}"
                                                                placeholder="https://youtu.be/3l6Q4QL-j4Q">
                                                            @error('video_url')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>

                                                        {{-- end video url  --}}
                                                        {{-- start  thumbnail url  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="thumbnail"
                                                                class="form-label ">{{ ___('course.Thumbnail') }}
                                                                <span class="fillable">*</span>
                                                            </label>
                                                            <div @if (@$data['course']->thumbnailImage) data-val="{{ showImage(@$data['course']->thumbnailImage->original) }}" @endif
                                                                data-name="thumbnail"
                                                                class="file @error('thumbnail') is-invalid @enderror"
                                                                data-height="200px "></div>
                                                            <small
                                                                class="text-muted">{{ ___('placeholder.NB : Thumbnail size will 600px x 600px and not more than 1mb') }}</small>
                                                            @error('thumbnail')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>

                                                        {{-- end thumbnail --}}
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End media form -->
                                            <!-- Start meta form-->
                                            <div class="multiStep-wrapper-contents step5 ">
                                                <!-- Form -->
                                                <div class="mb-24 border-0 pt-0">

                                                    <div class="row">

                                                        {{-- start meta title  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="meta_title"
                                                                class="form-label ">{{ ___('course.Meta Title') }}
                                                            </label>
                                                            <input
                                                                class="form-control ot-input @error('title') is-invalid @enderror"
                                                                name="meta_title" list="datalistOptions" id="meta_title"
                                                                value="{{ @$data['course']->meta_title }}"
                                                                placeholder="{{ ___('placeholder.Enter meta title') }}">
                                                            @error('meta_title')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>
                                                        {{-- end meta title  --}}
                                                        {{-- start meta keyword  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="meta_keyword"
                                                                class="form-label ">{{ ___('course.Meta Keyword') }}
                                                            </label>
                                                            <input
                                                                class="form-control ot-input @error('title') is-invalid @enderror"
                                                                name="meta_keyword" list="datalistOptions"
                                                                id="meta_keyword"
                                                                value="{{ @$data['course']->meta_keywords }}"
                                                                placeholder="{{ ___('placeholder.Enter meta title') }}">
                                                            @error('meta_keyword')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>
                                                        {{-- end meta title  --}}
                                                        {{-- start meta description  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="meta_description"
                                                                class="form-label ">{{ ___('course.Meta Description') }}
                                                            </label>
                                                            <textarea class="form-control @error('title') is-invalid @enderror" name="meta_description" list="datalistOptions"
                                                                row="10" id="meta_description" placeholder="{{ ___('placeholder.Enter meta description') }}"><?= @$data['course']->meta_description ?></textarea>
                                                            @error('meta_description')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>
                                                        {{-- end meta description  --}}

                                                        {{-- start  thumbnail url  --}}
                                                        <div class="col-xl-12 col-md-6 mb-3">
                                                            <label for="meta_image"
                                                                class="form-label ">{{ ___('course.Meta Image') }}
                                                            </label>
                                                            <div @if (@$data['course']->metaImage) data-val="{{ showImage(@$data['course']->metaImage->original) }}" @endif
                                                                data-name="meta_image"
                                                                class="file @error('meta_image') is-invalid @enderror"
                                                                data-height="200px "></div>
                                                            <small
                                                                class="text-muted">{{ ___('placeholder.NB : Meta image size will 1200px x 627px and not more than 1mb') }}</small>
                                                            @error('meta_image')
                                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>

                                                        {{-- end thumbnail --}}
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End media form -->
                                            <!-- Start complete form -->
                                            <div class="multiStep-wrapper-contents text-center step6 ">
                                                <h2>{{ ___('ui_element.Everything looks good') }}</h2>
                                                <p>{{ ___('ui_element.Click on the button below to submit your form') }}
                                                </p>
                                                <button type="submit"
                                                    class="btn btn-lg ot-btn-primary">{{ ___('common.Update') }}</button>
                                            </div>
                                            <!-- End complete form -->
                                        </div>
                                    </form>
                                </div>



                                <div class="multiStep-footer mt-3 mb-20">
                                    <div class="multiStep-footer-flex">
                                        <div class="multiStep-footer-left">
                                            <a href="javascript:void(0)"
                                                class="multiStep-footer-back previous ot-btn-primary ot-primary-btn"
                                                id="previous"> {{ ___('course.Back') }} </a>
                                        </div>
                                        <div class="multiStep-footer-right">
                                            <a href="javascript:void(0)"
                                                class="multiStep-footer-next next ot-btn-primary btn-primary-fill"
                                                id="next">{{ ___('course.Next') }} </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Eorm-with-multiStep End -->



    </div>
@endsection
@push('script')
    <script src="{{ asset('backend/assets/js/edit_course.js') }}"></script>
@endpush
