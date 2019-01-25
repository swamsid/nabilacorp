<?php

namespace App\Modules\Purchase\model;

use Illuminate\Database\Eloquent\Model;

use DB;

use Auth;

use Datatables;

use Carbon\Carbon;

use Response;



class d_payable_dt extends Model {

    protected $table = 'd_payable_dt';
    const CREATED_AT = 'pd_created';
    const UPDATED_AT = 'pd_updated';

}
