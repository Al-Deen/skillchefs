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
                            <select class="form-select ot-input course_category_list" id="course_category_id" required
                                data-url="{{ route('course-category.list') }}" name="course_id">
                                <option value="" selected>
                                    {{ ___('common.Select_Course_Category') }}
                                </option>
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
