"use strict";
var step = 1;
var course_step_count = 'course_count';
// ckeditor editor
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

if($('#edit_course').length > 0){
    course_step_count = `course_count${$('#edit_course').data('val')}`
}
function toggleTab() {

    localStorage.setItem(course_step_count, step);
    $(".single-step").removeClass("current-items"); // remove active class from all tabs
    $(".single-step").each(function (e) {
        if (e + 1 == step) {
            $(this).addClass("current-items");
            $(this).prevAll().addClass("completed");
            $(this).removeClass("completed"); // remove active class from all tabs
        }
    });

    // add active class to the current from
    $('.step-wrapper-contents').removeClass('active'); // remove active class from all tabs
    if ($(".single-step").length == step) {
        $('.step-wrapper-contents').each(function (index) {
            if ($("#course_step").length > 0) {
                if(index > 2){
                    $(this).addClass('active');
                }
            }else{
                $(this).addClass('active');
            }
        });
        $('#next-btn').html(submitText);
    }else{
        $(".step-wrapper-contents").each(function (e) {
            if (e + 1 == step) {
                $(this).addClass("active");
            }
        });
    }

    if (step == 2) {
       $('.course-assignment-load').length > 0 &&  courseAssignmentLoad(); //
    }else if (step == 3) {
       $('.course-notice-board-load').length > 0 && courseNoticeBoardLoad();
    }

}


function submitForm() {
    const form = document.getElementById("form_values");
    const url = form.getAttribute("action");
    const data = new FormData(form);
    data.append('step', step);
    $.ajax({
      url: url,
      type: "POST",
      data: data,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log(response);
        if (response?.result) {
            if(response?.data?.redirect){
                step=1;
                localStorage.setItem(course_step_count, step);
                successHandler(response?.message);
                setTimeout(() => {
                    window.location.href = response?.data?.redirect;
                }, 1500);
            }else{
                step++;
                toggleTab();
            }
        } else {
          errorHandler(something_went_wrong);
        }
      },
      error: function (error) {
        if (error?.responseJSON?.errors) {
          $('.invalid-feedback').empty();
          $.each(error?.responseJSON?.errors, function (key, value) {
              $('#' + key).removeClass('is-invalid');
              let file_error = $('#' + key).parent().parent().find('.ot_fileUploader');
              let select2Tags = $('#' + key).next().find('.select2-selection');
              let textareaTag = $('#' + key).next().find('.ck-editor');
              let option = key.split('.')
              if (select2Tags?.prevObject[0]?.className == 'select2 select2-container select2-container--default') {
                  $('#' + key).next('.select2-container').next().empty();
                  $('#' + key).next('.select2-container').after('<div class="invalid-feedback d-inline">' + value[0] + '</div>');
              }else if(textareaTag?.prevObject[0]?.className == 'ck ck-reset ck-editor ck-rounded-corners'){
                  $('#' + key).next().next().empty();
                  $('#' + key).next().after('<div class="invalid-feedback d-inline">' + value[0] + '</div>');
              }else if(file_error?.prevObject[0]?.className == 'ot_fileUploader left-side mb-2 file-upload-browse'){
                  $('.error-'+key).empty();
                  $('.error-' + key).next().empty();
                  $('.error-'+key).after('<div class="invalid-feedback d-inline">' + value[0] + '</div>');
              }
              else if(option.length > 1 ){
               // $('input').removeClass('is-invalid');
                $('#commission_'+option[1]).next().empty();
                $('#commission_'+option[1]).addClass('is-invalid');
                $('#commission_'+option[1]).after('<div class="invalid-feedback">' + value[0] + '</div>');
              }
              else{
                  $('#' + key).next().empty();
                  $('#' + key).addClass('is-invalid');
                  $('#' + key).after('<div class="invalid-feedback">' + value[0] + '</div>');
              }
          });
      }else if(error?.responseJSON?.message) {
         errorHandler(error?.responseJSON?.message);
      }
      }
    });
  }
$('#is_free').on('click', function () {
    if (this.checked) {
        dHide('price_div');
    } else {
        dShow('price_div');
    }
});
$('#is_discount').on('click', function () {
    if (this.checked) {
        dShow('discount_div')
    } else {
        dHide('discount_div')
    }
});

$(document).on("submit", "#form_values", function (e) {
    e.preventDefault();
    submitForm();
});

$(document).on("click", "#next-btn", function (e) {
    e.preventDefault();
    if ($(".single-step").length >= step) {
        submitForm();
    }
});

$(document).on("click", "#previous-btn", function () {
    if (step > 1) {
        step--;
        toggleTab();
    }
});

$(document).on("click", ".edit_course", function (e) {
    let y = $(this).data('val');
    step = y;
    toggleTab();
});


// start  course assignment load via post
function courseAssignmentLoad() {
    var pageURL = $('.course-assignment-load').data('href');
    var loadClass = 'course-assignment-load';
    getPagination(pageURL, loadClass);

}
// end course assignment load via post

// start  pagination load via post
$(document).on("click", ".organization_assignment__paginate", function (e) {
    e.preventDefault();
    getPagination($(this).attr("href"),'course-assignment-load');
});

// start  course noticeBoard load via post
function courseNoticeBoardLoad() {
    var pageURL = $('.course-notice-board-load').data('href');
    var loadClass = 'course-notice-board-load';
    getPagination(pageURL, loadClass);

}
$(document).on("click", ".organization_noticeboard__paginate", function (e) {
    e.preventDefault();
    getPagination($(this).attr("href"),'course-notice-board-load');
});
// end course assignment load via post

if ($("#course_step").length > 0) {
    var count_step = localStorage.getItem(course_step_count) ?? 1;
    if (count_step > 0) {
        step = count_step;
        toggleTab();
    }
}


$( ".droppable-area1" ).sortable({
    connectWith: ".connected-sortable",
    stack: '.connected-sortable'
}).disableSelection();

$( ".lesson-droppable" ).sortable({
    connectWith: ".connected-sortable-lesson",
    stack: '.connected-sortable-lesson'
}).disableSelection();
$( ".question-droppable" ).sortable({
    connectWith: ".connected-sortable-question",
    stack: '.connected-sortable-question'
}).disableSelection();

$(".droppable-area1").on("sortupdate", function( event, ui ) {
    if (event.target.className == $(this).attr('class')) {
    let data = [];
    $('.single-accordion').each(function() {
        var id = $(this).data('id');
        data.push(id);
      });
      let course_id = $('.course_id').data("id");
      PostRequest(`${webUrl}/instructor/sortable-section/${course_id}`, {data})
      .then(response => {
        if (response?.result) {
            successHandler(response?.message);
        } else {
          errorHandler(something_went_wrong);
        }
      })
      .catch(error => {
        errorHandler(something_went_wrong);
      });
    }
});
$(".lesson-droppable").on("sortupdate", function( event, ui ) {
    if (event.target.className == $(this).attr('class')) {
        let data = [];
        $('.lessons').each(function() {
            var id = $(this).data('id');
            data.push(id);
        });
        let course_id = $('.course_id').data("id");
        PostRequest(`${webUrl}/instructor/sortable-lesson/${course_id}`, {data})
        .then(response => {
            if (response?.result) {
                successHandler(response?.message);
            } else {
            errorHandler(something_went_wrong);
            }
        })
        .catch(error => {
            errorHandler(something_went_wrong);
        });
    }
});
$(".question-droppable").on("sortupdate", function( event, ui ) {
    if (event.target.className == $(this).attr('class')) {
        let data = [];
        $('.questions').each(function() {
            var id = $(this).data('id');
            data.push(id);
        });
        let course_id = $('.course_id').data("id");
        PostRequest(`${webUrl}/instructor/sortable-question/${course_id}`, {data})
        .then(response => {
            if (response?.result) {
                successHandler(response?.message);
            } else {
            errorHandler(something_went_wrong);
            }
        })
        .catch(error => {
            errorHandler(something_went_wrong);
        });
    }
});
