<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_plan extends Model
{
    protected $table = 'd_sales_plan';
    protected $primaryKey = 'sp_id';
   
      protected $fillable = ['sp_id',
      						  'sp_code',
      						  'sp_comp',
      						  'sp_status', 
      						  'sp_mem', 
      						  'sp_date'
      						];
    const CREATED_AT = 'sp_created';
    const UPDATED_AT = 'sp_updated';
}
