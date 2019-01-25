<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use app\Customer;
use Carbon\carbon;

use App\m_item;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_sales;
use App\Modules\POS\model\d_sales_dt;


class PenjualanMobileController extends Controller
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
//http://localhost/nabilacorp/penjualan/rencanapenjualan/rencana#listtoko
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function find_d_sales_dt(Request $req) {
       $data = array();

       // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
        
       $rows = d_sales_dt::leftJoin('d_sales', function($join) {
        $join->on('sd_sales', '=', 's_id');
      })->where('s_channel', 'Toko');


       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = str_replace('/', '-', $tgl_awal);
        $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
        $tgl_akhir = str_replace('/', '-', $tgl_akhir);
        $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
        $rows = $rows->whereBetween('sd_date', array($tgl_awal, $tgl_akhir));
       }
        
        $rows = $rows->orderBy('sd_date', 'DESC')->get();

       foreach ($rows as $row) {
         $new_row = $row;
         $detail = d_sales_dt::penjualanDt( $row->sd_detailid );
         $detail = $detail[0];
         $new_row['i_name'] = $detail->i_name;
         $new_row['sd_qty'] = $detail->sd_qty;
         $new_row['sd_price'] = $detail->sd_price;
         $new_row['sd_disc_percent'] = $detail->sd_disc_percent;
         $new_row['sd_disc_percentvalue'] = $detail->sd_disc_percentvalue;
         $new_row['sd_disc_value'] = $detail->sd_disc_value;
         $new_row['sd_total'] = $detail->sd_total;
         $new_row['s_nama_cus'] = '';
         $new_row['s_finishdate'] = '';
         $new_row['s_channel'] = '';

         if($row->d_sales != null) {
            $new_row['s_note'] = $row->d_sales->s_note;
            $new_row['s_nama_cus'] = $row->d_sales->s_nama_cus;
            $new_row['s_finishdate'] = $row->d_sales->s_finishdate;
         }

         $new_row['s_detname'] = '';
         if($row->m_item != null) {
            $new_row['s_detname'] = $row->m_item->m_satuan->s_detname;
         }
         array_push($data, $new_row);
       }

       $res = array('data' => $data);
       return response()->json($res);
    }

    
    public function penjualanmobile() {
      return view('POS::penjualanmobile/penjualanmobile');
    }

    public function print_laporan(Request $req) {
      $data = array();

       // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = str_replace('/', '-', $tgl_awal);
        $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
        $tgl_akhir = str_replace('/', '-', $tgl_akhir);
        $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
        $rows = d_sales_dt::whereBetween('sd_date', array($tgl_awal, $tgl_akhir))->orderBy('sd_date', 'DESC')->get();
       }

       else {
          $rows = d_sales_dt::orderBy('sd_date', 'DESC')->get();
       }

       // Menghitung total
       $total_discount = 0;
       $total_discountvalue = 0;
       $grand_total = 0;

       foreach ($rows as $row) {
         $new_row = $row;
         $detail = d_sales_dt::penjualanDt( $row->sd_detailid );
         $detail = $detail[0];
         $new_row['i_name'] = $detail->i_name;
         $new_row['sd_qty'] = $detail->sd_qty;
         $new_row['sd_price'] = $detail->sd_price;
         $new_row['sd_disc_percent'] = $detail->sd_disc_percent;
         $new_row['sd_disc_percentvalue'] = $detail->sd_disc_percentvalue;
         $new_row['sd_disc_value'] = $detail->sd_disc_value;
         $new_row['sd_total'] = $detail->sd_total;
         $new_row['s_nama_cus'] = '';
         $new_row['s_finishdate'] = '';

         $subtotal = ($detail->sd_qty * $detail->sd_price);
         $total_discountvalue += $subtotal * ($new_row['sd_disc_percent'] / 100);
         $grand_total += ($subtotal - ($subtotal * ($new_row['sd_disc_percent'] / 100)));

         if($row->d_sales != null) {
            $new_row['s_note'] = $row->d_sales->s_note;
            $new_row['s_nama_cus'] = $row->d_sales->s_nama_cus;
            $new_row['s_finishdate'] = $row->d_sales->s_finishdate;
         }

         $new_row['s_detname'] = '';
         if($row->m_item != null) {
            $new_row['s_detname'] = $row->m_item->m_satuan->s_detname;
         }
         array_push($data, $new_row);
       }

       $res = array('data' => $data, 'grand_total' => $grand_total, 'total_discountvalue' => $total_discountvalue);
       
      return view('POS::penjualanmobile/print_laporan', $res);
    }
    
}
