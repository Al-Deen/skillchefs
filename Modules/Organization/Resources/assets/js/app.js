"use strict";
(function ($) {
    var _token = $('meta[name="csrf-token"]').attr('content');
});
$(document).ready(function() {
    var arr = [];

    $(".instructor_select_multiple").select2({
        placeholder: $(".instructor_select_multiple").attr("data-placeholder")
    });

    $(".instructor_select_multiple").on("select2:select", function (e) {
        var data = e.params.data;
        if (!arr.includes(data.id)) {
            arr.push(data.id);
            let template = `
                <div class='row' id="instructor_${data.id}">
                    <div class="col-xl-6 col-md-6 mb-3">
                        <input type="text" class="form-control ot-input col-xl-6 col-md-6" value="${data.text}" disabled/>
                    </div>
                    <div class="col-xl-5 col-md-5 mb-3">
                        <input type="text" name="commissions[${data.id}]" value="0" min="0" max="100" placeholder="commission" id="commission_${data.id}" class="form-control ot-input col-xl-6 col-md-6"/>
                    </div>
                    <div class="col-xl-1 col-md-1 mb-3">
                        <a class="btn btn-danger remove ri-delete-bin-line" data-id="${data.id}"></a>
                    </div>
                </div>
            `;
            $("#show_instructor_fields").append(template);
        }        
    });
    $("#show_instructor_fields").on("click", ".remove", function () {
        var instructorId = $(this).data("id");
        $("#instructor_" + instructorId).remove(); 
        arr = arr.filter(id => id !== instructorId.toString());
        $(".instructor_select_multiple").find(`option[value="${instructorId}"]`).prop("selected", false);
        $(".instructor_select_multiple").trigger("change");
    });
    
    
    $(".instructor_select_multiple").on("select2:unselect", function (e) {
        var data = e.params.data;
        var instructorId = data.id;
        $("#instructor_" + instructorId).remove(); 
        arr = arr.filter(id => id !== instructorId.toString());
    });



});
