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

                        <div class="col-xl-12 col-md-12 mb-3 ">
                            <label for="purchase_code" class="form-label ">
                                {{ ___('addon.Purchase_Code') }}
                                <span class="fillable">*</span>
                            </label>
                            <input type="text" class="form-control ot-input" name="purchase_code" id="purchase_code"
                                placeholder="{{ ___('addon.Enter_Purchase_Code') }}">



                        </div>
                        <!-- start document_file -->
                        <div class="col-xl-12 col-md-12 mb-3 ">

                            <label for="Image" class="form-label ">
                                {{ ___('addon.Addon_File') }}
                                <span class="fillable">*</span>
                            </label>

                            <div class="ot_fileUploader left-side mb-2 file-upload-browse">
                                <input class="form-control file_placeholder" type="text"
                                    placeholder="{{ ___('addon.Choose_Addon_File') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary" for="addon_file">{{ ___('common.Browse') }}
                                        <input type="file" class="d-none form-control" name="addon_file"
                                            accept=".zip" id="addon_file">
                                </button>
                            </div>
                            <div class="invalid-feedback d-inline error-addon_file"></div>
                        </div>
                        <!-- end document_file -->
                        <div class="col-xl-12 col-md-12 mt-4">

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
