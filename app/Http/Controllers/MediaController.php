<?php

namespace App\Http\Controllers;

use App\Uploadfile;
use App\Uploadfile_has_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    private $files_path;

    public function __construct()
    {
        $this->middleware('permission:Media', ['only' => ['index','show','edit','update']]);
        $this->middleware('permission:Media-delete', ['only' => ['destroy']]);
        $this->files_path = public_path('/images');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = DB::table('uploadfile')
        ->select('uploadfile_has_table.id', 'uploadfile.name', 'uploadfile.name_thumb','folder','title','table_name','ref_table_id','users.name as admin_name','uploadfile.created_at')
        ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
        ->join('users', 'users.id', '=', 'uploadfile.users_id')
        ->latest('uploadfile.created_at')
        ->paginate(10);

        return view('management.media.index',compact('results'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function edit($id)
    {
        $results = DB::table('uploadfile')
        ->select('uploadfile_has_table.id', 'uploadfile.name', 'uploadfile.name_thumb','folder','title','table_name','ref_table_id','users.name as admin_name','uploadfile.created_at')
        ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
        ->join('users', 'users.id', '=', 'uploadfile.users_id')
        ->where('uploadfile_has_table.id', $id)
        ->first();
        return view('management.media.edit',compact('results'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);
        Uploadfile_has_table::find($id)->update(['title' => $request->title]);
        return redirect()->route('media.index')->with('success','Category updated successfully');
    }

    public function show($id)
    {
        $results = DB::table('uploadfile')
        ->select('uploadfile_has_table.id', 'uploadfile.name', 'uploadfile.name_thumb','folder','title','table_name','ref_table_id','users.name as admin_name','uploadfile.created_at')
        ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
        ->join('users', 'users.id', '=', 'uploadfile.users_id')
        ->where('uploadfile_has_table.id', $id)
        ->first();

        return view('management.media.show',compact('results'));
    }

    public function destroy($id)
    {
        $file_select = DB::table('uploadfile')
        ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
        ->where('uploadfile_has_table.id', $id)
        ->get();
        foreach ($file_select as $file_value) {
            $uploadfile_id=$file_value->uploadfile_id;
            $table_name= $file_value->table_name;
            $file_folder= $file_value->folder;

            $files_path=$this->files_path;
            $files_path.="/".$table_name;
            $files_path.="/".$file_folder;
            $directory_save=$files_path;
            DB::table('uploadfile_has_table')
            ->where('id', $file_value->id)
            ->delete();

            $count = DB::table('uploadfile_has_table')
            ->where('uploadfile_id', $uploadfile_id)
            ->count();
            if($count==0){
                $file_name=$file_value->name;
                $file_name_thumb=$file_value->name_thumb;
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
                DB::table('uploadfile')->where('id', $uploadfile_id)->delete();
            }
            if (is_dir($directory_save)) {
                UploadfileController::deleteDirectory($directory_save);
            }
        }
        // del file
        return redirect()->route('media.index')->with('success','Media deleted successfully');
    }
}
