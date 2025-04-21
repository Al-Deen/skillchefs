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
                route('admin.certificate.index') =>  ___('backend_sidebar.Certificate List'),
                '#' => @$data['title'],
            ],
        
            'buttons' => 1,
        ])
        {{-- breadecrumb Area E n d --}}

        <!--  table content start -->
        <div class="table-content table-basic ecommerce-components product-list">
            <div class="card">
                <div class="card-body">


                    <!--  toolbar table start  -->
                    <div
                        class="table-toolbar d-flex flex-wrap gap-2 flex-column flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
                        <div class="align-self-center">
                            <div
                                class="d-flex flex-wrap gap-2 flex-column flex-lg-row justify-content-center align-content-center">
                                <img src="{{ showImage(@$data['certificate']->image->original) }}"
                                alt="img" class="card-img-top">
                            </div>
                        </div>
                    </div>
                    <!--toolbar table end -->
                </div>
            </div>
        </div>
        <!--  table content end -->
    </div>
@endsection
