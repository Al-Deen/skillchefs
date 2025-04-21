<div class="modal fade boostrap-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-body">
                <button type="button" class="close-icon" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
                <div class="custom-modal-body ">

                    <div class="d-flex justify-content-between small-tittle-two border-bottom mb-30 pb-8">
                        <span>
                            <h5 class="title text-capitalize font-600">
                                {{ $data['assignmentSubmission']->assignment->title }}
                            </h5>
                            <small class="text-12 text-tertiary">{{ ___('instructor.Marks') }} :
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
                        <h6 class="title mb-25">
                            <strong>{{ ___('instructor.Attachment') }} : </strong>
                            <a class="ms-5 status-primary"
                                href="{{ route('instructor.assignment.download', encryptFunction(@$data['assignmentSubmission']->assignment_id)) }}">
                                <i class="ri-download-2-fill"></i>
                            </a>
                        </h6>
                    @endif
                    <h6 class="title">
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
                        <h4 class="title text-18 text-capitalize font-600 mb-8">
                            <strong>{{ ___('instructor.Submission Info') }} </strong>
                        </h4>
                    </div>
                    @if (@$data['assignmentSubmission']->assignmentFile)
                        <h6 class="title mb-25 ">
                            <strong>{{ ___('instructor.Submission File') }} : </strong>
                            <a class="ms-5 status-primary"
                                href="{{ route('instructor.assignment_submission.download', encryptFunction(@$data['assignmentSubmission']->id)) }}"><i
                                    class="ri-download-2-fill"></i></a>
                        </h6>
                    @endif

                    @if (@$data['assignmentSubmission']->is_reviewed)
                        <div class="border-bottom mb-20">
                            <h4 class="title text-18 text-capitalize font-600 mb-8">
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
                        <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="ot-contact-form mb-24">
                                <label for="marks" class="ot-contact-label">{{ ___('course.Marks') }}</label>

                                <input type="number" class="form-control" name="marks"
                                    placeholder="{{ ___('placeholder.Marks') }}" id="marks"
                                    value="{{ $data['assignmentSubmission']->marks }}">
                            </div>

                            <div class="ot-contact-form mb-24">
                                <label for="review" class="ot-contact-label">{{ ___('course.Review') }}</label>
                                <textarea class="form-control ot-input ckeditor-editor" rows="5" id="review" name="review"
                                    placeholder="{{ ___('placeholder.review') }}">{{ old('review') }}</textarea>
                            </div>



                            <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                                <button class="btn-primary-fill" type="button"
                                    onclick="submitMainForm()">{{ @$data['button'] }}</button>
                                <button class="btn-primary-outline close-modal"
                                    type="button">{{ ___('common.Discard') }}</button>
                            </div>
                        </form>
                    @endif



                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/js/instructor/__modal.min.js') }}"></script>
