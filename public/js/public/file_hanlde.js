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
    var up_prev_name = $(this)[0].files[0];

    if (up_prev_name) {
        let extension = up_prev_name.name.split('.').pop().toLowerCase();
        const reader = new FileReader();

        reader.onload = function (e) {
            if (extension === "pdf") {
                up_prev.closest('.up_doc_con').find('.set-document').attr('href', e.target.result);
                up_prev.closest('.up_doc_con').find('.pdf-icon').removeClass('hidden');
                up_prev.closest('.up_doc_con').find('.set-image').addClass('hidden');
            } else {
                up_prev.closest('.up_doc_con').find('.set-image').attr('src', e.target.result);
                up_prev.closest('.up_doc_con').find('.pdf-icon').addClass('hidden');
                up_prev.closest('.up_doc_con').find('.set-image').removeClass('hidden');
            }
        };

        if (extension === "pdf") {
            reader.readAsDataURL(up_prev_name); // For PDF Preview
        } else if (['jpg', 'jpeg', 'png'].includes(extension)) {
            reader.readAsDataURL(up_prev_name); // For Image Preview
        } else {
            alert('Invalid file format. Only PDF, JPG, JPEG, and PNG are supported.');
            up_prev.val(''); // Clear invalid file
        }

        up_prev.closest('.up_doc_con').find('.up_doc_prev_con').removeClass('hidden');
    } else {
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
