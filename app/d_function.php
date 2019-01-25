<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_function extends Model
{
    protected $table = 'd_function';
    protected $primaryKey = 'f_id';
    protected $fillable = ['f_name'];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
}
