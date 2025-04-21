"use strict";
var endpoint = $("meta[name='baseurl']").attr("content");

let page = 1;
let total_page = 1;

function quizInit(int_url){
    $.ajax({
        url: int_url,
        type: "GET",
        success: function (response) {
            const { result, message, data } = response;
            if (result) {
                $("#quiz_load").html(data?.html);
                if(data?.quiz_start){
                    data?.time ? startTimer(data?.time) : $('.time').remove();
                    quizLoad();
                }
            }else{
                errorHandler(message);
            }
        },
        error: function (error) {
            errorHandler(something_went_wrong);
        }

    });
}

$('#quiz_load').length && quizInit($('#quiz_load').data('url'));
window.quizStart = async (url) => {
    quizInit(url);
}





window.quizUp = async () => {
    let url = endpoint + "/student/quiz/question-up/"+ $("#quiz-result-container").data("id");
    try {
        const response = await fetch(url );
        if (response.ok) {
            const { result, message, data } = await response.json();
            if (result) {
                window.location.reload();
            }
        }
    } catch (error) {
    }
}

function startTimer(duration) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        $('#time_count').html(minutes + ":" + seconds);
        if (--timer < 0) {
            quizUp();
            timer = duration;
        }
    }, 1000);
}





window.quizLoad = async () => {
    let url = endpoint + "/student/quiz/question-load/"+ $("#quiz_id").data("id") +"?" + "page=" + page;
    try {
        const response = await fetch(url );
        if (response.ok) {
            const { result, message, data } = await response.json();
            if (result) {
                page ++;
                $("#question_list").html(data?.html);
                $('#question-number').html(data?.question_number);

            }else{
                errorHandler(message);
            }
        }
    } catch (error) {
        errorHandler(something_went_wrong);
    }
}




// Start question submit
window.submitQuestion = async (pagination_url, lastQuestion = null) => {
    let url = endpoint + "/student/quiz/question-submit";
    let answer = $('input[name="option"]:checked').map(function(i, e) {return e.value}).toArray();
    let quiz_result_id = $("#quiz-result-container").data("id");
    let question_id = $("#display-question").data("id");
    if (answer.length == 0 && lastQuestion == 1) {
        quizLoad();
        return false;
    }else if (answer.length == 0 && lastQuestion == null) {
        quizLoad();
        return false;
    }
    let data = {
        question_id: question_id,
        answer: answer,
        quiz_id: quiz_result_id,
        lastQuestion: lastQuestion,
        _token: csrf_token
    }
    try {
        await $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (response) {
                const { result, data } = response;
                if (result) {
                    if (lastQuestion == null) {
                        quizLoad();
                    }else{
                        quizInit(pagination_url);
                    }
                }
            },
            error: function (error) {
                errorHandler(something_went_wrong);
            }

        });

    } catch (error) {
        errorHandler(something_went_wrong);
    }
}

// End question submit

$(document).on('click', '.submitQuestion', function (e) {
    let pagination_url = endpoint + "/student/quiz/answer-list/" + $('#quiz_id').data('id');
    pagination_url &&
    submitQuestion(pagination_url, 1);
});
$(document).on('click', '.prevPaginationQuestion', function (e) {
    e.preventDefault();
    page = page - 2;
    quizLoad();
});
$(document).on('click', '.skipPaginationQuestion', function (e) {
    e.preventDefault();
    quizLoad();
});
$(document).on('click', '.paginationQuestion', function (e) {
    e.preventDefault();
    let pagination_url = $(this).attr('href');
    pagination_url &&
    submitQuestion(pagination_url);
});
