<style>
    label {
    display: block;
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

input:focus {
    border-color: #007BFF;
    outline: none;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007BFF;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}
</style>


<div id="Paynet" class="@if (old('payment_method') == 'Paynet') d-block @else d-none @endif">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="ot-contact-form mb-24 mt-20">
                <form action ="{{ route('checkout.payment') }}" method="POST" >
                    <input name="payment_method" class="radio" type="hidden" value="Paynet">
                    @csrf
                    <div class="form-group primary-btn">
                        <script
                                class="paynet-button m-auto"
                                type="text/javascript"
                                src="{{env('PAYNET_SCRIPT')}}"
                                data-key="{{env('PAYNET_PUBLIC')}}"
                                data-amount="{{@$amount}}"
                                data-button_label="{{ ___('frontend.Pay With Paynet') }}">
                        </script>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<script>

document.addEventListener('DOMContentLoaded', function () {
    $('.radio').on('change', function() {
        var event_type = $(this).val();
        if (event_type == "Paynet") {
            $('#Paynet').addClass("d-block").removeClass("d-none");
            $('#complete_payment').addClass("d-none");
        } else {
            $('#Paynet').addClass("d-none").removeClass("d-block");
            $('#complete_payment').removeClass("d-none");
            $("#payment_type option[value='']").attr('selected', true);
            $('#additional_details').val(null);
        }
    });

});


</script>
