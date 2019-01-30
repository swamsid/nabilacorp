<?php

namespace App\Http\Controllers\modul_keuangan\analisa\common_size;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;

use DB;
use PDF;

class analisa_common_size_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.analisa.common_size.index');
    }

    public function dataResource(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = []; $akun = [];

    	$akun = DB::table('dk_akun')
					->select(
						'ak_id as id',
						'ak_nama as nama'
                    )
					->get();

		return json_encode($akun);

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		$akun = DB::table('dk_akun')
					->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                	->where('as_periode', $tgl)
					->select(
						'ak_id as id',
						'ak_nama as nama',
						DB::raw('substring(ak_id, 1, 1) as kelompok'),
                        DB::raw('coalesce(as_saldo_akhir, 0) as saldo_akhir')
                    )
					->get();

    		// total

	    		$total1 = DB::table('dk_akun')
	    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
	                        	->where('as_periode', $tgl)
	    						->where(DB::raw('substring(ak_id, 1, 1)'), '1')
	    						->select(
		                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
		                        )
	    						->first();

		    	$total2 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '2')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

		    	$total3 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '3')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

		    	$total4 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '4')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

		    	$total4 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '4')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

		    	$total5 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '5')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

		    	$total6 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '6')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

		    	$total7 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '7')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

		    	$total8 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '8')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

		    	$total9 = DB::table('dk_akun')
		    						->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
		                        	->where('as_periode', $tgl)
		    						->where(DB::raw('substring(ak_id, 1, 1)'), '9')
		    						->select(
			                            DB::raw('coalesce(sum(as_saldo_akhir), 0) as saldo_akhir')
			                        )
		    						->first();

	    	// Total
    		array_push($data, 
    			[
    				"tanggal"		=> date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1))),
    				"total1"		=> $total1,
    				"total2"		=> $total2,
    				"total3"		=> $total3,
    				"total4"		=> $total4,
    				"total5"		=> $total5,
    				"total6"		=> $total6,
    				"total7"		=> $total7,
    				"total8"		=> $total8,
    				"total9"		=> $total9,
    			]
    		);
    	}

    	return json_encode([
    		"data"	=> $data,
    		"akun"	=> $akun
    	]);
    }
}
