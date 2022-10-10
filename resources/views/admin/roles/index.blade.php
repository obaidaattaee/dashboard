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
                <a class="btn btn-success float-end" href="{{ route('admin.roles.create') }}">
                    <i class="cil-plus"></i>
                    {{ ucwords(t('add new')) }}
                </a>
                <button class="btn btn-gray search-button float-end">
                    <i class="cil-search"></i>
                </button>
            </h3>
            <div class="card-toolbar search-section d-none">
                <form action="{{ route('admin.roles.index') }}" method="get" id="filter form">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" placeholder="name" class="form-control">
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
            <div class="table-responsive roles-content">
                @include('admin.roles.table', ['roles' => $roles])
            </div>
        </div>

    </div>
@endsection

@section('javascript')
    <script></script>
@endsection
