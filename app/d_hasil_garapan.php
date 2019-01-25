<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_hasil_garapan extends Model
{
  protected $table = 'd_hasil_garapan';
  protected $primaryKey = 'd_hg_id';
  protected $fillable = [ 'd_hg_id',
                          'd_hg_pid',
                          'd_hg_tgl',
                          'd_hg_cid',
                          'd_hg_gaji',
                          'd_hg_lembur'
                          ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'd_hg_created';
  const UPDATED_AT = 'd_hg_updated';
}
