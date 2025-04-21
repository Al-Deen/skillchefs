@extends('panel.instructor.layouts.master')
@section('title', @$data['title'])
@section('content')

    <!-- AI Support Start -->
    <section class="ai-support">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div
                    class="section-tittle-two border-bottom pb-8 d-flex align-items-center justify-content-between flex-wrap mb-20">
                    <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                </div>
            </div>
        </div>
        <div class="dashboared-card mb-24">
            <div class="row">
                <div class="col-lg-12">

                    <div class="main">
                        <div class="main__right nice-scroll">

                            {{-- AI message--}}
                            <div class="ai-reply-message">
                                <ul class="ai-message-list copy-text">

                                </ul>
                            </div>

                            {{-- User message  --}}
                            <div class="main__chat_window nice-scroll">
                                <ul class="messages"></ul>
                            </div>

                            {{-- inpux box --}}
                            <div class="main__message_container">
                                <input id="chat_message" type="text" autocomplete="off"
                                    placeholder="{{ ___('placeholder.Type_message_here...') }}">

                                <a id="send" class="options__button" href="#">
                                   <i class="ri-send-plane-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End-of AI Support -->

@endsection

@section('scripts')
@endsection
