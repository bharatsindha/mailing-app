<div class="mt-3 text-end">
    @if(isset($cancel) && $cancel)
        <a class="btn btn-outline-gray-500 animate-up-2" href="{{ url()->previous() }}">{{ __('Cancel') }}</a>
    @endif
    @if(isset($back) && $back)
        <a class="btn btn-outline-gray-500 animate-up-2" href="{{ url()->previous() }}">{{ __('Back') }}</a>
    @endif
    @if(isset($save) && $save)
        <button class="btn btn-secondary animate-up-2" type="submit">{{ __('Save') }}</button>
    @endif
    @if(isset($update) && $update)
        <button class="btn btn-secondary animate-up-2" type="submit">{{ __('Update') }}</button>
    @endif
</div>
