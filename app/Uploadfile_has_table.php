<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploadfile_has_table extends Model
{
    protected $table = 'uploadfile_has_table';
    protected $fillable = [
        'uploadfile_id', 'title', 'table_name' ,'ref_table_id','is_cover','section_order'
    ];
}
