@extends('indexmain')
@section('pageTitle'){{ $type_calendar }} {{ __('Calendar') }}@stop
@section('content')
<div class="inner-container pad-top-lg pad-bot-lg  bg-white">
    <div class="row">
        <div class="col-sm-12 col-md-12 pr-0 pl-0">
            <h1 class="title-primary">{{ $type_calendar }} {{ __('Calendar') }}</h1>
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
            @foreach ($coursecalendar as $value)
            @php
            $status_show="";
                $show= __('Read More');
                if($value->open_register=='1'){
                    $show= __('Read More / Register');
                    $status=status_meeting($value->register_start_date, $value->register_end_date);
                    if ($status==false){
                        $status_show='<i class="fa fa-info-circle"></i> '.__('Not in the registration period!');
                    }else if($value->register_count>=$value->number_participants){
                        $status_show=__('Full registration!');
                    }
                }
            @endphp
            <div class="card mb-3 w-100">
                <div class="row ">
                    <div class="col-md-4 mr-0 event-left">
                        <h2 style="background-color:#1a1a72">
                        <div id="Nov" class="Nov eventkk"> {{ Carbon\Carbon::parse($value->start_date)->format('d M h:i')}} - {{ Carbon\Carbon::parse($value->end_date)->format('d M h:i')}}</div>
                        @if($value->location != null)
                        <p>{{ $value->location }}</p>
                        @endif
                        </h2>
                        <a href="{{ route('web.coursecalendar_data',$value->id) }}"><img src="{!! cover_picture($value->id,'coursecalendar') !!}" alt="{{ $value->name }}" class="w-100"></a>
                    </div>
                    <div class="col-md-8 event-right">
                      <div class="card-block px-3 mt-2 mb-2">
                        <h4 class="card-title">{{ $value->name }}</h4>
                        @if($value->location != null)
                        <h3><span>{{ __('Location') }}</span></h3>
                        <p class="card-text">{{ $value->location }}</p>
                        @endif
                        @if($value->target_audience != null)
                        <h3><span>{{ __('Target Audience') }}</span></span></h3>
                        <p class="card-text">{{ $value->target_audience }}</p>
                        @endif
                        @if($value->course_director != null)
                        <h3><span>{{ __('Course Director') }}</span></h3>
                        <p class="card-text">{{ $value->course_director }}</p>
                        @endif
                        @if($value->open_register=='1')
                        <h3><span>{{ __('Register') }}</span></h3>
                        <p class="card-text">{{ $value->register_count }} / {{ $value->number_participants }}</p>
                        <p class="card-text">{!! $status_show !!}</p>
                        @endif
                        @if ($value->open_zoom==1)
                        <h3><span><i class="fa fa-check"></i> {{ __('Zoom Meeting') }}</span></h3>
                        @endif
                        <a href="{{ route('web.coursecalendar_data',$value->id) }}" class="btn btn-primary mt-2">{{ $show }}</a>
                      </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-md-12 pt-2 pl-0 pr-0">
            {!! $coursecalendar->links() !!}
            </div>
        </div>
        <div id="calendar" class="col-md-12"></div>
    </div>
</div>
@endsection
@section('csspage')
<link rel="stylesheet" href="{!! asset('css/calendar.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/fullcalendar-4.1.0/packages/core/main.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/fullcalendar-4.1.0/packages/daygrid/main.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/fullcalendar-4.1.0/packages/timegrid/main.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/fullcalendar-4.1.0/packages/list/main.css') !!}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('scriptpage')
<script src="{!! asset('plugins/fullcalendar-4.1.0/packages/core/main.js') !!}"></script>
<script src="{!! asset('plugins/fullcalendar-4.1.0/packages/interaction/main.js') !!}"></script>
<script src="{!! asset('plugins/fullcalendar-4.1.0/packages/daygrid/main.js') !!}"></script>
<script src="{!! asset('plugins/fullcalendar-4.1.0/packages/timegrid/main.js') !!}"></script>
<script src="{!! asset('plugins/fullcalendar-4.1.0/packages/list/main.js') !!}"></script>
<script src="{!! asset('plugins/tooltip/tooltip.min.js') !!}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        height: 'auto',
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
      locale: 'en',
        defaultDate: '{{ Carbon\Carbon::now()->format('Y-m-d')}}',
        nextDayThreshold : "00:00:01",
        weekNumbers: false,
        weekNumberCalculation: 'ISO',
        editable: false,
        navLinks: true, // can click day/week names to navigate views
        eventLimit: true, // allow "more" link when too many events
        events: function (info, successCallback, failureCallback) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    start: moment(info.start.valueOf()).format('YYYY-MM-DD'),
                    end: moment(info.end.valueOf()).format('YYYY-MM-DD'),
                    type_calendar: '{{ $type_calendar }}',
                    },
                url: "{{ route('web.get_events') }}",
                type: 'GET',
                success: function (response) {
                        successCallback(response);
                }
            });
        },
        timeFormat: 'H:mm',
          eventRender: function(info) {
          var tooltip = new Tooltip(info.el, {
            title: info.event.title,
            placement: 'top',
            trigger: 'hover',
            container: 'body'
          });
        },
          eventClick: function(info) {
            var url=info.event.url + "/" + info.event.id;
              info.jsEvent.preventDefault(); // don't let the browser navigate
              if (info.event.url) {
                  window.open(url, "_parent");
              }
        }
      });
      calendar.render();
    });
  </script>
@endsection
