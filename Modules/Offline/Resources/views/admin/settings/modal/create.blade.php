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
                <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values"
                    enctype="multipart/form-data">
                    @csrf


                    <div class="row">
                        <!-- start title -->
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="name" class="form-label ">
                                {{ ___('course.Name') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <input type="text" class="form-control ot-input" id="name" name="name"
                                placeholder="{{ ___('offline.name') }}" value="{{ @$data['setting']->name }}"
                                required />
                        </div>
                        <!-- end title -->
                        <!-- start status -->
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="status" class="form-label ">
                                {{ ___('course.Status') }}
                                <span class="fillable">*</span></label>
                            </label>
                            <select class="form-select ot-input modal_select2" id="status" name="status" required>
                                <option {{ @$data['setting']->status == 1 ? 'selected' : '' }} value="1">
                                    {{ ___('common.Active') }}
                                </option>
                                <option {{ @$data['setting']->status == 2 ? 'selected' : '' }} value="2">
                                    {{ ___('common.Inactive') }}
                                </option>
                            </select>
                        </div>
                        <!-- end status -->

                        <div class="form-group d-flex justify-content-end mt-2">
                            <button type="button" onclick="submitForm()"
                                class="btn btn-lg ot-btn-primary">{{ @$data['button'] }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
