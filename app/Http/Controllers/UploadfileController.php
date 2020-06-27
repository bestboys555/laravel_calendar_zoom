<?php

namespace App\Http\Controllers;

use App\Uploadfile;
use App\Uploadfile_has_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use File;
use Session;

class UploadfileController extends Controller
{
    private $files_path;

    public function __construct()
    {
        $this->files_path = public_path('/images');
    }

    public function show_file(Request $request)
    {
        $files_path=$this->files_path;
        $table_name = ($request->table_name != 'undefined' ? $request->table_name : '');
        $files_path.="/".$table_name;
        $ref_table_id=$request->ref_table_id;
        if($ref_table_id!=""){
            $file_select = DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
            ->where('ref_table_id', $ref_table_id)
            ->where('table_name', $table_name)
            ->orderBy('section_order', 'asc')
            ->orderBy('uploadfile.id', 'asc')
            ->get();
        }else{
            $tmp_key=Session::get('file_'.$table_name);
            $file_select = DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
            ->where('tmp_key', $tmp_key)
            ->orderBy('section_order', 'asc')
            ->orderBy('uploadfile.id', 'asc')
            ->get();
        }

        $i_pic=0;
        $html="";
        foreach ($file_select as $picture_value) {
            $file_id=$picture_value->id;
            $file_name=$picture_value->name;
            $file_name_thumb=$picture_value->name_thumb;
            $file_title=$picture_value->title;
            $is_cover=$picture_value->is_cover;
            $file_folder=$picture_value->folder;
            $file_extension=$picture_value->file_extension;

            $directory_save=$files_path."/".$file_folder;
            $directory_show='/images/'.$table_name.'/'.$file_folder;
            $show_pic_url="";
            $show_pic_url_thumb="/images/no-images.png";
            if (file_exists($directory_save."/". $file_name)) {
                $show_pic_url=$directory_show."/". $file_name;
                $show_pic_url_thumb=$directory_show."/". $file_name_thumb;
            }

            $html.="<div class='col-lg-2 col-md-3 col-sm-3 padleft0 mb-3' id='recordsArray_".$file_id."' style='height: auto;min-height: 165px;'>";
            if($file_extension=='jpeg' or $file_extension=='JPEG' or $file_extension=='jpg'  or $file_extension=='JPG' or  $file_extension=='png' or  $file_extension=='PNG' or $file_extension=='gif' or $file_extension=='GIF'){
            if($is_cover=="1"){
           $html.="<div class='paperclip'><div class='paperclip-inner'><span class='paperclip-label'><i class='ik ik-star-on'></i><br />Cover</span></div></div>";
               }
           $html.="<div class='photoitem thumbnail l-image ";
           if($is_cover=="yes"){$html.="cover";}
           $html.="'>";
           $html.="<a data-toggle='lightbox' data-gallery='multiimages' data-title='".$file_title."'><img src='".$show_pic_url_thumb."' alt='' class='img-thumbnail' style='width:100%'></a>
           <div class='action' id='action'>
           <div class='col group_text_edit'>
       <input name='file[".$i_pic."][id]' id='pic_".$i_pic."' type='hidden' value='".$file_id."'><input name='file[".$i_pic."][title]' type='text' id='alt_".$i_pic."' value='".$file_title."' class='form-control' placeholder='Title'></div><div class='group_pic_edit'>";

                if($is_cover=="0"){
            $html.="<a href='#' id='".$file_id."' class='stcover btn btn-warning' route-data='".route('file.setcover')."'><i class='ik ik-star-on'></i>Set Cover</a> ";
                }

           $html.="<a class='add_images_textedit btn btn-icon btn-success' title='Add to TextEdit' data-url='".asset($show_pic_url)."'><i class='ik ik-plus'></i></a> <a href='#' id='".$file_id."' class='stdelete btn btn-icon btn-danger' route-data='".route('file.delete_file')."'><i class='ik ik-trash-2'></i></a></div></div></div>";
            }else{
                $file=public_path('/images/'.$table_name.'/'.$file_folder.'/'.$file_name);
                $html.="<div class='document'>
                    <div class='document-body'><a href='".url_file($file_id, $file_folder, $table_name,'')."' target='_blank' title='".$file_title."'>".get_extenstion($file_name)."</a>
                    <div class='document-footer'>
                            <span class='document-description'>".get_file_size($file)."</span>
                    </div>
                    </div>
                    <div class='col group_text_edit'>
       <input name='file[".$i_pic."][id]' id='pic_".$i_pic."' type='hidden' value='".$file_id."'><input name='file[".$i_pic."][title]' type='text' id='alt_".$i_pic."' value='".$file_title."' class='form-control' placeholder='Title'></div>
                    <div class='group_pic_edit'>
                    <a class='add_link_textedit btn btn-icon btn-success' title='Add to TextEdit' data-url='".asset($show_pic_url)."' data-title='".$file_title."'><i class='ik ik-plus'></i></a> <a href='#' id='".$file_id."' class='stdelete btn btn-icon btn-danger' route-data='".route('file.delete_file')."'><i class='ik ik-trash-2'></i></a>
                    </div>

            </div>";
            }
           $html.="</div>";
            $i_pic++;
        }

        return Response::json([
            'html_data' => $html
        ], 200);
    }

    public function upload_file(Request $request)
    {
        $files_path=$this->files_path;
        $table_name = ($request->table_name != 'undefined' ? $request->table_name : '');
        $files_path.="/".$table_name;

        $type_upload='';
        $this->gen_session_file($table_name);
        $tmp_key='';

        $ref_table_id=$request->ref_table_id;
        $this->validate($request,[
            'pic_file' =>  'required|mimes:jpeg,png,jpg,gif,pdf,doc,docx,xls,xlsx|max:12288‬'
        ]);

        $photos = $request->file('pic_file');
        if (!is_array($photos)) {
            $photos = [$photos];
        }
        if (!is_dir($files_path)) {
            mkdir($files_path, 0777);
        }
        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $extension = $photo->getClientOriginalExtension();
            $newname = sha1(date('YmdHis') . Str::random(30)). '.' . $extension;

            if($ref_table_id!=""){
                $folder_save=$ref_table_id;
                $directory_save=$files_path."/".$folder_save;
            }else{
                $folder_save="tmp_file_folder";
                $directory_save=$files_path."/tmp_file_folder";
               $tmp_key=Session::get('file_'.$table_name);
            }
            if($extension=='jpeg' or $extension=='JPEG' or $extension=='jpg'  or $extension=='JPG' or  $extension=='png' or  $extension=='PNG' or $extension=='gif' or $extension=='GIF'){
                $file_title=$request->file_title;
                $file_select = DB::table('uploadfile');
                $file_select = $file_select->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id');
                if($ref_table_id!=""){
                    $file_select = $file_select->where('ref_table_id', $ref_table_id);
                    $file_select = $file_select->where('table_name', $table_name);
                }else{
                    $file_select = $file_select->where('tmp_key', $tmp_key);
                }
                $file_select = $file_select->where('is_cover', '1');
                $file_select = $file_select->count();

                    $is_cover="0";
                    if($file_select==0){
                        $is_cover="1";
                    }

                    if (!is_dir($directory_save)) {
                        mkdir($directory_save, 0777);
                     }

                     $thumb_name = 'thumb_'. $newname;
                     Image::make($photo)
                         ->resize(1080, null, function ($constraint) {
                             $constraint->aspectRatio();
                             $constraint->upsize();
                         })
                         ->save($directory_save . '/' . $newname);

                    $resize = Image::make($photo);
                    $resize = $resize->resize(388, null, function ($constraint) {
                             $constraint->aspectRatio();
                             $constraint->upsize();
                         });
                    if($table_name=="hospital" or $table_name=="doctor"){
                        $resize = $resize->fit(388, 388);
                    }else{
                        $resize = $resize->fit(388, 214);
                    }
                    $resize = $resize->save($directory_save . '/' . $thumb_name);

                    $type_upload='pic';
                    $data_uploadfile = array(
                        'name' => $newname,
                        'name_thumb' => $thumb_name,
                        'folder' => $folder_save,
                        'file_extension' => $extension,
                        'tmp_key' => $tmp_key,
                    );

                    $data_uploadfile_has_table = array(
                        'title' => $file_title,
                        'table_name' => $table_name,
                        'ref_table_id' => $ref_table_id,
                        'is_cover' => $is_cover
                    );
                }else{
                    $file_title = basename($photo->getClientOriginalName());
                    $photo->move($directory_save,$newname);
                    $type_upload='filedocument';
                    $data_uploadfile = array(
                        'name' => $newname,
                        'folder' => $folder_save,
                        'file_extension' => $extension,
                        'tmp_key' => $tmp_key,
                    );

                    $data_uploadfile_has_table = array(
                        'title' => $file_title,
                        'table_name' => $table_name,
                        'ref_table_id' => $ref_table_id,
                        'is_cover' => '0'
                    );
                }
                $data_uploadfile = array_merge($data_uploadfile, [
                    'users_id' => Auth::id(),
                ]);
                $data = Uploadfile::create($data_uploadfile);
                $data_uploadfile_has_table = array_merge($data_uploadfile_has_table, [
                    'uploadfile_id' => $data->id,
                ]);
                $data_uploadfile_has_table = array_merge($data_uploadfile_has_table, [
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]);
                Uploadfile_has_table::create($data_uploadfile_has_table);
        }
        return Response::json([
            'message' => 'success','type' => $type_upload
        ], 200);
    }

    public function file_sortable(Request $request)
    {
        $updateRecordsArray = collect($request->recordsArray);
        $listingCounter = 1;
        foreach ($updateRecordsArray as $recordIDValue) {
            DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
            ->where('uploadfile_has_table.id', $recordIDValue)
            ->update(['section_order' => $listingCounter]);
        $listingCounter++;
            }
        return Response::json([
            'message' => 'success'
        ], 200);
    }

    public function delete_file(Request $request)
    {
        if(isset($request->file_id))
        {
            $file_id=$request->file_id;
            $file_select = DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
            ->where('uploadfile_has_table.id', $file_id)
            ->get();
            $uploadfile_id=$file_select[0]->uploadfile_id;
            $file_name=$file_select[0]->name;
            $file_name_thumb=$file_select[0]->name_thumb;
            $file_folder= $file_select[0]->folder;
            $ref_table_id= $file_select[0]->ref_table_id;
            $tmp_key= $file_select[0]->tmp_key;
            $is_cover= $file_select[0]->is_cover;
            $table_name= $file_select[0]->table_name;
            $file_extension=$file_select[0]->file_extension;
            $files_path=$this->files_path;
            if($table_name!=''){
                $files_path.="/".$table_name;
            }
            $directory_save=$files_path."/".$file_folder;

            if($file_name!=NULL){
                if (file_exists($directory_save."/". $file_name)) {
                    unlink($directory_save."/". $file_name);
                }
            }
            if($file_name_thumb!=NULL){
                if (file_exists($directory_save."/". $file_name_thumb)) {
                    unlink($directory_save."/". $file_name_thumb);
                }
            }

            if($file_extension=='jpeg' or $file_extension=='png' or $file_extension=='jpg' or $file_extension=='gif'){
                if($is_cover=='1'){
                    $file_cover_select = DB::table('uploadfile')
                    ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id');
                    if($ref_table_id!="" or $ref_table_id!=null){
                        $file_cover_select = $file_cover_select->where('ref_table_id', $ref_table_id);
                        $file_cover_select = $file_cover_select->where('table_name', $table_name);
                    }else{
                        $file_cover_select = $file_cover_select->where('tmp_key', $tmp_key);
                    }
                    $file_cover_select = $file_cover_select->where(function($query) {
                        $query->where('file_extension', 'jpeg')
                      ->orWhere('file_extension', 'JPEG')
                      ->orWhere('file_extension', 'jpg')
                      ->orWhere('file_extension', 'JPG')
                      ->orWhere('file_extension', 'png')
                      ->orWhere('file_extension', 'PNG')
                      ->orWhere('file_extension', 'gif')
                      ->orWhere('file_extension', 'GIF');
                    });
                    $file_cover_select = $file_cover_select->where('uploadfile_has_table.id', '!=' , $file_id);
                    $file_cover_select = $file_cover_select->orderBy('uploadfile_has_table.id', 'asc');
                    $file_cover_select = $file_cover_select->limit(1);
                    $file_cover_select = $file_cover_select->get();

                    if(isset($file_cover_select[0]->id)){
                        $id_update_cover=$file_cover_select[0]->id;
                        DB::table('uploadfile_has_table')
                        ->where('id', $id_update_cover)
                        ->update(['is_cover' => '1']);
                    }
                }
            }
            DB::table('uploadfile_has_table')->where('id', $file_id)->delete();
            $count = DB::table('uploadfile_has_table')
            ->where('uploadfile_id', $uploadfile_id)
            ->count();
            if($count==0){
                DB::table('uploadfile')->where('id', $uploadfile_id)->delete();
            }

            return Response::json([
                'message' => 'success'
            ], 200);
        }
    }

    public function setcover(Request $request)
    {
        if(isset($request->file_id))
        {
            $file_id = $request->file_id;
            $table_name = $request->table_name;
            $file_select = DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
            ->where('uploadfile_has_table.id', $file_id)
            ->get();

            $id_update_cover=$file_select[0]->id;
            $ref_table_id= $file_select[0]->ref_table_id;
            $tmp_key= $file_select[0]->tmp_key;

                DB::table('uploadfile_has_table')
                ->where('id', $id_update_cover)
                ->update(['is_cover' => '1']);

            $picture_cover = DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id');
            if($ref_table_id!="" or $ref_table_id!=null){
                $picture_cover = $picture_cover->where('ref_table_id', $ref_table_id);
                $picture_cover = $picture_cover->where('table_name', $table_name);
            }else{
                $picture_cover = $picture_cover->where('tmp_key', $tmp_key);
            }
            $picture_cover = $picture_cover->where('uploadfile_has_table.id', '!=' , $id_update_cover);
            $picture_cover = $picture_cover->update(['is_cover' => '0']);

            return Response::json([
                'message' => 'success'
            ], 200);
        }
    }

    public static function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
        $i=0;
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') { continue; }
            $i++;
        }
        if($i==0){
            if (is_dir($dir)) {
            return File::deleteDirectory($dir);
            }
        }
    }


    function gen_session_file($table_name){
        if (!Session::has('file_'.$table_name))
        {
        Session::put('file_'.$table_name, sha1(date('YmdHis') . Str::random(30)));
        }
        Session::save();
    }
}
