@extends('management.themekit.dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row clearfix">
            @canany([
                'coursecalendar-list', 'coursecalendar-create', 'coursecalendar-edit', 'coursecalendar-delete'
                ])
            <div class="col-lg-3 col-md-6 col-sm-12">
                <a href="{{ route('coursecalendar.index') }}">
                    <div class="widget bg-primary">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>{{ __('Calendar') }}</h6>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @canany([
                'Media', 'Media-delete'
                ])
            <div class="col-lg-3 col-md-6 col-sm-12">
                <a href="{{ route('media.index') }}">
                    <div class="widget bg-success">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>{{ __('Media Library') }}</h6>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-image"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @canany([
                'user-list', 'user-create', 'user-edit', 'user-delete'
                ])
            <div class="col-lg-3 col-md-6 col-sm-12">
                <a href="{{ route('settings.general') }}">
                    <div class="widget bg-warning">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>{{ __('Settings') }}</h6>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-cogs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @canany([
                'user-list', 'user-create', 'user-edit', 'user-delete'
                ])
            <div class="col-lg-3 col-md-6 col-sm-12">
                <a href="{{ route('users.index') }}">
                    <div class="widget bg-danger">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>{{ __('Users Management') }}</h6>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
        </div>

    </div>
</div>
@endsection
@section('csspage')
<link rel="stylesheet" href="{!! asset('plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/jvectormap/jquery-jvectormap.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/weather-icons/css/weather-icons.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/c3/c3.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('plugins/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables.net-responsive/js/dataTables.responsive.min.js') !!}"></script>
<script src="{!! asset('plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') !!}"></script>
<script src="{!! asset('plugins/jvectormap/jquery-jvectormap.min.js') !!}"></script>
<script src="{!! asset('plugins/jvectormap/tests/assets/jquery-jvectormap-world-mill-en.js') !!}"></script>
<script src="{!! asset('plugins/moment/moment.js') !!}"></script>
<script src="{!! asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<script src="{!! asset('plugins/d3/dist/d3.min.js') !!}"></script>
<script src="{!! asset('plugins/c3/c3.min.js') !!}"></script>
<script src="{!! asset('js/tables.js') !!}"></script>
<script src="{!! asset('js/charts.js') !!}"></script>
@endsection
