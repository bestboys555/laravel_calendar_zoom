@extends('indexmain')
@section('pageTitle'){{ __('List your Meeting') }}@stop
@section('content')
<div class="inner-container pad-top-lg pad-bot-lg  bg-white">
    <div class="row">
        <div class="col-sm-12 col-md-12 pr-0 pl-0">
            <h1 class="title-primary">{{ __('List your Meeting') }}</h1>
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
                        <th>{{ __('Training end') }}</th>
                        <th></th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meeting as $meeting_value)
                    @php
                    $status=status_meeting($meeting_value->register_start_date, $meeting_value->register_end_date);
                    $link_show = route('web.coursecalendar_data',$meeting_value->id);
                    $link_register = route('web.register_coursecalendar_view',$meeting_value->meeting_register_id);
                    @endphp
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td align="left"><a href="{{ $link_show }}">{{ $meeting_value->name }}</a></td>
                        <td align="left">{{ Carbon\Carbon::parse($meeting_value->meeting_start_date)}}</td>
                        <td align="left">{{ Carbon\Carbon::parse($meeting_value->meeting_start_end)}}</td>
                        <td align="left"><a class="btn btn-success" href="{{ $link_register }}"><i class="fa fa-eye"></i> {{ __('View') }}</a></td>
                        <td align="left">@if ($meeting_value->confirm_meeting==0)
                            <p class="fw-700 text-red">
                                <i class="fa fa-clock"></i> {{ __('Wait confirm') }}
                            </p>
                            @else
                            <p class="fw-700 text-green">
                                <i class="fa fa-check"></i> {{ __('Confirm') }}
                            </p>
                            @endif</td>
                    </tr>
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
