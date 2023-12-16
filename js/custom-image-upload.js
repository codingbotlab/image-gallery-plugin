jQuery(document).ready(function($) {
    $('#upload-button').click(function() {
        var fileInput = $('#custom-upload-button')[0];
        var file = fileInput.files[0];
        var formData = new FormData();

        formData.append('file', file);
        formData.append('action', 'custom_upload_image');
        formData.append('nonce', custom_upload_vars.custom_upload_nonce);

        $.ajax({
            type: 'POST',
            url: custom_upload_vars.custom_upload_ajaxurl,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#uploaded-image').html(response);
            },
        });
    });
});
