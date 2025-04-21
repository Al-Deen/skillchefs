@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- breadecrumb Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                route('languages.index') => ___('language.languages'),
                '#' => @$data['title'],
            ],

            'buttons' => 1,
        ])
        {{-- breadecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                    <input type="hidden" name="code" id="code" value="{{ @$data['language']->code }}">
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="lang_module" class="form-label">{{ ___('language.module') }}</label>
                            <select class="select2 ot-input @error('lang_module') is-invalid @enderror change-module"
                                name="lang_module" id="lang_module" aria-describedby="validationServer04Feedback">
                                @foreach ($data['modules'] as $key => $value)
                                    
                                    @php
                                        $explode = explode('.', $value);
                                    @endphp
                                    @if ($key > 1)
                                        @if ($explode[1] == 'json')
                                            <option value="{{ $value }}"
                                                @if ($value == 'common.json') selected @endif>
                                                {{ Str::title(substr($value, 0, -5)) }}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                            @error('lang_module')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleDataList" class="form-label ">{{ ___('language.term') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleDataList"
                                        class="form-label ">{{ ___('language.translated_language') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 term-translated-language">
                            @php $i = 0; @endphp
                            @foreach ($data['terms'] as $key => $row)
                            @php $i++; @endphp
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input class="form-control ot-input" name="name" list="datalistOptions"
                                             value="{{ $key }}" disabled id="name_{{ $key }}">

                                    </div>
                                    <div class="col-md-6 translated_language d-flex justify-content-around align-items-center">
                                        <input class="form-control ot-input ml-3" list="datalistOptions"
                                            placeholder="{{ ___('language.translated_language') }}" name="{{ $key }}"
                                            value="{{ $row }}" id="val_{{ $i }}">
                                        <div class="text-end ms-3">
                                            <button class="btn btn-lg ot-btn-primary " onclick="languageTermSave(`{{ route('languages.update.terms', @$data['language']->code) }}`, `{{ $key }}`, `{{$i}}`)">
                                                <i class="fa-regular fa-floppy-disk fa-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
