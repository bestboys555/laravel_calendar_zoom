@extends('management.themekit.dashboard')
@section('pageTitle'){{ __('Check Payment') }}@endsection

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-12">
            <div class="page-header-title">
                <i class="ik ik-eye bg-blue"></i>
                <div class="d-inline">
                    <h2>{{ __('Check Payment') }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-block">
            </div>
            <div class="card-body p-0 table-border-style">
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>{{ __('Name') }}</th>
                            <th width="25%">{{ __('Training name') }}</th>
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
                            <td align="left">{{ $value->meeting_name }}</td>
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
                                <a class="btn btn-success mr-2" href="{{ route('coursecalendar.register_coursecalendar_view',[$value->meeting_register_id, 'notificat']) }}"><i class="fa fa-eye"></i> {{ __('View Payment') }}</a>
                                <a class="btn btn-icon btn-outline-danger" href="{{ route('coursecalendar.destroy_register',$value->meeting_register_id) }}" onclick="return confirm('{{ __('Are you sure Delete?') }}')"><i class="ik ik-trash-2"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
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
