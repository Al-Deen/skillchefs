"use strict";
$(document).ready(function() {
    $('.radio').on('change', function() {
        var event_type = $(this).val();
        $('#complete_payment').addClass("d-block");
        if (event_type == "offline") {
            $('#offline').addClass("d-block").removeClass("d-none");
        } else {
            $('#offline').addClass("d-none").removeClass("d-block");
            $("#payment_type option[value='']").attr('selected', true);
            $('#additional_details').val(null);
        }
    });
});
