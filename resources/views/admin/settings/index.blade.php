@extends('admin.layouts.app')

@section('title', ucwords(t('general settings')))

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
                <li class="breadcrumb-item active"><span>{{ ucwords(t('general settings')) }}</span></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>
                {{ ucwords(t('general settings')) }}
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="post" id="setting_form"
                enctype="multipart/form-data" class="form-inline">
                @csrf

                <div class="row">
                    @foreach ($settings as $setting)
                        <div class="col-lg-12 my-2">
                            <label for="{{ $setting->key }}">{{ ucwords(t($setting->name)) }}</label>
                            @if (in_array($setting->type, ['text', 'number', 'checkbox']))
                                <input type="{{ $setting->type }}" name="{{ $setting->key }}" class="form-control mt-2"
                                    value="{{ $setting->value }}">
                            @elseif ($setting->type == 'textarea')
                                <textarea name="{{ $setting->key }}" class="form-control mt-2" id="{{ $setting->key }}" cols="30" rows="10">{{ $setting->value }}</textarea>
                            @elseif ($setting->type == 'file')
                                <input type="file" name="files[{{ $setting->key }}]" accept=".png,.jpeg,.jpg,.gif"
                                    id="files.{{ $setting->key }}" class="form-control">
                                    <div class="image mt-2 w-100 h-100">
                                        <img src="{{ $setting->value }}" alt="{{ $setting->value }}" style="max-height: 80px">
                                    </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-success btn-sm" type="submit" form="setting_form">
                {{ ucwords(t('submit')) }}
            </button>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $('#setting_form').on('submit', function(event) {
            event.preventDefault();

            $('.loader').show()

            var formData = new FormData(this)

            $.ajax({
                url: "{{ route('admin.settings.update') }}",
                method: "post",
                data: formData,
                processData: false,
                contentType: false,
            }).then(function(response) {

                $('.loader').hide()

                toastr.success(response.message)
            }).catch(function({
                responseJSON
            }) {
                $('.loader').hide()

                toastr.error(responseJSON.message)
            })
        })
    </script>
@endsection
