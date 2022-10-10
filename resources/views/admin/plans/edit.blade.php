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
            </h3>
        </div>
        <div class="card-body">
            <form
                action="@if ($plan) {{ route('admin.plans.update', ['plan' => $plan]) }} @else {{ route('admin.plans.store') }} @endif"
                method="post" id="plan_form">
                @csrf
                @if ($plan)
                    @method('PUT')
                @endif
                <div class="row">

                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('name')) }}</label>
                        <input type="text" placeholder="{{ t('name') }}" name="name"
                            value="@if ($plan) {{ $plan->name }} @endif" id="name"
                            class="form-control mt-2">
                    </div>

                    <div class="col-md-12">
                        <label for="duration" class="mt-2">{{ ucwords(t('duration')) }}</label>
                        <select name="duration" id="duration" class="form-control">
                            @foreach ($durations as $duration)
                                <option value="{{ $duration['name'] }}" @if (($plan && $plan->duration == $duration['name']) || $loop->index == 0) selected @endif>
                                    {{ ucwords(t($duration['display_name'])) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="cost" class="mt-2">{{ ucwords(t('cost')) }}</label>
                        <input type="number" step=".001" placeholder="{{ t('cost') }}" name="cost"
                            value="@if ($plan){{ $plan->cost }}@endif" id="cost"
                            class="form-control mt-2">
                    </div>

                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-success btn-sm" type="submit" form="plan_form">
                {{ ucwords(t('submit')) }}
            </button>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $('#plan_form').on('submit', function(event) {
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
                    window.location.href = "{{ route('admin.plans.index') }}"
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
