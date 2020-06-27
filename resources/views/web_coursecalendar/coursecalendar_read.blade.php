@extends('indexmain')
@section('pageTitle'){!!$coursecalendar->name!!}@endsection
@section('content')
@php
$status=status_meeting($coursecalendar->register_start_date, $coursecalendar->register_end_date);
$active_tab=0;
$active_detal=0;
@endphp
<div class="inner-container pad-top-lg pad-bot-lg  bg-white">
    <div class="row">
        <div class="col-sm-12 col-md-12 pr-0 pl-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('web.home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('web.coursecalendar', $coursecalendar->type_calendar) }}">{{ $coursecalendar->type_calendar }} {{ __('Calendar') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!!$coursecalendar->name!!}</li>
                </ol>
            </nav>
            <h1 class="mt-3">{!!$coursecalendar->name!!}@auth
                @canany(['coursecalendar-edit'])
                <a href="{{ route('coursecalendar.edit',$coursecalendar->id) }}" target="_blank" ><i class="fa fa-edit"></i></a>
                @endcan
            @endauth</h1>

            <p class="card-text" datetime="{{ $coursecalendar->created_at }}" title="{{ $coursecalendar->created_at }}"><small class="text-muted">{{ Carbon\Carbon::parse($coursecalendar->created_at)->diffForHumans()}}</small></p>

            @if($coursecalendar->location != null)
            <h3><span>{{ __('Location') }}</span></h3>
            <p class="card-text">{{ $coursecalendar->location }}</p>
            @endif
            @if($coursecalendar->target_audience != null)
            <h3><span>{{ __('Target Audience') }}</span></span></h3>
            <p class="card-text">{{ $coursecalendar->target_audience }}</p>
            @endif
            @if($coursecalendar->course_director != null)
            <h3><span>{{ __('Course Director') }}</span></h3>
            <p class="card-text">{{ $coursecalendar->course_director }}</p>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @if ($coursecalendar->detail != '')
                @php
                $active_tab++;
                @endphp
                <li class="nav-item">
                <a class="nav-link {{ ($active_tab == 1) ? 'active' : '' }}" id="detail_t-tab" data-toggle="tab" href="#detail_t" role="tab" aria-controls="detail_t" aria-selected="true">{{ __('General Information') }}</a>
                </li>
                @endif
                @if ($coursecalendar->faqs != '')
                @php
                $active_tab++;
                @endphp
                <li class="nav-item">
                <a class="nav-link {{ ($active_tab == 1) ? 'active' : '' }}" id="faqs_t-tab" data-toggle="tab" href="#faqs_t" role="tab" aria-controls="faqs_t" aria-selected="false">{{ __('FAQs') }}</a>
                </li>
                @endif
                @if ($coursecalendar->accommodation != '')
                @php
                $active_tab++;
                @endphp
                <li class="nav-item">
                <a class="nav-link {{ ($active_tab == 1) ? 'active' : '' }}" id="accommodation_t-tab" data-toggle="tab" href="#accommodation_t" role="tab" aria-controls="accommodation_t" aria-selected="false">{{ __('Accommodation') }}</a>
                </li>
                @endif
                @if ($coursecalendar->payment_detail != '')
                @php
                $active_tab++;
                @endphp
                <li class="nav-item">
                <a class="nav-link {{ ($active_tab == 1) ? 'active' : '' }}" id="payment_detail_t-tab" data-toggle="tab" href="#payment_detail_t" role="tab" aria-controls="payment_detail_t" aria-selected="false">{{ __('Payment detail') }}</a>
                </li>
                @endif
            </ul>
            <div class="tab-content mb-4" id="myTabContent">
                @if ($coursecalendar->detail != '')
                @php
                $active_detal++;
                @endphp
                <div class="tab-pane fade {{ ($active_detal == 1) ? 'show active' : '' }}" id="detail_t" role="tabpanel" aria-labelledby="detail_t-tab">
                    {!!$coursecalendar->detail!!}
                </div>
                @endif
                @if ($coursecalendar->faqs != '')
                @php
                $active_detal++;
                @endphp
                <div class="tab-pane fade {{ ($active_detal == 1) ? 'show active' : '' }}" id="faqs_t" role="tabpanel" aria-labelledby="faqs_t-tab">
                    {!!$coursecalendar->faqs!!}
                </div>
                @endif
                @if ($coursecalendar->accommodation != '')
                @php
                $active_detal++;
                @endphp
                <div class="tab-pane fade {{ ($active_detal == 1) ? 'show active' : '' }}" id="accommodation_t" role="tabpanel" aria-labelledby="accommodation_t-tab">
                    {!!$coursecalendar->accommodation!!}
                </div>
                @endif
                @if ($coursecalendar->payment_detail != '')
                @php
                $active_detal++;
                @endphp
                <div class="tab-pane fade {{ ($active_detal == 1) ? 'show active' : '' }}" id="payment_detail_t" role="tabpanel" aria-labelledby="payment_detail_t-tab">
                    {!!$coursecalendar->payment_detail!!}
                </div>
                @endif
            </div>
            @if($coursecalendar->open_register=='1')
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td width="25%" class="col_head">{{ __('Date Register start') }}</td>
                            <td>{{ Carbon\Carbon::parse($coursecalendar->register_start_date)->format('d-M-yy h:i')}}</td>
                        </tr>
                        <tr>
                            <td width="25%" class="col_head">{{ __('Date Register end') }}</td>
                            <td>{{ Carbon\Carbon::parse($coursecalendar->register_end_date)->format('d-M-yy h:i')}}</td>
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
                        @if ($coursecalendar->open_zoom==1)
                        <tr>
                            <td width="25%" class="col_head">{{ __('Zoom Meeting') }}</td>
                            <td><i class="fa fa-check"></i></td>
                        </tr>
                        @endif
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
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
                @if ($status==true)
                @php
                $count_register=0;
                if($coursecalendar_register){
                    $count_register = $coursecalendar_register->count();
                }
                @endphp
                    @if ($count_register==0)
                        @if ($coursecalendar->register_count<$coursecalendar->number_participants)
                        <a class="btn btn-success btn-lg col-12" href="{{ route('web.register_coursecalendar',$coursecalendar->id) }}" role="button">{{ __('Register This Meeting') }}</a>
                        @else
                        <div class="alert alert-warning text-center" role="alert">
                            {{ __('Full registration!') }}
                        </div>
                        @endif
                    @else
                    <div class="alert alert-primary text-center" role="alert">
                        {{ __('You have already registered.') }} <a href="{{ route('web.register_coursecalendar_view',$coursecalendar_register->id) }}" role="button"><i class="fa fa-search"></i>{{ __('View') }}</a>
                    </div>
                    @endif
                @else
                    <div class="alert alert-warning text-center" role="alert">
                        {{ __('Not in the registration period!') }}
                    </div>
                @endif
            @endif
            @if (count($documents)!=0)
            <div class="mt-4">
                <div class="row">
                    @foreach ($documents as $document)
                    <?php $file=public_path('/images/coursecalendar/'.$document->folder.'/'.$document->name); ?>
                    <div class="col-md-4">
                        <div class="document mb-4">
                            <a href="{{ url_file($document->id, $coursecalendar->id, 'coursecalendar','') }}" target="_blank" title="{{ $document->title }}">
                                <div class="document-body">{!! get_extenstion($file) !!}</div>
                                <div class="document-footer">
                                        <span class="document-name"> {{ $document->title }} </span>
                                        <span class="document-description"> {{ get_file_size($file) }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @if (count($pictures)!=0)
            <div class="row baguetteBox">
                <div class="row no-bg no-border">
                    @foreach ($pictures as $picture)
                    <div class="col-md-3">
                        <a href="{{ url_file($picture->id, $coursecalendar->id, 'coursecalendar', "") }}" class="d-block mb-4 h-100">
                            <img class="img-fluid img-thumbnail" src="{{ url_file($picture->id, $coursecalendar->id, 'coursecalendar', "thumb_") }}" alt="">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('csspage')
<link rel="stylesheet" href="{!! asset('plugins/fontawesome/css/all.min.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/baguetteBox/css/baguetteBox.css') !!}">
<link rel="stylesheet" href="{!! asset('css/document_list.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('plugins/baguetteBox/js/baguetteBox.js') !!}"></script>
<script>
    baguetteBox.run('.baguetteBox');
</script>
@endsection
