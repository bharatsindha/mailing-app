<div class="btn-group">
    <a class="d-flex align-items-center" href="{{ route('admin.'.$module.'.edit', $id) }}">
        <span class="text-gray-400 me-2 action-icon-hover"><i class="fa-solid fa-pen-to-square"></i></span>
    </a>
    <a class="d-flex align-items-center" href="{{ route('admin.'.$module.'.show', $id) }}">
        <span class="text-gray-400 me-2 action-icon-hover"><i class="fa-solid fa-eye"></i></span>
    </a>
    <div role="separator" class="dropdown-divider my-1"></div>
    <form method="post" class=""
          action="{{ route('admin.'.$module.'.destroy', $id) }}">
        @csrf
        <input name="_method" type="hidden" value="DELETE">
        <button type="submit" class="d-flex align-items-center border-0 bg-transparent p-0">
            <span class="text-gray-400 me-2 action-icon-hover"><i class="fa-solid fa-trash-can"></i></span>
        </button>
    </form>
</div>


