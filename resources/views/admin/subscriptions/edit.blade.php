@extends('admin.layouts.app')

@section('title', ucwords(t('Subscriptions')))

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/bootstrap-datepicker.min.css') }}" />
@endsection
@section('breadcrumb')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-dark">
                        <!-- if breadcrumb is single--><span>{{ ucwords(t('dashboard')) }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span>{{ ucwords(t('Subscriptions')) }}</span></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>
                {{ ucwords(t('Subscriptions')) }}
            </h3>
        </div>
        <div class="card-body">
            <form
                action="@if ($subscription) {{ route('admin.subscriptions.update', ['subscription' => $subscription]) }} @else {{ route('admin.subscriptions.store') }} @endif"
                method="post" id="subscription_form">
                @csrf
                @if ($subscription)
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <label for="client_id" class="mt-2">{{ ucwords(t('Client')) }}</label>
                        <select name="client_id" id="client_id" class="form-control mt-2">
                            <option value="">{{ ucwords(t('select client')) }}</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" @if (object_get($subscription ?? '', 'client_id', request()->input('client_id')) == $client->id) selected @endif>
                                    {{ $client->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="plan_id" class="mt-2">{{ ucwords(t('Plan')) }}</label>
                        <select name="plan_id" id="plan_id" class="form-control mt-2">
                            <option value="">{{ ucwords(t('select plan')) }}</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" data-duration="{{ $plan->duration }}"
                                    data-cost="{{ $plan->cost }}" @if ($subscription && $subscription->plan_id == $plan->id) selected @endif>
                                    {{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="start_from" class="mt-2">{{ ucwords(t('Start from')) }}</label>
                        <input type="text" name="start_from" value="@if($subscription){{ $subscription->start_from }}@endif" id="start_from" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="expiration_date" class="mt-2">{{ ucwords(t('expiration date')) }}</label>
                        <input type="text" name="expiration_date" value="@if($subscription){{ $subscription->expiration_date }}@endif" id="expiration_date" class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="cost" class="mt-2">{{ ucwords(t('cost')) }}</label>
                        <input type="text" name="cost" value="@if($subscription){{ $subscription->cost }}@endif" id="cost" class="form-control" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="cost" class="mt-2">{{ ucwords(t('description')) }}</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control mt-2">
@if ($subscription)
{{ $subscription->description }}
@endif
</textarea>
                    </div>
                </div>
                <input type="hidden" name="duration" id="duration" value="@if($subscription){{ $subscription->duration }}@endif">
            </form>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-success btn-sm" type="submit" form="subscription_form">
                {{ ucwords(t('submit')) }}
            </button>
        </div>
    </div>

@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('admin_assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script>
        $('#subscription_form').on('submit', function(event) {
            event.preventDefault();
            $('.loader').show()

            var url = $(this).prop('action')
            var formData = new FormData(this)

            $.ajax({
                url: url,
                method: "post",
                data: formData,
                processData: false,
                contentType: false,
            }).then(function(response) {
                $('.loader').hide()
                toastr.success(response.message)

                setTimeout(() => {
                    window.location.href =
                        "{{ request()->input('client_id')  ? route('admin.clients.show', ['client' => request()->input('client_id')]) : route('admin.subscriptions.index') }}"
                }, 2000);
            }).catch(function({
                responseJSON
            }) {
                $('.loader').hide()

                if (responseJSON.errors && Object.keys(responseJSON.errors).length) {
                    Object.keys(responseJSON.errors).forEach(error => {
                        toastr.error(responseJSON.errors[error][0]);
                    });
                } else {
                    toastr.error(responseJSON.message)
                }
            })
        })
        $('#start_from').datepicker({
            format: "yyyy-mm-dd",
            weekStart: 1,
            orientation: "bottom",
            language: "{{ app()->getLocale() }}",
            keyboardNavigation: false,
            // endDate: endYear,
        });

        $('#plan_id , #start_from').on('change', function(event) {
            var planDuration = $('#plan_id option:selected').data('duration')
            var startFromDate = moment($('#start_from').val())
            var expirationDate
            if (planDuration) {
                $('#cost').val($('#plan_id option:selected').data('cost'))
                $('#duration').val(planDuration)
            }
            if (startFromDate._isValid) {
                expirationDate = startFromDate.add(1, planDuration + 's').format('YYYY-MM-DD');
            }
            $('#expiration_date').val(expirationDate)
        })
    </script>
@endsection