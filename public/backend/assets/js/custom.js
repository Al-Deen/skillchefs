"use strict";

var token = $('meta[name="csrf-token"]').attr("content");
var main_url = $("#url").val();


var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

function ajaxError(response) {

    if (response.status === 404) {
        Toast.fire({
            icon: 'error',
            title: 'What you are looking is not found'
        });
        return;
    } else if (response.status === 500) {
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong.'
        });
        return;
    } else if (response.status === 200) {
        Toast.fire({
            icon: 'error',
            title: 'Something is not right'
        });
        return;
    } else {
        // reset error message here
        $(".custom-error-text").text("");
    }

    let jsonValue = $.parseJSON(response?.responseText);
    let errors = response?.responseJSON?.errors;
    var multifield_errors = JSON.parse(response?.responseText).errors;


    if (errors) {
        $.each(errors, function (field, messages) {
            var input = $("#error_" + field);
            $.each(messages, function (index, message) {
                input.text(message);
            });
        });
    } else {
        Toast.fire({
            icon: 'error',
            title: jsonValue.message
        });
    }
}

//End CMS setting status update

window.errorHandler = (error, timer=1500) => {
    let title = '';
    if (error?.result === false) {
        title = error?.message;
    } else if (error?.responseJSON?.message) {
        title = error?.responseJSON?.message;
    } else {
        title = error;
    }
    Toast.fire({
        icon: 'error',
        title: title,
        timer: timer
    });
}

$(document).ready(function () {

    $('.change-role').on('change', function (e) {
        e.preventDefault();
        var url = $('#url').val();
        var role_id = $(this).val();


        var formData = {
            role_id: role_id
        }
        $.ajax({
            type: "GET",
            dataType: 'html',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url + '/users/change-role',
            success: function (data) {
                $('#permissions-table tbody').html(data);
            },
            error: function (data) {}
        });
    });


    $('.change-module').on('change', function (e) {
        e.preventDefault();
        var url = $('#url').val();
        var code = $('#code').val();
        var module = $(this).val();


        var formData = {
            code: code,
            module: module,
        }
        $.ajax({
            type: "GET",
            dataType: 'html',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url + '/languages/change-module',
            success: function (data) {
                $('.term-translated-language').html(data);
            },
            error: function (data) {}
        });
    });

});

function languageTermSave(submitUrl , key, i){

    var name = key;
    var value = $(`#val_${i}`).val();
    var lang_module = $('#lang_module').val();
    var code = $('#code').val();

    var formData = {
        name,
        value,
        lang_module,
        code
    }
    $.ajax({
        type: "PUT",
        dataType: 'json',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: submitUrl,
        success: function (data) {
            if (data?.result ) {
                Toast.fire({
                    icon: 'success',
                    title: data?.message,
                    timer: 2000
                });
            }else{
                toaster.fire({
                    icon: "error",
                    title: something_went_wrong,
                });
            }

        },
        error: function (data) {
            toaster.fire({
                icon: "error",
                title: something_went_wrong,
            });
        }
    });

}



$(document).on('click', '.common-key', function () {
    var value = $(this).val();
    var value = value.split("_");
    if (value[1] == 'read') {
        if (!$(this).is(':checked')) {
            $(this).closest('tr').find('.common-key').prop('checked', false);
        }
    } else {
        if ($(this).is(':checked')) {
            $(this).closest('tr').find('.common-key').first().prop('checked', true);
        }
    }
});

// slider js
$(document).ready(function () {
    $("._common_div").hide();
    let type = $('.file_system').val();
    if (type == 's3') {
        $("._common_div").show();
    } else {
        $("._common_div").hide();
    }

    $('.file_system').on('change', function () {
        let type = $(this).val();
        if (type == 's3') {
            $("._common_div").show(); // show product div
        } else {
            $("._common_div").hide(); // show category div
        }
    });
});

var toaster = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

$(document).ready(function () {


    $('.language-change').on('change', function (e) {
        e.preventDefault();
        var url = $('#url').val();
        var code = $(this).val();


        var formData = {
            code: code,
        }
        $.ajax({
            type: "GET",
            dataType: 'html',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url + '/languages/change',
            success: function (data) {
                if (data == 1) {
                    location.reload();
                } else {

                    Toast.fire({
                        icon: 'error',
                        title: 'Language terms not generate yet!'
                    })
                    location.reload();
                }
            },
            error: function (data) {}
        });



    });

    $("input[name='theme_mode']").on('change', function (e) {
        var url = $('#url').val();
        var theme_mode = $(this).val();

        var formData = {
            theme_mode: theme_mode,
        }
        $.ajax({
            type: "POST",
            dataType: 'html',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url + '/setting/change-theme',
            success: function (data) {
                if (data) {
                    if (theme_mode == 'dark-theme') {
                        $('#dark_logo').show();
                        $('#default_logo').hide();
                    } else {
                        $('#dark_logo').hide();
                        $('#default_logo').show();
                    }
                    // location.reload();
                }
            },
            error: function (data) {}
        });
    });



    // end
});

/*----------------------------------------------
    Nice Scroll js
----------------------------------------------*/
$(".nice-scroll").niceScroll({});

/*----------------------------------------------
    Plugin Activision
    --Odometer Counter--
----------------------------------------------*/
$('.odometer').appear(function (e) {
    var odo = jQuery(".odometer");
    odo.each(function () {
        var countNumber = jQuery(this).attr("data-count");
        jQuery(this).html(countNumber);
    });
});

$(document).on('keyup', '#menuSearch', function () {
    var url = $('#url').val();
    var searchData = $(this).val();

    if (searchData != '') {
        $.ajax({
            url: url + '/searchMenuData',
            type: "post",
            dataType: "json",
            data: {
                searchData: searchData
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#autoCompleteData').removeClass('d-none').html(data.data);
            }
        });

    } else {
        $('#autoCompleteData').html('');
    }

});

$(document).on('focusout', '#menuSearch', function () {
    $('#autoCompleteData').addClass('d-nones');
});

// Full screen
function toggleFullScreen() {
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}
(function ($, window, document, undefined) {
    "use strict";
    var $ripple = $(".js-ripple");
    $ripple.on("click.ui.ripple", function (e) {
        var $this = $(this);
        var $offset = $this.parent().offset();
        var $circle = $this.find(".c-ripple__circle");
        var x = e.pageX - $offset.left;
        var y = e.pageY - $offset.top;
        $circle.css({
            top: y + "px",
            left: x + "px"
        });
        $this.addClass("is-active");
    });
    $ripple.on(
        "animationend webkitAnimationEnd oanimationend MSAnimationEnd",
        function (e) {
            $(this).removeClass("is-active");
        });
})(jQuery, window, document);

$(document).ready(function() {
    $('.select2').select2({ width: '100%' });
});



$(".show_more").on('change', function () {
    var show = $(this).val();
    window.location.href = '?show=' + show;
});
$(".show_type").on('change', function () {
    var type = $(this).val();
    window.location.href = '?type=' + type;
});

$('.delete_data').on('click', function (e) {
    e.preventDefault();
    Swal.fire({
        title: are_you_sure,
        text: you_wont_be_able_to_revert_this,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: yes_delete_it
    }).then((confirmed) => {
        if (confirmed.isConfirmed) {
            location.href = $(this).data('href');
        }
    });
});

$('.status_update').on('click', function (e) {
    e.preventDefault();
    Swal.fire({
        title: are_you_sure,
        text: you_wont_be_able_to_revert_this,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: $(this).data('text')
    }).then((confirmed) => {
        if (confirmed.isConfirmed) {
            location.href = $(this).data('href');
        }
    });
});
/*-----------------------------------
Tagify
-----------------------------------*/
if ($('input[name=tag]').length > 0) {
   $('input[name=tag]').tagify()
}



/*-----------------------------------
  Ck Editor
-----------------------------------*/
  $(document).ready(function() {
    $('.ckeditor-editor').each(function(index, element) {
        ClassicEditor.create(element)
          .then(editor => {
            editor.model.document.on('change:data', () => {
              var editorData = editor.getData();
               $(element).val(editorData)
            });
          });
      });
  });

/*-----------------------------------
  Ck Editor
-----------------------------------*/



$(".cus-dropdown-seelct").next(".select2-container").addClass("custom-container")
$(".custom-container .select2-selection__arrow").remove();

const __globalDelete = (url) => {
    Swal.fire({
        title: are_you_sure,
        text: you_wont_be_able_to_revert_this,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: yes_delete_it
    }).then((confirmed) => {
        if (confirmed.isConfirmed) {
            location.href = url;
        }
    });

};

var modalClose = (event) => {
    $(".modal").remove();
    $(".modal-barkdrop").remove();
    $(".modal-backdrop").remove();
    $(".modal-open").removeClass("modal-open");
    $(".modal-backdrop").removeClass("modal-backdrop");
    $(".modal-backdrop").removeClass("modal-backdrop-open");
    $(".modal-backdrop").removeClass("show");
  };

const mainModalOpen = (ur) => {
    modalClose();
    $.ajax({
      url: ur,
      type: "GET",
      success: function (data) {
        // console.log(data);
        if (data?.result) {
              $(data?.data).appendTo('body').modal('show');
        } else {
          toaster.fire({
            icon: "error",
            title: something_went_wrong,
          });
        }
      },
      error: function (err) {
        if (err?.responseJSON?.message) {
            toaster.fire({
              iconColor: "white",
              icon: "error",
              title: err.responseJSON.message,
            });
          }else{
            toaster.fire({
                icon: "error",
                title: something_went_wrong,
              });
          }
      },
    });
  };

  //CMS Setting status update
$(document).on('change', '.status-update', function () {
    //
    let id = $(this).val();
    let url = $(this).attr('data-url');
    if(id){
        Swal.fire({
            title: are_you_sure,
            text: "You want to update status!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes Update it"
        }).then((confirmed) => {
            if (confirmed.isConfirmed) {
                $.ajax({
                    url: url,
                    data: { id: id },
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                            if (response.result) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response?.message
                                });
                            }
                    },
                    error: function (response) {
                        ajaxError(response);
                    }
                });
            }else{
                location.reload();
            }
        });
    }

});




$(document).on('click', '.main-modal-open', function () {
    var url = $(this).attr('data-url');
    mainModalOpen(url);
});


// select country start
$(".country_list").select2({
    placement: "bottom",
    innerWidth: "100%",
    ajax: {
        url: `${main_url}/select/country-list`,
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
// Select country end


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
        url: `${main_url}/admin/ai-support/search`,
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

function divHide(className) {
    $("." + className).addClass("d-none");
    // with disable input , select amd textarea
    $("." + className)
        .find("input")
        .attr("disabled", true);
    $("." + className)
        .find("select")
        .attr("disabled", true);
    $("." + className)
        .find("textarea")
        .attr("disabled", true);
}

function divShow(className) {
    $("." + className).removeClass("d-none");
    // with enable input , select amd textarea
    $("." + className)
        .find("input")
        .attr("disabled", false);
    $("." + className)
        .find("select")
        .attr("disabled", false);
    $("." + className)
        .find("textarea")
        .attr("disabled", false);
}

function swipeButton(name) {
    $('#'+name+'_setup').change(function() {
        if($(this).prop('checked') == true) {
            divShow(name);
        } else {
            divHide(name);
        }
    });
}



function pageType() {
    var page_content_type = $(".page_content_type").val();
    if (page_content_type == '1') {
        divShow('page-type-content');
        divHide('page-type-image');
        divHide('both-type');
    } else if (page_content_type == '2') {
        divShow('page-type-image');
        divHide('page-type-content');
        divHide('both-type');
    }else {
        divShow('both-type');
        divShow('page-type-content');
        divShow('page-type-image');
    }
}


$(document).on('change', '.page_content_type', function () {
    pageType();
});

$('.page_content_type').length && pageType();

var options =  {
    blockquoteBreakingLevel: 2,
    disableDragAndDrop: true,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript','fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert',['ltr','rtl']],
        ['insert', ['link','picture', 'video', 'hr']],
        ['table', ['table']],
        ['air', ['undo', 'redo']],
        ['view', ['codeview']]
    ]
  };

$(document).ready(function() {
    $('.summernote').length > 0 && $('.summernote').summernote(options);




});
// async function dataPaginate(className) {
//     $.ajax({
//         url: $(`.${className}`).data("url"),
//         method: "get",
//         data: {},
//         success: function (data) {
//             console.log(data);
//             if (data?.result) {
//                 $("#ot_categories_area").html(data.data.content);
//                 callCategoriesCarousel();
//             }
//         },
//     });
// }

// $(".chat-list").length > 0 && dataPaginate("chat-list");


$(document).on("click", ".status_id", function (e) {
    if ($(this).prop('checked')) {
        e.preventDefault();
        var url = $(this).data("url");
        Swal.fire({
            title: are_you_sure,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: active
        }).then((confirmed) => {
            if (confirmed.isConfirmed) {
                location.href = url;
            }
        });
    }else{
        e.preventDefault();
        var url = $(this).data("url");
        Swal.fire({
            title: are_you_sure,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: inactive
        }).then((confirmed) => {
            if (confirmed.isConfirmed) {
                location.href = url;
            }
        });
    }
});

/*-----------------------------------
  Role Delete Alert While User Already Assigned
-----------------------------------*/
$(document).on('click', '.role_no_delete_btn', function(e) {
    Swal.fire({
        icon: 'error',
        title: cant_delete_the_role,
        text: user_already_assigned_to_this_role,
        showCancelButton: true,
        showConfirmButton: false,
        width: 600,
        padding: '3em',
    });
});
/*-----------------------------------
  Role Delete Alert While User Already Assigned
-----------------------------------*/
