<script>
    const notyf = new Notyf({
        position: {
            x: 'right',
            y: 'top',
        },
        types: [
            {
                type: 'success',
                background: '#10b981',
                icon: {
                    className: 'fa-solid fa-circle-check',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            },
            {
                type: 'info',
                background: '#2361ce',
                icon: {
                    className: 'fa-solid fa-circle-info',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            },
            {
                type: 'warning',
                background: '#fba918',
                icon: {
                    className: 'fa-solid fa-circle-exclamation',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            },
            {
                type: 'danger',
                background: '#e11d48',
                icon: {
                    className: 'fa-solid fa-circle-exclamation',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }
        ]
    });

    @foreach (['success', 'info', 'warning', 'danger'] as $message)
    @if (session()->has('alert-' . $message))
    notyf.open({
        type: '{{ $message }}',
        message: "{{ session()->get('alert-' . $message) }}"
    });
    @endif
    @endforeach
</script>
