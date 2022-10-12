@if (count($clients))
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ ucwords(t('company name')) }}</th>
                <th>{{ ucwords(t('email')) }}</th>
                <th>{{ ucwords(t('company_phone')) }}</th>
                <th>{{ ucwords(t('admin_name')) }}</th>
                <th>{{ ucwords(t('admin_phone')) }}</th>
                <th style="max-width: 100px;min-width: 80px">{{ ucwords(t('actions')) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>
                        <img src="{{ $client->logo_image }}" alt="" class="rounded" style="max-width: 50px">
                        {{ object_get($client, 'company_name' , '-') }}</td>
                    <td>{{ object_get($client, 'email' , '-') }}</td>
                    <td>{{ object_get($client, 'company_phone' , '-') }}</td>
                    <td>{{ object_get($client, 'admin_name' , '-') }}</td>
                    <td>{{ object_get($client, 'admin_phone' , '-') }}</td>
                    <td style="max-width: 40px;min-width: 30px">

                        <a href="{{ route('admin.clients.show', ['client' => $client->id]) }}" class="btn btn-success btn-sm">
                            <i class="cil-description"></i>
                        </a>

                        <a href="{{ route('admin.clients.edit', ['client' => $client->id]) }}" class="btn btn-warning btn-sm">
                            <i class="cil-color-border"></i>
                        </a>

                        <button class="btn btn-danger btn-sm" type="submit" form="delete_client_{{ $client->id }}">
                            <i class="cil-trash"></i>
                        </button>
                        <form action="{{ route('admin.clients.destroy', ['client' => $client->id]) }}"
                            id="delete_client_{{ $client->id }}" class="delete_item" method="POST">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h4 class="text-center mt-4">
        {{ ucwords(t('there is no data for now.')) }}
        <a href="{{ route('admin.clients.create') }}" class="text-success">{{ ucwords(t('add new')) }}</a>
    </h4>
@endif
