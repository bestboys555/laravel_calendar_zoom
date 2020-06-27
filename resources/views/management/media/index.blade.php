@extends('management.themekit.dashboard')

@section('pageTitle')
Media Library
@endsection

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-edit bg-blue"></i>
                <div class="d-inline">
                    <h2>Media Library</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('management') }}"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active"><a href="{{ route('media.index') }}">Media Library</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-block">
                    <div class="form-group">
                        <div id="myDropzone" class="dropzone" route-data="{{ route('file.upload_file') }}"></div>
                    </div>

                @if ($message = Session::get('success'))
                <div class="alert alert-success mt-2 mb-0">{{ $message }}</div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger mt-2 mb-0">
                    <strong>Whoops!</strong> There were some problems with your input.<br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive">
                        <table class="table table-inverse table-hover">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th width="200px">file</th>
                                    <th>Title</th>
                                    <th>Uploader</th>
                                    <th>Ref</th>
                                    <th>Date</th>
                                    <th width="200px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $rs)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>@php
                                        $file_name=$rs->name;
                                        $file_extension=end_extenstion($file_name);
                                        $table_name=$rs->table_name;
                                        $folder=$rs->folder;
                                        @endphp
                                        @if ($file_extension=='doc' or $file_extension=='docx' or $file_extension=='xls' or $file_extension=='xlsx' or $file_extension=='pdf')
                                        @php
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
                                        $file=public_path($file_part);
                                        @endphp
                                        <div class="document">
                                            <a href="{{ url_file($rs->id, $folder, $table_name, '') }}" target="_blank" title="{{ $rs->title }}">
                                                <div class="document-body">{!! get_extenstion($file_name) !!}</div>
                                                <div class="document-footer">
                                                        <span class="document-name"> {{ $rs->title }} </span>
                                                        <span class="document-description"> {{ get_file_size($file) }}</span>
                                                </div>
                                            </a>
                                        </div>
                                        @else
                                        <a href="{{ url_file($rs->id, $folder, $table_name, '') }}" class="d-block h-100">
                                            <img class="img-fluid img-thumbnail" src="{{ url_file($rs->id, $folder, $table_name, 'thumb_') }}" alt="">
                                        </a>
                                        @endif
                                    </td>
                                    <td>{{ $rs->title }}</td>
                                    <td>{{ $rs->admin_name }}</td>
                                    <td>@php
                                        $myList = get_field($rs->table_name,'id',$rs->ref_table_id,'');
                                        @endphp
                                        @if(is_array($myList) || is_object($myList))
                                            @foreach ($myList as $value)
                                                @if ($rs->table_name=="news")
                                                @can('news-edit')
                                                <a href="{{ route('news.edit',$value->id) }}">{{ $value->name }}</a>
                                                @endcan
                                                @elseif ($rs->table_name=="page")
                                                @can('page-edit')
                                                <a href="{{ route('page.edit',$value->id) }}">{{ $value->name }}</a>
                                                @endcan
                                                @elseif ($rs->table_name=="meeting")
                                                @can('meeting-edit')
                                                <a href="{{ route('meeting.edit',$value->id) }}">{{ $value->name }}</a>
                                                @endcan
                                                @elseif ($rs->table_name=="coursecalendar")
                                                @can('coursecalendar-edit')
                                                <a href="{{ route('coursecalendar.edit',$value->id) }}">{{ $value->name }}</a>
                                                @endcan
                                                @elseif ($rs->table_name=="hospital")
                                                @can('hospital-edit')
                                                <a href="{{ route('hospital.edit',$value->id) }}">{{ $value->name }}</a>
                                                @endcan
                                                @elseif ($rs->table_name=="doctor")
                                                @can('hospital-edit')
                                                <a href="{{ route('doctor.edit',$value->id) }}">{{ $value->name }}</a>
                                                @endcan
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($rs->created_at)->format('d/m/Y')}}</td>
                                    <td>
                                    <a class="btn btn-icon btn-outline-success mr-3" href="{{ route('media.show',$rs->id) }}"><i class="ik ik-eye"></i></a>
                                    <a class="btn btn-icon btn-outline-primary mr-3" href="{{ route('media.edit',$rs->id) }}"><i class="ik ik-edit-2"></i></a>
                                    <a class="btn btn-icon btn-outline-danger mr-3" href="{{ route('media.destroy',$rs->id) }}" onclick="return confirm('Are you sure Delete?')"><i class="ik ik-trash-2"></i></a>
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
    {!! $results->links() !!}
@endsection

@section('csspage')
<link rel="stylesheet" href="{!! asset('css/dropzone.css') !!}">
<link rel="stylesheet" href="{!! asset('css/dropzone_custom.css') !!}">
@endsection
@section('scriptpage')
<script src="{!! asset('js/dropzone.js') !!}"></script>
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function(){
        var myDropzone = new Dropzone("#myDropzone", {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $('#myDropzone').attr('route-data'),
            type: "post",
            paramName: "pic_file",
            autoProcessQueue: true,
            uploadMultiple: false, // uplaod files in a single request
            maxFilesize: 12, // MB
            acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx",
            // Language Strings
            dictInvalidFileType: "ประเภทไฟล์ไม่ถูกต้อง",
            dictDefaultMessage: "Upload Picture and Document file",
        });
            myDropzone.on("complete", function(file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                myDropzone.removeFile(file);
                    window.location.href = '{{ route('media.index') }}';
                }
            });
    });
    </script>
@endsection
