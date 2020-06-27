@extends('management.themekit.dashboard')
@section('pageTitle')View Data {{ $results->title }}@endsection

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
                    <li class="breadcrumb-item active"><a href="{{ route('media.index') }}">News Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Data</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

    <div class="row">
        <div class="card col-md-12">
            <div class="card-footer text-right">
                <a class="btn btn-dark" href="{{ route('media.index') }}"> Back</a>
            </div>
            <div class="card-body">
                @php
                $file_name=$results->name;
                $file_extension=end_extenstion($file_name);
                $table_name=$results->table_name;
                $folder=$results->folder;
                $file_part='/images';
                    if($table_name!=NULL){
                        $file_part.="/".$table_name;
                    }
                    if($folder!=NULL){
                        $file_part.="/".$folder;
                    }
                    if($file_name!=NULL){
                        $file_part.="/".$file_name;
                    }
                    $full_url =env('APP_URL').$file_part.$file_name;
                $file=public_path($file_part);
                @endphp
                @if ($file_extension=='doc' or $file_extension=='docx' or $file_extension=='xls' or $file_extension=='xlsx' or $file_extension=='pdf')
                <div class="document">
                    <a href="{{ url_file($results->id, $folder, $table_name, '') }}" target="_blank" title="{{ $results->title }}">
                        <div class="document-body">{!! get_extenstion($file_name) !!}</div>
                        <div class="document-footer">
                                <span class="document-name"> {{ $results->title }} </span>
                                <span class="document-description"> {{ get_file_size($file) }}</span>
                        </div>
                    </a>
                </div>
                @else
                <a href="{{ url_file($results->id, $folder, $table_name, '') }}" class="d-block h-100">
                    <img class="img-fluid img-thumbnail" src="{{ url_file($results->id, $folder, $table_name, 'thumb_') }}" alt="">
                </a>
                @endif

                <p>
                    <div class="input-group">
                        <input type="text" class="form-control" value="{!! $full_url !!}" id="url">
                        <div class="input-group-append">
                            <a class="btn btn-success mr-3" onclick="myFunction()">copy</a>
                        </div>
                      </div>
                </p>
            </div>
        </div>
    </div>
@endsection
@section('csspage')
@endsection
@section('scriptpage')
<script>
    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("url");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        alert("Copied the text: " + copyText.value);
      }
</script>
@endsection
