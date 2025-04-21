<div class="multiStep-wrapper-contents active">
    <div class="card mb-24 border-0 pt-0">
        <div class="card-body pt-0">

            <div class="row">
                {{-- start Assaignment  --}}
                <div class="col-xl-12 col-md-12 mb-3">
                    <!--  course noticeboard start -->
                    @if (url()->current() === route('course.edit', [$data['course']->id, 'noticeboard']))
                        <div class="row mb-3">
                            <div class="col-xl-12 col-md-12 mb-3">
                                <div class="content">
                                    <h3>
                                        {{ ___('course.Noticeboard List') }}
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
                                                        name="noticeboardSearch" autocomplete="off" />
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
                                                        onclick="courseNoticeboardLoad()">
                                                        <span class="icon">{{ ___('common.Filter') }}
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- add btn start -->
                                @if (hasPermission('course_noticeboard_create'))
                                    <div class="align-self-center d-flex gap-2">
                                        <!-- add btn -->
                                        <div class="align-self-center">
                                            <a href="{{ route('course.edit', [$data['course']->id, 'noticeboard-create']) }}"
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
                            <div class="course-noticeboard-load"
                                data-href="{{ route('course.get-noticeboard', $data['course']->id) }}">

                            </div>


                        </div>
                        <!--  course assignment end -->
                    @elseif(@$data['noticeboard'])
                        <!--  title Course create -->
                        <div class="row mb-3">
                            <div class="col-xl-12 col-md-12 mb-3">
                                <div class="content">
                                    <h3>{{ ___('common.Edit') }}
                                        {{ ___('course.NoticeBoard') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
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
                                        value="{{ @$data['noticeboard']->title }}"
                                        placeholder="{{ ___('course.Title') }}" value="{{ old('title') }}"
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
                                    <textarea class="form-control ot-input" id="description" name="description" required
                                        placeholder="{{ ___('course.description') }}">
                                    {{ @$data['noticeboard']->description }}
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
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="notify"
                                                {{ @$data['noticeboard']->is_send_mail ? 'checked' : '' }}
                                                name="is_send_mail">
                                            <label class="form-check-label"
                                                for="notify">{{ ___('course.Is it free course') }}</label>
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
                                        {{ ___('course.Noticeboard') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('course.notice-board.store', $data['course']->id) }}" method="POST"
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
                                    <label for="description" class="form-label ">{{ ___('course.Description') }}
                                        <span class="fillable">*</span></label>
                                    </label>
                                    <textarea class="form-control ot-input" id="description" name="description" required
                                        placeholder="{{ ___('course.description') }}">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-12 col-md-12 mb-3">
                                    <div class="input-check-radio">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="notify" {{ old('is_send_mail') ? 'checked' : '' }}
                                                name="is_send_mail">
                                            <label class="form-check-label"
                                                for="notify">{{ ___('course.Is it free course') }}</label>
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
