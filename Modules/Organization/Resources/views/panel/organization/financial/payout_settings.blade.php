@extends('organization::panel.organization.layouts.master')
@section('title', @$data['title'])
@section('content')
    <!-- organization add Bank Start -->
    <section class="ai-support">
        <div class="row">
            <!-- Section Tittle -->
            <div class="col-xl-12">
                <div
                    class="section-tittle-two border-bottom pb-8 d-flex align-items-center justify-content-between flex-wrap mb-20">
                    <h2 class="title font-600 mb-20">{{ $data['title'] }}</h2>
                    <button class="btn-primary-outline main-modal-open"
                        data-url="{{ route('organization.payment_method.add') }}">
                        <i class="ri-add-line"></i>
                        {{ ___('organization.Add Account') }}
                    </button>
                </div>
            </div>
        </div>
        <!-- Dashboard Card S t a r t -->
        <div class="dashboared-card mb-24">
            <div class="row g-24">
                @forelse ($data['payment_methods'] as $item)
                    <div class="col-xl-3 col-sm-6">
                        <div
                            class="single-dashboard-card single-dashboard-card2 position-relative carts-bg-one h-calc d-flex align-items-center @if ($item->is_default) payment_default @endif">

                            <div class="edit main-modal-open"
                                data-url="{{ route('organization.payment_method.edit', $item->id) }}">
                                <i class="ri-pencil-line"></i>
                            </div>
                            <div class="payment_info">
                                <div class="user-img">
                                    <img src="{{ showImage(@$item->paymentMethod->image->original) }}"
                                        class="img-cover round">
                                </div>
                                <div class="cat-caption text-center mt-2">
                                    <p class="pera font-600">{{ @$item->paymentMethod->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-xl-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="not-data-found table-img text-center pt-50 pb-10">
                                    <img src="{{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                                        alt="img" class="w-100 mb-20 w-25">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <!-- End-of card -->
    </section>
@endsection
