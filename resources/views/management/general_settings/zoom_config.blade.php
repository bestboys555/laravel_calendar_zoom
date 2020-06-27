@extends('management.themekit.dashboard')
@section('pageTitle')
{{__('Zoom meeting Settings')}}
@endsection

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-file-text bg-blue"></i>
                <div class="d-inline">
                    <h2>{{__('Zoom meeting Settings')}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    @if ($message = Session::get('success'))
        <div class="alert alert-success mb-2">{{ $message }}</div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger mb-2">
        <strong>Whoops!</strong> There were some problems with your input.<br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.general') }}">{{ __('General Settings') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('settings.zoom') }}">{{ __('Zoom meeting Settings') }}</a>
        </li>
    </ul>
        {!! Form::open(['method' => 'PUT','route' => ['settings.zoom.update', $generalsetting->id]]) !!}
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="api_key">{{__('Zoom api key')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="api_key" name="api_key" value="{{ $generalsetting->api_key }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="api_secret">{{__('Zoom api secret')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="api_secret" name="api_secret" value="{{ $generalsetting->api_secret }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="zoom_email">{{__('Zoom Email')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="zoom_email" name="zoom_email" value="{{ $generalsetting->zoom_email }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="timezone">{{__('Time Zone')}}</label>
                    <div class="col-sm-9">
                        {!! Form::select('timezone', array(
                                            'Asia/Bangkok' => 'Asia/Bangkok', 
                                            ), old('timezone', env('APP_TIMEZONE')) , array('class' => 'form-control select2', 'placeholder' => '' )) !!}
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-success mr-2" type="submit">{{__('Save')}}</button>
            </div>
        </div>
    {!! Form::close() !!}
    </div>
</div>
@endsection

@section('csspage')
<link rel="stylesheet" href="{!! asset('/plugins/select2/dist/css/select2.min.css') !!}">
<link rel="stylesheet" href="{!! asset('/plugins/summernote/dist/summernote-bs4.css') !!}">
<link rel="stylesheet" href="{!! asset('/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') !!}">
<link rel="stylesheet" href="{!! asset('/plugins/mohithg-switchery/dist/switchery.min.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('/plugins/select2/dist/js/select2.min.js') !!}"></script>
<script src="{!! asset('/plugins/summernote/dist/summernote-bs4.min.js') !!}"></script>
<script src="{!! asset('/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') !!}"></script>
<script src="{!! asset('/plugins/jquery.repeater/jquery.repeater.min.js') !!}"></script>
<script src="{!! asset('/plugins/mohithg-switchery/dist/switchery.min.js') !!}"></script>
<script>
    "use strict";
$(document).ready(function() {
    $('#meta_keyword').tagsinput('items');
});
</script>
@endsection
