import './bootstrap';
$(document).ready(function () {

    $('#scanner').val('');  // Input field should be empty on page load
    $('#scanner').focus();  // Input field should be focused on page load 

    $('html').on('click', function () {
        $('#scanner').focus();  // Input field should be focused again if you click anywhere
    });

    $('html').on('blur', function () {
        $('#scanner').focus();  // Input field should be focused again if you blur
    });

    $('#scanner').change(function () {

        if ($('#scanner').val() == '') {
            return;  // Do nothing if input field is empty
        }

        $.ajax({
            url: '/scan/save',
            cache: false,
            type: 'GET',
            data: {
                user_id: $('#scanner').val()
            },
            success: function (response) {
                $('#scanner').val('');
            }
        });
    });
});
