@if (!empty($data['states']))
    @foreach ($data['states'] as $stateId => $stateName)
        <option value="{{ $stateId }}">
            {{ $stateName }}</option>
    @endforeach
@endif
