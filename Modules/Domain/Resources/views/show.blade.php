@extends('layouts.admin.main')
@section('title', 'Domains')
@section('stylesheets')
    @parent
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('View Domain') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Domains'])
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Domain Details') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('Domain Name') }}</label>
                            <div class="small text-gray">{{ $result->name }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('Domain Url') }}</label>
                            <div class="small text-gray">{{ $result->url }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name">{{ __('Gmail client ID') }}</label>
                            <div class="small text-gray"><code>{{ ucfirst($result->client_id) }}</code></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="name">{{ __('Gmail client secret') }}</label>
                            <div class="small text-gray"><code>{{ ucfirst($result->client_secret) }}</code></div>
                        </div>
                        <div class="col-md-6 mb-3">
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
