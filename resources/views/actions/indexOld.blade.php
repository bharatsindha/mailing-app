<div class="btn-group">
    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        @include('icons.action-toggle')
    </button>
    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1" style="">
        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.'.$module.'.edit', $id) }}">
            @include('icons.edit')
            Edit
        </a>
        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.'.$module.'.show', $id) }}">
            @include('icons.view')
            View Details
        </a>
        <div role="separator" class="dropdown-divider my-1"></div>

        <form method="post" class=""
              action="{{ route('admin.'.$module.'.destroy', $id) }}">
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit" class="dropdown-item d-flex align-items-center">
                @include('icons.delete')
                Remove
            </button>
        </form>
    </div>
</div>
