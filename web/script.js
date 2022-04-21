$(document.body).on('click', '#delete', function () {
    console.log($(this).attr('user'));
    $.ajax({
        url: urlDelete,
        type: 'POST',
        data: {
            id: $(this).attr('user')
        },
        success: function (data) {
        },
    });

});