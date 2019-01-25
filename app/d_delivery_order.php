<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_delivery_order extends Model
{
    protected $table = 'd_delivery_order';
    protected $primaryKey = 'do_id';
    const CREATED_AT = 'do_insert';
    const UPDATED_AT = 'do_update';
    
      protected $fillable = ['do_id',
                   'do_comp',
      						 'do_nota',
      						 'do_date_send', 
      						 'do_time', 
      						 'do_date_received',
      						 'spk_status'];
}
