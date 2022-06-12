<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            @if (count($results) > 0)
                <table class="table table-centered table-nowrap mb-0 rounded" style="min-height: 25vh;">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">{{ __('#') }}</th>
                        <th class="border-0">{{ __('Domain') }}</th>
                        <th class="border-0">{{ __('Sender Email') }}</th>
                        <th class="border-0">{{ __('Bounce Track Date') }}</th>
                        <th class="border-0 rounded-end text-end">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td><span class="font-weight-bold">{{ $result->id }}</span></td>
                            <td>
                                <span>{{ $result->name }}</span>
                            </td>
                            <td><span>{{ $result->sender_email }}</span></td>
                            <td>
                                <span>{{ \App\Facades\General::datetimeFormat($result->bounce_track_date) }}</span>
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
                                               onclick="checkGMail('{{ $result->id }}','{{ $result->sender_email }}', '{{ $result->domain_id }}');">
                                                <span class="dropdown-icon text-gray-400 me-2">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                </span>
                                                Bounce Track
                                            </a>
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
            @else
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
                    <div class="d-block mb-4 mb-md-0 w-100 text-center">
                        <h4>{{ __('No results found') }}</h4>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
