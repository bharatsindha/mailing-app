@extends('layouts.admin.main')
@section('title', 'Users')
@section('stylesheets')
    @parent
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('View User') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Users'])
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('General Information') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Name') }}</label>
                            <div class="small text-gray">{{ $result->name }}</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Email') }}</label>
                            <div class="small text-gray">{{ $result->email }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Role') }}</label>
                            <div class="small text-gray">
                                <span class="badge bg-secondary">{{ ucfirst($result->role) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Created At') }}</label>
                            <div
                                class="small text-gray">{{ \App\Facades\General::dateFormat($result->created_at) }}</div>
                        </div>
                    </div>
                    @include('actions.form_actions', ['back' => true])
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4"></div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
