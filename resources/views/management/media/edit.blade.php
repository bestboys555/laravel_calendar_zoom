@extends('management.themekit.dashboard')
@section('pageTitle')
Edit {{ $results->name }}
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-file-text bg-blue"></i>
                    <div class="d-inline">
                        <h2>Edit</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('management') }}"><i class="ik ik-home"></i></a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('media.index') }}">Media Library</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
            <form class="forms-sample" action="{{ route('media.update',$results->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
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
                <a href="{{ url_file($results->id, $folder, $table_name, '') }}" target="_blank" class="d-block h-100">
                    <img class="img-fluid img-thumbnail" src="{{ url_file($results->id, $folder, $table_name, 'thumb_') }}" alt="">
                </a>
                @endif
                            <div class="form-group">
                                <label for="exampleInputTitle">Title <small class="color-red">*</small></label>
                                {!! Form::text('title', old('title', $results->title), array('id'=>'title','placeholder' => 'Title','class' => 'form-control','required' => 'required')) !!}
                            </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                        <a class="btn btn-dark" href="{{ route('media.index') }}"> Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('csspage')

@endsection
@section('scriptpage')

@endsection
