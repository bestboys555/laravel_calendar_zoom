<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploadfile extends Model
{
    protected $table = 'uploadfile';
    protected $fillable = [
        'name', 'name_thumb', 'folder', 'file_extension', 'tmp_key', 'tmp_key', 'users_id'
    ];
}
