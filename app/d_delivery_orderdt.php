<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_delivery_orderdt extends Model
{
    protected $table = 'd_delivery_orderdt';
    protected $primaryKey = 'dod_do';
    const CREATED_AT = 'dod_insert';
    const UPDATED_AT = 'dod_update';
    
      protected $fillable = [ 	'dod_do',
								'dod_detailid',
								'dod_item', 
								'dod_qty_send', 
								'dod_date_send',
								'dod_time_send',
								'dod_qty_received',
								'dod_date_received',
								'dod_time_received',
								'dod_status'];
}
