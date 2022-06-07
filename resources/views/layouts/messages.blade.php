{{--@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endforeach
@endif--}}

@foreach (['success', 'info', 'warning', 'danger'] as $message)
    @if (session()->has('alert-' . $message))
        <div class="alert alert-{{ $message }}">
            {{ session()->get('alert-' . $message) }}
        </div>
    @endif
@endforeach
