@extends('admin.layouts.app')

@section('title', ucwords(t('Users')))

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
                <li class="breadcrumb-item active"><span>{{ ucwords(t('Users')) }}</span></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>
                {{ ucwords(t('Users')) }}
            </h3>
        </div>
        <div class="card-body">
            <form
                action="@if ($user) {{ route('admin.users.update', ['user' => $user]) }} @else {{ route('admin.users.store') }} @endif"
                method="post" id="user_form">
                @csrf
                @if ($user)
                    @method('PUT')
                @endif
                <div class="row">

                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('name')) }}</label>
                        <input type="text" placeholder="{{ t('name') }}" name="name"
                            value="@if ($user) {{ $user->name }} @endif" id="name"
                            class="form-control mt-2">
                    </div>

                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('email')) }}</label>
                        <input type="email" placeholder="{{ t('email') }}" name="email"
                            value="@if ($user) {{ $user->email }} @endif" id="email"
                            class="form-control mt-2">
                    </div>

                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('password')) }}</label>
                        <input type="password" placeholder="{{ t('password') }}" name="password" value=""
                            id="password" class="form-control mt-2">
                    </div>

                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('roles')) }}</label>
                        <div class="row mx-2 my-2">
                            @foreach ($roles as $role)
                                <div class="col-md-3">
                                    <input type="checkbox" name="roles[]" id="roles_{{ $role->id }}"
                                    @if($user && $user->hasRole($role->id)) checked @endif
                                        value="{{ $role->id }}">
                                    <label for="roles_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-success btn-sm" type="submit" form="user_form">
                {{ ucwords(t('submit')) }}
            </button>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $('#user_form').on('submit', function(event) {
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
                    window.location.href = "{{ route('admin.users.index') }}"
                }, 2000);
            }).catch(function({
                responseJSON
            }) {
                $('.loader').hide()

                if (Object.keys(responseJSON.errors).length) {
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
