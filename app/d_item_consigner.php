<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_item_consigner extends Model
{
	protected $table = 'd_item_consigner';
    protected $primaryKey = 'ic_id';
    protected $fillable = ['ic_id', 
    						'ic_con', 
    						'ic_item'
							];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    // const CREATED_AT = 'c_created';
    // const UPDATED_AT = 'c_updated';
}
