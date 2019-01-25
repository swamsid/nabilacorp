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


class d_receivable extends Model
{  
    protected $table = 'd_receivable';
    protected $primaryKey = 'r_id';

    const CREATED_AT = 'r_created';
    const UPDATED_AT = 'r_updated';
    
    protected $fillable = [ 'r_id',
							'r_date' ,
							'r_duedate',
							'r_type',
							'r_code',
							'r_mem' ,
							'r_customer_name',
							'r_alamat_cus',
							'r_ref',
							'r_value',
							'r_pay',
							'r_outstanding',
							'r_created',
							'r_updated',
							'r_status'
							];


}
	
?>
