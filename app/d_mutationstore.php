<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mutationstore extends Model
{
    protected $table = 'd_mutationstore';
    protected $primaryKey = 'ms_id';
    const CREATED_AT = 'ms_insert';
    const UPDATED_AT = 'ms_update';
    
      protected $fillable = ['ms_id','ms_date','ms_item', 'ms_store', 'ms_destination','ms_qty'];
}
