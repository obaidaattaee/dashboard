<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img src="{{ config()->get('settings.app_logo') }}" class="sidebar-brand-narrow" width="46" height="46"
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
        @can('show general settings')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings.general') }}">
                    <img src="{{ asset('admin_assets/assets/icons/settings.svg') }}" class="px-2" alt="">
                    {{ ucwords(t('general settings')) }}
                </a>
            </li>
        @endcan
        {{-- @can('show roles') --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.roles.index') }}">
                    <img src="{{ asset('admin_assets/assets/icons/settings.svg') }}" class="px-2" alt="">
                    <i class="fa fa-users"></i>
                    {{ ucwords(t('roles')) }}
                </a>
            </li>
        {{-- @endcan --}}
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
