"use strict";

var endpoint = $("meta[name='baseurl']").attr("content");
var addToCartRoute = `${endpoint}/cart/add`;
var cartRoute = `${endpoint}/cart`;
var checkoutRoute = `${endpoint}/checkout`;
var countryListRoute = `${endpoint}/select/country-list`;
var paymentRoute = `${endpoint}/checkout/payment`;
var removeCartRoute = `${endpoint}/cart/remove`;
var loginRoute = `${endpoint}/sign-in`;

// Start  course detail page video player
$('#player').length &&
new Plyr("#player", {
    controls: [
        "play",
        "progress",
        "current-time",
        "mute",
        "volume",
        "fullscreen",
    ],
    logo: {
        enabled: false,
    },
    style: "video",
});
// End  course detail page video player

// Start add to function for course detail page
window.cartForm = async (...prams) => {
    try {
        const response = await fetch(
            addToCartRoute + "?" + new URLSearchParams({ slug: prams[0], type: prams[1] })
        );
        if (response.ok) {
            const { result, message, data } = await response.json();
            if (result) {
                if (data?.course == "free") {
                    successHandler(message);
                    location.reload();
                    return;
                }
                $('#total_cart').html(data?.total_cart);
                if (prams[1] == "checkout") {
                    window.location.href = checkoutRoute;
                }else{
                    successHandler(message);
                }
            }else{
                errorHandler(message);
                if (prams[1] == "checkout") {
                    setTimeout(function () {
                        window.location.href = cartRoute;
                    }, 2000);
                }
            }
        } else {
            const errorText = await response.json();
            warningsHandler(errorText);
            window.location.href = loginRoute;
        }
    } catch (error) {
        errorHandler(something_went_wrong);
    }
};
// End add to function for course detail page


// Start add to cart
$(document).on("click", ".add-to-cart", function (e) {
    console.clear();
    e.preventDefault();
    let id = $('#course-summary').data("val");
    cartForm(id, "add");
});
// End add to cart
// Start checkout
$(document).on("click", ".checkout", function (e) {
    console.clear();
    e.preventDefault();
    let id = $('#course-summary').data("val");
    cartForm(id, "checkout");
});

// End checkout
// start remove cart
$(document).on("click", ".clear-cart", function (e) {
    e.preventDefault();
    let remove_url =  removeCartRoute + "/" + $(this).data("id");
    Swal.fire({
        title: are_you_sure,
        text: you_wont_be_able_to_revert_this,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: yes_delete_it
    }).then((confirmed) => {
        if (confirmed.isConfirmed) {
            location.href = remove_url;
        }
    });
});
// end remove cart

// Start  country select for checkout page
$(".country-select").select2({
    placement: "bottom",
    innerWidth: "100%",
    ajax: {
      url: countryListRoute,
      dataType: "json",
      data: function (params) {
        return {
          term: params.term,
          _token: csrf_token,
        };
      },
      type: "POST",
      delay: 250,
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              text: item.text,
              id: item.id
            };
          }),
        };
      },
      error: function (error, data) {

      },
      cache: false,
    },
  });

  // End  country select for checkout page

// checkout payment function
window.checkoutPayment = async () => {
    try {
        $.ajax({
            url: paymentRoute,
            type: "POST",
            data: {
                _token: csrf_token,
                payment_method: $("input[name='payment_method']:checked").val(),
                country: $(".country-select").val(),
            },
            success: function (data) {
            },
            error: function (error) {
              if (error?.responseJSON?.errors) {
                $('.invalid-feedback').empty();
                $.each(error?.responseJSON?.errors, function (key, value) {
                    $('#' + key).removeClass('is-invalid');
                    let select2Tags = $('#' + key).next().find('.select2-selection');
                    if (select2Tags?.prevObject[0]?.className == 'select2 select2-container select2-container--default') {
                        $('#' + key).next('.select2-container').next().empty();
                        $('#' + key).next('.select2-container').after('<div class="invalid-feedback d-inline">' + value[0] + '</div>');
                    }else{
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).html('<div class="invalid-feedback d-inline">' + value[0] + '</div>');
                    }
                });
            }else if(error?.responseJSON?.message) {
                errorHandler(error?.responseJSON?.message);
            }
            }
          });
    } catch (error) {
        errorHandler(something_went_wrong);
    }
}


// Start  checkout payment
$(document).on("click", "#checkout-payment", function (e) {
    console.clear();
    checkoutPayment();
});

