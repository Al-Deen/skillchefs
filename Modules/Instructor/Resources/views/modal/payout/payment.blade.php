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
                    <div class="row mb-3 p-2 mb-3 d-flex justify-content-center">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xl-12 mb-3">
                                    <label for="amount" class="form-label ">
                                        {{ ___('instructor.Amount') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="ot-input form-control" id="amount" name="amount" disabled
                                        value="{{ @$data['payout']->amount }}" rows="10"></input>
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="note" class="form-label ">
                                        {{ ___('instructor.Note') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <textarea class="ot-textarea form-control" id="note" rows="6" placeholder="{{ ___('instructor.Note') }}"
                                        name="note" rows="10"></textarea>
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
