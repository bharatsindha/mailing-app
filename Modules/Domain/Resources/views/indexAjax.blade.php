@if (count($results) > 0)
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-centered table-nowrap mb-0 rounded" style="min-height: 30vh;">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">{{ __('#') }}</th>
                        <th class="border-0">{{ __('Name') }}</th>
                        <th class="border-0">{{ __('Url') }}</th>
                        <th class="border-0">{{ __('Client ID') }}</th>
                        <th class="border-0">{{ __('Created At') }}</th>
                        <th class="border-0 rounded-end text-end">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td><span class="font-weight-bold">{{ $result->id }}</span></td>
                            <td><span>{{ $result->name }}</span></td>
                            <td><span>{{ $result->url }}</span></td>
                            <td><span>{{ ucfirst($result->client_id) }}</span></td>
                            <td>
                                <span>
                                    {{ \App\Facades\General::dateFormat($result->created_at) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-end">
                                    @include('actions.index', ['module' => 'domains', 'id' => $result->id])
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
    @include('notFound.searchNotFound', ['message' => "We're sorry what you were looking for. Please add new domain."])
@endif
