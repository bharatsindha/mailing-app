@extends('layouts.admin.main')
@section('title', 'View Sender Email')
@section('stylesheets')
    @parent
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('View Sender Email') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Sender Emails'])
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Sender Email Details') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Domain Name') }}</label>
                            <div class="small text-gray">{{ $result->domain->name }}</div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Created At') }}</label>
                            <div
                                class="small text-gray">{{ \App\Facades\General::dateFormat($result->created_at) }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('Sender Name') }}</label>
                            <div class="small text-gray">{{ ucfirst($result->sender_name) }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('Sender Email') }}</label>
                            <div class="small text-gray">{{ ucfirst($result->sender_email) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @include('actions.form_actions', ['back' => true])
        </div>
        <div class="col-12 col-xl-4"></div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
