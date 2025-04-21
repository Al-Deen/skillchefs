<div class="multiStep-wrapper-contents active ">
    <div class="card mb-24 border-0 pt-0">
        <div class="card-body pt-0">

            <div class="row">
                {{-- start Assaignment  --}}
                <div class="col-xl-12 col-md-12 mb-3">
                    <!--  course assignment start -->
                    @if (url()->current() === route('course.edit', [$data['course']->id, 'assignment']))
                        <div class="row mb-3">
                            <div class="col-xl-12 col-md-12 mb-3">
                                <div class="content">
                                    <h3>
                                        {{ ___('course.Assignment List') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="table-content table-basic ecommerce-components product-list ">
                            <!--  toolbar table start  -->
                            <div
                                class="table-toolbar d-flex flex-wrap gap-2 flex-column flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">

                                <div class="align-self-center">
                                    <div
                                        class="d-flex flex-wrap gap-2 flex-column flex-lg-row justify-content-center align-content-center">
                                        <!-- show per page -->
                                        @include('backend.ui-components.ajax-per-page')
                                        <!-- show per page end -->
                                        <div class="align-self-center d-flex gap-2">
                                            <!-- search start -->
                                            <div class="align-self-center">
                                                <div class="search-box d-flex">
                                                    <input class="form-control" placeholder="{{ ___('common.search') }}"
                                                        name="assignmentSearch" autocomplete="off" />
                                                    <span class="icon"><i
                                                            class="fa-solid fa-magnifying-glass"></i></span>
                                                </div>
                                            </div>
                                            <!-- search end -->

                                            <!-- dropdown action -->
                                            <div class="align-self-center">
                                                <div class="dropdown dropdown-action" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Filter">
                                                    <button type="button" class="btn-add"
                                                        onclick="courseAssignmentLoad()">
                                                        <span class="icon">{{ ___('common.Filter') }}
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- add btn start -->
                                @if (hasPermission('course_assignment_create'))
                                    <div class="align-self-center d-flex gap-2">
                                        <!-- add btn -->
                                        <div class="align-self-center">
                                            <a href="{{ route('course.edit', [$data['course']->id, 'assignment-create']) }}"
                                                role="button" class="btn-add" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="{{ ___('course.Add') }}">
                                                <span><i class="fa-solid fa-plus"></i>
                                                </span>
                                                <span class="d-none d-xl-inline">{{ ___('common.add') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <!-- add btn end -->
                            </div>
                            <!--toolbar table end -->
                            <div class="course-assignment-lod"
                                data-href="{{ route('course.get-assignment', $data['course']->id) }}">

                            </div>


                        </div>
                        <!--  course assignment end -->
                    @elseif(@$data['assignment'])
                        <!--  title Course create -->
                        <div class="row mb-3">
                            <div class="col-xl-12 col-md-12 mb-3">
                                <div class="content">
                                    <h3>{{ ___('common.Edit') }}
                                        {{ ___('course.Assignment') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('course.assignment.update', $data['assignment']->id) }}" method="POST"
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
                                        value="{{ @$data['assignment']->title }}"
                                        placeholder="{{ ___('course.Title') }}" value="{{ old('title') }}"
                                        required />
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
                                    <textarea class="form-control ot-input" id="details" name="details" required
                                        placeholder="{{ ___('course.details') }}">
                                    {{ @$data['assignment']->details }}
                                </textarea>
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
                                    <input type="number" class="form-control ot-input" id="marks" name="marks"
                                        required placeholder="{{ ___('course.Marks') }}"
                                        value="{{ @$data['assignment']->marks }}" />
                                    @error('marks')
                                        <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-12 col-md-12 mb-3 ">

                                    <label for="details"
                                        class="form-label ">{{ ___('course.Assignment File') }}</label>

                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text"
                                            placeholder="{{ ___('course.Assignment File') }}" readonly=""
                                            id="placeholder">
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
                                    <input type="datetime-local" class="form-control ot-input" id="deadline"
                                        name="deadline" required placeholder="{{ ___('course.Deadline') }}"
                                        value="{{ @$data['assignment']->deadline }}" />
                                    @error('deadline')
                                        <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-xl-12 col-md-12 mb-3">
                                    <label for="note" class="form-label ">{{ ___('course.Note') }}</label>
                                    <textarea class="form-control ot-input" id="note" name="note" placeholder="{{ ___('course.note') }}">{{ @$data['assignment']->note }}</textarea>
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
                                    <select class="form-select ot-input select2" required id="status_id"
                                        name="status_id">
                                        @foreach (assignmentType() as $type)
                                            <option
                                                {{ @$data['assignment']->status_id == $type->id ? 'selected' : '' }}
                                                value="{{ $type->id }}">
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
                                <div class="col-xl-12 col-md-12 mb-3">
                                    <button type="submit"
                                        class="btn btn-lg ot-btn-primary">{{ ___('common.Update') }}</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <!--  course assignment create start -->
                        <!--  title Course create -->
                        <div class="row mb-3">
                            <div class="col-xl-12 col-md-12 mb-3">
                                <div class="content">
                                    <h3>{{ ___('course.Add') }}
                                        {{ ___('course.Assignment') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('course.assignment.store', $data['course']->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12 col-md-12 mb-3">
                                    <label for="title" class="form-label ">
                                        {{ ___('course.Title') }}
                                        <span class="fillable">*</span></label>
                                    </label>
                                    <input type="text" class="form-control ot-input" id="title"
                                        name="title" placeholder="{{ ___('course.Title') }}"
                                        value="{{ old('title') }}" required />
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
                                    <textarea class="form-control ot-input" id="details" name="details" required
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
                                    <input type="number" class="form-control ot-input" id="marks"
                                        name="marks" required placeholder="{{ ___('course.Marks') }}"
                                        value="{{ old('marks') }}" />
                                    @error('marks')
                                        <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-12 col-md-12 mb-3 ">

                                    <label for="details"
                                        class="form-label ">{{ ___('course.Assignment File') }}</label>

                                    <div class="ot_fileUploader left-side mb-3">
                                        <input class="form-control" type="text"
                                            placeholder="{{ ___('course.Assignment File') }}" readonly=""
                                            id="placeholder">
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
                                    <input type="datetime-local" class="form-control ot-input" id="deadline"
                                        name="deadline" required placeholder="{{ ___('course.Deadline') }}"
                                        value="{{ old('deadline') }}" />
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
                                    <select class="form-select ot-input select2" required id="status_id"
                                        name="status_id">
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
                                <div class="col-xl-12 col-md-12 mb-3">
                                    <button type="submit"
                                        class="btn btn-lg ot-btn-primary">{{ ___('common.Create') }}</button>
                                </div>
                            </div>
                        </form>
                    @endif

                </div>
                {{-- end Assaignment  --}}

            </div>
        </div>
    </div>
</div>
