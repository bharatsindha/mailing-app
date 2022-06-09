@extends('layouts.admin.main')

@section('title', 'Compose')

@section('stylesheets')
    @parent
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">{{ __('Compose') }}</h2>
            @include('layouts.admin.breadcrumb', ['module' => 'Compose'])
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card card-body border-0 shadow mb-4">
                <form method="POST" action="{{ route('admin.compose.store') }}" id="composeForm"
                      enctype="multipart/form-data">
                    @csrf
                    @include('mail::form')
                    @include('actions.form_actions', ['send' => true])
                </form>
            </div>
        </div>
        <div class="col-12 col-xl-4"></div>
    </div>
@endsection

@section('scripts')
    @parent

    <script src="{{ asset('admin_template/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
    <script>

        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('mail_content');

        let attachments = [];

        let myDropzone = new Dropzone("div#dAttachment", {
            url: "{{ route('admin.compose.uploadAttachment') }}",
            addRemoveLinks: true,
            maxFilesize: 10,
            // dictDefaultMessage: '<span class="text-center">' +
            //     '<span class="font-lg visible-xs-block visible-sm-block visible-lg-block">' +
            //     '<span class="font-lg">' +
            //     '<i class="fa fa-caret-right text-danger"></i> Drop files ' +
            //     '<span class="font-xs">to upload</span>' +
            //     '</span>' +
            //     '<span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4>' +
            //     '</span>',
            // dictResponseError: 'Error uploading file!',
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
                    url: '{{ route('admin.compose.removeAttachment') }}',
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
