@extends('admin.layouts.app')

@section('title', ucwords(t('Subscriptions')))

@section('css')
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
                <a class="btn btn-success float-end" href="{{ route('admin.subscriptions.create') }}">
                    <i class="cil-plus"></i>
                    {{ ucwords(t('add new')) }}
                </a>
                <button class="btn btn-gray search-button float-end">
                    <i class="cil-search"></i>
                </button>
                <button class="btn btn-info invoice-button d-none float-end">
                    <i class="cil-money"></i>
                    {{ ucwords(t('add invoice')) }}
                </button>
            </h3>
            <div class="card-toolbar search-section d-none">
                <form action="{{ route('admin.subscriptions.index') }}" method="get" id="filter_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" placeholder="{{ ucwords(t('name')) }}" name="name" id="name"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input type="text" placeholder="{{ ucwords(t('email')) }}" name="email" id="email"
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
                                <input placeholder="{{ ucwords(t('duration')) }}" type="number" class="form-control my-2"
                                    name="duration" id="duration">
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
    </script>
    <script src="{{ asset('admin_assets/js/custom/subscriptions.js') }}"></script>

    <script>
        $('#filter_form').on('submit', function(event) {
            event.preventDefault()

            $('.loader').show()

            var formData = new FormData(this)

            var url = $(this).prop('action')

            $.ajax({
                url: url + "?name=" + $('#name').val() + '&email=' + $('#email').val(),
                method: "get",
                data: formData,
                processData: false,
                contentType: false,
            }).then(function(response) {
                $('.loader').hide()

                $('.subscriptions-content').empty().append(response.data)

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
@endsection
