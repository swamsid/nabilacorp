<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    protected $table = "m_potongan";

    protected $fillable = [ 'c_nama', 'c_value' ];
}
