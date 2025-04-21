@php $i = 0; @endphp
@foreach ($data['terms'] as $key => $row)
@php $i++; @endphp
    <div class="row mb-3">
        <div class="col-md-6">
            <input class="form-control ot-input" name="name" list="datalistOptions" value="{{ $key }}" disabled
                id="name_{{ $key }}">

        </div>
        <div class="col-md-6 translated_language d-flex justify-content-around align-items-center">
            <input class="form-control ot-input ml-3" list="datalistOptions"
                placeholder="{{ ___('language.translated_language') }}" name="{{ $key }}"
                value="{{ $row }}" id="val_{{ $i }}">
            <div class="text-end ms-3">
                <button class="btn btn-lg ot-btn-primary " onclick="languageTermSave(`{{ route('languages.update.terms', @$data['code']) }}`, `{{ $key }}`, `{{$i}}`)">
                    <i class="fa-regular fa-floppy-disk fa-lg"></i>
                </button>
            </div>
        </div>
    </div>
@endforeach
