@extends('admin.layouts.app')

@section('title', ucwords(t('Roles')))

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
                <li class="breadcrumb-item active"><span>{{ ucwords(t('Roles')) }}</span></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>
                {{ ucwords(t('Roles')) }}
            </h3>
        </div>
        <div class="card-body">
            <form
                action="@if ($role) {{ route('admin.roles.update', ['role' => $role]) }} @else {{ route('admin.roles.store') }} @endif"
                method="post" id="role_form">
                @csrf
                @if ($role)
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('name')) }}</label>
                        <input type="text" placeholder="{{ t('name') }}" name="name"
                            value="@if ($role) {{ $role->name }} @endif" id="name"
                            class="form-control mt-2">

                    </div>

                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('Permissions')) }}</label>

                        @foreach ($permissions as $key => $permissions)
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <input type="checkbox" class="fomr-control permission_group"
                                        id="permissions_{{ $key }}">
                                    <label for="{{ $key }}">{{ $key }}</label>
                                    <div class="row mx-4 my-2">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-3">
                                                <input type="checkbox" class="permission" name="permissions[]"
                                                    @if ($role && $role->hasPermissionTo($permission->id)) checked @endif
                                                    id="permissions_{{ $permission->id }}" value="{{ $permission->id }}">
                                                <label
                                                    for="permissions_{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-success btn-sm" type="submit" form="role_form">
                {{ ucwords(t('submit')) }}
            </button>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $('.permission_group').on('click', function(event) {
            var isChecked = $(this).is(':checked');

            if (isChecked) {
                $(this).parent().find('.permission').prop('checked', true)
            } else {
                $(this).parent().find('.permission').prop('checked', false)
            }
        })

        $('.permission').on('click', function(event) {
            var isChecked = $(this).is(':checked');

            var permissions = $(this).parent().parent().find('.permission')
            var checkedPermissions = $(this).parent().parent().find('.permission:checked')

            if (permissions.length == checkedPermissions.length) {
                $(this).parent().parent().parent().find('.permission_group').prop('checked', true)
            } else {
                $(this).parent().parent().parent().find('.permission_group').prop('checked', false)
            }
        })
    </script>

    <script>
        $('#role_form').on('submit', function(event) {
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
                    window.location.href = "{{ route('admin.roles.index') }}"
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
