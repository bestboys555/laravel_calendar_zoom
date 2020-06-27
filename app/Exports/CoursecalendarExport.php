<?php

namespace App\Exports;

use App\Coursecalendar;
use App\CoursecalendarRegister;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class CoursecalendarExport implements FromView
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $coursecalendar = Coursecalendar::leftJoin('coursecalendar_register', 'coursecalendar.id', '=', 'coursecalendar_register.coursecalendar_id')
        ->where('coursecalendar.id', $this->id)
        ->select(DB::raw('coursecalendar.*, coursecalendar_register.id as meeting_register_id, count(coursecalendar_register.id) as register_count'))
        ->groupBy('coursecalendar.id')
        ->first();

        $coursecalendar_register = CoursecalendarRegister::where('coursecalendar_id', $this->id)
        ->join('users', 'users.id', '=', 'coursecalendar_register.users_id')
        ->select(DB::raw('coursecalendar_register.*, coursecalendar_register.id as meeting_register_id, users.name, users.email, users.tell, users.address'))
        ->orderBy('coursecalendar_register.confirm_meeting', 'asc')
        ->orderBy('coursecalendar_register.file_payment', 'asc')
        ->orderBy('coursecalendar_register.id', 'asc')
        ->get();

        if($coursecalendar){
        return view('management.coursecalendar.export',compact('coursecalendar', 'coursecalendar_register'));
        }else{
            return abort(404);
        }
    }
}
