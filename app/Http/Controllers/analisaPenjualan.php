<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class analisaPenjualan extends Controller
{
    public function index(Request $request){

    	$d1 = date('Y-m-d', strtotime($request->date1));
    	$d2 = date('Y-m-d', strtotime($request->date2));

    	if($request->type == 1){
    		
    		$data = DB::table('d_sales_dt as a')
    					->join('m_item', 'a.sd_item', '=', 'i_id')
    					->where('a.sd_date', '>=', $d1)
    					->where('a.sd_date', '<=', $d2)
    					->distinct('a.sd_item')
    					->select('a.sd_item', DB::raw('sum(a.sd_qty) as total'), 'i_name', 'i_code')
    					->groupBy('a.sd_item')
    					->limit($request->counter)
    					->orderBy('total', 'desc')
    					->get();

    		$dataNama = []; $dataValue = [];

    		foreach ($data as $key => $dta) {
    			$dataNama[$key] = $dta->i_name;
    			$dataValue[$key] = $dta->total;
    		}

    		$dataNama = json_encode($dataNama);
    		$dataValue = json_encode($dataValue);

    		return view('analisaPenjualan1', compact('data', 'request', 'dataNama', 'dataValue'));

    	}else{

    		$head = DB::table('d_sales_dt as a')
    					->leftJoin('m_item', 'a.sd_item', '=', 'i_id')
    					->where('a.sd_date', '>=', $d1)
    					->where('a.sd_date', '<=', $d2)
    					->where('a.sd_item', $request->id_item)
    					->distinct('a.sd_item')
    					->select(DB::raw('coalesce(sum(a.sd_qty), 0) as total'))
    					->groupBy('a.sd_item')
    					->first();

    		$item = DB::table('m_item')->where('i_id', $request->id_item)->first();

    		$headValue = ($head) ? $head->total : 0;
    		$headNama = ($item) ? $item->i_name : 'Tidak Diketahui';

    		$data = DB::table('d_sales_dt as a')
    					->join('d_sales', 's_id', '=', 'sd_sales')
    					->where('sd_item', $request->id_item)
    					->where('a.sd_date', '>=', $d1)
    					->where('a.sd_date', '<=', $d2)
    					->select('s_date', 's_note', 'sd_qty')
    					->get();

    		$dataNama = []; $dataValue = [];

    		$diffSearch = date_diff(date_create($d1), date_create($d2));
    		$diff = (int)$diffSearch->format("%a") + 1;
    		
    		$dc1 = date('Y-m-d', strtotime('-'.$diff.' days', strtotime($d1)));
    		$dc2 = date('Y-m-d', strtotime('-'.$diff.' days', strtotime($d2)));

    		$ctn = 0;

    		for ($i = 0; $i < 5; $i++) {
    			$head = DB::table('d_sales_dt as a')
	    					->join('m_item', 'a.sd_item', '=', 'i_id')
	    					->where('a.sd_date', '>=', $dc1)
	    					->where('a.sd_date', '<=', $dc2)
	    					->where('a.sd_item', $request->id_item)
	    					->distinct('a.sd_item')
	    					->select('a.sd_item', DB::raw('sum(a.sd_qty) as total'), 'i_name', 'i_code')
	    					->groupBy('a.sd_item')
	    					->first();

	    		if(!$head){
		    		$dataNama[$ctn] = 'Periode (-'.($i+1).')';
		    		$dataValue[$ctn] = 0;
		    	}
		    	else{
		    		$dataNama[$ctn] = 'Periode (-'.($i+1).')';
		    		$dataValue[$ctn] = $head->total;
		    	}

	    		$dc1 = date('Y-m-d', strtotime('-'.$diff.' days', strtotime($dc1)));
    			$dc2 = date('Y-m-d', strtotime('-'.$diff.' days', strtotime($dc2)));
		    	
		    	$ctn++;
    		}
		    
		    $dataNama = json_encode(array_reverse($dataNama));
		    $dataValue = json_encode(array_reverse($dataValue));

    		// return $dataValue;

    		return view('analisaPenjualan2', compact('request', 'data', 'headNama', 'headValue', 'dataNama', 'dataValue'));
    	}
    }
}
