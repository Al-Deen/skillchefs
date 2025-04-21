<table class="table table-bordered {{ @$data['class'] }}" id="table">
    <thead class="thead">
        <tr>
            @if (@$data['fields'])
                @foreach (@$data['fields'] as $field)
                    <th class="sorting_desc">{{ $field }}</th>
                @endforeach
            @endif
        </tr>
    </thead>

</table>
@if (@$data['url_id'])
    <input type="text" hidden id="{{ @$data['url_id'] }}" value="{{ @$data['table'] }}">
@endif
