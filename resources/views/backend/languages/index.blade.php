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

        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ ___('language.languages') }}</h4>
                    @if (hasPermission('language_create'))
                        <a href="{{ route('languages.create') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-plus"></i> </span>
                            <span class="">{{ ___('common.add') }}</span>
                        </a>
                    @endif
                </div>
                <div class="card-body ot-card">
                    <div class="table-responsive">
                        <table class="table table-bordered ot-table-bg language-table">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('common.ID') }}</th>
                                    <th class="purchase">{{ ___('common.name') }}</th>
                                    <th class="purchase">{{ ___('language.code') }}</th>
                                    <th class="purchase">{{ ___('language.RTL') }}</th>
                                    <th class="purchase">{{ ___('language.icon') }}</th>
                                    @if (hasPermission('language_update') || hasPermission('language_delete') || hasPermission('language_update_terms'))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['languages'] as $key => $row)
                                    <tr id="row_{{ $row->id }}">
                                        <td class="serial">{{ ++$key }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->code }}</td>
                                        <td>
                                            @if ($row->direction == 'ltr')
                                                {{ statusBackend('danger', ___('common.No')) }}
                                            @else
                                                {{ statusBackend('success', ___('common.Yes')) }}
                                            @endif
                                        </td>
                                        <td><i class="{{ $row->icon_class }} "></i></td>
                                        @if (hasPermission('language_update') || hasPermission('language_delete') || hasPermission('language_update_terms'))
                                            <td class="action">
                                                <div class="dropdown dropdown-action">
                                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        @if (hasPermission('language_update'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('languages.edit', $row->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-pen-to-square"></i></span>
                                                                    <span>{{ ___('common.edit') }}</span></a>
                                                            </li>
                                                        @endif

                                                        @if (hasPermission('language_update_terms'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('languages.edit.terms', $row->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-pen-to-square"></i></span>
                                                                    <span>{{ ___('language.edit_terms') }}</span></a>
                                                            </li>
                                                        @endif

                                                        @if ($row->code != 'en')
                                                            @if (hasPermission('language_delete'))
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                                        onclick="delete_row('languages/delete', {{ $row->id }})">
                                                                        <span class="icon mr-8"><i
                                                                                class="fa-solid fa-trash-can"></i></span>
                                                                        <span>{{ ___('common.delete') }}</span>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    @include('backend.ui-components.empty_table', [
                                        'colspan' => '5',
                                        'message' => ___(
                                            'message.Please add a new entity or manage the data table to see the content here'),
                                    ])
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!--  table end -->
                    <!--  pagination start -->
                    @if (count($data['languages']) > 10)
                        <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    {!! $data['languages']->links() !!}
                                </ul>
                            </nav>
                        </div>
                    @endif
                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->
    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
