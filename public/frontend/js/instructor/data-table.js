"use strict";

var __url = $('meta[name="base-url"]').attr("content");
var _token = $('meta[name="csrf-token"]').attr("content");
let pageURL;
let loadClass;
let filterData;
let course_id = $('#course_id').val();



function pagination(url) {
    pageURL = url;
    getPagination(pageURL, loadClass, filterData);

}


// table schema start

// start  course assignment load via post
function courseAssignmentLoad() {
    filterData = {
        course_id: course_id,
        search: $('input[name="assignmentSearch"]').val(),
        show_more: $('.ajax_show_more').val(),
    };
    pageURL = $('.course-assignment-lod').data('href');
    loadClass = 'course-assignment-lod';
    getPagination();

}
$('.course-assignment-load').length > 0 && courseAssignmentLoad();
// end course assignment load via post


// start  course noticeboard via post
function courseNoticeboardLoad() {
    filterData = {
        course_id: course_id,
        search: $('input[name="noticeboardSearch"]').val(),
        show_more: $('.ajax_show_more').val(),
    };
    pageURL = $('.course-noticeboard-load').data('href');
    loadClass = 'course-noticeboard-load';
    getPagination();

}
$('.course-noticeboard-load').length > 0 && courseNoticeboardLoad();
// end course noticeboard via post
