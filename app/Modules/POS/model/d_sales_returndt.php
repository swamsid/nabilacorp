<?php

namespace App\Modules\POS\model;

use Illuminate\Database\Eloquent\Model;


use App\Modules\POS\model\d_receivable_dt;

use App\Lib\mutasi;

use App\Lib\format;


use App\m_item;

use DB;

use Auth;

use Datatables;

use Session;


class d_sales_returndt extends Model
{  
    protected $table = 'd_sales_returndt';
    protected $primaryKey = 'dsrdt_detailid';

    const CREATED_AT = 'dsrdt_created';
    const UPDATED_AT = 'dsrdt_updated';    
}
	
?>
