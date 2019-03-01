<?php

namespace App\Http\Controllers\modul_keuangan\setting\akun_penting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class akun_penting_controller extends Controller
{
    public function index(){
    	$cabang = '';

        if(modulSetting()['support_cabang']){
            $cabang = DB::table(tabel()->cabang->nama)
                                ->where(tabel()->cabang->kolom->id, modulSetting()['onLogin'])
                                ->select(tabel()->cabang->kolom->nama.' as nama')
                                ->first()->nama;
        }

    	return view('modul_keuangan.setting.akun_penting.index', compact('cabang'));
    }

    public function form_resource(){
    	if(modulSetting()['onLogin'] == modulSetting()['id_pusat'])
    		$level1 = DB::table('dk_akun_penting')->whereNull('ap_comp')->get();
    	else
    		$level1 = DB::table('dk_akun_penting')->where('ap_comp', modulSetting()['onLogin'])->get();

    	$akun = DB::table('dk_akun')
    				->where('ak_comp', modulSetting()['onLogin'])
    				->select('ak_id as id', DB::raw("concat(ak_nomor, ' - ', ak_nama) as text"))
    				->get();

    	return json_encode([
    		'level_1'	=> $level1,
    		'akun'		=> $akun,
    	]);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

    	try {
    		
    		for ($i = 0; $i < count($request->id); $i++) { 
    			
    			$cekAkun = DB::table('dk_akun')->where('ak_id', $request->akun[$i])->first();

    			if(!$cekAkun){
    				$response = [
		                "status"    => 'error',
		                "message"   => 'Beberap Akun Tidak Bisa Ditemukan, Cobalah Memuat Ulang Halaman',
		            ];

		            return json_encode($response);
    			}

    			DB::table('dk_akun_penting')->where('ap_id', $request->id[$i])->update([
    				'ap_akun'	=> $request->akun[$i]
    			]);

    		}

    		DB::commit();

    		$response = [
                "status"    => 'berhasil',
                "message"   => 'Data Akun Penting Berhasil Diperbarui'
            ];

            return json_encode($response);

    	} catch (\Exception $e) {
    		DB::rollback();
            $response = [
                "status"    => 'error',
                "message"   => 'System Mengalami Masalah. Err: '.$e,
            ];

            return json_encode($response);
    	}
    }
}
