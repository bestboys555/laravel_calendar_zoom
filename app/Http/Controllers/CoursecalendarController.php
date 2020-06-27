<?php

namespace App\Http\Controllers;

use App\Coursecalendar;
use App\CoursecalendarRegister;
use App\Zoom_meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use File;
use Session;
use App\Exports\CoursecalendarExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class CoursecalendarController extends Controller
{
    protected $zoom_user;
    private $photos_path;
    private $generalsetting;

    public function __construct()
    {
        $zoom = new \MacsiDigital\Zoom\Support\Entry;
        $this->zoom_user = new \MacsiDigital\Zoom\User($zoom);
        $this->middleware('permission:coursecalendar-list|coursecalendar-create|coursecalendar-edit|coursecalendar-delete', ['only' => ['index','show']]);
        $this->middleware('permission:coursecalendar-create', ['only' => ['create','store']]);
        $this->middleware('permission:coursecalendar-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:coursecalendar-delete', ['only' => ['destroy']]);
        $this->middleware('permission:coursecalendar-checkpayment', ['only' => ['show_payment', 'destroy_register', 'register_meeting_view', 'register_checkpayment','payment_notification']]);
        $this->files_path = public_path('/images');
        $this->generalsetting = \App\GeneralSetting::first();
    }

    public function index()
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->select(DB::raw('coursecalendar.*, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->latest('coursecalendar.created_at')
        ->paginate(10);

        return view('management.coursecalendar.index',compact('coursecalendar'))->with('i', (request()->input('coursecalendar', 1) - 1) * 10);
    }


    public function search(Request $request)
    {
        $coursecalendar = Coursecalendar::
        where('name', 'LIKE', "%{$request->search}%")
        ->orWhere('detail', 'LIKE', "%{$request->search}%")
        ->latest()
        ->paginate(10);

        return view('management.coursecalendar.index',compact('coursecalendar'))->with('i', ($request->input('coursecalendar', 1) - 1) * 10);
    }

    public function category($cat_id)
    {
        $coursecalendar = DB::table('coursecalendar')
            ->where('cat_id', $cat_id)->latest()
            ->paginate(10);

        $category = DB::table('news_category')
            ->where('id', $cat_id)
            ->get();

        return view('management.coursecalendar.index',compact('coursecalendar','category'))->with('i', (request()->input('coursecalendar', 1) - 1) * 10);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zoom = $this->zoom_user->find($this->generalsetting->zoom_email);
        return view('management.coursecalendar.create',compact('zoom'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $open_register = (isset($request->open_register) == '1' ? '1' : '0');
        $show_index = (isset($request->show_index) == '1' ? '1' : '0');
        $open_zoom = (isset($request->open_zoom) == '1' ? '1' : '0');
        $files_path=$this->files_path;
        $files_path.="/coursecalendar";

        $data_validate = array(
            'name' => 'required',
            'type_calendar' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            );

        $data_insert = array(
            'name' => $request->name,
            'type_calendar' => $request->type_calendar,
            'location' => $request->location,
            'target_audience' => $request->target_audience,
            'course_director' => $request->course_director,
            'start_date' => date('Y-m-d H:i', strtotime($request->start_date)),
            'end_date' => date('Y-m-d H:i', strtotime($request->end_date)),
            'show_index' => $show_index,
            'open_register' => $open_register,
            'open_zoom' => $open_zoom,
        );

        if($open_register==1){
            $data_validate = array_merge($data_validate, [
                'number_participants' => 'required|numeric',
                'price' => 'numeric',
                'register_start_date' => 'required',
                'register_end_date' => 'required',
            ]);
            $data_insert = array_merge($data_insert, [
                'number_participants' => $request->number_participants,
                'price' => $request->price,
                'register_start_date' => date('Y-m-d H:i', strtotime($request->register_start_date)),
                'register_end_date' => date('Y-m-d H:i', strtotime($request->register_end_date)),
            ]);
        }else{
            $data_insert = array_merge($data_insert, [
                'number_participants' => NULL,
                'price' => '0',
                'register_start_date' => NULL,
                'register_end_date' => NULL,
            ]);
        }
        if($request->price>0){
            $data_validate = array_merge($data_validate, [
                'payment_detail' => 'required',
            ]);
        }
        /// validate zoom //
        if($open_zoom==1){
            $data_validate = array_merge($data_validate, [
                'zoom_start_time' => 'required',
                'zoom_duration' => 'required|numeric',
            ]);
        }

        $request->validate($data_validate);
        $data = Coursecalendar::create($data_insert); // save coursecalendar
        /// zoom ///
        $zoom_data = $data->zoom;
        if($open_zoom=='1'){
            $startTime = $request->zoom_start_time;
            $date = Carbon::parse($startTime)->format('Y-m-d');
            $time = Carbon::parse($startTime)->format('H:i:s');
            $datetime = $date.'T'.$time.'Z';

            $zoom = $this->zoom_user->find($this->generalsetting->zoom_email);
            if(!$zoom_data){
                $meeting = $zoom->meetings()->create(array(
                    'topic'         => $request->name,
                    'start_time'    => $datetime,
                    'duration'      => $request->zoom_duration,
                    'timezone'      => env('APP_TIMEZONE')
                ));
                if($meeting){
                    $meetingId = $meeting->id;
                    $data->zoom()->create(array(
                        'zoom_id'       => $meetingId,
                        'start_time'    => date('Y-m-d H:i', strtotime($request->zoom_start_time)),
                        'duration'      => $request->zoom_duration,
                        'password'      => $meeting->password,
                        'timezone'      => $meeting->timezone,
                        'duration'      => $request->zoom_duration,
                        "start_url"     => $meeting->start_url,
                        "join_url"      => $meeting->join_url,
                    ));
                }
            }
        }
        /// end zoom ///

        // update file
        $tmp_key = Session::get('file_coursecalendar');

        $file_select = DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
            ->where('tmp_key', $tmp_key)
            ->orderBy('uploadfile_has_table.id', 'asc')
            ->get();

        foreach ($file_select as $file_value) {
            $file_id=$file_value->id;
            $folder=$file_value->folder;
            $pic_name=$file_value->name;
            $pic_thumb_name=$file_value->name_thumb;
            $directory_save=$files_path."/".$data->id;
            if (!is_dir($directory_save)) {
                mkdir($directory_save, 0777);
            }
            if($pic_name!=NULL){
                $old_directory_pic=$files_path."/".$folder."/".$pic_name;
                $new_directory_pic=$files_path."/".$data->id."/".$pic_name;
                if (file_exists($old_directory_pic)) {
                    File::move($old_directory_pic, $new_directory_pic);
                }
            }
            if($pic_thumb_name!=NULL){
                $old_directory_pic_thumb=$files_path."/".$folder."/".$pic_thumb_name;
                $new_directory_pic_thumb=$files_path."/".$data->id."/".$pic_thumb_name;
                if (file_exists($old_directory_pic_thumb)) {
                    File::move($old_directory_pic_thumb, $new_directory_pic_thumb);
                }
            }

            $result = collect($request->file)
            ->firstWhere('id', $file_id);
            $title_save = $result['title'];
            DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
            ->where('uploadfile_has_table.id', $file_id)
            ->update(['title' => $title_save, 'ref_table_id' => $data->id, 'tmp_key' => '', 'folder' => $data->id]);
        }
        // update file
        $detail=str_replace('tmp_file_folder',$data->id,$request->detail);
        $faqs=str_replace('tmp_file_folder',$data->id,$request->faqs);
        $accommodation=str_replace('tmp_file_folder',$data->id,$request->accommodation);
        $payment_detail=str_replace('tmp_file_folder',$data->id,$request->payment_detail);

            DB::table('coursecalendar')
            ->where('id', $data->id)
            ->update([
            'detail' => $detail,
            'faqs' => $faqs,
            'accommodation' => $accommodation,
            'payment_detail' => $payment_detail
            ]);

        Session::forget('file_coursecalendar');
        //
        return redirect()->route('coursecalendar.index')->with('success','Meeting created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coursecalendar  $Coursecalendar
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coursecalendar  $Coursecalendar
     * @return \Illuminate\Http\Response
     */

    public function edit(Coursecalendar $coursecalendar)
    {
        $ref_page = DB::table('coursecalendar')->where('id','!=', $coursecalendar->id)->pluck('name','id')->all();
        $zoom = $this->zoom_user->find($this->generalsetting->zoom_email);
        $zoom_data = $coursecalendar->zoom;
        return view('management.coursecalendar.edit',compact('coursecalendar','ref_page','zoom','zoom_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coursecalendar  $coursecalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coursecalendar $coursecalendar)
    {
        $open_register = (isset($request->open_register) == '1' ? '1' : '0');
        $show_index = (isset($request->show_index) == '1' ? '1' : '0');
        $open_zoom = (isset($request->open_zoom) == '1' ? '1' : '0');
        $data_validate = array(
            'name' => 'required',
            'type_calendar' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            );

        $data_insert = array(
            'name' => $request->name,
            'type_calendar' => $request->type_calendar,
            'location' => $request->location,
            'target_audience' => $request->target_audience,
            'course_director' => $request->course_director,
            'detail' => $request->detail,
            'faqs' => $request->faqs,
            'accommodation' => $request->accommodation,
            'payment_detail' => $request->payment_detail,
            'start_date' => date('Y-m-d H:i', strtotime($request->start_date)),
            'end_date' => date('Y-m-d H:i', strtotime($request->end_date)),
            'show_index' => $show_index,
            'open_register' => $open_register,
            'open_zoom' => $open_zoom,
        );

        if($open_register==1){
            $data_validate = array_merge($data_validate, [
                'number_participants' => 'required|numeric',
                'price' => 'numeric',
                'register_start_date' => 'required',
                'register_end_date' => 'required',
            ]);
            $data_insert = array_merge($data_insert, [
                'number_participants' => $request->number_participants,
                'price' => $request->price,
                'register_start_date' => date('Y-m-d H:i', strtotime($request->register_start_date)),
                'register_end_date' => date('Y-m-d H:i', strtotime($request->register_end_date)),
            ]);
        }else{
            $data_insert = array_merge($data_insert, [
                'number_participants' => NULL,
                'price' => '0',
                'register_start_date' => NULL,
                'register_end_date' => NULL,
            ]);
        }

        if($open_zoom==1){
            $data_validate = array_merge($data_validate, [
                'zoom_start_time' => 'required',
                'zoom_duration' => 'required|numeric',
            ]);
        }

        if($request->price>0){
            $data_validate = array_merge($data_validate, [
                'payment_detail' => 'required',
            ]);
        }
        $request->validate($data_validate);
        // update file
            $file_select = DB::table('uploadfile')
            ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
            ->where('ref_table_id', $coursecalendar->id)
            ->where('table_name', 'coursecalendar')
            ->orderBy('uploadfile_has_table.id', 'asc')
            ->get();

        foreach ($file_select as $file_value) {
            $file_id=$file_value->id;
            $result = collect($request->file)
            ->firstWhere('id', $file_id);
            $title_save = $result['title'];
            DB::table('uploadfile_has_table')
            ->where('id', $file_id)
            ->update(['title' => $title_save]);
        }
        // update file

        $coursecalendar->update($data_insert);
        /// zoom ///
        $zoom_data = $coursecalendar->zoom;
        if($open_zoom=='1'){
            $startTime = $request->zoom_start_time;
            $date = Carbon::parse($startTime)->format('Y-m-d');
            $time = Carbon::parse($startTime)->format('H:i:s');
            $datetime = $date.'T'.$time.'Z';

            $zoom = $this->zoom_user->find($this->generalsetting->zoom_email);
            if($zoom_data){
                $zoomMeeting = $zoom->meetings()->find($zoom_data->zoom_id);

                $meeting = $zoomMeeting->update(array(
                    'topic'         => $request->name,
                    'start_time'    => $datetime,
                    'duration'      => $request->zoom_duration,
                    'timezone'      => env('APP_TIMEZONE')
                ));
                if($zoomMeeting){
                    $coursecalendar->zoom()->update(array(
                        'start_time' => $meeting->start_time,
                        'duration'   => $request->zoom_duration,
                    ));
                }
            }else{
                $meeting = $zoom->meetings()->create(array(
                    'topic'         => $request->name,
                    'start_time'    => $datetime,
                    'duration'      => $request->zoom_duration,
                    'timezone'      => env('APP_TIMEZONE')
                ));
                if($meeting){
                    $meetingId = $meeting->id;
                    $coursecalendar->zoom()->create(array(
                        'zoom_id'       => $meetingId,
                        'start_time'    => date('Y-m-d H:i', strtotime($request->zoom_start_time)),
                        'duration'      => $request->zoom_duration,
                        'password'      => $meeting->password,
                        'timezone'      => $meeting->timezone,
                        'duration'      => $request->zoom_duration,
                        "start_url"     => $meeting->start_url,
                        "join_url"      => $meeting->join_url,
                    ));
                }
            }
        }else{
            if($zoom_data){
                $coursecalendar->zoom()->delete();
                //$zoomMeeting = $this->zoom_user->find($zoom_data->zoom_id);
                $zoom = $this->zoom_user->find($this->generalsetting->zoom_email);
                $zoomMeeting = $zoom->meetings()->find($zoom_data->zoom_id);
                if($zoomMeeting){
                   $zoomMeeting->delete();
                }
            }
        }
/// end zoom ///
        if(isset($request->ref_id)){
            return redirect()->route('coursecalendar.category', ['id' => $request->ref_id])
            ->with('success','Meeting updated successfully');
        }else{
            return redirect()->route('coursecalendar.index')
            ->with('success','Meeting updated successfully');
        }
    }


    public function show(Coursecalendar $coursecalendar)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar.id', $coursecalendar->id)
        ->select(DB::raw('coursecalendar.*, coursecalendar_register.id as meeting_register_id, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->first();

        $pictures = DB::table('uploadfile')
        ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
        ->where('ref_table_id', $coursecalendar->id)
        ->where('table_name', 'coursecalendar')
        ->where(function($query) {
            $query->where('file_extension', 'jpeg')
                      ->orWhere('file_extension', 'JPEG')
                      ->orWhere('file_extension', 'jpg')
                      ->orWhere('file_extension', 'JPG')
                      ->orWhere('file_extension', 'png')
                      ->orWhere('file_extension', 'PNG')
                      ->orWhere('file_extension', 'gif')
                      ->orWhere('file_extension', 'GIF');
        })
        ->where('is_cover','!=', '1')
        ->orderBy('section_order', 'asc')
        ->orderBy('uploadfile_has_table.id', 'asc')
        ->get();

        $documents = DB::table('uploadfile')
        ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
        ->where('ref_table_id', $coursecalendar->id)
        ->where('table_name', 'coursecalendar')
        ->where(function($query) {
            $query->where('file_extension', 'pdf')
            ->orWhere('file_extension', 'doc')
            ->orWhere('file_extension', 'docx')
            ->orWhere('file_extension', 'xls')
            ->orWhere('file_extension', 'xlsx');
        })
        ->orderBy('section_order', 'asc')
        ->orderBy('uploadfile_has_table.id', 'asc')
        ->get();

        return view('management.coursecalendar.show',compact('coursecalendar', 'pictures', 'documents'));
    }

    public function show_payment($id)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar.id', $id)
        ->select(DB::raw('coursecalendar.*, coursecalendar_register.id as meeting_register_id, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->first();

        $coursecalendar_register = CoursecalendarRegister::where('coursecalendar_id', $id)
        ->join('users', 'users.id', '=', 'coursecalendar_register.users_id')
        ->select(DB::raw('coursecalendar_register.*, coursecalendar_register.id as meeting_register_id, users.name'))
        ->orderBy('coursecalendar_register.confirm_meeting', 'asc')
        ->orderBy('coursecalendar_register.file_payment', 'asc')
        ->orderBy('coursecalendar_register.id', 'asc')
        ->get();
        if($coursecalendar){
            return view('management.coursecalendar.check_payment_list',compact('coursecalendar', 'coursecalendar_register'));
        }else{
            return abort(404);
        }
    }

    public function payment_notification(Request $request)
    {
        $coursecalendar_register = CoursecalendarRegister::where('confirm_meeting', '0')
        ->join('users', 'users.id', '=', 'coursecalendar_register.users_id')
        ->join('coursecalendar', 'coursecalendar_register.coursecalendar_id', '=', 'coursecalendar.id')
        ->select(DB::raw('coursecalendar_register.*, coursecalendar_register.id as meeting_register_id, users.name , coursecalendar.name as meeting_name'))
        ->orderBy('coursecalendar_register.confirm_meeting', 'asc')
        ->orderBy('coursecalendar_register.file_payment', 'desc')
        ->orderBy('coursecalendar_register.id', 'asc')
        ->get();

        return view('management.coursecalendar.check_payment_notification',compact('coursecalendar_register'));
    }

    public function destroy(Coursecalendar $coursecalendar)
    {
        $calendar_id=$coursecalendar->id;
        $file_select = DB::table('uploadfile')
        ->join('uploadfile_has_table', 'uploadfile.id', '=', 'uploadfile_has_table.uploadfile_id')
        ->where('ref_table_id', $calendar_id)
        ->where('table_name', 'coursecalendar')
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
        $zoom_data = $coursecalendar->zoom;
        if($zoom_data){
                $coursecalendar->zoom()->delete();
                $zoom = $this->zoom_user->find($this->generalsetting->zoom_email);
                $zoomMeeting = $zoom->meetings()->find($zoom_data->zoom_id);
                if($zoomMeeting){
                   $zoomMeeting->delete();
                }
            }
        CoursecalendarRegister::where('id', $calendar_id)->delete();
        // del file
        $coursecalendar->delete();
        return redirect()->route('coursecalendar.index')->with('success','Meeting deleted successfully');
    }

    public function destroy_register($id)
    {
        $coursecalendar_register = CoursecalendarRegister::where('id', $id)
        ->first();

        $directory_save=$this->photos_path."/".$coursecalendar_register->coursecalendar_id;
        $file_old=$directory_save."/".$coursecalendar_register->file_payment;
        if($coursecalendar_register->file_payment!=NULL and file_exists($file_old)){
            unlink($file_old);
        }

        CoursecalendarRegister::where('id', $coursecalendar_register->id)->delete();
        //return redirect()->route('coursecalendar.show_payment',$coursecalendar_register->coursecalendar_id)->with('success','Deleted successfully');
        return back()->with('success','Deleted successfully');
    }

    public function register_coursecalendar_view($id,$back)
    {
        $coursecalendar = CoursecalendarRegister::join('users', 'users.id', '=', 'coursecalendar_register.users_id')
        ->join('coursecalendar', 'coursecalendar_register.coursecalendar_id', '=', 'coursecalendar.id')
        ->where('coursecalendar_register.id', $id)
        ->select(DB::raw('coursecalendar.*, coursecalendar_register.id as meeting_register_id, file_payment , confirm_meeting , note, coursecalendar_register.users_id , users.name as users_name, users.email, coursecalendar_register.tell, coursecalendar_register.address'))
        ->first();
        if ($coursecalendar) {
            return view('management.coursecalendar.check_payment_view',compact('coursecalendar','back'));
        }else{
            return abort(404);
        }
    }

    public function register_checkpayment(Request $request , $id)
    {
        $confirm_meeting = (isset($request->confirm_meeting) == '1' ? '1' : '0');
        $back = (isset($request->back) ? $request->back : '');

        $coursecalendar_register = CoursecalendarRegister::where('id', $id)
        ->first();
        $data_insert = array(
            'confirm_meeting' => $confirm_meeting,
        );
        $coursecalendar = CoursecalendarRegister::where('id', $id)
        ->update($data_insert);
        if ($coursecalendar) {
            if($back=='notificat'){
                return redirect()->route('payment_coursecalendar_notification')->with('success','confirm coursecalendar successfully.');
            }else if($back=='list'){
                return redirect()->route('coursecalendar.show_payment',$coursecalendar_register->coursecalendar_id)->with('success','confirm coursecalendar successfully.');
            }else{
                return redirect()->route('coursecalendar.show_payment',$coursecalendar_register->coursecalendar_id)->with('success','confirm coursecalendar successfully.');
            }
        }else{
            return abort(404);
        }
    }

    function export_excel($id)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar.id', $id)
        ->select(DB::raw('coursecalendar.*, coursecalendar_register.id as meeting_register_id, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->first();
        if($coursecalendar){
        return (new CoursecalendarExport($id))->download('Workshop Training('.$coursecalendar->name.').xlsx');
        }else{
            return abort(404);
        }
    }
}
