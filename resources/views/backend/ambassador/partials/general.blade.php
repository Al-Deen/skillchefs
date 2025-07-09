<div class="card ot-card">
    <div class="card-body">
        <form method="POST" action="{{ @$data['url'] }}" enctype="multipart/form-data">
            @csrf

            {{-- Style Two --}}
            <div class="row mb-3 row mb-3 d-flex justify-content-center">

                <div class="col-lg-6">
                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                        <h4 class="title text-capitalize font-600">
                            {{ ___('ambassador.Personal Information') }}
                        </h4>
                    </div>
                    <div class="row">

                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="name" class="form-label ">{{ ___('ambassador.Name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                value="{{ $data['ambassador']->user->name }}" id="name"
                                placeholder="{{ ___('placeholder.Enter Name') }}">
                            @error('name')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="phone" class="form-label ">{{ ___('ambassador.Phone') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('phone') is-invalid @enderror" name="phone"
                                value="{{ $data['ambassador']->user->phone }}" id="phone"
                                placeholder="{{ ___('placeholder.Enter Phone') }}">
                            @error('phone')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label ">{{ ___('ambassador.Date Of Birth') }} <span
                                    class="fillable">*</span></label>
                            <input type="date"
                                class="form-control ot-input @error('date_of_birth') is-invalid @enderror"
                                name="date_of_birth" value="{{ $data['ambassador']->date_of_birth }}"
                                id="date_of_birth">
                            @error('date_of_birth')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label ">{{ ___('ambassador.Gender') }} <span
                                    class="fillable">*</span></label>
                            <select class="select2 @error('gender') is-invalid @enderror" name="gender">
                                <option value="{{ App\Enums\Gender::MALE }}"
                                    @if (@$data['ambassador']->gender == App\Enums\Gender::MALE) {{ 'selected' }} @endif>
                                    {{ ___('ambassador.Male') }}</option>
                                <option value="{{ App\Enums\Gender::FEMALE }}"
                                    @if (@$data['ambassador']->gender == App\Enums\Gender::FEMALE) {{ 'selected' }} @endif>
                                    {{ ___('ambassador.Female') }}</option>
                                <option value="{{ App\Enums\Gender::OTHERS }}"
                                    @if (@$data['ambassador']->gender == App\Enums\Gender::OTHERS) {{ 'selected' }} @endif>
                                    {{ ___('ambassador.Others') }}</option>
                            </select>
                            @error('gender')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="address" class="form-label ">{{ ___('ambassador.Address') }} </label>
                            <input class="form-control ot-input @error('address') is-invalid @enderror" name="address"
                                value="{{ $data['ambassador']->address }}" id="address"
                                placeholder="{{ ___('placeholder.Enter Address') }}">
                            @error('address')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
{{--                        <div class="col-xl-12 col-md-6 mb-3">--}}
{{--                            <label for="address" class="form-label ">{{ ___('ambassador.Country') }} <span--}}
{{--                                    class="fillable">*</span></label>--}}

{{--                            <select class="ambassador_select @error('country_id') is-invalid @enderror" data-href="{{ url('/select/country-list') }}" name="country_id">--}}
{{--                                <option value="">{{ ___('placeholder.Select Country') }}</option>--}}
{{--                                @if (@$data['ambassador']->country_id)--}}
{{--                                    <option value="{{ @$data['ambassador']->country_id }}" selected>--}}
{{--                                        {{ @$data['ambassador']->country->name }}</option>--}}
{{--                                @endif--}}
{{--                            </select>--}}

{{--                            @error('country_id')--}}
{{--                                <div id="validationServer04Feedback" class="invalid-feedback">--}}
{{--                                    {{ $message }}--}}
{{--                                </div>--}}
{{--                            @enderror--}}



{{--                            @error('address')--}}
{{--                                <div id="validationServer04Feedback" class="invalid-feedback">--}}
{{--                                    {{ $message }}--}}
{{--                                </div>--}}
{{--                            @enderror--}}
{{--                        </div>--}}


                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="small-tittle-two border-bottom mb-20 pb-8">
                        <h4 class="title text-capitalize font-600">{{ ___('ambassador.About Information') }}
                        </h4>
                    </div>
                    <div class="row">

                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="designation" class="form-label ">
                                {{ ___('ambassador.Designation') }}
                                <span class="fillable">*</span>
                            </label>
                            <input class="form-control ot-input @error('designation') is-invalid @enderror"
                                value="{{ $data['ambassador']->designation }}" name="designation" id="designation"
                                placeholder="{{ ___('placeholder.Enter Designation') }}">
                            @error('designation')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="designation" class="form-label ">
                                {{ ___('ambassador.About') }}
                            </label>
                            <textarea class="ot-textarea form-control  @error('about_me') is-invalid @enderror" id="text" rows="6"
                                placeholder="{{ ___('ambassador.About My Self') }}" name="about_me" id="" rows="10"><?= @$data['ambassador']->about_me ?></textarea>
                            @error('about_me')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-xl-12 col-md-6 mb-3">
                            <label for="designation" class="form-label ">
                                {{ ___('ambassador.Profile Image') }}
                            </label>
                            <div @if ($data['ambassador']->user->image) data-val="{{ showImage($data['ambassador']->user->image->original) }}" @endif
                                data-name="profile_image" class="file @error('profile_image') is-invalid @enderror"
                                data-height="200px ">
                            </div>
                            <small
                                class="text-muted">{{ ___('placeholder.NB : Profile image size will 100px x 100px and not more than 1mb') }}</small>
                            @error('profile_image')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="col-md-12 mt-24">
                    <div class="text-end">
                        <button class="btn btn-lg ot-btn-primary"><span>
                            </span>{{ ___('common.Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
