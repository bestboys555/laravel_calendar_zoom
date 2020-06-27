@extends('indexmain')
@php
    $generalsetting = \App\GeneralSetting::first();
@endphp
@section('pageTitle'){{ $generalsetting->site_name }}@stop
@section('meta')
@if($generalsetting->meta_description != null)
<meta name="description" content="{{ $generalsetting->meta_description }}" />
@endif
@if($generalsetting->meta_keyword != null)
<meta name="keywords" content="{{ $generalsetting->meta_keyword }}">
@endif
@if($generalsetting->meta_author != null)
<meta name="author" content="{{ $generalsetting->meta_author }}">
@endif
@endsection
@section('content')
<div class="wrapper pad-top-lg pad-bot-lg">
    <div class="inner-container">
        <div class="row">
            <div class="col-sm-12 col-md-12 mt-4">
                <div class="card-deck">
                    @foreach ($news as $news_value)
                    @php
                        if($news_value->table_name=='news'){
                            $link = route('web.show',$news_value->id);
                        }else if($news_value->table_name=='meeting'){
                            $link = route('web.meeting_data',$news_value->id);
                        }else if($news_value->table_name=='coursecalendar'){
                            $link = route('web.coursecalendar_data',$news_value->id);
                        }
                    @endphp
                    <div class="card col-md-4 pr-0 pl-0">
                        <a href="{{ $link }}" title="{{ $news_value->name }}"><img src="{!! cover_picture($news_value->id,$news_value->table_name) !!}" class="card-img-top" alt="{{ $news_value->name }}"></a>
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ $link }}" title="{{ $news_value->name }}">{{ $news_value->name }}</a></h5>
                            <p class="card-text"><small class="text-muted">{{ Carbon\Carbon::parse($news_value->created_at)->diffForHumans()}}</small></p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('csspage')
<link rel="stylesheet" href="{!! asset('css/home.css') !!}">
<link rel="stylesheet" href="{!! asset('plugins/FullWidthImageSlider/css/component.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('plugins/FullWidthImageSlider/js/modernizr.custom.js') !!}"></script>
<script src="{!! asset('plugins/FullWidthImageSlider/js/jquery.cbpFWSlider.min.js') !!}"></script>
<script>
    $( function() {
        $( '#cbp-fwslider' ).cbpFWSlider();
    } );
</script>
@endsection
