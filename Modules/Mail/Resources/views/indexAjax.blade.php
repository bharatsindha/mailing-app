@if (count($results) > 0)
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded" style="min-height: 25vh;">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">{{ __('#') }}</th>
                        <th class="border-0">{{ __('Domain') }}</th>
                        <th class="border-0">{{ __('Sender Email') }}</th>
                        <th class="border-0">{{ __('Subject') }}</th>
                        <th class="border-0">{{ __('Total Emails') }}</th>
                        <th class="border-0">{{ __('Created At') }}</th>
                        <th class="border-0 rounded-end text-end">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td><span class="font-weight-bold">{{ $result->id }}</span></td>
                            <td><span>{{ $result->name }}</span></td>
                            <td><span>{{ $result->sender_name .'<' .$result->sender_email .'>' }}</span></td>
                            <td>
                                <span>{{ strlen($result->subject) > 60 ? substr($result->subject, 0, 60) . '...' : $result->subject }}</span>
                            </td>
                            <td><span>{{ $result->total_emails }}</span></td>
                            <td>
                                <span>
                                    {{ !is_null($result->created_at) ? $result->created_at->diffForHumans() : '' }}
                                </span>
                            </td>
                            <td>
                                <div class="text-end">
                                    <div class="btn-group">
                                        <button
                                            class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            @include('icons.action-toggle')
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1"
                                             style="">
                                            <a class="dropdown-item d-flex align-items-center"
                                               href="{{ route('admin.drafts.show', $result->id) }}">
                                                @include('icons.view')
                                                View Draft
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center"
                                               onclick="checkGmail('{{ $result->id }}', '{{ $result->sender_email }}', '{{ $result->domain_id }}');">
                                                <span class="dropdown-icon text-gray-400 me-2">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                </span>
                                                Start Email
                                            </a>
                                            <div role="separator" class="dropdown-divider my-1"></div>
                                            <form method="post" class=""
                                                  action="{{ route('admin.drafts.destroy', $result->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                                    @include('icons.delete')
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div
                    class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                    <div class="pagination-block text-center">
                        {{ $results->links('pagination.bootstrap-5') }}
                    </div>
                </div>
        </div>
    </div>
</div>
@else
    @include('notFound.searchNotFound', ['message' => "We're sorry what you were looking for. Please add new draft."])
@endif
