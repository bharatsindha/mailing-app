@extends('layouts.admin.main')

@section('title', 'Email Sent Details')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Email Sent Details') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Email Sent Details'])
        </div>
    </div>
    <div class="table-settings mb-4">
        <form action="{{ url()->full() }}" method="get" id="get_data">
            <div class="row justify-content-between align-items-center">
                <div class="col-9 col-lg-8 d-md-flex">
                    @csrf
                    <div class="input-group me-2 me-lg-3 fmxw-200">
                        <span class="input-group-text">@include('icons.search')</span>
                        <input type="text" name="q" id="q" class="form-control" placeholder="Search..."
                               autocomplete="off">
                    </div>
                    <div class="form-check me-2 me-lg-3 fmxw-200 mr-3">
                        Status:
                    </div>
                    <div class="form-check me-2 me-lg-3 fmxw-200">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="all" checked>
                        <label class="form-check-label" for="status1">All</label>
                    </div>
                    <div class="form-check me-2 me-lg-3 fmxw-200">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="sent">
                        <label class="form-check-label" for="status2">Sent</label>
                    </div>
                    <div class="form-check me-2 me-lg-3 fmxw-200">
                        <input class="form-check-input" type="radio" name="status" id="status3" value="opened">
                        <label class="form-check-label" for="status3">Opened</label>
                    </div>
                    <div class="form-check me-2 me-lg-3 fmxw-200">
                        <input class="form-check-input" type="radio" name="status" id="status4" value="bounced">
                        <label class="form-check-label" for="status4">Bounced</label>
                    </div>
                    <input type="hidden" name="page" id="page" class="form-control">
                </div>
                <div class="col-3 col-lg-4 d-flex justify-content-end">
                    <div class="mt-3 text-end">
                        <a class="btn btn-secondary d-inline-flex align-items-center me-2"
                           href="{{ route('admin.drafts.show', $sessionId)  }}">
                            <i class="fa-solid fa-eye mr-2"></i> {{ __('View Draft Details') }}
                        </a>
                        <a class="btn btn-outline-gray-500" href="{{ url()->previous() }}">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="ajax-content"></div>
@endsection

@section('scripts')
    @parent
    <script>
        function get_data_ajax() {
            let form = $('form#get_data');

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: $('form#get_data').serialize(),
                success: function (data) {
                    $('.ajax-content').html(data);
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('Error in fetching data. Please try again.');
                }
            });
        }

        $(document).on('submit', 'form#get_data', function (event) {
            event.preventDefault();
            get_data_ajax();
        });

        $(document).on('click', '.pagination>li>a', function (event) {
            event.preventDefault();
            $('#page').val($(this).text());
            get_data_ajax();
        });

        $(document).on('click', '.form-check-input', function (event) {
            $(this).prop('checked', true);
            // event.preventDefault();
            $('#page').val('1');
            get_data_ajax();
        });

        $(document).ready(function () {
            $('form#get_data').submit();
        });

        $('#q').keyup(function () {
            $('#page').val('1');
            get_data_ajax();
        });
    </script>

@endsection
