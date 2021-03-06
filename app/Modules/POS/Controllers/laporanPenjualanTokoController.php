<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use app\Customer;
use Carbon\carbon;
use App\d_mem;
use App\m_item;
use Auth;
use App\Http\Controllers\Controller;
use App\m_pegawai_man;
use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_sales;
use App\Modules\POS\model\d_sales_dt;
use Datatables;
use DB;
use Excel;
use Session;


class laporanPenjualanTokoController  extends Controller
{

   public function find_d_sales_dt(Request $req) 
   {
      if ($req->shift == 'all') 
      {
         $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
         $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));
         $user = d_mem::select('m_id')
           // ->where('m_pegawai_id',$req->shift)
           ->first();               
         $rows = d_sales_dt::leftJoin('d_sales', function($join) {
               $join->on('sd_sales', '=', 's_id');
            })
            ->where('s_channel', 'Toko')
            ->where('s_status', 'final')
            ->whereBetween('sd_date', [$tgl_awal, $tgl_akhir]) 
            // ->where('s_create_by',$user->m_id)
            ->where('s_comp',Session::get('user_comp'))  
            ->join('m_item','i_id','=','sd_item')
            ->join('m_satuan','m_satuan.s_id','=','i_sat1')
            ->select('m_item.i_name',
                     's_note',
                     's_date',
                     's_nama_cus',
                     's_detname',
                     'sd_qty',
                     'sd_price',
                     'sd_disc_value',
                     'sd_disc_percent',
                     'sd_total',
                     'sd_disc_percentvalue')
            ->orderBy('sd_date', 'ASC')
            ->get();
      }
      else
      {
         $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
         $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));
         $user = d_mem::select('m_id')
           ->where('m_pegawai_id',$req->shift)
           ->first();               
         $rows = d_sales_dt::leftJoin('d_sales', function($join) {
               $join->on('sd_sales', '=', 's_id');
            })
            ->where('s_channel', 'Toko')
            ->where('s_status', 'final')
            ->whereBetween('sd_date', [$tgl_awal, $tgl_akhir]) 
            ->where('s_create_by',$user->m_id)
            ->where('s_comp',Session::get('user_comp'))  
            ->join('m_item','i_id','=','sd_item')
            ->join('m_satuan','m_satuan.s_id','=','i_sat1')
            ->select('m_item.i_name',
                     's_note',
                     's_date',
                     's_nama_cus',
                     's_detname',
                     'sd_qty',
                     'sd_price',
                     'sd_disc_value',
                     'sd_disc_percent',
                     'sd_total',
                     'sd_disc_percentvalue')
            ->orderBy('sd_date', 'ASC')
            ->get();
      }     
      

      return Datatables::of($rows)                         
                   ->editColumn('s_date', function ($rows) {                           
                             return date('d M Y',strtotime($rows->s_date));
                     })
                   ->editColumn('sd_total', function ($rows) {                           
                             return number_format($rows->sd_total,'2',',','.');
                   })->editColumn('sd_disc_value', function ($rows) {                           
                             return number_format($rows->sd_disc_value,'2',',','.');
                   })->editColumn('sd_price', function ($rows) {                           
                             return number_format($rows->sd_price,'2',',','.');
                   })->make(true);    

   }
    
    public function penjualanmobile() {

      $pegawai = m_pegawai_man::select('c_id','c_code','c_nama')
        ->join('d_mem','d_mem.m_pegawai_id','=','c_id')
        ->get();

      $item = DB::table('m_item')->where('i_type', 'BP')->select('i_id', 'i_code', 'i_name')->get();

      return view('POS::laporanPenjualanToko/index', compact('pegawai', 'item'));
    }

   public function totalPenjualan(Request $req)
   {
      if ($req->shift == 'all') 
      {
         $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
         $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));
         $user = d_mem::select('m_id')
           ->where('m_pegawai_id',$req->shift)
           ->first();

         $rows = d_sales_dt::select(DB::raw("SUM(sd_disc_value) as sd_disc_value"),
                                    DB::raw("SUM(sd_disc_percentvalue) as sd_disc_percentvalue"),
                                    DB::raw("SUM(sd_total) as sd_total"))
            ->leftJoin('d_sales', function($join) {
                     $join->on('sd_sales', '=', 's_id');
            })
            ->where('s_channel', 'Toko')
            ->where('s_status', 'final')
            // ->where('s_create_by',$user->m_id)
            ->whereBetween('s_date', [$tgl_awal, $tgl_akhir])  
            ->where('s_comp',Session::get('user_comp'))                            
            ->orderBy('sd_date', 'ASC')
            ->first();

           $data=[                
                   'sd_disc_value'=>number_format($rows->sd_disc_percentvalue+$rows->sd_disc_value,2,',','.'),
                   'sd_total'=>number_format($rows->sd_total,2,',','.')

                   ];

           return json_encode($data);
      }
      else
      {
         $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
         $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));
         $user = d_mem::select('m_id')
           ->where('m_pegawai_id',$req->shift)
           ->first();

         $rows = d_sales_dt::select(DB::raw("SUM(sd_disc_value) as sd_disc_value"),
                                    DB::raw("SUM(sd_disc_percentvalue) as sd_disc_percentvalue"),
                                    DB::raw("SUM(sd_total) as sd_total"))
            ->leftJoin('d_sales', function($join) {
                     $join->on('sd_sales', '=', 's_id');
            })
            ->where('s_channel', 'Toko')
            ->where('s_status', 'final')
            ->where('s_create_by',$user->m_id)
            ->whereBetween('s_date', [$tgl_awal, $tgl_akhir])  
            ->where('s_comp',Session::get('user_comp'))                            
            ->orderBy('sd_date', 'ASC')
            ->first();

           $data=[                
                   'sd_disc_value'=>number_format($rows->sd_disc_percentvalue+$rows->sd_disc_value,2,',','.'),
                   'sd_total'=>number_format($rows->sd_total,2,',','.')

                   ];

           return json_encode($data);
      }
      
   }

   public function print_laporan_excel(Request $req) 
   {
      $data = array();      
      $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
      $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));     
      $user = d_mem::select('m_id')
        ->where('m_pegawai_id',$req->shift)
        ->first();            
      $rows = d_sales_dt::select('m_item.i_name',
                                 's_note',
                                 's_date',
                                 's_nama_cus',
                                 's_detname',
                                 'sd_qty',
                                 'sd_price',
                                 'sd_disc_value',
                                 'sd_disc_percent',
                                 'sd_total')
         ->leftJoin('d_sales', function($join) {
            $join->on('sd_sales', '=', 's_id');
         })
         ->where('s_channel', 'Toko')
         ->where('s_status', 'final')
         ->whereBetween('s_date', [$tgl_awal, $tgl_akhir]) 
         // ->where('s_create_by',$user->m_id)    
         ->where('s_comp',Session::get('user_comp')) 
         ->join('m_item','i_id','=','sd_item')
         ->join('m_satuan','m_satuan.s_id','=','i_sat1')
         ->orderBy('sd_date', 'ASC')
         ->get();

         // Menghitung total
         $total_discountPercent=0;
         $total_discount = 0;
         $total_discountvalue = 0;
         $grand_total = 0;

         foreach ($rows as $detail) {        
         $subtotal = ($detail->sd_qty * $detail->sd_price);
         $total_discountPercent += $detail->sd_disc_percentvalue;
         $total_discountvalue += $detail->sd_disc_value;
         $grand_total += $detail->sd_total;         
         }

         Excel::create('Laporan Penjualan Toko '.date('d-m-y'), function($excel) use ($grand_total,$total_discountvalue,$total_discountPercent,$rows){        
         $excel->sheet('New sheet', function($sheet) use ($grand_total,$total_discountvalue,$total_discountPercent,$rows) {
         $sheet->loadView('POS::laporanPenjualanToko/print_laporan_excel')
         /*->mergeCells('A2:B3')*/
         ->with('data',$rows)
         ->with('grand_total',$grand_total)
         ->with('total_discountPercent',$total_discountPercent)
         ->with('total_discountvalue',$total_discountvalue);
      });

      })->download('xls');

   }

   public function print_laporan(Request $req) 
   {
      if ($req->shift == 'all') 
      {
         $data = array();
         $rows=null;      
         $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
         $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir)); 
         $user = d_mem::select('m_id')
           ->where('m_pegawai_id',$req->shift)
           ->first();                  
         $rows = d_sales_dt::select('m_item.i_name',
                                    's_note',
                                    's_date',
                                    's_nama_cus',
                                    's_detname',
                                    'sd_qty',
                                    'sd_price',
                                    'sd_disc_value',
                                    'sd_disc_percent',
                                    'sd_total')
            ->leftJoin('d_sales', function($join) {
                  $join->on('sd_sales', '=', 's_id');
              })
            ->where('s_channel', 'Toko')
            ->where('s_status', 'final')
            ->whereBetween('s_date', [$tgl_awal, $tgl_akhir]) 
            // ->where('s_create_by',$user->m_id)   
            ->where('s_comp',Session::get('user_comp'))  
            ->join('m_item','i_id','=','sd_item')
            ->join('m_satuan','m_satuan.s_id','=','i_sat1')
            ->orderBy('sd_date', 'ASC')
            ->get();
      }
      else
      {
         $data = array();
         $rows=null;      
         $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
         $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir)); 
         $user = d_mem::select('m_id')
           ->where('m_pegawai_id',$req->shift)
           ->first();                  
         $rows = d_sales_dt::select('m_item.i_name',
                                    's_note',
                                    's_date',
                                    's_nama_cus',
                                    's_detname',
                                    'sd_qty',
                                    'sd_price',
                                    'sd_disc_value',
                                    'sd_disc_percent',
                                    'sd_total')
            ->leftJoin('d_sales', function($join) {
                  $join->on('sd_sales', '=', 's_id');
              })
            ->where('s_channel', 'Toko')
            ->where('s_status', 'final')
            ->whereBetween('s_date', [$tgl_awal, $tgl_akhir]) 
            ->where('s_create_by',$user->m_id)   
            ->where('s_comp',Session::get('user_comp'))  
            ->join('m_item','i_id','=','sd_item')
            ->join('m_satuan','m_satuan.s_id','=','i_sat1')
            ->orderBy('sd_date', 'ASC')
            ->get();
      }
      

      // Menghitung total
      $total_discountPercent=0;       
      $total_discountvalue = 0;
      $grand_total = 0;

      foreach ($rows as $detail) {        
      $subtotal = ($detail->sd_qty * $detail->sd_price);
      $total_discountPercent += $detail->sd_disc_percentvalue;
      $total_discountvalue += $detail->sd_disc_value;
      $grand_total += $detail->sd_total;         
      }


      $res = array('data' => $rows,
              'grand_total' => $grand_total, 
              'total_discountPercent' => $total_discountPercent,
              'total_discountvalue' => $total_discountvalue,        
              'tgl1'=>$tgl_awal,
              'tgl2'=>$tgl_akhir                    
              );

      return view('POS::laporanPenjualanToko/print_laporan', $res);
   }

   public function penjualanItem($tgl1, $tgl2, $shift)
   {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
         $tgll = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
         $tgl2 = $y2.'-'.$m2.'-'.$d2;

      $user = d_mem::select('m_id')
           ->where('m_pegawai_id',$shift)
           ->first();    

      if ($shift == 'all') 
      {
         $rows = d_sales_dt::select('s_name',
                                  'i_name',
                                  'i_type',
                                  'i_code',
                                  DB::raw("sum(sd_qty) as jumlah"))
         ->leftJoin('d_sales', function($join) {
               $join->on('sd_sales', '=', 's_id');
           })
         ->where('s_channel', 'Toko')
         ->where('s_status', 'final')
         ->whereBetween('s_date', [$tgll, $tgl2]) 
         // ->where('s_create_by',$user->m_id)   
         ->where('s_comp',Session::get('user_comp'))  
         ->join('m_item','i_id','=','sd_item')
         ->join('m_satuan','m_satuan.s_id','=','i_sat1')
         ->orderBy('sd_date', 'ASC')
         ->get();   
         dd($rows);       
      }
      else
      {
         $rows = d_sales_dt::select('sd_item',
                                  'i_name',
                                  'i_type',
                                  'i_code',
                                  DB::raw("sum(sd_qty) as jumlah"))
         ->leftJoin('d_sales', function($join) {
               $join->on('sd_sales', '=', 's_id');
           })
         ->where('s_channel', 'Toko')
         ->where('s_status', 'final')
         ->whereBetween('s_date', [$tgll, $tgl2]) 
         ->where('s_create_by',$user->m_id)   
         ->where('s_comp',Session::get('user_comp'))  
         ->join('m_item','i_id','=','sd_item')
         ->join('m_satuan','m_satuan.s_id','=','i_sat1')
         ->orderBy('sd_date', 'ASC')
         ->get();          
      }                
      

      return DataTables::of($leagues)
      // ->addIndexColumn()
      ->editColumn('sDate', function ($data)
      {
        return date('d M Y', strtotime($data->s_date));
      })
      ->editColumn('type', function ($data)
      {
          if ($data->i_type == "BJ")
          {
              return 'Barang Jual';
          }
          elseif ($data->i_type == "BP")
          {
              return 'Barang Produksi';
          }
      })

      ->make(true);
   }
    
}
