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

        <div class="table-content table-basic ecommerce-components product-list">
            <div class="card">
                <div class="card-body">
                    <!--  toolbar table start  -->
                    <div
                        class="table-toolbar d-flex flex-wrap gap-2 flex-column flex-xl-row justify-content-center justify-content-xxl-between align-content-center pb-3">
                        <form action="" method="get">
                            <div class="align-self-center">
                                <div
                                    class="d-flex flex-wrap gap-2 flex-column flex-lg-row justify-content-center align-content-center">

                                    <div class="align-self-center d-flex gap-2">
                                        <!-- search start -->
                                        <div class="align-self-center">
                                            <div class="search-box d-flex">
                                                <input class="form-control" placeholder="{{ ___('common.search') }}"
                                                    name="{{ ___('common.search') }}" value="{{ @$_GET['search'] }}" />
                                                <span class="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                            </div>
                                        </div>
                                        <!-- search end -->

                                        <!-- dropdown action -->
                                        <div class="align-self-center">
                                            <div class="dropdown dropdown-action" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Filter">
                                                <button type="submit" class="btn-add">
                                                    <span class="icon">{{ ___('common.Filter') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- add btn start -->
                        @if (hasPermission('addon_create'))
                            <div class="align-self-center d-flex gap-2">
                                <!-- add btn -->
                                <div class="align-self-center">
                                    <a onclick="mainModalOpen(`{{ route('admin.addon.create') }}`)" role="button"
                                        class="btn-add" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="{{ ___('course.Add') }}">
                                        <span><i class="fa-solid fa-plus"></i> </span>
                                        <span class="d-none d-xl-inline">{{ ___('common.add') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <!-- add btn end -->
                    </div>
                    <!--toolbar table end -->
                    <div class="row g-24">

                        @forelse ($data['addons'] as $addon)
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="single-add-ons radius-4">
                                    <div class="single-add-ons-img position-relative overflow-hidden radius-4 mb-20">
                                        <a href="#">
                                            <img src="{{ @showImage('', $addon->thumbnail) }}" class="img-cover"
                                                alt="img">
                                        </a>
                                    </div>
                                    <div class="single-add-ons-info">
                                        <div class="single-add-ons-info-title mb-12">
                                            <a href="javascript:;">
                                                <h4 class=" line-clamp-1 text-20 font-700">{{ $addon->title }}</h4>
                                            </a>
                                        </div>
                                        <p class="line-clamp-2">
                                            {{ @$addon->description }}
                                        </p>
                                        <div class="d-flex justify-content-between">
                                            <p>
                                                {{ statusBackend(@$addon->status->class, $addon->status->name) }}
                                            </p>

                                            <div class="form-check form-switch ms-2">
                                                <input class="form-check-input status_id" value="1" type="checkbox"
                                                    id="status_id" name="status_id"
                                                    data-url="{{ route('admin.addon.status', $addon->id) }}"
                                                    @if ($addon->status_id == 1) checked @endif data-value="off">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-12 text-center">
                                <div class="radius-4 text-center">
                                    <div class="single-add-ons-img position-relative overflow-hidden radius-4 mb-20">
                                        <img src=" {{ @showImage(setting('empty_table'), 'backend/assets/images/no-data.png') }}"
                                            alt="img" class="mb-primary empty_table" width="250">
                                    </div>
                                </div>
                            </div>
                        @endforelse

                    </div>
                    <!--  pagination start -->
                    @include('backend.ui-components.pagination', ['data' => $data['addons']])
                    <!--  pagination end -->
                </div>
            </div>
        </div>









    </div>
@endsection


@push('script')
@endpush
