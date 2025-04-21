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
                        <h5 class="title text-capitalize font-500">
                            {{ $data['assignmentSubmission']->assignment->title }}
                        </h5>
                        <small class="text-12 text-tertiary font-500">{{ ___('instructor.Marks') }} :
                            {{ $data['assignmentSubmission']->assignment->marks }}</small>
                    </span>
                    <div class="d-flex align-items-center  note_action">
                        <span class="gap-3 text-tertiary text-14">
                            <i class="ri-time-line"></i>
                        </span>
                        <span class="assignment-date ms-1 text-14">
                            {{ date('d M Y, h:i a', strtotime($data['assignmentSubmission']->created_at)) }}</span>
                        <div class="edits">
                        </div>
                    </div>

                </div>
                @if (@$data['assignmentSubmission']->assignment->assignmentFile)
                    <h6 class="title mb-25 mb-20">
                        <strong class="font-500">{{ ___('instructor.Attachment') }} : </strong>
                        <a class="ms-5 status-primary"
                            href="{{ route('admin.assignment.download', (@$data['assignmentSubmission']->assignment_id)) }}">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </h6>
                @endif
                <h6 class="title title mb-25 mb-20">
                    <strong>{{ ___('instructor.Details') }} : </strong>
                    <p class="pera mb-6">
                        <?= $data['assignmentSubmission']->assignment->details ?>
                    </p>
                </h6>
                @if ($data['assignmentSubmission']->assignment->note)
                    <h6 class="title mb-25 mt-25">
                        <strong>{{ ___('instructor.Note') }} : </strong>
                        <p class="pera mb-6">
                            <?= $data['assignmentSubmission']->assignment->note ?>
                        </p>
                    </h6>
                @endif

                <div class="border-bottom mb-20">
                    <h4 class="title text-16 text-capitalize font-500 mb-8 mt-20">
                        <strong>{{ ___('instructor.Submission Info') }} </strong>
                    </h4>
                </div>
                @if (@$data['assignmentSubmission']->assignmentFile)
                    <h6 class="title mb-25 ">
                        <strong>{{ ___('instructor.Submission File') }} : </strong>
                        <a class="ms-5 status-primary"
                            href="{{ route('admin.assignment_submission.download', (@$data['assignmentSubmission']->id)) }}">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </h6>
                @endif

                @if (@$data['assignmentSubmission']->is_reviewed)
                    <div class="border-bottom mb-20">
                        <h4 class="title text-18 text-capitalize font-500 mb-8">
                            <strong>{{ ___('instructor.Review') }} </strong>
                        </h4>
                    </div>
                    <h6 class="title mb-25 ">
                        <strong>{{ ___('instructor.Marks') }} : </strong>
                        <span class="ms-5 status-primary">
                            {{ $data['assignmentSubmission']->marks }}
                        </span>
                    </h6>
                    <h6 class="title mb-25 ">
                        <strong>{{ ___('instructor.Review') }} : </strong>
                        <p class="pera mb-6">
                            <?= $data['assignmentSubmission']->details ?>
                        </p>
                    </h6>
                @else
                    <form action="{{ $data['url'] }}" method="post" id="modal_values"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-xl-12 mb-3">
                                        <label for="title" class="form-label ">{{ ___('course.Marks') }}<span
                                                class="fillable">*</span></label>
                                        <input type="number" class="form-control ot-input" name="marks"
                                            placeholder="{{ ___('placeholder.Marks') }}" id="marks"
                                            value="{{ @$data['assignmentSubmission']->marks }}">
                                    </div>
                                    <div class="col-xl-12 col-md-12 mb-3">
                                        <label for="title" class="form-label ">{{ ___('course.Review') }}</label>
                                        <textarea class="form-control ot-input ckeditor-editor" rows="5" id="review" name="review"
                                            placeholder="{{ ___('placeholder.review') }}">{{ old('review') }}</textarea>
                                    </div>
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
                @endif
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('backend/assets/js/modal/__modal.min.js') }}"></script>
