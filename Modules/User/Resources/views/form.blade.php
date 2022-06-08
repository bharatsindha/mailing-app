<div class="row">
    <div class="col-md-6 mb-3">
        <div>
            <label for="name">{{ __('Name') }}</label>
            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" type="text"
                   name="name"
                   value="{{ isset($result) && !is_null($result->name) ? $result->name :  old('name') }}"
                   placeholder="{{ __('Enter your name') }}" required="">
            @if($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div>
            <label for="email">{{ __('Email') }}</label>
            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" type="email"
                   placeholder="{{ __('Enter your email') }}"
                   name="email"
                   value="{{ isset($result) && !is_null($result->email) ? $result->email :  old('email') }}"
                   required="" autocomplete="off">
            @if($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <div>
            <label for="password">{{ __('Password') }}</label>
            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" type="password"
                   name="password"
                   placeholder="{{ __('Enter your password') }}" {{ !isset($result) ? 'required' : '' }} >
            @if($errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div>
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                   id="password_confirmation" type="password"
                   name="password_confirmation"
                   placeholder="{{ __('Enter your confirm password') }}"
                {{ !isset($result) ? 'required' : '' }} >
            @if($errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>
    </div>
</div>
<div class="row align-items-center">
    <div class="col-md-6 mb-3">
        <label for="role">{{ __('Role') }}</label>
        <select class="form-select mb-0 {{ $errors->has('role') ? 'is-invalid' : '' }}" id="role"
                aria-label="Gender select example" name="role"
                required>
            <option value="" selected="selected">{{ __('Select your role') }}</option>
            @foreach($roles as $key => $role)
                <option value="{{ $key }}"
                    {{ ((isset($result->role) && $result->role === $key) ||
                        ((old('role') == $key))) ? 'selected' : '' }}>
                    {{ $role }}
                </option>
            @endforeach
        </select>
        @if($errors->has('role'))
            <div class="invalid-feedback">{{ $errors->first('role') }}</div>
        @endif
    </div>
</div>
