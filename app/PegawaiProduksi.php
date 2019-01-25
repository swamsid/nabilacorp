<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PegawaiProduksi extends Model
{
    protected $table = 'm_pegawai_pro';
    protected $fillable = [	
       'c_code', 'c_id_by_production', 'c_nik', 'c_nama', 'c_tahun_masuk', 'c_jabatan_pro_id', 'c_rumah_produksi'
    ];
}
