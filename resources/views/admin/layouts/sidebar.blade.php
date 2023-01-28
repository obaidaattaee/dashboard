<div class="sidebar sidebar-light sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img src="{{ config()->get('settings.app_logo' , asset('admin_assets/assets/img/default_logo.png')) }}" class="sidebar-brand-narrow w-50" width="46" height="46"
            alt="">

        {{-- <img src="{{ config()->get('settings.app_logo') }}" class="sidebar-brand-narrow" width="46" height="46"
            alt=""> --}}

    </div>

    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('admin_assets/vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}">
                    </use>
                </svg> Dashboard<span class="badge badge-sm bg-info ms-auto">NEW</span>
            </a>
        </li>
        <li class="nav-title">{{ ucwords(t('settings')) }}</li>
        @can('show users list')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="cil-group px-2"></i>
                    {{ ucwords(t('users')) }}
                </a>
            </li>
        @endcan
        @can('show roles list')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <i class="cil-address-book px-2"></i>
                    {{ ucwords(t('roles')) }}
                </a>
            </li>
        @endcan
        @can('show general settings')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings.general') }}">
                    <i class="cil-settings px-2"></i>
                    {{ ucwords(t('general settings')) }}
                </a>
            </li>
        @endcan


    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
