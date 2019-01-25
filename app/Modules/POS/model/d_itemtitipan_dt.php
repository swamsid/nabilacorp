<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Datatables;

use App\Lib\format;

use App\Lib\mutasi;

use Session;

class d_itemtitipan_dt extends Model
{  
    protected $table = 'd_itemtitipan_dt';
    protected $primaryKey = 'idt_itemtitipan';
    const CREATED_AT = 'idt_created';
    const UPDATED_AT = 'idt_updated';

    protected $fillable = ['idt_itemtitipan','idt_detailid','idt_date','idt_item','idt_qty','idt_price','idt_terjual','idt_sisa','idt_return_qty','idt_return_titip','idt_action','idt_comp','idt_position','idt_status'];

    static function itemTitipanDt($id){

	   	$titipan_dt=d_itemtitipan_dt::
	   						 select('i_id','i_code','idt_itemtitipan','idt_detailid','idt_date','idt_item','idt_qty','idt_price','i_name','m_satuan.s_name','s_qty','idt_terjual','idt_return_qty','idt_return_titip','idt_action','idt_comp','idt_position',DB::raw(" (select sum(sd_qty) from d_sales_dt where sd_item=idt_item and idt_date=sd_date and idt_comp=sd_comp and idt_position=sd_position group by sd_date) as terjual"))
	   						->join('m_item','idt_item','=','i_id')
	    				    ->join('m_satuan','s_id','=','i_satuan')
	    				    ->Leftjoin('d_stock',function($join){
	    				    	$join->on('s_item','=','i_id');
	    				    	$join->on('s_comp','=','idt_comp');
	    				    	$join->on('s_position','=','idt_position');

	    				    })
	    				    ->where('idt_itemtitipan',$id)	    				    
	    				    ->get();

	    				   
		return $titipan_dt;
    }

    static function editTitipanDt($id){

	   	$titipan_dt=d_itemtitipan_dt::
	   						 select('i_id','i_code','idt_itemtitipan','idt_detailid','idt_date','idt_item','idt_qty','idt_price','i_name','m_satuan.s_name','s_qty','idt_terjual','idt_return_qty','idt_return_titip','idt_action','idt_comp','idt_position',DB::raw(" (select sum(sd_qty) from d_sales_dt where sd_item=idt_item and idt_date=sd_date and idt_comp=sd_comp and idt_position=sd_position group by sd_date) as terjual"))
	   						->join('m_item','idt_item','=','i_id')
	    				    ->join('m_satuan','s_id','=','i_satuan')
	    				    ->leftjoin('d_stock',function($join){
	    				    	$join->on('s_item','=','i_id');
	    				    	$join->on('s_comp','=','idt_comp');
	    				    	$join->on('s_position','=','idt_position');

	    				    })
	    				    ->where('idt_itemtitipan',$id)	    				    
	    				    ->get();
	    				   
		return $titipan_dt;

    }
   
}
	