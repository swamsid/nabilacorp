<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_productresult_dt extends Model
{
    protected $table = 'd_productresult_dt';
    protected $primaryKey = 'prdt_productresult';
    
      protected $fillable = ['prdt_productresult',
					      						 'prdt_detail',
					      						 'prdt_item', 
					      						 'prdt_qty',
					      						 'prdt_kirim',
					      						 'prdt_sisa',
					      						 'prdt_produksi',
					      						 'prdt_status',
					      						 'prdt_date',
					      						 'prdt_time'];
		public $timestamps = false;
}
