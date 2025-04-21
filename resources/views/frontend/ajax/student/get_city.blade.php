@if (!empty($data['cities']))
    @foreach ($data['cities'] as $cityId => $cityName)
        <option value="{{ $cityId }}">
            {{ $cityName }}</option>
    @endforeach
@endif
