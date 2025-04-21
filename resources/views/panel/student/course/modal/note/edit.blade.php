<div class="modal fade boostrap-modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content data">
            <div class="modal-body">
                <button type="button" class="close-icon" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-line" aria-hidden="true"></i>
                </button>
                <div class="custom-modal-body ">
                    <form action="{{ $data['url'] }}" class="row p-2" method="post" id="modal_values"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="small-tittle-two border-bottom mb-30 pb-8">
                            <h4 class="title text-capitalize font-600">{{ $data['title'] }} </h4>
                        </div>


                        <div class="ot-contact-form mb-24">
                            <label for="content" class="form-label ">{{ ___('course.Note') }}</label>
                            <textarea class="form-control ot-input ckeditor-editor" id="note" name="note"
                                placeholder="{{ ___('course.Note') }}"><?= $data['note']->description ?></textarea>
                            @error('note')
                                <div id="validationServer04Feedback" class="invalid-feedback error-show">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="btn-wrapper d-flex flex-wrap gap-10 mt-20">
                            <button class="btn-primary-fill" type="button"
                                onclick="submitForm()">{{ @$data['button'] }}</button>
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
