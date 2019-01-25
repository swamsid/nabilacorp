<?php

namespace App\Modules\Purchase\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\m_itemm;
use App\m_price;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\Purchase\model\d_payable;
use App\Modules\Purchase\model\d_payable_dt;
use DB;

use Auth;
use Carbon\carbon;
use Excel;




class PembayaranHutangController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
      return view('Purchase::pembayaranhutang/index');
    }

    public function find_d_payable(Request $req) {
      $d_payable = d_payable::leftJoin('d_payable_dt', 'p_id', '=', 'pd_payable') ;

      $tgl_awal = $req->tgl_awal;
      $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
      $tgl_akhir = $req->tgl_akhir;
      $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
      if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);


        $d_payable = $d_payable->whereBetween('p_date', array($tgl_awal, $tgl_akhir));
      }

      $d_payable = $d_payable->groupBy('p_id'); 
      $d_payable = $d_payable->select('p_id', 'p_code', 'p_ref', 'p_supplier', 'p_date', 'p_value', 'p_duedate', 'p_duedate', 'p_outstanding', DB::raw('IFNULL(SUM(pd_value), 0) AS p_pay'))->get();

      $data = array('data' => $d_payable);

      return response()->json($data);
    }

    public function find_d_payable_dt($p_id) {
      $d_payable_dt = d_payable_dt::where('pd_payable', $p_id)->get();
      $data = array('data' => $d_payable_dt);

      return response()->json($data);
    }

    public function insert_d_payable_dt(Request $req) {

      DB::beginTransaction();
      try {

        $pd_payable = $req->pd_payable;
        $pd_payable = $pd_payable != null ? $pd_payable : '';
        $pd_datepay = $req->pd_datepay;
        $pd_datepay = $pd_datepay != null ? $pd_datepay : '';
        $pd_datepay = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $pd_datepay);;

        $pd_value = $req->pd_value;
        $pd_value = $pd_value != null ? $pd_value : '';

        $pd_detailid = DB::table('d_payable_dt')->where('pd_payable', $pd_payable)->select( DB::raw('IFNULL(MAX(pd_detailid), 0) AS count_detailid') )->get()->first();
        $pd_detailid = $pd_detailid->count_detailid + 1;
        // Input ke tabel d_payable_dt
        $d_payable_dt = new d_payable_dt; 
        $d_payable_dt->pd_payable = $pd_payable;
        $d_payable_dt->pd_detailid = $pd_detailid;
        $d_payable_dt->pd_datepay = $pd_datepay;
        $d_payable_dt->pd_value = $pd_value;
        $d_payable_dt->save();
        // =================================s=========

        // Update jumlah terbayar dan sisa pembayaran ke tabel d_payable
        $d_payable = d_payable::find($pd_payable);
        $d_payable_data = $d_payable->first();
        $p_pay = $d_payable_dt->where('pd_payable', $pd_payable)->sum('pd_value');
        $p_outstanding = d_payable::where('p_id', $pd_payable)->get()->first()->p_value - $p_pay;
        $d_payable->p_outstanding = $p_outstanding;
        $d_payable->save();
        // ==================================================================


        DB::commit();
        $res = array('status' => 'sukses' );
      }
      catch(\Exception $e) {
        DB::rollback();
        
        $res = array('status' => 'Error. ' . $e);
      }
      return response()->json($res);
    }

    // public function laporan_pembayaran_hutang(Request $req) {

    //  $d_payable = d_payable::leftJoin('d_payable_dt', 'p_id', '=', 'pd_payable') ;

    //   $tgl_awal = $req->tgl_awal;
    //   $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
    //   $tgl_akhir = $req->tgl_akhir;
    //   $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
    //   if($tgl_awal != '' && $tgl_akhir != '') {
    //     $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
    //     $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);


    //     $d_payable = $d_payable->whereBetween('p_date', array($tgl_awal, $tgl_akhir));
    //   }

    //   $d_payable = $d_payable->groupBy('p_id'); 
    //   $d_payable_data = $d_payable->select('p_id', 'p_code', 'p_ref', 'p_supplier', 'p_date', 'p_value', 'p_duedate', 'p_duedate', 'p_outstanding', DB::raw('IFNULL(SUM(pd_value), 0) AS p_pay'))->get();
    //   $d_payable_total_hutang = $d_payable->sum('p_value');
    //   $d_payable_total_hutang_belum_terbayar = $d_payable->sum('p_outstanding');
    //   $d_payable_total_hutang_terbayar = $d_payable->sum('pd_value');


    //   Excel::create('Transaction '.date('d-m-y'), function($excel) use ($d_payable_data,$d_payable_total_hutang,$d_payable_total_hutang_belum_terbayar,$d_payable_total_hutang_terbayar){        
    //         $excel->sheet('Data Penjualan', function($sheet) use ($d_payable_data,$d_payable_total_hutang,$d_payable_total_hutang_belum_terbayar,$d_payable_total_hutang_terbayar) {
    //             $sheet->loadView('Purchase::pembayaranhutang/laporan_pembayaran_hutang')
    //             ->with('d_payable_data',$d_payable_data)                
    //             ->with('d_payable_total_hutang',$d_payable_total_hutang)
    //             ->with('d_payable_total_hutang_belum_terbayar',$d_payable_total_hutang_belum_terbayar)
    //             ->with('d_payable_total_hutang_terbayar',$d_payable_total_hutang_terbayar);

    //         });
    //     })->download('xls');

    // }

    public function laporan_pembayaran_hutang(Request $req) {

     $d_payable = d_payable::leftJoin('d_payable_dt', 'p_id', '=', 'pd_payable') ;

      $tgl_awal = $req->tgl_awal;
      $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
      $tgl_akhir = $req->tgl_akhir;
      $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
      if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);


        $d_payable = $d_payable->whereBetween('p_date', array($tgl_awal, $tgl_akhir));
      }

      $d_payable = $d_payable->groupBy('p_id'); 
      $d_payable_data = $d_payable->select('p_id', 'p_code', 'p_ref', 'p_supplier', 'p_date', 'p_value', 'p_duedate', 'p_duedate', 'p_outstanding', DB::raw('IFNULL(SUM(pd_value), 0) AS p_pay'))->get();
      $d_payable_total_hutang = $d_payable->sum('p_value');
      $d_payable_total_hutang_belum_terbayar = $d_payable->sum('p_outstanding');
      $d_payable_total_hutang_terbayar = $d_payable->sum('pd_value');

      $d_payable_detail = $d_payable_data;
      foreach ($d_payable_detail as $data) {
        $payments = d_payable_dt::where('pd_payable', $data->p_id)->get();
        $data['payments'] = $payments;
      }

      $d_payable_data_req = array(
        "d_payable_data" => $d_payable_data,
        "d_payable_total_hutang" => $d_payable_total_hutang,
        "d_payable_total_hutang_belum_terbayar" => $d_payable_total_hutang_belum_terbayar,
        "d_payable_total_hutang_terbayar" => $d_payable_total_hutang_terbayar
      );

      $d_payable_detail_req = array(
        "d_payable_detail" => $d_payable_detail
      );

      Excel::create('Transaction '.date('d-m-y'), function($excel) use ($d_payable_data_req, $d_payable_detail_req){        
            $excel->sheet('Data Pembayaran Piutang', function($sheet) use ($d_payable_data_req) {
                $sheet->loadView('Purchase::pembayaranhutang/laporan_pembayaran_hutang', $d_payable_data_req);

            });

            $excel->sheet('Detail Pembayaran Piutang', function($sheet) use ($d_payable_detail_req) {
                $sheet->loadView('Purchase::pembayaranhutang/laporan_detail_pembayaran_hutang', $d_payable_detail_req);

            });
        })->download('xlsx');

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
   /* public function cut(){
      $connector = new FilePrintConnector("\\\TAZIZ-PC\Purchase-80");
      $printer = new Printer($connector);
      $printer -> cut();
      $printer -> close();

    }*/
    // =======================================================
}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/