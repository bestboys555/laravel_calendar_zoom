<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zoom_meeting extends Model
{
    protected $table = 'zoom_meeting';
    protected $fillable = [
        'meeting_id', 'zoom_id' , 'password', 'meeting_type', 'start_time', 'duration', 'timezone', 'start_url', 'join_url', 'timezone'
    ];

    public function zoomable()
    {
            return $this->morphTo();
    }
}
