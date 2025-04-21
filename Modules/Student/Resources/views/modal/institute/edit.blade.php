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
                                    <label for="name" class="form-label ">
                                        {{ ___('instructor.Institute') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ @$data['institute']['name'] }}"
                                        placeholder="{{ ___('instructor.Daffodil International University') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="program" class="form-label ">
                                        {{ ___('instructor.Program') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input @error('program') is-invalid @enderror"
                                        name="program" id="program" value="{{ @$data['institute']['program'] }}"
                                        placeholder="{{ ___('placeholder.Ex: Computer Science and Engineering') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="degree" class="form-label ">
                                        {{ ___('instructor.Degree') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input @error('degree') is-invalid @enderror"
                                        name="degree" id="degree" value="{{ @$data['institute']['degree'] }}"
                                        placeholder="{{ ___('placeholder.Ex: Bachelor') }}">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="start_date" class="form-label ">
                                        {{ ___('instructor.Start Date') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input @error('start_date') is-invalid @enderror"
                                        value="{{ date('Y-m-d', strtotime(@$data['institute']['start_date']) ) }}" name="start_date"
                                        id="start_date" type="date">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            {{  @$data['institute']['current'] ? 'checked' : '' }} name="current"
                                            id="current">
                                        <label class="form-check-label"
                                            for="current">{{ ___('instructor.Currently studying here') }}</label>
                                    </div>
                                </div>


                                <div
                                    class="col-xl-12 mb-3 end_date_div {{ @$data['institute']['current'] ? 'd-none' : '' }}">
                                    <label for="end_date" class="form-label ">
                                        {{ ___('instructor.End Date') }}
                                        <span class="fillable">*</span>
                                    </label>
                                    <input class="form-control ot-input @error('end_date') is-invalid @enderror"
                                        value="{{ date('Y-m-d', strtotime(@$data['institute']['end_date']) ) }}" name="end_date" id="end_date"
                                        type="date">
                                </div>
                                <div class="col-xl-12 mb-3">
                                    <label for="description" class="form-label ">
                                        {{ ___('instructor.Description') }}
                                    </label>
                                    <textarea class="ot-textarea form-control  @error('description') is-invalid @enderror" id="text" rows="6"
                                        placeholder="{{ ___('instructor.description') }}" name="description" id="" rows="10"><?= @$data['institute']['description'] ?></textarea>
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
