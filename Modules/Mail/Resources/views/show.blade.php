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
        @include('actions.form_actions', ['back' => true])
    </div>
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Draft Details') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Domain Name') }}</label>
                            <div class="small text-gray">
                                <span class="form-field-view2">{{ $session->domain->name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Sender Email') }}</label>
                            <div class="small text-gray">
                                <span class="form-field-view2">
                                {{ $session->email->sender_name .'<' .$session->email->sender_email . '>' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="name">{{ __('Subject') }}</label>
                            <div class="small text-gray">
                                <span class="form-field-view2">{{ $session->subject }}</span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="name">{{ __('Mail Content') }}</label>
                            <div class="small text-gray">
                                <span class="mail-content-view">
                                    {!! $session->mail_content !!}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Created At') }}</label>
                            <div class="small text-gray">
                                <span class="form-field-view2">
                                    {{ \App\Facades\General::dateFormat($session->created_at) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Status') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="small text-gray">
                            <span
                                class="badge badge-lg fs-827 bg-{{ \App\Facades\General::getDraftBadgeClass($session->is_completed) }}">
                                {{ \App\Facades\General::getDraftStatus($session->is_completed) }}
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Email Details') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Total Emails') }}</label>
                            <div class="small text-gray">
                                <span class="text-primary">{{ $session->total_emails }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Total Sent') }}</label>
                            <div class="small text-gray">
                                <span class="text-success">{{ $session->total_sent }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Total Opened') }}</label>
                            <div class="small text-gray">
                                <span class="text-success">{{ $session->composesOpened()->count() }}</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="name">{{ __('Total Bounced') }}</label>
                            <div class="small text-gray">
                                <span class="text-danger">{{ $session->composesBounced()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Attachments') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <ul class="list-group list-group-flush">
                                @if($session->attachments()->count())
                                    @foreach($session->attachments as $key => $attachment)
                                        <li class="list-group-item bg-transparent border-bottom py-3 px-0">
                                            <div class="row align-items-center m-0">
                                                <div class="col-auto px-0">
                                                    <span class="small">{{ $attachment->filename }}</span>
                                                </div>
                                                <div class="col text-end">
                                                    <a href="{{ Storage::url(\Modules\Mail\Entities\Attachment::ATTACHMENT_PATH.
                                                            DIRECTORY_SEPARATOR.$attachment->filename) }}"
                                                       target="_blank">
                                                        <span class="fs-6 fw-bolder text-dark">
                                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item bg-transparent border-bottom py-3 px-0">
                                        <div class="row align-items-center m-0">
                                            <div class="col-auto px-0">
                                                <span class="small">Not Found!</span>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Receiver Details') }}</h2>
                </div>
                <div class="card-body">
                    @include('mail::composeReport', ['results' => $session->composes])
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @parent
    <script>


    </script>
@endsection
