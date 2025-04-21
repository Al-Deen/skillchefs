@extends('backend.master')

@section('title', @$data['title'])
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/tagify.css') }}">
@endpush
@section('content')
<div>
    @include('organization::panel.organization.partials.tab')
    @if (url()->current() === route('organization.admin.edit', [$data['organization']->id, 'general']))
        <!-- general body start -->
        @include('organization::panel.organization.partials.general')
        <!-- general body end -->
    @elseif (url()->current() === route('organization.admin.edit', [$data['organization']->id, 'security']))
        <!-- security body start -->
        @include('organization::panel.organization.partials.security')
        <!-- security body end -->
    @elseif (url()->current() === route('organization.admin.edit', [$data['organization']->id, 'skill']))
        <!-- skill body start -->
        @include('organization::panel.organization.partials.skill')
        <!-- skill body end -->
    @endif
</div>
@endsection

@push('script')
    <script src="{{ asset('backend/assets/js/tagify.js') }}"></script>
@endpush
