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
                            <label for="name" class="form-label ">{{ ___('common.name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input" name="name" list="datalistOptions"
                                id="name" value="{{ @$data['account']->name }}"
                                placeholder="{{ ___('placeholder.Enter_Name') }}">
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="ac_name" class="form-label ">{{ ___('common.Account_Name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input" name="ac_name" list="datalistOptions"
                                id="ac_name" value="{{ @$data['account']->ac_name }}"
                                placeholder="{{ ___('placeholder.Enter Account Name') }}">
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="ac_number" class="form-label ">{{ ___('common.Account_Number') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input" name="ac_number" list="datalistOptions"
                                id="ac_number" value="{{ @$data['account']->ac_number }}"
                                placeholder="{{ ___('placeholder.Enter_Account_Number') }}">
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="code" class="form-label ">{{ ___('common.Code') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input" name="code" list="datalistOptions"
                                id="code" value="{{ @$data['account']->code }}"
                                placeholder="{{ ___('placeholder.Enter Code') }}">
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="branch" class="form-label ">{{ ___('common.Branch') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input" name="branch" list="datalistOptions"
                                id="branch" value="{{ @$data['account']->branch }}"
                                placeholder="{{ ___('placeholder.Enter_Branch') }}">
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="balance" class="form-label ">{{ ___('common.Balance') }}</label>
                            <input class="form-control ot-input" type="number" name="balance"
                                placeholder="{{ ___('placeholder.Enter_Balance') }}" list="datalistOptions"
                                id="balance" value="{{ @$data['account']->balance }}">
                        </div>
                        <div class="col-xl-12 mb-3">
                            <label for="status" class="form-label ">{{ ___('common.Status') }}
                                <span class="fillable">*</span></label>
                            <select
                                class="form-select ot-input modal_select2 @error('status_id') is-invalid @enderror"
                                id="status_id" required name="status_id">
                                <option value="1"
                                    {{ @$data['account']->status_id == 1 ? ' selected' : '' }}>
                                    {{ ___('common.Active') }}</option>
                                <option value="2"
                                    {{ @$data['account']->status_id == 2 ? ' selected' : '' }}>
                                    {{ ___('common.Inactive') }}</option>
                            </select>
                            @error('status_id')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1"
                                    {{ @$data['account']->is_default ? 'checked' : '' }} name="is_default"
                                    id="is_default">
                                <label class="form-check-label"
                                    for="is_default">{{ ___('common.Default') }}</label>
                            </div>
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
