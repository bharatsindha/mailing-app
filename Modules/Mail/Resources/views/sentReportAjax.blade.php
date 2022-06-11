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
                        <th class="border-0">{{ __('Subject') }}</th>
                        <th class="border-0">{{ __('Emails') }}</th>
                        <th class="border-0">{{ __('Sent') }}</th>
                        <th class="border-0">{{ __('Opened') }}</th>
                        <th class="border-0">{{ __('Bounced') }}</th>
                        <th class="border-0">{{ __('Created At') }}</th>
                        <th class="border-0 rounded-end text-end">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td><span class="font-weight-bold">{{ $result->id }}</span></td>
                            <td>
                                <a href="{{ route('admin.domains.show', $result->domain_id) }}">
                                    <span>{{ $result->name }}</span>
                                </a>
                            </td>
                            <td><span>{{ $result->sender_email }}</span></td>
                            <td>
                                <span>{{ strlen($result->subject) > 40 ? substr($result->subject, 0, 40) . '...' : $result->subject }}</span>
                            </td>
                            <td><span>{{ $result->total_emails }}</span></td>
                            <td><span>{{ $result->total_sent }}</span></td>
                            <td><span>{{ $result->composesOpened()->count() }}</span></td>
                            <td><span>{{ $result->composesBounced()->count() }}</span></td>
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
