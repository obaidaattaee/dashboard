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
asda
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Invoice Modal -->


@endsection

@section('javascript')
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
