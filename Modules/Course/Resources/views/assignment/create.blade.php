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
                route('course.assignment.index', $data['course']->id) => ___('course.Course Assignment List'),
                '#' => @$data['title'],
            ],
            'buttons' => 0,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  category create start -->
        <div class="card ot-card">

            <div class="card-body">

                <form action="{{ route('course.assignment.store', $data['course']->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="title" class="form-label ">
                                {{ ___('course.Title') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <input type="text" class="form-control ot-input" id="title" name="title"
                                placeholder="{{ ___('course.Title') }}" value="{{ old('title') }}" required />
                            @error('title')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="details" class="form-label ">{{ ___('course.Details') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <textarea class="form-control ot-input ckeditor-editor" id="details" name="details" required
                                placeholder="{{ ___('course.details') }}">{{ old('details') }}</textarea>
                            @error('details')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="marks" class="form-label ">{{ ___('course.Marks') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <input type="number" class="form-control ot-input" id="marks" name="marks" required
                                placeholder="{{ ___('course.Marks') }}" value="{{ old('marks') }}" />
                            @error('marks')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="ot-contact-form mb-24">
                            <label for="pass_marks" class="ot-contact-label">{{ ___('course.Pass Marks') }}
                                <span class="text-danger">*</span></label>
                            </label>
                            <input type="number" class="form-control ot-input" id="pass_marks" name="pass_marks"
                                placeholder="{{ ___('course.Pass Marks') }}" value="{{ old('pass_marks') }}" required/>
                            @error('pass_marks')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3 ">

                            <label for="details" class="form-label ">{{ ___('course.Assignment File') }}</label>

                            <div class="ot_fileUploader left-side mb-3 file-upload-browse">
                                <input class="form-control file_placeholder" type="text"
                                    placeholder="{{ ___('course.Assignment File') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="assignment_file">{{ ___('common.Browse') }}</label>
                                    <input type="file" class="d-none form-control" name="assignment_file"
                                        accept=".pdf,.doc,.docx" id="assignment_file">
                                </button>
                            </div>
                            @error('assignment_file')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="deadline" class="form-label ">{{ ___('course.Deadline') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <input type="datetime-local" class="form-control ot-input" id="deadline" name="deadline"
                                required placeholder="{{ ___('course.Deadline') }}" value="{{ old('deadline') }}" />
                            @error('deadline')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="note" class="form-label ">{{ ___('course.Note') }}</label>
                            <textarea class="form-control ot-input" id="note" name="note" placeholder="{{ ___('course.note') }}">{{ old('note') }}</textarea>
                            @error('note')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="status_id" class="form-label ">{{ ___('course.Status') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <select class="form-select ot-input select2" required id="status_id" name="status_id">
                                @foreach (assignmentType() as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mt-4">
                            <button type="submit" class="btn btn-lg ot-btn-primary">{{ ___('common.Create') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!--  category create end -->
    </div>
@endsection
