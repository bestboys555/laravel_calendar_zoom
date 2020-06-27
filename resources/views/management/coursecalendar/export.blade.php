<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="50"></th>
            <th width="50"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>{{ __('Training name') }}</strong></td>
            <td><strong>{!!$coursecalendar->name!!}</strong></td>
        </tr>
        <tr>
            <td><strong>{{ __('Date Register start') }}</strong></td>
            <td>{{ Carbon\Carbon::parse($coursecalendar->register_start_date)}}</td>
        </tr>
        <tr>
            <td><strong>{{ __('Date Register end') }}</strong></td>
            <td>{{ Carbon\Carbon::parse($coursecalendar->register_end_date)}}</td>
        </tr>
        <tr>
            <td><strong>{{ __('Date Meeting start') }}</strong></td>
            <td>{{ Carbon\Carbon::parse($coursecalendar->meeting_start_date)}}</td>
        </tr>
        <tr>
            <td><strong>{{ __('Date Meeting end') }}</strong></td>
            <td>{{ Carbon\Carbon::parse($coursecalendar->meeting_end_date)}}</td>
        </tr>
        <tr>
            <td><strong>{{ __('Register') }}</strong></td>
            <td>{{ $coursecalendar->register_count }} / {{ $coursecalendar->number_participants }}</td>
        </tr>
        <tr>
            <td><strong>{{ __('The cost') }}</strong></td>
            <td>{!! ($coursecalendar->price!=0) ? $coursecalendar->price .' '.__('THB') : '<span style="color: #fc740a">Free</span>' !!}</td>
        </tr>
    </tbody>
  </table>
<table class="table table-striped">
    <thead>
        <tr>
            <th width="30">#</th>
            {{--  <th></th>  --}}
            <th width="30"><strong>{{ __('Name') }}</strong></th>
            <th width="30"><strong>{{ __('Email') }}</strong></th>
            <th width="30"><strong>{{ __('Tell') }}</strong></th>
            <th width="30"><strong>{{ __('Address') }}</strong></th>
            <th width="20"><strong>{{ __('Send Payment') }}</strong></th>
            <th width="20"><strong>{{ __('Status') }}</strong></th>
        </tr>
    </thead>
    <tbody>
        @php
        $i=0;
        @endphp
        @foreach ($coursecalendar_register as $register_value)
        <tr>
            <td>{{ ++$i }}</td>
            {{--  <td align="left"><img src="{!! user_photo($register_value->users_id) !!}" class="rounded-circle" width="50"></td>  --}}
            <td>{{ $register_value->name }}</td>
            <td>{{ $register_value->email }}</td>
            <td>{{ $register_value->tell }}</td>
            <td>{{ $register_value->address }}</td>
            <td align="left">
                @if ($register_value->file_payment!=NULL)
                {{ __('Yes') }}
                @endif</td>
            <td align="left">@if ($register_value->confirm_meeting==0)
                {{ __('Wait confirm') }}
                @else
                {{ __('Confirm') }}
                @endif</td>
        </tr>
        @endforeach
    </tbody>
</table>
