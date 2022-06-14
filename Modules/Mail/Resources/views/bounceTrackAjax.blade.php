@if (count($results) > 0)
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive bounce-tracking-spinner">
                <div class="main-spinner w-100 justify-content-center align-items-center">
                    <div class="spinner-border"></div>
                </div>
                <div class="overlay"></div>
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">{{ __('#') }}</th>
                        <th class="border-0">{{ __('Domain') }}</th>
                        <th class="border-0">{{ __('Sender Email') }}</th>
                        <th class="border-0">{{ __('Last Bounce Tracked Date') }}</th>
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
                            <td><span>{{ $result->sender_name . '<' . $result->sender_email . '>' }}</span></td>
                            <td>
                                <span>{{ \App\Facades\General::datetimeFormat($result->bounce_track_date) }}</span>
                            </td>
                            <td>
                                <div class="text-end">
                                    <div class="btn-group">
                                        <a class="dropdown-item d-flex align-items-center" style="padding-right: 0"
                                           onclick="checkGMail('{{ $result->id }}','{{ $result->sender_email }}', '{{ $result->domain_id }}');">
                                                <span class="dropdown-icon text-gray-400 me-2">
                                                    <i class="fa-solid fa-circle-play"></i>
                                                </span>
                                            Start Bounce Tracking
                                        </a>
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
    @include('notFound.searchNotFound', ['message' => "We're sorry what you were looking for. Please add new sender email."])
@endif
