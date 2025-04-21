<div class="multiStep-wrapper-contents active">
    <form action="{{ route('course.edit', [$data['course']->id,'general'])}}" enctype="multipart/form" method="post">
        @csrf
    <div class="card mb-24 border-0 pt-0">
        <div class="card-body pt-0">

            <div class="row">

                {{-- start title  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="title"
                        class="form-label ">{{ ___('course.Course Title') }}
                        <span class="fillable">*</span></label>
                    <input
                        class="form-control ot-input @error('title') is-invalid @enderror"
                        name="title" list="datalistOptions" id="title"
                        value="{{ @$data['course']->title }}"
                        placeholder="{{ ___('placeholder.Enter Title') }}">
                    @error('title')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end title  --}}

                {{-- start course type  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="course_type"
                        class="form-label ">{{ ___('course.Course Type') }}
                        <span class="fillable">*</span></label>
                    <select
                        class="form-select select2 @error('course_type') is-invalid @enderror"
                        id="course_type" name="course_type">
                        @foreach (courseType() as $type)
                            <option value="{{ $type->id }}"
                                {{ @$data['course']->course_type == $type->id ? ' selected="selected"' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_type')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end course type  --}}

                {{-- start cinstructor  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="instructor"
                        class="form-label ">{{ ___('common.Instructor') }}
                        <span class="fillable">*</span></label>
                    <select
                        class="form-select ot-input instructor_select @error('instructor') is-invalid @enderror"
                        id="instructor" name="instructor"
                        data-href="{{ route('ajax-instructor-list') }}">
                        @if (@$data['course']->instructor)
                            <option
                                value="{{ @$data['course']->instructor->id }}"
                                selected>
                                {{ @$data['course']->instructor->name }}
                            </option>
                        @else
                            <option selected="" disabled=""
                                value="">
                                {{ ___('common.Select Instructor') }}
                            </option>
                        @endif
                    </select>
                    @error('instructor')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end cinstructor  --}}
                {{-- start Partner cinstructor  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="partner_instructor"
                        class="form-label ">{{ ___('common.Partner Instructor') }}
                    </label>
                    <select
                        class="form-select ot-input instructor_select @error('partner_instructor') is-invalid @enderror"
                        id="partner_instructor" name="partner_instructor[]"
                        multiple="multiple"
                        data-href="{{ route('ajax-instructor-list') }}">
                        @if (@$data['course']->partner_instructors)
                            @foreach (@$data['course']->partnerInstructors() as $instructor)
                                <option value="{{ @$instructor->id }}"
                                    selected>
                                    {{ @$instructor->name }}
                                </option>
                            @endforeach
                        @endif
                        <option value="">
                            {{ ___('common.Select Partner Instructor') }}
                        </option>
                    </select>
                    @error('partner_instructor')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end  partner instructor  --}}

                {{-- start course level  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="course_level"
                        class="form-label ">{{ ___('course.Course Level') }}
                        <span class="fillable">*</span></label>
                    <select
                        class="form-select ot-input select2 @error('course_level') is-invalid @enderror"
                        id="course_level" name="course_level">
                        @foreach (courseLevel() as $level)
                            <option value="{{ $level->id }}"
                                {{ @$data['course']->level_id == $level->id ? ' selected="selected"' : '' }}>
                                {{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('course_level')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end course level  --}}

                {{-- start short description  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="short_description"
                        class="form-label ">{{ ___('common.Short Description') }}
                        <span class="fillable">*</span></label>
                    <textarea class="form-control ot-textarea @error('short_description') is-invalid @enderror" name="short_description"
                        id="short_description" rows="5" placeholder="{{ ___('placeholder.Enter Short Description') }}">
                        <?= @$data['course']->short_description ?>
                    </textarea>
                    @error('short_description')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end short description  --}}

                {{-- start description  --}}

                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="description"
                        class="form-label ">{{ ___('common.Description') }}
                        <span class="fillable">*</span></label>
                    <textarea class="form-control summernote @error('description') is-invalid @enderror" name="description"
                        id="description" rows="5" placeholder="{{ ___('placeholder.Enter Description') }}">
                        <?= @$data['course']->description ?>
                    </textarea>
                    @error('description')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end description  --}}

                {{-- start category  --}}

                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="category_id"
                        class="form-label ">{{ ___('common.Category') }}</label>
                    <select
                        class="form-select ot-input select2 @error('category') is-invalid @enderror"
                        id="category" name="category">
                        @foreach ($data['categories'] as $category)
                            <optgroup class="select2-result-selectable"
                                label="{{ $category->title }}">
                                @foreach (@$category->children as $child)
                                    <option value="{{ $child->id }}"
                                        {{ @$data['course']->course_category_id == $child->id ? ' selected="selected"' : '' }}>
                                        {{ $child->title }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('category')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end category  --}}

                {{-- start status  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="status_id"
                        class="form-label ">{{ ___('common.Status') }}<span
                            class="fillable">*</span></label>
                    <select
                        class="form-select ot-input select2 @error('status_id') is-invalid @enderror"
                        id="status_id" required name="status_id">
                        <option value="1"
                            {{ $data['course']->status_id == 1 ? 'selected' : '' }}>
                            {{ ___('common.Active') }}</option>
                        <option value="2"
                            {{ $data['course']->status_id == 2 ? 'selected' : '' }}>
                            {{ ___('common.Inactive') }}</option>
                    </select>
                    @error('status_id')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end status  --}}

                {{-- start visibility  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="visibility_id"
                        class="form-label ">{{ ___('common.Visibility') }}<span
                            class="fillable">*</span></label>
                    <select
                        class="form-select ot-input select2 @error('visibility_id') is-invalid @enderror"
                        id="visibility_id" required name="visibility_id">
                        @foreach (courseVisibility() as $visibility)
                            <option value="{{ $visibility->id }}"
                                {{ @$data['course']->visibility_id == $visibility->id ? ' selected="selected"' : '' }}>
                                {{ $visibility->name }}</option>
                        @endforeach
                    </select>
                    @error('visibility_id')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- end visibility  --}}

                {{-- start language  --}}
                <div class="col-xl-12 col-md-6 mb-3">
                    <label for="language"
                        class="form-label ">{{ ___('common.Language') }}<span
                            class="fillable">*</span></label>
                    <select
                        class="form-select ot-input select2 @error('language_id') is-invalid @enderror"
                        id="language" required name="language_id">
                        @foreach ($data['languages'] as $language)
                            <option value="{{ $language->code }}"
                                {{ @$data['course']->language == $language->code ? ' selected="selected"' : '' }}>
                                {{ $language->name }}</option>
                        @endforeach
                    </select>
                    @error('language_id')
                        <div id="validationServer04Feedback"
                            class="invalid-feedback error-show">
                            {{ $message }}
                        </div>
                    @enderror


                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12 mb-3">
                    <button type="submit"
                        class="btn btn-lg ot-btn-primary">{{ ___('common.Update') }}</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>