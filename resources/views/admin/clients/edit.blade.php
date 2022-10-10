@extends('admin.layouts.app')

@section('title', ucwords(t('Clients')))

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
                <li class="breadcrumb-item active"><span>{{ ucwords(t('Clients')) }}</span></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>
                {{ ucwords(t('Clients')) }}
            </h3>
        </div>
        <div class="card-body">
            <form
                action="@if ($client) {{ route('admin.clients.update', ['client' => $client]) }} @else {{ route('admin.clients.store') }} @endif"
                method="post" id="client_form">
                @csrf
                @if ($client)
                    @method('PUT')
                @endif
                <div class="row">

                    <div class="col-md-12">
                        <label for="company_name" class="mt-2">{{ ucwords(t('company name')) }}</label>
                        <input type="text" placeholder="{{ t('company name') }}" name="company_name"
                            value="@if ($client) {{ $client->company_name }} @endif" id="company_name"
                            class="form-control mt-2">
                    </div>


                    <div class="col-md-12">
                        <label for="email" class="mt-2">{{ ucwords(t('email')) }}</label>
                        <input type="email" placeholder="{{ t('email') }}" name="email"
                            value="@if ($client) {{ $client->email }} @endif" id="email"
                            class="form-control mt-2">
                    </div>


                    <div class="col-md-12">
                        <label for="company_phone" class="mt-2">{{ ucwords(t('company phone')) }}</label>
                        <input type="tel" placeholder="{{ t('company phone') }}" name="company_phone"
                            value="@if ($client) {{ $client->company_phone }} @endif"
                            id="company_phone" class="form-control mt-2">
                    </div>


                    <div class="col-md-12">
                        <label for="admin_name" class="mt-2">{{ ucwords(t('admin name')) }}</label>
                        <input type="text" placeholder="{{ t('admin name') }}" name="admin_name"
                            value="@if ($client) {{ $client->admin_name }} @endif" id="admin_name"
                            class="form-control mt-2">
                    </div>

                    <div class="col-md-12">
                        <label for="admin_phone" class="mt-2">{{ ucwords(t('admin phone')) }}</label>
                        <input type="tel" placeholder="{{ t('admin phone') }}" name="admin_phone"
                            value="@if ($client) {{ $client->admin_phone }} @endif" id="admin_phone"
                            class="form-control mt-2">
                    </div>

                    <div class="col-md-12">
                        <label for="admin_phone" class="mt-2">{{ ucwords(t('logo')) }}</label>
                        <input type="file" name="logo_image" id="logo_image" class="form-control"
                            accept=".png,.jpeg,.jpg,.gif">
                        @if ($client && object_get($client, 'logo'))
                            <div class="image mt-2 w-100 h-100">
                                <img src="{{ object_get($client, 'logo.full_path') }}"
                                    alt="{{ object_get($client, 'logo.full_path') }}" style="max-height: 80px">
                            </div>
                        @endif

                    </div>

                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-success btn-sm" type="submit" form="client_form">
                {{ ucwords(t('submit')) }}
            </button>
        </div>
    </div>
@endsection

@section('javascript')
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
