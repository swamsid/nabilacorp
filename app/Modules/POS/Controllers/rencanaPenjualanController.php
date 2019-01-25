<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_item;
use App\d_stock;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\m_machine;
use App\Modules\POS\model\d_sales_plan;
use App\Modules\POS\model\d_salesplan_dt;


use Datatables;
use Session;
use Auth;






class rencanaPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     
    
    
    public function index() { 
        $printPl=view('Produksi::sam');
        $flag='Toko';
        $paymentmethod=m_paymentmethod::pm();       
        $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));    
        $machine=m_machine::showMachineActive();      
        $data['toko']=view('POS::rencanapenjualan/toko',compact('machine'));      
        $data['listtoko']=view('POS::rencanapenjualan/listtoko');   
        return view('POS::rencanapenjualan/POSpenjualanToko',compact('data','pm','printPl'));
    }

    function simpan(Request $request){
      return d_sales_plan::simpan($request);
    }

    // Menampilkan form untuk mengupdate data
    function form_perbarui($sp_id) {
      $d_sales_plan = d_sales_plan::leftJoin('d_mem', 'm_id', '=', 'sp_mem')->where('sp_id', $sp_id)->first();
      $d_salesplan_dt = d_salesplan_dt::leftJoin('m_item', 'i_id', '=', 'spdt_item')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');
      $d_salesplan_dt = $d_salesplan_dt->where('spdt_salesplan', $sp_id)->select('i_name', 's_name', 'spdt_qty', 'i_id')->get();
      
      $data = [
        'd_sales_plan' => $d_sales_plan,
        'd_salesplan_dt' => $d_salesplan_dt
      ];
      return view('POS::rencanapenjualan/updateRencanaPenjualan', $data);
    }

    // Mengupdate data ke database
    function perbarui(Request $request){
      
      return d_sales_plan::perbarui($request);
    }

    public function hapus($id = '') {
        $transaction = DB::transaction(function() use ($id){
          $status = "gagal";
          if($id != '' ){
            $d_sales_plan = d_sales_plan::find($id);
            $d_sales_plan->delete();
            $d_salesplan_dt = d_salesplan_dt::where('spdt_salesplan', $id);
            $d_salesplan_dt->delete(); 
            $status = "sukses";
          }   

          $res = array( 'status' => $status );
          return response()->json($res);

        });

        return $transaction;
        
      }

    function find_d_sales_plan(Request $req) {
       $data = array();
       $sp_comp = Session::get('user_comp');
       $rows = d_sales_plan::leftJoin('d_salesplan_dt', 'spdt_salesplan', '=', 'sp_id')
          ->leftJoin('m_item', 'i_id', '=', 'spdt_item');
      // memilih kolom yang akan ditampilkan
      $rows = $rows->select('sp_id', 'sp_code', 'sp_comp', 'sp_mem', 'sp_date', DB::raw('IFNULL( SUM(i_price) , 0) AS total_harga'));    

        // Memfilter data
       $rows = $rows->where('sp_comp', $sp_comp);
       // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);
        $rows = $rows->whereBetween('sp_date', array($tgl_awal, $tgl_akhir));
       }

       $rows = $rows->groupBy('sp_id')->get();


       $res = array('data' => $rows);
       return response()->json($res);
    }

    function find_m_item(Request $req) {
       $data = array();
       $s_comp = $req->get('s_comp');
       $s_comp = $s_comp != null ? $s_comp : '';
       $term = $req->term;
       $term = $term != null ? $term : '';


       $rows = m_item::leftJoin(DB::raw('d_stock ST'), 'i_id', '=', DB::raw('ST.s_id'))->leftJoin(DB::raw('m_satuan SA'), 'i_sat1' , '=', DB::raw('SA.s_id'));
        // memfilter data yang ditampilkan
        if($term != '') {
              $rows = $rows->where('i_code', 'LIKE', "%$term%")->orWhere('i_name', 'LIKE', "%$term%");
        }
      // memilih kolom yang akan ditampilkan
        $rows = $rows->select('i_code', 'i_id', DB::raw('i_name AS label'), DB::raw('i_name AS item'), DB::raw('s_name AS satuan'), DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_comp = "$s_comp" AND s_comp = s_position), 0) AS stok'));

        $res = $rows->take(10)->get();
       return response()->json($res);
    }

    
   
}