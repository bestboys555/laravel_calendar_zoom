<?php
function get_zoom_notification_num()
{
    $meeting_1 = DB::table('zoom_meeting')
    ->join('coursecalendar', 'coursecalendar.id', '=', 'zoom_meeting.meeting_id')
    ->select(DB::raw("coursecalendar.id, coursecalendar.name, start_time, duration , zoom_meeting.join_url"))
    ->where('meeting_type', 'App\Coursecalendar')
    ->where(function($query) {
        $query
        ->whereRaw('DATE_ADD( start_time , INTERVAL +duration minute) >NOW()')
        ->orwhereDate('start_time', '>', NOW());
    })
    ->where('open_register', '0');
    $count = DB::table('coursecalendar')
    ->join('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
    ->join('zoom_meeting', 'coursecalendar.id', '=', 'zoom_meeting.meeting_id')
    ->select(DB::raw("coursecalendar.id, coursecalendar.name, start_time , duration, zoom_meeting.join_url"))
    ->where('users_id', Auth::id())
    ->where('meeting_type', 'App\Coursecalendar')
    ->where(function($query) {
        $query
        ->whereRaw('DATE_ADD( start_time , INTERVAL +duration minute) >NOW()')
        ->orwhereDate('start_time', '>', NOW());
    })
    ->union($meeting_1)
    ->groupBy('id')
    ->get()
    ->count();
    if($count!=0){
        return $count;
    }else{
        return '0';
    }
}

function cover_picture($id,$table)
{
    $no_image="/images/no-images.png";
    $fetch_userTo = DB::table('uploadfile')
    ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
    ->where('ref_table_id', $id)
    ->where('table_name', $table)
    ->where('is_cover', '1')
    ->get();

    $count = $fetch_userTo->count();
    if($count!=0){
        $thumb_pic = $fetch_userTo[0]->name_thumb;
        $photos_path = public_path('/images/'.$table.'/'.$id.'/');
        $photos_path_return ='/images/'.$table.'/'.$id.'/';
        if (file_exists( $photos_path . $thumb_pic)) {
            return $photos_path_return. $thumb_pic;
        }else{
            return $no_image;
        }
    }else{
        return $no_image;
    }
}

function cover_picture_returnfalse($id,$table)
{
    $fetch_userTo = DB::table('uploadfile')
    ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
    ->where('ref_table_id', $id)
    ->where('table_name', $table)
    ->where('is_cover', '1')
    ->get();
    $count = $fetch_userTo->count();
    if($count!=0){
        $thumb_pic = $fetch_userTo[0]->name_thumb;
        $photos_path = public_path('/images/'.$table.'/'.$id.'/');
        $photos_path_return ='/images/'.$table.'/'.$id.'/';
        if (file_exists( $photos_path . $thumb_pic)) {
            return $photos_path_return. $thumb_pic;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function images_news($id,$alt,$class,$table)
{
    $fetch_userTo = DB::table('uploadfile')
    ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
    ->where('ref_table_id', $id)
    ->where('table_name', $table)
    ->where('is_cover', '1')
    ->get();

    $count = $fetch_userTo->count();
    if($count!=0){
        $thumb_pic = $fetch_userTo[0]->name;
        $photos_path = public_path('/images/'.$table.'/'.$id.'/');
        $photos_path_return ='/images/'.$table.'/'.$id.'/';
        if (file_exists( $photos_path . $thumb_pic)) {
            return "<img src=\"".$photos_path_return. $thumb_pic."\" class=\"".$class."\" alt=\"".$alt."\" >";
        }else{
            return '';
        }
    }else{
        return '';
    }
}

function banner_show($name, $folder)
{
    if($name){
        $photos_path = public_path('/images/banner/'.$folder.'/');
        $photos_path_return ='/images/banner/'.$folder.'/';
        if (file_exists( $photos_path . $name)) {
            return $photos_path_return . $name;
        }else{
            return '';
        }
    }else{
        return '';
    }
}

function url_file($id, $folder, $table, $thumb)
{
    $file_part="";
    $fetch_filedocument = DB::table('uploadfile')
    ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
    ->where('uploadfile_has_table.id', $id)
    ->first();

    if($fetch_filedocument){
        $file_name=$fetch_filedocument->name;
        $table_name=$fetch_filedocument->table_name;
        $folder=$fetch_filedocument->folder;
        $file_part='/images';
        if($table_name!=NULL){
            $file_part.="/".$table_name;
        }
        if($folder!=NULL){
            $file_part.="/".$folder;
        }
        if($file_name!=NULL){
            $file_part.="/".$thumb.$file_name;
        }

        $file_path=public_path($file_part);
        $file_path_return =$file_part;
        if (file_exists($file_path)) {
            return $file_path_return;
        }else{
            return $file_part;
        }
    }else{
        return $file_part;
    }
}

function user_photo($id)
{
    $fetch_userTo = DB::table('users')
    ->where('id', $id)
    ->get();
    $old_avatar_pic = $fetch_userTo[0]->avatar_pic;
    $photos_path = public_path('/images/avatar/');
    if ($old_avatar_pic!=null and file_exists( $photos_path . $old_avatar_pic)) {
        return '/images/avatar/' . $old_avatar_pic;
    } else {
        return '/images/avatar/no-avatar.png';
    }
}

function user_photo_fullurl($id)
{
    $fetch_userTo = DB::table('users')
    ->where('id', $id)
    ->get();
    $old_avatar_pic = $fetch_userTo[0]->avatar_pic;
    $photos_path = public_path('/images/avatar/');
    if ($old_avatar_pic!=null and file_exists( $photos_path . $old_avatar_pic)) {
        return env('APP_URL').'/images/avatar/' . $old_avatar_pic;
    } else {
        return env('APP_URL').'/images/avatar/no-avatar.png';
    }
}

function get_field($table, $column_name, $id, $return_id) {
    if($table!=null or $table!=""){
    $fetch = DB::table($table);
    if($id!=null or $id!=""){
    $fetch = $fetch->where($column_name, $id);
    }
    $count = $fetch->count();

    if($count!=0){
        $fetch = $fetch->get();
        if($return_id!=""){
            $value = $fetch[0]->$return_id;
            return $value;
        }else{
            return $fetch;
        }
    }
    }else{
        return false;
    }
}

function get_table_all($table) {
    $fetch = DB::table($table);
    $fetch = $fetch->get();
    return $fetch;
}

function get_table_all_where($table, $column_name, $value) {
    $fetch = DB::table($table);
    $fetch = $fetch->where($column_name, $value);
    $fetch = $fetch->get();
    return $fetch;
}

function get_table_json($table) {
    $fetch = DB::table($table)
    ->get();
    return $fetch->toJson(JSON_PRETTY_PRINT);
}


function get_page_menu() {
    $fetch = DB::table('page')
    ->select('id','name','link_out','position')
    ->get();
    // $fetch = DB::table('page')
    // ->select('id','name','link_out','position')
    // ->get();
    return $fetch;
}

function get_ref_page_menu($page_id) {
    $fetch = DB::table('page')
    ->join('page_has_page', 'page.id', '=', 'page_has_page.page_id')
    ->where('page_has_page.ref_page_id',$page_id)
    ->orderBy('page.name', 'asc')
    ->get();
    return $fetch;
}

function get_file_size($file) {
    if (file_exists($file)) {
        $size = File::size($file); // bytes
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
        return round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
        //$filesize = round($filesize / 1024, 2); // kilobytes with two digits
    }
}

function get_extenstion($file) {
        $show="";
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if($extension=="doc" or $extension=="docx"){
            $show='<i class="far fa-file-word text-info"></i>';
        }else if($extension=="xls" or $extension=="xlsx"){
            $show='<i class="far fa-file-excel text-success"></i>';

        }else if($extension=="pdf"){
            $show='<i class="far fa-file-pdf text-danger"></i>';

        }
        return $show;
}

function end_extenstion($file) {
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    return $extension;
}

function status_meeting($start_date, $end_date) {
    $date_now =strtotime(date('d-m-Y H:i'));
    $start_date=strtotime($start_date);
    $end_date=strtotime($end_date);
    if($start_date<=$date_now and $date_now<=$end_date){
        return true;
    }else{
        return false;
    }
}
