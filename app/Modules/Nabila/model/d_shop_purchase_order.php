<?php

namespace App\Modules\Nabila\model;

use Illuminate\Database\Eloquent\Model;

class d_shop_purchase_order extends Model
{  



    protected $table = 'd_shop_purchase_order';
    protected $primaryKey = 'spo_id';
    const CREATED_AT = 'spo_created';
    const UPDATED_AT = 'spo_updated';

}
	