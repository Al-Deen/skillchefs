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
                                    <label for="title" class="form-label">{{ ___('event.Title') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input type="text" class="form-control ot-input" name="title" id="title" value="{{ old('title') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="details" class="form-label">{{ ___('event.Details') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <textarea class="ot-textarea form-control" name="details" id="details">{{ old('details') }}</textarea>
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="from_time" class="form-label ">{{ ___('event.Start Time') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input type="time" class="form-control ot-input" name="from_time" id="from_time" value="{{ old('from_time') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="to_time" class="form-label ">{{ ___('event.End Time') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input type="time" class="form-control ot-input" name="to_time" id="to_time" value="{{ old('to_time') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="location" class="form-label">{{ ___('event.Location') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input type="text" class="form-control ot-input" name="location" id="location" value="{{ old('location') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="degree" class="form-label">{{ ___('event.Status') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <select class="ot-contact modal_select2" required id="status_id" name="status_id">
                                        <option value="1">{{ ___('common.Active') }}</option>
                                        <option value="2">{{ ___('common.Inactive') }}</option>
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
