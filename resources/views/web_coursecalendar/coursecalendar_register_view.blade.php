@extends('indexmain')
@section('pageTitle'){!!$coursecalendar->name!!}@endsection
@section('content')
@php
$profile = App\User::find(Auth::id());
$status=status_meeting($coursecalendar->register_start_date, $coursecalendar->register_end_date);
@endphp
<div class="inner-container pad-top-lg pad-bot-lg  bg-white">
    <div class="row">
        <div class="col-sm-12 col-md-12 pr-0 pl-0">
            <h1 class="mb-4">{{ __('Register Course') }}</h1>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="25%" class="col_head">{{ __('Meeting') }}</td>
                        <td>{!!$coursecalendar->name!!}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="col_head">{{ __('View full detail') }}</td>
                        <td><a class="btn btn-success" href="{{ route('web.coursecalendar_data',$coursecalendar->id) }}"><i class="fa fa-eye"></i> {{ __('View full detail') }}</a></td>
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
                        <td width="25%" class="col_head">{{ __('Status') }}</td>
                        <td>@if ($coursecalendar->confirm_meeting==0)
                            <p class="fw-700 text-red">
                                <i class="fa fa-clock"></i> {{ __('Wait confirm') }}
                            </p>
                            @else
                            <p class="fw-700 text-green">
                                <i class="fa fa-check"></i> {{ __('Confirm') }}
                            </p>
                            @endif</td>
                    </tr>
                    @php
    if($zoom!=false){
    $endTime = \Carbon\Carbon::parse($zoom_data->start_time)->add('minute',$zoom_data->duration);
    $start_time=\Carbon\Carbon::parse($zoom_data->start_time);
    $time_now=\Carbon\Carbon::now();
@endphp
                        <tr>
                            <td width="25%" class="col_head">{{ __('Zoom Meeting') }}</td>
                            <td>
                                <p class="col-md-6 text-right"><b>{{ __('Start Date & Time video meeting') }}</b></p><p class="col-md-6 text-left">{{ $zoom_data->start_time }}</p>
                                @if(\Carbon\Carbon::parse($endTime) > $time_now and ($start_time < $time_now) )
                                    @if(($coursecalendar->confirm_meeting==1 and $coursecalendar->open_register==1) or ($coursecalendar->open_register==0))
                                    <div class="action-buttons">
                                        <a href="{{ $zoom_data->join_url }}" target="_blank" class="btn-primary btn">
                                            <i class="fa fa-video" aria-hidden="true"></i> Join
                                        </a>
                                    </div>
                                    @endif
                                @elseif($endTime < $time_now)
                                    <span class="red">
                                        Expire:{{ $start_time->diffForHumans() }}
                                    </span>
                                @else
                                    <div class="col-md-12">
                                        <div class="alert alert-info" role="alert">
                                            Metting Start in:{{(($start_time)->addMinutes($zoom_data->duration))->diffForHumans()}}
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
@php
                    }
@endphp
                </tbody>
            </table>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
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
                {!! Form::open(['method' => 'PUT','route' => ['web.register_upload_payment_coursecalendar', $coursecalendar->meeting_register_id],'style'=>'display:inline','enctype'=>'multipart/form-data']) !!}
                    <div class="card mb-4">
                        <div class="card-header"><h3>{{ __('Upload Payment') }}</h3></div>
                        <div class="card-body">
                            @if ($coursecalendar->payment_detail != '')
                            <div class="mb-4">{!!$coursecalendar->payment_detail!!}</div>
                            @endif
                            <div class="form-group">
                                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="file_upload" id="file_upload">
                            </div>
                            <div class="form-group">
                            <?php $link_file='/images/coursecalendar/'.$coursecalendar->id.'/'.$coursecalendar->file_payment;
                                $file=public_path($link_file);
                                $file_url=$link_file; ?>
                            @if (file_exists($file) and $coursecalendar->file_payment!=NULL)
                            <p class="fw-700 text-green">{{ __('Already upload payment') }}</p>
                                <img src="{{ $file_url }}" alt="">
                            @endif
                            </div>
                            <div class="form-group">
                                <label for="exampleInputConfirmPassword1">{{ __('Note') }}</label>
                                <textarea class="form-control" id="note" name="note" rows="4">{{ old('note', null) }}</textarea>
                            </div>
                        </div>
                    </div>
                    {!!
                    Form::button('Send payment file', array(
                                'type' => 'submit',
                                'class'=> 'btn btn-success btn-lg col-12',
                                'onclick'=>'return confirm("Are you sure register This Meeting?")'
                                ))
                    !!}
                {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('csspage')
@endsection
@section('scriptpage')
@endsection
