$(document).on('click', '.up_doc_rmv_btn', function () {
    var up_prev_rmv = $(this);
    up_prev_rmv.closest('.up_doc_prev_con').addClass('hidden');
    up_prev_rmv.closest('.up_doc_con').find('.up_input').val('');
    up_prev_rmv.closest('.up_doc_con').find('.set-document').attr('src', '').attr('href', '');
    up_prev_rmv.closest('.up_doc_con').find('.pdf-icon').addClass('hidden');
    up_prev_rmv.closest('.up_doc_con').find('.set-image').addClass('hidden');
});

$(document).on('change', '.up_input', function (event) {
    var up_prev = $(this);
    let index = $('.up_input').index(this);
    var up_prev_name = $(this)[0].files[0];
    if (up_prev_name) {
        let fileSize = up_prev_name.size / 1024 / 1024
        if (fileSize < 2) {
            let extension = up_prev_name.name.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'pdf'].includes(extension)) {
                const fileURL = URL.createObjectURL(up_prev_name);
                if (extension === "pdf") {
                    up_prev.closest('.up_doc_con').find('.set-document').attr('href', fileURL);
                    up_prev.closest('.up_doc_con').find('.pdf-icon').removeClass('hidden');
                    up_prev.closest('.up_doc_con').find('.set-image').addClass('hidden');
                } else {
                    up_prev.closest('.up_doc_con').find('.set-image').attr('src', fileURL);
                    up_prev.closest('.up_doc_con').find('.pdf-icon').addClass('hidden');
                    up_prev.closest('.up_doc_con').find('.set-image').removeClass('hidden');
                }
                up_prev.closest('.up_doc_con').find('.up_doc_prev_con').removeClass('hidden');
                $('.file-error').eq(index).html('');
            } else {
                $('.file-error').eq(index).html('Invalid file format. Only PDF, JPG, JPEG, and PNG are supported.');

                up_prev.val('');
            }

        } else {
            up_prev.val('');
            up_prev.closest('.up_doc_con').find('.set-document').attr('href', '');
            up_prev.closest('.up_doc_con').find('.set-image').attr('src', '');
            up_prev.closest('.up_doc_con').find('.up_doc_prev_con').addClass('hidden');
            $('.file-error').eq(index).html('File size is only 2 mb.');
        }
    } else {
        up_prev.closest('.up_doc_con').find('.set-document').attr('href', '');
        up_prev.closest('.up_doc_con').find('.set-image').attr('src', '');
        up_prev.closest('.up_doc_con').find('.up_doc_prev_con').addClass('hidden');
    }

    // Update the file name
    if (up_prev_name) {
        var fileName = up_prev_name.name;
        up_prev.closest('.up_doc_con').find('.up_doc_name').html(fileName);
    }
});

$('#closePrevModalButton').on('click', function () {
    $('#prevModal').addClass('hidden');
    $('body').css('overflow', 'visible');
});
