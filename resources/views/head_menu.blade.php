<header id="header">
    <div class="inner-header">
        <div class="content">
            <div class="hamburger-box hidden-lg">
                <div class="hamburger-inner"></div>
            </div>
            <a href="{{ route('web.home') }}" title="{{ $generalsetting->site_name }}" class="logo hidden-xs hidden-sm hidden-md">
                <img src="{!! asset('images/logo_index.png') !!}" alt="{{ $generalsetting->site_name }}"/>
            </a>
            <a href="{{ route('web.home') }}" title="{{ $generalsetting->site_name }}" class="logo hidden-lg">
                <img src="{!! asset('images/logo_mobile.svg') !!}" alt="{{ $generalsetting->site_name }}"/>
            </a>
            <nav class="global-nav hidden-xs hidden-sm hidden-md">
                <ul>
                    <li class="has-sub">
                        <a href="#" title="{{ __('Calendar') }}" class="link-sub  ga_nav_header {{ (request()->routeIs('web.coursecalendar') or request()->routeIs('web.coursecalendar_data') or request()->routeIs('web.register_coursecalendar')) ? 'current' : '' }}">{{ __('Calendar') }}</a>
                        <ul class="mega-menu">
                            <li><a href="{{ route('web.coursecalendar', 'Course') }}" title="{{ __('Course Calendar') }}" target="_self" class="level-1-title">{{ __('Course Calendar') }}</a></li>
                            <li><a href="{{ route('web.coursecalendar', 'Meeting') }}" title="{{ __('Meeting Calendar') }}" target="_self" class="level-1-title">{{ __('Meeting Calendar') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="right-header">
                    {{--  <ul class="language hidden-xs hidden-sm">
                        <li><a href="#" style="color:#da0902" title="ไทย">ไทย</a></li>
                        <li><a href="/en/personal-banking.html" title="EN">EN</a></li>
                    </ul>  --}}
                <a href="#" title="ค้นหา" class="icons icon-search" data-search-modal data-url="search"></a>
                @if (!Auth::check())
                <div class="digital-menu">
                    <a href="#" title="{{ __('Login') }}" class="hide-icon btn-login"> <i class="fa fa-user-circle" style="font-size: 20px;"></i> <p class="mb-0">{{ __('Login/Register') }}</p> </a>
                    {{--  <a href="#" title="{{ __('Login') }}" class="btn btn-primary btn-primary-dropdown hide-icon btn-login">{{ __('Login') }}</a>  --}}
                    <div class="user_card" id="digital">
                        <div class="justify-content-center form_container">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="email" name="email" id="email" class="form-control input_user @error('email') is-invalid @enderror" placeholder="{{ __('EMail Address') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control input_pass" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox pt-2">
                                        <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                                        <label class="custom-control-label" for="remember">{{ __('Remember me') }}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 mb-3">
                                        @if(env('GOOGLE_RECAPTCHA_KEY'))
                                            <div class="g-recaptcha"
                                                data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                    <div class="justify-content-center mt-4">
                             <button class="btn login_btn" type="submit">{{ __('Login') }}</button>
                           </div>
                            </form>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex justify-content-center links">
                                {{ __('Dont have an account?') }} <a href="{{ route('register') }}" class="ml-2">{{ __('Register') }}</a>
                            </div>
                            <div class="d-flex justify-content-center links">
                                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="dropdown">
                    <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{!! user_photo(Auth::user()->id) !!}" class="avatar">
                        @php
                        $cont_zoom=get_zoom_notification_num();
                        @endphp
                        @if ($cont_zoom!=0)
                        <span class="badge badge-pill badge-danger mb-1">{{ $cont_zoom }}</span></a>
                        @endif
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-140px, 29px, 0px);">
                        <ul>
                            <li><a class="dropdown-item" href="{{ url('management') }}"><i class="fa fa-arrow-alt-circle-right"></i> {{ __('Dashboard') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('web.meeting_your_list') }}"><i class="fa fa-th-list"></i> {{ __('List your Meeting') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('web.zoom_list') }}"><i class="fa fa-th-list"></i> {{ __('Zoom meeting') }} @if ($cont_zoom!=0)
                                <span class="badge_list badge-pill badge-danger mb-1">{{ $cont_zoom }}</span></a>
                                @endif</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.data') }}"><i class="fa fa-user"></i> {{ __('Profile') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.data_pass') }}"><i class="fa fa-cog"></i> {{ __('Change Password') }}</a></li>
                            <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#logout"><i class="fa fa-power-off"></i> {{ __('Log out') }}</a></li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div id="search-modal" data-searchmodal class="modal" data-url="index.html">
        <div class="inner-container">
            <a href="#" title="" class="icons icon-close"></a>
            <div class="search-result">
                <section class="search">
                    <input type="hidden" id="numberOfRecentItems" value="3"/>
                    <form action="{{ route('web.search') }}" method="get" name="search-form" id="search-form">
                        <div class="search-input">
                            <button type="submit" title="" class="icons icon-search" disabled></button>
                            <input type="text" name="q" id="search-advance" value="" placeholder="พิมพ์สิ่งที่ต้องการค้นหา" class="search-advance"/>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <div class="mega-menu-mobile hidden-lg">
        <div class="outer-menu">
            <div class="collapse-item">
                <h3 class="collapse-header"><a href="#" title="{{ __('Calendar') }}">{{ __('Calendar') }}</a></h3>
                <div class="collapse-inner">
                    <div class="mega-menu">
                        <div class="inner-menu">
                            <div class="level-1">
                                <ul>
                                    <li><a href="{{ route('web.coursecalendar', 'Course') }}" title="{{ __('Course Calendar') }}" target="_self" class="level-1-title">{{ __('Course Calendar') }}</a></li>
		                            <li><a href="{{ route('web.coursecalendar', 'Meeting') }}" title="{{ __('Meeting Calendar') }}" target="_self" class="level-1-title">{{ __('Meeting Calendar') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  <ul class="language">
            <li>ไทย</li>
            <li><a href="#" title="EN">EN</a></li>
        </ul>  --}}
    </div>
</header>
