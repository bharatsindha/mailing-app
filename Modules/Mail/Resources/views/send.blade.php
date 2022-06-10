@extends('layouts.admin.main')

@section('title', 'Sending Mail')

@section('stylesheets')
    @parent
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Sending Mail') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Sending Mail'])
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card card-body border-0 shadow mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Domain: </strong>
                        {{$session->domain->name}}
                    </div>
                    <div class="col-md-5">
                        <strong>Sender Email: </strong>
                        ({{$session->email->sender_name}}) {{ $session->email->sender_email }}
                    </div>
                    <div class="col-md-2">
                        <strong>Total Email: </strong>{{ $session->total_emails }}
                    </div>
                    <div class="col-md-2">
                        <strong>Total Sent: </strong>
                        <label id="totalSent">0</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Subject: </strong>{{ $session->subject }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ajax-content">
                <table class="table table-hover" id="mailingTable">
                    <tr>
                        <th>{{ __('#') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Company') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <input type="hidden" name="sessionId" value="{{ $session->id }}" id="sessionId">
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            getEmail();
        });

        let qTotalSent = $('#totalSent');
        let qMailingTableRow = $('#mailingTable tr');
        let sessionId = $("#sessionId").val();
        let domainId = "{{ $session->domain_id }}";

        let getEmailUrl = "{{ route('admin.mail.getEmail', 'SESSION_ID') }}";
        let sendEmailUrl = "{{ route('admin.mail.sendEmail', 'SESSION_ID') }}";
        getEmailUrl = getEmailUrl.replace('SESSION_ID', sessionId);
        sendEmailUrl = sendEmailUrl.replace('SESSION_ID', sessionId);

        /**
         * Get Email
         */
        function getEmail() {
            $.ajax({
                type: "POST",
                url: getEmailUrl,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    if (response.status !== 'completed') {

                        let totalSent = parseInt($('#mailingTable tr').last().index(), 10);
                        totalSent = totalSent + 1;

                        $('#mailingTable tr').last().after('<tr>' +
                            '<td>' + totalSent + '</td>' +
                            '<td>' + response.session.composes_pending.to + '</td>' +
                            '<td>' + response.session.composes_pending.company_name + '</td>' +
                            '<td><img id="loading-image" src="{{ asset('img/ajax-loader.gif')}}" style=""/></td>' +
                            '</tr>');

                        // let rand = Math.round(Math.random() * (120000 - 60000)) + 60000;
                        let rand = Math.round(Math.random() * (12000 - 6000)) + 6000;
                        setTimeout(function () {
                            loadData();
                        }, rand);
                    }
                },
                error: function () {
                }
            });
        }

        /**
         * Send Email
         */
        function loadData() {
            $.ajax({
                type: "POST",
                url: sendEmailUrl,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'notConnected') {
                        setCookie("tempDomainId", domainId, 1);
                        PopupCenterDual('{{ route('admin.mail.reConnect') }}', 'GMail login page', '450', '450');

                        setTimeout(function () {
                            $('#mailingTable tr').last().remove();
                            getEmail();
                        }, 30000);

                    } else {
                        if (response.status !== 'completed') {
                            let totalSent = parseInt(qTotalSent.text(), 10);
                            totalSent = totalSent + 1;
                            qTotalSent.html(totalSent);

                            $('#mailingTable tr').last().remove();
                            let img = "{{ asset('img/AquaBallGreen.png') }}";
                            $('#mailingTable tr').last().after('<tr>' +
                                '<td>' + totalSent + '</td>' +
                                '<td>' + response.session.composes_pending.to + '</td>' +
                                '<td>' + response.session.composes_pending.company_name + '</td>' +
                                '<td>Mail Sent <img src="' + img + '" style="height: 10px; padding-left: 5px;" alt=""/></td>' +
                                '</tr>');

                            getEmail();
                        }
                    }
                },
                error: function () {
                    let rand = Math.round(Math.random() * (90000 - 30000)) + 30000;
                    setTimeout(function () {
                        loadData();
                    }, rand);
                }
            });
        }

        /**
         * Open popup to re-connect to GMail
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
            width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ?
                document.documentElement.clientWidth : screen.width;
            height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ?
                document.documentElement.clientHeight : screen.height;

            let left = ((width / 2) - (w / 2)) + dualScreenLeft;
            let top = ((height / 2) - (h / 2)) + dualScreenTop;
            let newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            if (newWindow == null || typeof (newWindow) == 'undefined') {
                alert("Popup Blocker is enabled! Please add this site to your exception list.");
            } else {
                if (window.focus) {
                    newWindow.focus();
                }
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
         * Get Cookie
         *
         * @param cookieName
         * @returns {string}
         */
        function getCookie(cookieName) {
            let name = cookieName + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) === 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>
@endsection
