<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pengajuan_pelatihandt extends Model
{
  protected $table = 'd_pengajuan_pelatihandt';
  protected $primaryKey = 'ppd_pp';
  protected $fillable = [ 'ppd_pp',
                          'ppd_detailid',
                          'ppd_fpd_fp',
                          'pp_fpd_det',
                          'pp_fpd_ket'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;

}
