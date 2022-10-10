@if (count($roles))
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ ucwords(t('name')) }}</th>
                <th>{{ ucwords(t('guard')) }}</th>
                <th style="max-width: 20px">{{ ucwords(t('actions')) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ object_get($role, 'name') }}</td>
                    <td>{{ object_get($role, 'guard_name') }}</td>
                    <td style="max-width: 20px">
                        <a href="{{ route('admin.roles.edit', ['role' => $role->id]) }}" class="btn btn-warning btn-sm">
                            <i class="cil-color-border"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
