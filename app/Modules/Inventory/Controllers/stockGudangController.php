<?php

namespace App\Modules\Inventory\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\d_stock;
use Datatables;

class stockGudangController extends Controller
{
    public function index(){
    	$cabang=Session::get('user_comp');  
    	$dataGudang = DB::table('d_gudangcabang')
                    ->where('gc_comp',$cabang)
                    ->select('gc_id','gc_gudang')->get();
    	$daftar = view('Inventory::stockgudang.daftar',compact('dataGudang'));
    	return view('Inventory::stockgudang.index',compact('daftar'));
    }

    public function tableGudang($comp)
  	{
      $data = d_stock::
      select(
          'i_code',
          'i_name',
          'i_type',
          's_qty',
          's_name')
          ->where('s_comp', $comp)
          ->where('s_position', $comp)
          ->where('i_isactive','TRUE')
          ->join('m_item', 'i_id', '=', 's_item')
          ->join('m_satuan', 'm_satuan.s_id', '=', 'i_sat1')
          ->get();
      // dd($data);
      return DataTables::of($data)
          ->addIndexColumn()
          ->editColumn('s_qty', function ($data) {
              return '<div>
                        <span class="pull-right">
                          ' . number_format($data->s_qty, 0, ',', '.') . '
                        </span>
                      </div>';
          })

          ->editColumn('type', function ($data)
          {
              if ($data->i_type == "BJ")
              {
                  return 'Barang Jual';
              }
              elseif ($data->i_type == "BP")
              {
                  return 'Barang Produksi';
              }
              elseif ($data->i_type == "BB")
              {
                  return 'Bahan Baku';
              }
          })

          ->editColumn('item', function ($data) {
              return '<div>
                        '.$data->i_code. ' - ' .$data->i_name.'
                      </div>';
          })

          ->rawColumns(['item','s_qty', 'type'])
          ->make(true);

  }
}
