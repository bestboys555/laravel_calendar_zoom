<?php

namespace App\Http\Controllers;

use App\Coursecalendar;
use App\CoursecalendarRegister;
use App\Zoom_meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Response;

class WebpageCoursecalendarController extends Controller
{
    protected $zoom_user;
    private $photos_path;
    private $generalsetting;
    public function __construct()
    {
        $this->photos_path = public_path('/images/coursecalendar');
        $zoom = new \MacsiDigital\Zoom\Support\Entry;
        $this->zoom_user = new \MacsiDigital\Zoom\User($zoom);
        $this->generalsetting = \App\GeneralSetting::first();
    }

    public function zoom_list()
    {
        $meeting_1 = Zoom_meeting::join('coursecalendar', 'coursecalendar.id', '=', 'zoom_meeting.meeting_id')
        ->select(DB::raw("coursecalendar.id, coursecalendar.name, start_time, duration , zoom_meeting.join_url"))
        ->where('meeting_type', Coursecalendar::class)
        ->where(function($query) {
            $query
            ->whereRaw('DATE_ADD( start_time , INTERVAL +duration minute) >NOW()')
            ->orwhereDate('start_time', '>', NOW());
        })
        ->where('open_register', '0');
        $meeting = Coursecalendar::join('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->join('zoom_meeting', 'coursecalendar.id', '=', 'zoom_meeting.meeting_id')
        ->select(DB::raw("coursecalendar.id, coursecalendar.name, start_time , duration, zoom_meeting.join_url"))
        ->where('users_id', Auth::id())
        ->where('meeting_type', Coursecalendar::class)
        ->where(function($query) {
            $query
            ->whereRaw('DATE_ADD( start_time , INTERVAL +duration minute) >NOW()')
            ->orwhereDate('start_time', '>', NOW());
        })
        ->union($meeting_1)
        ->groupBy('id')
        ->orderBy('start_time','asc')
        ->paginate(10);
        $zoom = $this->zoom_user->find($this->generalsetting->zoom_email);
        return view('web_coursecalendar.coursecalendar_zoom_list',compact('meeting','zoom'))->with('i', (request()->input('meeting', 1) - 1) * 10);
    }

    public function coursecalendar($type_calendar)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar.type_calendar', $type_calendar)
        ->select(DB::raw('coursecalendar.*, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->latest('coursecalendar.created_at')
        ->paginate(10);
        return view('web_coursecalendar.coursecalendar_index',compact('coursecalendar','type_calendar'));
    }

    public function coursecalendar_data($id)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar.id', $id)
        ->select(DB::raw('coursecalendar.*, coursecalendar_register.id as meeting_register_id, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->first();
        if($coursecalendar){
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

            $coursecalendar_register = CoursecalendarRegister::where('coursecalendar_id', $coursecalendar->id)
                ->where('users_id', Auth::id())
                ->first();

            return view('web_coursecalendar.coursecalendar_read',compact('coursecalendar','pictures','documents','coursecalendar_register'));
        }else{
            return abort(404);
        }
    }
    public function register_coursecalendar($id)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar.id', $id)
        ->where('coursecalendar.open_register', '1')
        ->select(DB::raw('coursecalendar.*, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->first();
        if (Auth::check()) {
            if( $coursecalendar){
                $coursecalendar_register = CoursecalendarRegister::where('coursecalendar_id', $coursecalendar->id)
                ->where('users_id', Auth::id())
                ->get();
                $count_register = $coursecalendar_register->count();
                return view('web_coursecalendar.coursecalendar_register',compact('coursecalendar','count_register'));
            }else{
                return abort(404);
            }
        }else{
            return redirect()->route('web.coursecalendar')->withErrors(['Please login!'])->withInput();
        }
    }

    public function register_coursecalendar_view($id)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar_register.id', $id)
        ->where('users_id', Auth::id())
        ->select(DB::raw('coursecalendar.*, coursecalendar_register.id as meeting_register_id, count(coursecalendar_register.id) as register_count, file_payment , confirm_meeting'))
        ->groupBy('coursecalendar.id')
        ->first();
        if (Auth::check() and $coursecalendar) {
            $zoom = $this->zoom_user->find($this->generalsetting->zoom_email);
            $zoom_data = $coursecalendar->zoom;

            return view('web_coursecalendar.coursecalendar_register_view',compact('coursecalendar', 'zoom', 'zoom_data'));
        }else{
            return abort(404);
        }
    }
    public function register_upload_payment(Request $request , $id)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar_register.id', $id)
        ->where('users_id', Auth::id())
        ->select(DB::raw('coursecalendar.*, coursecalendar_register.id as meeting_register_id, count(coursecalendar_register.id) as register_count, file_payment'))
        ->groupBy('coursecalendar.id')
        ->first();
        if (Auth::check() and $coursecalendar) {
            $data_validate = array(
                'file_upload' =>  'required|mimes:jpeg,png,jpg,gif|max:12288‬'
            );

            $request->validate($data_validate);
            $photo = $request->file('file_upload');
            $extension = $photo->getClientOriginalExtension();
            $name = sha1(date('YmdHis') . Str::random(30));
            $Repic_name = $name . '.' . $extension;

            $data_insert = array(
                'file_payment' => $Repic_name,
                'note' => $request->note,
            );

            if (!is_dir($this->photos_path)) {
                mkdir($this->photos_path, 0777);
            }
            $directory_save=$this->photos_path."/".$coursecalendar->id;
            if (!is_dir($directory_save)) {
                mkdir($directory_save, 0777);
            }

            Image::make($photo)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($directory_save . '/' . $Repic_name);

            $file_old=$directory_save."/".$coursecalendar->file_payment;
            if($coursecalendar->file_payment!=NULL and file_exists($file_old)){
                unlink($file_old);
            }
            CoursecalendarRegister::where('id', $coursecalendar->meeting_register_id)
            ->update($data_insert);
            return redirect()->route('web.register_coursecalendar_view', $coursecalendar->meeting_register_id)->with('success','Upload Payment successfully.');
        }else{
            return abort(404);
        }
    }

    public function register_coursecalendar_confirm(Request $request , $id)
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar.id', $id)
        ->where('coursecalendar.open_register', '1')
        ->select(DB::raw('coursecalendar.*, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->first();
        $status=status_meeting($coursecalendar->register_start_date, $coursecalendar->register_end_date);
        if (Auth::check()) {
            if ($status==true){
                if ($coursecalendar->register_count<$coursecalendar->number_participants){
                    $coursecalendar_register = CoursecalendarRegister::where('coursecalendar_id', $coursecalendar->id)
                    ->where('users_id', Auth::id())
                    ->get();
                    $count_register = $coursecalendar_register->count();
                    $data_validate = array(
                        'tell' => 'required',
                        );
                    $data_insert = array(
                            'tell' => $request->tell,
                            'address' => $request->address,
                            'coursecalendar_id' => $coursecalendar->id,
                            'users_id' => Auth::id(),
                        );
                    $request->validate($data_validate);
                    if($count_register==0){
                        $data = CoursecalendarRegister::create($data_insert); // save news
                        return redirect()->route('web.register_coursecalendar_view',$data->id)->with('success','Registered successfully');
                    }else{
                        return back()->withErrors(['You have already registered.'])->withInput();
                    }
                }else{
                    return back()->withErrors([''.__('Full registration!').''])->withInput();
                }
            }else{
                return back()->withErrors(['Not in the registration period!'])->withInput();
            }
        }else{
            return redirect()->route('web.coursecalendar')->withErrors(['Please login!'])->withInput();
        }
    }
    public function get_events(Request $request)
    {
        if($request)
        {
        $start = (!empty($request->start)) ? ($request->start) : ('');
        $end = (!empty($request->end)) ? ($request->end) : ('');
        $data = Coursecalendar::whereDate('start_date', '>=', $start)
        ->whereDate('end_date',   '<=', $end)
        ->where('type_calendar', $request->type_calendar)
        ->select( 'id', DB::raw("'".route('web.coursecalendar_data','')."' as url"), 'name as title',DB::raw("start_date as start"), DB::raw("end_date as end")
          )->get();
        return Response::json($data)->header('Content-Type', 'application/json');
        }
    }

    public function meeting_your_list()
    {
        $meeting = Coursecalendar::join('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
            ->select(DB::raw("coursecalendar.id, coursecalendar_register.id as meeting_register_id, coursecalendar.name, start_date, end_date ,confirm_meeting,'coursecalendar' as table_name, coursecalendar.created_at"))
            ->where('users_id', Auth::id())
            ->latest()
            ->paginate(10);
        return view('web_coursecalendar.meeting_list_register',compact('meeting'))->with('i', (request()->input('meeting', 1) - 1) * 10);
    }
}
