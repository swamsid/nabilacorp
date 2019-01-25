<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

use App\Lib\format;

use App\m_item;

use DB;

use Auth;

use Datatables;

use Carbon\Carbon;



class d_purchaseorder_dt extends Model
{  



 



    protected $table = 'd_purchaseorder_dt';
    protected $primaryKey = 'podt_id';
    const CREATED_AT = 'podt_created';
    const UPDATED_AT = 'podt_updated';
    
      protected $fillable =    ['podt_purchaseorder',
                                'podt_detailid',
                                'podt_item',
                                'podt_purchaseplandt',
                                'podt_qty',
                                'podt_qtyconfirm',
                                'podt_price',
                                'podt_prevcost',
                                'podt_total',
                                'podt_isconfirm',
                                'podt_created',
                                'podt_updated'  
                              ];
  
    
     

  
}
	
	