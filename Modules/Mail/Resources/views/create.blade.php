@extends('layouts.admin.main')

@section('title', 'Drafts')

@section('stylesheets')
    @parent
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css"/>
    <style>
        .dropzone {
            border: 2px dotted #6B7280;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Drafts') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Drafts'])
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            @foreach($errors->getMessages() as $eKey => $eMessage)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $eMessage[0] }}
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow mb-4">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Draft Information') }}</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.drafts.store') }}" id="composeForm"
                          enctype="multipart/form-data">
                        @csrf
                        @include('mail::form')
                        @include('actions.form_actions', ['save' => true, 'cancel' => true])
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card border-0 shadow">
                <div class="card-header d-flex align-items-center">
                    <h2 class="fs-5 fw-bold mb-0">{{ __('Dynamic Variables') }}</h2>
                </div>
                <div class="card-body">
                    <p>Please use these variables in subject or mail content to replace the receiver details
                        dynamic.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('First Name') }}</label>
                            <div class="small text-gray"><code>@{{firstName}}</code></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('Last Name') }}</label>
                            <div class="small text-gray"><code>@{{lastName}}</code></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('Company Name') }}</label>
                            <div class="small text-gray"><code>@{{company}}</code></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('Designation') }}</label>
                            <div class="small text-gray"><code>@{{designation}}</code></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">{{ __('Project Name') }}</label>
                            <div class="small text-gray"><code>@{{project}}</code></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('admin_template/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <script>

        // instance, using default configuration.
        CKEDITOR.replace('mail_content');

        let attachments = [];

        let myDropzone = new Dropzone("div#dAttachment", {
            url: "{{ route('admin.draft.uploadAttachment') }}",
            addRemoveLinks: true,
            maxFilesize: 5,
            // dictDefaultMessage: 'Drop or click here to upload files. Max file size allowed',
            dictDefaultMessage: '<div class="d-flex align-items-center"><span><i class="fa fa-file-circle-plus" style="width: 30px;height: 30px;"></i></span>' +
                '<span style="display: inline-block; vertical-align: middle;padding-left: 5px;">' +
                'Drop Files to upload or CLICK <br>' +
                '<small style="font-size: 10px; display: block;text-align: left;">' +
                '<strong>Maximum 5MB file size allowed</strong></small></span></div>',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            removedfile: function (file) {

                let fileIndex = attachments.findIndex((attachment) => {
                    return (attachment.filename_origin.trim() === file.upload.filename.trim())
                });

                let fileData = attachments[fileIndex];

                attachments.splice(fileIndex, 1);

                syncAttachmentWithForm();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.draft.removeAttachment') }}',
                    data: {"_token": "{{ csrf_token() }}", fileData},
                    success: function (data) {
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
                let fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function (file, response) {
                attachments.push(response);
                syncAttachmentWithForm();
            },
        });

        /**
         * Sync the attachment into form
         **/
        function syncAttachmentWithForm() {
            $("input[type='hidden'][name='attachments[]']").remove();
            let $element = $("#composeForm");
            $.each(attachments, function (key, attachment) {
                let inputEl = document.createElement("input");
                inputEl.setAttribute("type", "hidden");
                inputEl.setAttribute("name", "attachments[]");
                inputEl.setAttribute("value", JSON.stringify(attachment));
                //append to form element that you want .
                $element.append(inputEl);
            })
        }

        /**
         * On changing the domain, append the sender emails of the domain
         **/
        $(document).on('change', ".on-change-domain", function (event) {
            if (event.target.value && event.target.value > 0) {
                $.ajax({
                    url: '{{ route('admin.emails.gsebd') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'get',
                    data: {
                        domainId: event.target.value
                    },
                    success: function (data) {
                        if (!data.senderEmails?.length) {
                            notyf.open({
                                type: 'danger',
                                message: 'Sender email is not yet added for this domain.'
                            });
                        }

                        let $element = initializeEmailOption();

                        if (data.senderEmails) {
                            $.each(data.senderEmails, function (key, email) {
                                // Create the DOM option
                                let text = email.sender_email + ' (' + email.sender_name + ')';
                                let option = new Option(text, email.id, false, false);
                                // Append it to the select
                                $element.append(option);
                            })
                        }
                    },
                    error: function (jqXHR, exception) {
                        notyf.open({type: 'danger', message: jqXHR.responseJSON ?? jqXHR.statusText});
                    }
                });
            } else {
                initializeEmailOption();
            }
        });

        /**
         * Initialize the email option
         *
         * @returns {void | * | jQuery | HTMLElement}
         */
        function initializeEmailOption() {
            let $element = $("#email_id").empty();
            $element.append(
                new Option("{{ __('Select Sender Email') }}", '', true, true)
            );

            return $element;
        }
    </script>
@endsection
