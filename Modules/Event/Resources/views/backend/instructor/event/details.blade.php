<div class="tab-pane fade show active">
    <div class="col-xl-12">
        <div
            class="small-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap gap-10 mb-20 pb-8">
            <div class="country d-flex align-items-center ">
                <i class="ri-pencil-line"></i>
                <span class="country text-title font-600 ml-10">{{ ___('event.General') }}</span>
            </div>
        </div>
    </div>
    <form class="mt-20" action="{{ route('instructor.event.update', encryptFunction($data['event']->id)) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Event Title -->
            <div class="col-lg-6">
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.Title') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" type="text" name="title" id="title"
                        value="{{ $data['event']->title }}" placeholder="{{ ___('event.Event Title') }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('label.Visibility') }} <span class="text-danger">*</span>
                    </label>
                    <select class="form-select ot-input select2 @error('visibility_id') is-invalid @enderror" id="visibility_id"
                        required name="visibility_id">
                        @foreach (courseVisibility() as $visibility)
                            <option value="{{ $visibility->id }}"
                                {{ @$data['event']->visibility_id == $visibility->id ? ' selected="selected"' : '' }}>
                                {{ $visibility->name }}</option>
                        @endforeach
                    </select>
                    @error('visibility_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Select Categories -->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.Event Type') }} <span class="text-danger">*</span>
                    </label>
                    <select class="form-control ot-contact-input select2" id="event_type" name="event_type">
                        <option selected="" disabled="" value="">
                            {{ ___('event.Select Event Type') }}
                        </option>
                        @foreach (@$data['event_type'] as $event_type)
                            <option value="{{ $event_type }}"
                                {{ $data['event']->event_type == $event_type ? ' selected="selected"' : '' }}>
                                {{ $event_type }}</option>
                        @endforeach
                    </select>
                    @error('event_type')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Select Categories -->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.Is Paid') }} <span class="text-danger">*</span>
                    </label>
                    <select class="form-control ot-contact-input select2" id="is_paid" name="is_paid">
                        <option selected="" disabled="" value="">
                            {{ ___('event.Select') }}
                        </option>
                        @foreach (@$data['is_paid'] as $is_paid)
                            <option value="{{ $is_paid->id }}"
                                {{ $data['event']->is_paid == $is_paid->id ? 'selected' : '' }}>
                                {{ $is_paid->name }}</option>
                        @endforeach
                    </select>
                    @error('is_paid')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            {{-- If Online Start --}}
            <div id="if_online" class="@if ($data['event']->event_type == 'Online') d-block @else d-none @endif ">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('event.Online Media') }} </label>
                            <input class="form-control" type="text" name="online_media" id="online_media"
                                value="{{ $data['event']->online_media }}"
                                placeholder="{{ ___('event.Event Online Media') }}">
                            @error('online_media')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('event.Online Link') }}</label>
                            <input class="form-control" type="text" name="online_link" id="online_link"
                                value="{{ $data['event']->online_link }}"
                                placeholder="{{ ___('event.Event Online Link') }}">
                            @error('online_link')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('event.Online Note') }} </label>
                            <input class="form-control" type="text" name="online_note" id="online_note"
                                value="{{ $data['event']->online_note }}"
                                placeholder="{{ ___('event.Event Online Note') }}">
                            @error('online_note')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('event.Welcome Media') }}</label>
                            <input class="form-control" type="text" name="online_welcome_media" id="online_welcome_media"
                                value="{{ $data['event']->online_welcome_media }}"
                                placeholder="{{ ___('event.Event welcome Note') }}">
                            @error('online_welcome_media')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- If Online End --}}
            {{-- If Offline Start --}}
            <div id="if_offline" class="@if ($data['event']->event_type == 'Offline') d-block @else d-none @endif ">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('event.Address') }} <span class="text-danger">*</span> </label>
                            <input class="form-control" type="text" name="address" id="address" value="{{ $data['event']->address }}"
                                placeholder="{{ ___('event.Event Address') }}">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- If Offline End --}}
            {{-- If Paid Start --}}
            <div id="if_paid" class="@if ($data['event']->is_paid == 11) d-block @else d-none @endif ">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ot-contact-form mb-24">
                            <label class="ot-contact-label">{{ ___('event.Ticket Price') }} <span
                                    class="text-danger">*</span> </label>
                            <input class="form-control" type="number" name="price" id="price"
                                value="{{ $data['event']->price }}" placeholder="{{ ___('event.Ticket Price') }}">
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            {{-- If Paid End --}}

            <div class="col-lg-6">
                <!-- Select Categories -->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.Category') }} <span class="text-danger">*</span>
                    </label>
                    <select class="form-control ot-contact-input select2" id="category" name="category">
                        <option selected="" disabled="" value="">
                            {{ ___('event.Select Category') }}
                        </option>
                        @foreach (@$data['categories'] as $category)
                            <option value="{{ $category->id }}"
                                {{ $data['event']->category_id == $category->id ? ' selected="selected"' : '' }}>
                                {{ $category->title }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.Event Duration') }} <span
                            class="text-danger">*</span></label>
                    <input
                        class="form-control ot-contact-input date-picker @error('event_duration') is-invalid @enderror"
                        date-picker type="text" name="event_duration"
                        value="{{ $data['event']->startDateTime()->format('m/d/Y h:i A') . ' - ' . $data['event']->endDateTime()->format('m/d/Y h:i A') }}"
                        placeholder="{{ ___('event.Start Date') }}">
                    @error('event_duration')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <input type="hidden" id="start_date" value="{{ $data['event']->startDateTime() }}">
            <input type="hidden" id="end_date" value="{{ $data['event']->endDateTime() }}">
            <div class="col-lg-6 col-md-6">
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.Event Deadline') }} <span
                            class="text-danger">*</span></label>
                    <input
                        class="form-control ot-contact-input date-picker @error('registration_deadline') is-invalid @enderror"
                        date-picker type="text" name="registration_deadline" id="registration_deadline"
                        value="{{ $data['event']->deadlineDateTime()->format('m/d/Y h:i:A') }}"
                        placeholder="{{ ___('event.Start Date') }}">
                    @error('registration_deadline')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="settings-expertise-content">
                    <div class="ot-contact-form position-relative mb-24">
                        <label class="ot-contact-label">{{ ___('event.Tags') }} <span class="text-danger">*</span> <i
                                title="Max 5 Tags" class="ri-information-line"></i></label>
                        <input class="tagify--outside" type="text" placeholder="{{ ___('event.Add tags') }}"
                            name="tags" id="tags"
                            value="{{ @$data['event']->tags ? @$data['event']->tags : '' }}">
                        @error('tags')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.Max Participant') }} <span
                            class="text-danger">*</span> </label>
                    <input class="form-control" type="number" name="max_participant" id="max_participant"
                        value="{{ $data['event']->max_participant }}"
                        placeholder="{{ ___('event.Event max_participant') }}">
                    @error('max_participant')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.Show Participant') }} <span
                            class="text-danger">*</span> </label>
                    <select class="form-control ot-contact-input select2" id="visibility_id" required
                        name="show_participant">
                        @foreach ($data['show_participant'] as $visibility)
                            <option value="{{ $visibility->id }}"
                                {{ $data['event']->show_participant == $visibility->id ? ' selected="selected"' : '' }}>
                                {{ $visibility->name }}</option>
                        @endforeach
                    </select>
                    @error('show_participant')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <!-- Course Descriptions-->
                <div class="ot-contact-form mb-24">
                    <label class="ot-contact-label">{{ ___('event.description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control summernote" placeholder="{{ ___('event.Enter Description') }}" name="description"
                        id="description">{{ $data['event']->description }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <!-- Course Price -->
                <div class="ot-contact-form mb-15">
                    <label class="ot-contact-label">{{ ___('label.Thumbnail') }} <span class="text-danger">*</span></label>
                    <div @if (@$data['event']->thumbnail) data-val="{{ showImage(@$data['event']->image->original) }}" @endif
                        data-name="thumbnail" class="file" data-height="200px "></div>
                    <small
                        class="text-muted">{{ ___('placeholder.NB : Thumbnail size will 1920px x 680px and not more than 1mb') }}</small>
                    <div id="thumbnail"></div>
                    @error('thumbnail')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex aling-items-center flex-wrap gap-10 mb-20">
            <button class="btn-primary-fill" type="submit"> {{ ___('event.Post') }}</button>
        </div>
    </form>
</div>
