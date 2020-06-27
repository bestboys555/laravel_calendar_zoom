<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursecalendarRegister extends Model
{
    protected $table = 'coursecalendar_register';
    protected $fillable = [
        'tell', 'address', 'file_payment', 'confirm_meeting','coursecalendar_id','users_id','note'
    ];
}
