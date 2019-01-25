<?php

namespace App\Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\mMember;
use DB;
use Carbon\Carbon;
use DateTime;
use Yajra\Datatables\Datatables;
use Session;
use App\Lib\mutasi;
use App\d_delivery_orderdt;
use App\d_delivery_order;
use App\d_gudangcabang;
use App\d_stock_mutation;
use Response;
class PenerimaanBrgSupController extends Controller
{
    public function index(){
      $tabIndex = view('Inventory::p_suplier.tab-index');
      $tabWait = view('Inventory::p_suplier.tab-wait');
      $tabFinish = view('Inventory::p_suplier.tab-finish');
      $tabModal = view('Inventory::p_suplier.modal');
      $tabModDetail = view('Inventory::p_suplier.modal-detail');
      $tabDetItem = view('Inventory::p_suplier.modal-detail-peritem');
      $ssss = Session::get('user_comp') ;
      return view('Inventory::p_suplier.index',compact('tabIndex','tabWait','tabFinish','tabModal','tabModDetail','tabDetItem','ssss'));
    }

  public function lookupDataPembelian(Request $request)
    {
      // dd($request->all());
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) 
        {
            $purchase = DB::table('d_purchaseorder_dt')
            ->select('d_purchaseorder_dt.podt_purchaseorder', 'd_purchase_order.po_id','d_purchase_order.po_code')
            ->join('d_purchase_order', 'd_purchaseorder_dt.podt_purchaseorder', '=', 'd_purchase_order.po_id')
            // ->where('d_purchaseorder_dt.d_pcsdt_isreceived','=','FALSE')
            // ->where('d_purchase_order.po_code', 'LIKE', '%'.$term.'%')
            ->where('d_purchaseorder_dt.podt_qtysend','!=','0')
            ->where('d_purchaseorder_dt.podt_isconfirm','=','TRUE')
            ->where('d_purchase_order.po_status','=','CF')
            ->orderBy('d_purchase_order.po_code', 'DESC')
            ->limit(5)
            ->groupBy('po_code')->get();
            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->podt_purchaseorder, 'text' => $val->po_code];
            }
            return Response::json($formatted_tags);
        }
        else
        { 
            $purchase = DB::table('d_purchaseorder_dt')
            ->select('d_purchaseorder_dt.podt_purchaseorder', 'd_purchase_order.po_id','d_purchase_order.po_code')
            ->join('d_purchase_order', 'd_purchaseorder_dt.podt_purchaseorder', '=', 'd_purchase_order.po_id')
            // ->where('d_purchaseorder_dt.d_pcsdt_isreceived','=','FALSE')
            ->where('d_purchaseorder_dt.podt_qtysend','!=','0')
            ->where('d_purchase_order.po_code', 'LIKE', '%'.$term.'%')
            ->where('d_purchaseorder_dt.podt_isconfirm','=','TRUE')
            ->orderBy('d_purchase_order.po_code', 'DESC')
            ->limit(5)
            ->groupBy('po_code')->get();

            foreach ($purchase as $val) 
            {
                $formatted_tags[] = ['id' => $val->podt_purchaseorder, 'text' => $val->po_code];
            }

          return Response::json($formatted_tags);  
        }
    }
    public function getdataform($id)
    {
        $data_header = DB::table('d_purchase_order')
            ->join('m_supplier','m_supplier.s_id','=','d_purchase_order.po_supplier')
            ->where('po_id', '=',$id)
            ->first();  
        $data_isi = DB::table('d_purchaseorder_dt')
            ->join('d_purchase_order', 'd_purchaseorder_dt.podt_purchaseorder', '=', 'd_purchase_order.po_id')
            // ->leftjoin('d_terima_pembelian_dt','d_terima_pembelian_dt','=','d_purchaseorder_dt.')
            ->join('m_item','m_item.i_id','=','d_purchaseorder_dt.podt_item')
            ->join('m_satuan','m_satuan.s_id','=','d_purchaseorder_dt.podt_satuan')
            ->where('d_purchase_order.po_id', '=',$id)
            ->get();

        $item = [];
        for ($i=0; $i <count($data_isi) ; $i++) { 
            $item[$i] = $data_isi[$i]->podt_item;
        }
        $data_stock = DB::table('d_stock')
            ->whereIn('s_item',$item)
            ->get();
        
        return response()->json([
            'data_header'=>$data_header,
            'data_isi'=>$data_isi,
            'data_stock'=>$data_stock,
        ]);          
    }

    public function simpan_penerimaan(Request $request)
    {
       // dd($request->all());
      // session::get()->all();
       $increment = DB::table('d_terima_pembelian')->max('d_tb_id');
       if ($increment == null) {
         $increment = 1;
       }else{
         $increment += 1;
       }


      $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_tb_code,4)) as kode_max from d_terima_pembelian WHERE DATE_FORMAT(d_tb_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));

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

      $tb_code = "TB-".date('ym')."-".$kd;
       // return $increment;
       date_default_timezone_set("Asia/Jakarta"); 
      // return date('d/m/Y h:i:s');
       $data_header = DB::table('d_terima_pembelian')->insert([
          'd_tb_id'=>$increment,
          'd_tb_pid'=>$request->headNotaPurchase,
          'd_tb_code'=>$tb_code,
          'd_tb_sup'=>$request->headSupplierId,
          'd_tb_staff'=>$request->headStaffId,
          'd_tb_noreff'=>$request->headNotaTxt,
          'd_tb_totalnett'=>$request->headTotalNett,
          'd_tb_totalbyr'=>$request->headTotalTerima,
          'd_tb_date'=>date('Y-m-d',strtotime($request->headTglTerima)),
          'd_tb_created'=>date('Y-m-d h:i:s'),
          'd_tb_duedate'=>date('Y-m-d'),
          'd_tb_comp'=>Session::get('user_comp'),
       ]);


       for ($i=0; $i <count($request->fieldNamaItem); $i++) { 
           $data_detail = DB::table('d_terima_pembelian_dt')->insert([
              'd_tbdt_idtb'=>$increment,
              'd_tbdt_item'=>$request->fieldItemId[$i],
              'd_tbdt_sat'=>$request->fieldSatuanId[$i],
              'd_tbdt_qty'=>$request->fieldQtyterima[$i],
              'd_tbdt_totalqty'=>$request->fieldQty[$i],
              'd_tbdt_price'=>$request->fieldHargaRaw[$i],
              'd_tbdt_comp'=>Session::get('user_comp'),
              'd_tbdt_pricetotal'=>$request->fieldHargaTotalRaw[$i],
              'd_tbdt_date_received'=>date('Y-m-d',strtotime($request->headTglTerima)),
           ]);
       }
        
         for ($i=0; $i <count($request->fieldNamaItem); $i++) {
            $check[$i] = DB::table('d_stock')
                            ->where('s_comp',$request->head_po_comp)
                            ->where('s_position',$request->head_po_comp)
                            ->where('s_item','=',$request->fieldItemId[$i])
                            ->get();

            $check_satuan[$i] = DB::table('m_item')->where('i_id','=',$request->fieldItemId[$i])->get();
            if(count($check[$i]) == 0) 
              {   
                $insert_stock = DB::table('d_stock')->insert([
                  's_comp'=>$request->head_po_comp,
                  's_position'=>$request->head_po_comp,
                  's_qty'=>$request->fieldQtyterima[$i],
                  's_item'=>$request->fieldItemId[$i],
                  's_insert'=>date('Y-m-d h:i:s'),
                ]);
              }else{
                $update_stock = DB::table('d_stock')
                            ->where('s_comp',$request->head_po_comp)
                            ->where('s_position',$request->head_po_comp)
                            ->where('s_item',$check[$i][0]->s_item)->update([
                  // 's_comp'=>1,
                  // 's_position'=>1,
                  's_qty'=>(($check_satuan[$i][0]->i_sat_isi1*$request->fieldQtyterima[$i])+$check[$i][0]->s_qty),
                  's_update'=>date('Y-m-d h:i:s'),
                ]);
            }
         }

         // for ($i=0; $i <count($request->fieldNamaItem); $i++) {
         //    $check[$i] = DB::table('d_stock')->where('s_item','=',$request->fieldItemId[$i])->get();
         //    $check_satuan[$i] = DB::table('m_item')->where('i_id','=',$request->fieldItemId[$i])->get();
         //    $update_stock = DB::table('d_stock')->where('s_item',$check[$i][0]->s_item)->update([
         //      's_qty'=>(($check_satuan[$i][0]->i_sat_isi1*$request->fieldQtyterima[$i])+$check[$i][0]->s_qty),
         //      's_update'=>date('Y-m-d h:i:s'),
         //    ]);
         // }

         
       // dd($request->all());
      $data_po_header = DB::table('d_purchase_order')
                      ->where('po_id',$request->headNotaPurchase)
                      ->update(['po_received'=>date('Y-m-d')]);
                      
      for ($i=0; $i <count($request->fieldNamaItem); $i++) { 
          $data_detail_check[$i] = DB::table('d_purchaseorder_dt')
                  ->where('podt_detailid',$request->order_id[$i])
                  ->where('podt_purchaseorder',$request->headNotaPurchase)
                  ->get();
          // $data_detail_check[$i]->podt_qtysend;
          $send[$i] =  $data_detail_check[$i][0]->podt_qtyreceive+($request->fieldQty[$i] - $request->fieldQtyterima[$i]);
          $data_detail_order = DB::table('d_purchaseorder_dt')
              ->where('podt_detailid',$request->order_id[$i])
              ->where('podt_purchaseorder',$request->headNotaPurchase)
              ->update([
                 'podt_qtysend'=>$data_detail_check[$i][0]->podt_qtysend-$request->fieldQtyterima[$i],
                 'podt_qtyreceive'=>$data_detail_check[$i][0]->podt_qtyreceive+$request->fieldQtyterima[$i],
           ]);
       }

       // return $chek;
       // return $data_detail_order;
       return response()->json([
            'status' => 'Sukses',
            'pesan' => 'Data Telah Berhasil di Simpan'
        ]);

    }
    public function list_sj(Request $request)
    {
        $id_sj = trim($request->sj_code);
            
        return response()->json([
            'idSj' => $id_sj,
        ]);
        //return view('/inventory/p_hasilproduksi/tabel_penerimaan',compact('query'));
    }

    public function get_tabel_data($id)
    {

        $query = d_delivery_orderdt::select(
                    'd_delivery_order.do_nota', 
                    'd_delivery_orderdt.dod_do',
                    'd_delivery_orderdt.dod_detailid',
                    'm_item.i_name',
                    'd_delivery_orderdt.dod_qty_send',
                    'd_delivery_orderdt.dod_qty_received',
                    'd_delivery_orderdt.dod_date_received',
                    'd_delivery_orderdt.dod_time_received',
                    'd_delivery_orderdt.dod_status')
            ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
            ->join('m_item', 'd_delivery_orderdt.dod_item', '=', 'm_item.i_id')
            ->where('d_delivery_order.do_nota', '=', $id)
            ->where('d_delivery_orderdt.dod_status', '=', 'WT')
            ->orderBy('d_delivery_orderdt.dod_update', 'desc')
            ->get();

        return DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('action', function($data)
        {
            if ($data->dod_qty_received == '0' && $data->dod_date_received == null && $data->dod_time_received == null) {
                return '<div class="text-center">
                            <button class="btn btn-sm btn-success" title="Terima"
                                onclick=terimaHasilProduksi("'.$data->dod_do.'","'.$data->dod_detailid.'")><i class="fa fa-plus"></i> 
                            </button>&nbsp;
                            
                        </div>';
            }   
        })
        ->editColumn('tanggalTerima', function ($data) 
        {
            if ($data->dod_date_received == null) 
            {
                return '-';
            }
            else 
            {
                return $data->dod_date_received ? with(new Carbon($data->dod_date_received))->format('d M Y') : '';
            }
        })
        ->editColumn('jamTerima', function ($data) 
        {
            if ($data->dod_time_received == null) 
            {
                return '-';
            }
            else 
            {
                return $data->dod_time_received;
            }
        })
        ->editColumn('status', function ($data) 
        {
            if ($data->dod_status == "WT") 
            {
                return '<span class="label label-info">Waiting</span>';
            }
            elseif ($data->dod_status == "FN") 
            {
                return '<span class="label label-success">Final</span>';
            }
        })
        //inisisai column status agar kode html digenerate ketika ditampilkan
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function terima_hasil_produksi($dod_do, $dod_detailid){
        $query = d_delivery_orderdt::select(
                                        'd_delivery_order.do_nota', 
                                        'd_delivery_orderdt.dod_do',
                                        'd_delivery_orderdt.dod_detailid',
                                        'd_delivery_orderdt.dod_item',
                                        'd_delivery_orderdt.dod_prdt_productresult',
                                        'd_delivery_orderdt.dod_prdt_detail',
                                        'm_item.i_name',
                                        'd_delivery_orderdt.dod_qty_send',
                                        'd_delivery_orderdt.dod_qty_received',
                                        'd_delivery_orderdt.dod_date_received',
                                        'd_delivery_orderdt.dod_time_received',
                                        'd_delivery_orderdt.dod_status')
            ->join('d_delivery_order', 'd_delivery_orderdt.dod_do', '=', 'd_delivery_order.do_id')
            ->join('m_item', 'd_delivery_orderdt.dod_item', '=', 'm_item.i_id')
            ->where('d_delivery_orderdt.dod_do', '=', $dod_do)
            ->where('d_delivery_orderdt.dod_detailid', '=', $dod_detailid)
            ->where('d_delivery_orderdt.dod_status', '=', 'WT')
            ->get();

         echo json_encode($query);
    }

    public function simpan_update_data(Request $request){
      // dd($request->all());
      DB::beginTransaction();
      try {
        //ubah status
          $recentStatusDo = DB::table('d_delivery_orderdt')
                              ->where('dod_do',$request->doId)
                              ->where('dod_detailid',$request->detailId)
                              ->first();
          // dd($recentStatusDo);
          if ($recentStatusDo->dod_status == "WT") {
              //update status to FN
              DB::table('d_delivery_orderdt')
                  ->where('dod_do',$request->doId)
                  ->where('dod_detailid',$request->detailId)
                  ->update(['dod_status' => "FN"]);
          }else{
              //update status to WT
              DB::table('d_delivery_orderdt')
                  ->where('dod_do',$request->doId)
                  ->where('dod_detailid',$request->detailId)
                  ->update(['dod_status' => "WT"]);
          }

          //get recent status Product Result detail
          //end status
          $doId = d_delivery_order::where('do_id',$request->doId)->first();
          $gc_sending = d_gudangcabang::select('gc_id')
                      ->where('gc_gudang','GUDANG SENDING')
                      ->first();
          //get stock item gdg Sending

          if(mutasi::mutasiStok(  $request->idItemMasuk,
                                  $request->qtyDiterima,
                                  $comp=$doId->do_send,
                                  $position=$gc_sending->gc_id,
                                  $flag='MENGURANGI',
                                  $request->noNotaMasuk,
                                  'MENGURANGI',
                                  Carbon::now(),
                                  100)){}

          //cek ada tidaknya record pada tabel
          $id_stock = DB::table('d_stock')->select('s_id')
              ->where('s_comp',$doId->do_send)
              ->where('s_position',$doId->do_send)
              ->where('s_item',$request->idItemMasuk)
              ->first();
          // dd($id_stock);
          if($id_stock != null){ //jika terdapat record, maka lakukan update
              //get stock item gdg Grosir
              $stok_item_gs = DB::table('d_stock')
              ->where('s_comp',$doId->do_send)
              ->where('s_position',$doId->do_send)
              ->where('s_item',$request->idItemMasuk)
              ->first();
              $stok_akhir_gdgGrosir = $stok_item_gs->s_qty + $request->qtyDiterima;
              //update stok gudang grosir
              $update = DB::table('d_stock')
                  ->where('s_comp',$doId->do_send)
                  ->where('s_position',$doId->do_send)
                  ->where('s_item',$request->idItemMasuk)
                  ->update(['s_qty' => $stok_akhir_gdgGrosir]);

              $sm_detailid = d_stock_mutation::select('sm_detailid')
                ->where('sm_stock',$id_stock->s_id)
                ->max('sm_detailid')+1;
                
              d_stock_mutation::create([
                    'sm_stock' => $id_stock->s_id,
                    'sm_detailid' => $sm_detailid,
                    'sm_date' => Carbon::now(),
                    'sm_comp' => $doId->do_send,
                    'sm_position' => $doId->do_send,
                    'sm_mutcat' => 9,
                    'sm_item' => $request->idItemMasuk,
                    'sm_qty' => $request->qtyDiterima,
                    'sm_qty_used' => 0,
                    'sm_qty_sisa' => $request->qtyDiterima,
                    'sm_qty_expired' => 0,
                    'sm_detail' => 'PENAMBAHAN',
                    'sm_reff' => $request->noNotaMasuk,
                    'sm_insert' => Carbon::now()
                ]);

          }else{ //jika tidak ada record, maka lakukan insert
              //get last id
              $id_stock = DB::table('d_stock')->max('s_id') + 1;
              //insert value ke tbl d_stock
              DB::table('d_stock')->insert([
                  's_id' => $id_stock,
                  's_comp' => $doId->do_send,
                  's_position' => $doId->do_send,
                  's_item' => $request->idItemMasuk,
                  's_qty' => $request->qtyDiterima,
              ]);

              d_stock_mutation::create([
                  'sm_stock' => $id_stock,
                  'sm_detailid' =>1,
                  'sm_date' => Carbon::now(),
                  'sm_comp' => $doId->do_send,
                  'sm_position' => $doId->do_send,
                  'sm_mutcat' => 9,
                  'sm_item' => $request->idItemMasuk,
                  'sm_qty' => $request->qtyDiterima,
                  'sm_qty_used' => 0,
                  'sm_qty_sisa' => $request->qtyDiterima,
                  'sm_qty_expired' => 0,
                  'sm_detail' => 'PENAMBAHAN',
                  'sm_reff' => $request->noNotaMasuk,
                  'sm_insert' => Carbon::now()
              ]);
          }
           
          //update d_delivery_orderdt
          $date = Carbon::parse($request->tglMasuk)->format('Y-m-d');
          $time = $request->jamMasuk.":00";
          $now = Carbon::now();
          DB::table('d_delivery_orderdt')
                  ->where('dod_detailid', $request->detailId)
                  ->where('dod_do',$request->doId)
                  ->update(['dod_qty_received' => $request->qtyDiterima, 'dod_date_received' => $date, 'dod_time_received' => $time, 'dod_update' => $now]);
                      
          DB::commit();
          return response()->json([
              'status' => 'Sukses',
              'pesan' => 'Data Telah Berhasil di Simpan'
          ]);
      }catch (\Exception $e) {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'data' => $e->getMessage()
          ]);
      }
    }

    public function get_penerimaan_by_tgl($tgl1,$tgl2,$akses,$comp)
    {
        // dd($akses);
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;
        //dd(array($tanggal1, $tanggal2));
        
        // $query = DB::table('d_purchase_order')
        // ->select('d_tb_code','d_tb_duedate','po_id','po_comp','po_date','po_code','po_supplier','s_company','po_mem','m_name','d_tb_status')
        // ->join('d_mem','d_purchase_order.po_mem','=','d_mem.m_id')
        // ->join('m_supplier','d_purchase_order.po_supplier','=','m_supplier.s_id')
        // ->leftjoin('d_terima_pembelian','d_purchase_order.po_code','=','d_terima_pembelian.d_tb_noreff')
        // ->where('po_comp',$comp)
        // ->get();

        $query = DB::table('d_terima_pembelian')
                ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
                ->join('m_supplier','d_terima_pembelian.d_tb_sup','=','m_supplier.s_id')
                ->leftjoin('d_purchase_order','d_purchase_order.po_code','=','d_terima_pembelian.d_tb_noreff')
                ->where('po_comp',$comp)
                ->get();
        // return $query;   
     
            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($data)
            {
                return '<div class="text-center">
                            <a class="btn btn-sm btn-success" href="javascript:void(0)" title="Ubah Status"
                                onclick=lihatStatus("'.$data->d_tb_code.'")><i class="fa fa-eye"></i>
                            </a>
                        </div>
                        ';
                    
            })
            ->editColumn('tanggalTerima', function ($data) 
            {
                if ($data->d_tb_duedate == null) 
                {
                    return '-';
                }
                else 
                {
                    return $data->d_tb_duedate ? with(new Carbon($data->d_tb_duedate))->format('d M Y') : '';
                }
            })
            ->editColumn('status', function ($data) 
            {
                if ($data->d_tb_status == "WT") 
                {
                    return '<span class="label label-info">Waiting</span>';
                }
                elseif ($data->d_tb_status == "FN") 
                {
                    return '<span class="label label-success">Final</span>';
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        
              
    }

    public function getdatadetail($id)
    {

       $data_header = DB::table('d_terima_pembelian')
                  ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
                  ->join('m_supplier','d_terima_pembelian.d_tb_sup','=','m_supplier.s_id')
                  ->where('d_tb_code',$id)
                  ->get();
       
       $data_isi = DB::table('d_terima_pembelian')
                ->select('s_qty','d_tbdt_qty','d_tbdt_qty','d_tbdt_totalqty','i_code','i_name','ms.s_name')
                ->join('d_terima_pembelian_dt','d_tb_id','d_tbdt_idtb')
                ->join('m_item','i_id','d_tbdt_item')
                ->join('d_mem','d_terima_pembelian.d_tb_staff','=','d_mem.m_id')
                ->join('m_supplier','d_terima_pembelian.d_tb_sup','=','m_supplier.s_id')
                ->leftjoin('d_stock','d_stock.s_item','=','m_item.i_id')
                ->join('m_satuan as ms','ms.s_id','=','d_terima_pembelian_dt.d_tbdt_sat')
                ->leftjoin('d_purchase_order','d_purchase_order.po_code','=','d_terima_pembelian.d_tb_noreff')
                ->where('d_tb_code',$id)
                ->get();
     
     return response()
            ->json([
                'data_isi'=>$data_isi,
                'data_header'=>$data_header,
            ]);
        
    }
}
