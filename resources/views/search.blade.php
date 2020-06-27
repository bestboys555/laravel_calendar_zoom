@extends('indexmain')
@section('pageTitle'){{ __('Search') }}@stop
@section('content')
<div class="inner-container pad-top-lg pad-bot-lg bg-white">
    <div class="row">
        <div class="col-sm-12 col-md-12 pr-0 pl-0">
            <h1 class="title-primary">{{ __('Search') }}</h1>
            @foreach ($news as $value)
            @php
                if($value->table_name=='coursecalendar'){
                    $link = route('web.coursecalendar_data',$value->id);
                }
                $detail = iconv_substr(str_replace("&nbsp;", '', strip_tags(stripcslashes($value->detail))),0,300,"UTF-8");
                $images = cover_picture_returnfalse($value->id,$value->table_name);
            @endphp
            <div class="mb-3 w-100">
                <div class="row ">
                    @if($images != false)
                    <div class="col-md-2 mr-0 event-left">
                        <a href="{!! $link !!}"><img src="{!! $images !!}" class="w-100" alt="{{ $value->name }}"></a>
                    </div>
                    @endif
                    <div class="{{ ($images != false) ? 'col-md-10 event-right' : 'col-md-12' }}">
                      <div class="card-block px-3 mt-2 mb-2">
                        <h4> <a href="{!! $link !!}">{{ $value->name }}</a></h4>
                        <p class="card-text" datetime="{{ $value->created_at }}" title="{{ $value->created_at }}"><small class="text-muted">{{ Carbon\Carbon::parse($value->created_at)->diffForHumans()}}</small></p>
                        <p class="card-text">{{ $detail }}</p>
                      </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-md-12 pt-2 pl-0 pr-0">
                {!! $news->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('csspage')

@endsection
@section('scriptpage')

@endsection
