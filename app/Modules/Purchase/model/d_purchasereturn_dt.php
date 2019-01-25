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



class d_purchasereturn_dt extends Model {

    protected $table = 'd_purchasereturn_dt';
    const CREATED_AT = 'prdt_created';
    const UPDATED_AT = 'prdt_updated';

}
