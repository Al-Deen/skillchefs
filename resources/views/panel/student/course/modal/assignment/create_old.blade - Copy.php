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
                                {{ $data['assignment']->title }}
                            </h5>
                            <small class="text-12 text-tertiary">{{ ___('student.Marks') }} :
                                {{ $data['assignment']->marks }}</small>
                        </span>
                        <div class="d-flex align-items-center  note_action">
                            <span class="gap-3 text-tertiary text-14">
                                <i class="ri-time-line"></i>
                            </span>
                            <span class="assignment-date ms-1 text-14">
                                {{ date('d M Y, h:i a', strtotime($data['assignment']->deadline)) }}</span>
                            <div class="edits">
                            </div>
                        </div>

                    </div>
                    @if ($data['assignment']->assignmentFile)
                        <h6 class="title mb-25">
                            <strong>{{ ___('student.Attachment') }} : </strong>
                            <a href="{{ route('student.assignment.download', [$data['enroll_id'], encryptFunction($data['assignment']->id)]) }}"
                                class="ms-5" href=""><i class="ri-download-2-fill"></i></a>
                        </h6>
                    @endif
                    <h6 class="title mb-25">
                        <strong>{{ ___('student.Details')}} : </strong>
                        <p class="pera mb-6">
                            <?= $data['assignment']->details ?>
                        </p>
                    </h6>
                    @if ($data['assignment']->note)
                        <h6 class="title mb-25 mt-25">
                            <strong>{{ ___('student.Note')}} : </strong>
                            <p class="pera mb-6">
                                <?= $data['assignment']->note ?>
                            </p>
                        </h6>
                    @endif
                    <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="ot-contact-form mb-24">
                            <label for="content" class="form-label ">{{ ___('course.File Upload') }}</label>
                            <div class="ot_fileUploader left-side mb-2 file-upload-browse">
                                <input class="form-control form-control file_placeholder" type="text"
                                    placeholder="{{ ___('student.Assignment File') }}" id="placeholder">
                                <button class="border-0" type="button">
                                    <label class="btn-uplode" for="assignment_file">{{ ___('student.Brouse') }}</label>
                                    <input type="file" class="d-none form-control" name="assignment_file"
                                        accept=".pdf,.doc,.docx" id="assignment_file">
                                </button>
                            </div>
                            <div class="invalid-feedback d-inline error-assignment_file"></div>
                        </div>



                        <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                            <button class="btn-primary-fill " type="button"
                                onclick="submitMainForm()">{{ @$data['button'] }}</button>
                            <button class="btn-primary-outline close-modal"
                                type="button">{{ ___('student.Discard') }}</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/js/student/__modal.min.js') }}"></script>
