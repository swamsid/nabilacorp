<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fp_detail extends Model
{
  protected $table = 'fp_detail';
  protected $primaryKey = 'fpd_id';
  protected $fillable = [ 'fpd_id',
                          'fpd_fp',
                          'fpd_det',
                          'fpd_jawab'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
}
