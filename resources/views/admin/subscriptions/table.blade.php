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
                <th>{{ ucwords(t('description')) }}</th>
                <th>{{ ucwords(t('duration')) }}</th>
                <th>{{ ucwords(t('start from')) }}</th>
                <th>{{ ucwords(t('expiration date')) }}</th>
                <th>{{ ucwords(t('invoice number')) }}</th>

                <th style="max-width: 100px;min-width: 90px">{{ ucwords(t('actions')) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                {{-- {{ dd($subscription->invoices) }} --}}
                <tr>
                    <td>
                        <input type="checkbox" name="subscription_id[]" value="{{ $subscription->id }}"
                            data-duration="{{ object_get($subscription, 'plan.duration') }}" class="subscription"
                            id="subscription_id_{{ $subscription->id }}">
                    </td>
                    <td>{{ $subscription->id }}</td>
                    <td>
                        <a
                            href="{{ route('admin.clients.show', ['client' => object_get($subscription, 'client.id', '0')]) }}">
                            <img src="{{ $subscription->logo_image }}" alt="" class="rounded"
                                style="max-width: 50px">
                            {{ object_get($subscription, 'client.company_name', '-') }}
                        </a>
                    </td>
                    <td>
                        <a
                            href="{{ route('admin.plans.edit', ['plan' => object_get($subscription, 'plan.id', '-')]) }}">
                            {{ object_get($subscription, 'plan.name', '-') }}
                        </a>
                    </td>
                    <td>{{ substr(object_get($subscription, 'description', '-'), 0, 150) }}</td>
                    <td>{{ object_get($subscription, 'plan.duration_name', '-') }}</td>
                    <td>{{ object_get($subscription, 'start_from', '-') }}</td>
                    <td>
                        @if ($subscription->status == App\Models\Subscription::STATUSES[0]['id'])
                            {{ object_get($subscription, 'status_name', '-') }}
                        @elseif ($subscriptionInvoice = $subscription->invoiceSubscriptions->first())
                            @php
                                if (Carbon\Carbon::parse($subscriptionInvoice->expiration_date)->gt(now())) {
                                    if (object_get($subscription, 'plan.name', App\Models\Plan::DURATIONS[0]['name']) == App\Models\Plan::DURATIONS[1]['name']) {
                                        $color = Carbon\Carbon::parse($subscriptionInvoice->expiration_date)->diffInMonths(now()) > 1 ? 'success' : 'warning';
                                    } else {
                                        $color = Carbon\Carbon::parse($subscriptionInvoice->expiration_date)->diffInDays(now()) > 7 ? 'success' : 'warning';
                                    }
                                } else {
                                    $color = 'danger';
                                }
                            @endphp
                            <span class="invoices-history p-2 btn btn-{{ $color }} text-white rounded"
                                data-url="{{ route('admin.subscriptions.show_invoices', ['subscription' => $subscription->id]) }}"
                                data-subsccription-id="{{ $subscription->id }}">
                                {{ object_get($subscriptionInvoice, 'expiration_date', '-') }}
                            </span>
                        @else
                            {{ ucwords(t('ends')) }}
                        @endif
                    </td>

                    <td>
                        @if ($subscriptionInvoice = $subscription->invoiceSubscriptions->first())
                            @php
                                if (Carbon\Carbon::parse($subscriptionInvoice->expiration_date)->gt(now())) {
                                    if (object_get($subscription, 'plan.name', App\Models\Plan::DURATIONS[0]['name']) == App\Models\Plan::DURATIONS[1]['name']) {
                                        $color = Carbon\Carbon::parse($subscriptionInvoice->expiration_date)->diffInMonths(now()) > 1 ? 'success' : 'warning';
                                    } else {
                                        $color = Carbon\Carbon::parse($subscriptionInvoice->expiration_date)->diffInDays(now()) > 7 ? 'success' : 'warning';
                                    }
                                } else {
                                    $color = 'danger';
                                }
                            @endphp
                            <span class="invoices-history p-2 btn btn-{{ $color }} text-white rounded"
                                data-url="{{ route('admin.subscriptions.show_invoices', ['subscription' => $subscription->id]) }}"
                                data-subsccription-id="{{ $subscription->id }}">
                                {{ object_get($subscriptionInvoice, 'invoice.invoice_number', '-') }}
                            </span>
                        @else
                            -
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
    @if (!isset($needPagination))
        {{ $subscriptions->links() }}
    @endif
@else
    <h4 class="text-center mt-4">
        {{ ucwords(t('there is no data for now.')) }}
        <a href="{{ route('admin.subscriptions.create', ['client_id' => isset($client) ? $client->id : 0]) }}"
            class="text-success">{{ ucwords(t('add new')) }}</a>
    </h4>
@endif
