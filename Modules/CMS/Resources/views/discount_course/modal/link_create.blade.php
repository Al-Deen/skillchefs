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
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="name" class="form-label ">{{ ___('common.Name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('name') is-invalid @enderror"
                                name="name" list="datalistOptions" id="name"
                                value="{{ @$data['link']->name }}"
                                placeholder="{{ ___('placeholder.Enter Name') }}">
                            @error('name')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="status" class="form-label ">{{ ___('common.Status') }}
                                <span class="fillable">*</span></label>
                            <select
                                class="form-select ot-input modal_select2 @error('status_id') is-invalid @enderror"
                                id="status_id" required name="status_id">
                                <option value="1" {{ @$data['link']->status_id == 1 ? ' selected' : '' }}>
                                    {{ ___('common.Active') }}</option>
                                <option value="2" {{ @$data['link']->status_id == 2 ? ' selected' : '' }}>
                                    {{ ___('common.Inactive') }}</option>
                            </select>
                            @error('status_id')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="is_page"
                                    {{ @$data['link']->is_page ? 'checked' : '' }} id="is_page">
                                <label class="form-check-label ms-1"
                                    for="is_page">{{ ___('placeholder.Want to add Page?') }}</label>
                            </div>
                        </div>
                        <div
                            class="col-xl-12 col-md-12 mb-3 page_url @if (!@$data['link']->is_page) d-none @endif">
                            <label for="page" class="form-label ">{{ ___('common.Page') }}
                                <span class="fillable">*</span></label>
                            <select
                                class="form-select ot-input modal_select2 @error('page_id') is-invalid @enderror"
                                id="page_id" name="page_id">
                                @foreach ($data['pages'] as $page)
                                    <option value="{{ $page->id }}"
                                        {{ @$data['link']->page_id == $page->id ? ' selected' : '' }}>
                                        {{ $page->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div
                            class="col-xl-12 col-md-12 mb-3 custom_url @if (@$data['link']->is_page) d-none @endif">
                            <label for="link" class="form-label ">{{ ___('common.Link') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('link') is-invalid @enderror"
                                name="link" list="datalistOptions" id="link"
                                value="{{ @$data['link']->link }}"
                                placeholder="{{ ___('placeholder.Enter link') }}">
                            @error('link')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <small>{{ ___('placeholder.NB: Link should be start with https://') }}</small>
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
