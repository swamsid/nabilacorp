<?php

namespace App\Modules\Inventory\model;

use Illuminate\Database\Eloquent\Model;

use DB;

class d_mutationitem_material extends Model
{

    protected $table = 'd_mutationitem_material';
    protected $primaryKey = 'mm_mutationitem';
    const CREATED_AT = 'mm_create';
    const UPDATED_AT = 'mm_update';

      protected $fillable = ['mm_mutationitem','mm_comp','mm_position','mm_detailid','mm_item','mm_qty','mm_hpp'];

      static function mutasiItemDt($id){
        dd('1');
      	 $mm=d_mutationitem_material::join('m_item','mm_item','=','i_id')
      							 ->join('m_satuan','i_satuan','=','s_id')
      							 ->join('d_stock','s_item','=','mm_item')
      							 ->where('mm_mutationitem',$id)
      							 ->get();

      							 return $mm;


      }

    }
