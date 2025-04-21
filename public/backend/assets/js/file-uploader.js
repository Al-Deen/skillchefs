(function ($) {
    "use strict";
    // image picker arrow function start

    $(".file").each(function () {
        $(this).jubaerImagePicker({
            fieldName: $(this).data('name'),
            maxCount: 1,
            rowHeight: $(this).data('height'),
            groupClassName: 'col-lg-12',
            loaderIcon: '<i class="fa fa-close"></i>',
            maxFileSize: '1024',
            dropFileLabel: "Drop Here",
            defaultImage: $(this).data('val'),
            onAddRow: function (index) {},
            onRenderedPreview: function (index) {

            },
            onRemoveRow: function (index) {

            },
            onExtensionErr: function (index, file) {
                toaster.fire({
                    icon: 'error',
                    title: file_type_not_allowed
                })
            },
            onSizeErr: function (index, file) {
                toaster.fire({
                    icon: 'error',
                    title: file_size_not_allowed
                })
            }
        });
    });



    $(".thumbnail").each(function () {
        $(this).jubaerImagePicker({
            fieldName: $(this).data('name'),
            maxCount: 1,
            rowHeight: $(this).data('height'),
            groupClassName: 'col-lg-12',
            loaderIcon: '<i class="fa fa-close"></i>',
            maxFileSize: '1024',
            dropFileLabel: "Drop Here",
            onAddRow: function (index) {},
            onRenderedPreview: function (index) {
            },
            onRemoveRow: function (index) {
            },
            onExtensionErr: function (index, file) {
                toaster.fire({
                    icon: 'error',
                    title: file_type_not_allowed
                })
            },
            onSizeErr: function (index, file) {
                toaster.fire({
                    icon: 'error',
                    title: file_size_not_allowed
                })
            }
        });
    });

})(jQuery);
