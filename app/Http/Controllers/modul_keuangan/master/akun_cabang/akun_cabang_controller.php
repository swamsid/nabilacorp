<?php

namespace App\Http\Controllers\modul_keuangan\master\akun_cabang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use keuangan;

class akun_cabang_controller extends Controller
{
    public function index(){
    	$data = DB::table('dk_akun_cabang as a')
    				->join('dk_hierarki_lvl_dua as b', 'a.ac_kelompok', '=', 'b.hld_id')
    				->select('a.*', 'b.hld_nama as kelompok')
    				->get();

    	return view('modul_keuangan.master.akun-cabang.index', compact('data'));
    }

    public function create(){
    	return view('modul_keuangan.master.akun-cabang.form');
    }

    public function form_resource(){
    	$akun = DB::table('dk_akun_cabang')
                    // ->where('ak_isactive', '1')
                    ->select('ac_id as id', 'ac_nama as text', 'ac_nomor as nomor')
                    ->orderBy('ac_nomor', 'asc')
                    ->get();

        $kelompok = DB::table('dk_hierarki_lvl_dua')
                        ->select('hld_id as id', DB::raw('concat(hld_id, " - ", hld_nama) as text'))
                        ->get();

    	return json_encode([
    		"akun_parrent"		=> $akun,
            "kelompok"          => $kelompok
    	]);
    }

    public function datatable(Request $request){
    	$data = DB::table('dk_akun_cabang')
                    ->get();

    	return json_encode($data);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

        $ids = $request->ak_kelompok.'.'.$request->ak_nomor;
        $cek = DB::table('dk_akun_cabang')
                    ->where('ac_nomor', $ids)->first();

        if($cek){
            $response = [
                "status"    => 'error',
                "message"   => 'Nomor Akun Sudah Ada, Data Tidak Bisa Disimpan'
            ];

            return json_encode($response);
        }

        try {
           
            $id = DB::table('dk_akun_cabang')->max('ac_id') + 1;

            DB::table('dk_akun_cabang')->insert([
                'ac_id'             => $id,
                'ac_nomor'          => $ids,
                'ac_nama'           => $request->ak_nama,
                'ac_kelompok'       => $request->ak_kelompok,
                'ac_posisi'         => $request->ak_posisi,
                'ac_opening_date'   => date('Y-m-d'),
                'ac_sub_id'         => $request->ak_nomor,
                'ac_resiprokal'     => isset($request->resiprokal) ? '1' : '0',
            ]);

            $response = [
                'status'        => 'berhasil',
                'message'       => 'Data Akun Cabang Berhasil Disimpan'
            ];

            $akun = DB::table('dk_akun_cabang')
	                    // ->where('ak_isactive', '1')
	                    ->select('ac_id as id', 'ac_nama as text', 'ac_nomor as nomor')
	                    ->orderBy('ac_nomor', 'asc')
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

    	$cek = DB::table('dk_akun_cabang')->where('ac_id', $request->ak_id);

    	if(!$cek->first()){
    		$response = [
    			"status"	=> 'error',
    			"message"	=> 'Data Akun Cabang Tidak Bisa Ditemukan, Cobalah Memuat Ulang Halaman'
    		];

    		return json_encode($response);
    	}

    	try {

			$cek->update([
    			'ac_nama'			=> $request->ak_nama,
    			'ac_posisi'			=> $request->ak_posisi,
                'ac_resiprokal'     => isset($request->resiprokal) ? '1' : '0',
			]);

            $akun = DB::table('dk_akun_cabang')
                        // ->where('ak_isactive', '1')
                        ->select('ac_id as id', 'ac_nama as text', 'ac_nomor as nomor')
                        ->orderBy('ac_nomor', 'asc')
                        ->get();

			$response = [
    			'status'		=> 'berhasil',
    			'message'		=> 'Data Akun Cabang Berhasil Diperbarui',
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
    	$cek = DB::table('dk_akun_cabang')->where('ac_id', $request->ak_id);

    	try {
    		
    		if($cek->first()){
    			$response = [
	    			"status"	=> 'error',
	    			"message"	=> 'Data Akun Cabang Tidak Bisa Ditemukan, Cobalah Memuat Ulang Halaman',
	    		];
    		}

			if($cek->first()->ac_isactive == '1'){
				$cek->update([
	    			"ac_isactive" => '0'
	    		]);

	    		$active = '0';
			}else{
				$cek->update([
	    			"ac_isactive" => '1'
	    		]);

	    		$active = '1';
			}

			$response = [
    			'status'		=> 'berhasil',
    			'active'		=> $active,
    			'message'		=> 'Data Akun Cabang Berhasil Diperbarui'
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
