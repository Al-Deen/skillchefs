<div class="card ot-card">
    <div class="card-body">
        <form action="{{ @$data['url'] }}" enctype="multipart/form-data" method="post">
            @csrf
            {{-- Style Two --}}
            <div class="row mb-3 row mb-3 d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="title" class="form-label ">{{ ___('event.Title') }} <span
                                    class="fillable">*</span></label>
                            <input type="text" class="form-control ot-input @error('title') is-invalid @enderror"
                                name="title" list="datalistOptions" id="title" value="{{ $data['event']->title }}"
                                placeholder="{{ ___('placeholder.Event Title') }}">
                            @error('title')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="visibility_id" class="form-label ">{{ ___('event.Visibility') }} <span
                                    class="fillable">*</span></label>
                            <select class="form-select ot-input select2 @error('visibility_id') is-invalid @enderror"
                                id="visibility_id" name="visibility_id">
                                @foreach (courseVisibility() as $visibility)
                                    <option value="{{ $visibility->id }}"
                                        {{ @$data['event']->visibility_id == $visibility->id ? ' selected="selected"' : '' }}>
                                        {{ $visibility->name }}</option>
                                @endforeach
                            </select>
                            @error('visibility_id')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="status" class="form-label ">{{ ___('event.Event Type') }} <span
                                    class="fillable">*</span></label>
                            <select class="form-select ot-input select2 @error('event_type') is-invalid @enderror"
                                id="event_type" name="event_type">
                                <option selected="" disabled="" value="">
                                    {{ ___('event.Select Event Type') }}
                                </option>
                                @foreach (@$data['event_type'] as $event_type)
                                    <option value="{{ $event_type }}"
                                        {{ $data['event']->event_type == $event_type ? ' selected="selected"' : '' }}>
                                        {{ $event_type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_type')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="is_paid" class="form-label ">{{ ___('event.Is Paid') }} <span
                                    class="fillable">*</span></label>
                            <select class="form-select ot-input select2 @error('is_paid') is-invalid @enderror"
                                id="is_paid" name="is_paid">
                                <option selected="" disabled="" value="">
                                    {{ ___('event.Select') }}
                                </option>
                                @foreach (@$data['is_paid'] as $is_paid)
                                    <option value="{{ $is_paid->id }}"
                                        {{ $data['event']->is_paid == $is_paid->id ? 'selected' : '' }}>
                                        {{ $is_paid->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('is_paid')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- If Online Start --}}
                        <div id="if_online" class="@if ($data['event']->event_type == 'Online') d-block @else d-none @endif ">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="online_media" class="form-label ">{{ ___('event.Online Media') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('online_media') is-invalid @enderror"
                                        name="online_media" type="text" list="datalistOptions" id="online_media"
                                        value="{{ $data['event']->online_media }}"
                                        placeholder="{{ ___('placeholder.Online Media') }}">
                                    @error('online_media')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="online_link" class="form-label ">{{ ___('event.Online Link') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('online_link') is-invalid @enderror"
                                        name="online_link" type="text" list="datalistOptions" id="online_link"
                                        value="{{ $data['event']->online_link }}"
                                        placeholder="{{ ___('placeholder.Online Link') }}">
                                    @error('online_link')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="online_note" class="form-label ">{{ ___('event.Online Note') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('online_note') is-invalid @enderror"
                                        name="online_note" type="text" list="datalistOptions" id="online_note"
                                        value="{{ $data['event']->online_note }}"
                                        placeholder="{{ ___('placeholder.Online Note') }}">
                                    @error('online_note')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="online_welcome_media"
                                        class="form-label ">{{ ___('event.Welcome Media') }} <span
                                            class="fillable">*</span></label>
                                    <input
                                        class="form-control ot-input @error('online_welcome_media') is-invalid @enderror"
                                        name="online_welcome_media" type="text" list="datalistOptions"
                                        id="online_welcome_media" value="{{ $data['event']->online_welcome_media }}"
                                        placeholder="{{ ___('placeholder.Welcome Media') }}">
                                    @error('online_welcome_media')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- If Online End --}}

                        {{-- If Online Start --}}
                        <div id="if_offline" class="@if ($data['event']->event_type == 'Offline') d-block @else d-none @endif ">
                            <div class="row">
                                <div class="col-xl-12 mb-3">
                                    <label for="address" class="form-label ">{{ ___('event.Address') }} <span
                                            class="fillable">*</span></label>
                                    <input type="text"
                                        class="form-control ot-input @error('address') is-invalid @enderror"
                                        name="address" list="datalistOptions" id="address"
                                        value="{{ $data['event']->address }}"
                                        placeholder="{{ ___('placeholder.Event Address') }}">
                                    @error('address')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- If Online End --}}

                        {{-- If Paid Start --}}
                        <div id="if_paid" class="@if (old('is_paid') == 11) d-block @else d-none @endif ">
                            <div class="col-xl-6 col-md-6 mb-3">
                                <label for="title" class="form-label ">{{ ___('event.Ticket Price') }} <span
                                        class="fillable">*</span></label>
                                <input class="form-control ot-input @error('price') is-invalid @enderror"
                                    name="price" type="number" list="datalistOptions" id="price"
                                    value="{{ $data['event']->price }}"
                                    placeholder="{{ ___('placeholder.Ticket Price') }}">
                                @error('price')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        {{-- If Paid End --}}


                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="category" class="form-label ">{{ ___('event.Category') }} <span
                                    class="fillable">*</span></label>
                            <select class="form-select ot-input select2 @error('category') is-invalid @enderror"
                                id="category" name="category">
                                <option selected="" disabled="" value="">
                                    {{ ___('event.Select Category') }}
                                </option>
                                @foreach (@$data['categories'] as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $data['event']->category_id == $category->id ? ' selected="selected"' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="event_duration" class="form-label">{{ ___('event.Event Duration') }} <span
                                    class="fillable">*</span></label>
                            <input type="text"
                                class="form-control ot-input date-picker @error('event_duration') is-invalid @enderror"
                                name="event_duration" list="datalistOptions" date-picker id="event_duration"
                                placeholder="{{ ___('placeholder.Start Date') }}"
                                value="{{ $data['event']->startDateTime()->format('m/d/Y h:i A') . ' - ' . $data['event']->endDateTime()->format('m/d/Y h:i A') }}">
                            @error('event_duration')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" id="start_date" value="{{ $data['event']->startDateTime() }}">
                        <input type="hidden" id="end_date" value="{{ $data['event']->endDateTime() }}">

                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="registration_deadline" class="form-label ">{{ ___('event.Event Deadline') }}
                                <span class="fillable">*</span></label>
                            <input type="text"
                                class="form-control ot-input date-picker @error('registration_deadline') is-invalid @enderror"
                                name="registration_deadline" list="datalistOptions" date-picker
                                id="registration_deadline"
                                value="{{ $data['event']->deadlineDateTime()->format('m/d/Y h:i:A') }}"
                                placeholder="{{ ___('placeholder.Start Date') }}">
                            @error('registration_deadline')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="tags" class="form-label ">{{ ___('event.Tags') }} <span
                                    class="fillable">*</span>
                                <i title="Max 5 Tags" class="ri-information-line"></i>
                            </label>
                            <input type="text" class="form-control" name="tags" id="tags"
                                value="{{ @$data['event']->tags ? @$data['event']->tags : '' }}"
                                placeholder="{{ ___('placeholder.Add tags') }}">
                            @error('tags')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="max_participant" class="form-label ">{{ ___('event.Max Participant') }} <span
                                    class="fillable">*</span></label>
                            <input type="number"
                                class="form-control ot-input @error('max_participant') is-invalid @enderror"
                                name="max_participant" min="0" list="datalistOptions" id="max_participant"
                                value="{{ $data['event']->max_participant }}"
                                placeholder="{{ ___('placeholder.Event Max Participant') }}">
                            @error('max_participant')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <label for="show_participant" class="form-label ">{{ ___('event.Show Participant') }}
                                <span class="fillable">*</span></label>
                            <select
                                class="form-select ot-input select2 @error('show_participant') is-invalid @enderror"
                                id="visibility_id" name="show_participant">
                                <option selected="" disabled="" value="">
                                    {{ ___('event.Select Category') }}
                                </option>
                                @foreach ($data['show_participant'] as $visibility)
                                    <option value="{{ $visibility->id }}"
                                        {{ $data['event']->show_participant == $visibility->id ? ' selected="selected"' : '' }}>
                                        {{ $visibility->name }}</option>
                                @endforeach
                            </select>
                            @error('show_participant')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-12 col-md-12 mb-3">
                            <label for="description" class="form-label">{{ ___('label.Description') }}</label>
                            <textarea class="form-control ckeditor-editor @error('description') is-invalid @enderror" name="description"
                                id="description" rows="5" placeholder="{{ ___('placeholder.Enter Description') }}">{{ $data['event']->description }}</textarea>
                            @error('description')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-12 col-md-12">
                            <label for="thumbnail" class="form-label ">{{ ___('course.Thumbnail') }}</label>
                            <div @if (@$data['event']->thumbnail) data-val="{{ showImage(@$data['event']->image->original) }}" @endif
                                data-name="thumbnail" class="file @error('thumbnail') is-invalid @enderror"
                                data-height="200px "></div>
                            <small
                                class="text-muted">{{ ___('placeholder.NB : Thumbnail size will 1920px x 680px and not more than 1mb') }}</small>
                            @error('thumbnail')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3">
                    <button class="btn btn-lg ot-btn-primary" type="submit"></span>{{ @$data['button'] }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
