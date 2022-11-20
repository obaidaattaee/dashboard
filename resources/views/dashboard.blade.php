{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('admin.layouts.app')

@section('breadcrumb')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single--><span>Home</span>
                </li>
                <li class="breadcrumb-item active"><span>Blank</span></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4 text-white bg-primary">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">
                            {{ Arr::get($data, 'clients_count', '-') }}
                        </div>
                        <div>
                            <i class="cil-applications"></i>
                            {{ ucwords(t('Clients')) }}

                        </div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart1" height="70"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4 text-white bg-info">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">
                            {{ Arr::get($data, 'plans_count', '-') }}
                        </div>
                        <div>
                            <i class="cil-library"></i>
                            {{ ucwords(t('plans')) }}
                        </div>
                    </div>
                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart2" height="70"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4 text-white bg-warning">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">
                            {{ Arr::get($data, 'subscriptions', '-') }}
                        </div>
                        <div>
                            <i class="cil-library"></i>
                            {{ ucwords(t('subscriptions')) }}
                        </div>
                    </div>

                </div>
                <div class="c-chart-wrapper mt-3" style="height:70px;">
                    <canvas class="chart" id="card-chart3" height="70"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card mb-4 text-white bg-danger">
                <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-4 fw-semibold">
                            {{ Arr::get($data, 'invoices', '-') }}
                        </div>
                        <div>
                            <i class="cil-cash"></i>
                            {{ ucwords(t('invoices')) }}
                        </div>
                    </div>

                </div>
                <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                    <canvas class="chart" id="card-chart4" height="70"></canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="card">
        <div class="card-header">
            <h3>
                {{ ucwords(t('Subscriptions')) }}
                <a class="btn btn-success mx-1 float-end" href="{{ route('admin.subscriptions.create') }}">
                    <i class="cil-plus"></i>
                    {{ ucwords(t('add new')) }}
                </a>
                <button class="btn btn-gray mx-1 search-button float-end">
                    <i class="cil-search"></i>
                </button>
                <button class="btn btn-primary mx-1 invoice-button d-none float-end">
                    <i class="cil-money"></i>
                    {{ ucwords(t('add invoice')) }}
                </button>
                @can('change sales status to called')
                    <a class="btn btn-info mx-1 sales-button d-none float-end"
                        href="{{ route('admin.invoice_subscription.change_sales_status', ['type' => 'called']) }}">
                        <i class="cil-money"></i>
                        {{ ucwords(t('mark as called')) }}
                    </a>
                @endcan
                @can('change sales status to renewd')
                    <a class="btn btn-success mx-1 sales-button d-none float-end"
                        href="{{ route('admin.invoice_subscription.change_sales_status', ['type' => 'renewd']) }}">
                        <i class="cil-money"></i>
                        {{ ucwords(t('mark as renewd')) }}
                    </a>
                @endcan

            </h3>

            <div class="card-toolbar search-section d-none">
                <form action="{{ route('admin.subscriptions.index') }}" method="get" id="filter_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            {{-- <input type="text" placeholder="{{ ucwords(t('name')) }}" name="name" id="name"
                                class="form-control"> --}}
                            <select name="client_id" id="client_id" class="form-control select">
                                <option value="">{{ ucwords(t('all clients')) }}</option>
                                @foreach (Arr::get($data, 'clients', []) as $client)
                                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            {{-- <input type="text" placeholder="{{ ucwords(t('email')) }}" name="email" id="email"
                                class="form-control"> --}}
                            <select name="plan_id" id="plan_id" class="form-control form-select select"
                                data-coreui-search="true">
                                <option value="">{{ ucwords(t('all plans')) }}</option>
                                @foreach (Arr::get($data, 'plans', []) as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <input type="text" placeholder="{{ ucwords(t('search')) }}" name="search" id="search"
                                class="form-control">
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success">
                                {{ ucwords(t('search')) }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive subscriptions-content">
                @include('admin.subscriptions.table', ['subscriptions' => $subscriptions])
            </div>
        </div>

    </div>



    <!-- Start Subscription Modal -->
    <div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Subscription Modal -->


    <!-- Start Invoice Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modat-title">
                        {{ ucwords(t('add invoice')) }}
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.invoices.store') }}" enctype="multipart/form-data" method="POST"
                        id="invoice_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="invoice_number">{{ ucwords(t('invoice number')) }}</label>
                                <input placeholder="{{ ucwords(t('invoice number')) }}" type="text"
                                    class="form-control my-2" name="invoice_number" id="invoice_number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="invoice_number">
                                    {{ ucwords(t('duration')) }}
                                    <span class="duration_type"></span>
                                </label>
                                <input placeholder="{{ ucwords(t('duration')) }}" type="number"
                                    class="form-control my-2" name="duration" id="duration">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="description">{{ ucwords(t('description')) }}</label>
                                <textarea placeholder="{{ ucwords(t('description')) }}" name="description" id="description" cols="30"
                                    rows="10" class="form-control my-2"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="invoice_number">{{ ucwords(t('invoice cost')) }}</label>
                                <input placeholder="{{ ucwords(t('invoice cost')) }}" type="number" step=".0001"
                                    class="form-control my-2" name="invoice_cost" id="invoice_cost">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="invoice_number">{{ ucwords(t('invoice image')) }}</label>
                                <input type="file" class="form-control my-2" name="invoice_image" id="invoice_image">
                            </div>
                        </div>
                        <input type="hidden" name="subscriptions" id="subscription_ids" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                    <button class="btn btn-success btn-sm" type="submit"
                        form="invoice_form">{{ ucwords(t('submit')) }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Invoice Modal -->


    <!-- Start Show Invoices Modal -->
    <div class="modal fade" id="invoicesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modat-title">
                        {{ ucwords(t('Show Invoices')) }}
                    </div>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Show Invoices Modal -->
@endsection

@section('javascript')
    <script>
        EMPTY_SUBSCRIPTIONS = "{{ ucwords(t('you should select subscriptions first.')) }}"
        DIFFIRANTE_SUBSCRIPTIONS = "{{ ucwords(t('you should select subscriptions that have same duration.')) }}"
        DIFFIRANTE_SUBSCRIPTIONS = "{{ ucwords(t('you should select subscriptions that have same duration.')) }}"
    </script>

    <script>
        @hasallroles('super_admin')
            function SalesStatusFilter(value, index, self) {
                return self.indexOf(value) === index;
            }
        @else
            function SalesStatusFilter(value, index, self) {
                console.log(value, index, self);
                return false;
            }
        @endhasallroles
    </script>

    <script src="{{ asset('admin_assets/js/custom/subscriptions.js') }}"></script>

    <script>
        $('#filter_form').on('submit', function(event) {
            event.preventDefault()

            $('.loader').show()

            var formData = new FormData(this)

            var url = $(this).prop('action')

            $.ajax({
                url: url + "?client_id=" + $('#client_id').val() + '&plan_id=' + $('#plan_id').val() +
                    '&search=' +
                    $('#search').val(),
                method: "get",
                data: formData,
                processData: false,
                contentType: false,
            }).then(function(response) {
                $('.loader').hide()

                $(response.data.container_class).empty().append(response.data.data)

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
    </script>

    <script src="{{ asset('admin_assets/js/custom/subscriptions.js') }}"></script>
    <script src="{{ asset('admin_assets/vendors/chart.js/js/chart.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('admin_assets/vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
    <script src="{{ asset('admin_assets/js/main.js') }}"></script>
@endsection
