<?php

namespace App\Modules\Purchase\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_item;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\m_machine;

use App\Modules\Purchase\model\d_purchase_return;
use App\Modules\Purchase\model\d_purchasereturn_dt;
use App\Modules\Purchase\model\d_purchase_order;
use App\Modules\Purchase\model\d_purchaseorder_dt;

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

    public function pembelian()
    {
        return view('Purchase::returnpembelian/pembelian');
    }

    public function tambah_pembelian()
    {
        
        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
        $resp = array(
          
          'staff' => $staff
        );
        return view('Purchase::returnpembelian/tambah_pembelian', $resp);
    }
    
    public function find_d_purchase_return(Request $req) {
      $d_purchase_return = d_purchase_return::leftJoin('d_mem', 'pr_staff', '=', 'm_id')
        ->leftJoin('m_supplier', 'pr_supplier', '=', 's_id');
      // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
          $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
          $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);
          $d_purchase_return = $d_purchase_return->whereBetween('pr_datecreated', array($tgl_awal, $tgl_akhir));
       }  

      $d_purchase_return = $d_purchase_return->select('pr_id', 'pr_purchase', 'pr_code', 'm_name', 's_company', 'pr_pricetotal', DB::raw("CASE pr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS pr_method"), DB::raw("CASE pr_status WHEN 'WT' THEN 'Waiting ' WHEN 'CF' THEN 'Confirmed ' WHEN 'DE' THEN 'Dapat diedit ' WHEN 'RC' THEN 'RECEIVED' END AS pr_status"))->get();
      $res = array(
        'data' => $d_purchase_return
      );

      return response()->json($res);
    } 

    function insert_d_purchase_return(Request $req) {
      $d_purchase_return = new d_purchase_return(); 
      $d_purchasereturn_dt = new d_purchasereturn_dt(); 
      $new_id = $d_purchase_return->select( DB::raw('IFNULL(MAX(pr_id), 0) + 1 AS new_id') )->get()->first();

      $pr_id = $new_id->new_id;

      $pr_purchase = $req->pr_purchase;
      $pr_purchase = $pr_purchase != null ? $pr_purchase : '';
      $pr_supplier = $req->pr_supplier;
      $pr_supplier = $pr_supplier != null ? $pr_supplier : '';
      $pr_method = $req->pr_method;
      $pr_method = $pr_method != null ? $pr_method : '';
      $pr_staff = $req->pr_staff;
      $pr_staff = $pr_staff != null ? $pr_staff : '';
      $pr_datecreated = $req->pr_datecreated;
      $pr_datecreated = $pr_datecreated != null ? $pr_datecreated : '';
      $pr_datecreated = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $pr_datecreated);

      $pr_datecreated_first = date("Y-m-01", strtotime($pr_datecreated));
      $pr_datecreated_last = date("Y-m-31", strtotime($pr_datecreated));
      $pr_code = d_purchase_return::select( 
        DB::raw(
          "CONCAT(
          'RTR-',
          DATE_FORMAT('$pr_datecreated', '%y%m'), 
          '-', 
          LPAD(COUNT(`pr_id`) + 1, 5, '0')) 
        AS pr_code"
        ) 
      );
      
      $pr_code = $pr_code->whereBetween('pr_datecreated', array($pr_datecreated_first, $pr_datecreated_last))->get()->first()->pr_code;


      DB::beginTransaction();
      try {

        $prdt_item = $req->prdt_item;
        $prdt_item = $prdt_item != null ? $prdt_item : array();
        if( count($prdt_item) > 0 ) {
          $prdt_qty = $req->prdt_qty;

          $prdt_qty = $prdt_qty != null ? $prdt_qty : array();
           $prdt_qtyreturn = $req->prdt_qtyreturn;

          $prdt_qtyreturn = $prdt_qtyreturn != null ? $prdt_qtyreturn : array();
           $prdt_price = $req->prdt_price;

          $prdt_price = $prdt_price != null ? $prdt_price : array();
           
          $data_purchasereturn_dt = array();
          $pr_pricetotal = 0;
          for($x = 0;$x < count($prdt_item);$x++) {
              array_push($data_purchasereturn_dt, array(
                "prdt_purchasereturn" => $pr_id,
                "prdt_detail" => $x + 1,
                "prdt_item" => $prdt_item[$x],
                "prdt_qty" => $prdt_qty[$x],
                "prdt_qtyreturn" => $prdt_qtyreturn[$x],
                "prdt_price" => $prdt_price[$x],
                "prdt_pricetotal" => $prdt_price[$x] * $prdt_qtyreturn[$x]
              ));

              $pr_pricetotal += ($prdt_price[$x] * $prdt_qtyreturn[$x]);
          }
          $d_purchasereturn_dt->insert($data_purchasereturn_dt);
        }

        $d_purchase_return->pr_id = $pr_id;
        $d_purchase_return->pr_code = $pr_code;
        $d_purchase_return->pr_purchase = $pr_purchase;
        $d_purchase_return->pr_supplier = $pr_supplier;
        $d_purchase_return->pr_method = $pr_method;
        $d_purchase_return->pr_staff = $pr_staff;
        $d_purchase_return->pr_datecreated = $pr_datecreated;
        $d_purchase_return->pr_pricetotal = $pr_pricetotal;

        $d_purchase_return->save();
        DB::commit();
        $res = array('status' => 'sukses' );
      }
      catch(\Exception $e) {
        DB::rollback();
        
        $res = array('status' => 'Error. ' . $e);
      }

      return response()->json($res);
    }

    function update_d_purchase_return(Request $req) {
      

      $pr_id = $req->pr_id;
      $pr_id = $pr_id != null ? $pr_id : '';
      
      if($pr_id != '') {

        DB::beginTransaction();
        try {

          $prdt_item = $req->prdt_item;
          $prdt_item = $prdt_item != null ? $prdt_item : array();
          if( count($prdt_item) > 0 ) {
            d_purchasereturn_dt::where('prdt_purchasereturn', $pr_id)->delete();
            $prdt_qty = $req->prdt_qty;
            $d_purchasereturn_dt = new d_purchasereturn_dt();

            $prdt_qty = $prdt_qty != null ? $prdt_qty : array();
             $prdt_qtyreturn = $req->prdt_qtyreturn;

            $prdt_qtyreturn = $prdt_qtyreturn != null ? $prdt_qtyreturn : array();
             $prdt_price = $req->prdt_price;

            $prdt_price = $prdt_price != null ? $prdt_price : array();
             
            $data_purchasereturn_dt = array();
            $pr_pricetotal = 0;
            for($x = 0;$x < count($prdt_item);$x++) {
                array_push($data_purchasereturn_dt, array(
                  "prdt_purchasereturn" => $pr_id,
                  "prdt_detail" => $x + 1,
                  "prdt_item" => $prdt_item[$x],
                  "prdt_qtyreturn" => $prdt_qtyreturn[$x],
                  "prdt_price" => $prdt_price[$x],
                  "prdt_pricetotal" => $prdt_price[$x] * $prdt_qtyreturn[$x]
                ));

                $pr_pricetotal += ($prdt_price[$x] * $prdt_qtyreturn[$x]);
            }
            $d_purchasereturn_dt->insert($data_purchasereturn_dt);
          }

          $d_purchase_return =  new d_purchase_return();
          $d_purchase_return = $d_purchase_return->find($pr_id);
          $d_purchase_return->pr_pricetotal = $pr_pricetotal;
          $d_purchase_return->save();
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

    function form_perbarui($pr_id) {
      // Daftar divisi

      // Membuat form update belanja harian
      $d_purchase_return = d_purchase_return::leftJoin('d_mem', 'pr_staff', '=', 'm_id');
      $d_purchase_return = $d_purchase_return->leftJoin('d_purchase_order', 'pr_purchase', '=', 'po_code');
      $d_purchase_return = $d_purchase_return->leftJoin('m_supplier', 's_id', '=', 'pr_supplier');
      $d_purchase_return = $d_purchase_return->where('pr_id', $pr_id)->select('pr_id', 'pr_purchase', 'pr_code', 'm_name', 's_company', 'pr_pricetotal', DB::raw('DATE_FORMAT(pr_datecreatedcreated, "%d/%m/%Y") AS pr_datecreatedcreated'), 'po_method', 'po_total_gross', 'po_disc_percent', 'po_disc_value', 'po_tax_value', 'po_disc_value',DB::raw("CASE pr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS pr_method"))->get()->first();

      
      $d_purchasereturn_dt = d_purchasereturn_dt::leftJoin('m_item', 'i_id', '=', 'prdt_item')
        ->leftJoin('m_satuan', 'i_satuan', '=', 's_id'); 
      $d_purchasereturn_dt = $d_purchasereturn_dt->where('prdt_purchasereturn', $pr_id)->get();


        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
      $res = array(
          "d_purchase_return" => $d_purchase_return,
          "d_purchasereturn_dt" => $d_purchasereturn_dt,
          "staff" => $staff
      );

      return view('Purchase::returnpembelian/edit_pembelian', $res);

    }
    function form_preview($pr_id) {
      // Daftar divisi

      // Membuat form update belanja harian
      $d_purchase_return = d_purchase_return::leftJoin('d_mem', 'pr_staff', '=', 'm_id');
      $d_purchase_return = $d_purchase_return->leftJoin('d_purchase_order', 'pr_purchase', '=', 'po_code');
      $d_purchase_return = $d_purchase_return->leftJoin('m_supplier', 's_id', '=', 'pr_supplier');
      $d_purchase_return = $d_purchase_return->where('pr_id', $pr_id)->select('pr_id', 'pr_purchase', 'pr_code', 'm_name', 's_company', 'pr_pricetotal', DB::raw('DATE_FORMAT(pr_datecreatedcreated, "%d/%m/%Y") AS pr_datecreatedcreated'), 'po_method', 'po_total_gross', 'po_disc_percent', 'po_disc_value', 'po_tax_value', 'po_disc_value',DB::raw("CASE pr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS pr_method"))->get()->first();

      
      $d_purchasereturn_dt = d_purchasereturn_dt::leftJoin('m_item', 'i_id', '=', 'prdt_item')
        ->leftJoin('m_satuan', 'i_satuan', '=', 's_id'); 
      $d_purchasereturn_dt = $d_purchasereturn_dt->where('prdt_purchasereturn', $pr_id)->get();


        $staff['nama'] = Auth::user()->m_name;
        $staff['id'] = Auth::User()->m_id;
      $res = array(
          "d_purchase_return" => $d_purchase_return,
          "d_purchasereturn_dt" => $d_purchasereturn_dt,
          "staff" => $staff
      );

      return view('Purchase::returnpembelian/preview_pembelian', $res);

    }

    function delete_d_purchase_return($pr_id) {
      
      if($pr_id != '') {
        
        DB::beginTransaction();
        try {
          $d_purchase_return = d_purchase_return::where('pr_id', $pr_id);
          $d_purchase_return->delete();
          $d_purchasereturn_dt = d_purchasereturn_dt::where('prdt_purchasereturn', $pr_id)->delete();

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

    public function find_d_purchase_order(Request $req) {
      $d_purchase_order = d_purchase_order::leftJoin(DB::raw('m_supplier S'), DB::raw('S.s_id'), '=', DB::raw('d_purchase_order.po_supplier'));
      // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
          $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
          $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);
          $d_purchase_order = $d_purchase_order->whereBetween('po_date', array($tgl_awal, $tgl_akhir));
       }  

      $d_purchase_order = $d_purchase_order->get();
      $res = array(
        'data' => $d_purchase_order
      );

      return response()->json($res);
    }    
    
    public function find_d_purchaseorder_dt(Request $req) {
      $d_purchaseorder_dt = d_purchaseorder_dt::leftJoin('m_item', 'i_id', '=', 'podt_item');
      $d_purchaseorder_dt = $d_purchaseorder_dt->leftJoin('m_satuan', 's_id', '=', 'i_satuan') ;

      $po_id = $req->po_id;
      $po_id = $po_id != null ? $po_id : '';
      if($po_id != '') {
        $d_purchaseorder_dt = $d_purchaseorder_dt->where('podt_purchaseorder', $po_id);  
      }

      $d_purchaseorder_dt = $d_purchaseorder_dt->get();
      $res = array(
        'data' => $d_purchaseorder_dt
      );

      return response()->json($res);
    }    
}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/