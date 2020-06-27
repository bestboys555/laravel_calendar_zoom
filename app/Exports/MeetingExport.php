<?php

namespace App\Exports;

use App\Meeting;
use App\MeetingRegister;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class MeetingExport implements FromView
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $meeting = Meeting::leftJoin('meeting_register', 'meeting.id', '=', 'meeting_register.meeting_id')
        ->where('meeting.id', $this->id)
        ->select(DB::raw('meeting.*, meeting_register.id as meeting_register_id, count(meeting_register.id) as register_count'))
        ->groupBy('meeting.id')
        ->first();

        $meeting_register = MeetingRegister::where('meeting_id',  $this->id)
        ->join('users', 'users.id', '=', 'meeting_register.users_id')
        ->select(DB::raw('meeting_register.*, meeting_register.id as meeting_register_id, users.name , users.email, users.tell, users.address'))
        ->orderBy('meeting_register.confirm_meeting', 'asc')
        ->orderBy('meeting_register.file_payment', 'asc')
        ->orderBy('meeting_register.id', 'asc')
        ->get();
        if($meeting){
        return view('management.meeting.export',compact('meeting', 'meeting_register'));
        }else{
            return abort(404);
        }
    }
}
