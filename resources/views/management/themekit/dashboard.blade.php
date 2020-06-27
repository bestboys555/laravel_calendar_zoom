<!doctype html>
<html class="no-js" lang="en">
@section('pageTitle')
Dashboard
@endsection
<head>
@include('management.themekit.head')
</head>
@php
$profile = App\User::find(Auth::id());
$check_publish = App\Http\Controllers\RoleController::check_publish();
@endphp
<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <div class="wrapper {{ Auth::user()->hidden_menu === "1" ? "nav-collapsed menu-collapsed" : "" }}">
        @include('management.themekit.head_menu')
        <div class="page-wrap">
            @include('management.themekit.sidebar')
            <div class="main-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                @include('management.themekit.footer')
            </footer>
        </div>
    </div>
@include('management.themekit.script')
@yield('script')
</body>
</html>
