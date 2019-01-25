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
      // return Auth::user();
       // return Session::get('user_comp');
            $gudang = DB::table('d_gudangcabang')
            ->join('m_comp','m_comp.c_id','=','gc_comp')
            ->where('gc_comp',Session::get('user_comp'))
            ->where(function ($query) {
                $query->where('gc_gudang', '=', 'GUDANG PENJUALAN')
                      ->orWhere('gc_gudang', '=', 'GUDANG BAHAN BAKU');
            })->get();
       
            // return Session::get('user_comp')
        
            // dd($gudang);
        return view('Purchase::rencanapembelian/create',compact('gudang'));
    }
    // url('/////')?{{ time() }}
}