<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_payment extends Model
{
    protected $table = 'd_sales_payment';
    protected $primaryKey = 'sp_sales';
    protected $fillable = ['sp_sales','sp_paymentid','sp_comp','sp_method','sp_nominal','sp_date'];
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
}
