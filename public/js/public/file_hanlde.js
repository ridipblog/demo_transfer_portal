$(document).on('click', '.up_doc_rmv_btn', function () {
    var up_prev_rmv = $(this);
    up_prev_rmv.closest('.up_doc_prev_con').addClass('hidden');
    up_prev_rmv.closest('.up_doc_con').find('.up_input').val('');  // Clear the file input field
});

$(document).on('change', '.up_input', function () {
    var up_prev = $(this);
    var up_prev_name = $(this)[0].files[0];

    // Check if a file is selected
    if (up_prev.val() != null && up_prev.val() != "") {
        up_prev.closest('.up_doc_con').find('.up_doc_prev_con').removeClass('hidden');
    } else {
        up_prev.closest('.up_doc_con').find('.up_doc_prev_con').addClass('hidden');
    }

    // If a file is selected, update the specific file name field
    if (up_prev_name) {
        var fileName = up_prev_name.name;
        up_prev.closest('.up_doc_con').find('.up_doc_name').html(fileName);  // Target the correct .up_doc_name element
    }
});
$('#closePrevModalButton').on('click', function () {
    $('#prevModal').addClass('hidden');
        $('body').css('overflow', 'visible');
});
