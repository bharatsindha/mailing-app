<nav aria-label="breadcrumb" class="d-none d-md-inline-block">
    <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">
                @include('icons.home')
            </a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ env('APP_NAME') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page"> {{ $module }}</li>
    </ol>
</nav>
