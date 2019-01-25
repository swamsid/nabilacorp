<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use App\m_item;

class d_sales_dt extends Model
{  
    protected $table = 'd_sales_dt';
    protected $primaryKey = 'sd_sales';
    public $timestamps=false;
    
      protected $fillable = ['sd_sales','sd_detailid','sd_item','sd_qty','sd_price','sd_disc_percent','sd_disc_value','sd_total'];
	static function penjualanDt($sd_sales=''){
		return DB::table('d_sales_dt')->join('m_item','sd_item','=','i_id')
		->join('m_satuan','s_id','=','i_satuan')->where('sd_sales',$sd_sales)
		->join('d_stock','s_item','=','i_id')
		->get();
	}
}
	
	