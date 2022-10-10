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
                method="post" id="create_role">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('name')) }}</label>
                        <input type="text" placeholder="{{ t('name') }}" id="name" class="form-control mt-2">
                    </div>

                    <div class="col-md-12">
                        <label for="name" class="mt-2">{{ ucwords(t('Permissions')) }}</label>

                        @foreach ($permissions as $key => $permissions)
                            <div class="row">
                                <div class="col-md-12 my-2">
                                    <input type="checkbox" id="permissions_{{ $key }}">
                                    <label for="{{ $key }}">{{ $key }}</label>
                                    <div class="row mx-4 my-2">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-3">
                                                <input type="checkbox" name="permissions[]"
                                                    id="permissions_{{ $permission->id }}">
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
            <button class="btn btn-success btn-sm" type="submit" form="setting_form">
                {{ ucwords(t('submit')) }}
            </button>
        </div>
    </div>
@endsection

@section('javascript')
    <script></script>
@endsection
