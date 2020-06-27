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
            <div class="card-footer text-right">
                <a class="btn btn-primary" href="{{ route('coursecalendar.export_excel',$coursecalendar->id) }}"> Export to Excel</a>
                <a class="btn btn-dark" href="{{ route('coursecalendar.index') }}"> Back</a>
            </div>
            @if ($message = Session::get('success'))
                <div class="card-header d-block pt-0">
                    <div class="alert alert-success mt-2 mb-0">{{ $message }}</div>
                </div>
            @endif
            <div class="card-body pt-0">
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
                            <td width="25%" class="col_head">{{ __('Register') }}</td>
                            <td>{{ $coursecalendar->register_count }} / {{ $coursecalendar->number_participants }}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('The cost') }}</td>
                            <td>{!! ($coursecalendar->price!=0) ? $coursecalendar->price .' '.__('THB') : '<span style="color: #fc740a">Free</span>' !!}</td>
                        </tr>
                    </tbody>
                  </table>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Tell') }}</th>
                            <th>{{ __('Send Payment') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i=0;
                        @endphp
                        @foreach ($coursecalendar_register as $value)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td align="left"><img src="{!! user_photo($value->users_id) !!}" class="rounded-circle" width="50"></td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->tell }}</td>
                            <td align="left">
                                @if ($value->file_payment!=NULL)
                                <p class="fw-700 text-green">
                                    <i class="fa fa-check"></i> {{ __('Yes') }}
                                </p>
                                @endif</td>
                            <td align="left">@if ($value->confirm_meeting==0)
                                <p class="fw-700 text-red">
                                    <i class="fa fa-clock"></i> {{ __('Wait confirm') }}
                                </p>
                                @else
                                <p class="fw-700 text-green">
                                    <i class="fa fa-check"></i> {{ __('Confirm') }}
                                </p>
                                @endif</td>
                            <td>
                                <a class="btn btn-success mr-2" href="{{ route('coursecalendar.register_coursecalendar_view', [$value->meeting_register_id, 'list']) }}"><i class="fa fa-eye"></i> {{ __('View Payment') }}</a>
                                <a class="btn btn-icon btn-outline-danger" href="{{ route('coursecalendar.destroy_register',$value->meeting_register_id) }}" onclick="return confirm('{{ __('Are you sure Delete?') }}')"><i class="ik ik-trash-2"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('csspage')
<link rel="stylesheet" href="{!! asset('plugins/baguetteBox/css/baguetteBox.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('plugins/baguetteBox/js/baguetteBox.js') !!}"></script>
<script>
    baguetteBox.run('.baguetteBox');
</script>
@endsection
