<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_spk extends Model
{  
    protected $table = 'd_spk';
    protected $primaryKey = 'spk_id';
    const CREATED_AT = 'spk_insert';
    const UPDATED_AT = 'spk_update';
    
      protected $fillable = ['spk_id','spk_ref','spk_date', 'spk_item', 'spk_code','spk_status','spk_comp'];
}
	
	