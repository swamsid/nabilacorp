<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_productresult extends Model
{
    protected $table = 'd_productresult';
    protected $primaryKey = 'pr_id';
    const CREATED_AT = 'pr_insert';
    const UPDATED_AT = 'pr_update';
    
      protected $fillable = ['pr_id',
      						 'pr_spk',
      						 'pr_date', 
      						 'pr_item'];
}
