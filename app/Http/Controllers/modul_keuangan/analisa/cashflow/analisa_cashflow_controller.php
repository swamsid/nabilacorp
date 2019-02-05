<?php

namespace App\Http\Controllers\modul_keuangan\analisa\cashflow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;

use DB;
use PDF;

class analisa_cashflow_controller extends Controller
{
    public function index(){
    	return view('modul_keuangan.analisa.cashflow.index');
    }

    public function dataResource(Request $request){
    	$d1 = explode('/', $request->d1)[0].'-01-01';
    	$data = [];

    	$kelompokAkun = level_2::where("hld_cashflow", "OCF")
    								->select('hld_id')
        							->get();

    	for ($i=0; $i < 12; $i++) {

    		$tgl = date('Y-m-d', strtotime('+'.($i).' months', strtotime($d1)));

    		array_push($data, 
    			[
    				
    			]
    		);
    	}

    	return json_encode([
    		"data"	=> $data
    	]);
    }
}
