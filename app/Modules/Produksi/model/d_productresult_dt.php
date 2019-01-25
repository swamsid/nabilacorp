<?php

namespace App\Modules\Produksi\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Datatables;

use App\Lib\format;

use App\Lib\mutasi;

class d_productresult_dt extends Model
{  


    protected $table 		= 'd_productresult_dt';
    protected $primaryKey 	= 'prdt_productresult';
    const CREATED_AT		= 'prdt_created';
    const UPDATED_AT 		= 'prdt_updated';
    
    protected $fillable = ['prdt_productresult','prdt_detailid','prdt_comp','prdt_date','prdt_item','prdt_qty','prdt_qty_sisa','prdt_status','prdt_hpp','prdt_time','prdt_position'];

   

  }

  