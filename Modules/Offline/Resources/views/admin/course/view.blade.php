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
                <form action="{{ @$data['url'] }}" method="POST">
                    @csrf
                    <div class="row mb-3 d-flex justify-content-center">
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="status_id" class="form-label">{{ ___('common.Invoice No') }}</label>
                            <span>
                                <h5 class="text-15">{{ @$data['order']->invoice_number }}</h5>
                            </span>
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="status_id" class="form-label">{{ ___('common.Payment Method') }}</label>
                            <span>
                                <h5 class="text-15">{{ @$data['order']->payment_method }}</h5>
                            </span>
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="status_id" class="form-label">{{ ___('offline.Payment Type') }}</label>
                            <span>
                                <h5 class="text-15">{{ @$data['order']->payment_manual['payment_type'] }}</h5>
                            </span>
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="status_id" class="form-label">{{ ___('offline.Additional_Details') }}</label>
                            <span>
                                <h5 class="text-15">{{ @$data['order']->payment_manual['additional_details'] }}</h5>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group d-flex justify-content-end">
                                <button type="submit" class="btn btn-lg ot-btn-primary close-modal">{{ @$data['button'] }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
