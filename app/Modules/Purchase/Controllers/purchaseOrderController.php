<?php

namespace App\Modules\Purchase\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;
use App\m_itemm;
use App\Http\Controllers\Controller;
use App\mMember;
use App\Modules\Purchase\model\d_purchase_order;
use App\Modules\Purchase\model\d_purchaseorder_dt;
use Response;
use App\m_supplier;
use Datatables;
use Session;
use App\d_gudangcabang;
use App\d_purchasing;
use App\Modules\Purchase\model\d_purchasing_dt;

class purchaseOrderController extends Controller
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

   public function konvertRp($value)
    {
      $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
      return (int)str_replace(',', '.', $value);
    }
   public function seachItemPurchase(Request $request){
         return   m_itemm::seachItemPurchase($request);
   }
   public function simpanOrder(Request $request){
      d_purchase_order::simpanOrder($request);

   }
   public function orderIndex(){
    $tindex =view('Purchase::orderpembelian/tab-index');
    $history =view('Purchase::orderpembelian/tab-history');
    /*$to =view('Purchase::orderpembelian/tambah_order');   */

    $modal =view('Purchase::orderpembelian/modal');
    $modaledit =view('Purchase::orderpembelian/modal-edit');

    $modaldetail=view('Purchase::orderpembelian/modal-detail-peritem');
    $modaldetail_show=view('Purchase::orderpembelian/modal-detail-order');

     return view('Purchase::orderpembelian/index',compact('tindex','history','to','modal','modaledit','modaldetail','modaldetail_show'));
   }
   public function dataOrder(Request $request){
      return d_purchase_order::dataOrder($request);
   }
   public function formOrder()
   {
      return view('Purchase::orderpembelian/tambah_order');
   }

   public function savePo(Request $request)
   {
      // dd($request->all());
      $totalGross = $this->konvertRp($request->totalGross);
      $replaceCharDisc = (int)str_replace("%","",$request->diskonHarga);
      $replaceCharPPN = (int)str_replace("%","",$request->ppnHarga);
      $diskonPotHarga = $this->konvertRp($request->potonganHarga);
      $discValue = $totalGross * $replaceCharDisc / 100;
      //code
      $p_id=d_purchasing::max('d_pcs_id')+1;
      $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcs_code,4)) as kode_max from d_purchasing WHERE DATE_FORMAT(d_pcs_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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
      $p_code = "PO-".date('ym')."-".$kd;
      //end code
      $comp = Session::get('user_comp');

      DB::beginTransaction();
      try {
          //insert to table d_purchasing
          $dataHeader = new d_purchasing;
          $dataHeader->d_pcsp_id = $request->cariKodePlan;
          $dataHeader->s_id = $request->cariSup;
          $dataHeader->p_pcs_comp = $comp;
          $dataHeader->d_pcs_code = $p_code;
          $dataHeader->d_pcs_staff = $request->idStaff;
          $dataHeader->d_pcs_method = $request->methodBayar;
          $dataHeader->d_pcs_total_gross = $totalGross;
          $dataHeader->d_pcs_discount = $diskonPotHarga;
          $dataHeader->d_pcs_disc_percent = $replaceCharDisc;
          $dataHeader->d_pcs_disc_value = $discValue;
          $dataHeader->d_pcs_tax_percent = $replaceCharPPN;
          $dataHeader->d_pcs_duedate = date('Y-m-d',strtotime($request->jatuhTempo));
          $dataHeader->d_pcs_tax_value = ($totalGross - $diskonPotHarga - $discValue) * $replaceCharPPN / 100;
          $dataHeader->d_pcs_total_net = $this->konvertRp($request->totalNett);
          // $dataHeader->d_pcs_sisapayment = $this->konvertRp($request->totalNett);
          $dataHeader->d_pcs_date_created = date('Y-m-d',strtotime($request->tanggal));
          $dataHeader->save(); 
         
        //get last lastId then insert id to d_purchasing_dt
        //variabel untuk hitung array field
        $hitung_field = count($request->fieldItemId);

        //update pada tabel d_purchasingplan_dt column
        for ($i=0; $i < $hitung_field; $i++) 
        { 
          DB::table('d_purchaseplan_dt')
          ->where('ppdt_pruchaseplan', $request->fieldidPlanDt[$i])
          ->update([
               'ppdt_ispo' => 'TRUE'
            ]);
        }

        //insert data isi
        for ($i=0; $i < $hitung_field; $i++) 
        {
          $old_str = [".", ","];
          $new_str = ["", "."];
          $dataIsi = new d_purchasing_dt;
          $dataIsi->d_pcs_id = $p_id;
          $dataIsi->i_id = $request->fieldItemId[$i];
          $dataIsi->d_pcsdt_sid = $request->cariSup;
          $dataIsi->d_pcsdt_sat = $request->fieldIdSatuan[$i];
          $dataIsi->d_pcsdt_idpdt = $request->fieldidPlanDt[$i];
          $dataIsi->d_pcsdt_qty = $request->fieldQty[$i];
          $dataIsi->d_pcsdt_price = str_replace($old_str, $new_str, $request->fieldHarga[$i]);
          $dataIsi->d_pcsdt_prevcost = str_replace($old_str, $new_str, $request->fieldHargaPrev[$i]);
          $dataIsi->d_pcsdt_total = str_replace($old_str, $new_str, $request->fieldHargaTotal[$i]);
          $dataIsi->d_pcsdt_created = Carbon::now();
          $dataIsi->save();
        }
      DB::commit();
      return response()->json([
            'status' => 'sukses',
            'pesan' => 'Data Order Pembelian Berhasil Disimpan'
        ]);
      } 
      catch (\Exception $e) 
      {
        //dd($e);
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        ]);
      }

   }

   public function getDataDetail(Request $request,$id)
   {
      // return 'a';
      $dataHeader = d_purchase_order::join('m_supplier', 's_id', '=', 'po_supplier')
                         ->join('d_mem','m_id','=','po_mem')
                         ->where('po_id',$id)->first();
      // $dataHeader = d_purchase_order::where('po_id',$id)->first();
      $dataIsi = d_purchaseorder_dt::
                             join('d_purchase_order','podt_purchaseorder','=','po_id')
                             ->leftjoin('m_item','podt_item','=','i_id')
                             // ->leftjoin('d_item_supplier','is_item','=','i_id')
                             // ->leftjoin('m_price','m_pitem','=','i_id')
                             ->leftjoin('m_satuan', 's_id', '=', 'podt_satuan')
                             // ->leftjoin('d_stock','s_item','=','i_id')
                             ->where('podt_purchaseorder', '=', $id)
                             // ->where('po_comp',$gudang->p_comp)
                             // ->where('popen(command, mode)_gudang',$gudang->p_gudang)
                             // ->where('podt_ispo', '=', "FALSE")
                             // ->where('podt_isconfirm', '=', "TRUE")
                             ->orderBy('podt_created', 'DESC')
                             ->get();
         // $prev_harga = [];
         $harga = [];

         for ($i=0; $i <count($dataIsi) ; $i++) {
           // $prev_harga = '';
           $prev_harga[$i] = DB::table('d_item_supplier')
                             ->where('is_item',$dataIsi[$i]->i_id)
                             ->get();

             if ($dataIsi[$i]->satuan_position == 1) {
               if ($dataIsi[$i]->is_price1 != null) {
                   $harga[$i] = $dataIsi[$i]->is_price1;
               }else{
                   $harga[$i] = 0;
               }
             }elseif ($dataIsi[$i]->satuan_position == 2) {
               if ($dataIsi[$i]->is_price2 != null) {
                   $harga[$i] = $dataIsi[$i]->is_price2;
               }else{
                   $harga[$i] = 0;
               }
             }elseif ($dataIsi[$i]->satuan_position == 3) {
               if ($dataIsi[$i]->is_price3 != null) {
                   $harga[$i] = $dataIsi[$i]->is_price3;
               }else{
                   $harga[$i] = 0;
               }
             }
         }

         // return $prev_harga;
         // return $harga;


      return response()->json([
         'status' => 'sukses',
         'data_isi' => $dataIsi,
         'header' => $dataHeader,
         'data_prev' => $harga,
      ]);
   }

   public function deleteDataOrder(Request $request)
   {
      $dataHeader = d_purchase_order::where('po_id',$request->idPo)->delete();
      $dataDetail = d_purchaseorder_dt::where('podt_purchaseorder',$request->idPo)->delete();
       // dd($request->all()); 
        return response()->json([
            'status' => 'sukses',
        ]);
   }

   public function getDataEdit($id)
   {    
      $dataHeader = d_purchase_order::join('m_supplier','s_id','po_supplier')->where('po_id',$id)->where('po_status','=','WT')->get();

      $dataIsi = d_purchaseorder_dt::join('m_item','i_id','podt_item')
                         ->join('m_satuan','s_id','podt_satuan')
                         ->leftjoin('d_stock','s_item','=','i_id')
                         ->where('podt_purchaseorder',$id)
                         ->orderBy('i_id','ASC')
                         ->get();


      $tamp=[];
      foreach ($dataIsi as $key => $value) {
       $tamp[$key]=$value->podt_item;
      }     
      $urut_index = count($tamp);
      $tamp=array_map("strval",$tamp); 


      return view('Purchase::orderpembelian/edit_order',compact('data','tamp','urut_index','dataIsi','dataHeader'));
   }

   public function updatePo(Request $request)
   {
       // dd($request->all());
      for ($i=0; $i <count($request->id_header_remove) ; $i++) { 
        $delete = DB::table('d_purchaseorder_dt')
                            ->where('podt_detailid',$request->id_detail_remove[$i])
                            ->where('podt_purchaseorder',$request->id_header_remove[$i])
                            ->delete();
      }
      for ($i=0; $i <count($request->podt_purchaseorder) ; $i++) { 
        $update = DB::table('d_purchaseorder_dt')
                            ->where('podt_detailid',$request->podt_detailid[$i])
                            ->where('podt_purchaseorder',$request->podt_purchaseorder[$i])
                            ->update([
                                'podt_qtysend'=>$request->fieldQtyconfirm[$i],
                                'podt_qty'=>$request->fieldQtyconfirm[$i],
                                'podt_price'=>$request->podt_price[$i],
                                'podt_total'=>$request->podt_total[$i],
                            ]);
      }

      return response()->json(['status'=>'sukses']);

   }

   public function getDataRencanaBeli(Request $request)
   {
        $formatted_tags = array();
        $term = trim($request->q);
        if (empty($term)) {
            $sup = DB::table('d_purchaseplan_dt')
                     ->select('d_purchase_plan.p_code', 'd_purchaseplan_dt.ppdt_pruchaseplan')
                     ->join('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
                     ->where('d_purchaseplan_dt.ppdt_isconfirm', '=', "TRUE")
                     ->where('d_purchaseplan_dt.ppdt_ispo', '=', "FALSE")
                     ->groupBy('d_purchaseplan_dt.ppdt_pruchaseplan')
                     ->get();
                     // dd($sup);
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->ppdt_pruchaseplan, 'text' => $val->p_code];
            }
            return Response::json($formatted_tags);
        }
        else
        {
            $sup = DB::table('d_purchaseplan_dt')
                     ->select('d_purchase_plan.p_code', 'd_purchaseplan_dt.ppdt_pruchaseplan')
                     ->join('d_purchase_plan','d_purchaseplan_dt.ppdt_pruchaseplan','=','d_purchase_plan.p_id')
                     ->where('d_purchase_plan.p_code', 'LIKE', '%'.$term.'%')
                     ->where('d_purchaseplan_dt.ppdt_isconfirm', '=', "TRUE")
                     ->where('d_purchaseplan_dt.ppdt_ispo', '=', "FALSE")
                     ->groupBy('d_purchaseplan_dt.ppdt_pruchaseplan')
                     ->get();
            // dd($sup);
            foreach ($sup as $val) {
                $formatted_tags[] = ['id' => $val->ppdt_pruchaseplan, 'text' => $val->p_code];
            }

            return Response::json($formatted_tags);  
        }
    }

   public function getDataSupplier(Request $request)
   {
      $formatted_tags = array();
      $term = trim($request->q);
      if (empty($term)) {
          $sup = DB::table('m_supplier')
            ->where('s_active','Y')
            ->take(10)->get();
          foreach ($sup as $val) {
              $formatted_tags[] = ['id' => $val->s_id, 'text' => $val->s_company];
          }
          return Response::json($formatted_tags);
      }
      else
      {
          $sup = DB::table('m_supplier')
            ->where('s_active','Y')
            ->where('s_company', 'LIKE', '%'.$term.'%')->take(10)->get();
          foreach ($sup as $val) {
              $formatted_tags[] = ['id' => $val->s_id, 'text' => $val->s_company];
          }

          return Response::json($formatted_tags);  
      }
   }

   public function getDataForm($id)
   {
      $dataHeader = DB::table('d_purchase_plan')
                    ->select('m_supplier.s_id', 
                              'm_supplier.s_company',
                              'p_supplier')
                    ->join('m_supplier', 'd_purchase_plan.p_supplier', '=', 'm_supplier.s_id')
                    ->where('d_purchase_plan.p_id', '=', $id)
                    ->get();

      // //Hitung Hutang
      // $hitHutang = d_purchasing::select('d_pcs_sisapayment')
      // ->where('d_pcs_sisapayment','!=','0')
      // ->where('s_id',$dataHeader[0]->d_pcsp_sup)
      // ->get();
      
      // $totHutang = 0;
      // for ($i=0; $i < count($hitHutang) ; $i++) { 
      //   $totHutang += $hitHutang[$i]->d_pcs_sisapayment;
      // }
      // //end Hitung Hutang
      // //Hitung Plafon
      // $plafon = DB::table('d_supplier')
      //   ->select('s_limit','s_top')
      //   ->where('s_id',$dataHeader[0]->d_pcsp_sup)
      //   ->first();

      // $batasPlafon = $plafon->s_limit - $totHutang;
      // if ($plafon->s_limit == '0') {
      //   $batasPlafon = '0';
      // }
      // $cariSisa = d_purchasing::select('d_pcs_sisapayment')
      // ->where('s_id',$dataHeader[0]->d_pcsp_sup)
      // ->where('d_pcs_sisapayment','!=','0.00')
      // ->get();
      // $totalSisa = 0;
      // for ($i=0; $i <count($cariSisa) ; $i++) 
      // { 
        
      //   $totalSisa += $cariSisa[$i]->d_pcs_sisapayment;
      // }
      // $batasPlafon = $plafon->s_limit - $totalSisa;
      // //End Plafon
      // //cari jatuh tempo
      // $oke = $plafon->s_top.' '. 'days';
      // $date = Carbon::now()->toDateString();
      // $date=date_create($date);
      // date_add($date,date_interval_create_from_date_string($oke));
      // $jatuhTempo = date_format($date,"d-m-Y");
      // //end
      $dataIsi = DB::table('d_purchaseplan_dt')
            ->select('d_purchaseplan_dt.*', 
                     'm_item.i_name', 
                     'm_item.i_code', 
                     'm_item.i_sat1', 
                     'm_item.i_id', 
                     'm_satuan.s_name', 
                     'm_satuan.s_id')
            ->leftJoin('m_item','d_purchaseplan_dt.ppdt_item','=','m_item.i_id')
            ->leftJoin('m_satuan','d_purchaseplan_dt.ppdt_satuan','=','m_satuan.s_id')
            ->where('d_purchaseplan_dt.ppdt_pruchaseplan', '=', $id)
            ->where('d_purchaseplan_dt.ppdt_ispo', '=', "FALSE")
            ->where('d_purchaseplan_dt.ppdt_isconfirm', '=', "TRUE")
            ->get();

        foreach ($dataIsi as $val) 
        {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
        }

        //variabel untuk count array
        $counter = 0;
        //ambil value stok by item type
        $comp = Session::get('user_comp');
         $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
      
         return response()->json([
            'status' => 'sukses',
            'data_header' => $dataHeader,
            'data_isi' => $dataIsi,
            'data_stok' => $dataStok['val_stok'],
            'data_satuan' => $dataStok['txt_satuan'],
            // 'plafon' => $plafon->s_limit,
            // 'batasPlafon' => $batasPlafon,
            // 'plafonRp' => number_format($plafon->s_limit,2,",","."),
            // 'batasPlafonRp' => number_format( $batasPlafon,2,",","."),
            // 'jatuhTempo' =>  $jatuhTempo,
         ]);
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
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id' AND s_position = '$gc_id' limit 1) ,'0') as qtyStok"));
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
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id' AND s_position = '$gc_id' limit 1) ,'0') as qtyStok"));
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
            $query = DB::select(DB::raw("SELECT IFNULL( (SELECT s_qty FROM d_stock where s_item = '$val->i_id' AND s_comp = '$gc_id' AND s_position = '$gc_id' limit 1) ,'0') as qtyStok"));
            $satUtama = DB::table('m_item')->join('m_satuan', 'm_item.i_sat1', '=', 'm_satuan.s_id')->select('m_satuan.s_name')->where('m_item.i_sat1', '=', $arrSatuan[$counter])->first();

            $stok[] = $query[0];
            $satuan[] = $satUtama->s_name;
            $counter++;
         }
      }

      $data = array('val_stok' => $stok, 'txt_satuan' => $satuan);
      return $data;
   }

   public function getOrderByTgl($tgl1, $tgl2)
   {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
       $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      $data = d_purchasing::select('d_pcs_date_created',
                                    'd_pcs_id', 
                                    'd_pcsp_id',
                                    'd_pcs_code',
                                    's_company',
                                    'd_pcs_method',
                                    'd_pcs_total_net',
                                    'd_pcs_date_received',
                                    'd_pcs_status',
                                    'd_mem.m_id',
                                    'd_mem.m_name')
            ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
            ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
            ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
            ->orderBy('d_pcs_created', 'DESC')
            ->get();

      return DataTables::of($data)
      ->addIndexColumn()
      ->editColumn('status', function ($data)
      {
         if ($data->d_pcs_status == "WT") 
         {
            return '<span class="label label-default">Waiting</span>';
         }
         elseif ($data->d_pcs_status == "DE") 
         {
            return '<span class="label label-warning">Dapat diedit</span>';
         }
         elseif ($data->d_pcs_status == "CF") 
         {
            return '<span class="label label-info">Disetujui</span>';
         }
         else
         {
            return '<span class="label label-success">Diterima</span>';
         }
      })

      ->editColumn('tglOrder', function ($data) 
      {
         if ($data->d_pcs_date_created == null) 
         {
            return '-';
         }
         else 
         {
            return $data->d_pcs_date_created ? with(new Carbon($data->d_pcs_date_created))->format('d M Y') : '';
         }
      })

      ->editColumn('hargaTotalNet', function ($data) 
      {
         return number_format($data->d_pcs_total_net,0,",",".");
      })

      ->editColumn('tglMasuk', function ($data) 
      {
        if ($data->d_pcs_date_received == null) 
        {
            return '-';
        }
        else 
        {
            return $data->d_pcs_date_received ? with(new Carbon($data->d_pcs_date_received))->format('d M Y') : '';
        }
      })
      
      ->addColumn('action', function($data)
      {
        if ($data->d_pcs_status == "WT") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'")><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }
        elseif ($data->d_pcs_status == "DE") 
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'")><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }
        else
        {
          return '<div class="text-center">
                      <button class="btn btn-sm btn-success" title="Detail"
                          onclick=detailOrder("'.$data->d_pcs_id.'")><i class="fa fa-info-circle"></i> 
                      </button>
                      <button class="btn btn-sm btn-warning" title="Edit"
                          onclick=editOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete"
                          onclick=deleteOrder("'.$data->d_pcs_id.'") disabled><i class="fa fa-times-circle"></i>
                      </button>
                  </div>'; 
        }  
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
   }

}
