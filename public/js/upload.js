toastr.options = {
    "closeButton": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false
};

$(document).ready(function() {
    var $form = $('#image-upload-form')

    $form.find('button[type="submit"]').on('click', function () {
        event.preventDefault();
        var data = new FormData();
        var $imageFormInput = $form.find('input#images');
        var files = $imageFormInput.prop('files');

        if (typeof files === 'undefined' || files.length == 0) {
            toastr.warning('Please, select files before uploading');
            return false;
        }

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            data.append($imageFormInput.attr("name"), file);
        }

        data.set("_token", $form.find('input[name="_token"]').val());
        $form.waitMe({
            effect : 'roundBounce',
            text : '',
            bg : "rgba(0, 0, 0, 0.25)",
            color : "#fb6470"
        })
        
        $.ajax({
            url: $form.attr("action"),
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data)
                var uploadedImages = Object.values(data['uploadedImages']);
                if (typeof uploadedImages !== 'undefined' && uploadedImages.length > 0) {
                    toastr.success(uploadedImages.join("<br>"), 'UPLOADED IMAGES');
                }

                var failedUploads = Object.values(data['failedUploads']);
                if (typeof failedUploads !== 'indefined' && failedUploads.length > 0) {
                    toastr.error(failedUploads.join("<br>"), 'FAILED UPLOADS');
                }
            },
            error: function(data) {
                var errorMessage = 'Unexpected server error. Try please later';

                if (typeof data['responseJSONwdwad'] !== 'undefined'
                    && typeof data['responseJSON']['message'] !== 'undefined')
                {
                    errorMessage = data['responseJSON']['message'];
                }

                toastr.error(errorMessage, 'ERROR');
            },
            complete: function() {
                $form.waitMe('hide');
                $imageFormInput.val(null);
            }
        })
    })

    $('#uploaded-images-table').find('a.delete-image').on('click', function() {
        event.preventDefault();
        var $parentTableRow = $(this).parents("tr");
        $parentTableRow.waitMe({
            effect : 'bounce',
            text : '',
            bg : "rgba(0, 0, 0, 0.50)",
            color : "#fb6470"
        });

        $.ajax({
            url: $(this).attr("href"),
            type: "POST",
            data: {'_token': $('input[name="_token"]').val()},
            success: function() {
                toastr.success('Image was deleted.');
                $parentTableRow.remove();
            },
            error: function() {
                toastr.error('Unexpected server error. Try please later.');
                $parentTableRow.waitMe("hide");
            }
        })
    })
})
