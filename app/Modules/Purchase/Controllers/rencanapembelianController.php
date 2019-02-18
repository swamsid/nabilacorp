<?php

namespace App\Modules\Purchase\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\carbon;
use DB;
use App\Http\Controllers\Controller;
use App\mMember;
use Datatables;
use Session;
use App\m_supplier;

class rencanapembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function rencana()
    {
        return view('/purchasing/rencanapembelian/rencana');
    }
   
    public function create()
    {
        $gudang = DB::table('d_gudangcabang')
            ->select('gc_id','gc_gudang','c_name')
            ->join('m_comp','m_comp.c_id','=','gc_comp')
            ->where('gc_comp',Session::get('user_comp'))
            ->where(function ($query) {
                $query->where('gc_gudang', '=', 'GUDANG PENJUALAN')
                      ->orWhere('gc_gudang', '=', 'GUDANG BAHAN BAKU');
            })->get();
  
        $supplier = m_supplier::select('s_id','s_name')->get();

        return view('Purchase::rencanapembelian/create',compact('gudang','supplier'));
    }

}