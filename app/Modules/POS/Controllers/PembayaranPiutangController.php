<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\m_itemm;
use App\m_price;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\d_receivable;
use App\Modules\POS\model\d_receivable_dt;
use App\Modules\POS\model\d_sales;
use DB;

use Auth;
use Excel;





class PembayaranPiutangController extends Controller
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
      return view('POS::pembayaranpiutang/index');
    }

    public function find_d_receivable(Request $req) {
      $tgl_awal = $req->tgl_awal;
      $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
      $tgl_akhir = $req->tgl_akhir;
      $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
      $tgl_awal = str_replace('/', '-',$tgl_awal);
      $tgl_akhir = str_replace('/', '-',$tgl_akhir);

      if($tgl_awal != '' && $tgl_akhir != '') {

        $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);

        $d_receivable = d_receivable::whereBetween('r_date', array($tgl_awal, $tgl_akhir))->get();
      }
      else {

        $d_receivable = d_receivable::all();
      }
      $data = array('data' => $d_receivable);

      return response()->json($data);
    }

    public function insert_d_receivable_dt(Request $req) {

      DB::beginTransaction();
      try {

        $rd_receivable = $req->rd_receivable;
        $rd_receivable = $rd_receivable != null ? $rd_receivable : '';
        $rd_datepay = $req->rd_datepay;
        $rd_datepay = $rd_datepay != null ? $rd_datepay : '';
        $rd_datepay = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $rd_datepay);

        $rd_value = $req->rd_value;
        $rd_value = $rd_value != null ? $rd_value : '';

        $d_receivable = d_receivable::where('r_id',$rd_receivable);        
        $tamp=$d_receivable;

        
        $rd_detailid = DB::table('d_receivable_dt')->where('rd_receivable', $rd_receivable)->select( DB::raw('IFNULL(COUNT(rd_detailid), 0) AS count_detailid') )->get()->first();
        $rd_detailid = $rd_detailid->count_detailid + 1;
        // Input ke tabel d_receivable_dt
        $d_receivable_dt = new d_receivable_dt;
        $d_receivable_dt->rd_receivable = $rd_receivable;
        $d_receivable_dt->rd_detailid = $rd_detailid;
        $d_receivable_dt->rd_datepay = $rd_datepay;
        $d_receivable_dt->rd_value = $rd_value;
        $d_receivable_dt->rd_outstanding=$tamp->first()->r_outstanding;
        $d_receivable_dt->save();
        // ==========================================

        // Update jumlah terbayar dan sisa pembayaran ke tabel d_receivable        
        $r_pay = $d_receivable_dt->where('rd_receivable', $rd_receivable)->sum('rd_value');
        $r_outstanding = d_receivable::where('r_id', $rd_receivable)->get()->first()->r_value - $r_pay;

        $d_receivable->update([
          'r_pay' => $r_pay,
          'r_outstanding' => $r_outstanding
          ]);
        
        $codeSales=$d_receivable->first()->r_ref;
        $d_sales=d_sales::where('s_note',$codeSales);
        $d_sales->update([
                  's_bayar'=>$r_pay
                  ]);

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

    public function laporan_pembayaran_piutang(Request $req) {

     $d_receivable = d_receivable::leftJoin('d_receivable_dt', 'r_id', '=', 'rd_receivable') ;

      $tgl_awal = $req->tgl_awal;
      $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
      $tgl_akhir = $req->tgl_akhir;
      $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
      if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);


        $d_receivable = $d_receivable->whereBetween('r_date', array($tgl_awal, $tgl_akhir));
      }

      $d_receivable = $d_receivable->groupBy('r_id'); 
      $d_receivable_data = $d_receivable->select('r_id', 'r_code', 'r_ref', 'r_date', 'r_value', 'r_duedate', 'r_duedate', 'r_outstanding', DB::raw('IFNULL(SUM(rd_value), 0) AS r_pay'))->get();
      $d_receivable_total_piutang = $d_receivable->sum('r_value');
      $d_receivable_total_piutang_belum_terbayar = $d_receivable->sum('r_outstanding');
      $d_receivable_total_piutang_terbayar = $d_receivable->sum('rd_value');

      $d_receivable_detail = $d_receivable_data;
      foreach ($d_receivable_detail as $data) {
        $payments = d_receivable_dt::where('rd_receivable', $data->r_id)->get();
        $data['payments'] = $payments;
      }

      $d_receivable_data_req = array(
        "d_receivable_data" => $d_receivable_data,
        "d_receivable_total_piutang" => $d_receivable_total_piutang,
        "d_receivable_total_piutang_belum_terbayar" => $d_receivable_total_piutang_belum_terbayar,
        "d_receivable_total_piutang_terbayar" => $d_receivable_total_piutang_terbayar
      );

      $d_receivable_detail_req = array(
        "d_receivable_detail" => $d_receivable_detail
      );

      Excel::create('Transaction '.date('d-m-y'), function($excel) use ($d_receivable_data_req, $d_receivable_detail_req){        
            $excel->sheet('Data Pembayaran Piutang', function($sheet) use ($d_receivable_data_req) {
                $sheet->loadView('POS::pembayaranpiutang/laporan_pembayaran_piutang', $d_receivable_data_req);

            });

            $excel->sheet('Detail Pembayaran Piutang', function($sheet) use ($d_receivable_detail_req) {
                $sheet->loadView('POS::pembayaranpiutang/laporan_detail_pembayaran_piutang', $d_receivable_detail_req);

            });
        })->download('xlsx');

    }
}