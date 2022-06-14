@extends('layouts.admin.main')

@section('title', 'Email Report')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Email Report') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Email Report'])
        </div>
    </div>
    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <form action="{{ url()->full() }}" method="get" id="get_data">
                <div class="col-12 col-lg-12 d-md-flex">
                    @csrf
                    <div class="input-group me-2 me-lg-3 fmxw-200">
                        <span class="input-group-text">@include('icons.search')</span>
                        <input type="text" name="q" id="q" class="form-control" placeholder="Search in report"
                               autocomplete="off">
                    </div>
                    <select class="form-select me-2 me-lg-3 fmxw-200" name="domain" id="domain">
                        <option value="all">All domains</option>
                        @foreach($domains as $key => $domain)
                            <option value="{{ $domain['id'] }}">{{ $domain['name'] }}</option>
                        @endforeach
                    </select>
                    <div class="input-group me-2 me-lg-3 fmxw-200">
                        <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                        <input data-datepicker="" class="form-control dropdown-toggle" id="from" name="from" type="text"
                               placeholder="From" value="{{ \Carbon\Carbon::today()->subDays(7)->format('m/d/Y') }}">
                    </div>
                    <div class="input-group me-2 me-lg-3 fmxw-200">
                        <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                        <input data-datepicker="" class="form-control dropdown-toggle" id="to" name="to" type="text"
                               placeholder="To" value="{{ \Carbon\Carbon::today()->format('m/d/Y') }}">
                    </div>
                    <input type="hidden" name="page" id="page" class="form-control">
                    <div class="input-group me-2 me-lg-3 fmxw-300">
                        <button class="btn btn-sm px-3 btn-primary btn-search-report">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button class="btn btn-outline-gray-500 px-3 btn-reset-report">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
            <div class="col-3 col-lg-4 d-flex justify-content-end"></div>
        </div>
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

        $(document).ready(function () {
            $('form#get_data').submit();
        });

        $(document).on('click', '.btn-search-report', function (event) {
            event.preventDefault();
            get_data_ajax();
        });

        $(document).on('click', '.btn-reset-report', function (event) {
            event.preventDefault();
            $('form#get_data').trigger("reset");
            get_data_ajax();
        });

    </script>

@endsection
