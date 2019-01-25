<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

use App\Lib\mutasi;

use App\Lib\format;

use App\d_sales_payment;

use App\m_item;

use DB;

use Auth;

use Datatables;



class d_purchaseplan_dt extends Model
{  

    protected $table = 'd_purchaseplan_dt';
    protected $primaryKey = 'ppdt_pruchaseplan';
    const CREATED_AT = 'ppdt_created';
    const UPDATED_AT = 'ppdt_updated';
    
      protected $fillable = ['ppdt_pruchaseplan','ppdt_detailid','ppdt_item','ppdt_qty','ppdt_prevcost','ppdt_totalcost','ppdt_satuan','ppdt_qtyconfirm','ppdt_isconfirm','ppdt_ispo','ppdt_poid','ppdt_satuan_position'];

    
  
}
	
	