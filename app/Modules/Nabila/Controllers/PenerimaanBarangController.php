<?php

namespace App\Modules\Nabila\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_itemm;

use App\Http\Controllers\Controller;
use App\Lib\mutation;

use App\Modules\Nabila\model\d_shop_purchase_order;
use App\Modules\Nabila\model\d_shop_purchaseorder_dt;
use App\Modules\Nabila\model\d_shop_terima_pembelian;
use App\Modules\Nabila\model\d_shop_terima_pembelian_dt;

use Datatables;
use Session;

class PenerimaanBarangController extends Controller
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
     * @return \Illuminate\Http\Restbnse
     */
    
   public function update_stb_status(Request $req) {
      $stb_id = $req->stb_id;
      $stb_id = $stb_id != null ? $stb_id : '';
      $stb_status = $req->stb_stfatus;
      $stb_status = $stb_status != null ? $stb_status : '';
      if($stb_id != '' && $stb_status != '') {

        $d_shop_terima_pembelian = d_shop_terima_pembelian::find($stb_id);
        $d_shop_terima_pembelian->stb_status = $stb_status;
        $d_shop_terima_pembelian->save();
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
      return d_terima_pembelian::simpan($request);

   }
   public function index(){     

     return view( 'Nabila::penerimaanbarang/index' );
   }
   

    function find_d_shop_terima_pembelian(Request $req) {

       $data = array();
       $rows = d_shop_terima_pembelian::leftJoin('m_supplier', 'stb_sup', '=', 's_id')->leftJoin('d_mem', 'stb_staff', '=', 'm_id')->leftJoin('d_shop_purchase_order', 'stb_pid', '=', 'spo_id');

       $rows = $rows->leftJoin('d_shop_terima_pembelian_dt', 'stb_id', '=', 'stbdt_idtb');

       // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_akhir);
        $rows = $rows->whereBetween('stb_date', array($tgl_awal, $tgl_akhir));
       }

       $rows = $rows->select( 'stb_date', DB::raw('DATE_FORMAT(stb_date, "%d/%m/%Y") AS stb_date_label'), 'stb_totalnett', DB::raw('CONCAT("Rp ", FORMAT(stb_totalnett, 0)) AS stb_total_net_label'), 'm_name', 'stb_id', DB::raw('DATE_FORMAT(stb_date, "%d/%m/%Y") AS stb_date_label'), 'stb_code', 'spo_code', 'stb_noreff', 's_company')->get();
       

       $res = array('data' => $rows);
       return response()->json($res);
    }

    function find_d_shop_terima_pembelian_dt($id = '') {

      $d_shop_terima_pembelian_dt = d_shop_terima_pembelian_dt::leftJoin('m_item', 'stbdt_item', '=', 'i_id')
        ->leftJoin('m_satuan', 'i_sat1', '=', DB::raw('m_satuan.s_id'))
        ->leftJoin('d_shop_terima_pembelian', 'stbdt_id', '=', 'stb_id')
        ->leftJoin('d_shop_purchase_order', 'stb_pid', '=', 'spo_id')
        ->leftJoin('d_shop_purchaseorder_dt', 'spodt_purchaseorder', '=', 'spo_id')
        ->leftJoin('m_supplier', 'spo_supplier', '=', DB::raw('m_supplier.s_id'));
      if($id != '') {
        $d_shop_terima_pembelian_dt = $d_shop_terima_pembelian_dt->where('stbdt_idtb', $id);
      }  
      $d_shop_terima_pembelian_dt  = $d_shop_terima_pembelian_dt->select(DB::raw('DATE_FORMAT(stb_date, "%d/%m/%Y") AS stb_date_label'), DB::raw('m_satuan.s_id AS s_id'),'stb_code', DB::raw('m_satuan.s_name AS s_name'), 'stbdt_item','spodt_qty','stbdt_qty','stbdt_price','i_sat1','i_id','i_code','i_name', 's_company', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();

       $res = array('data' => $d_shop_terima_pembelian_dt);
       return response()->json($res);
    }
   
    function find_d_shop_purchaseorder_dt($id) {


      $d_shop_purchaseorder_dt = d_shop_purchaseorder_dt::leftJoin('m_item', 'spodt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');  
      $d_shop_purchaseorder_dt = $d_shop_purchaseorder_dt->where('spodt_purchaseorder', $id)->select('s_id', 's_name', 'spodt_item','spodt_qty','spodt_price','spodt_satuan','i_id','i_code','i_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'), DB::raw("(SELECT IFNULL(SUM(stbdt_qty), 0) FROM d_shop_terima_pembelian_dt TBDT JOIN d_shop_terima_pembelian TB ON TBDT.stbdt_idtb = TB.stb_id WHERE d_shop_purchaseorder_dt.spodt_item = stbdt_item AND stb_pid = $id) AS qty_masuk"))->get();

       $res = array('d_shop_purchaseorder_dt' => $d_shop_purchaseorder_dt);
       return response()->json($res);
    }

   function insert_d_shop_terima_pembelian(Request $request){
      $stb_date = $request->stb_date;
      $stb_date = $stb_date != null ? $stb_date : '';
      $stb_date = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $stb_date);
      // membuat kode purchase order
      $firstdate = date('Y-m-01', strtotime($stb_date));
      $enddate = date('Y-m-31', strtotime($stb_date));
      $order_number = d_shop_terima_pembelian::select( DB::raw('IFNULL(COUNT(stb_id) + 1, 1) AS order_number') )->whereBetween('stb_date', [$firstdate, $enddate]);
      $order_number = $order_number->first()->order_number; 
      $stb_code = DB::raw("(SELECT CONCAT('TB/', DATE_FORMAT('$stb_date', '%m%y'), '/', LPAD($order_number, 4, '0')))");
      // ================================================================================
      $stb_id = d_shop_terima_pembelian::select( DB::raw('IFNULL(MAX(stb_id) + 1, 1) AS stb_id') );
      $stb_id = $stb_id->first()->stb_id;
      $stb_staff = $request->stb_staff;
      $stb_staff = $stb_staff != null ? $stb_staff : '';
      $stb_pid = $request->stb_pid;
      $stb_pid = $stb_pid != null ? $stb_pid : '';

      // Comp dari tabel purchase order
      // Position dari gudang yg ada pada purchase plan
      $sp_gudang = d_shop_purchase_order::leftJoin('d_shop_purchase_plan', 'spo_purchaseplan', '=', 'sp_id')->where('spo_id', $stb_pid)->first();
      $sp_gudang = $sp_gudang->sp_gudang;
      $gc_comp = DB::table('d_gudangcabang')->where('gc_id', $sp_gudang)->first();
      $position = $gc_comp->gc_id;
      $comp = $position;

      $spo_code = d_shop_purchase_order::where('spo_id', $stb_pid)->select('spo_code')->first()->spo_code; 
      $stb_noreff = DB::raw("(SELECT spo_code FROM d_shop_purchase_order WHERE spo_id = $stb_pid)");
      $stb_sup = DB::raw("(SELECT spo_supplier FROM d_shop_purchase_order WHERE spo_id = $stb_pid)");
      $stb_purchaseplan = $request->stb_purchaseplan;
      $stb_purchaseplan = $stb_purchaseplan != null ? $stb_purchaseplan : '';
      $stb_method = $request->stb_method;
      $stb_method = $stb_method != null ? $stb_method : '';

      $stb_totalnett = $request->stb_total_nett;
      $stb_totalnett = $stb_totalnett != null ? preg_replace('/\D/', '', $stb_totalnett) : 0;
      $stb_comp = Session::get('user_comp');
      DB::beginTransaction();
      try {

        $stb_id = DB::table('d_shop_terima_pembelian')->select(DB::raw('IFNULL(MAX(stb_id), 0) + 1 AS new_id'))->get()->first()->new_id;
        $grand_total = 0;
        
        $d_shop_terima_pembelian_dt = new d_shop_terima_pembelian_dt();

        $stbdt_item = $request->stbdt_item;
        $stbdt_item = $stbdt_item != null ? $stbdt_item : array();
        if( count($stbdt_item) > 0 ) {
            $stbdt_qty = $request->stbdt_qty;
            $stbdt_qty = $stbdt_qty != null ? $stbdt_qty : array();
            $stbdt_price = $request->stbdt_price;
            $stbdt_price = $stbdt_price != null ? $stbdt_price : array();
            $stbdt_sat = $request->stbdt_sat;
            $stbdt_sat = $stbdt_sat != null ? $stbdt_sat : array();

            $units = [];
            for($x = 0; $x < count($stbdt_item);$x++) {
                $total = $stbdt_qty[$x] * $stbdt_price[$x];
                $grand_total += $total;
                $unit = [
                  'stbdt_id' => $x + 1,
                  'stbdt_idtb' => $stb_id,
                  'stbdt_item' => $stbdt_item[$x],
                  'stbdt_qty' => $stbdt_qty[$x],
                  'stbdt_price' => $stbdt_price[$x],
                  'stbdt_sat' => $stbdt_sat[$x]
                ];
                array_push($units, $unit);
                // Mutasi barang masuk
                mutation::mutasiMasuk(
                  $stb_date,
                  $comp,
                  $position,
                  $stbdt_item[$x],
                  $stbdt_qty[$x],
                  'pembelian barang nabilastore',
                  '101',
                  $spo_code,
                  $stbdt_price[$x],
                  0
                );
            }

            d_shop_terima_pembelian_dt::insert($units);            
        }

        d_shop_terima_pembelian::insert([
          'stb_id' => $stb_id,
          'stb_comp' => $stb_comp,
          'stb_date' => $stb_date,
          'stb_pid' => $stb_pid,
          'stb_noreff' => $stb_noreff,
          'stb_sup' => $stb_sup,
          'stb_code' => $stb_code,
          'stb_staff' => $stb_staff,
          'stb_totalnett' => $stb_totalnett
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
    
    function update_d_shop_terima_pembelian(Request $request){
      $stb_id = $request->stb_id;
      $stb_id = $stb_id != null ? $stb_id : '';  

      if($stb_id != '') {
        DB::beginTransaction();
        try {
          d_shop_terima_pembelian_dt::where('stbdt_terima_pembelian', $stb_id)->delete();

          $stbdt_item = $request->stbdt_item;
          $stbdt_item = $stbdt_item != null ? $stbdt_item : array();
          if( count($stbdt_item) > 0 ) {

              $stbdt_qtyconfirm = $request->stbdt_qtyconfirm;
              $stbdt_qtyconfirm = $stbdt_qtyconfirm != null ? $stbdt_qtyconfirm : array();
              $stbdt_price = $request->stbdt_price;
              $stbdt_price = $stbdt_price != null ? $stbdt_price : array();
              $stbdt_satuan = $request->stbdt_satuan;
              $stbdt_satuan = $stbdt_satuan != null ? $stbdt_satuan : array();

              $units = array();
              for($x = 0; $x < count($stbdt_item);$x++) {
                  array_push($units, array(
                    "stbdt_terima_pembelian" => $stb_id,
                    "stbdt_detailid" => $x + 1,
                    "stbdt_item" => $stbdt_item[$x],
                    "stbdt_qty" => $stbdt_qty[$x],
                    "stbdt_qtyconfirm" => $stbdt_qtyconfirm[$x],
                    "stbdt_price" => $stbdt_price[$x],
                    "stbdt_satuan" => $stbdt_satuan[$x],
                    "stbdt_total" => $stbdt_price[$x] * $stbdt_qtyconfirm[$x]

                  ));
              }
          }
          d_shop_terima_pembelian_dt::insert($units);

          $stb_total_gross = $request->stb_total_gross;
          $stb_total_gross = $stb_total_gross != null ? $stb_total_gross : 0;
          $stb_total_net = $request->stb_total_net;
          $stb_total_net = $stb_total_net != null ? $stb_total_net : 0;
          $stb_disc_value = $request->stb_disc_value;
          $stb_disc_value = $stb_disc_value != null ? $stb_disc_value : 0;
          $stb_tax_percent = $request->stb_tax_percent;
          $stb_tax_percent = $stb_tax_percent != null ? $stb_tax_percent : 0;

          d_shop_terima_pembelian::where('stb_id', $stb_id)->update([
            'stb_disc_value' => $stb_disc_value,
            'stb_tax_percent' => $stb_tax_percent,
            'stb_total_gross' => $stb_total_gross,
            'stb_total_net' => $stb_total_net
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
         return view('Nabila::penerimaanbarang/form_insert', $res);
    }

    public function form_update($id)
    {
        $d_shop_terima_pembelian = d_shop_terima_pembelian::leftJoin('m_supplier', 'stb_supplier', '=', 's_id')->leftJoin('d_shop_purchase_plan', 'stb_purchaseplan', '=', 'spo_id');
        $d_shop_terima_pembelian = $d_shop_terima_pembelian->where('stb_id', $id)->select('spo_code','s_company', 'stb_id','stb_date', 'stb_comp','stb_code','stb_mem','stb_method', 'stb_purchaseplan', 'stb_disc_value', 'stb_tax_percent', 's_company',  DB::raw('DATE_FORMAT(stb_date, "%d-%m-%Y") AS stb_date_label'))->first();

        $d_shop_terima_pembelian_dt = d_shop_terima_pembelian_dt::leftJoin('m_item', 'stbdt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');  
        $d_shop_terima_pembelian_dt = $d_shop_terima_pembelian_dt->where('stbdt_terima_pembelian', $id)->select('s_id', 's_name', 'stbdt_item','stbdt_qty', 'stbdt_qtyconfirm', 'stbdt_price','stbdt_satuan','i_id','i_code','i_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();

        $res = [
          'd_shop_terima_pembelian' => $d_shop_terima_pembelian,
          'd_shop_terima_pembelian_dt' => $d_shop_terima_pembelian_dt
        ];  
        return view('Nabila::penerimaanbarang/form_update', $res);
    }

    public function preview($id)
    {
        $d_shop_terima_pembelian = d_shop_terima_pembelian::leftJoin('m_supplier', 'stb_sup', '=', 's_id')->leftJoin('d_shop_purchase_order', 'stb_pid', '=', 'spo_id')->leftJoin('d_mem', 'stb_staff', '=', 'm_id');
        $d_shop_terima_pembelian = $d_shop_terima_pembelian->where('stb_id', $id)->select('spo_code','s_company', 'stb_id','stb_date', 'stb_comp','stb_code', 'stb_noreff', 'm_name', 'stb_pid', 's_company',  DB::raw('DATE_FORMAT(stb_date, "%d-%m-%Y") AS stb_date_label'))->first();

        $d_shop_terima_pembelian_dt = d_shop_terima_pembelian_dt::leftJoin('m_item', 'stbdt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');  
        $d_shop_terima_pembelian_dt = $d_shop_terima_pembelian_dt->where('stbdt_idtb', $id)->select('s_id', 's_name', 'stbdt_item','stbdt_qty', 'stbdt_price', 'i_id','i_code','i_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();

        $res = [
          'd_shop_terima_pembelian' => $d_shop_terima_pembelian,
          'd_shop_terima_pembelian_dt' => $d_shop_terima_pembelian_dt
        ];  
        return view('Nabila::penerimaanbarang/preview', $res);
    }

   

    public function tambah_pembelian()
    {
        return view('/purchasing/returnpenerimaanbarang/tambah_pembelian');
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
        d_shop_terima_pembelian_dt::where('stbdt_terima_pembelian', $id)->delete();
        
        d_shop_terima_pembelian::where('stb_id', $id)->delete();


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