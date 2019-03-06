<?php

namespace App\Modules\Nabila\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_itemm;

use App\Http\Controllers\Controller;

use App\Modules\Nabila\model\d_shop_purchase_plan;
use App\Modules\Nabila\model\d_shop_purchaseplan_dt;

use Datatables;
use Session;

class RencanaPembelianController extends Controller
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
    
   public function update_sp_status(Request $req) {
      $sp_id = $req->sp_id;
      $sp_id = $sp_id != null ? $sp_id : '';
      $sp_status = $req->sp_status;
      $sp_status = $sp_status != null ? $sp_status : '';
      if($sp_id != '' && $sp_status != '') {

        $d_shop_purchase_plan = d_shop_purchase_plan::find($sp_id);
        $d_shop_purchase_plan->sp_status = $sp_status;
        $d_shop_purchase_plan->save();
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
      return d_purchase_plan::simpan($request);

   }
   public function index(){     

     return view( 'Nabila::rencanapembelian/index' );
   }
   
    function find_d_shop_purchase_plan(Request $req) {

       $data = array();
       $rows = d_shop_purchase_plan::leftJoin('m_supplier', 'sp_supplier', '=', 's_id');

       // Filter berdasarkan tanggal dan keyword
       $sp_status = $req->sp_status;
       $sp_status = $sp_status != null ? $sp_status : '';
       $keyword = $req->keyword;
       $keyword = $keyword != null ? $keyword : '';
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
        $tgl_awal = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_awal);
        $tgl_akhir = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $tgl_akhir);
        $rows = $rows->whereBetween('sp_date', array($tgl_awal, $tgl_akhir));
       }

       if($keyword != '') {
        $rows = $rows->where('sp_code', 'LIKE', DB::raw("'%$keyword%'"));

       }
       if($sp_status != '') {
        $rows = $rows->where('sp_status', $sp_status);
       }

       $rows = $rows->select('s_id', 'sp_id', DB::raw('DATE_FORMAT(sp_date, "%d/%m/%Y") AS sp_date_label'), 'sp_code', 's_company', 'sp_status', DB::raw("CASE sp_status WHEN 'WT' THEN 'Waiting ' WHEN 'PE' THEN 'Dapat Diedit' WHEN 'AP' THEN 'Disetujui' WHEN 'NAP' THEN 'Tidak Disetujui' END AS sp_status_label"))->get();
       

       $res = array('data' => $rows);
       return response()->json($res);
    }

    function find_d_shop_purchaseplan_dt($id) {

      $d_shop_purchaseplan_dt = d_shop_purchaseplan_dt::leftJoin('m_item', 'sppdt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');  
      $d_shop_purchaseplan_dt = $d_shop_purchaseplan_dt->where('sppdt_purchaseplan', $id)->select('s_id', 's_name', 'sppdt_item','sppdt_qty','sppdt_price','sppdt_satuan','i_id','i_code','i_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();

       $res = array('d_shop_purchaseplan_dt' => $d_shop_purchaseplan_dt);
       return response()->json($res);
    }
   
   function insert_d_shop_purchase_plan(Request $request){
      $sp_date = $request->sp_date;
      $sp_date = $sp_date != null ? $sp_date : '';
      $sp_date = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $sp_date);;

      $sp_mem = $request->sp_mem;
      $sp_mem = $sp_mem != null ? $sp_mem : '';
      $sp_supplier = $request->sp_supplier;
      $sp_supplier = $sp_supplier != null ? $sp_supplier : '';
      $sp_gudang = $request->sp_gudang;
      $sp_gudang = $sp_gudang != null ? $sp_gudang : '';
      $sp_comp = Session::get('user_comp');
      DB::beginTransaction();
      try {

        $sp_id = DB::table('d_shop_purchase_plan')->select(DB::raw('IFNULL(MAX(sp_id), 0) + 1 AS new_id'))->get()->first()->new_id;
        // membuat kode purchase plan
        $firstdate = date('Y-m-01', strtotime($sp_date));
        $enddate = date('Y-m-31', strtotime($sp_date));
        $order_number = d_shop_purchase_plan::select( DB::raw('IFNULL(COUNT(sp_id) + 1, 1) AS order_number') )->whereBetween('sp_date', [$firstdate, $enddate]);
        $order_number = $order_number->first()->order_number; 
        $sp_code = DB::raw("(SELECT CONCAT('PP/', DATE_FORMAT('$sp_date', '%m%y'), '/', LPAD($order_number, 4, '0')))");
        $grand_total = 0;
        
        $d_shop_purchaseplan_dt = new d_shop_purchaseplan_dt();

        $sppdt_item = $request->sppdt_item;
        $sppdt_item = $sppdt_item != null ? $sppdt_item : array();
        if( count($sppdt_item) > 0 ) {
            $sppdt_qty = $request->sppdt_qty;
            $sppdt_qty = $sppdt_qty != null ? $sppdt_qty : array();
            $sppdt_qty = $request->sppdt_qty;
            $sppdt_qty = $sppdt_qty != null ? $sppdt_qty : array();
            $sppdt_price = $request->sppdt_price;
            $sppdt_price = $sppdt_price != null ? $sppdt_price : array();
            $sppdt_satuan = $request->sppdt_satuan;
            $sppdt_satuan = $sppdt_satuan != null ? $sppdt_satuan : array();

            $units = [];
            for($x = 0; $x < count($sppdt_item);$x++) {
                $totalcost = $sppdt_qty[$x] * $sppdt_price[$x];
                $grand_total += $totalcost;
                $unit = [
                  'sppdt_detailid' => $x + 1,
                  'sppdt_purchaseplan' => $sp_id,
                  'sppdt_item' => $sppdt_item[$x],
                  'sppdt_qty' => $sppdt_qty[$x],
                  'sppdt_price' => $sppdt_price[$x],
                  'sppdt_satuan' => $sppdt_satuan[$x],
                  'sppdt_totalcost' => $totalcost
                ];
                array_push($units, $unit);
            }

            d_shop_purchaseplan_dt::insert($units);            
        }

        d_shop_purchase_plan::insert([
          'sp_code' => $sp_code,
          'sp_mem' => $sp_mem,
          'sp_id' => $sp_id,
          'sp_date' => $sp_date,
          'sp_supplier' => $sp_supplier,
          'sp_comp' => $sp_comp,
          'sp_gudang' => $sp_gudang,
          'sp_status' => 'WT'
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
    
    function update_d_shop_purchase_plan(Request $request){
      $sp_id = $request->sp_id;
      $sp_id = $sp_id != null ? $sp_id : '';  

      if($sp_id != '') {
        DB::beginTransaction();
        try {
          d_shop_purchaseplan_dt::where('sppdt_purchaseplan', $sp_id)->delete();

          $sppdt_item = $request->sppdt_item;
          $sppdt_item = $sppdt_item != null ? $sppdt_item : array();
          if( count($sppdt_item) > 0 ) {

              $sppdt_qty = $request->sppdt_qty;
              $sppdt_qty = $sppdt_qty != null ? $sppdt_qty : array();
              $sppdt_qty = $request->sppdt_qty;
              $sppdt_qty = $sppdt_qty != null ? $sppdt_qty : array();
              $sppdt_price = $request->sppdt_price;
              $sppdt_price = $sppdt_price != null ? $sppdt_price : array();
              $sppdt_satuan = $request->sppdt_satuan;
              $sppdt_satuan = $sppdt_satuan != null ? $sppdt_satuan : array();

              $units = array();
              for($x = 0; $x < count($sppdt_item);$x++) {
                  array_push($units, array(
                    "sppdt_purchaseplan" => $sp_id,
                    "sppdt_detailid" => $x + 1,
                    "sppdt_item" => $sppdt_item[$x],
                    "sppdt_qty" => $sppdt_qty[$x],
                    "sppdt_price" => $sppdt_price[$x],
                    "sppdt_satuan" => $sppdt_satuan[$x],
                    "sppdt_totalcost" => $sppdt_price[$x] * $sppdt_qty[$x]

                  ));
              }
          }
          d_shop_purchaseplan_dt::insert($units);

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
         $gudang = $gudang->where('gc_gudang', 'GUDANG NABILAMOSLEM');
         $gudang = $gudang->select('gc_id', 'c_name', 'gc_gudang')->get();

         $res = [
            'gudang' => $gudang
         ];
         return view('Nabila::rencanapembelian/form_insert', $res);
    }

    public function form_update($id)
    {
        $d_shop_purchase_plan = d_shop_purchase_plan::leftJoin('m_supplier', 'sp_supplier', '=', 's_id')->leftJoin('d_gudangcabang', 'sp_gudang', '=', 'gc_id')->leftJoin('m_comp', 'gc_comp', '=', 'c_id');
        $d_shop_purchase_plan = $d_shop_purchase_plan->where('sp_id', $id)->select('sp_id','sp_date','sp_gudang','sp_comp','sp_code','sp_mem', 's_company', 'gc_gudang', 'c_owner', DB::raw('DATE_FORMAT(sp_date, "%d-%m-%Y") AS sp_date_label'))->first();

        $d_shop_purchaseplan_dt = d_shop_purchaseplan_dt::leftJoin('m_item', 'sppdt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');
        ;
        $comp = Session::get('user_comp');  
        $d_shop_purchaseplan_dt = $d_shop_purchaseplan_dt->where('sppdt_purchaseplan', $id)->select('sppdt_item','sppdt_qty','sppdt_price','sppdt_satuan','s_id','s_name','i_id','i_code','i_name', DB::raw("IFNULL((SELECT s_qty FROM d_stock S JOIN d_gudangcabang G ON S.s_position = G.gc_id WHERE s_item = m_item.i_id AND gc_gudang = 'GUDANG NABILAMOSLEM' AND gc_comp = $comp), 0) AS s_qty"))->get();

        $res = [
          'd_shop_purchase_plan' => $d_shop_purchase_plan,
          'd_shop_purchaseplan_dt' => $d_shop_purchaseplan_dt
        ];  
        return view('Nabila::rencanapembelian/form_update', $res);
    }

    public function preview($id)
    {
        $d_shop_purchase_plan = d_shop_purchase_plan::leftJoin('m_supplier', 'sp_supplier', '=', 's_id')->leftJoin('d_gudangcabang', 'sp_gudang', '=', 'gc_id')->leftJoin('m_comp', 'gc_comp', '=', 'c_id');
        $d_shop_purchase_plan = $d_shop_purchase_plan->where('sp_id', $id)->select('sp_id','sp_date','sp_gudang','sp_comp','sp_code','sp_mem', 's_company', 'gc_gudang', 'c_owner', DB::raw('DATE_FORMAT(sp_date, "%d-%m-%Y") AS sp_date_label'))->first();

        $d_shop_purchaseplan_dt = d_shop_purchaseplan_dt::leftJoin('m_item', 'sppdt_item', '=', 'i_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id');
        $comp = Session::get('user_comp');
        $d_shop_purchaseplan_dt = $d_shop_purchaseplan_dt->where('sppdt_purchaseplan', $id)->select('sppdt_item','sppdt_qty','sppdt_price','sppdt_satuan','s_name', 's_id', 'i_id','i_code','i_name', DB::raw("IFNULL((SELECT s_qty FROM d_stock S JOIN d_gudangcabang G ON S.s_position = G.gc_id WHERE s_item = m_item.i_id AND gc_gudang = 'GUDANG NABILAMOSLEM' AND gc_comp = $comp), 0) AS s_qty"))->get();

        $res = [
          'd_shop_purchase_plan' => $d_shop_purchase_plan,
          'd_shop_purchaseplan_dt' => $d_shop_purchaseplan_dt
        ];  
        return view('Nabila::rencanapembelian/preview', $res);
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
        $d_shop_purchaseplan_dt = d_shop_purchaseplan_dt::where('sppdt_purchaseplan', $id);
        $d_shop_purchaseplan_dt->delete();
        
        $d_shop_purchase_plan = d_shop_purchase_plan::where('sp_id', $id);
        $d_shop_purchase_plan->delete();


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