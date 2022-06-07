/*
 * Custom JS
 */

const notyf = new Notyf({
    position: {
        x: 'center',
        y: 'bottom',
    },
    types: [
        {
            type: 'success',
            background: '#05A677',
            icon: {
                className: 'fas fa-check',
                tagName: 'span',
                color: '#fff'
            },
            dismissible: false
        },
        {
            type: 'info',
            background: '#0948B3',
            icon: {
                className: 'fas fa-info',
                tagName: 'span',
                color: '#fff'
            },
            dismissible: false
        },
        {
            type: 'warning',
            background: '#F5B759',
            icon: {
                className: 'fas fa-exclamation',
                tagName: 'span',
                color: '#fff'
            },
            dismissible: false
        },
        {
            type: 'danger',
            background: '#FA5252',
            icon: {
                className: 'fas fa-times',
                tagName: 'span',
                color: '#fff'
            },
            dismissible: false
        }
    ]
});

function show_notif(type, message) {
    if (type == 'success') {
        notyf.open({
            type: 'success',
            message: message
        });
    }
    else if (type == 'info') {
        notyf.open({
            type: 'info',
            message: message
        });
    }
    else if (type == 'warning') {
        notyf.open({
            type: 'warning',
            message: message
        });
    }
    else if (type == 'danger') {
        notyf.open({
            type: 'danger',
            message: message
        });
    }
    else {
        notyf.open({
            type: 'danger',
            message: message
        });
    }
}

function show_notifs(response) {
    var result_data = (typeof(response) === 'string') ? JSON.parse(response) : response;

    if (result_data.is_error == false) {
        result_data.message.split(', ').forEach(function(message) {
            show_notif('success', message);
        });
    }
    else if (result_data.is_error == true) {
        result_data.message.split(', ').forEach(function(message) {
            show_notif('error', message);
        });
    }
}
