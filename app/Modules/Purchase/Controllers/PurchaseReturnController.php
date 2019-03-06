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
use App\Modules\Purchase\model\d_purchasing;
use App\Modules\Purchase\model\d_purchasing_dt;

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
        ->leftJoin('d_purchasing', 'pr_purchase', '=', 'd_pcs_id')->leftJoin('m_supplier', 'd_pcs_supplier', '=', 's_id');
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

      $d_purchase_return = $d_purchase_return->select('pr_id', 'pr_purchase', 'pr_code', 'm_name', 's_company', 'pr_pricetotal', DB::raw("CASE pr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS pr_method"), DB::raw("CASE pr_status WHEN 'WT' THEN 'Waiting ' WHEN 'CF' THEN 'Confirmed ' WHEN 'DE' THEN 'Dapat diedit ' WHEN 'RC' THEN 'RECEIVED' END AS pr_status_label"), 'pr_status')->get();
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
          'RTR/',
          DATE_FORMAT('$pr_datecreated', '%y%m'), 
          '/', 
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
      $d_purchase_return = $d_purchase_return->leftJoin('d_purchasing', 'pr_purchase', '=', 'd_pcs_id');
      $d_purchase_return = $d_purchase_return->leftJoin('m_supplier', 's_id', '=', 'd_pcs_supplier');
      $d_purchase_return = $d_purchase_return->where('pr_id', $pr_id)->select('pr_id', 'pr_purchase', 'pr_code', 'm_name', 's_company', 'pr_pricetotal', DB::raw('DATE_FORMAT(pr_datecreated, "%d/%m/%Y") AS pr_datecreated'), 'd_pcs_method', 'd_pcs_code', 'd_pcs_total_gross', 'd_pcs_disc_percent', 'd_pcs_disc_value', 'd_pcs_tax_value', 'd_pcs_disc_value', 'd_pcs_total_net',DB::raw("CASE pr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS pr_method"))->first();

      
      $d_purchasereturn_dt = d_purchasereturn_dt::leftJoin('m_item', 'i_id', '=', 'prdt_item')->leftJoin('d_purchase_return', 'prdt_purchasereturn', '=', 'pr_id')->leftJoin('d_purchasing', 'pr_purchase', '=', 'd_pcs_id')->leftJoin('d_purchase_plan', 'd_pcs_purchaseplan', '=', 'pr_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id'); 
      $d_purchasereturn_dt = $d_purchasereturn_dt->where('prdt_purchasereturn', $pr_id)->select('prdt_item', 'prdt_qty','prdt_qtyreturn','prdt_price', 's_name', 's_detname', 's_id', 'i_id', 'i_name', 'i_code', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = d_purchasereturn_dt.prdt_item AND s_position = p_gudang), 0) AS stock'))->get();


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
      $d_purchase_return = $d_purchase_return->leftJoin('d_purchasing', 'pr_purchase', '=', 'd_pcs_id');
      $d_purchase_return = $d_purchase_return->leftJoin('m_supplier', 's_id', '=', 'd_pcs_supplier');
      $d_purchase_return = $d_purchase_return->where('pr_id', $pr_id)->select('pr_id', 'pr_purchase', 'pr_code', 'm_name', 's_company', 'pr_pricetotal', DB::raw('DATE_FORMAT(pr_datecreated, "%d/%m/%Y") AS pr_datecreated'), 'd_pcs_method', 'd_pcs_code', 'd_pcs_total_gross', 'd_pcs_disc_percent', 'd_pcs_disc_value', 'd_pcs_tax_value', 'd_pcs_disc_value', 'd_pcs_total_net',DB::raw("CASE pr_method WHEN 'TK' THEN 'TUKAR BARANG ' WHEN 'PN' THEN 'POTONG NOTA' END AS pr_method"))->first();
      
      
      $d_purchasereturn_dt = d_purchasereturn_dt::leftJoin('m_item', 'i_id', '=', 'prdt_item')->leftJoin('d_purchase_return', 'prdt_purchasereturn', '=', 'pr_id')->leftJoin('d_purchasing', 'pr_purchase', '=', 'd_pcs_id')->leftJoin('d_purchase_plan', 'd_pcs_purchaseplan', '=', 'pr_id')->leftJoin('m_satuan', 'i_sat1', '=', 's_id'); 
      $d_purchasereturn_dt = $d_purchasereturn_dt->where('prdt_purchasereturn', $pr_id)->select('prdt_item', 'prdt_qty','prdt_qtyreturn','prdt_price', 's_name', 's_detname', 's_id', 'i_id', 'i_name', 'i_code', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = d_purchasereturn_dt.prdt_item AND s_position = p_gudang), 0) AS stock'))->get();


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

    public function find_d_purchasing(Request $req) {
      $d_purchasing = d_purchasing::leftJoin(DB::raw('m_supplier S'), DB::raw('S.s_id'), '=', DB::raw('d_purchasing.d_pcs_supplier'));
      // Filter berdasarkan tanggal
       $tgl_awal = $req->tgl_awal;
       $tgl_awal = $tgl_awal != null ? $tgl_awal : '';
       $tgl_akhir = $req->tgl_akhir;
       $tgl_akhir = $tgl_akhir != null ? $tgl_akhir : '';
       if($tgl_awal != '' && $tgl_akhir != '') {
          $tgl_awal = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_awal);
          $tgl_akhir = preg_replace('/([0-9]+)([\/-])([0-9]+)([\/-])([0-9]+)/', '$5-$3-$1', $tgl_akhir);
          $d_purchasing = $d_purchasing->whereBetween('d_pcs_date', array($tgl_awal, $tgl_akhir));
       }  

      $d_purchasing = $d_purchasing->get();
      $res = array(
        'data' => $d_purchasing
      );

      return response()->json($res);
    }    

    public function update_pr_status(Request $req) {
      $pr_id = $req->pr_id;
      $pr_id = $pr_id != null ? $pr_id : '';
      $pr_status = $req->pr_status;
      $pr_status = $pr_status != null ? $pr_status : '';
      if($pr_id != '' && $pr_status != '') {

        $d_purchase_return = d_purchase_return::find($pr_id);
        $pr_method = $d_purchase_return->pr_method; 
        $pr_datecreated = $d_purchase_return->pr_datecreated;
        $d_purchase_return->pr_status = $pr_status;
        $d_purchase_return->save();

        $p_gudang = d_purchase_return::leftJoin('d_purchasing', 'pr_purchase', '=', 'd_pcs_id')->leftJoin('d_purchase_plan', 'd_pcs_purchaseplan', '=', 'p_id')->where('pr_id', $pr_id);
        $p_gudang = $p_gudang->first()->p_gudang;
        $comp = $p_gudang;
        $position = $p_gudang; 
        if($pr_status == 'AP') {
            $d_purchasereturn_dt = d_purchasereturn_dt::where('prdt_purchasereturn', $pr_id)->get(); 
            foreach ($d_purchasereturn_dt as $unit) {
                if($pr_method == 'TK') {
                    mutasi::mutasiStok(
                        $unit->prdt_item,
                        $unit->prdt_qtyreturn,
                        $comp,
                        $position,
                        'pengurangan stok return pembelian',
                        $pr_code,
                        '',
                        $pr_datecreated,
                        '103'
                    );
                    mutation::mutasiMasuk(
                        $pr_datecreated,
                        $comp,
                        $position,
                        $unit->prdt_item,
                        $unit->prdt_qtyreturn,
                        'penambahan stok return pembelian ',
                        '104',
                        $pr_code,
                        $unit->prdt_price,
                        0
                    );
                    
                }
                else {

                  mutasi::mutasiStok(
                        $unit->prdt_item,
                        $unit->prdt_qtyreturn,
                        $comp,
                        $position,
                        'pengurangan stok return pembelian nabilastore',
                        $pr_code,
                        '',
                        $pr_date_created,
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
    
    public function find_d_purchasing_dt(Request $req) {
      $d_purchasing_dt = d_purchasing_dt::leftJoin('m_item', DB::raw('d_purchasing_dt.i_id'), '=', DB::raw('m_item.i_id'))->leftJoin('m_satuan', 's_id', '=', 'i_sat1');
      $d_purchasing_dt = $d_purchasing_dt->leftJoin('d_purchasing', 'd_pcs_id', '=', 'd_pcs_id')->leftJoin('d_purchase_plan', 'd_pcs_purchaseplan', '=', 'p_id');

      $d_pcs_id = $req->d_pcs_id;
      $d_pcs_id = $d_pcs_id != null ? $d_pcs_id : '';
      if($d_pcs_id != '') {
        $d_purchasing_dt = $d_purchasing_dt->where('d_pcs_id', $d_pcs_id);  
      }

      $d_purchasing_dt = $d_purchasing_dt->select(DB::raw('m_item.i_id AS i_id'), 'd_pcsdt_satuan', 'd_pcsdt_qty', 'd_pcsdt_qtysend', 'd_pcsdt_qtyreceive', 'd_pcsdt_qtyconfirm', 'd_pcsdt_price', 'd_pcsdt_prevcost', 'd_pcsdt_gross', 'd_pcsdt_total', 'd_pcsdt_disc', 'd_pcsdt_isconfirm', 's_name', 's_id', 'i_id', 'i_name', 'i_code', DB::raw('IFNULL((SELECT s_qty FROM d_stock WHERE s_item = d_purchasing_dt.i_id AND s_position = p_gudang), 0) AS stock'))->get();
      $res = array(
        'data' => $d_purchasing_dt
      );

      return response()->json($res);
    }    
}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/