@extends('indexmain')
@section('pageTitle'){{ __('Zoom meeting') }}@stop
@section('content')
<div class="inner-container pad-top-lg pad-bot-lg  bg-white">
    <div class="row">
        <div class="col-sm-12 col-md-12 pr-0 pl-0">
            <h1 class="title-primary">{{ __('Zoom meeting') }}</h1>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger text-center">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="350">{{ __('Training name') }}</th>
                        <th>{{ __('Training start') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meeting as $meeting_value)
                    @php
                    $link_show = route('web.coursecalendar_data',$meeting_value->id);
                    if($zoom!=false){
                    $endTime = \Carbon\Carbon::parse($meeting_value->start_time)->add('minute',$meeting_value->duration);
                    $start_time=\Carbon\Carbon::parse($meeting_value->start_time);
                    $time_now=\Carbon\Carbon::now();
                    @endphp
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td align="left"><a href="{{ $link_show }}">{{ $meeting_value->name }}</a></td>
                        <td align="left">{{ Carbon\Carbon::parse($meeting_value->start_time)}}</td>
                        <td align="left">@if(\Carbon\Carbon::parse($endTime) > $time_now and ($start_time < $time_now) )
                            <div class="action-buttons">
                                <a href="{{ $meeting_value->join_url }}" target="_blank" class="btn-primary btn">
                                    <i class="fa fa-video" aria-hidden="true"></i> Join
                                </a>
                            </div>
                        @elseif($endTime < $time_now)
                            <span class="red">
                                Expire:{{ $start_time->diffForHumans() }}
                            </span>
                        @else
                            <div class="alert alert-info" role="alert">
                                Metting Start in:{{(($start_time)->addMinutes($meeting_value->duration))->diffForHumans()}}
                            </div>
                        @endif</td>
                    </tr>
                        @php
                        }
                        @endphp
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="col-md-12 pt-2 pl-0 pr-0">
            {!! $meeting->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('csspage')

@endsection
@section('scriptpage')

@endsection
