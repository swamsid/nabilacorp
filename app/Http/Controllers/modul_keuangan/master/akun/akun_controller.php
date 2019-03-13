<?php

namespace App\Http\Controllers\modul_keuangan\master\akun;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use keuangan;

class akun_controller extends Controller
{
    public function index(){
    	$data = DB::table('dk_akun as a')
    				->join('dk_hierarki_lvl_dua as b', 'a.ak_kelompok', '=', 'b.hld_id')
                    ->where('ak_comp', modulSetting()['onLogin'])
    				->select('a.*', 'b.hld_nama as kelompok')
    				->get();

    	// return json_encode($data);

    	return view('modul_keuangan.master.akun.index', compact('data'));
    }

    public function create(){
    	return view('modul_keuangan.master.akun.form');
    }

    public function datatable(Request $request){
    	$data = DB::table('dk_akun')
                    ->where('ak_comp', modulSetting()['onLogin'])
                    ->orderBy('ak_nomor')
                    ->get();

    	return json_encode($data);
    }

    public function form_resource(){
    	$akun = DB::table('dk_akun')
                    ->where('ak_comp', modulSetting()['onLogin'])
                    // ->where('ak_isactive', '1')
                    ->select('ak_id as id', 'ak_nama as text', 'ak_nomor as nomor', 'ak_kelompok as kelompok')
                    ->orderBy('ak_nomor', 'asc')
                    ->get();

        $kelompok = DB::table('dk_hierarki_lvl_dua')
                        ->select('hld_id as id', DB::raw('concat(hld_nomor, " - ", hld_nama) as text'), 'hld_nomor as nomor')
                        ->orderBy('hld_nomor')
                        ->get();

    	return json_encode([
    		"akun_parrent"		=> $akun,
            "kelompok"          => $kelompok
    	]);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

        $cek = DB::table('dk_hierarki_lvl_dua')
                    ->where('hld_id', $request->ak_kelompok)
                    ->first();

        if(!$cek){
            $response = [
                "status"    => 'error',
                "message"   => 'Kelompok Akun Tidak Bisa Ditemukan, Cobalah Untuk Memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        $ids = $cek->hld_nomor.'.'.$request->ak_nomor;
        $cek2 = DB::table('dk_akun')
                    ->where('ak_nomor', $ids)
                    ->where('ak_comp', modulSetting()['onLogin'])->first();

        if($cek2){
            $response = [
                "status"    => 'error',
                "message"   => 'Nomor Akun Sudah Digunakan Oleh Akun Lain, Data Tidak Bisa Disimpan'
            ];

            return json_encode($response);
        }

        try {
            

            $id = DB::table('dk_akun')->max('ak_id') + 1;

            DB::table('dk_akun')->insert([
                'ak_id'             => $id,
                'ak_nomor'          => $ids,
                'ak_tahun'          => date('Y'),
                'ak_comp'           => modulSetting()['onLogin'],
                'ak_nama'           => $request->ak_nama,
                'ak_kelompok'       => $request->ak_kelompok,
                'ak_posisi'         => $request->ak_posisi,
                'ak_opening_date'   => date('Y-m-d'),
                'ak_sub_id'         => $request->ak_nomor,
                'ak_resiprokal'     => isset($request->resiprokal) ? '1' : '0',
                'ak_opening'        => ($request->ak_opening) ? str_replace(',', '', $request->ak_opening) : 0,
            ]);

            keuangan::akunSaldo()->addAkun($id);

            $akun = DB::table('dk_akun')
                    ->where('ak_comp', modulSetting()['onLogin'])
                    // ->where('ak_isactive', '1')
                    ->select('ak_id as id', 'ak_nama as text', 'ak_nomor as nomor', 'ak_kelompok as kelompok')
                    ->orderBy('ak_nomor', 'asc')
                    ->get();

            $response = [
                'status'        => 'berhasil',
                'message'       => 'Data Akun Berhasil Disimpan',
                'akun_parrent'  => $akun
            ];

            DB::commit();
            return json_encode($response);

        } catch (\Exception $e) {
            $response = [
                "status"    => 'error',
                "message"   => 'System Mengalami Masalah. Err: '.$e,
            ];

            return json_encode($response);
        }

    }

    public function update(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

    	$cek = DB::table('dk_akun')->where('ak_id', $request->ak_id);

    	if(!$cek->first()){
    		$response = [
    			"status"	=> 'error',
    			"message"	=> 'Data Akun Tidak Bisa Ditemukan, Cobalah Memuat Ulang Halaman'
    		];

    		return json_encode($response);
    	}

        $cek2 = DB::table('dk_hierarki_lvl_dua')
                    ->where('hld_id', $request->ak_kelompok)
                    ->first();

        if(!$cek2){
            $response = [
                "status"    => 'error',
                "message"   => 'Kelompok Akun Tidak Bisa Ditemukan, Cobalah Untuk Memuat Ulang Halaman'
            ];

            return json_encode($response);
        }

        $ids = $cek2->hld_nomor.'.'.$request->ak_nomor;
        $cek3 = DB::table('dk_akun')
                    ->where('ak_nomor', $ids)
                    ->where('ak_comp', modulSetting()['onLogin'])->first();

        if($cek3){
            $response = [
                "status"    => 'error',
                "message"   => 'Nomor Akun Sudah Digunakan Oleh Akun Lain, Data Tidak Bisa Disimpan'
            ];

            return json_encode($response);
        }

    	try {

            $opening = ($request->ak_opening) ? str_replace(',', '', $request->ak_opening) : 0;
            $posisi = $cek->first()->ak_posisi;
            $openingDB = $cek->first()->ak_opening;

			$cek->update([
                'ak_nomor'          => $ids,
                'ak_kelompok'       => $request->ak_kelompok,
    			'ak_nama'			=> $request->ak_nama,
    			'ak_posisi'			=> $request->ak_posisi,
                'ak_sub_id'         => $request->ak_nomor,
                'ak_resiprokal'     => isset($request->resiprokal) ? '1' : '0',
    			'ak_opening'		=> ($request->ak_opening) ? str_replace(',', '', $request->ak_opening) : 0,
			]);

            if($opening != $openingDB || $posisi != $request->ak_posisi){
                keuangan::akunSaldo()->updateAkun($request->ak_id);
            }

            $akun = DB::table('dk_akun')
                        ->where('ak_comp', modulSetting()['onLogin'])
                        // ->where('ak_isactive', '1')
                        ->select('ak_id as id', 'ak_nama as text', 'ak_nomor as nomor', 'ak_kelompok as kelompok')
                        ->orderBy('ak_nomor', 'asc')
                        ->get();

			$response = [
    			'status'		=> 'berhasil',
    			'message'		=> 'Data Akun Berhasil Diperbarui',
                'akun_parrent'  => $akun
    		];

    		DB::commit();
    		return json_encode($response);

    	} catch (\Exception $e) {
    		$response = [
    			"status"	=> 'error',
    			"message"	=> 'System Mengalami Masalah. Err: '.$e,
    		];

    		return json_encode($response);
    	}
    }

    public function delete(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

    	$active = '';
    	$cek = DB::table('dk_akun')->where('ak_id', $request->ak_id);

    	try {
    		
    		if(!$cek->first()){
    			$response = [
	    			"status"	=> 'error',
	    			"message"	=> 'Data Akun Tidak Bisa Ditemukan, Cobalah Memuat Ulang Halaman',
	    		];

                return json_encode($response);
    		}

			$cek2 = DB::table('dk_jurnal_detail')->where('jrdt_akun', $cek->first()->ak_id)->first();

			if($cek2){
				$response = [
	    			"status"	=> 'error',
	    			"message"	=> 'Akun Ini Memiliki Histori Di Jurnal, Tidak Bisa Di Nonaktifkan',
	    		];

	    		return json_encode($response);
			}

			if($cek->first()->ak_isactive == '1'){
				$cek->update([
	    			"ak_isactive" => '0'
	    		]);

	    		$active = '0';
			}else{
				$cek->update([
	    			"ak_isactive" => '1'
	    		]);

	    		$active = '1';
			}

			$response = [
    			'status'		=> 'berhasil',
    			'active'		=> $active,
    			'message'		=> 'Data Akun Berhasil Diperbarui'
    		];

    		DB::commit();
    		return json_encode($response);

    	} catch (\Exception $e) {
    		$response = [
    			"status"	=> 'error',
    			"message"	=> 'System Mengalami Masalah. Err: '.$e,
    		];

    		return json_encode($response);
    	}
    }
}
