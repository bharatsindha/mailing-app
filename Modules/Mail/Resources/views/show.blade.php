@extends('layouts.admin.main')
@section('title', 'Drafts')
@section('stylesheets')
    @parent
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Draft Details') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Drafts'])
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">{{ __('Draft information') }}</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">{{ __('Domain Name') }}</label>
                        <div class="small text-gray">{{ $session->domain->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name">{{ __('Sender Email') }}</label>
                        <div class="small text-gray">{{ $session->email->sender_email }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">{{ __('Subject') }}</label>
                        <div class="small text-gray">{{ $session->subject }}</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="name">{{ __('Mail Content') }}</label>
                        <div class="small text-gray">
                            <code
                                style="background-color: #eee;display: block;padding: 20px; color: inherit">
                                {!! $session->mail_content !!}
                            </code>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name">{{ __('Created At') }}</label>
                        <div class="small text-gray">{{ \App\Facades\General::dateFormat($session->created_at) }}</div>
                    </div>
                </div>
                @include('actions.form_actions', ['back' => true])
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card card-body border-0 shadow mb-4">
                <div class="row">
                    <h2 class="h5 mb-4">{{ __('Draft Status') }}</h2>
                    <div class="col-md-12 mb-3">
                        <div class="small text-gray">
                            <span
                                class="badge badge-lg bg-{{ \App\Facades\General::getDraftBadgeClass($session->is_completed) }}">
                                {{ \App\Facades\General::getDraftStatus($session->is_completed) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">{{ __('Email information') }}</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">{{ __('Total Emails') }}</label>
                        <div class="small text-gray">{{ $session->total_emails }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name">{{ __('Total Sent') }}</label>
                        <div class="small text-gray">{{ $session->total_sent }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name">{{ __('Total Opened') }}</label>
                        <div class="small text-gray">{{ $session->total_opened }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name">{{ __('Total Bounced') }}</label>
                        <div class="small text-gray">{{ $session->total_bounced }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
