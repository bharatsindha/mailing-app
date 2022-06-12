@extends('layouts.admin.main')

@section('title', 'Bounce Track')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Bounce Track') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Bounce Track'])
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
                        <input type="text" name="q" id="q" class="form-control" placeholder="Search Email"
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
    <input type="hidden" name="currentEmailId" id="currentEmailId" value="">
    <input type="hidden" name="currentSenderEmail" id="currentSenderEmail" value="">
    <input type="hidden" name="currentDomainId" id="currentDomainId" value="">
    <input type="hidden" name="connectionType" id="connectionType" value="bounce track">
    <div class="ajax-content"></div>
@endsection

@section('scripts')
    @parent

    <script>

        function startBounceTracking() {

            console.log("started bounce tracking");

            let emailId = $("#currentEmailId").val();
            let currentSenderEmail = $("#currentSenderEmail").val();

            if (emailId > 0) {
                let bounceTrackUrl = "{{ route('admin.mail.bounceTracking', 'EMAIL_ID') }}";
                bounceTrackUrl = bounceTrackUrl.replace('EMAIL_ID', emailId);

                $.ajax({
                    type: "POST",
                    url: bounceTrackUrl,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // console.log(response, "response")
                        if (response.status === 'notConnected') {
                            let domainId = $("#currentDomainId").val();
                            syncGMailConnection(domainId);
                        } else {
                            notyf.open({
                                type: 'success',
                                message: 'Bounce tracked successfully for the email ' + currentSenderEmail
                            });
                        }
                    },
                    error: function () {
                        notyf.open({
                            type: 'danger',
                            message: 'Something went wrong. Please try later.'
                        });
                    }
                });

            } else {
                notyf.open({
                    type: 'danger',
                    message: 'System could not recognize email. Please try later.'
                });
            }
        }

        /**
         * Set cookie
         *
         * @param cookieName
         * @param cookieValue
         * @param expireDays
         */
        function setCookie(cookieName, cookieValue, expireDays) {
            let d = new Date();
            d.setTime(d.getTime() + (expireDays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
        }

        /**
         * Check connection with GMail
         *
         * @param emailId
         * @param senderEmail
         * @param domainId
         */
        function checkGMail(emailId, senderEmail, domainId) {
            $("#currentEmailId").val(emailId);
            $("#currentSenderEmail").val(senderEmail);
            $("#currentDomainId").val(domainId);

            syncGMailConnection(domainId);
        }

        /**
         * Connect to GMail
         *
         **/
        function syncGMailConnection(domainId) {
            setCookie("tempDomainId", domainId, 1);
            PopupCenterDual("{{ route('admin.mail.connection') }}", 'GMail login page', '450', '450');
        }

        /**
         * Open popup to connect to GMail
         *
         * @param url
         * @param title
         * @param w
         * @param h
         * @constructor
         */
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
