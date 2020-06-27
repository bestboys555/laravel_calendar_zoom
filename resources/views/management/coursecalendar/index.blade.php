@extends('management.themekit.dashboard')
@section('pageTitle'){{ __('Calendar') }}@stop

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-edit bg-blue"></i>
                <div class="d-inline">
                    <h2>{{ __('Calendar') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('management') }}"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active"><a href="{{ route('coursecalendar.index') }}">{{ __('Calendar') }}</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-md-3"><div class="text-left">
                            {!! Form::open(array('route' => 'coursecalendar.search','method'=>'post')) !!}
                            @csrf
                            <div class="input-group">
                                {!! Form::text('search', old('search', null), array('id'=>'name','placeholder' => 'Search text','class' => 'form-control')) !!}
                                <div class="input-group-append">
                                  <button class="btn btn-outline-secondary" type="submit"><i class="ik ik-search"></i> {{ __('Search') }}</button>
                                </div>
                              </div>
                              {!! Form::close() !!}
                        </div></div>
                        <div class="col-md-9">@can('coursecalendar-create')
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('coursecalendar.create') }}"> {{ __('Create Calendar') }}</a>
                            </div>
                            @endcan</div>
                    </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2 mb-0">{{ $message }}</div>
                @endif
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive">
                        <table class="table table-inverse table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Type Calendar') }}</th>
                                    <th>{{ __('Training start') }}</th>
                                    <th>{{ __('New register') }}</th>
                                    <th>{{ __('Show index') }}</th>
                                    <th>{{ __('Open register') }}</th>
                                    <th>{{ __('Zoom Meeting') }}</th>
                                    <th>{{ __('checkpayment') }}</th>
                                    <th width="350px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coursecalendar as $meeting_value)
                                @php
                                $count_meeting_register= get_table_all('coursecalendar_register')
                                ->where('coursecalendar_id', $meeting_value->id)
                                ->where('confirm_meeting', '0')
                                ->count();
                                @endphp
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $meeting_value->name }}</td>
                                    <td>{{ $meeting_value->type_calendar }}</td>
                                    <td align="left">{{ Carbon\Carbon::parse($meeting_value->start_date)}}</td>
                                    <td>@if ($count_meeting_register>0)
                                        <span class="badge badge-pill badge-danger mb-1">{{ $count_meeting_register }}</span>
                                        @endif
                                    </td>
                                    <td>{!! ($meeting_value->show_index==1) ? '<i class="ik ik-check"></i>' : '' !!}</td>
                                    <td>{!! ($meeting_value->open_register==1) ? '<i class="ik ik-check"></i>' : '' !!}</td>
                                    <td>{!! ($meeting_value->open_zoom==1) ? '<i class="ik ik-check"></i>' : '' !!}</td>
                                    <td>@if ($meeting_value->open_register==1)
                                        @can('coursecalendar-checkpayment')
                                        <a class="btn btn-outline-success mr-3" href="{{ route('coursecalendar.show_payment',$meeting_value->id) }}"><i class="ik ik-eye"></i> {{ __('Check Payment') }}</a>
                                        @endcan
                                        @endif</td>
                                    <td>
                                        <a class="btn btn-icon btn-outline-success mr-3" href="{{ route('coursecalendar.show',$meeting_value->id) }}"><i class="ik ik-eye"></i></a>
                                        @can('coursecalendar-edit')
                                        <a class="btn btn-icon btn-outline-primary mr-3" href="{{ route('coursecalendar.edit',$meeting_value->id) }}"><i class="ik ik-edit-2"></i></a>
                                        @endcan
                                        @can('coursecalendar-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['coursecalendar.destroy', $meeting_value->id],'style'=>'display:inline']) !!}
                                        {!!
                                        Form::button('<i class="ik ik-trash-2"></i>', array(
                                                    'type' => 'submit',
                                                    'class'=> 'btn btn-icon btn-outline-danger',
                                                    'onclick'=>'return confirm("'.__('Are you sure Delete?').'")'))
                                        !!}
                                        {!! Form::close() !!}
                                        @endcan
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
    {!! $coursecalendar->links() !!}
@endsection
@section('csspage')
{{-- <link rel="stylesheet" href="{!! asset('css/easyTree.css') !!}"> --}}
@endsection
@section('scriptpage')
{{-- <script>$( function() {
    $("#treeview").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings';
			$.post("ajax_file/article_updaterows.php", order, function(theResponse){
			});
		}
		});
  });</script> --}}
@endsection
