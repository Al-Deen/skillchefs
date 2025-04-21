"use strict";
const endpoint = $("meta[name='baseurl']").attr("content");

let page = 1;
let total_page = 1;

window.quizUp = async () => {
    let url = endpoint + "/student/quiz/question-up/"+ $("#quiz-result-container").data("id");
    try {
        const response = await fetch(url );
        if (response.ok) {
            const { result, message, data } = await response.json();
            if (result) {
                window.location.href = endpoint + "/student/quiz/quiz/" + $('#quiz_id').data('id');
            }
        }
    } catch (error) {
    }
}

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            quizUp();
            timer = duration;
        }
    }, 1000);
}

window.onload = function () {
    var fiveMinutes = 60 * $('#time').data('value'),
        display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
};


window.quizLoad = async () => {
    let url = endpoint + "/student/quiz/question-load/"+ $("#quiz_id").data("id") +"?" + "page=" + page;
    try {
        const response = await fetch(url );
        if (response.ok) {
            const { result, message, data } = await response.json();
            if (result) {
                page ++;
                $("#question_list").html(data?.html);

            }
        }
    } catch (error) {
    }
}
$(document).ready(function () {
   quizLoad();
});



// Start question submit
window.submitQuestion = async (pagination_url, lastQuestion = null) => {
    let url = endpoint + "/student/quiz/question-submit";
    let answer = $('input:checked').map(function(i, e) {return e.value}).toArray();
    let quiz_result_id = $("#quiz-result-container").data("id");
    let question_id = $("#display-question").data("id");
    if (answer.length == 0 && lastQuestion == 1) {
        window.location.href = pagination_url;
        return false;
    }else if (answer.length == 0 && lastQuestion == null) {
        quizLoad();
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
                const { result } = response;
                if (result) {
                    if (lastQuestion == null) {
                        quizLoad();
                    }else{
                        window.location.href = pagination_url;
                    }
                }
            },
            error: function (error) {
            }

        });

    } catch (error) {
    }
}

// End question submit

$(document).on('click', '.submitQuestion', function (e) {
    let pagination_url = endpoint + "/student/quiz/answer-list/" + $('#quiz_id').data('id');
    pagination_url &&
    submitQuestion(pagination_url, 1);


});
$(document).on('click', '.paginationQuestion', function (e) {
    e.preventDefault();
    let pagination_url = $(this).attr('href');
    pagination_url &&
    submitQuestion(pagination_url);
});
