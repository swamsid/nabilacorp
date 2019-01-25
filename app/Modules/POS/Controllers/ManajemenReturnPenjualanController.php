<?php

namespace App\Modules\POS\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\POS\model\d_sales;
use App\Modules\POS\model\d_sales_dt;
use App\Modules\POS\model\d_sales_return;
use App\Modules\POS\model\d_sales_returndt;


use Datatables;
use App\Http\Requests;
use DB;
use Response;

class ManajemenReturnPenjualanController extends Controller
{
  public function r_penjualan(){
    
    return view('POS::manajemenreturn.index');
  }

  public function deleteretur($id) {

    DB::beginTransaction();
    try {
      $d_sales_returndt = d_sales_returndt::where('dsrdt_idsr', $id);
      $d_sales_returndt->delete();

      $d_sales_return = d_sales_return::where('dsr_id', $id);
      $d_sales_return->delete();



      DB::commit();
      $status = 'sukses';
    }
    catch(\Exception $e) {
      DB::rollback();
      $status = 'Terjadi kesalahan. ' . $e;
    }

    $res = ['status' => $status];

    return response()->json($res);
  }

    public function tabel(){
    $return = d_sales_return::all();


    return DataTables::of($return)

    ->editColumn('dsr_date', function ($data) {
       return date('d-M-Y', strtotime($data->dsr_date));
    })

    ->editColumn('dsr_type_sales', function ($data)  {
            if ($data->dsr_type_sales == "RT")
            {
                return 'Retail';
            }
            elseif ($data->dsr_type_sales == "GR")
            {
                return 'Grosir';
            }
        })

    ->editColumn('dsr_status', function ($data)  {
            $url = url('/penjualan/manajemenreturn/preview/');
            if ($data->dsr_status == "WT")
            {
                return '<div class="text-center">
                          <span class="label label-yellow">Waiting</span>
                        </div>';
            }
            elseif ($data->dsr_status == "TL")
            {
                return '<div class="text-center">
                            <span class="label label-red">Di Tolak</span>
                        </div>';
            } elseif ($data->dsr_status == "TR")
            {
                return '<div class="text-center">
                            <span class="label label-blue">Di Setujui</span>
                        </div>';
            } elseif ($data->dsr_status == "FN")
            {
              return '<div class="text-center">
                            <span class="label label-green">Selesai</span>
                        </div>';
            }
        })

    ->editColumn('dsr_method', function ($data)  {
            if ($data->dsr_method == "TB")
            {
                return 'Tukar Barang';
            }
            elseif ($data->dsr_method == "PN")
            {
                return 'Pemotongan Nota';
            }
             elseif ($data->dsr_method == "SB")
            {
                return 'Salah Barang';
            }
             elseif ($data->dsr_method == "SA")
            {
                return 'Salah Alamat';
            }
             elseif ($data->dsr_method == "KB")
            {
                return 'Kurang Barang';
            }
        })

    ->editColumn('dsr_jenis_return', function ($data)  {
            if ($data->dsr_jenis_return == "BR")
            {
                return 'Barang Rusak';
            }
            elseif ($data->dsr_jenis_return == "KB")
            {
                return 'Kelebihan Barang';
            }
        })
    ->editColumn('description',function ($data)
            {
              return  '<div class="text-center">
                        <select class="form-control" name="description[]">
                          <option value="Kelebihan">Kelebihan</option>
                          <option value="Rusak">Rusak</option>
                        </select>
                      </div>';# code...
            })

    ->addColumn('action', function($data){
      $url = url('/penjualan/manajemenreturn/preview/') . '/';
      if ($data->dsr_method == 'SB' || $data->dsr_method == 'SA') {

        if ($data->dsr_status == "WT"){
          return  '<div class="text-center">
                      <button type="button"
                          class="btn btn-success fa fa-eye btn-sm"
                          title="detail"
                          onclick="location.href=\'' . $url . '/' . $data->dsr_id . '\'"
                       >
                      </button>
                      <a onclick="distroyNota('.$data->dsr_id.')"
                          class="btn btn-danger btn-sm"
                          title="Hapus">
                          <i class="fa fa-trash-o"></i></a>
                    </div>';
          }elseif ($data->dsr_status == "TL") {
            return  '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            onclick="location.href=\'' . $url . $data->dsr_id . '\'"
                            >
                        </button>
                        <a  onclick="distroyNota('.$data->dsr_id.')"
                            class="btn btn-danger btn-sm"
                            title="Hapus">
                            <i class="fa fa-trash-o"></i></a>
                      </div>';
          }else{
            if ($data->dsr_status_terima == 'WT'){
              return '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            
                            onclick="location.href=\'' . $url . '/' . $data->dsr_id . '\'"
                            >
                        </button>
                        <button type="button"
                            class="btn btn-success fa fa-check btn-sm"
                            title="Terima Barang"
                            data-toggle="modal"
                            data-target="#myItemTerimaSB">
                        </button>
                      </div>';
            }else{
              return '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            onclick="location.href=\'' . $url . '/' . $data->dsr_id . '\'"
                            >
                        </button>
                      </div>';
            }
            
         }

      }
      else{

        if ($data->dsr_status == "WT"){
          return  '<div class="text-center">
                      <button type="button"
                          class="btn btn-success fa fa-eye btn-sm"
                          title="detail"
                          onclick="location.href=\'' . $url . $data->dsr_id . '\'">
                      </button>
                      <a  onclick="distroyNota('.$data->dsr_id.')"
                          class="btn btn-danger btn-sm"
                          title="Hapus">
                          <i class="fa fa-trash-o"></i></a>
                    </div>';
          }elseif ($data->dsr_status == "TL") {
            return  '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            data-toggle="modal"
                            onclick="location.href=\'' . $url . $data->dsr_id . '\'"
                            data-target="#myItem">
                        </button>
                        <a  onclick="distroyNota('.$data->dsr_id.')"
                            class="btn btn-danger btn-sm"
                            title="Hapus">
                            <i class="fa fa-trash-o"></i></a>
                      </div>';
          }else{
            return '<div class="text-center">
                        <button type="button"
                            class="btn btn-success fa fa-eye btn-sm"
                            title="detail"
                            data-toggle="modal"
                            onclick="location.href=\'' . $url . $data->dsr_id . '\'"
                            data-target="#myItem">
                        </button>
                      </div>';
          }

        }
         
        })
      
    ->rawColumns(['dsr_date','description','dsr_status','dsr_method','dsr_jenis_return','action'])
    ->make(true);
  }

  public function newreturn(){
    
    $nota = DB::table('d_sales')->get();
    $pn_template = view('POS::manajemenreturn/includes/pn_template');
    $pn_template = preg_replace("/\r\n|\r|\n/", ' ', $pn_template);
    $tb_template = view('POS::manajemenreturn/includes/tb_template');
    $tb_template = preg_replace("/\r\n|\r|\n/", ' ', $tb_template);
    $data = [
      'pn_template' => $pn_template,
      'tb_template' => $tb_template,
      'nota' => $nota
    ];
    return view('POS::manajemenreturn.return-penjualan', $data);
  }

  public function carinota(Request $request){
    // return 's';
    // dd($request->all());
    // $nota = DB::table('d_sales')->get();
      // $formatted_tags = array();
      $term = trim($request->q);

      $condition = [
        ['s_status', '=', 'terima']
      ];
      $d_sales = d_sales::where($condition);
      if($term != '') {
        $d_sales = $d_sales->where('s_note', $term);
      }
      $d_sales = $d_sales->take(50)->get();
      return Response::json($d_sales);

  }
  public function getdata($id) {
    $data = d_sales::leftJoin('d_sales_dt','sd_sales','=','s_id')
      ->leftJoin('m_item','i_id','=','sd_item');

    $data = $data->select(
      's_gross',
      's_disc_percent',
      's_disc_value',
      's_net',
      's_nama_cus',
      's_alamat_cus',
      's_channel')     
      ->where('s_id',$id)
      ->first();

      return Response::json($data);
  }

  public function preview($id) {
    $d_sales_return = d_sales_return::where('dsr_id', $id)->first();

    $d_sales_returndt = d_sales_returndt::leftJoin('m_item', 'i_id', '=', 'ddsrdt_item');
    $d_sales_returndt = $d_sales_returndt->where('ddsrdt_idsr', $id);

    $res = [
        'd_sales_return' => $d_sales_return,
        'd_sales_returndt' => $d_sales_returndt
    ];

    return view('POS::manajemenreturn.preview', $res);
  }

  public function tabelpnota($id,$metode)
  {
    $sales = DB::table('d_sales_dt')
      ->join('m_item','i_id','=','sd_item')
      ->join('m_satuan','m_satuan.s_id','=','i_sat1')
      ->where('sd_sales',$id)
      ->get();
    return view('POS::manajemenreturn.data-detail-return',compact('sales','metode'));
      
  }

  public function store(Request $request,$id)
  {
    DB::beginTransaction();
    try {
        // DB::enableQueryLog();
        // dd($request->all());
        if ($request->t_return == null) {
           $t_return =0;    # code...
        }
        else {
          $t_return = str_replace(['Rp', '\\', '.', ' '], '', $request->t_return);
        }
        $replaceCharDisc = (int)str_replace("%","",$request->diskonHarga);
        $replaceCharPPN = (int)str_replace("%","",$request->ppnHarga);

        $s_gross = str_replace(['Rp', '\\', '.', ' '], '', $request->s_gross);
        $total_diskon = str_replace(['Rp', '\\', '.', ' '], '', $request->total_diskon);
        $total_value = str_replace(['Rp', '\\', '.', ' '], '', $request->total_value);
        $total_percent = str_replace(['Rp', '\\', '.', ' '], '', $request->total_percent);
        $s_net = str_replace(['Rp', '\\', '.', ' '], '', $request->s_net);

          $dsr_id = DB::table('d_sales_return')->max('dsr_id')+1;
         
          $query = DB::select(DB::raw("SELECT MAX(RIGHT(dsr_id,4)) as kode_max from d_sales_return WHERE DATE_FORMAT(dsr_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
         
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
          
          $p_code = "RT-".date('ym')."-".$kd;

        $dsr_date = $request->tanggal;
        $dsr_date = preg_replace('/(\d+)[-\/](\d+)[-\/](\d+)/', '$3-$2-$1', $dsr_date);  
        $data_head = DB::table('d_sales_return')->insert([
              'dsr_id'=>$dsr_id,
              'dsr_sid' => $request->id_sales,
              'dsr_customer'=> $request->dsr_customer,
              'dsr_alamat_customer'=> $request->dsr_alamat_customer,
              // 'dsr_alamat'=>$request->,
              'dsr_code'=>$p_code,
              'dsr_method'=>$id,
              // 'dsr_jenis_return'=>$request->,
              // 'dsr_type_sales'=>$request->,
              'dsr_date'=>$dsr_date,

              'dsr_price_return'=>$request->t_return,
              'dsr_sgross'=>$s_gross,  
              'dsr_disc_vpercent'=>$total_diskon,
              'dsr_disc_value'=>$total_value,
              'dsr_net'=>$s_net,
              // 'dsr_status'=>,
              // 'dsr_status_terima'=>, 
              // 'dsr_resi'=>, 
              'dsr_created'=>date('Y-m-d h:i:s'), 
              // 'dsr_updated'=>, 
        ]);

        $dsrdt_item = $request->dsrdt_item;;
        $dsrdt_item = $dsrdt_item != null ? $dsrdt_item : [];
        $dsrdt_price = $request->dsrdt_price;;
        $dsrdt_price = $dsrdt_price != null ? $dsrdt_price : [];
        $dsrdt_price_disc = $request->dsrdt_price_disc;;
        $dsrdt_price_disc = $dsrdt_price_disc != null ? $dsrdt_price_disc : [];
        $dsrdt_qty = $request->dsrdt_qty;;
        $dsrdt_qty = $dsrdt_qty != null ? $dsrdt_qty : [];
        $dsrdt_qty_confirm = $request->dsrdt_qty_confirm;;
        $dsrdt_qty_confirm = $dsrdt_qty_confirm != null ? $dsrdt_qty_confirm : [];

        for ($i=0; $i <count($dsrdt_item) ; $i++) { 

            $dsrdt_total = $dsrdt_price[$i] * $dsrdt_qty_confirm[$i];

            $data_head = DB::table('d_sales_returndt')->insert([
              'dsrdt_idsr'=>$dsr_id,
              'dsrdt_detailid'=>$i+1,
              'dsrdt_item'=>$dsrdt_item[$i],
              'dsrdt_qty'=>$dsrdt_qty[$i],
              // 'dsr_alamat'=>$request->,
              'dsrdt_qty_confirm'=>$dsrdt_qty_confirm[$i],
              'dsrdt_price'=>$dsrdt_price[$i],
              // 'dsr_jenis_return'=>$request->,
              // 'dsr_type_sales'=>$request->,
              'dsrdt_return_price'=>$dsrdt_price_disc[$i],
              'dsrdt_created'=>date('Y-m-d h:i:s'), 
              // 'dsr_updated'=>, 

            ]);
            
            
            // $data_stock = DB::table('d_stock')->insert([
            //   'dsrdt_item'=>$request->i_id[$i],
            //   'dsrdt_qty_confirm'=>$request->dsrdt_qty_return[$i],
              

            // ]);
            DB::commit();
            $status = 'sukses';
        }
    }
    catch(\Exception $e) {
        DB::rollback();
        $status = 'Terjadi Kesalahan. ' . $e;
    }

    $res = ['status' => $status];
    return response()->json($res);
  }


}
