@if (count($users))
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ ucwords(t('name')) }}</th>
                <th>{{ ucwords(t('email')) }}</th>
                <th>{{ ucwords(t('roles')) }}</th>
                <th style="max-width: 80px;min-width: 60px">{{ ucwords(t('actions')) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ object_get($user, 'name') }}</td>
                    <td>{{ object_get($user, 'email') }}</td>
                    <td>{{ implode(',' , $user->roles->pluck('name')->toArray()) }}</td>
                    <td style="max-width: 40px">
                        <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-warning btn-sm">
                            <i class="cil-color-border"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h4 class="text-center mt-4">
        {{ ucwords(t('there is no data for now.')) }}
        <a href="{{ route('admin.users.create') }}" class="text-success">{{ ucwords(t('add new')) }}</a>
    </h4>
@endif
