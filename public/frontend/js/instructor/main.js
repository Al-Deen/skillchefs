"use strict";
import { aiSearchRoute, countryListRoute, monthlySalesRoute } from "./__route.js";
let token = $('meta[name="csrf_token"]').attr("content");



$('.select2').select2();

// start modal open by an event
var modalClose = (event) => {
    $(".modal").remove();
    $(".modal-barkdrop").remove();
    $(".modal-backdrop").remove();
    $(".modal-open").removeClass("modal-open");
    $(".modal-backdrop").removeClass("modal-backdrop");
    $(".modal-backdrop").removeClass("modal-backdrop-open");
    $(".modal-backdrop").removeClass("show");
  };


window.mainModalOpen = (ur) => {
    modalClose();
    $.ajax({
      url: ur,
      type: "GET",
      success: function (data) {
        if (data?.result) {
              $(data?.data).appendTo('body').modal('show');
        } else {
            errorHandler(something_went_wrong);
        }
      },
      error: function (err) {
        if (err?.responseJSON?.message) {
            errorHandler(err.responseJSON.message);
          }else{
            errorHandler(something_went_wrong);
          }
      },
    });
  };

// end modal open by an event
// start destroy note
window.destroyFunction = async (ur) => {
    Swal.fire({
        title: are_you_sure,
        text: you_wont_be_able_to_revert_this,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: yes_delete_it
    }).then((confirmed) => {
        if (confirmed.isConfirmed) {
            location.href = ur;
        }
    });
};
// end destroy note




// end setting page

  // select instructor start
  $(".country_list").select2({
    placement: "bottom",
    innerWidth: "100%",
    ajax: {
      url: countryListRoute,
      dataType: "json",
      data: function (params) {
        return {
          term: params.term,
          _token: token,
        };
      },
      type: "POST",
      delay: 250,
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              text: item.text,
              id: item.id,
            };
          }),
        };
      },
      error: function (error, data) {
        toaster.fire({
          icon: "error",
          title: something_went_wrong,
        });
      },
      cache: false,
    },
  })[2];
// Select instructor end

// api subscription start

if ($(".chat_message").length > 0) {
  let height = $('.admin-wrapper').height();
  $('.main').css('height', height);

  $(".main__chat_window").animate({
      scrollTop: $('.messages').height()
  }, "fast");
}


function ChatBot() {
    var text = $("#chat_message").val();
    if (text == "") {
        $("#chat_message").focus();
        return false;
    }
    $(".messages").append("<li class='sent'>" + text + "</li>");
    // messages section scroll to bottom
    $
    $(".main__chat_window").animate({
        scrollTop: $('.messages').height()
    }, "fast");
    $("#chat_message").val("");
    $.ajax({
        url: aiSearchRoute,
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        data: JSON.stringify({
            text: text,
            _token: token,
        }),
        success: function(response) {
          if(response?.data){
            var data = response.data;
            if (data?.error) {
                $(".messages").append("<li class='message ai-reply'>" + data?.error?.message + "</li>");
                $(".main__chat_window").animate({
                    scrollTop: $('.messages').height()
                }, "fast");
              errorHandler(data?.error?.message, 8000);
            }else{
              var message = data?.choices[0]?.message?.content;
              if (message) {
                $(".messages").append("<li class='message ai-reply'>" + message + "</li>");
                $(".main__chat_window").animate({
                    scrollTop: $('.messages').height()
                }, "fast");
              }else{
                errorHandler(something_went_wrong);
              }
            }
          }else{
            errorHandler(something_went_wrong);
          }
        },
        error: function(err) {
          if (err?.responseJSON?.message) {
            errorHandler(err.responseJSON.message);
          }else{
            errorHandler(something_went_wrong);
          }
        }

    });
}

$("#send").on("click", function(e) {
    e.preventDefault();
    ChatBot();

})

$("#chat_message").on('keyup ', function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        ChatBot();
    }
});
// api subscription start


// monthly sales chart

function monthlySalesChart(data){

  var options = {
    series: [{
        name: data?.message?.type,
        data: data?.data?.info
    }],
    chart: {
        height: 350,
        type: 'bar',
    },
    plotOptions: {
        bar: {
            borderRadius: 10,
            dataLabels: {
                position: 'left', // top, center, bottom
            },
        }
    },
    dataLabels: {
        enabled: true,

        formatter: function(val) {
            return val + currency;
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },

    xaxis: {
        categories: data?.data?.labels,
        position: 'bottom',
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        },
        crosshairs: {
            fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                }
            }
        },
        tooltip: {
            enabled: true,
        }
    }
};

var chart = new ApexCharts(document.querySelector("#monthly_sales"), options);
chart.render();

}
if ($("#monthly_sales").length > 0) {

    $.ajax({
        url: monthlySalesRoute,
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        data: JSON.stringify({
            _token: token,
        }),
        success: function(response) {
        if (response?.result) {
            monthlySalesChart(response);
        }
        }
    });
}
// monthly sales chart








