<div id="offline" class="@if (old('payment_method') == 'offline') d-block @else d-none @endif ">
    <div class="row mt-3">
        @if (\File::exists(base_path('Modules/Offline/payment.json')))
            @php
                $jsonString = file_get_contents(base_path('Modules/Offline/payment.json'));
                $collections = collect(json_decode($jsonString, true));
                // dd($collections);
                $payments = $collections
                    ->filter(function ($payment) {
                        return $payment['status'] == 1;
                    })
                    ->values()
                    ->all();

            @endphp
            @if (count($payments) > 0)
                <div class="col-lg-12">
                    <div class="ot-contact-form mb-24">
                        <label class="ot-contact-label">{{ ___('offline.Payment Type') }} <span
                                class="text-danger">*</span></label>
                        <select class="form-select ot-input select_2" id="payment_type" name="payment_type">
                            @foreach ($payments as $key => $payment)
                                @php $payment = (object) $payment; @endphp
                                @if ($payment->status == 1)
                                    <option
                                        value="{{ $payment->name }}"{{ old('payment_type') == $payment->name ? ' selected' : '' }}>
                                        {{ $payment->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('payment_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            @else
                <input type="hidden" name="payment_type" value="Cash">
            @endif
        @endif
        <div class="col-lg-12">
            <div class="ot-contact-form mb-24">
                <label class="ot-contact-label">{{ ___('offline.Additional_Details') }} <span
                        class="text-danger">*</span>
                    <i class="ri-information-fill" data-toggle="tooltip" data-placement="top"
                        title="{{ ___('offline.ex: Transaction ID XXXX-XXXX-XXXX-XXXX') }}"></i>
                </label>
                <textarea class="ot-contact-textarea" name="additional_details" id="additional_details"
                    placeholder="{{ ___('offline.ex: Transaction ID XXXX-XXXX-XXXX-XXXX') }}" rows="4">{{ old('additional_details') }}</textarea>
                @error('additional_details')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script src="{{ asset('modules/offline/js/app.js') }}"></script>
@endsection
