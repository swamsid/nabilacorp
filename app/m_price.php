<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Response;

class m_price extends Model
{  
    protected $table = 'm_price';
    protected $primaryKey = 'm_pid';
    
    const CREATED_AT = 'm_pcreated';
    const UPDATED_AT = 'm_pupdated';
    public function m_item() {
    	$res = $this->belongsTo('App\m_itemm', 'm_pitem', 'i_id');

    	return $res;
    }
}