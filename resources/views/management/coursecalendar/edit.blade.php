@extends('management.themekit.dashboard')
@section('pageTitle'){{ __('Edit') }} {{ $coursecalendar->name }}@stop
@section('content')
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-file-text bg-blue"></i>
                    <div class="d-inline">
                        <h2>{{ __('Edit Course Calendar') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('management') }}"><i class="ik ik-home"></i></a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('coursecalendar.index') }}">{{ __('Course Calendar Management') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="coursecalendar">{{ __('Edit Course Calendar') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>{{ __('Whoops!') }}</strong> {{ __('There were some problems with your input.') }}<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
            <form class="forms-sample" action="{{ route('coursecalendar.update', $coursecalendar->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body" id="date">
                            <div class="form-group">
                                <label for="exampleInputTitle">{{ __('Name') }} <small class="color-red">*</small></label>
                                {!! Form::text('name', old('name', $coursecalendar->name), array('id'=>'name','placeholder' => 'Name','class' => 'form-control','required' => 'required')) !!}
                            </div>
                            <div class="form-group">
                                <label for="roles">{{ __('Type Calendar') }} <small class="color-red">*</small></label>
                                {!! Form::select('type_calendar', array('Course' => 'Course', 'Meeting' => 'Meeting'), old('type_calendar', $coursecalendar->type_calendar) , array('class' => 'form-control select2', 'placeholder' => '' ,'required' => 'required')) !!}
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="open">{{ __('Location') }}</label>
                                        <div class="">
                                            {!! Form::text('location', old('location', $coursecalendar->location), array('id'=>'location','placeholder' => __('Location'),'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="show_index">{{ __('Target Audience') }}</label>
                                        <div class="">
                                            {!! Form::text('target_audience', old('target_audience', $coursecalendar->target_audience), array('id'=>'target_audience','placeholder' => __('Target Audience'),'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="show_index">{{ __('Course Director') }}</label>
                                        <div class="">
                                            {!! Form::text('course_director', old('course_director', $coursecalendar->course_director), array('id'=>'course_director','placeholder' => __('Course Director'),'class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputTitle">{{ __('Use open for register') }}</label>
                                {!! Form::checkbox('open_register', '1', old('open_register', $coursecalendar->open_register), ['class' => 'js-dynamic-state']); !!}
                            </div>
                            <div class="row" id="register_content" style="{{ (old('open_register')==1 or $coursecalendar->open_register == 1) ? '' : 'display: none;' }}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Number of participants') }} <small class="color-red">*</small></label>
                                        <input id="number_participants" placeholder="Number of participants" class="form-control @error('number_participants') is-invalid @enderror" name="number_participants" type="number" value="{{ old('number_participants', $coursecalendar->number_participants ) }}">
                                        @error('number_participants')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Price per person') }} <small class="color-red">*</small></label>
                                        <input id="price" placeholder="Price" class="form-control @error('price') is-invalid @enderror" name="price" type="number" value="{{ old('price', $coursecalendar->price) }}">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">{{ __('Date Register') }}</div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Date start') }}</label>
                                        <div class="input-group date" id="register_start_date" data-target-input="nearest">
                                             <input name="register_start_date" type="text" class="form-control datetimepicker-input @error('register_start_date') is-invalid @enderror" data-target="#register_start_date" value="{{ old('register_start_date', $coursecalendar->register_start_date) }}" readonly />
                                             <div class="input-group-append" data-target="#register_start_date" data-toggle="datetimepicker">
                                                 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                             </div>
                                            @error('register_start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                     </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Date end') }}</label>
                                        <div class="input-group date" id="register_end_date" data-target-input="nearest">
                                             <input name="register_end_date" type="text" class="form-control datetimepicker-input @error('register_end_date') is-invalid @enderror" data-target="#register_end_date" value="{{ old('register_end_date', $coursecalendar->register_end_date) }}" readonly />
                                             <div class="input-group-append" data-target="#register_end_date" data-toggle="datetimepicker">
                                                 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                             </div>
                                             @error('register_end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                         </div>
                                     </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">{{ __('Date Meeting') }}</div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Date start') }}</label>
                                        <div class="input-group date" id="start_date" data-target-input="nearest">
                                             <input name="start_date" type="text" class="form-control datetimepicker-input @error('start_date') is-invalid @enderror" data-target="#start_date" value="{{ old('start_date', $coursecalendar->start_date) }}" readonly />
                                             <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                                 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                             </div>
                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                     </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Date end') }}</label>
                                        <div class="input-group date" id="end_date" data-target-input="nearest">
                                             <input name="end_date" type="text" class="form-control datetimepicker-input @error('end_date') is-invalid @enderror" data-target="#end_date" value="{{ old('end_date', $coursecalendar->end_date) }}" readonly />
                                             <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                                 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                             </div>
                                             @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                         </div>
                                     </div>
                                </div>
                            </div>
@php
    if($zoom!=false){
@endphp
                            <div class="form-group">
                                <label for="exampleInputTitle">{{ __('Use Zoom online meeting') }} <img src="{!! asset('images/zoom.png') !!}" style="height: 40px;"></label>
                                {!! Form::checkbox('open_zoom', '1', old('open_zoom', $coursecalendar->open_zoom), ['class' => 'js-dynamic-state']); !!}
                            </div>
                            <div class="row" id="zoom_content" style="{{ (old('open_zoom')==1 or $coursecalendar->open_zoom == 1) ? '' : 'display: none;' }}">
                                <div class="col-md-6">
                                    @php
                                    if($zoom_data){
                                        $zoom_start_time=$zoom_data->start_time;
                                        $zoom_duration=$zoom_data->duration;
                                    }else{
                                        $zoom_start_time=$coursecalendar->start_date;
                                        $zoom_duration="0";
                                    }
                                    @endphp
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Start Date & Time video meeting') }}</label>
                                        <div class="input-group date" id="zoom_start_time" data-target-input="nearest">
                                             <input name="zoom_start_time" type="text" class="form-control datetimepicker-input @error('zoom_start_time') is-invalid @enderror" data-target="#zoom_start_time" value="{{ old('zoom_start_time', $zoom_start_time) }}" readonly />
                                             <div class="input-group-append" data-target="#zoom_start_time" data-toggle="datetimepicker">
                                                 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                             </div>
                                            @error('zoom_start_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    @php
    if($errors->has('zoom_duration')){
        $error_zoom_duration=" is-invalid";
    }else{
        $error_zoom_duration="";
    }
@endphp
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Duration') }} ({{ __('Time ') }}) <small class="color-red">*</small></label>
                                        {!! Form::select('zoom_duration', array(
                                            '60' => '1 HR',
                                            '120' => '2 HR',
                                            '180' => '3 HR',
                                            '240' => '4 HR',
                                            '300' => '5 HR',
                                            '360' => '6 HR',
                                            '420' => '7 HR',
                                            '480' => '8 HR',
                                            '540' => '9 HR',
                                            '600' => '10 HR',
                                            '660' => '11 HR',
                                            ), old('zoom_duration', $zoom_duration) , array('class' => 'form-control select2'.$error_zoom_duration, 'placeholder' => '' )) !!}
                                        @error('zoom_duration')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>
                                @php
                                if($zoom_data){
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Zoom Password') }}</label>
                                        <input id="zoom-Password" placeholder="{{ __('Zoom Password') }}" class="form-control" name="zoom_password" readonly value="{{ $zoom_data->password }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{ __('Zoom link') }}</label>
                                        <div class="input-group">
                                            <input id="zoom-link" placeholder="{{ __('Zoom link') }}" class="form-control" name="zoom_link" readonly value="{{ $zoom_data->join_url }}">
                                            <div class="input-group-append" >
                                                <div class="input-group-text bg-blue">
                                                    <a href="{{ $zoom_data->start_url }}" target="_blank"><i class="fa fa-video" aria-hidden="true"></i> Start
                                                </a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(((\Carbon\Carbon::parse($zoom_data->start_time))->addMinutes($zoom_data->duration)) > \Carbon\Carbon::now())
                                <div class="col-md-12">
                                    <div class="alert alert-info" role="alert">
                                        Metting Start in:{{((\Carbon\Carbon::parse($zoom_data->start_time))->addMinutes($zoom_data->duration))->diffForHumans()}}
                                    </div>
                                </div>
                                @else
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                        Expire:{{((\Carbon\Carbon::parse($zoom_data->start_time))->addMinutes($zoom_data->duration))->diffForHumans()}}
                                      </div>
                                </div>
                                @endif
                                @php
                                 }
                                @endphp
                            </div>
@php
                        }
@endphp
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __('General Information') }}</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ __('FAQs') }}</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{ __('Accommodation') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="payment_detailb-tab" data-toggle="tab" href="#payment_detailb" role="tab" aria-controls="payment_detailb" aria-selected="false">{{ __('Payment detail') }}</a>
                                </li>
                              </ul>
                              <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="form-group">
                                        <textarea class="form-control html-editor summernote" id="detail" name="detail" cols="50">{{ old('detail', $coursecalendar->detail) }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="form-group">
                                        <textarea class="form-control html-editor summernote" id="faqs" name="faqs" cols="50">{{ old('faqs', $coursecalendar->faqs) }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="form-group">
                                        <textarea class="form-control html-editor summernote" id="accommodation" name="accommodation" cols="50">{{ old('accommodation', $coursecalendar->accommodation) }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="payment_detailb" role="tabpanel" aria-labelledby="payment_detailb-tab">
                                    <div class="form-group">
                                        <textarea class="form-control html-editor summernote" id="payment_detail" name="payment_detail" cols="50">{{ old('payment_detail', $coursecalendar->payment_detail) }}</textarea>
                                    </div>
                                </div>
                              </div>
                            <div class="form-group">
                                <label for="show_index">Show on Index page</label>
                                <div class="">
                                    {!! Form::checkbox('show_index', '1', old('show_index', $coursecalendar->show_index), ['class' => 'js-dynamic-state']); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="myDropzone" class="dropzone" route-data="{{ route('file.upload_file') }}"></div>
                            </div>
                            <div id="show_file" route-data="{{ route('file.show_file') }}" route-data-sortable="{{ route('file.file_sortable') }}" class="row">
                            </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success mr-2">{{ __('Save Changes') }}</button>
                        @if (isset($ref_id))
                        <a class="btn btn-dark" href="{{ route('coursecalendar.category', ['id' => $ref_id]) }}"> Back</a>
                         @else
                        <a class="btn btn-dark" href="{{ route('coursecalendar.index') }}"> {{ __('Back') }}</a>
                        @endif
                        {!! Form::hidden('table_id', $coursecalendar->id, array('id'=>'table_id')) !!}
                        {!! Form::hidden('table_name', 'coursecalendar', array('id'=>'table_name')) !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('csspage')
<link rel="stylesheet" href="{!! asset('plugins/summernote/summernote-0.8.16-dist/summernote.min.css') !!}">
{{--  <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">  --}}
<link rel="stylesheet" href="{!! asset('css/dropzone.css') !!}">
<link rel="stylesheet" href="{!! asset('css/dropzone_custom.css') !!}">
<link rel="stylesheet" href="{!! asset('css/paperclip.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/jquery-ui-1.12.1/jquery-ui.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/mohithg-switchery/dist/switchery.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('plugins/sweetalert/dist/sweetalert.min.js') !!}"></script>
<script src="{!! asset('plugins/summernote/summernote-0.8.16-dist/summernote.min.js') !!}"></script>
{{--  <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>  --}}
<script src="{!! asset('js/dropzone.js') !!}"></script>
<script src="{!! asset('js/upload_pic.js') !!}"></script>
<script src="{!! asset('js/summernote_meeting.js') !!}"></script>
<script src="{!! asset('plugins/mohithg-switchery/dist/switchery.js') !!}"></script>
<script src="{!! asset('plugins/moment/moment.js') !!}"></script>
<script src="{!! asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<script>
function load_data_pic(){
@if (!empty(old('picture')))
@foreach (old('picture') as $date => $array)
$("#alt_{{ $date }}").val("{{ $array['title'] }}");
@endforeach
@endif
}
function load_data_file(){
@if (!empty(old('document')))
    @foreach (old('document') as $date => $array)
    $("#file_alt_{{ $date }}").val("{{ $array['title'] }}");
    @endforeach
@endif
}

var elems = Array.prototype.slice.call(document.querySelectorAll('.js-dynamic-state'));
elems.forEach(function(el) {
  var switchery = new Switchery(el);
  el.onchange = function(e) {
    if (($(this).attr('name')=='open_register') && ($(this).is(':checked'))) {
        $("#register_content").show();
    } else if (($(this).attr('name')=='open_register')){
        $("#register_content").hide();
    }
    if (($(this).attr('name')=='open_zoom') && ($(this).is(':checked'))) {
        $("#zoom_content").show();
    } else if (($(this).attr('name')=='open_zoom')){
        $("#zoom_content").hide();
    }
  }
});

$(function () {
@php
    if($zoom!=false){
@endphp
    $('#zoom_start_time').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        ignoreReadonly: true
    });
@php
}
@endphp
    $('#register_start_date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        ignoreReadonly: true
    });
    $('#register_end_date').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm',
        ignoreReadonly: true
    });
    $("#register_start_date").on("change.datetimepicker", function (e) {
        $('#register_end_date').datetimepicker('minDate', e.date);
    });
    $("#register_end_date").on("change.datetimepicker", function (e) {
        $('#register_start_date').datetimepicker('maxDate', e.date);
    });

    $('#start_date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        ignoreReadonly: true
    });
    $('#end_date').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm',
        ignoreReadonly: true
    });
    $("#start_date").on("change.datetimepicker", function (e) {
        $('#end_date').datetimepicker('minDate', e.date);
    });
    $("#end_date").on("change.datetimepicker", function (e) {
        $('#start_date').datetimepicker('maxDate', e.date);
    });
});
</script>
@endsection
