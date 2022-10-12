@if (count($subscriptions))
    <table class="table">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" name="subscriptions" class="subscriptions" id="subscriptions">
                </th>
                <th>#</th>
                <th>{{ ucwords(t('client')) }}</th>
                <th>{{ ucwords(t('plan')) }}</th>
                <th>{{ ucwords(t('duration')) }}</th>
                <th>{{ ucwords(t('start from')) }}</th>
                <th>{{ ucwords(t('expiration date')) }}</th>
                <th style="max-width: 100px;min-width: 80px">{{ ucwords(t('actions')) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <td>
                        <input type="checkbox" name="subscription_id[]" value="{{ $subscription->id }}"
                            data-duration="{{ object_get($subscription, 'plan.duration') }}" class="subscription"
                            id="subscription_id_{{ $subscription->id }}">
                    </td>
                    <td>{{ $subscription->id }}</td>
                    <td>
                        <img src="{{ $subscription->logo_image }}" alt="" class="rounded"
                            style="max-width: 50px">
                        {{ object_get($subscription, 'client.company_name', '-') }}
                    </td>
                    <td>{{ object_get($subscription, 'plan.name', '-') }}</td>
                    <td>{{ object_get($subscription, 'plan.duration_name', '-') }}</td>
                    <td>{{ object_get($subscription, 'start_from', '-') }}</td>
                    <td>
                        @if ($subscription->status == App\Models\Subscription::STATUSES[0]['id'])
                            {{ object_get($subscription, 'status_name', '-') }}
                        @else
                            {{ object_get($subscription, 'expiration_date', '-') }}
                        @endif
                    </td>
                    <td style="max-width: 40px;min-width: 30px">

                        <button data-description="{{ $subscription->description }}"
                            class="btn btn-success btn-sm subscription-details">
                            <i class="cil-description"></i>
                        </button>

                        <a href="{{ route('admin.subscriptions.edit', ['subscription' => $subscription->id, 'client_id' => isset($client) ? $client->id : 0]) }}"
                            class="btn btn-warning btn-sm">
                            <i class="cil-color-border"></i>
                        </a>

                        <button class="btn btn-danger btn-sm" type="submit"
                            form="delete_subscription_{{ $subscription->id }}">
                            <i class="cil-trash"></i>
                        </button>
                        <form
                            action="{{ route('admin.subscriptions.destroy', ['subscription' => $subscription->id]) }}"
                            id="delete_subscription_{{ $subscription->id }}" class="delete_item" method="POST">
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
        <a href="{{ route('admin.subscriptions.create', ['client_id' => isset($client) ? $client->id : 0]) }}"
            class="text-success">{{ ucwords(t('add new')) }}</a>
    </h4>
@endif
