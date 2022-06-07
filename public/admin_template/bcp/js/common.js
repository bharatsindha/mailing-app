function get_data_ajax() {
    var form = $('form#get_data');

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: $('form#get_data').serialize(),
        success: function (data) {
            $('.ajax-content').html(data);
        },
        error: function (xhr, textStatus, errorThrown) {
            alert('Error in fetching data. Please try again.');
        }
    });
}

$(document).on('submit', 'form#get_data', function (event) {
    event.preventDefault();
    get_data_ajax();
});

$(document).on('click', '.pagination>li>a', function (event) {
    event.preventDefault();
    $('#page').val($(this).text());
    get_data_ajax();
});

$(document).ready(function () {
    $('form#get_data').submit();
});

var typingTimer;

$('#q').keyup(function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function () {
        $('#page').val('1');
        get_data_ajax();
    }, 1000);
});

$(document).on('change', '#file', function (event) {
    if (event.target.files.length) {
        var form = $('form#import-data');
        var formData = new FormData(form[0]);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                // clear the file input
                $('#file').val('');
                show_notifs(data);
                $('#page').val('1');
                get_data_ajax();
            },
            error: function (err) {
                // clear the file input
                $('#file').val('');
                show_notifs(err.responseText);
            }
        });
    }
});

$(document).on('submit', 'form.delete-action', function (event) {
    if (confirm('Are you sure you want to delete this?')) {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (data) {
                show_notifs(data);
                $('#page').val('1');
                get_data_ajax();
            },
            error: function (err) {
                show_notifs(err.responseText);
            }
        });
    }

    return false;
});
