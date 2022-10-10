@if (count($plans))
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ ucwords(t('name')) }}</th>
                <th>{{ ucwords(t('cost')) }}</th>
                <th>{{ ucwords(t('duration')) }}</th>
                <th style="max-width: 80px;min-width: 60px">{{ ucwords(t('actions')) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plans as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ object_get($plan, 'name') }}</td>
                    <td>{{ object_get($plan, 'cost') }}</td>
                    <td>{{ object_get($plan, 'duration_name') }}</td>
                    <td style="max-width: 40px">
                        <a href="{{ route('admin.plans.edit', ['plan' => $plan->id]) }}" class="btn btn-warning btn-sm">
                            <i class="cil-color-border"></i>
                        </a>

                        <button class="btn btn-danger btn-sm" type="submit" form="delete_plan_{{ $plan->id }}">
                            <i class="cil-trash"></i>
                        </button>
                        <form action="{{ route('admin.plans.destroy', ['plan' => $plan->id]) }}"
                            id="delete_plan_{{ $plan->id }}" class="delete_item" method="POST">
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
        <a href="{{ route('admin.plans.create') }}" class="text-success">{{ ucwords(t('add new')) }}</a>
    </h4>
@endif
