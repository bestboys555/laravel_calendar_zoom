@extends('management.themekit.dashboard')
@section('pageTitle')
{{__('General Settings')}}
@endsection

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-file-text bg-blue"></i>
                <div class="d-inline">
                    <h2>{{__('General Settings')}}</h2>
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
            <a class="nav-link active" href="{{ route('settings.general') }}">{{ __('General Settings') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.zoom') }}">{{ __('Zoom meeting Settings') }}</a>
        </li>
    </ul>
        {!! Form::open(['method' => 'PUT','route' => ['settings.general.update', $generalsetting->id]]) !!}
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="name">{{__('Site Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="name" name="name" value="{{ $generalsetting->site_name }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="meta_keyword">{{__('Meta keyword')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="meta_keyword" name="meta_keyword" value="{{ $generalsetting->meta_keyword }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="meta_author">{{__('Meta author')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="meta_author" name="meta_author" value="{{ $generalsetting->meta_author }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="meta_description">{{__('Meta description')}}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="4" id="meta_description" name="meta_description">{{$generalsetting->meta_description}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="address">{{__('Address')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="address" name="address" value="{{ $generalsetting->address }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="name">{{__('Footer Text')}}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="4" name="description">{{$generalsetting->description}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="phone">{{__('Phone')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="phone" name="phone" value="{{ $generalsetting->phone }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="email">{{__('Email')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="email" name="email" value="{{ $generalsetting->email }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="facebook">{{__('Facebook')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="facebook" name="facebook" value="{{ $generalsetting->facebook }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="instagram">{{__('Instagram')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="instagram" name="instagram" value="{{ $generalsetting->instagram }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="twitter">{{__('Twitter')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="twitter" name="twitter" value="{{ $generalsetting->twitter }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="youtube">{{__('Youtube')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="youtube" name="youtube" value="{{ $generalsetting->youtube }}" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label text-right" for="google_plus">{{__('Google Plus')}}</label>
                    <div class="col-sm-9">
                        <input type="text" id="google_plus" name="google_plus" value="{{ $generalsetting->google_plus }}" class="form-control">
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
