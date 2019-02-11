<?php

namespace App\Modules\Nabila\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_item;
use App\Lib\mutation;
use App\Lib\mutasi;
use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\m_machine;

use App\Modules\Nabila\model\d_shop_purchase_return;
use App\Modules\Nabila\model\d_shop_purchasereturn_dt;
use App\Modules\Nabila\model\d_shop_purchase_order;
use App\Modules\Nabila\model\d_shop_purchaseorder_dt;

use Datatables;

use Auth;




class PurchaseReturnController extends Controller
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
    
   /* public function cut(){
      $connector = new FilePrintConnector("\\\TAZIZ-PC\POS-80");
      $pointer = new Printer($connector);
      $pointer -> cut();
      $pointer -> close();

    }*/

    public function index()
    {
        return view('Nabila::returnpembelian/pembelian');
    }

    public function tambah_pembelian()
    {
        
        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
        $resp = array(
          
          'staff' => $staff
        );
        return view('Nabila::returnpembelian/tambah_pembelian', $resp);
    }
    
    public function find_d_shop_purchase_return(Request $req) {
      $d_shop_purchase_return = d_shop_purchase_return::leftJoin('d_mem', 'spr_staff', '=', 'm_id')
        ->leftJoin('d_shop_purchase_order', 'spr_purchase', '=', 'spo_id')
        ->leftJoin('m_supplier', 'spo_supplier', '=', 's_id');
      // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
          $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
          $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);
          $d_shop_purchase_return = $d_shop_purchase_return->whereBetween('spr_datecreated', array($tgl_awal, $tgl_akhir));
       }  

      $d_shop_purchase_return = $d_shop_purchase_return->select('spr_id', 'spr_purchase', 'spr_code', 'm_name', 's_company', 'spr_pricetotal', DB::raw("CASE spr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS spr_method"), DB::raw("CASE spr_status WHEN 'WT' THEN 'Waiting ' WHEN 'AP' THEN 'Disetujui' WHEN 'NAP' THEN 'Tidak Disetujui' END AS spr_status_label"), 'spr_status')->get();
      $res = array(
        'data' => $d_shop_purchase_return
      );

      return response()->json($res);
    } 

    function insert_d_shop_purchase_return(Request $req) {
      $d_shop_purchase_return = new d_shop_purchase_return(); 
      $d_shop_purchasereturn_dt = new d_shop_purchasereturn_dt(); 
      $new_id = $d_shop_purchase_return->select( DB::raw('IFNULL(MAX(spr_id), 0) + 1 AS new_id') )->get()->first();

      $spr_id = $new_id->new_id;

      $spr_purchase = $req->spr_purchase;
      $spr_purchase = $spr_purchase != null ? $spr_purchase : '';
      $spr_supplier = $req->spr_supplier;
      $spr_supplier = $spr_supplier != null ? $spr_supplier : '';
      $spr_method = $req->spr_method;
      $spr_method = $spr_method != null ? $spr_method : '';
      $spr_staff = $req->spr_staff;
      $spr_staff = $spr_staff != null ? $spr_staff : '';
      $spr_datecreated = $req->spr_datecreated;
      $spr_datecreated = $spr_datecreated != null ? $spr_datecreated : '';
      $spr_datecreated = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $spr_datecreated);

      $spr_datecreated_first = date("Y-m-01", strtotime($spr_datecreated));
      $spr_datecreated_last = date("Y-m-31", strtotime($spr_datecreated));
      $spr_code = d_shop_purchase_return::select( 
        DB::raw(
          "CONCAT(
          'RTR-',
          DATE_FORMAT('$spr_datecreated', '%y%m'), 
          '-', 
          LPAD(COUNT(`spr_id`) + 1, 5, '0')) 
        AS spr_code"
        ) 
      );
      
      $spr_code = $spr_code->whereBetween('spr_datecreated', array($spr_datecreated_first, $spr_datecreated_last))->get()->first()->spr_code;


      DB::beginTransaction();
      try {

        $sprdt_item = $req->sprdt_item;
        $sprdt_item = $sprdt_item != null ? $sprdt_item : array();
        if( count($sprdt_item) > 0 ) {
          $sprdt_qty = $req->sprdt_qty;

          $sprdt_qty = $sprdt_qty != null ? $sprdt_qty : array();
           $sprdt_qtyreturn = $req->sprdt_qtyreturn;

          $sprdt_qtyreturn = $sprdt_qtyreturn != null ? $sprdt_qtyreturn : array();
           $sprdt_price = $req->sprdt_price;

          $sprdt_price = $sprdt_price != null ? $sprdt_price : array();
           
          $data_purchasereturn_dt = array();
          $spr_pricetotal = 0;
          for($x = 0;$x < count($sprdt_item);$x++) {
              array_push($data_purchasereturn_dt, array(
                "sprdt_purchasereturn" => $spr_id,
                "sprdt_detail" => $x + 1,
                "sprdt_item" => $sprdt_item[$x],
                "sprdt_qty" => $sprdt_qty[$x],
                "sprdt_qtyreturn" => $sprdt_qtyreturn[$x],
                "sprdt_price" => $sprdt_price[$x],
                "sprdt_pricetotal" => $sprdt_price[$x] * $sprdt_qtyreturn[$x]
              ));

              $spr_pricetotal += ($sprdt_price[$x] * $sprdt_qtyreturn[$x]);
          }

          $d_shop_purchasereturn_dt->insert($data_purchasereturn_dt);
        }

        $d_shop_purchase_return->spr_id = $spr_id;
        $d_shop_purchase_return->spr_code = $spr_code;
        $d_shop_purchase_return->spr_purchase = $spr_purchase;
        $d_shop_purchase_return->spr_supplier = $spr_supplier;
        $d_shop_purchase_return->spr_method = $spr_method;
        $d_shop_purchase_return->spr_staff = $spr_staff;
        $d_shop_purchase_return->spr_datecreated = $spr_datecreated;
        $d_shop_purchase_return->spr_pricetotal = $spr_pricetotal;

        $d_shop_purchase_return->save();
        DB::commit();
        $res = array('status' => 'sukses' );
      }
      catch(\Exception $e) {
        DB::rollback();
        
        $res = array('status' => 'Error. ' . $e);
      }

      return response()->json($res);
    }

    function update_d_shop_purchase_return(Request $req) {
      

      $spr_id = $req->spr_id;
      $spr_id = $spr_id != null ? $spr_id : '';
      
      if($spr_id != '') {

        DB::beginTransaction();
        try {

          $sprdt_item = $req->sprdt_item;
          $sprdt_item = $sprdt_item != null ? $sprdt_item : array();
          if( count($sprdt_item) > 0 ) {
            d_shop_purchasereturn_dt::where('sprdt_purchasereturn', $spr_id)->delete();
            $sprdt_qty = $req->sprdt_qty;
            $d_shop_purchasereturn_dt = new d_shop_purchasereturn_dt();

            $sprdt_qty = $sprdt_qty != null ? $sprdt_qty : array();
             $sprdt_qtyreturn = $req->sprdt_qtyreturn;

            $sprdt_qtyreturn = $sprdt_qtyreturn != null ? $sprdt_qtyreturn : array();
             $sprdt_price = $req->sprdt_price;

            $sprdt_price = $sprdt_price != null ? $sprdt_price : array();
             
            $data_purchasereturn_dt = array();
            $spr_pricetotal = 0;
            for($x = 0;$x < count($sprdt_item);$x++) {
                array_push($data_purchasereturn_dt, array(
                  "sprdt_purchasereturn" => $spr_id,
                  "sprdt_detail" => $x + 1,
                  "sprdt_item" => $sprdt_item[$x],
                  "sprdt_qtyreturn" => $sprdt_qtyreturn[$x],
                  "sprdt_price" => $sprdt_price[$x],
                  "sprdt_pricetotal" => $sprdt_price[$x] * $sprdt_qtyreturn[$x]
                ));

                $spr_pricetotal += ($sprdt_price[$x] * $sprdt_qtyreturn[$x]);
            }
            $d_shop_purchasereturn_dt->insert($data_purchasereturn_dt);
          }

          $d_shop_purchase_return =  new d_shop_purchase_return();
          $d_shop_purchase_return = $d_shop_purchase_return->find($spr_id);
          $d_shop_purchase_return->spr_pricetotal = $spr_pricetotal;
          $d_shop_purchase_return->save();
          DB::commit();
          $res = array('status' => 'sukses' );
        }
        catch(\Exception $e) {
          DB::rollback();
          
          $res = array('status' => 'Error. ' . $e);
        }
      }
      else {
        $res = array('status' => 'ID Kosong');
      }

      return response()->json($res);
    }

    function form_perbarui($spr_id) {
      // Daftar divisi

      // Membuat form update belanja harian
      $d_shop_purchase_return = d_shop_purchase_return::leftJoin('d_mem', 'spr_staff', '=', 'm_id');
      $d_shop_purchase_return = $d_shop_purchase_return->leftJoin('d_shop_purchase_order', 'spr_purchase', '=', 'spo_id')->leftJoin('d_shop_purchase_plan', 'spo_purchaseplan', '=', 'sp_id');
      $d_shop_purchase_return = $d_shop_purchase_return->leftJoin('m_supplier', 's_id', '=', 'sp_supplier');
      $d_shop_purchase_return = $d_shop_purchase_return->where('spr_id', $spr_id)->select('spr_id', 'spr_purchase', 'spr_code', 'm_name', 's_company', 'spr_pricetotal', DB::raw('DATE_FORMAT(spr_datecreated, "%d/%m/%Y") AS spr_datecreated'), 'spo_method', 'spo_total_gross', 'spo_total_net', 'spo_disc_percent', 'spo_disc_value', 'spo_tax_percent', 'spo_disc_value',DB::raw("CASE spr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS spr_method"))->get()->first();

      $d_shop_purchasereturn_dt = d_shop_purchasereturn_dt::leftJoin('m_item', 'i_id', '=', 'sprdt_item')
        ->leftJoin('m_satuan', 'i_satuan', '=', 's_id'); 
      $d_shop_purchasereturn_dt = $d_shop_purchasereturn_dt->where('sprdt_purchasereturn', $spr_id);
      $d_shop_purchasereturn_dt = $d_shop_purchasereturn_dt->select('sprdt_item', 'sprdt_qty', 'sprdt_qtyreturn', 'sprdt_price', 'sprdt_pricetotal', 'i_code', 'i_name', 's_detname', 's_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();


        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
      $res = array(
          "d_shop_purchase_return" => $d_shop_purchase_return,
          "d_shop_purchasereturn_dt" => $d_shop_purchasereturn_dt,
          "staff" => $staff
      );

      return view('Nabila::returnpembelian/edit_pembelian', $res);

    }
    function form_preview($spr_id) {
      // Daftar divisi

      
      // Membuat form update belanja harian
      $d_shop_purchase_return = d_shop_purchase_return::leftJoin('d_mem', 'spr_staff', '=', 'm_id');
      $d_shop_purchase_return = $d_shop_purchase_return->leftJoin('d_shop_purchase_order', 'spr_purchase', '=', 'spo_id')->leftJoin('d_shop_purchase_plan', 'spo_purchaseplan', '=', 'sp_id');
      $d_shop_purchase_return = $d_shop_purchase_return->leftJoin('m_supplier', 's_id', '=', 'sp_supplier');
      $d_shop_purchase_return = $d_shop_purchase_return->where('spr_id', $spr_id)->select('spr_id', 'spr_purchase', 'spr_code', 'spo_code', 'm_name', 's_company', 'spr_pricetotal', DB::raw('DATE_FORMAT(spr_datecreated, "%d/%m/%Y") AS spr_datecreated'), 'spo_method', 'spo_total_gross', 'spo_total_net', 'spo_disc_percent', 'spo_disc_value', 'spo_tax_percent', 'spo_disc_value',DB::raw("CASE spr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS spr_method"))->get()->first();

      $d_shop_purchasereturn_dt = d_shop_purchasereturn_dt::leftJoin('m_item', 'i_id', '=', 'sprdt_item')
        ->leftJoin('m_satuan', 'i_satuan', '=', 's_id'); 
      $d_shop_purchasereturn_dt = $d_shop_purchasereturn_dt->where('sprdt_purchasereturn', $spr_id);
      $d_shop_purchasereturn_dt = $d_shop_purchasereturn_dt->select('sprdt_item', 'sprdt_qty', 'sprdt_qtyreturn', 'sprdt_price', 'sprdt_pricetotal', 'i_code', 'i_name', 's_detname', 's_name', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = m_item.i_id), 0) AS s_qty'))->get();

        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
      $res = array(
          "d_shop_purchase_return" => $d_shop_purchase_return,
          "d_shop_purchasereturn_dt" => $d_shop_purchasereturn_dt,
          "staff" => $staff
      );

      return view('Nabila::returnpembelian/preview_pembelian', $res);

    }

    function delete_d_shop_purchase_return($spr_id) {
      
      if($spr_id != '') {
        
        DB::beginTransaction();
        try {
          $d_shop_purchase_return = d_shop_purchase_return::where('spr_id', $spr_id);
          $d_shop_purchase_return->delete();
          $d_shop_purchasereturn_dt = d_shop_purchasereturn_dt::where('sprdt_purchasereturn', $spr_id)->delete();

          DB::commit();
          $res = array('status' => 'sukses' );
        }
        catch(\Exception $e) {
          DB::rollback();
          
          $res = array('status' => 'Error. ' . $e);
        }
      }
      else {
        $res = array('status' => 'ID Kosong');
      }

      return response()->json($res);
    }

    public function find_d_shop_purchase_order(Request $req) {
      $d_shop_purchase_order = d_shop_purchase_order::leftJoin(DB::raw('m_supplier S'), DB::raw('S.s_id'), '=', DB::raw('d_shop_purchase_order.po_supplier'));
      // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
          $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
          $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);
          $d_shop_purchase_order = $d_shop_purchase_order->whereBetween('spo_date', array($tgl_awal, $tgl_akhir));
       }  

      $d_shop_purchase_order = $d_shop_purchase_order->get();
      $res = array(
        'data' => $d_shop_purchase_order
      );

      return response()->json($res);
    }    
    
    public function find_d_shop_purchaseorder_dt(Request $req) {
      $d_shop_purchaseorder_dt = d_shop_purchaseorder_dt::leftJoin('m_item', 'i_id', '=', 'podt_item');
      $d_shop_purchaseorder_dt = $d_shop_purchaseorder_dt->leftJoin('m_satuan', 's_id', '=', 'i_satuan') ;

      $po_id = $req->po_id;
      $po_id = $po_id != null ? $po_id : '';
      if($po_id != '') {
        $d_shop_purchaseorder_dt = $d_shop_purchaseorder_dt->where('podt_purchaseorder', $po_id);  
      }

      $d_shop_purchaseorder_dt = $d_shop_purchaseorder_dt->get();
      $res = array(
        'data' => $d_shop_purchaseorder_dt
      );

      return response()->json($res);
    }    

     public function update_spr_status(Request $req) {
      $spr_id = $req->spr_id;
      $spr_id = $spr_id != null ? $spr_id : '';

      $spr_status = $req->spr_status;
      $spr_status = $spr_status != null ? $spr_status : '';
      if($spr_id != '' && $spr_status != '') {

        $d_shop_purchase_order = d_shop_purchase_return::find($spr_id);
        $d_shop_purchase_order->spr_status = $spr_status;
        $d_shop_purchase_order->save();
        $spr_code = $d_shop_purchase_order->spr_code;
        $spr_date_created = $d_shop_purchase_order->spr_date_created;
        $spr_method = $d_shop_purchase_order->spr_method;
        $sp_gudang = d_shop_purchase_return::leftJoin('d_shop_purchase_order', 'spr_purchase', '=', 'spo_id')->leftJoin('d_shop_purchase_plan', 'spo_purchaseplan', '=', 'sp_id')->where('spr_id', $spr_id);
        $sp_gudang = $sp_gudang->first()->sp_gudang;
        $comp = $sp_gudang;
        $position = $sp_gudang; 
        if($spr_status == 'AP') {
            $d_shop_purchasereturn_dt = d_shop_purchasereturn_dt::where('sprdt_purchasereturn', $spr_id)->get(); 
            foreach ($d_shop_purchasereturn_dt as $unit) {
                if($spr_method == 'TK') {
                    mutasi::mutasiStok(
                        $unit->sprdt_item,
                        $unit->sprdt_qtyreturn,
                        $comp,
                        $position,
                        'pengurangan stok return pembelian nabilastore',
                        $spr_code,
                        '',
                        $spr_date_created,
                        '103'
                    );
                    mutation::mutasiMasuk(
                        $spr_date_created,
                        $comp,
                        $position,
                        $unit->sprdt_item,
                        $unit->sprdt_qtyreturn,
                        'penambahan stok return pembelian nabilastore',
                        '104',
                        $spr_code,
                        $unit->sprdt_price,
                        0
                    );
                    
                }
                else {

                  mutasi::mutasiStok(
                        $unit->sprdt_item,
                        $unit->sprdt_qtyreturn,
                        $comp,
                        $position,
                        'pengurangan stok return pembelian nabilastore',
                        $spr_code,
                        '',
                        $spr_date_created,
                        '103'
                    );
                }
            }
        }
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
}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/