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

        <!-- Form with multiStep S t a r t-->
        <div class="form-with-multistep section-padding ot-card overflow-hidden">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-sm-12">
                        <div class="multiStep-wrapper border-bottom pb-10">
                            <div class="multiStep-wrapper-flex">
                                <div class="multiStep-wrapper-left h-calc radius-8 overflow-hidden">
                                    <ul class="step-list-wrapper list-style-none d-flex">
                                        <li class="single-step-list-step tab1 current-items general">
                                            <span class="single-multiStep-request-list-item-number  active">
                                                <div class="single-wrap">
                                                    <i class="las la-dice"></i>
                                                    <span>{{ ___('course.General') }}</span>
                                                </div>
                                            </span>
                                        </li>
                                        <li class="single-step-list-step tab2">
                                            <span class="single-multiStep-request-list-item-number ">
                                                <div class="single-wrap">
                                                    <i class="las la-dice"></i>
                                                    <span>{{ ___('course.Requirements') }}</span>
                                                </div>
                                            </span>
                                        </li>
                                        <li class="single-step-list-step tab3">
                                            <span class="single-multiStep-request-list-item-number ">
                                                <div class="single-wrap">
                                                    <i class="las la-dice"></i>
                                                    <span>{{ ___('course.Price') }}</span>
                                                </div>
                                            </span>
                                        </li>
                                        <li class="single-step-list-step tab4">
                                            <span class="single-multiStep-request-list-item-number ">
                                                <div class="single-wrap">
                                                    <i class="las la-dice"></i>
                                                    <span>{{ ___('course.Media') }}</span>
                                                </div>
                                            </span>
                                        </li>
                                        <li class="single-step-list-step tab5">
                                            <span class="single-multiStep-request-list-item-number ">
                                                <div class="single-wrap">
                                                    <i class="las la-dice"></i>
                                                    <span>{{ ___('course.SEO') }}</span>
                                                </div>
                                            </span>
                                        </li>
                                        <li class="single-step-list-step tab6">
                                            <span class="single-multiStep-request-list-item-number ">
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
                            <form action="{{ route('course.store') }}" method="post" enctype="multipart/form-data"
                                id="courseSubmit">
                                @csrf
                                <div class="multiStep-wrapper-flex">

                                    <!-- Start general form -->
                                    <div class="multiStep-wrapper-contents step1 active">
                                        <div class="mb-24 border-0 pt-0">
                                            <div class="row">

                                                {{-- start title  --}}
                                                <div class="col-xl-12 col-md-12 mb-3">
                                                    <label for="title"
                                                        class="form-label ">{{ ___('course.Course Title') }}
                                                        <span class="fillable">*</span></label>
                                                    <input
                                                        class="form-control ot-input @error('title') is-invalid @enderror"
                                                        name="title" list="datalistOptions" id="title"
                                                        value="{{ old('title') }}"
                                                        placeholder="{{ ___('placeholder.Enter Title') }}">
                                                    @error('title')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- end title  --}}

                                                {{-- start course type  --}}
                                                <div class="col-xl-4 col-md-12 mb-3">
                                                    <label for="course_type"
                                                        class="form-label ">{{ ___('label.Course Type') }}
                                                        <span class="fillable">*</span></label>
                                                    <select
                                                        class="form-select select2 @error('course_type') is-invalid @enderror"
                                                        id="course_type" name="course_type">
                                                        @foreach (courseType() as $type)
                                                            <option value="{{ $type->id }}"
                                                                {{ old('course_type') == $type->id ? ' selected="selected"' : '' }}>
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
                                                <div class="col-xl-4 col-md-12 mb-3">
                                                    <label for="instructor"
                                                        class="form-label ">{{ ___('common.Instructor') }}
                                                        <span class="fillable">*</span></label>
                                                    <select
                                                        class="instructor_select @error('instructor') is-invalid @enderror"
                                                        id="instructor" name="instructor"
                                                        data-href="{{ route('ajax-instructor-list') }}">
                                                        <option selected="" disabled="" value="">
                                                            {{ ___('common.Select Instructor') }}
                                                        </option>
                                                    </select>
                                                    @error('instructor')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- end cinstructor  --}}

                                                {{-- start course level  --}}
                                                <div class="col-xl-4 col-md-12 mb-3">
                                                    <label for="course_level" class="form-label ">{{ ___('label.Level') }}
                                                        <span class="fillable">*</span></label>
                                                    <select
                                                        class="form-select ot-input select2 @error('course_level') is-invalid @enderror"
                                                        id="course_level" name="course_level">
                                                        @foreach (courseLevel() as $level)
                                                            <option value="{{ $level->id }}"
                                                                {{ old('course_level') == $level->id ? ' selected="selected"' : '' }}>
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
                                                <div class="col-xl-12 col-md-12 mb-3">
                                                    <label for="short_description"
                                                        class="form-label ">{{ ___('label.Short description') }}</label>
                                                    <textarea class="form-control ot-textarea @error('short_description') is-invalid @enderror" name="short_description"
                                                        id="short_description" rows="5" placeholder="{{ ___('placeholder.Enter Short Description') }}">{{ old('short_description') }}</textarea>
                                                    @error('short_description')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- end short description  --}}

                                                {{-- start description  --}}

                                                <div class="col-xl-12 col-md-12 mb-3">
                                                    <label for="description"
                                                        class="form-label ">{{ ___('label.Description') }}</label>
                                                    <textarea class="form-control ckeditor-editor @error('description') is-invalid @enderror" name="description"
                                                        id="description" rows="5" placeholder="{{ ___('placeholder.Enter Description') }}">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- end description  --}}

                                                {{-- start category  --}}

                                                <div class="col-xl-3 col-md-6 mb-3">
                                                    <label for="category_id"
                                                        class="form-label ">{{ ___('label.Category') }}
                                                        <span class="fillable">*</span></label>
                                                    <select
                                                        class="form-select ot-input select2 @error('category') is-invalid @enderror"
                                                        id="category" name="category">
                                                        <option selected="" disabled="" value="">
                                                            {{ ___('placeholder.Select Category') }}
                                                        </option>
                                                        @foreach ($data['categories'] as $category)
                                                            <?= categoryBacktracking($category->id, '', null) ?>
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
                                                <div class="col-xl-3 col-md-6 mb-3">
                                                    <label for="status_id"
                                                        class="form-label ">{{ ___('common.Status') }}<span
                                                            class="fillable">*</span></label>
                                                    <select
                                                        class="form-select ot-input select2 @error('status_id') is-invalid @enderror"
                                                        id="status_id" required name="status_id">
                                                        <option value="1">{{ ___('common.Active') }}
                                                        </option>
                                                        <option value="2">{{ ___('common.Inactive') }}
                                                        </option>
                                                    </select>
                                                    @error('status_id')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- end status  --}}

                                                {{-- start visibility  --}}
                                                <div class="col-xl-3 col-md-6 mb-3">
                                                    <label for="visibility_id"
                                                        class="form-label ">{{ ___('label.Visibility') }}<span
                                                            class="fillable">*</span></label>
                                                    <select
                                                        class="form-select ot-input select2 @error('visibility_id') is-invalid @enderror"
                                                        id="visibility_id" required name="visibility_id">
                                                        @foreach (courseVisibility() as $visibility)
                                                            <option value="{{ $visibility->id }}"
                                                                {{ old('course_level') == $visibility->id ? ' selected="selected"' : '' }}>
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
                                                <div class="col-xl-3 col-md-6 mb-3">
                                                    <label for="language"
                                                        class="form-label ">{{ ___('common.Language') }}<span
                                                            class="fillable">*</span></label>
                                                    <select
                                                        class="form-select ot-input select2 @error('language_id') is-invalid @enderror"
                                                        id="language" required name="language_id">
                                                        @foreach ($data['languages'] as $language)
                                                            <option value="{{ $language->code }}">
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
                                                        class="form-label ">{{ ___('label.Course Requirements') }}
                                                    </label>
                                                    <textarea class="form-control ckeditor-editor @error('requirements') is-invalid @enderror" name="requirements"
                                                        id="requirements" rows="5">
                                                            {{ old('requirements') }}
                                                        </textarea>

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
                                                        id="requirements" rows="5">
                                                            {{ old('outcomes') }}
                                                        </textarea>
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
                                                                {{ old('is_free') ? 'checked' : '' }} name="is_free">
                                                            <label class="form-check-label"
                                                                for="is_free_course">{{ ___('label.Is it free course') }}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- end price free  --}}

                                                {{-- start  price  --}}
                                                <div class="col-xl-12 col-md-6 mb-3 price_div">
                                                    <label for="price"
                                                        class="form-label ">{{ ___('label.Course Price') }}
                                                    </label>
                                                    <input
                                                        class="form-control ot-input @error('title') is-invalid @enderror"
                                                        name="price" list="datalistOptions" id="price"
                                                        min="0" type="number"
                                                        placeholder="{{ ___('placeholder.Enter Price') }}">
                                                    @error('price')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>

                                                {{-- end price  --}}

                                                {{-- start  is discount  --}}

                                                <div class="col-xl-12 col-md-6 mb-3 d-flex price_div">
                                                    <div class="input-check-radio">
                                                        <div class="form-check price_div">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" id="is_discount" name="is_discount">
                                                            <label class="form-check-label"
                                                                for="is_discount">{{ ___('label.Check discount price') }}</label>
                                                        </div>
                                                    </div>
                                                </div>



                                                {{-- start  discount  --}}
                                                <div class="col-xl-6 col-md-6 mb-3 price_div">
                                                    <label for="discount_price"
                                                        class="form-label ">{{ ___('label.Course Discount') }}
                                                    </label>
                                                    <input
                                                        class="form-control ot-input @error('title') is-invalid @enderror"
                                                        name="discount_price" list="datalistOptions" id="discount_price"
                                                        min="0" type="number"
                                                        placeholder="{{ ___('placeholder.Enter Discount') }}">
                                                    @error('discount_price')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                {{-- end discount  --}}

                                                {{-- start  discount type  --}}
                                                <div class="col-xl-6 col-md-6 mb-3 price_div">
                                                    <label for="discount_type"
                                                        class="form-label ">{{ ___('label.Discount Type') }}
                                                    </label>
                                                    <select class="form-control select2 ot-input" name="discount_type"
                                                        list="datalistOptions" id="discount_type"
                                                        placeholder="{{ ___('placeholder.Enter Discount Type') }}">
                                                        <option value="1">
                                                            {{ ___('course.Fixed') }}</option>
                                                        <option value="2">
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
                                                        class="form-label ">{{ ___('label.Course Preview Type') }}
                                                    </label>
                                                    <select class="form-control select2 ot-input" name="course_preview"
                                                        list="datalistOptions" id="course_preview">
                                                        <option selected="" disabled="" value="">
                                                            {{ ___('placeholder.Select Option') }}
                                                        </option>
                                                        @foreach (coursePreviewType() as $type)
                                                            <option value="{{ $type->id }}">
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
                                                        class="form-label ">{{ ___('label.Video URL') }}
                                                    </label>
                                                    <input class="form-control ot-input" name="video_url"
                                                        list="datalistOptions" id="video_url"
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
                                                        class="form-label ">{{ ___('label.Thumbnail') }}
                                                    </label>
                                                    <div data-name="thumbnail"
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
                                                        class="form-label ">{{ ___('label.Meta Title') }}
                                                    </label>
                                                    <input class="form-control ot-input" name="meta_title"
                                                        list="datalistOptions" id="meta_title"
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
                                                        class="form-label ">{{ ___('label.Meta Keyword') }}
                                                    </label>
                                                    <input class="form-control ot-input" name="meta_keyword"
                                                        list="datalistOptions" id="meta_keyword"
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
                                                        class="form-label ">{{ ___('label.Meta Description') }}
                                                    </label>
                                                    <textarea class="form-control" name="meta_description" list="datalistOptions" row="10" id="meta_description"
                                                        placeholder="{{ ___('placeholder.Enter meta description') }}"></textarea>
                                                    @error('meta_description')
                                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>
                                                {{-- end meta description  --}}

                                                {{-- start  thumbnail url  --}}
                                                <div class="col-xl-12 col-md-6 mb-3">
                                                    <label for="price"
                                                        class="form-label ">{{ ___('course.Meta Image') }}
                                                    </label>
                                                    <div data-name="meta_image"
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
                                        <p>{{ ___('ui_element.Click on the button below to submit your form') }}</p>
                                        <button type="submit"
                                            class="btn btn-lg ot-btn-primary">{{ ___('common.Submit') }}</button>
                                    </div>
                                    <!-- End complete form -->
                                </div>
                            </form>
                        </div>

                        <div class="multiStep-footer mb-20">
                            <div class="multiStep-footer-flex ml-14 mr-14">
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
        <!-- form-with-multiStep End -->



    </div>
@endsection
@push('script')
    <script src="{{ asset('backend/assets/js/course.js') }}"></script>
@endpush
