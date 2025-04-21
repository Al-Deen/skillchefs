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
                '#' => @$data['title'],
            ],

            'buttons' => 1,
        ])
        {{-- breadecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('settings.seo_setting_update') }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row">

                                {{-- start meta title  --}}
                                <div class="col-xl-12 col-md-6 mb-3">
                                    <label for="author" class="form-label ">{{ ___('course.Author') }}
                                    </label>
                                    <input class="form-control ot-input @error('title') is-invalid @enderror" name="author"
                                        list="datalistOptions" id="author" value="{{ setting('author') }}"
                                        placeholder="{{ ___('placeholder.Enter meta title') }}">
                                    @error('author')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                {{-- end meta title  --}}
                                {{-- start meta keyword  --}}
                                <div class="col-xl-12 col-md-6 mb-3">
                                    <label for="meta_keyword" class="form-label ">{{ ___('course.Meta Keyword') }}
                                    </label>
                                    <input class="form-control ot-input @error('title') is-invalid @enderror"
                                        name="meta_keyword" list="datalistOptions" id="meta_keyword"
                                        value="{{ setting('meta_keyword') }}"
                                        placeholder="{{ ___('placeholder.Enter meta title') }}">
                                    @error('meta_keyword')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                {{-- end meta title  --}}
                                {{-- start meta description  --}}
                                <div class="col-xl-12 col-md-6 mb-3">
                                    <label for="meta_description" class="form-label ">{{ ___('course.Meta Description') }}
                                    </label>
                                    <textarea class="form-control @error('title') is-invalid @enderror" name="meta_description" list="datalistOptions"
                                        row="10" cols="5" id="meta_description" placeholder="{{ ___('placeholder.Enter meta description') }}"><?= setting('meta_description') ?></textarea>
                                    @error('meta_description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                {{-- end meta description  --}}
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="text-end">
                                    @if (hasPermission('seo_settings_update'))
                                        <button class="btn btn-lg ot-btn-primary">
                                            <span>
                                                <i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.update') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
