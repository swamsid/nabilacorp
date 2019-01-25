<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'm_jabatan' ;

    protected $fillable = [
        'c_posisi','c_id','c_divisi_id','c_sub_divisi_id'
    ];
}
