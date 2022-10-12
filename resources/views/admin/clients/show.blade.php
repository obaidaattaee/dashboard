@extends('admin.layouts.app')

@section('title', ucwords($client->company_name))

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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clients.index') }}" class="text-dark">
                        <!-- if breadcrumb is single--><span>{{ ucwords(t('Clinets')) }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active"><span>{{ ucwords($client->company_name) }}</span></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- start client details card -->
    <div class="card">
        <div class="card-header">
            <h3>
                {{ ucwords($client->company_name) }}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ object_get($client, 'logo_image') }}" class="w-100 rounded" style="max-height: 100px"
                        alt="{ ucwords($client->company_name) }}">
                </div>
                <div class="col-md-10">
                    <div class="row h-50">
                        <div class="col-md-3">
                            <div class="fw-bold">{{ ucwords(t('company name')) }}</div>
                            {{ object_get($client, 'company_name') }}
                        </div>
                        <div class="col-md-3">
                            <div class="fw-bold">{{ ucwords(t('email')) }}</div>
                            {{ object_get($client, 'email') }}
                        </div>
                        <div class="col-md-3">
                            <div class="fw-bold">{{ ucwords(t('company phone')) }}</div>
                            {{ object_get($client, 'company_phone') }}
                        </div>
                        <div class="col-md-3">
                            <div class="fw-bold">{{ ucwords(t('admin name')) }}</div>
                            {{ object_get($client, 'admin_name') }}
                        </div>
                    </div>
                    <div class="row h-50">
                        <div class="col-md-3">
                            <div class="fw-bold">{{ ucwords(t('admin phone')) }}</div>
                            {{ object_get($client, 'admin_phone') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end client details card -->


    <!-- start client subscriptions card -->
    <div class="card mt-4">
        <div class="card-header">
            <h3>
                {{ ucwords(t('subscriptions')) }}

                <a class="btn btn-success float-end mx-1"
                    href="{{ route('admin.subscriptions.create', ['client_id' => $client->id]) }}">
                    <i class="cil-plus"></i>
                    {{ ucwords(t('add new')) }}
                </a>
                <button class="btn btn-info invoice-button d-none mx-1 float-end">
                    <i class="cil-money"></i>
                    {{ ucwords(t('add invoice')) }}
                </button>
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @include('admin.subscriptions.table', [
                    'subscriptions' => $subscriptions,
                    'client' => $client,
                ])
            </div>
        </div>
    </div>
    <!-- end client subscriptions card -->


    <!-- Modal -->
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
@endsection

@section('javascript')
    <script src="{{ asset('admin_assets/js/custom/subscriptions.js') }}"></script>

    <script>
        $('#client_form').on('submit', function(event) {
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
                    window.location.href = "{{ route('admin.clients.index') }}"
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
    </script>
@endsection
