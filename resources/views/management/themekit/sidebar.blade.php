<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{ url('management') }}">
            <div class="logo-img">
                <img src="/images/logo_mobile.svg" class="header-brand-img" alt="lavalite">
            </div>
            <span class="text">@if(!empty($profile->getRoleNames()))
                @foreach($profile->getRoleNames() as $v)
                   {{ $v }}
                @endforeach
              @endif</span>
        </a>
        <button type="button" class="nav-toggle" route-data="{{ route('profile.Updatehidden_menu') }}"><i data-toggle="{{ Auth::user()->hidden_menu === "1" ? "collapsed" : "expanded" }}"
                class="ik ik-toggle-right toggle-icon"></i></button>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-lavel">Navigation</div>
                <div class="nav-item {{ (request()->routeIs('news*') or request()->routeIs('admin_home')) ? 'active open' : '' }}">
                    <a href="{{ url('management') }}"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                </div>
                @canany([
                    'coursecalendar-list', 'coursecalendar-create', 'coursecalendar-edit', 'coursecalendar-delete','coursecalendar-checkpayment'
                    ])
                <div class="nav-item has-sub {{ (request()->routeIs('coursecalendar*') or (request()->routeIs('payment_coursecalendar_notification'))) ? 'active open' : '' }}">
                    <a href="javascript:void(0)" class="main-menu"><i class="fa fa-calendar"></i><span>{{ __('Workshop Training') }}</span></a>
                    <div class="submenu-content">
                    @canany([
                    'coursecalendar-list', 'coursecalendar-create', 'coursecalendar-edit', 'coursecalendar-delete','coursecalendar-checkpayment'
                    ])
                        <a href="{{ route('coursecalendar.index') }}" class="menu-item {{ (request()->routeIs('coursecalendar*') and !request()->routeIs('payment_coursecalendar_notification')) ? 'active' : '' }}">{{ __('Calendar') }}</a>
                        @endcan
                        @canany([
                            'coursecalendar-checkpayment'
                            ])
                        <a href="{{ route('payment_coursecalendar_notification') }}" class="menu-item {{ (request()->routeIs('payment_coursecalendar_notification')) ? 'active' : '' }}">{{ __('Check Payment') }}</a>
                        @endcan
                    </div>
                </div>
                @endcan
@canany([
'Media', 'Media-delete'
])
                <div class="nav-lavel">{{ __('management') }}</div>
                @canany([
                    'Media', 'Media-delete'
                    ])
                <div class="nav-item {{ (request()->routeIs('media*')) ? 'active open' : '' }}">
                    <a href="{{ route('media.index') }}" class="main-menu"><i class="ik ik-image"></i><span>{{ __('Media Library') }}</span></a>
                </div>
                @endcan
@endcan
@canany([
'generalsetting',
])
<div class="nav-lavel">{{ __('Settings') }}</div>
<div class="nav-item {{ (request()->routeIs('settings*')) ? 'active open' : '' }}">
    <a href="{{ route('settings.general') }}" class="main-menu"><i class="fa fa-cogs"></i><span>{{ __('Settings') }}</span></a>
</div>
@endcan
@canany([
'user-list', 'user-create', 'user-edit', 'user-delete',
'role-list', 'role-create', 'role-edit', 'role-delete',
'perm-list', 'perm-create', 'perm-edit', 'perm-delete'
])
                <div class="nav-lavel">{{ __('Users and Role') }}</div>
                <div class="nav-item has-sub {{ (request()->routeIs('users*') or request()->routeIs('roles*') or request()->routeIs('perm*')) ? 'active open' : '' }}">
                    <a href="javascript:void(0)" class="main-menu"><i class="ik ik-users"></i><span>{{ __('Users and Role') }}</span></a>
                    <div class="submenu-content">
@canany([
    'user-list', 'user-create', 'user-edit', 'user-delete'
])
                        <a href="{{ route('users.index') }}" class="menu-item {{ (request()->routeIs('users*')) ? 'active' : '' }}">{{ __('Users Management') }}</a>
@endcan
@canany([
    'role-list', 'role-create', 'role-edit', 'role-delete'
])
                        <a href="{{ route('roles.index') }}" class="menu-item {{ (request()->routeIs('roles*')) ? 'active' : '' }}">{{ __('Role Management') }}</a>
@endcan
@canany([
    'perm-list', 'perm-create', 'perm-edit', 'perm-delete'
])
                        <a href="{{ route('perm.index') }}" class="menu-item {{ (request()->routeIs('perm*')) ? 'active' : '' }}">{{ __('Permision Management') }}</a>
                    </div>
@endcan
                </div>
                @endcan
                {{--
                <div class="nav-lavel">Users and Role</div>
                <div class="nav-item active">
                    <a href="{!! asset('pages/navbar.html') !!}" target="_blank"><i class="ik ik-award"></i><span>Page teamplate</span></a>
                </div> --}}
            </nav>
        </div>
    </div>
</div>
