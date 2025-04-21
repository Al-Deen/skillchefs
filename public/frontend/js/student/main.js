"use strict";
import { countryListRoute, lectureProgressRoute, tabLoadRoute } from "../__route.js";
let lesson_id;
let selected_lessons = [];
let token = $('meta[name="csrf_token"]').attr("content");

$(document).on("click", "#lesson-start", function (e) {
    e.preventDefault();
    let url = location.href.split("learn/lecture");
    window.location.href = url[0] + "learn/lecture/" + $(this).data("id");
});

$('.select2').select2();
window.lessonProgress = async () => {
    try {
        await fetch(lectureProgressRoute, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
            },
            body: JSON.stringify({
                lesson_id: lesson_id,
                completed_lessons: selected_lessons,
            }),
        })
            .then((response) => response.json())
            .then((res) => {
                const { result, message, data } = res;
                if (result ) {
                    successHandler(message);
                }else{
                    errorHandler(message);
                }
            })
            .catch((error) => {
                errorHandler(error);
            });
    } catch (error) {
        errorHandler(something_went_wrong);
    }
};


$(document).on("change", "#lesson-progress", function () {
    lesson_id = $(this).data("id");
    selected_lessons = $("[name='lesson_id[]']:checked")
        .map(function () {
            return $(this).val();
        })
        .get();
     lessonProgress();
});

// Start  course detail page video player
$('#player').length &&
new Plyr("#player");
// End  course detail page video player


// course details tab change


window.tabLoad = async (tab) => {
    try {
        await fetch(tabLoadRoute, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
            },
            body: JSON.stringify({
                enrollId: $('.enroll-id').data("id"),
                tab: tab,
            }),
        })
            .then((response) => response.json())
            .then((res) => {
                const { result, message, data } = res;
                if (result ) {
                   if (tab == 'Notes') {
                    $('#notes_list').html(data);
                   }

                   else if (tab == 'Assignment') {
                    $('#assignments_list').html(data);
                   }else if (tab == 'Review') {
                    $('#reviews_list').html(data);

                   }
                }else{
                    errorHandler(message);
                }
            })
            .catch((error) => {
                errorHandler(error);
            });
    } catch (error) {
        errorHandler(something_went_wrong);
    }
};
var tabName = 'Overview';

function tabOpen(){
    tabName = localStorage.getItem('tabName') ?? 'Overview';
    $('.learn-tab').removeClass('active');
    $('.learn-tab[data-id="'+tabName+'"]').addClass('active');
    $(".tab-pane").removeClass("show active");
    $("#" + tabName).addClass("show active");
    if(tabName != null && tabName != undefined && tabName != 'Overview' && tabName != 'Announcement') {
        tabLoad(tabName);
    }

}

$(document).ready(function(){
    $('.course-play').length > 0 && tabOpen();
});


$(document).on('click', '.learn-tab', function(e) {
    let tab = $(this).data('id');
    tabName = tab;
    localStorage.setItem('tabName', tabName);
    if(tab != null && tab != undefined && tab != 'Overview' && tab != 'Announcement') {
        tabLoad(tab);
    }
});



// note store in database


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
    },
});
// Select instructor end




