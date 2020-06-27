<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('pageTitle')</title>
@yield('meta')
<link rel="icon" href="{!! asset('favicon.ico') !!}">
<link rel="stylesheet" href="{!! asset('plugins/fontawesome/css/all.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/bootstrap-4.4.1/dist/css/bootstrap.min.css') !!}">
<link rel="stylesheet" href="{!! asset('css/main-all.css') !!}" type="text/css">
@yield('csspage')
</head>
@php
$generalsetting = \App\GeneralSetting::first();
@endphp
<body class="homepage ">
	<div class="page">
        @include('head_menu')
		<div class="root responsivegrid">
            @yield('content')
		</div>
        @include('footer')
    </div>
<script src="{!! asset('js/jquery.min.js') !!}"></script>
<script>window.jQuery || document.write('<script src="{!! asset('src/js/vendor/jquery-3.3.1.min.js') !!}"><\/script>')</script>
<script src="{!! asset('plugins/popper.js/dist/umd/popper.min.js') !!}"></script>
<script src="{!! asset('plugins/bootstrap-4.4.1/dist/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('js/main-all.min.js') !!}"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
@yield('scriptpage')
</body>
</html>
