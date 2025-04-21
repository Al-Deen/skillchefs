<div class="modal fade lead-modal" id="lead-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-header modal-header-image mb-3">
                <h5 class="modal-title">{{ @$data['title'] }} </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ $data['url'] }}" method="post" id="modal_values"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3 d-flex justify-content-center">
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="course_id" class="form-label ">{{ ___('common.Course') }} <span
                                    class="fillable">*</span></label>
                            <select class="form-select ot-input course_list" id="course_id" required
                                data-url="{{ route('admin.featured-course.select') }}" name="course_id">
                                @if (@$data['featured_course'])
                                    <option value="{{ $data['featured_course']->course_id }}" selected>
                                        {{ $data['featured_course']->course->title }}</option>
                                @else
                                    <option value="" selected>
                                        {{ ___('common.Select Course') }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="status_id" class="form-label ">{{ ___('common.Status') }}
                                <span class="fillable">*</span></label>
                            <select class="form-select ot-input modal_select2" id="status_id" required
                                name="status_id">
                                <option value="1"
                                    {{ @$data['featured_course']->status_id == 1 ? ' selected' : '' }}>
                                    {{ ___('common.Active') }}</option>
                                <option value="2"
                                    {{ @$data['featured_course']->status_id == 2 ? ' selected' : '' }}>
                                    {{ ___('common.Inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group d-flex justify-content-end">
                                <button type="button" onclick="submitForm()"
                                    class="btn btn-lg ot-btn-primary">{{ @$data['button'] }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
