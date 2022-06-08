<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            @if (count($results) > 0)
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">{{ __('#') }}</th>
                        <th class="border-0">{{ __('Name') }}</th>
                        <th class="border-0">{{ __('Email') }}</th>
                        <th class="border-0">{{ __('Role') }}</th>
                        <th class="border-0">{{ __('Created At') }}</th>
                        <th class="border-0 rounded-end text-end">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td><span class="font-weight-bold">{{ $result->id }}</span></td>
                            <td><span>{{ $result->name }}</span></td>
                            <td><span>{{ $result->email }}</span></td>
                            <td><span>{{ ucfirst($result->role) }}</span></td>
                            <td>
                                <span>
                                    {{ \App\Facades\General::dateFormat($result->created_at) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-end">
                                    @include('actions.index', ['module' => 'users', 'id' => $result->id])
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
