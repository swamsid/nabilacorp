<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Datatables;
class d_stock extends Model
{  
    protected $table = 'd_stock';
    protected $primaryKey = 's_id';
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';
    
      protected $fillable = ['s_id','s_comp','s_position', 's_item', 's_qty'];

     static function dataStok(){
     	$a=0;
     	$stock=d_stock::rightjoin('m_item',function($join){
	     	$join->on('d_stock.s_item','=','m_item.i_id');
	     	$join->on('d_stock.s_comp','=','d_stock.s_position');
     	})->leftjoin('d_gudangcabang', function($join)  use ($a) {
     		$join->on('d_gudangcabang.gc_id','=','d_stock.s_comp');     				
     	})->get();

     	return Datatables::of($stock)->make(true); 
     }
}
