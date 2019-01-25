<?php

namespace App\Modules\POS\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use app\Customer;
use Carbon\carbon;

use App\m_item;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\d_receivable;
use App\Modules\POS\model\d_receivable_dt;
use App\Modules\POS\model\d_sales;
use Datatables;
use DB;
use Excel;


class laporanPenjualanPesananController  extends Controller
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

    public function receivableDt ($id){
       return $data=d_receivable_dt::
              where('rd_receivable',$id)              
             ->orderBy('rd_detailid')
             ->get();
    }

    public function index() {      
      return view('POS::laporanPenjualanPesanan/index');
    }
    public function table(Request $req) {            
       $shift      = $req->shift;                
       $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
       $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));
       
          $data=d_receivable::
                whereBetween('r_date', [$tgl_awal, $tgl_akhir])     
                ->get();    





      

      return Datatables::of($data)                       
                      ->addIndexColumn()                                                 
                      ->editColumn('r_date', function ($data) {   
                                return date('d-m-Y',strtotime($data->r_date));                            
                        })
                      ->editColumn('r_reff', function ($data) {                            
                                return $data->r_code;
                        })
                      ->editColumn('r_value', function ($data) {                            
                                return '<div style="width:100%;text-align:right">'.number_format($data->r_value,2,',','.');   
                        })
                      ->editColumn('r_outstanding', function ($data) {                            
                                return '<div style="width:100%;text-align:right">'.number_format($data->r_outstanding,2,',','.');   
                        })
                      ->editColumn('r_cus', function ($data) {                            
                                return $data->r_customer_name;   
                        })                         
                      ->editColumn('Terbayar', function ($data) {                  
                                $dt=$this->receivableDt($data->r_id);
                                $html='';
                                foreach ($dt as $key => $dataDt) {
                                  $html.= $dataDt->rd_value.'<br>';
                                }
                                return $html;                      
                      })   
                      ->editColumn('jml', function ($data) {                  
                                $dt=$this->receivableDt($data->r_id);                                
                                $html='';
                                foreach ($dt as $key => $dataDt) {                    
                                  if($dataDt->rd_status=='Y'){
                                      $html.='<div style="float:left">(DP)</div>';
                                  }              
                                  $html.= '<div style="float:right">'.number_format($dataDt->rd_value,2,',','.').'</div><br>';
                                }
                                return $html;                      
                      })           
                      ->editColumn('tgl', function ($data) {                  
                                $dt=$this->receivableDt($data->r_id);
                                $html='';
                                foreach ($dt as $key => $dataDt) {
                                  $html.='<div style="width:100%;text-align:center">'.date('d-m-Y',strtotime($dataDt->rd_datepay)).'<br>';
                                }
                                return $html;                      
                      })           
                      ->rawColumns(['tgl','jml','r_value','r_outstanding'])         
                      ->make(true); 
    
        
             
       
    }

    public function totalPiutang(Request $req){
       $rows       ='';
       $shift      = $req->shift;                
       $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
       $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));



        $shift      = $req->shift;                
       $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
       $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));
       
          $data=d_receivable::
                whereBetween('r_date', [$tgl_awal, $tgl_akhir])     
                ->select(DB::raw("SUM(r_value) as r_value"),
                     DB::raw("SUM(r_pay) as r_pay"),
                     DB::raw("SUM(r_outstanding) as r_outstanding")
                     )
                ->first();    


          
        $data=[                
                'r_value'=>number_format($data->r_value,2,',','.'),
                'r_pay'=>number_format($data->r_pay,2,',','.'),
                'r_outstanding'=>number_format($data->r_outstanding,2,',','.')

                ];

        return json_encode($data);


    }
    public function printLaporanExcel(Request $req) {
         $shift      = $req->shift;                
         $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
         $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));
         $posPesanan=d_sales::whereBetween('s_date', [$tgl_awal, $tgl_akhir])->where('s_channel','Pesanan')->get();              
         $data=d_receivable::               
               Leftjoin('d_receivable_dt','r_id','=','rd_receivable')
               ->whereBetween('r_date', [$tgl_awal, $tgl_akhir])     
               ->get();    

       // Menghitung total
       $total_discountPercent=0;
       $total_discount = 0;
       $total_discountvalue = 0;
       $grand_total = 0;

       foreach ($posPesanan as $detail) {        
         /*$subtotal = $detail->s_gross;*/
         $total_discountPercent += $detail->s_disc_percent;
         $total_discountvalue += $detail->s_disc_value;
         $grand_total += $detail->s_net;         
         
       }

       $totalPiutang=0;
       $jmlBayar=0;
       $sisaPiutang=0;

       $totalRe=d_receivable::
                whereBetween('r_date', [$tgl_awal, $tgl_akhir])     
                ->select(DB::raw("SUM(r_value) as r_value"),
                     DB::raw("SUM(r_pay) as r_pay"),
                     DB::raw("SUM(r_outstanding) as r_outstanding")
                     )
                ->first();    

      $totalPiutang=$totalRe->r_value;
      $jmlBayar=$totalRe->r_pay;
      $sisaPiutang=$totalRe->r_outstanding;

      Excel::create('Laporan Penjualan Pesanan '.date('d-m-y'), function($excel) use ($grand_total,$total_discountvalue,$total_discountPercent,$data,$posPesanan,$totalPiutang,$jmlBayar,$sisaPiutang){        
            $excel->sheet('Data Penjualan', function($sheet) use ($grand_total,$total_discountvalue,$total_discountPercent,$data,$posPesanan) {
                $sheet->loadView('POS::laporanPenjualanPesanan/print_laporan_excel_penjualan')
                ->with('posPesanan',$posPesanan)                
                ->with('grand_total',$grand_total)
                ->with('total_discountPercent',$total_discountPercent)
                ->with('total_discountvalue',$total_discountvalue);

            });
            $excel->sheet('Data Pelunasan Hutang', function($sheet) use ($data,$totalPiutang,$jmlBayar,$sisaPiutang) {
                $sheet->loadView('POS::laporanPenjualanPesanan/print_laporan_excel')
                ->with('data',$data)
                ->with('totalPiutang',$totalPiutang)
                ->with('jmlBayar',$jmlBayar)
                ->with('sisaPiutang',$sisaPiutang);                

            });

        })->download('xls');

    }
    
    public function print_laporan(Request $req) {
         $data = array();
        $rows=null;

        $shift      = $req->shift;        
        
       $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));
       $tgl_akhir  = date('Y-m-d',strtotime($req->tgl_akhir));
    
      if($shift=='A'){
          $tgl_awal   = date('Y-m-d',strtotime($req->tgl_awal));                    

    $rows = d_sales_dt::leftJoin('d_sales', function($join) {
                $join->on('sd_sales', '=', 's_id');
              })->where('s_channel', 'Toko')
              ->whereBetween('s_date', [$tgl_awal, $tgl_awal])     
            ->join('m_item','i_id','=','sd_item')
            ->join('m_satuan','m_satuan.s_id','=','i_sat1')->select('m_item.i_name','s_note','s_date','s_nama_cus','s_detname','sd_qty','sd_price','sd_disc_value','sd_disc_percent','sd_total')->orderBy('sd_date', 'ASC')
            ->get();

          
        }else if($shift=='1'){          
          $tgl_awal1   = date('Y-m-d G:i:s',strtotime($req->tgl_awal.' '.'06:00'));
          $tgl_awal2   = date('Y-m-d G:i:s',strtotime($req->tgl_awal.' '.'13:00'));

           $rows = d_sales_dt::leftJoin('d_sales', function($join) {
                $join->on('sd_sales', '=', 's_id');
              })->where('s_channel', 'Toko')
              ->whereBetween('s_insert', [$tgl_awal1, $tgl_awal2])    
            ->join('m_item','i_id','=','sd_item')
            ->join('m_satuan','m_satuan.s_id','=','i_sat1')->select('m_item.i_name','s_note','s_date','s_nama_cus','s_detname','sd_qty','sd_price','sd_disc_value','sd_disc_percent','sd_total')->orderBy('sd_date', 'ASC')
            ->get();

        }else if($shift=='2'){
          $tgl_awal1   = date('Y-m-d G:i:s',strtotime($req->tgl_awal.' '.'13:00'));
          $tgl_awal2   = date('Y-m-d G:i:s',strtotime($req->tgl_awal.' '.'21:00'));
          
          $rows = d_sales_dt::leftJoin('d_sales', function($join) {
                $join->on('sd_sales', '=', 's_id');
              })->where('s_channel', 'Toko')
              ->whereBetween('s_insert', [$tgl_awal1, $tgl_awal2])      
            ->join('m_item','i_id','=','sd_item')
            ->join('m_satuan','m_satuan.s_id','=','i_sat1')->select('m_item.i_name','s_note','s_date','s_nama_cus','s_detname','sd_qty','sd_price','sd_disc_value','sd_disc_percent','sd_total')->orderBy('sd_date', 'ASC')
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
                    'tgl1'=>$tgl_awal                    
                    );
       
      return view('POS::laporanPenjualanToko/print_laporan', $res);
    }
    
}
