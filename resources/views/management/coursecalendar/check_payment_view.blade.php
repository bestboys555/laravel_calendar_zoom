@extends('management.themekit.dashboard')
@section('pageTitle')View Data {{ $coursecalendar->name }}@endsection

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-eye bg-blue"></i>
                <div class="d-inline">
                    <h2>{{ __('Check Payment') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('management') }}"><i class="ik ik-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('coursecalendar.index') }}">{{ __('Course Calendar Management') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Data</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td width="25%" class="col_head">{{ __('Training name') }}</td>
                            <td><h3>{!!$coursecalendar->name!!}</h3></td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('Date Register start') }}</td>
                            <td>{{ Carbon\Carbon::parse($coursecalendar->register_start_date)->format('d-M-yy h:i') }}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('Date Register end') }}</td>
                            <td>{{ Carbon\Carbon::parse($coursecalendar->register_end_date)->format('d-M-yy h:i') }}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('Date Meeting start') }}</td>
                            <td>{{ Carbon\Carbon::parse($coursecalendar->start_date)->format('d-M-yy h:i') }}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('Date Meeting end') }}</td>
                            <td>{{ Carbon\Carbon::parse($coursecalendar->end_date)->format('d-M-yy h:i') }}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('The cost') }}</td>
                            <td>{!! ($coursecalendar->price!=0) ? $coursecalendar->price .' '.__('THB') : '<span style="color: #fc740a">Free</span>' !!}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head"></td>
                            <td><img src="{!! user_photo($coursecalendar->users_id) !!}" class="rounded-circle" width="50"></td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('User Name') }}</td>
                            <td>{{ $coursecalendar->users_name }}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('User Email') }}</td>
                            <td>{{ $coursecalendar->email }}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('User Tell') }}</td>
                            <td>{{ $coursecalendar->tell }}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('User Address') }}</td>
                            <td>{{ $coursecalendar->address }}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                {!! Form::open(['method' => 'PUT','route' => ['coursecalendar.register_checkpayment', $coursecalendar->meeting_register_id],'style'=>'display:inline']) !!}
                    <div class="card">
                        <div class="card-header"><h3>{{ __('Payment File') }}</h3></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="open">{{ __('Confirm coursecalendar') }}</label>
                                        <div class="">
                                            {!! Form::checkbox('confirm_meeting', 'value', old('confirm_meeting', $coursecalendar->confirm_meeting), ['class' => 'js-dynamic-state']); !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php $link_file='/images/coursecalendar/'.$coursecalendar->id.'/'.$coursecalendar->file_payment;
                                    $file=public_path($link_file);
                                    $file_url=$link_file; ?>
                                @if (file_exists($file) and $coursecalendar->file_payment!=NULL)
                                <p class="fw-700 text-green">{{ __('Already upload payment') }}</p>
                                    <img src="{{ $file_url }}" alt="">
                                @else
                                <p class="fw-700 text-red">
                                    <i class="fa fa-exclamation"></i> {{ __('Not have file payment') }}
                                </p>
                                @endif
                                </div>
                                @if ($coursecalendar->note!=NULL)
                                <div class="form-group">
                                    <label for="exampleInputConfirmPassword1"><strong>{{ __('Note') }} :</strong></label>
                                    {{ $coursecalendar->note }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            {!! Form::hidden('back', $back, array('id'=>'back')) !!}
                            <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                            <a class="btn btn-dark" href="{{ route('coursecalendar.index') }}"> Back</a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('csspage')
<link rel="stylesheet" href="{!! asset('/plugins/summernote/summernote-0.8.16-dist/summernote.min.css') !!}">
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
<link rel="stylesheet" href="{!! asset('/css/dropzone.css') !!}">
<link rel="stylesheet" href="{!! asset('/css/dropzone_custom.css') !!}">
<link rel="stylesheet" href="{!! asset('/css/paperclip.css') !!}">
<link rel="stylesheet" href="{!! asset('/plugins/jquery-ui-1.12.1/jquery-ui.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/mohithg-switchery/dist/switchery.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/baguetteBox/css/baguetteBox.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('/plugins/sweetalert/dist/sweetalert.min.js') !!}"></script>
<script src="{!! asset('/plugins/summernote/summernote-0.8.16-dist/summernote.min.js') !!}"></script>
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script src="{!! asset('/js/dropzone.js') !!}"></script>
<script src="{!! asset('plugins/mohithg-switchery/dist/switchery.js') !!}"></script>
<script src="{!! asset('plugins/moment/moment.js') !!}"></script>
<script src="{!! asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<script src="{!! asset('plugins/baguetteBox/js/baguetteBox.js') !!}"></script>
<script>
    baguetteBox.run('.baguetteBox');
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-dynamic-state'));
elems.forEach(function(el) {
  var switchery = new Switchery(el);
  el.onchange = function(e) {
    if (($(this).attr('name')=='open_date') && ($(this).is(':checked'))) {
        $("#date .choose-date").show();
    } else {
        $("#date .choose-date").hide();
    }
  }
});

</script>
@endsection
