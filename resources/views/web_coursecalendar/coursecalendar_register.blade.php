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
                        <td width="25%" class="col_head">{{ __('Date Register start') }}</td>
                        <td>{{ Carbon\Carbon::parse($coursecalendar->register_start_date)->format('d-M-yy h:i') }}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="col_head">{{ __('Date Register end') }}</td>
                        <td>{{ Carbon\Carbon::parse($coursecalendar->register_end_date)->format('d-M-yy h:i') }}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="col_head">{{ __('Date start') }}</td>
                        <td>{{ Carbon\Carbon::parse($coursecalendar->start_date)->format('d-M-yy h:i') }}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="col_head">{{ __('Date end') }}</td>
                        <td>{{ Carbon\Carbon::parse($coursecalendar->end_date)->format('d-M-yy h:i') }}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="col_head">{{ __('Register') }}</td>
                        <td>{{ $coursecalendar->register_count }} / {{ $coursecalendar->number_participants }}</td>
                    </tr>
                    <tr>
                        <td width="25%" class="col_head">{{ __('The cost') }}</td>
                        <td>{!! ($coursecalendar->price!=0) ? $coursecalendar->price .' '.__('THB') : '<span style="color: #fc740a">Free</span>' !!}</td>
                    </tr>
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
            @if ($status==true)
                @if ($count_register==0)
                    @if ($coursecalendar->register_count<$coursecalendar->number_participants)
                        {!! Form::open(['method' => 'PUT','route' => ['web.register_coursecalendar_confirm', $coursecalendar->id],'style'=>'display:inline']) !!}
                            <div class="card mb-4">
                                <div class="card-header"><h3>{{ __('Contact infomation') }}</h3></div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('Your telephone') }}</label>
                                        <input class="form-control @error('tell') is-invalid @enderror" type="text" placeholder="{{ __('Your telephone') }}" name="tell" id="tell"  value="{{ old('tell', $profile->tell) }}">
                                        @error('tell')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputConfirmPassword1">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="4">{{ old('address', $profile->address) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            {!!
                            Form::button('Confirm register This Meeting', array(
                                        'type' => 'submit',
                                        'class'=> 'btn btn-success btn-lg col-12',
                                        'onclick'=>'return confirm("Are you sure register This Meeting?")'
                                        ))
                            !!}
                        {!! Form::close() !!}
                    @else
                    <div class="alert alert-warning text-center" role="alert">
                        {{ __('Full registration!') }}
                    </div>
                    @endif
                @else
                <div class="alert alert-warning text-center" role="alert">
                    {{ __('You have already registered.') }}
                </div>
                @endif
            @else
                <div class="alert alert-warning text-center" role="alert">
                    {{ __('Not in the registration period!') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('csspage')
@endsection
@section('scriptpage')
@endsection
