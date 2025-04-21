@extends('errors.master')

@section('title', ___('common.400_database_connection_error'))
@section('main')


    <main>
        <section
            class="error-wrapper bg-white p-0 m-0 text-center d-flex justify-content-center align-items-center flex-column">
            <div class="error-content p-0 m-0 text-center d-flex justify-content-center align-items-center flex-column">
                <!-- error 404 image  -->
                <img src="{{ showImage(gallery('400-database-connection-error'), 'backend/assets/images/error/error500.png') }}" alt="img" />
                <!-- Head text  -->
                <h1 class="mt-30">{{ ___('common.400_database_connection_error') }}</h1>
                <!-- Error text   -->
                <p class="mt-10">
                    {{ ___('common.please_check_database_connection_and_tables') }}
                </p>
                <!-- Back to homepage button  -->
                <div class="btn-back-to-homepage mt-28">
                    <a href="{{ url('dashboard') }}" class="submit-button pv-16  btn ot-btn-primary">
                        {{ ___('common.back_to_homepage') }}
                    </a>
                    @if (env('APP_ENV') == 'local')
                        <a href="{{ url('i-am-sure-to-reset-my-database') }}"
                            class="submit-button pv-16  btn ot-btn-primary">
                            {{ ___('common.reset_database') }}
                        </a>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
