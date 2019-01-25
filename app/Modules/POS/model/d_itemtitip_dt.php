<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Datatables;

use App\Lib\format;

use App\Lib\mutasi;

use Session;

class d_itemtitip_dt extends Model
{  
    protected $table = 'd_itemtitip_dt';
    protected $primaryKey = 'idt_itemtitip';
    const CREATED_AT = 'idt_created';
    const UPDATED_AT = 'idt_updated';

    protected $fillable = ['idt_itemtitip','idt_detailid','idt_date','idt_item','idt_qty','idt_price','idt_terjual','idt_return','idt_comp','idt_position'];

     



    static function itemtitipDt($id){    	    	
	   	$titip_dt=d_itemtitip_dt::
	   						 select('i_id','i_code','idt_itemtitip','idt_detailid','idt_date','idt_item','idt_qty','idt_price','idt_position','idt_comp','i_name','m_satuan.s_name','s_qty','idt_terjual','idt_return',DB::raw(" (select sd_qty from d_sales_dt where sd_item=idt_item and idt_date=sd_date) as terjual"))
	   						->join('m_item','idt_item','=','i_id')
	    				    ->join('m_satuan','s_id','=','i_satuan')	    				    
	    				    ->leftjoin('d_stock',function($join){
								$join->on('s_item','=','i_id');
								$join->on('s_comp','=','idt_comp');
								$join->on('s_position','=','idt_position');


							})
	    				    ->where('idt_itemtitip',$id)
	    				    ->get();	    				   
	    				    
		return $titip_dt;
    }
   
}
	