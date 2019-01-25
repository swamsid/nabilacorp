<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

use App\Lib\format;

use App\m_item;

use DB;

use Auth;

use Datatables;

use Carbon\Carbon;

use Response;



class d_purchase_return extends Model {

    protected $table = 'd_purchase_return';
    protected $primaryKey = 'pr_id';
    const CREATED_AT = 'pr_created';
    const UPDATED_AT = 'pr_updated';

}
