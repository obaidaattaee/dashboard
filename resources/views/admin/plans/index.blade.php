@extends('admin.layouts.app')

@section('title', ucwords(t('Plans')))

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
                <li class="breadcrumb-item active"><span>{{ ucwords(t('Plans')) }}</span></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>
                {{ ucwords(t('Plans')) }}
                <a class="btn btn-success float-end" href="{{ route('admin.plans.create') }}">
                    <i class="cil-plus"></i>
                    {{ ucwords(t('add new')) }}
                </a>
                <button class="btn btn-gray search-button float-end">
                    <i class="cil-search"></i>
                </button>
            </h3>
            <div class="card-toolbar search-section d-none">
                <form action="{{ route('admin.plans.index') }}" method="get" id="filter_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" placeholder="{{ ucwords(t('name')) }}" name="name" id="name"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <select name="duration" id="duration" class="form-control">
                                <option value="">{{ t('duration') }}</option>
                                @foreach ($durations as $duration)
                                    <option value="{{ $duration['name'] }}">
                                        {{ ucwords(t($duration['display_name'])) }}</option>
                                @endforeach
                            </select>
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
            <div class="table-responsive plans-content">
                @include('admin.plans.table', ['plans' => $plans])
            </div>
        </div>

    </div>
@endsection

@section('javascript')
    <script>
        $('#filter_form').on('submit', function(event) {
            event.preventDefault()

            $('.loader').show()

            var formData = new FormData(this)

            var url = $(this).prop('action')

            $.ajax({
                url: url + "?name=" + $('#name').val() + '&email=' + $('#email').val() + '&duration=' + $(
                    '#duration').val(),
                method: "get",
                data: formData,
                processData: false,
                contentType: false,
            }).then(function(response) {
                $('.loader').hide()

                $('.plans-content').empty().append(response.data)

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
