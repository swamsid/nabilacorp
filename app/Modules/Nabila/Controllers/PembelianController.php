<?php

namespace App\Modules\Nabila\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_itemm;

use App\Http\Controllers\Controller;

use App\Modules\Nabila\model\d_shop_purchase_order;
use App\Modules\Nabila\model\d_shop_purchaseorder_dt;

use Datatables;
use Session;

class PembelianController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
   public function update_spo_status(Request $req) {
      $spo_id = $req->spo_id;
      $spo_id = $spo_id != null ? $spo_id : '';
      $spo_status = $req->spo_status;
      $spo_status = $spo_status != null ? $spo_status : '';
      if($spo_id != '' && $spo_status != '') {

        $d_shop_purchase_order = d_shop_purchase_order::find($spo_id);
        $d_shop_purchase_order->spo_status = $spo_status;
        $d_shop_purchase_order->save();
        $res = [
          'status' => 'sukses'
        ];
      }
      else {
        $res = [
          'status' => 'error',
          'message' => 'Data tidak lengkap'
        ]; 
      }

      return response()->json($res);
   } 
   
   public function seachItemNabila(Request $request){
         return m_itemm::seachItemNabila($request);
   }
   public function storePlan(Request $request){
      return d_purchase_order::simpan($request);

   }
   public function index(){     

     return view( 'Nabila::pembelian/index' );
   }
   
    function find_d_shop_purchase_order(Request $req) {

       $data = array();
       $rows = d_shop_purchase_order::leftJoin('m_supplier', 'spo_supplier', '=', 's_id')->leftJoin('d_mem', 'spo_mem', '=', 'm_id');


       // Filter datatable
       $start = $req->start;
       $start = $start != null ? $start : 0;
       $length = $req->length;
       $length = $length != null ? $length : 10;
       $search = $req->search;
       $search = $search['value'];

       // Filter berdasarkan tanggal, status & keyword
       $keyword = $req->keyword;
       $keyword = $keyword != null ? $keyword : '';
       $spo_status = $req->spo_status;
       $spo_status = $spo_status != null ? $spo_status : '';
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_akhir);
        $rows = $rows->whereBetween('spo_date', array($tgl_awal, $tgl_akhir));
       }
       if($keyword != '') {
        $rows = $rows->where('spo_code', 'LIKE', DB::raw("'%$keyword%'"));
       }
       if($spo_status != '') {
        $rows = $rows->where('spo_status', $spo_status);
       }

       $rows = $rows->skip($start)->take($length);

       $rows = $rows->select('spo_disc_percent', 'spo_disc_value', 'spo_tax_percent', 'spo_tax_value', 'spo_total_gross', 'spo_total_net', 'spo_date_confirm', DB::raw('DATE_FORMAT(spo_date_confirm, "%d/%m/%Y") AS spo_date_confirm_label'), 'spo_method', 'spo_total_net', DB::raw('CONCAT("Rp ", FORMAT(spo_total_net, 0)) AS spo_total_net_label'), 'm_name', 'spo_id', DB::raw('DATE_FORMAT(spo_date, "%d/%m/%Y") AS spo_date_label'), 'spo_code', 's_company', 'spo_status', DB::raw("CASE spo_status WHEN 'WT' THEN 'Waiting ' WHEN 'PE' THEN 'Dapat Diedit' WHEN 'AP' THEN 'Disetujui' WHEN 'NAP' THEN 'Tidak Disetujui' END AS spo_status_label"))->get();
       

       $res = array('data' => $rows);
       return response()->json($res);
    }

    function find_d_shop_purchaseorder_dt($id) {

      $d_shop_purchaseorder_dt = d_shop_purchaseorder_dt::leftJoin('m_item', 'spodt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');  
      $d_shop_purchaseorder_dt = $d_shop_purchaseorder_dt->where('spodt_purchaseorder', $id)->select('s_id', 's_name', 'spodt_item','spodt_qty','spodt_price','spodt_satuan','i_id','i_code','i_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();

       $res = array('d_shop_purchaseorder_dt' => $d_shop_purchaseorder_dt);
       return response()->json($res);
    }
   
   function insert_d_shop_purchase_order(Request $request){
      $spo_date = $request->spo_date;
      $spo_date = $spo_date != null ? $spo_date : '';
      $spo_date = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $spo_date);
      // membuat kode purchase order
      $firstdate = date('Y-m-01', strtotime($spo_date));
      $enddate = date('Y-m-31', strtotime($spo_date));
      $order_number = d_shop_purchase_order::select( DB::raw('IFNULL(COUNT(spo_id) + 1, 1) AS order_number') )->whereBetween('spo_date', [$firstdate, $enddate]);
      $order_number = $order_number->first()->order_number; 
      $spo_code = DB::raw("(SELECT CONCAT('PO/', DATE_FORMAT('$spo_date', '%m%y'), '/', LPAD($order_number, 4, '0')))");
      // ================================================================================
      $spo_id = d_shop_purchase_order::select( DB::raw('IFNULL(MAX(spo_id) + 1, 1) AS spo_id') );
      $spo_id = $spo_id->first()->spo_id;
      $spo_mem = $request->spo_mem;
      $spo_mem = $spo_mem != null ? $spo_mem : '';
      $spo_supplier = $request->spo_supplier;
      $spo_supplier = $spo_supplier != null ? $spo_supplier : '';
      $spo_purchaseplan = $request->spo_purchaseplan;
      $spo_purchaseplan = $spo_purchaseplan != null ? $spo_purchaseplan : '';
      $spo_method = $request->spo_method;
      $spo_method = $spo_method != null ? $spo_method : '';

      $spo_total_gross = $request->spo_total_gross;
      $spo_total_gross = $spo_total_gross != null ? preg_replace('/\D/', '', $spo_total_gross) : 0;
      $spo_total_net = $request->spo_total_net;
      $spo_total_net = $spo_total_net != null ? preg_replace('/\D/', '', $spo_total_net) : 0;
      $spo_disc_value = $request->spo_disc_value;
      $spo_disc_value = $spo_disc_value != null ? preg_replace('/\D/', '', $spo_disc_value) : 0;
      $spo_tax_percent = $request->spo_tax_percent;
      $spo_tax_percent = $spo_tax_percent != null ? $spo_tax_percent : 0;
      $spo_comp = Session::get('user_comp');
      DB::beginTransaction();
      try {

        $spo_id = DB::table('d_shop_purchase_order')->select(DB::raw('IFNULL(MAX(spo_id), 0) + 1 AS new_id'))->get()->first()->new_id;
        $grand_total = 0;
        
        $d_shop_purchaseorder_dt = new d_shop_purchaseorder_dt();

        $spodt_item = $request->spodt_item;
        $spodt_item = $spodt_item != null ? $spodt_item : array();
        if( count($spodt_item) > 0 ) {
            $spodt_qty = $request->spodt_qty;
            $spodt_qty = $spodt_qty != null ? $spodt_qty : array();
            $spodt_qty = $request->spodt_qty;
            $spodt_qty = $spodt_qty != null ? $spodt_qty : array();
            $spodt_qtyconfirm = $request->spodt_qtyconfirm;
            $spodt_qtyconfirm = $spodt_qtyconfirm != null ? $spodt_qtyconfirm : array();
            $spodt_price = $request->spodt_price;
            $spodt_price = $spodt_price != null ? $spodt_price : array();
            $spodt_satuan = $request->spodt_satuan;
            $spodt_satuan = $spodt_satuan != null ? $spodt_satuan : array();

            $units = [];
            for($x = 0; $x < count($spodt_item);$x++) {
                $total = $spodt_qty[$x] * $spodt_price[$x];
                $grand_total += $total;
                $unit = [
                  'spodt_detailid' => $x + 1,
                  'spodt_purchaseorder' => $spo_id,
                  'spodt_item' => $spodt_item[$x],
                  'spodt_qty' => $spodt_qty[$x],
                  'spodt_qtyconfirm' => $spodt_qtyconfirm[$x],
                  'spodt_price' => $spodt_price[$x],
                  'spodt_satuan' => $spodt_satuan[$x],
                  'spodt_total' => $total
                ];
                array_push($units, $unit);
            }

            d_shop_purchaseorder_dt::insert($units);            
        }

        d_shop_purchase_order::insert([
          'spo_id' => $spo_id,
          'spo_comp' => $spo_comp,
          'spo_date' => $spo_date,
          'spo_purchaseplan' => $spo_purchaseplan,
          'spo_supplier' => $spo_supplier,
          'spo_code' => $spo_code,
          'spo_mem' => $spo_mem,
          'spo_method' => $spo_method,
          'spo_disc_value' => $spo_disc_value,
          'spo_tax_percent' => $spo_tax_percent,
          'spo_total_gross' => $spo_total_gross,
          'spo_total_net' => $spo_total_net,
          'spo_status' => 'WT',
        ]);



        DB::commit();
        $status = 'sukses';
      }
      catch(\Exception $e) {
        DB::rollback();
        $status = 'gagal. ' . $e;
      }
      $res = array( 'status' => $status);

      return response()->json($res);
    }
    
    function update_d_shop_purchase_order(Request $request){
      $spo_id = $request->spo_id;
      $spo_id = $spo_id != null ? $spo_id : '';  

      if($spo_id != '') {
        DB::beginTransaction();
        try {
          d_shop_purchaseorder_dt::where('spodt_purchaseorder', $spo_id)->delete();

          $spodt_item = $request->spodt_item;
          $spodt_item = $spodt_item != null ? $spodt_item : array();
          if( count($spodt_item) > 0 ) {

              $spodt_qty = $request->spodt_qty;
              $spodt_qty = $spodt_qty != null ? $spodt_qty : array();
              $spodt_qtyconfirm = $request->spodt_qtyconfirm;
              $spodt_qtyconfirm = $spodt_qtyconfirm != null ? $spodt_qtyconfirm : array();
              $spodt_price = $request->spodt_price;
              $spodt_price = $spodt_price != null ? $spodt_price : array();
              $spodt_satuan = $request->spodt_satuan;
              $spodt_satuan = $spodt_satuan != null ? $spodt_satuan : array();

              $units = array();
              for($x = 0; $x < count($spodt_item);$x++) {
                  array_push($units, array(
                    "spodt_purchaseorder" => $spo_id,
                    "spodt_detailid" => $x + 1,
                    "spodt_item" => $spodt_item[$x],
                    "spodt_qty" => $spodt_qty[$x],
                    "spodt_qtyconfirm" => $spodt_qtyconfirm[$x],
                    "spodt_price" => $spodt_price[$x],
                    "spodt_satuan" => $spodt_satuan[$x],
                    "spodt_total" => $spodt_price[$x] * $spodt_qtyconfirm[$x]

                  ));
              }
          }
          d_shop_purchaseorder_dt::insert($units);

          $spo_total_gross = $request->spo_total_gross;
          $spo_total_gross = $spo_total_gross != null ? $spo_total_gross : 0;
          $spo_total_gross = preg_replace('/\D/', '', $spo_total_gross);
          $spo_total_net = $request->spo_total_net;
          $spo_total_net = $spo_total_net != null ? $spo_total_net : 0;
          $spo_total_net = preg_replace('/\D/', '', $spo_total_net);
          $spo_disc_value = $request->spo_disc_value;
          $spo_disc_value = $spo_disc_value != null ? $spo_disc_value : 0;
          $spo_disc_value = preg_replace('/\D/', '', $spo_disc_value);
          $spo_tax_percent = $request->spo_tax_percent;
          $spo_tax_percent = $spo_tax_percent != null ? $spo_tax_percent : 0;

          d_shop_purchase_order::where('spo_id', $spo_id)->update([
            'spo_disc_value' => $spo_disc_value,
            'spo_tax_percent' => $spo_tax_percent,
            'spo_total_gross' => $spo_total_gross,
            'spo_total_net' => $spo_total_net
          ]);

          DB::commit();
          $res = array(
            'status' => 'sukses'
          );
        }
        catch(\Exception $e) {
          DB::rollback();
          $res = array(
            'status' => 'Gagal. ' . $e
          );
        }  
      }
      else {
        $res = array(
          'status' => 'ID Kosong'
        );
      }
      

      return response()->json($res);
    }

   
   public function form_insert()
    {        
         $gudang = DB::table('d_gudangcabang')->leftJoin('m_comp', 'gc_comp', '=', 'c_id');
         $gudang = $gudang->where('gc_gudang', 'GUDANG NABILASTORE');
         $gudang = $gudang->select('gc_id', 'c_name', 'gc_gudang')->get();

         $res = [
            'gudang' => $gudang
         ];
         return view('Nabila::pembelian/form_insert', $res);
    }

    public function form_update($id)
    {
        $d_shop_purchase_order = d_shop_purchase_order::leftJoin('m_supplier', 'spo_supplier', '=', 's_id')->leftJoin('d_shop_purchase_plan', 'spo_purchaseplan', '=', 'sp_id');
        $d_shop_purchase_order = $d_shop_purchase_order->where('spo_id', $id)->select('sp_code','s_company', 'spo_id','spo_date', 'spo_comp','spo_code','spo_mem','spo_method', 'spo_purchaseplan', 'spo_disc_value', 'spo_tax_percent', 's_company',  DB::raw('DATE_FORMAT(spo_date, "%d-%m-%Y") AS spo_date_label'))->first();

        $d_shop_purchaseorder_dt = d_shop_purchaseorder_dt::leftJoin('m_item', 'spodt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');  
        $d_shop_purchaseorder_dt = $d_shop_purchaseorder_dt->where('spodt_purchaseorder', $id)->select('s_id', 's_name', 'spodt_item','spodt_qty', 'spodt_qtyconfirm', 'spodt_price','spodt_satuan','i_id','i_code','i_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();

        $res = [
          'd_shop_purchase_order' => $d_shop_purchase_order,
          'd_shop_purchaseorder_dt' => $d_shop_purchaseorder_dt
        ];  
        return view('Nabila::pembelian/form_update', $res);
    }

    public function preview($id)
    {
        $d_shop_purchase_order = d_shop_purchase_order::leftJoin('m_supplier', 'spo_supplier', '=', 's_id')->leftJoin('d_shop_purchase_plan', 'spo_purchaseplan', '=', 'sp_id');
        $d_shop_purchase_order = $d_shop_purchase_order->where('spo_id', $id)->select('sp_code','s_company', 'spo_id','spo_date', 'spo_comp','spo_code','spo_mem','spo_method', 'spo_purchaseplan', 'spo_disc_value', 'spo_tax_percent', 's_company',  DB::raw('DATE_FORMAT(spo_date, "%d-%m-%Y") AS spo_date_label'))->first();

        $d_shop_purchaseorder_dt = d_shop_purchaseorder_dt::leftJoin('m_item', 'spodt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');
        $comp = Session::get('user_comp');  
        $d_shop_purchaseorder_dt = $d_shop_purchaseorder_dt->where('spodt_purchaseorder', $id)->select('s_id', 's_name', 'spodt_item','spodt_qty', 'spodt_qtyconfirm', 'spodt_price','spodt_satuan','i_id','i_code','i_name', DB::raw("IFNULL((SELECT s_qty FROM d_stock S JOIN d_gudangcabang G ON S.s_position = G.gc_id WHERE s_item = m_item.i_id AND gc_gudang = 'GUDANG NABILAMOSLEM' AND gc_comp = $comp), 0) AS s_qty"))->get();

        $res = [
          'd_shop_purchase_order' => $d_shop_purchase_order,
          'd_shop_purchaseorder_dt' => $d_shop_purchaseorder_dt
        ];  
        return view('Nabila::pembelian/preview', $res);
    }

   

    public function tambah_pembelian()
    {
        return view('/purchasing/returnpembelian/tambah_pembelian');
    }
    public function tambah_order()
    {
        
    }
    public function bahan()
    {
        return view('/purchasing/rencanabahanbaku/bahan');
    }

    public function hapus($id) { 
      // Menghapus purchasing harian 

      DB::beginTransaction();
      try {
        d_shop_purchaseorder_dt::where('spodt_purchaseorder', $id)->delete();
        
        d_shop_purchase_order::where('spo_id', $id)->delete();


        DB::commit();
        $status = 'sukses';
      }
      catch(\Exception $e) {
        DB::rollback();
        $status = 'gagal. ' . $e;
      }
      $res = array( 'status' => $status);

      return response()->json($res);
    }

}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/