@extends('errors.master')

@section('title', ___('common.500_something_wrong'))
@section('main')
    <main>
        <section
            class="error-wrapper bg-white p-0 m-0 text-center d-flex justify-content-center align-items-center flex-column">
            <div class="error-content p-0 m-0 text-center d-flex justify-content-center align-items-center flex-column">
                <!-- error 404 image  -->
                <img src="{{ showImage(gallery('500-something-wrong'), 'backend/assets/images/error/error500.png') }}" alt="img" />
                <!-- Head text  -->
                <h1 class="mt-30">{{ ___('common.500_something_wrong') }}</h1>
                <!-- Error text   -->
                <p class="mt-10">
                    {{ ___('common.we_are_trying_to_fix_the_problem_as_soon_as_possible') }}
                </p>
                <!-- Back to homepage button  -->
                <div class="btn-back-to-homepage mt-28">
                    <a href="{{ url('dashboard') }}" class="submit-button pv-16  btn ot-btn-primary">
                        {{ ___('common.back_to_homepage') }}
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
