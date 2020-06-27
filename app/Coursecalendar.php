<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coursecalendar extends Model
{
    protected $table = 'coursecalendar';
    protected $fillable = [
        'name', 'type_calendar', 'location', 'target_audience', 'course_director', 'number_participants', 'price', 'detail', 'faqs', 'accommodation', 'payment_detail', 'register_start_date', 'register_end_date', 'start_date', 'end_date', 'show_index', 'open_register' , 'open_zoom' 
    ];

    public function zoom()
    {
        return $this->morphOne('App\Zoom_meeting', 'meeting');
    }
}
