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
                <div class="d-flex justify-content-between small-tittle-two border-bottom mb-30 pb-8 pl-4 pr-4">
                    <span>
                        <h5 class="title text-capitalize font-600">
                            {{ $data['contact']->name }}
                        </h5>
                        <small class="text-12 text-tertiary">{{ ___('common.Subject') }} :
                            {{ $data['contact']->subject }}</small>
                    </span>
                    <div class="d-flex align-items-center  note_action">
                        <span class="gap-3 text-tertiary text-14">
                            <i class="ri-time-line"></i>
                        </span>
                        <span class="assignment-date ms-1 text-14">
                            {{ date('d M Y, h:i a', strtotime($data['contact']->created_at)) }}</span>
                        <div class="edits">
                        </div>
                    </div>

                </div>
                <h6 class="title">
                    <strong>{{ ___('common.Message') }} : </strong>
                    <p class="pera mb-6">
                        <?= $data['contact']->message ?>
                    </p>
                </h6>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
