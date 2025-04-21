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
        {{-- bradecrumb Area E n d --}}


        <!-- AI Support Start -->
        <section class="dashboared-card mb-24">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ot-card white-bg">
                        <div class="main">
                            <div class="main__right nice-scroll">

                                {{-- AI message--}}
                                <div class="ai-reply-message">
                                    <ul class="ai-message-list copy-text">

                                    </ul>
                                </div>

                                {{-- User message  --}}
                                <div class="main__chat_window">
                                    <ul class="messages"></ul>
                                </div>

                                {{-- inpux box --}}
                                <div class="main__message_container">
                                    <input id="chat_message" type="text" autocomplete="off"
                                        placeholder="{{ ___('placeholder.Type_message_here...') }}">

                                    <a id="send" class="options__button" href="#">
                                        <i class="lab la-telegram-plane"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End-of AI Support -->

    </div>
@endsection
