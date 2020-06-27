@extends('management.themekit.dashboard')
@section('pageTitle')View Data {{ $coursecalendar->name }}@endsection

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-eye bg-blue"></i>
                <div class="d-inline">
                    <h2>View Data</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('management') }}"><i class="ik ik-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('coursecalendar.index') }}">News Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Data</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <div class="row">
        <div class="card">
            <div class="card-footer text-right pb-0">
                <a class="btn btn-dark" href="{{ route('coursecalendar.index') }}"> Back</a>
            </div>
            <div class="card-body pt-0">
                <h1 class="mt-3">{!!$coursecalendar->name!!}</h1>
                @php
                $status=status_meeting($coursecalendar->register_start_date, $coursecalendar->register_end_date);
                $active_tab=0;
                $active_detal=0;
                @endphp
                <p class="card-text" datetime="{{ $coursecalendar->created_at }}" title="{{ $coursecalendar->created_at }}"><small class="text-muted">{{ Carbon\Carbon::parse($coursecalendar->created_at)->diffForHumans()}}</small></p>

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
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td width="25%" class="col_head">{{ __('Training name') }}</td>
                            <td></td>
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
<link rel="stylesheet" href="{!! asset('plugins/baguetteBox/css/baguetteBox.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('plugins/baguetteBox/js/baguetteBox.js') !!}"></script>
<script>
    baguetteBox.run('.baguetteBox');
</script>
@endsection
