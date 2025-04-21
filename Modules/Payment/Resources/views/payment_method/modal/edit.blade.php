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
                        <div class="col-xl-12 mb-3">
                            <label for="title" class="form-label ">{{ ___('common.Title') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('title') is-invalid @enderror"
                                name="title" list="datalistOptions" id="title"
                                value="{{ @$data['payment']->title }}"
                                placeholder="{{ ___('placeholder.Enter Title') }}">
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="Image" class="form-label ">{{ ___('course.Image File') }}</label>
                            <div class="ot_fileUploader left-side mb-2 file-upload-browse">
                                <input class="form-control file_placeholder" type="text" value="{{ @$data['payment']->image->name ?? '' }}"
                                    placeholder="{{ ___('course.Image File') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="image_file">{{ ___('common.Browse') }}</label>
                                    <input type="file" class="d-none form-control" name="image_file"
                                        accept=".png, .jpg, .jpeg" id="image_file">
                                </button>
                            </div>
                            <div class="invalid-feedback d-inline error-image_file"></div>
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="status" class="form-label ">{{ ___('common.Status') }}
                                <span class="fillable">*</span></label>
                            <select
                                class="form-select ot-input modal_select2 @error('status_id') is-invalid @enderror"
                                id="status" required name="status_id">
                                <option value="1"
                                    {{ @$data['payment']->status_id == 1 ? ' selected' : '' }}>
                                    {{ ___('common.Active') }}</option>
                                <option value="2"
                                    {{ @$data['payment']->status_id == 2 ? ' selected' : '' }}>
                                    {{ ___('common.Inactive') }}</option>
                            </select>
                            @error('status_id')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
