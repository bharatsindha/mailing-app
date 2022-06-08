@extends('layouts.admin.main')
@section('title', 'Emails')
@section('stylesheets')
    @parent
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Edit Email') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Emails'])
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">{{ __('Emails information') }}</h2>
                <form method="POST" action="{{ route('admin.emails.update', $result->id) }}">
                    @method('PUT')
                    @csrf
                    @include('email::form', ['result' => $result])
                    @include('actions.form_actions', ['cancel' => true, 'update' => true])
                </form>
            </div>
        </div>
        <div class="col-12 col-xl-4"></div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
