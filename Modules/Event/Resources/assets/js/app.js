"use strict";

$(function() {
    if($('#start_date').val()){  // edit event
        $('input[name="event_duration"]').daterangepicker({
            timePicker: true,
            startDate: moment($('#start_date').val()),
            endDate: moment($('#end_date').val()),
            locale: {
                format: 'DD/MM/YYYY hh:mm A'
            }
        });
    } else{           // create event
        $('input[name="event_duration"]').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'DD/MM/YYYY hh:mm A'
            }
        });
    }
});

$(function() {
    if($('#start_date').val()){     // edit event
        $('input[name="registration_deadline"]').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'MM/DD/YYYY h:mm a'
            }
        });
    } else{                       // create event
        $('input[name="registration_deadline"]').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        });
    }
});

// Tagify
if ($("#tags").length > 0) {
    $("#tags").tagify({
        maxTags: 5,
        duplicates: false,
        autofocus: true,
    });
}

$(document).ready(function() {
    $('#event_type').on('change', function() {
        var event_type = $(this).val();

        if (event_type == "Online") {
            $('#if_online').addClass("d-block").removeClass("d-none");
        } else {
            $('#if_online').addClass("d-none").removeClass("d-block");
        }
    });

    $('#event_type').on('change', function() {
        var event_type = $(this).val();

        if (event_type == "Offline") {
            $('#if_offline').addClass("d-block").removeClass("d-none");
        } else {
            $('#if_offline').addClass("d-none").removeClass("d-block");
        }
    });

    $('#is_paid').on('change', function() {
        var is_paid = $(this).val();

        if (is_paid == 11) {
            $('#if_paid').addClass("d-block").removeClass("d-none");
        } else {
            $('#if_paid').addClass("d-none").removeClass("d-block");
        }
    });
});
