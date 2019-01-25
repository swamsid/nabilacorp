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
    				->join('dk_akun as b', 'b.ak_id', '=', 'a.ak_kelompok')
    				->where('a.ak_type', 'detail')
    				->select('a.*', 'b.ak_nama as kelompok')
    				->get();

    	// return json_encode($data);

    	return view('modul_keuangan.master.akun.index', compact('data'));
    }

    public function create(){
    	return view('modul_keuangan.master.akun.form');
    }

    public function datatable(Request $request){
    	$data = DB::table('dk_akun')->where('ak_type', $request->type)->get();

    	return json_encode($data);
    }

    public function form_resource(){
    	$akun = DB::table('dk_akun')->where('ak_type', 'parrent')->where('ak_isactive', '1')->select('ak_id as id', 'ak_nama as text')->get();
    	$neraca = DB::table('dk_akun_group')->where('ag_type', 'N')->where('ag_isactive', '1')->select('ag_id as id', 'ag_nama as text')->get();
    	$arusKas = DB::table('dk_akun_group')->where('ag_type', 'A')->where('ag_isactive', '1')->select('ag_id as id', 'ag_nama as text')->get();
    	$labaRugi = DB::table('dk_akun_group')->where('ag_type', 'LR')->where('ag_isactive', '1')->select('ag_id as id', 'ag_nama as text')->get();

    	return json_encode([
    		"akun_parrent"		=> $akun,
    		"group_neraca"		=> $neraca,
    		"arus_kas"			=> $arusKas,
    		"laba_rugi"			=> $labaRugi
    	]);
    }

    public function store(Request $request){
    	// return json_encode($request->all());

    	DB::beginTransaction();

    	$ids = $request->ak_kelompok.'.'.$request->ak_nomor;
    	$cek = DB::table('dk_akun')->where('ak_id', $ids)->first();

    	if($cek){
    		$response = [
    			"status"	=> 'error',
    			"message"	=> 'Nomor Akun Sudah Digunakan Oleh Akun Lain, Data Tidak Bisa Disimpan'
    		];

    		return json_encode($response);
    	}

    	try {
    		
    		if($request->ak_type == 'parrent'){
	    		
	    		DB::table('dk_akun')->insert([
	    			'ak_id'			=> $ids,
	    			'ak_tahun'		=> date('Y'),
	    			'ak_comp'		=> 1,
	    			'ak_nama'		=> $request->ak_nama,
	    			'ak_kelompok'	=> $request->ak_kelompok,
	    			'ak_type'		=> $request->ak_type,
	    		]);

	    		$response = [
	    			'status'		=> 'berhasil',
	    			'message'		=> 'Data Akun Berhasil Disimpan',
	    			'akun_parrent'	=> DB::table('dk_akun')->where('ak_type', 'parrent')->where('ak_isactive', '1')->select('ak_id as id', 'ak_nama as text')->get()
	    		];

	    	}else{
	    		DB::table('dk_akun')->insert([
	    			'ak_id'				=> $ids,
	    			'ak_tahun'			=> date('Y'),
	    			'ak_comp'			=> 1,
	    			'ak_nama'			=> $request->ak_nama,
	    			'ak_kelompok'		=> $request->ak_kelompok,
	    			'ak_posisi'			=> $request->ak_posisi,
	    			'ak_type'			=> $request->ak_type,
	    			'ak_group_neraca'	=> $request->ak_group_neraca,
	    			'ak_group_lr'		=> $request->ak_group_lr,
	    			'ak_group_ak'		=> $request->ak_group_ak,
	    			'ak_opening_date'	=> date('Y-m-d'),
	    			'ak_opening'		=> ($request->ak_opening) ? str_replace(',', '', $request->ak_opening) : 0,
	    		]);

                keuangan::akunSaldo()->addAkun($ids);

	    		$response = [
	    			'status'		=> 'berhasil',
	    			'message'		=> 'Data Akun Berhasil Disimpan'
	    		];
	    	}

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

    	try {
    		
    		if($cek->first()->ak_type == 'parrent'){

    			$cek->update([
    				'ak_nama'	=> $request->ak_nama,
    			]);

    			$response = [
	    			'status'		=> 'berhasil',
	    			'message'		=> 'Data Akun Berhasil Diperbarui',
	    			'akun_parrent'	=> DB::table('dk_akun')->where('ak_type', 'parrent')->where('ak_isactive', '1')->select('ak_id as id', 'ak_nama as text')->get()
	    		];

    		}else{

                $opening = ($request->ak_opening) ? str_replace(',', '', $request->ak_opening) : 0;
                $posisi = $cek->first()->ak_posisi;
                $openingDB = $cek->first()->ak_opening;

    			$cek->update([
	    			'ak_nama'			=> $request->ak_nama,
	    			'ak_posisi'			=> $request->ak_posisi,
	    			'ak_group_neraca'	=> $request->ak_group_neraca,
	    			'ak_group_lr'		=> $request->ak_group_lr,
	    			'ak_group_ak'		=> $request->ak_group_ak,
	    			'ak_opening'		=> ($request->ak_opening) ? str_replace(',', '', $request->ak_opening) : 0,
    			]);

                 if($opening != $openingDB || $posisi != $request->ak_posisi){
                    keuangan::akunSaldo()->updateAkun($request->ak_id);
                 }

    			$response = [
	    			'status'		=> 'berhasil',
	    			'message'		=> 'Data Akun Berhasil Diperbarui'
	    		];
    		}

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
    		
    		if($cek->first()){
    			$response = [
	    			"status"	=> 'error',
	    			"message"	=> 'Data Akun Tidak Bisa Ditemukan, Cobalah Memuat Ulang Halaman',
	    		];
    		}

    		if($cek->first()->ak_type == 'parrent'){

    			$cek2 = DB::table('dk_akun')->where('ak_kelompok', $cek->first()->ak_id)->first();

    			if($cek2){
    				$response = [
		    			"status"	=> 'error',
		    			"message"	=> 'Akun Ini Memiliki Detail, Tidak Bisa Di Nonaktifkan',
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
	    			'message'		=> 'Data Akun Berhasil Diperbarui',
	    			'active'		=> $active,
	    			'akun_parrent'	=> DB::table('dk_akun')->where('ak_type', 'parrent')->where('ak_isactive', '1')->select('ak_id as id', 'ak_nama as text')->get()
	    		];

    		}else{
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

    		}

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
