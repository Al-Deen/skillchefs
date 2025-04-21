<div class="page-header">
    <div class="row">

        {{-- breadcrumb dynamic data from common-helper --}}
        {!! breadcrumb([
            'title' => @$data['title'],
            'routes' => @$routes,
        ]) !!}

    </div>
</div>
