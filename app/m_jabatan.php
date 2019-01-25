<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_jabatan extends Model
{
  protected $table = 'm_jabatan';
  protected $primaryKey = 'c_id';
  protected $fillable = [ 'c_id',
                          'c_divisi_id',
                          'c_sub_divisi_id',
                          'c_posisi'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'created_at';
  const UPDATED_AT = 'updated_at';
}
