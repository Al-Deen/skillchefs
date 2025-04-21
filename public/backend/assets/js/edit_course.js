(function ($) {
    "use strict";

    var course_id = $('#course_id').val();
    var _token = $('meta[name="csrf-token"]').attr('content');

    function addInput(placeholder, name, id, deleteAction, requirementCount) {
        let html = `<div class="row mt-3 mb-3" id="${requirementCount}">
                        <div class="col-11">
                            <input
                                class="form-control ot-input"
                                name="${name}[]" list="datalistOptions" required
                                id="${id}"
                                placeholder="${placeholder}">
                        </div>
                        <div class="col-1">
                            <button type="button"
                                class="btn btn-danger ${deleteAction} w-48 h-48">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>`;
        return html;
    }
    // start add requirement input
    let requirementCount = 1;
    $(document).on('click', '.add-requirements', function () {
        requirementCount++;
        let html = addInput(enter_requirement, 'requirements', 'requirements', 'delete-requirements', 'requirement' + requirementCount)
        $('#requirement1').after(html);
    });
    // end add requirement input
    // start delete requirement input
    $(document).on('click', '.delete-requirements', function () {
        let id = $(this).parent().parent().attr('id');
        $('#' + id).remove();

    });
    // end delete requirement input
    // start add outcomes  input
    let outcomeCount = 1;
    $(document).on('click', '.add-outcomes', function () {
        outcomeCount++;
        let html = addInput(enter_requirement, 'outcomes', 'outcomes', 'delete-outcomes', 'outcome' + outcomeCount)
        $('#outcome1').after(html);
    });
    // end add outcomes  input
    // start delete outcomes  input
    $(document).on('click', '.delete-outcomes', function () {
        let id = $(this).parent().parent().attr('id');
        $('#' + id).remove();
    });

    // if course is free then hide price input and discount input
    $('#is_free_course').on('click', function () {
        if (this.checked) {
            $('.price_div').hide();
        } else {
            $('.price_div').show();
        }
    });

    // if course is auto free then hide price input and discount input
    $('#is_free_course').on('onload', function () {
        if (this.checked) {
            $('.price_div').hide();
        } else {
            $('.price_div').show();
        }
    });





    // course preview type
    $('#course_preview').on('change', function () {
        let preview_type = $(this).val();
        if (preview_type == 24) {
            $('.video_url').hide();
            $('.video_url').prop('required', false);
        } else if (preview_type == 15 || preview_type == 16){
            $('#video_url').show();
            $('#video_url').prop('required', true);
            //$('.video_url').prop('required', true);
        } else {
            $('.video_url').show();
            //$('.video_url').prop('required', true);
            $('#video_url').prop('required', false);
        }
    });


    let count = 1;
    let next;
    let previous;

    // input validation
    const validateInput = (input) => {
        if (input.value === "") {
            input.classList.add("is-invalid");
            // remove previous error message
            if (input.nextElementSibling) {
                input.nextElementSibling.remove();
            }
            input.insertAdjacentHTML('afterend', `<div class="invalid-feedback">
            ${input.id} is required
          </div>`);
            return false;
        } else {
            input.classList.remove("is-invalid");
            return true;
        }
    };

    // select2 validation
    const validateSelect2 = (select) => {
        if (select.value === "") {
            select.classList.add("is-invalid");
            $('#' + select.id).next('span').next().remove();
            $('#' + select.id).next('span').after(`<div class="invalid-feedback">
            ${select.id} is required
            </div>`);
            return false;
        } else {
            select.classList.remove("is-invalid");
            return true;
        }
    };

    // image validation
    const validateImage = (image) => {
        if (image.files.length === 0) {
            image.classList.add("is-invalid");
            image.insertAdjacentHTML('afterend', `<div class="invalid-feedback">
            ${image.id} is required
            </div>`);
            return false;
        } else {
            image.classList.remove("is-invalid");
            return true;
        }
    };



    // general validation
    let generalValidation = () => {
        let title = document.querySelector("#title");
        let category = document.querySelector("#category");
        let course_level = document.querySelector("#course_level");
        let language = document.querySelector("#language");
        let instructor = document.querySelector("#instructor");
        if (!validateInput(title) || !validateSelect2(instructor) || !validateInput(course_level) || !validateSelect2(category) || !validateInput(language)) {
            return false;
        }
        return true;
    }

    // media validation
    let mediaValidation = () => {
        let course_preview = document.querySelector("#course_preview");
        let video_url = document.querySelector("#video_url");
        let thumbnail = document.getElementsByName("thumbnail");
        // if (!validateSelect2(course_preview) || (course_preview.value != 24 && !validateInput(video_url))) {
        //     return false;
        // }
        if ((course_preview.value == 15 || course_preview.value == 16) && !validateInput(video_url)) {
            return false;
        }
        return true;
    }





    function toggleTab(next, previous) {
        $('.single-multiStep-request-list-item-number').removeClass('active'); // remove active class from all tabs
        $('.single-multiStep-request-list-item-number').removeClass('danger'); // remove active class from all tabs
        $('.tab' + previous).removeClass('current-items'); // remove active class from all tabs
        $('.tab' + previous).children().addClass('success'); // add success class to the previous tab

        $(`.tab${next}`).addClass('current-items'); // add active class to the current tab
        $(`.tab${next}`).children().addClass('active'); // add active class to the current tab

        //  form display toggle
        $('.multiStep-wrapper-contents').removeClass('active'); // remove active class from all tabs
        $(`.step${next}`).addClass('active'); // add active class to the current tab


    }

    function dangerTab(current) {
        $('.single-multiStep-request-list-item-number').removeClass('active'); // remove active class from all tabs
        $(`.tab${current}`).children().addClass('danger'); // add active class to the current tab
    }
    console.clear();

    let increase = () => {
        previous = count;
        (count != 6) ? count++ : count = count;
        next = count;
        toggleTab(next, previous);
    }


    $(document).on('click', '#next', function () {
        if (count == 5) {
            $('.next').addClass('d-none');
        } else {
            $('.next').removeClass('d-none');
        }
        if (count == 1) {
            if (generalValidation()) {
                increase();
            } else {
                dangerTab(count);
            }
        } else if (count == 2) {
            increase();
        } else if (count == 3) {
            increase();
        } else if (count == 4) {
            if (mediaValidation()) {
                increase();
            } else {
                dangerTab(count);
            }
        } else if (count == 5) {
            increase();
        } else if (count == 6) {
            increase();
        }

    });
    $(document).on('click', '#previous', function () {
        previous = next;
        (count != 1) ? count-- : count = count;
        next = count;
        if (count == 6) {
            $('.next').addClass('d-none');
        } else {
            $('.next').removeClass('d-none');
        }
        toggleTab(next, previous);
    });

    $('#courseSubmit').on('submit', function (event) {
        if (count == 6) {
            return true;
        } else {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }
    });

    $('.__course_edit').on('click', function () {
        // get parent array class name of clicked element
        var parentClass = $(this).parent().attr('class');
        // get second class name of parent array
        var class_name = parentClass.split(" ")[1];
        class_name = class_name.split("tab")[1];
        count = class_name;
        next = class_name;
        previous = class_name > 1 ? class_name - 1 : 1;
        if (count == 6) {
            $('.next').addClass('d-none');
        } else {
            $('.next').removeClass('d-none');
        }
        for (var i = 1; i <= count; i++) {
            toggleTab(i, i <= count - 1 ? i : count - 1);
        }
    });



})(jQuery);
