(function ($) {
    "use strict";

    $(document).ready(function () {
        var _token = $('meta[name="csrf-token"]').attr("content");
        // select instructor start
        $(".instructor_select").select2({
            placement: "bottom",
            innerWidth: "100%",
            ajax: {
                url: $(".instructor_select").data("href"),
                dataType: "json",
                data: function (params) {
                    return {
                        term: params.term,
                        _token: _token,
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

        // select categories start

        $(".categories_select").select2({
            placement: "bottom",
            innerWidth: "100%",
            ajax: {
                url: $(".categories_select").data("href"),
                dataType: "json",
                data: function (params) {
                    return {
                        term: params.term,
                        _token: _token,
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
        });
    });

    // Select categories end
})(jQuery);
