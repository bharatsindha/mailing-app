<div class="row align-items-center">
    <div class="col-md-12 mb-4">
        <label for="domain_id">{{ __('Select Domain') }}</label>
        <select class="form-select mb-0 {{ $errors->has('domain_id') ? 'is-invalid' : '' }} on-change-domain"
                id="domain_id"
                aria-label="Select Domain" name="domain_id"
                required>
            <option value="" selected="selected">{{ __('Select Domain') }}</option>
            @foreach($domains as $key => $domain)
                <option value="{{ $domain['id'] }}">
                    {{ $domain['name'] . ' (' . $domain['url'] . ')' }}
                </option>
            @endforeach
        </select>
        @if($errors->has('domain_id'))
            <div class="invalid-feedback">{{ $errors->first('domain_id') }}</div>
        @endif
    </div>

    <div class="col-md-12 mb-4">
        <label for="email_id">{{ __('Select Sender Email') }}</label>
        <select class="form-select mb-0 {{ $errors->has('email_id') ? 'is-invalid' : '' }}"
                id="email_id"
                aria-label="Select Sender Email" name="email_id"
                required>
            <option value="" selected="selected">{{ __('Select Email') }}</option>
        </select>
        @if($errors->has('email_id'))
            <div class="invalid-feedback">{{ $errors->first('email_id') }}</div>
        @endif
    </div>

    <div class="col-md-12 mb-4">
        <label for="excelFile">{{ __('Upload excel File') }}</label>
        <small class="form-text text-muted">( Please
            <a href="{{ asset('img/sample-excel-sheet-format.png') }}" target="_blank"><b>click here</b></a>
            to see the sample of excel sheet format. It should be ".xls" or ".xlsx".)</small>
        <input class="form-control {{ $errors->has('excelFile') ? 'is-invalid' : '' }}" type="file" id="excelFile"
               name="excelFile"
               accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
               required>
        @if($errors->has('excelFile'))
            <div class="invalid-feedback">{{ $errors->first('excelFile') }}</div>
        @endif
    </div>

    <div class="col-md-12 mb-4">
        <div>
            <label for="subject">{{ __('Subject') }}</label>
            <input class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" id="subject"
                   type="text"
                   name="subject"
                   value="{{ old('subject') }}"
                   placeholder="{{ __('Subject Line') }}" required="">
            @if($errors->has('subject'))
                <div class="invalid-feedback">{{ $errors->first('subject') }}</div>
            @endif
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div>
            <label for="mail_content">{{ __('Mail Content') }}</label>
            <textarea class="form-control {{ $errors->has('mail_content') ? 'is-invalid' : '' }}"
                      id="mail_content" name="mail_content"
                      placeholder="{{ __('Mail Content') }}"
                      rows="5" required>{{ old('content') }}</textarea>
            @if($errors->has('mail_content'))
                <div class="invalid-feedback">{{ $errors->first('mail_content') }}</div>
            @endif
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <label for="attachment">{{ __('Attachment') }}</label>
        <div id="dAttachment" class="fallback dropzone"></div>
    </div>
</div>
