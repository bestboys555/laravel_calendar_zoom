<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                <button type="button" id="navbar-fullscreen" class="nav-link"><i
                        class="ik ik-maximize"></i></button>
            </div>
            @php
            $total_notification=0;
            if(Gate::check('coursecalendar-checkpayment')){
                $count_coursecalendar_register= get_table_all_where('coursecalendar_register','confirm_meeting','0')->count();
                $total_notification = $total_notification + $count_coursecalendar_register;
            }
            @endphp
            <div class="top-menu d-flex align-items-center">
                @if($total_notification>0)
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                            class="ik ik-bell"></i><span class="badge bg-danger">{{ $total_notification }}</span></a>
                    <div class="dropdown-menu dropdown-menu-right notification-dropdown"
                        aria-labelledby="notiDropdown">
                        <h4 class="header">Notifications</h4>
                        @if(Gate::check('meeting-checkpayment') and $count_meeting_register>0)
                        <div class="notifications-wrap">
                            <a href="{{ route('meeting_payment_notification') }}" class="media">
                                <span class="d-flex">
                                    <i class="ik bg-danger">{{ $count_meeting_register }}</i>
                                </span>
                                <span class="media-body">
                                    <span class="heading-font-family media-heading">{{ __('Check Payment Meeting') }} </span>
                                </span>
                            </a>
                        </div>
                        @endif
                        @if(Gate::check('coursecalendar-checkpayment') and $count_coursecalendar_register>0)
                        <div class="notifications-wrap">
                            <a href="{{ route('payment_coursecalendar_notification') }}" class="media">
                                <span class="d-flex">
                                    <i class="ik bg-danger">{{ $count_coursecalendar_register }}</i>
                                </span>
                                <span class="media-body">
                                    <span class="heading-font-family media-heading">{{ __('Check Payment Course') }} </span>
                                </span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><img class="avatar" src="{!! user_photo(Auth::user()->id) !!}"
                            alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('web.home') }}"><i class="ik ik-arrow-left-circle dropdown-icon"></i> Home</a>
                        <a class="dropdown-item" href="{{ route('profile.data') }}"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                        <a class="dropdown-item" href="{{ route('profile.data_pass') }}"><i class="ik ik-settings dropdown-icon"></i> Change Password</a>
                        <button type="button" class="dropdown-item" data-toggle="modal" data-target="#logout"><i class="ik ik-power dropdown-icon" data-toggle="modal" data-target="#logout"></i> Logout</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
