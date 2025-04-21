@extends('panel.student.layouts.master')
@section('title', @$data['title'])
@section('content')
    <section>
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div
                    class="section-tittle-two border-bottom d-flex align-items-center justify-content-between flex-wrap mb-10 pb-20 gap-15">
                    <h2 class="title font-600">{{ $data['title'] }}</h2>
                    <div class="search-tab">
                        <a class="btn-primary-fill"
                            href="{{ route('student.certificate.download', encryptFunction(@$data['certificate']->enroll_id)) }}">
                            {{ ___('frontend.download') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search -->
        </div>
        <!-- Report Table -->
        <div class="row">
            <div class="col-xl-12">
                <div class="mb-24">
                    <img src="{{ showImage(@$data['certificate']->image->original) }}" alt="img" class="img-cover">
                </div>
            </div>
        </div>

    </section>

@endsection
