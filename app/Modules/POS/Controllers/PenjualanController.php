<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_itemm;
use App\m_price;
use App\d_stock;
use App\Http\Controllers\Controller;
use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\m_machine;
use App\Modules\POS\model\d_sales;
use App\Modules\POS\model\d_sales_dt;
use App\Modules\POS\model\d_salesb;
use App\d_gudangcabang;
use Response;
use Session;
use Datatables;
use Auth;


class PenjualanController extends Controller
{
    
   public function indexStok()
   {

      return view('POS::penjualanStock/index',compact('d'));
   }

   public function dataStok()
   {
      $stok=d_stock::dataStok();

      return $stok;      
   }

   public function s()
   {
      $d='data';

      return view('POS::POSpenjualanToko/s',compact('d'));
   }

   public function POSpenjualan()
   {
      $cabang = Session::get('user_comp');
      $cek = DB::table('m_comp')->select('c_owner')
         ->where('c_id',$cabang)->first();

      $pilihan=view('POS::POSpenjualan.pilihan', compact('cek'));

      return view('POS::POSpenjualan/POSpenjualan',compact('pilihan'));
   }

   public function itemRencana(Request $item)
   { 

      return m_itemm::itemRencana($item);
   }

   public function item(Request $request)
   { 
      $results = array();
      $search = $request->term;
      $harga = $request->harga;
      $groupName = ['BTPN','BJ','BP'];
      $cabang=Session::get('user_comp');                
      $position=DB::table('d_gudangcabang')
         ->where('gc_gudang',DB::raw("'GUDANG PENJUALAN'"))
         ->where('gc_comp',$cabang)
         ->select('gc_id')->first();  
      //nama item
      $queries = DB::table('m_item')->select('i_id',
                                          'i_code',
                                          'i_name',
                                          'i_type',
                                          'i_sat1')
         ->where(function ($query) use ($search,$groupName) {
            $query->where('i_name','like','%'.$search.'%');
            $query->whereIn('i_type',$groupName);
         })
         ->where('i_active','Y')
         ->orderBy('i_name', 'asc')
         ->take(25)
         ->get()->toArray();

      foreach ($queries as $val) 
      {
         //cek item type
         $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
         // //get satuan utama
         $sat1[] = $val->i_sat1;
      }

         // //variabel untuk count array
         $counter = 0;
         //ambil value stok by item type
         $comp = Session::get('user_comp');
         $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
         // return json_encode($dataStok);
         if ($queries == null)
         {
            $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
         }
         else
         {
            foreach ($queries as $index => $data)
            {
               $cekHarga = DB::table('m_item_price')
                     ->select('ip_price')
                     ->where('ip_item',$data->i_id)
                     ->where('ip_group',$harga)
                     ->first();
               if($cekHarga == null )
               {
                  $cekHarga = DB::table('m_item_price')
                     ->select('ip_price')
                     ->where('ip_item',$data->i_id)
                     ->where('ip_group','1')
                     ->first();
               }

               $results[] = [
                  'label' => $data->i_code.' - '.$data->i_name, 
                  'i_id' => $data->i_id,
                  'stok' => number_format($dataStok['val_stok'][$index]->qtyStok,0,',','.'),
                  'satuan' => $dataStok['txt_satuan'][$index],
                  'i_code' =>$data->i_code,
                  'i_price' =>number_format($cekHarga->ip_price,0,',','.'),
                  'item' => $data->i_name,
                  'position'=>$position->gc_id,
                  'comp'=>$position->gc_id,
               ];
            }
         }

      return Response::json($results);

   }

   public function searchItemCode(Request $item)
   { 

      return m_itemm::searchItemCode($item);
   }

   //auto complete customer
   public function customer(Request $customer)
   {

      return m_customer::customer($customer);     
   }

   function paymentmethod (Request $request)
   {
      $jumlah=$request->dataIndex;
      $paymentmethod=m_paymentmethod::pm();       
      $data =view('POS::paymentmethod/paymentmethod',compact('paymentmethod','jumlah'));    
      $a='';
      $a.=$data;
      $x=['view'=>$a,'jumlah'=>$jumlah];
      return $x;
   }

   function paymentmethodEdit($id,$flag)
   {
      $data=m_paymentmethod::paymentmethodEdit($id,$flag);              
      $jumlah=count($data['sales_pm']);
      $data =view('POS::paymentmethod/paymentmethodEdit',compact('data','jumlah'));    
      $a='';
      $a.=$data;
      $x=['view'=>$a,'jumlah'=>$jumlah];
      return $x;
   }

   public function posToko()
   { 
      $cabang = Session::get('user_comp');
      $cek = DB::table('m_comp')->select('c_owner')
         ->where('c_id',$cabang)->first();

      $printPl=view('Produksi::sam');
      $flag='Toko';
      $paymentmethod=m_paymentmethod::pm();       
      $daftarHarga=DB::table('m_price_group')
        ->where('pg_active','=','TRUE')
        ->where('pg_type','B')
        ->get();             
      $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));    
      $machine=m_machine::showMachineActive();      
      $data['toko']=view('POS::POSpenjualanToko/toko',compact('machine','paymentmethod','daftarHarga'));      
      $data['listtoko']=view('POS::POSpenjualanToko/listtoko');   
      return view('POS::POSpenjualanToko/POSpenjualanToko',compact('data','pm','printPl','paymentmethod','cek'));
   }

   function create(Request $request)
   {
      return d_sales::simpanMobile($request);
   }

   function createToko(Request $request)
   {
      return d_sales::simpan($request);
   }

   function update(Request $request)
   {

      return d_sales::perbarui($request);
   }

   function penjualanDtToko($id,Request $request)
   {      
      $status=$request->s_status;
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);           
      return view('POS::POSpenjualanToko/editDetailPenjualan',compact('data','tamp','status'));

   }




   function penjualanViewDtToko($id)
   {            
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) 
      {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('POS::POSpenjualanToko/viewDetailPenjualan',compact('data','tamp'));

   }


   function listPenjualan(Request $request)
   {
      if($request->ajax())
      {
        return view('POS::POSpenjualanToko/tableListToko');
      }else{
        return 'f';
      }
     
   }

   function listPenjualanData(Request $request)
   {
   /*if($request->ajax()){*/
     return d_sales::listPenjualanData($request);
   /*}else{
     return 'f';
   }*/

   }

   function printNota($id, Request $request)
   {
      $bayar=$request->s_bayar;
      $kembalian=$request->kembalian;
      $data=d_salesb::printNota($id);
      $dt=d_sales_dt::where('sd_sales',$id)->select('sd_sales')->get();
      $jumlah=count($dt);

      return view('POS::POSpenjualanToko/printNota',compact('data','kembalian','bayar','jumlah'));
   }

   public function POSpenjualanPesanan()
    {
      return view('/penjualan/POSpenjualanPesanan/POSpenjualanPesanan');
    }

    // Method untuk modul manajemen harga
   public function harga() 
   {
      return view('POS::manajemenharga/harga');
   }

    public function find_m_price() 
    {
      $m_price = m_price::take(100)->get();
      foreach ($m_price as $item) 
      {
         $item['i_code'] = '';
         $item['i_name'] = '';
         $item['i_type'] = '';
         $item['g_name'] = '';
         if($item->m_item != null) 
         {
            $item['i_code'] = $item->m_item->i_code;
            $item['i_name'] = $item->m_item->i_name;
            $item['i_type'] = $item->m_item->i_type;
            $item['g_name'] = $item->m_item->m_group->g_name;
         }
      }

      $data = array('data' => $m_price);
      return response()->json($data);
    }

   public function update_m_price(Request $req) 
   {
      $m_pid = $req->m_pid;
      $m_pid = $m_pid != null ? $m_pid : '';
      $status = 'gagal';
      if($m_pid != '') 
      {
         $m_pbuy1 = $req->m_pbuy1;
         $m_pbuy1 = $m_pbuy1 != null ? $m_pbuy1 : '';
         $m_pbuy2 = $req->m_pbuy2;
         $m_pbuy2 = $m_pbuy2 != null ? $m_pbuy2 : '';
         $m_pbuy3 = $req->m_pbuy3;
         $m_pbuy3 = $m_pbuy3 != null ? $m_pbuy3 : '';

         $data = m_price::find($m_pid);
         $data->m_pbuy1 = $req->m_pbuy1;
         $data->m_pbuy2 = $req->m_pbuy2;
         $data->m_pbuy3 = $req->m_pbuy3;
         $data->save(); 
         $status = 'sukses';
      }

      $res = array('status' => $status);
      return response()->json($res);
   }

   public function getStokByType($arrItemType, $arrSatuan, $counter, $comp)
   {
      foreach ($arrItemType as $val) 
      {
         if ($val->i_type == "BJ") //brg jual
         {
            $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG PENJUALAN')
                  ->where('gc_comp',$comp)
                  ->first();
                  
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id->gc_id' AND s_position = '$gc_id->gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
         elseif ($val->i_type == "BB") //bahan baku
         {
            $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG BAHAN BAKU')
                  ->where('gc_comp',$comp)
                  ->first();
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id->gc_id' AND s_position = '$gc_id->gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
         elseif ($val->i_type == "BTPN") //bahan baku
         {
            $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG PENJUALAN')
                  ->where('gc_comp',$comp)
                  ->first();
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id->gc_id' AND s_position = '$gc_id->gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
         if ($val->i_type == "BP") //bahan produksi
         {
            $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG PENJUALAN')
                  ->where('gc_comp',$comp)
                  ->first();

            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id->gc_id' AND s_position = '$gc_id->gc_id' limit 1) ,'0') as qtyStok"));

            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
         elseif ($val->i_type == "BL") //bahan lain
         {
            $gc_id = d_gudangcabang::select('gc_id')
                  ->where('gc_gudang','GUDANG BAHAN BAKU')
                  ->where('gc_comp',$comp)
                  ->first();
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id->gc_id' AND s_position = '$gc_id->gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
   }
}
