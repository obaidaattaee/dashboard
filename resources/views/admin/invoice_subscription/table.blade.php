@if (isset($subscriptions) && count($subscriptions))
    <table class="table">
        <thead>
            <th>{{ ucwords(t('invoice number')) }}</th>
            <th>{{ ucwords(t('duration')) }}</th>
            <th>{{ ucwords(t('start from')) }}</th>
            <th>{{ ucwords(t('expiration date')) }}</th>
            <th>{{ ucwords(t('cost')) }}</th>
            <th>{{ ucwords(t('attachment')) }}</th>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscrip)
                {{-- {{ dd(object_get($subscrip, 'invoice.invoiceImage')) }} --}}
                <tr>
                    <td>{{ object_get($subscrip, 'invoice.invoice_number') }}</td>
                    <td>{{ object_get($subscrip, 'subscription.plan.duration_name') }}</td>
                    <td>{{ object_get($subscrip, 'start_from') }}</td>
                    <td>{{ object_get($subscrip, 'expiration_date') }}</td>
                    <td>{{ object_get($subscrip, 'cost') }}</td>
                    <td>
                        @if (object_get($subscrip, 'invoice.invoiceImage.full_path'))
                            <a data-fancybox="" href="{{ object_get($subscrip, 'invoice.invoiceImage.full_path') }}"
                                class="fancybox">
                                <img src="{{ object_get($subscrip, 'invoice.invoiceImage.full_path') }}"
                                    style="max-width: 100px" alt="">
                            </a>
                        @else
                            {{ ucwords(t('no image')) }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
