<div class="row">
    <div class="col-md-6 mb-3">
        <div>
            <label for="name">{{ __('Name') }}</label>
            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" type="text"
                   name="name"
                   value="{{ isset($result) && !is_null($result->name) ? $result->name :  old('name') }}"
                   placeholder="{{ __('Enter domain name') }}" required="">
            @if($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div>
            <label for="url">{{ __('URL (example: domain.com)') }}</label>
            <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" id="url" type="text"
                   placeholder="{{ __('Enter domain url') }}"
                   name="url"
                   value="{{ isset($result) && !is_null($result->url) ? $result->url :  old('url') }}"
                   required="" autocomplete="off">
            @if($errors->has('url'))
                <div class="invalid-feedback">{{ $errors->first('url') }}</div>
            @endif
        </div>
    </div>
</div>

<h2 class="h5 mb-4 mt-3">{{ __('Gmail API Configuration: ') }}</h2>

@include('domain::gmailInfo')

<div class="row">
    <div class="col-md-12 mb-3">
        <div>
            <label for="client_id">{{ __('Gmail Client ID') }}</label>
            <input class="form-control {{ $errors->has('client_id') ? 'is-invalid' : '' }}" id="client_id" type="text"
                   name="client_id"
                   value="{{ isset($result) && !is_null($result->client_id) ? $result->client_id :  old('client_id') }}"
                   placeholder="{{ __('Enter Gmail client ID') }}" required="">
            @if($errors->has('client_id'))
                <div class="invalid-feedback">{{ $errors->first('client_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div>
            <label for="client_secret">{{ __('Gmail Client Secret') }}</label>
            <input class="form-control {{ $errors->has('client_secret') ? 'is-invalid' : '' }}" id="client_secret"
                   type="text"
                   placeholder="{{ __('Enter Gmail client secret') }}"
                   name="client_secret"
                   value="{{ isset($result) && !is_null($result->client_secret) ? $result->client_secret :  old('client_secret') }}"
                   required="" autocomplete="off">
            @if($errors->has('client_secret'))
                <div class="invalid-feedback">{{ $errors->first('client_secret') }}</div>
            @endif
        </div>
    </div>
</div>

