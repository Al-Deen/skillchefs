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
                route('course.index') => ___('common.Courses'),
                route('course.notice-board.index', $data['course']->id) => ___('course.Course NoticeBoard List'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">

                <form action="{{ route('course.noticeboard.update', $data['noticeboard']->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input type="text" hidden name="course_id" value="{{ $data['course']->id }}">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="title" class="form-label ">
                                {{ ___('course.Title') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <input type="text" class="form-control ot-input" id="title" name="title"
                                value="{{ @$data['noticeboard']->title }}" placeholder="{{ ___('course.Title') }}"
                                 required />
                            @error('title')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="description" class="form-label ">{{ ___('course.Description') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <textarea class="form-control ot-input ckeditor-editor" id="description" name="description" required
                                placeholder="{{ ___('course.description') }}">
                            <?= @$data['noticeboard']->description ?>
                        </textarea>
                            @error('description')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-12 col-md-12 mb-3">
                            <div class="input-check-radio">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="notify"
                                        {{ @$data['noticeboard']->is_send_mail ? 'checked' : '' }} name="is_send_mail">
                                    <label class="form-check-label"
                                        for="notify">{{ ___('course.Notify To All Students') }}</label>
                                </div>
                            </div>
                            @error('marks')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mt-4">
                            <button type="submit" class="btn btn-lg ot-btn-primary">{{ ___('common.Update') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!--  category create end -->
    </div>
@endsection
