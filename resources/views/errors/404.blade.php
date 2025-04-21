@extends('errors.master')

@section('title', ___('common.404_page_not_found'))
@section('main')

    <main>
        <section class="error-wrapper p-0 m-0 text-center d-flex justify-content-center align-items-center flex-column">

            <div class="error-content p-0 m-0 text-center d-flex justify-content-center align-items-center flex-column">
                <!-- error 404 image  -->
                <img src="{{ showImage(gallery('404-page-not-found'), 'backend/assets/images/error/error500.png') }}" alt="img" />
                <!-- Head text  -->
                <h1 class="mt-30">{{ ___('common.404_page_not_found') }}</h1>
                <!-- Error text   -->
                <p class="mt-10">
                    {{ ___('common.you_were_trying_to_reach_couldn_t_be_found_on_the_server') }}
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
