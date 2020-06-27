<?php

namespace App\Http\Controllers;

use App\News;
use App\News_category;
use App\Meeting;
use App\Coursecalendar;
use App\Banner;
use App\Hospital;
use App\Doctor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WebpageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = Coursecalendar::where('show_index', '1')
            ->select("coursecalendar.name"
            ,"coursecalendar.id"
            ,"coursecalendar.created_at"
            , DB::raw("'coursecalendar' as table_name"))
        ->latest()
        ->limit(12)
        ->get();
        return view('home',compact('news'));
    }

    public function search(Request $request)
    {
        $search = $request->q;
        $news = Coursecalendar::select("coursecalendar.name"
            ,"coursecalendar.detail"
            ,"coursecalendar.id"
            ,"coursecalendar.created_at"
            , DB::raw("'coursecalendar' as table_name"))
            ->where('coursecalendar.name', 'LIKE', "%{$search}%")
            ->orWhere('coursecalendar.detail', 'LIKE', "%{$search}%")
        ->latest()
        ->paginate(10);

        return view('search',compact('news'));
    }
}
