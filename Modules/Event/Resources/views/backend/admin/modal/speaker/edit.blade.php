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
                <form action="{{ @$data['url'] }}" method="post" id="modal_values" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3 p-2 mb-3 d-flex justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xl-12 mb-3">
                                    <label for="name" class="form-label ">{{ ___('event.Speaker Name') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input type="text" class="form-control ot-input " name="name" id="name" value="{{ $data['speaker']->name }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="designation" class="form-label ">{{ ___('event.Designation') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input type="text" class="form-control ot-input " name="designation" id="designation" value="{{ $data['speaker']->designation }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="title" class="form-label ">{{ ___('event.Profile Image') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input type="file" class="form-control ot-input " name="image" id="image">
                                    <small class="text-muted">
                                        {{ ___('placeholder.NB : Image size will 100px x 100px and not more than 1mb') }}
                                    </small>
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="degree" class="form-label ">
                                        {{ ___('event.Status') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <select class="ot-contact modal_select2" required id="status_id" name="status_id">
                                        <option value="1" {{ $data['speaker']->status_id === '1'? 'selected':'' }}>{{ ___('common.Active') }}</option>
                                        <option value="2" {{ $data['speaker']->status_id === '2'? 'selected':'' }}>{{ ___('common.Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" onclick="submitForm()"
                            class="btn btn-lg ot-btn-primary">{{ @$data['button'] }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
