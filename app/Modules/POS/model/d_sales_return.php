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


class d_sales_return extends Model
{  
    protected $table = 'd_sales_return';
    protected $primaryKey = 'dsr_id';

    const CREATED_AT = 'dsr_created';
    const UPDATED_AT = 'dsr_updated';    
}
	
?>
