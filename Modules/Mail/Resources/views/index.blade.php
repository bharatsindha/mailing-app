@extends('layouts.admin.main')

@section('title', 'Drafts')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Drafts') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Drafts'])
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.drafts.create') }}"
               class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                @include('icons.add')
                {{ __('New Draft') }}</a>
        </div>
    </div>
    <div class="table-settings mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-9 col-lg-8 d-md-flex">
                <form action="{{ url()->full() }}" method="get" id="get_data">
                    @csrf
                    <div class="input-group me-2 me-lg-3 fmxw-300">
                    <span class="input-group-text">
                        @include('icons.search')
                    </span>
                        <input type="text" name="q" id="q" class="form-control" placeholder="Search Drafts"
                               autocomplete="off">
                    </div>
                    <div class="input-group">
                        <input type="hidden" name="page" id="page" class="form-control">
                    </div>
                </form>
            </div>
            <div class="col-3 col-lg-4 d-flex justify-content-end"></div>
        </div>
    </div>
    <input type="hidden" name="current_session_id" id="current_session_id" value="">
    <input type="hidden" name="current_sender_email" id="current_sender_email" value="">
    <div class="ajax-content"></div>
@endsection

@section('scripts')
    @parent
    <script>
        function checkGmail(session_id, sender_email) {
            $("#current_session_id").val(session_id);
            $("#current_sender_email").val(sender_email);
            PopupCenterDual("{{ route('gmail.connection') }}", 'Gmail login page', '450', '450');
        }

        function PopupCenterDual(url, title, w, h) {
            // Fixes dual-screen position Most browsers Firefox
            let dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
            let dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;
            let width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ?
                document.documentElement.clientWidth : screen.width;
            let height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ?
                document.documentElement.clientHeight : screen.height;

            let left = ((width / 2) - (w / 2)) + dualScreenLeft;
            let top = ((height / 2) - (h / 2)) + dualScreenTop;
            let newWindow = window.open(url, title,
                'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            if (newWindow == null || typeof (newWindow) == 'undefined') {
                alert("Popup Blocker is not enabled! Please add this site to your exception list.");
            } else {
                if (window.focus) {
                    newWindow.focus();
                }
            }
        }
    </script>

    <script>
        function get_data_ajax() {
            let form = $('form#get_data');

            console.log("working here");
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

        let typingTimer;

        $('#q').keyup(function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                $('#page').val('1');
                get_data_ajax();
            }, 1000);
        });

    </script>

@endsection
