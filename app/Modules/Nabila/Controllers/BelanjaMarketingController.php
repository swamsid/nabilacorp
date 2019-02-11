<?php

namespace App\Modules\Nabila\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use App\m_item;
use App\d_sales_payment;
use App\Modules\POS\model\d_receivable;
use App\Modules\POS\model\d_receivable_dt;

use App\Http\Controllers\Controller;

use App\mMember;
use App\Modules\POS\model\m_paymentmethod;
use App\Modules\POS\model\d_sales;
use App\Modules\POS\model\d_sales_dt;
use App\Modules\POS\model\m_machine;
use App\Modules\Master\model\m_pegawai_man;
use Datatables;
use App\Lib\format;
use App\Lib\mutasi;
use Session;
use Auth;






class BelanjaMarketingController extends Controller
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
    
    public function delete($id) {
      $d_sales = d_sales::find($id);
      if($d_sales->s_status != 'draft') {
          $res = [
            'status' => 'error',
            'message' => 'Transaksi tidak dapat dihapus'
          ];
      }
      else {
        DB::beginTransaction();
        try {
          $d_sales_dt = d_sales_dt::where('sd_sales', $id);
          $d_sales_dt->delete();
          $d_sales->delete();

          $res = [
            'status' => 'sukses',
          ];
          DB::commit();
        }
        catch( \Exception $e ) {
          DB::rollback();
          $res = [
            'status' => 'error',
            'message' => 'Terjadi kesalahan. ' . $e
          ];
        }
      }

      return response()->json($res);
    }

    public function POSpenjualan()
    {
      $pilihan=view('Nabila::POSpenjualan.pilihan');
      return view('Nabila::POSpenjualan/POSpenjualan',compact('pilihan'));
    }
    //auto complete barang
    public function item(Request $item)
    {      
      
          
        //cari barang jual
        $results = array();
        $search = $item->term;

        $harga = $item->harga;
        $s_nama_cus = $item->s_nama_cus;
        $s_nama_cus = $s_nama_cus != null ? $s_nama_cus : 0;

        $cabang=Session::get('user_comp');                

        $position=DB::table('d_gudangcabang')
                      ->where('gc_gudang', 'GUDANG NABILAMOSLEM')
                      ->where('gc_comp',$cabang)
                      ->select('gc_id')->first();   
        $comp=$position->gc_id;
        $position=$position->gc_id;


        $groupName=['BTPN','BJ','BP'];


        /*dd($harga); */   

        $sql = DB::table('m_item')
             ->leftjoin('d_stock',function($join) use ($comp,$position) {
                  $join->on('s_item','=','i_id');
                  $join->where('s_comp',$comp); 
                  $join->where('s_position',$position);

             })
             ->leftJoin('m_satuan','m_satuan.s_id','=','i_sat1')           
             ->leftJoin('m_item_price','ip_item','=','i_id');
        $sql = $sql->where('i_type', 'BNM');
        if($search!=''){          
            $sql = $sql->where('i_name','like','%'.$search.'%')->orWhere('i_code','like','%'.$search.'%');
        }                                                 
        else{

          $results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
          return response()->json($results);
        }
        
        
          $price = "(SELECT IFNULL(ip_price, 0) FROM m_item_price IP WHERE IP.ip_item = i_id AND ip_group = $harga)";
          $ip_price = DB::raw($price . " AS i_price");
        

        $ip_edit = DB::raw("IFNULL( (SELECT ip_edit FROM m_item_price MP JOIN m_price_group PG ON MP.ip_group = PG.pg_id JOIN m_customer ON pg_id = c_class WHERE c_id = $s_nama_cus AND MP.ip_item = i_id), (SELECT IFNULL(ip_edit, 'N') FROM m_item_price IP WHERE IP.ip_item = i_id LIMIT 0, 1)) AS ip_edit");

        $label = DB::raw("CONCAT(i_name, ' - Rp ' , $price ) AS label");
        $satuan = DB::raw('s_name AS satuan');
        $item = DB::raw('i_name AS item');
        $comp = DB::raw("$comp AS comp");
        $position = DB::raw("$position AS position");
        $stok = DB::raw("IFNULL(s_qty, 0) AS stok");


        $sql = $sql->select($label, $item, $satuan, $comp, $position, 'i_id', 'i_code', 'i_name', $stok, $ip_edit, $ip_price);
        $sql = $sql->groupBy('i_id')->get();                        

        return response()->json($sql);
    }
    public function searchItemCode(Request $item)
    {      
      return m_item::searchItemCode($item);
    }
    
    //auto complete customer
    public function customer(Request $customer){
      return m_customer::customer($customer);     
    }

    public function posPesanan()
    { 
      /*$paymentmethod=m_paymentmethod::pm();      
      $pm=view('Nabila::paymentmethod/paymentmethod',compact('paymentmethod'));    */

      /*$data['toko']=view('Nabila::belanjamarketing/pesanan');      
      $data['listtoko']=view('Nabila::belanjamarketing/listpesanan');   
      return view('Nabila::belanjamarketing/pos-pesanan',compact('data'));
*/

      $printPl=view('Produksi::sam');
      $flag='Pesanan';
      $daftarHarga=DB::table('m_price_group')->where([
        ['pg_active','=','TRUE'],
        ['pg_type','=','M']
      ])->get();  
      $paymentmethod=m_paymentmethod::pm();       
      $pm =view('POS::paymentmethod/paymentmethod',compact('paymentmethod'));    
      $machine=m_machine::showMachineActive();      
      $data['toko']=view('Nabila::belanjamarketing/pesanan',compact('machine','paymentmethod','daftarHarga'));      
      $data['listtoko']=view('Nabila::belanjamarketing/listpesanan');   
      return view('Nabila::belanjamarketing/index',compact('data','pm','printPl'));




    }

    function create(Request $request){      
     return DB::transaction(function () use ($request) {   
      if($request->s_nama_cus==""){
        $data=['status'=>'gagal','data'=>'Nama pelanggan harus di isi'];
        return $data;
      }

      $query = DB::select(DB::raw("SELECT MAX(RIGHT(r_code,4)) as kode_max from d_receivable WHERE DATE_FORMAT(r_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
      $kd = "";
      
      if(count($query)>0)
      {
        foreach($query as $k)
        {
          $tmp = ((int)$k->kode_max)+1;
          $kd = sprintf("%05s", $tmp);
        }
      }
      else
      {
        $kd = "00001";
      }

          $r_code = "DPR-".date('ym')."-".$kd;

          $s_komisi = format::format($request->s_komisi);
          $s_komisi = preg_replace('/[\D\.]+(\d.+)/', '$2', $s_komisi);
          $s_komisi = str_replace('.', '', $s_komisi);

          $s_kasir = format::format($request->s_kasir);
          $s_gross = format::format($request->s_gross);
          $s_ongkir = format::format($request->s_ongkir);          
          $s_disc_value = format::format($request->s_disc_value);
          $s_disc_percent = format::format($request->s_disc_percent);
          $s_net= format::format($request->s_net);
           $kembalian= format::format($request->kembalian);
          $bayar= format::format($request->s_bayar);
          $s_bulat= format::format($request->s_bulat);

          $s_id=d_sales::max('s_id')+1;             
          $note='MARKETING-'.$s_id.'/'.date('Y.m.d');
          if($request->s_customer==''){
            $request->s_customer=0;
          }
          
          $s_date = date('Y-m-d',strtotime($request->s_date));
          $inputs = [
                    's_id' =>$s_id ,
                    's_comp'=> Session::get('user_comp'),                    
                    's_kasir' => $s_kasir,
                    's_channel'=>'marketing',
                    's_jenis_bayar'=>$request->s_jenis_bayar,
                    's_date'=>$s_date,
                    's_duedate'=>date('Y-m-d',strtotime($request->s_duedate)),
                    's_finishdate'=>date('Y-m-d',strtotime($request->s_finishdate)),
                    's_note'=>$note,
                    's_machine'=>Session::get('kasir'),
                    's_create_by'=>Auth::user()->m_id,
                    's_type_price'=>$request->s_type_price,
                    /*'s_customer'=>$request->s_customer,*/
                    's_nama_cus'=>$request->s_nama_cus,
                    's_alamat_cus'=>$request->s_alamat_cus,
                    's_komisi' => $s_komisi,
                    's_gross' => $s_gross,
                    's_disc_percent'=>$s_disc_percent,
                    's_disc_value'=>$s_disc_value,
                    's_tax'=>0,
                    's_ongkir'=>$s_ongkir,
                    's_net'=>$s_net,
                    's_status'=>$request->status,
                    's_bayar'=>$bayar,
                    /*'s_kembalian'=>$kembalian,*/
                    's_bulat'=>$s_bulat
           ];



          d_sales::insert($inputs);

          $r_id=d_receivable::max('r_id')+1;          
          if($s_net-$bayar<0){
            $p_outstanding=0;
            $r_pay=$s_net;            
            }else{
            $p_outstanding=$s_net-$bayar;
            $r_pay=$bayar;
          }

          for ($i=0; $i <count($request->sd_item); $i++) {  
                
               $sd_detailid=d_sales_dt::
                              where('sd_sales','=',$s_id)->max('sd_detailid')+1;      

                  $comp=$request->comp[$i];

                  $position=$request->position[$i];
                  

                  $sd_price = format::format($request->sd_price[$i]);

                  $sd_total = format::format($request->sd_total[$i]);

                  $sd_disc_value = format::format($request->sd_disc_value[$i]);              

                  $sd_disc_percentvalue = format::format($request->sd_disc_percentvalue[$i]);

                  $sd_qty= format::format($request->sd_qty[$i]);

                  d_sales_dt::create([
                            'sd_sales' =>$s_id ,
                            'sd_detailid'=>$sd_detailid,   
                            'sd_date'    =>date('Y-m-d',strtotime($request->s_date)),                             
                            'sd_comp'=>$comp,                    
                            'sd_position'=>$position,                            
                            'sd_item'=>$request->sd_item[$i],
                            'sd_qty'=>$sd_qty,                    
                            'sd_price' =>$sd_price,
                            'sd_price_disc' =>$sd_price-$sd_disc_value-$sd_disc_percentvalue,
                            'sd_disc_percent'=>$request->sd_disc_percent[$i],
                            'sd_disc_value'=>$sd_disc_value,
                            'sd_disc_percentvalue'=>$sd_disc_percentvalue,
                            'sd_total'=>$sd_total-$sd_disc_value-$sd_disc_percentvalue,
                  ]);

                  mutasi::mutasiStok(
                      $request->sd_item[$i],
                      $sd_qty,
                      $comp,
                      $position,
                      'pengurangan stok nabilamoslem',
                      $note,
                      '',
                      $s_date,
                      '102'
                  );
          
        }

/*dd($request->all());*/
$bayar=count($request->sp_nominal);
$totalBayar=0;
          for ($n=0; $n <$bayar; $n++) {  
            $jmlBayar=$bayar-1;   
            $sp_paymentid=d_sales_payment::
                          where('sp_sales','=',$s_id)->max('sp_paymentid')+1;  
            $sp_nominal = format::format($request->sp_nominal[$n]);    
            $s_kembalian = format::format($request->kembalian);
            if($jmlBayar==$n && $s_kembalian>0){              
              $sp_nominal=$sp_nominal-$s_kembalian;
            }        

            if($request->sp_date[$n]==0){
              $sp_date=date('Y-m-d');
            }else{
              $sp_date=$request->sp_date[$n];
            }

              d_sales_payment::create([
                  'sp_sales'=>$s_id,
                  'sp_paymentid'=>$sp_paymentid,
                  'sp_comp'=>Session::get('user_comp'),                    
                  'sp_method'=>$request->sp_method[$n],
                  'sp_nominal'=>$sp_nominal,
                  'sp_date'=>$sp_date,
                ]);

          $totalBayar+=$sp_nominal;
        } 

      
          $salesUpdate=d_sales::where('s_id',$s_id);
          $salesUpdate->update([
                  's_bayar'=>$totalBayar
            ]); 
          $data=['status'=>'sukses','data'=>'sukses' ,'s_id'=>$s_id,'s_status'=>$request->status];
          return json_encode($data);
      });
    }

     function serahFinal(Request $request){      
      return d_sales::serahFinal($request); 
    }


    function penjualanDtPesanan($id,Request $request){  
    
      $status=$request->s_status;      
        
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('Nabila::belanjamarketing/editDetailPenjualan',compact('data','tamp','status'));
      
    }


    function penjualanViewDtPesanan($id){            
      $data=d_sales_dt::penjualanDt($id);
      $tamp=[];
      foreach ($data as $key => $value) {
          $tamp[$key]=$value->i_id;
      }      
      $tamp=array_map("strval",$tamp);      
      return view('Nabila::belanjamarketing/viewDetailPenjualan',compact('data','tamp'));
      
    }

    function listPenjualanPesanan(Request $request){
      if($request->ajax()){
        return view('Nabila::belanjamarketing/tableListPesanan');
      }else{
        return 'f';
      }
        
    }
    function listPenjualanDataPesanan(Request $request){
        $from=date('Y-m-d',strtotime($request->tanggal1));
        $to=date('Y-m-d',strtotime($request->tanggal2));

               
        $d_sales = DB::table('d_sales')
                  ->join('m_machine','m_id','=','s_machine')                
                  ->where('s_channel','marketing')
                   ->whereBetween('s_date', [$from, $to])->where('s_comp',Session::get('user_comp'))->get();
      
          return Datatables::of($d_sales)
                         ->addColumn('item', function ($d_sales) {
                            return'<button onclick=dataDetailView(
                                                '.$d_sales->s_id.',
                                                \''.$d_sales->s_note.'\',
                                                \''.$d_sales->s_machine.'\',
                                                
                                                \''.date('d-m-Y',strtotime($d_sales->s_date)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_duedate)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_finishdate)).'\',
                                                \''.number_format($d_sales->s_gross,0,',','.').'\',
                                                '.$d_sales->s_disc_percent.',
                                                '.$d_sales->s_disc_value.',
                                                \''.number_format($d_sales->s_gross-$d_sales->s_disc_percent-$d_sales->s_disc_value,0,',','.').'\',
                                                \''.number_format($d_sales->s_ongkir,0,',','.').'\',
                                                \''.number_format($d_sales->s_bulat,0,',','.').'\',
                                                \''.number_format($d_sales->s_net,0,',','.').'\',
                                                \''.number_format($d_sales->s_bayar,0,',','.').'\',
                                                \''.number_format($d_sales->s_kembalian,0,',','.').'\',
                                                \''.$d_sales->s_customer.'\',
                                                \''.$d_sales->s_nama_cus.'\',
                                                \''.$d_sales->s_status.'\',                                                
                                                '.($d_sales->s_net-$d_sales->s_bayar).',
                                                \''.$d_sales->s_jenis_bayar.'\',
                                                
                                                \''.$d_sales->s_alamat_cus.'\',
                            ) class="btn btn-outlined btn-info btn-xs" type="button"        data-target="#detail" data-toggle="modal">Detail</button>';
                        })                       
                      ->addColumn('s_status_val', function ($d_sales) {
                            return $d_sales->s_status ;
                        })  
                      ->editColumn('s_status', function ($d_sales) {
                            if ($d_sales->s_status == 'draft')
                                return '<span class="label label-warning">Draft</span>';
                            if (strtolower($d_sales->s_status) == 'final')
                                return '<span class="label label-success">Final</span>';
                            if (strtolower($d_sales->s_status) == 'terima')
                                return '<span class="label label-info">Terima</scpan>';
                        })
                      ->editColumn('s_date', function ($d_sales) {                            
                                return date('d-m-Y',strtotime($d_sales->s_date));                            
                        })
                      ->editColumn('s_gross', function ($d_sales) {                            
                                return number_format($d_sales->s_gross,0,',','.');
                        })
                      ->editColumn('s_ongkir', function ($d_sales) {                            
                                return number_format($d_sales->s_ongkir,0,',','.');
                        })
                      ->editColumn('s_net', function ($d_sales) {                            
                                return number_format($d_sales->s_net,0,',','.');
                        })
                      ->editColumn('s_disc_percent', function ($d_sales) {                            
                                return number_format($d_sales->s_disc_percent+$d_sales->s_disc_value,0,',','.');
                        })
                         ->addColumn('action', function ($d_sales) {
                                                        
                            $disable = '';
                            $html='';  
 if($d_sales->s_status == 'final') {
                              $html .= '<div class="text-center">
                              <button type="button" class="btn btn-xs btn-success" title="Detail" onclick="dataDetailView(
                                                    '.$d_sales->s_id.',
                                                    \''.$d_sales->s_note.'\',
                                                    \''.$d_sales->s_machine.'\',
                                                    
                                                    \''.date('d-m-Y',strtotime($d_sales->s_date)).'\',
                                                    \''.date('d-m-Y',strtotime($d_sales->s_duedate)).'\',
                                                    \''.date('d-m-Y',strtotime($d_sales->s_finishdate)).'\',
                                                    \''.number_format($d_sales->s_gross,0,',','.').'\',
                                                    '.$d_sales->s_disc_percent.',
                                                    '.$d_sales->s_disc_value.',
                                                    \''.number_format($d_sales->s_gross-$d_sales->s_disc_percent-$d_sales->s_disc_value,0,',','.').'\',
                                                    \''.number_format($d_sales->s_ongkir,0,',','.').'\',
                                                    \''.number_format($d_sales->s_bulat,0,',','.').'\',
                                                    \''.number_format($d_sales->s_net,0,',','.').'\',
                                                    \''.number_format($d_sales->s_bayar,0,',','.').'\',
                                                    \''.number_format($d_sales->s_kembalian,0,',','.').'\',
                                                    \''.$d_sales->s_customer.'\',
                                                    \''.$d_sales->s_nama_cus.'\',
                                                    \''.$d_sales->s_status.'\',                                                
                                                    '.($d_sales->s_net-$d_sales->s_bayar).',
                                                    \''.$d_sales->s_jenis_bayar.'\',
                                                    
                                                    \''.$d_sales->s_alamat_cus.'\',
                                                    )" ><i class="fa fa-eye"></i> 
                              </button>
                              
                              </div>';
                          }
                          else {
                              $html.='<div class="text-center">
                              <button type="button" class="btn btn-xs btn-success" title="Detail" onclick="dataDetailView(
                                                '.$d_sales->s_id.',
                                                \''.$d_sales->s_note.'\',
                                                \''.$d_sales->s_machine.'\',
                                                
                                                \''.date('d-m-Y',strtotime($d_sales->s_date)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_duedate)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_finishdate)).'\',
                                                \''.number_format($d_sales->s_gross,0,',','.').'\',
                                                '.$d_sales->s_disc_percent.',
                                                '.$d_sales->s_disc_value.',
                                                \''.number_format($d_sales->s_gross-$d_sales->s_disc_percent-$d_sales->s_disc_value,0,',','.').'\',
                                                \''.number_format($d_sales->s_ongkir,0,',','.').'\',
                                                \''.number_format($d_sales->s_bulat,0,',','.').'\',
                                                \''.number_format($d_sales->s_net,0,',','.').'\',
                                                \''.number_format($d_sales->s_bayar,0,',','.').'\',
                                                \''.number_format($d_sales->s_kembalian,0,',','.').'\',
                                                \''.$d_sales->s_customer.'\',
                                                \''.$d_sales->s_nama_cus.'\',
                                                \''.$d_sales->s_status.'\',                                                
                                                '.($d_sales->s_net-$d_sales->s_bayar).',
                                                \''.$d_sales->s_jenis_bayar.'\',
                                                
                                                \''.$d_sales->s_alamat_cus.'\',
                                                )" ><i class="fa fa-eye"></i> 
                          </button>
                          <button type="button" class="btn btn-xs btn-warning" title="Edit"onclick="editPenjualan(
                                                '.$d_sales->s_id.',
                                                \''.$d_sales->s_note.'\',
                                                \''.$d_sales->s_machine.'\',
                                                
                                                \''.date('d-m-Y',strtotime($d_sales->s_date)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_duedate)).'\',
                                                \''.date('d-m-Y',strtotime($d_sales->s_finishdate)).'\',
                                                \''.number_format($d_sales->s_gross,0,',','.').'\',
                                                '.$d_sales->s_disc_percent.',
                                                '.$d_sales->s_disc_value.',
                                                \''.number_format($d_sales->s_gross-$d_sales->s_disc_percent-$d_sales->s_disc_value,0,',','.').'\',
                                                \''.number_format($d_sales->s_ongkir,0,',','.').'\',
                                                \''.number_format($d_sales->s_bulat,0,',','.').'\',
                                                \''.number_format($d_sales->s_net,0,',','.').'\',
                                                \''.number_format($d_sales->s_bayar,0,',','.').'\',
                                                \''.number_format($d_sales->s_kembalian,0,',','.').'\',
                                                \''.$d_sales->s_customer.'\',
                                                \''.$d_sales->s_nama_cus.'\',
                                                \''.$d_sales->s_status.'\',                                                
                                                '.($d_sales->s_net-$d_sales->s_bayar).',
                                                \''.$d_sales->s_jenis_bayar.'\',
                                                
                                                \''.$d_sales->s_alamat_cus.'\',
                                                \''.$d_sales->s_type_price.'\',

                                                )" '.$disable.' ><i class="fa fa-edit"></i>
                          </button>
                          <button type="button" class="btn btn-xs btn-danger" title="Hapus" onclick="deleteProduksi(
                          '.$d_sales->s_id.'
                          )" '.$disable.'><i class="fa fa-times"></i>
                          </button>
                          </div>';
                          }
                            return $html;
                        })
                        ->rawColumns(['item','action','s_status'])
                        ->make(true);  
    }
  function printNotaPesanan($id, Request $request){
      $bayar=$request->s_bayar;
      $kembalian=$request->kembalian;
      $data=d_sales::printNota($id);
      $dt=d_sales_dt::where('sd_sales',$id)->select('sd_sales')->get();
      $jumlah=count($dt);
      
      return view('Nabila::belanjamarketing/printNota',compact('data','kembalian','bayar','jumlah'));
     
   
  }

   public function POSpenjualanPesanan()
    {
      return view('Nabila::belanjamarketing/pos-pesanan');
    }

   public function update_s_status(Request $req) {
      $s_id = $req->s_id;
      $s_id = $s_id != null ? $s_id : '';
      $s_status = $req->s_status;
      $s_status = $s_status != null ? $s_status : '';
      if($s_id != '' && $s_status != '') {

        $d_sales = d_sales::find($s_id);
        $d_sales->s_status = $s_status;
        $d_sales->save();
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