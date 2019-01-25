<?php

namespace App\Modules\Inventory\model;

use Illuminate\Database\Eloquent\Model;

use DB;

class d_mutationitem_product extends Model
{
    protected $table = 'd_mutationitem_product';
    protected $primaryKey = 'mp_mutationitem';
    const CREATED_AT = 'mp_create';
    const UPDATED_AT = 'mp_update';

    protected $fillable = ['mp_mutationitem','mp_detailid','mp_comp','mp_position','mp_item','mp_qty','mp_hpp'];

    static function mutasiItemDt($id){

      	return d_mutationitem_product::join('m_item','mp_item','=','i_id')
      							 ->join('m_satuan','i_satuan','=','s_id')
      							 ->join('d_stock','s_item','=','mp_item')
      							 ->where('mp_mutationitem',$id)
      							 ->get();
    }

}
