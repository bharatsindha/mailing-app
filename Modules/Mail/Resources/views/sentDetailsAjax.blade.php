@if (count($results) > 0)
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">{{ __('#') }}</th>
                        <th class="border-0">{{ __('Name') }}</th>
                        <th class="border-0">{{ __('To') }}</th>
                        <th class="border-0">{{ __('Cc') }}</th>
                        <th class="border-0">{{ __('Bcc') }}</th>
                        <th class="border-0">{{ __('Company') }}</th>
                        <th class="border-0">{{ __('Designation') }}</th>
                        <th class="border-0">{{ __('Project') }}</th>
                        <th class="border-0">{{ __('Sent At') }}</th>
                        <th class="border-0 rounded-end text-end">{{ __('Status') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $key => $result)
                        <tr>
                            <td><span class="font-weight-bold">{{ $key + 1 }}</span></td>
                            <td><span>{{ $result->first_name .' '. $result->last_name }}</span></td>
                            <td><span>{{ $result->to }}</span></td>
                            <td><span>{{ $result->cc }}</span></td>
                            <td><span>{{ $result->bcc }}</span></td>
                            <td><span>{{ $result->company_name }}</span></td>
                            <td><span>{{ $result->designation }}</span></td>
                            <td><span>{{ $result->project_name }}</span></td>
                            <td><span>{{ \App\Facades\General::datetimeFormat($result->send_date) }}</span>
                            </td>
                            <td>
                                <div class="text-end">
                                    <span
                                        class="badge bg-{{ \App\Facades\General::getComposeBadgeClass($result->status) }}">
                                        {{ \App\Facades\General::getComposeStatus($result->status) }}
                                    </span>
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
    @include('notFound.searchNotFound', ['message' => ""])
@endif
