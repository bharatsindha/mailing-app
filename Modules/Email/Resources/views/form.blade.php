<div class="row align-items-center">
    <div class="col-md-12 mb-3">
        <label for="domain_id">{{ __('Select Domain') }}</label>
        <select class="form-select mb-0 {{ $errors->has('domain_id') ? 'is-invalid' : '' }}" id="domain_id"
                aria-label="Select Domain" name="domain_id"
                required>
            <option value="" selected="selected">{{ __('Select Domain') }}</option>
            @foreach($domains as $key => $domain)
                <option value="{{ $domain['id'] }}"
                    {{ ((isset($result->domain_id) && $result->domain_id === $domain['id']) ||
                        ((old('domain_id') == $domain['id']))) ? 'selected' : '' }}>
                    {{ $domain['name'] . ' <' . $domain['url'] . '>' }}
                </option>
            @endforeach
        </select>
        @if($errors->has('domain_id'))
            <div class="invalid-feedback">{{ $errors->first('domain_id') }}</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div>
            <label for="sender_name">{{ __('Sender Name') }}</label>
            <input class="form-control {{ $errors->has('sender_name') ? 'is-invalid' : '' }}" id="sender_name"
                   type="text"
                   name="sender_name"
                   value="{{ isset($result) && !is_null($result->sender_name) ? $result->sender_name :  old('sender_name') }}"
                   placeholder="{{ __('Enter sender name') }}" required="">
            @if($errors->has('sender_name'))
                <div class="invalid-feedback">{{ $errors->first('sender_name') }}</div>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div>
            <label for="sender_email">{{ __('Sender Email') }}</label>
            <input class="form-control {{ $errors->has('sender_email') ? 'is-invalid' : '' }}" id="sender_email"
                   type="email"
                   placeholder="{{ __('Enter sender email') }}"
                   name="sender_email"
                   value="{{ isset($result) && !is_null($result->sender_email) ? $result->sender_email :  old('sender_email') }}"
                   required="" autocomplete="off">
            @if($errors->has('sender_email'))
                <div class="invalid-feedback">{{ $errors->first('sender_email') }}</div>
            @endif
        </div>
    </div>
</div>


