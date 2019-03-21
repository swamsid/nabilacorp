<?php

namespace App\Modules\Purchase\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use DB;
use Datatables;
use Auth;
use App\d_purchasing;
use App\d_purchasing_dt;
use App\d_purchasingreturn;
use App\d_purchasingreturn_dt;
use App\d_stock;
use App\d_stock_mutation;
use App\lib\mutasi;
use Session;
use App\d_gudangcabang;

class ReturnPembelianController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {

    return view('Purchase::returnpembelian.index');
  }

  public function getReturnByTgl($tgl1, $tgl2)
  {
    $y = substr($tgl1, -4);
    $m = substr($tgl1, -7,-5);
    $d = substr($tgl1,0,2);
      $tanggal1 = $y.'-'.$m.'-'.$d;

    $y2 = substr($tgl2, -4);
    $m2 = substr($tgl2, -7,-5);
    $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

    $data = d_purchasingreturn::join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
          ->join('m_supplier','d_purchasingreturn.d_pcsr_supid','=','m_supplier.s_id')
          ->join('d_mem','d_purchasingreturn.d_pcs_staff','=','d_mem.m_id')
          ->select('d_purchasingreturn.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_code', 'd_mem.m_id', 'd_mem.m_name')
          ->whereBetween('d_pcsr_datecreated', [$tanggal1, $tanggal2])
          ->orderBy('d_pcsr_created', 'DESC')
          ->get();

    return DataTables::of($data)
    ->addIndexColumn()
    ->editColumn('status', function ($data)
    {
      if ($data->d_pcsr_status == "WT") 
      {
        return '<span class="label label-default">Waiting</span>';
      }
      elseif ($data->d_pcsr_status == "CF") 
      {
        if ($data->d_pcsr_method == 'PN') {
          return '<span class="label label-success">Potong Nota</span>';
        }else{
          return '<span class="label label-info">Disetujui</span>';
        }        
      }
      elseif ($data->d_pcsr_status == "DE") 
      {
        return '<span class="label label-warning">Dapat Diedit</span>';
      }
      else
      {
        return '<span class="label label-success">Diterima</span>';
      }
    })
    ->editColumn('metode', function ($data)
    {
      if ($data->d_pcsr_method == "TK") 
      {
        return 'Tukar Barang';
      }
      elseif ($data->d_pcsr_method == "PN") 
      {
        return 'Potong Nota';
      }
    })
    ->editColumn('tglBuat', function ($data) 
    {
        if ($data->d_pcsr_datecreated == null) 
        {
            return '-';
        }
        else 
        {
            return $data->d_pcsr_datecreated ? with(new Carbon($data->d_pcsr_datecreated))->format('d M Y') : '';
        }
    })
    ->editColumn('hargaTotal', function ($data) 
    {
      return 'Rp. '.number_format($data->d_pcsr_pricetotal,2,",",".");
    })
    ->addColumn('action', function($data)
    {
      if ($data->d_pcsr_status == "WT") 
      {
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailReturPembelian("'.$data->d_pcsr_id.'")><i class="fa fa-eye"></i> 
                    </button>
                    <button class="btn btn-sm btn-warning" title="Edit"
                        onclick=editReturPembelian("'.$data->d_pcsr_id.'")><i class="glyphicon glyphicon-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Delete"
                        onclick=deleteReturPembelian("'.$data->d_pcsr_id.'")><i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>'; 
      }
      elseif ($data->d_pcsr_status == "DE") 
      {
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailReturPembelian("'.$data->d_pcsr_id.'")><i class="fa fa-eye"></i> 
                    </button>
                    <button class="btn btn-sm btn-warning" title="Edit"
                        onclick=editReturPembelian("'.$data->d_pcsr_id.'")><i class="glyphicon glyphicon-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Delete"
                        onclick=deleteReturPembelian("'.$data->d_pcsr_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>'; 
      }
      else
      {
        return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailReturPembelian("'.$data->d_pcsr_id.'")><i class="fa fa-eye"></i> 
                    </button>
                    <button class="btn btn-sm btn-warning" title="Edit"
                        onclick=editReturPembelian("'.$data->d_pcsr_id.'") disabled><i class="glyphicon glyphicon-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Delete"
                        onclick=deleteReturPembelian("'.$data->d_pcsr_id.'") disabled><i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>'; 
      }
    })
    ->rawColumns(['status', 'action'])
    ->make(true);
  }

  public function getDataDetail($id, $type="all")
  {
    $dataHeader = d_purchasingreturn::join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
          ->join('m_supplier','d_purchasingreturn.d_pcsr_supid','=','m_supplier.s_id')
          ->join('d_mem', 'd_purchasingreturn.d_pcs_staff', '=', 'd_mem.m_id')
          ->select('d_purchasingreturn.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_total_net', 'd_purchasing.d_pcs_code', 'd_mem.m_name', 'd_mem.m_id')
          ->where('d_purchasingreturn.d_pcsr_id', '=', $id)
          ->orderBy('d_pcsr_created', 'DESC')
          ->get();

    $statusLabel = $dataHeader[0]->d_pcsr_status;
    if ($statusLabel == "WT") 
    {
      $spanTxt = 'Waiting';
      $spanClass = 'label-info';
    }
    elseif ($statusLabel == "DE")
    {
      $spanTxt = 'Dapat Diedit';
      $spanClass = 'label-warning';
    }
    else
    {
      $spanTxt = 'Di setujui';
      $spanClass = 'label-success';
    }

    $metodeReturn = $dataHeader[0]->d_pcsr_method;
    if ($metodeReturn == "PN") 
    {
      $lblMethod = 'Potong nota';
    }
    else
    {
      $lblMethod = 'Tukar barang';
    }

    foreach ($dataHeader as $val) 
    {
        $data = array(
          'hargaTotalReturn' => 'Rp. '.number_format($val->d_pcsr_pricetotal,2,",","."),
          'hargaTotalResult' => 'Rp. '.number_format($val->d_pcsr_priceresult,2,",","."),
          'tanggalReturn' => date('d-m-Y',strtotime($val->d_pcsr_datecreated))
        );
    }

    $dataIsi = d_purchasingreturn_dt::join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
            ->join('m_item', 'd_purchasingreturn_dt.d_pcsrdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_purchasingreturn_dt.d_pcsrdt_sat', '=', 'm_satuan.s_id')
            ->select('d_purchasingreturn_dt.*', 'm_item.*', 'd_purchasingreturn.d_pcsr_code', 'm_satuan.s_id', 'm_satuan.s_name')
            ->where('d_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', $id)
            ->orderBy('d_purchasingreturn_dt.d_pcsrdt_created', 'DESC')
            ->get();
    
    //cek item type untuk hitung stok
    foreach ($dataIsi as $val) 
    {
      $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
      //get satuan utama
      $sat1[] = $val->i_sat1;
    }

    //variabel untuk count array
    $counter = 0;
    //ambil value stok by item type
    $comp = Session::get('user_comp');
   $dataStok = $this->getStokByType($itemType, $sat1, $counter, $comp);
    //auth
    $staff['nama'] = Auth::user()->m_name;
    $staff['id'] = Auth::User()->m_id;

    return response()->json([
        'status' => 'sukses',
        'header' => $dataHeader,
        'header2' => $data,
        'data_isi' => $dataIsi,
        'spanTxt' => $spanTxt,
        'spanClass' => $spanClass,
        'lblMethod' => $lblMethod,
        'data_stok' => $dataStok['val_stok'],
        'data_satuan' => $dataStok['txt_satuan'],
        'staff' => $staff
    ]);
  }

  public function getListRevisiByTgl($tgl1, $tgl2)
  {
      $y = substr($tgl1, -4);
      $m = substr($tgl1, -7,-5);
      $d = substr($tgl1,0,2);
      $tanggal1 = $y.'-'.$m.'-'.$d;

      $y2 = substr($tgl2, -4);
      $m2 = substr($tgl2, -7,-5);
      $d2 = substr($tgl2,0,2);
      $tanggal2 = $y2.'-'.$m2.'-'.$d2;

      $data = d_purchasing::join('d_purchasingreturn','d_purchasing.d_pcs_id','=','d_purchasingreturn.d_pcsr_pcsid')
            ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
            ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
            ->select('d_pcs_date_created',
                     'd_pcs_id', 'd_pcsp_id',
                     'd_pcs_code','s_company',
                     'd_pcs_method',
                     'd_pcs_total_net',
                     'd_pcs_date_received',
                     'd_pcs_status',
                     'd_pcsr_code',
                     'd_pcsr_method',
                     'd_mem.m_id',
                     'd_mem.m_name'
                    )
            ->where('d_purchasing.d_pcs_status','=', 'RV')
            ->where('d_purchasingreturn.d_pcsr_method','=', 'PN')
            ->whereBetween('d_purchasing.d_pcs_date_created', [$tanggal1, $tanggal2])
            ->orderBy('d_pcs_date_created', 'DESC')
            ->get();

      return DataTables::of($data)
      ->addIndexColumn()
      ->editColumn('status', function ($data)
        {
        if ($data->d_pcs_status == "RC") 
        {
          return '<span class="label label-default">Diterima</span>';
        }
        elseif ($data->d_pcs_status == "RV") 
        {
          return '<span class="label label-warning">Revisi</span>';
        }
      })
      ->editColumn('tglBuat', function ($data) 
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
      ->editColumn('tglTerima', function ($data) 
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
      ->editColumn('hargaTotalNet', function ($data) 
      {
        return 'Rp. '.number_format($data->d_pcs_total_net,0,",",".");
      })
      ->addColumn('action', function($data)
      {
        if ($data->d_pcs_status == "RV") 
        {
          return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailPoRev("'.$data->d_pcs_id.'")><i class="fa fa-eye"></i> 
                    </button>
                  </div>'; 
        }
        elseif ($data->d_pcs_status == "RC") 
        {
          return '<div class="text-center">
                    <button class="btn btn-sm btn-success" title="Detail"
                        onclick=detailPoRev("'.$data->d_pcs_id.'") disabled><i class="fa fa-eye"></i> 
                    </button>
                  </div>'; 
        } 
      })
      ->rawColumns(['status', 'action'])
      ->make(true);
  }

  public function tambahReturn()
  {
    //code order
    $query = DB::select(DB::raw("SELECT MAX(RIGHT(d_pcsr_code,5)) as kode_max from d_purchasingreturn WHERE DATE_FORMAT(d_pcsr_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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

    $codeRP = "RTR-".date('ym')."-".$kd;
    $staff['nama'] = Auth::user()->m_name;
    $staff['id'] = Auth::User()->m_id;
    return view ('Purchase::returnpembelian/tambah-return',compact('codeRP', 'staff'));
  }

   public function lookupDataPembelian(Request $request)
   {
      $comp = Session::get('user_comp');
      $formatted_tags = array();
      $term = trim($request->q);
      if (empty($term)) {
         $sup = DB::table('d_purchasing')
            ->where('p_pcs_comp',$comp)
            ->where('d_pcs_status','=','RC')
            ->orderBy('d_pcs_code', 'DESC')
            ->limit(5)
            ->get();
         foreach ($sup as $val) 
         {
             $formatted_tags[] = ['id' => $val->d_pcs_id, 'text' => $val->d_pcs_code];
         }
         return Response::json($formatted_tags);
      }
      else
      {
         $sup = DB::table('d_purchasing')->where('d_pcs_status','=','RC')
            ->where('p_pcs_comp',$comp)
            ->orderBy('d_pcs_code', 'DESC')
            ->where('d_pcs_code', 'LIKE', '%'.$term.'%')
            ->limit(5)
            ->get();
         foreach ($sup as $val) 
         {
             $formatted_tags[] = ['id' => $val->d_pcs_id, 'text' => $val->d_pcs_code];
         }

         return Response::json($formatted_tags);  
      }
   }

  public function getDataForm($id)
  {
    $dataHeader = DB::table('d_purchasing')
                    ->select('d_purchasing.*', 'm_supplier.s_company', 'm_supplier.s_name', 'm_supplier.s_id')
                    ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
                    ->where('d_pcs_id', '=', $id)
                    ->get();

    $dataIsi = DB::table('d_purchasing_dt')
                  ->select('d_purchasing_dt.*', 'm_item.i_name', 'm_item.i_code', 'm_item.i_sat1', 'm_item.i_id', 'm_satuan.s_name', 'm_satuan.s_id')
                  ->leftJoin('m_item','d_purchasing_dt.i_id','=','m_item.i_id')
                  ->leftJoin('m_satuan','d_purchasing_dt.d_pcsdt_sat','=','m_satuan.s_id')
                  ->where('d_purchasing_dt.d_pcs_id', '=', $id)
                  // ->where('d_purchasing_dt.d_pcsdt_isconfirm', '=', "TRUE")
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
    ]);
  }

  public function simpanDataReturn(Request $request)
  {
    // dd($request->all());
    DB::beginTransaction();
    try {      
      //insert to table d_purchasingreturn
      $dataHeader = new d_purchasingreturn;
      $dataHeader->d_pcsr_comp = Session::get('user_comp');
      $dataHeader->d_pcsr_pcsid = $request->cariNotaPurchase;
      $dataHeader->d_pcsr_supid = $request->idSup;
      $dataHeader->d_pcsr_code = $request->kodeReturn;
      $dataHeader->d_pcsr_method = $request->metodeReturn;
      $dataHeader->d_pcs_staff = $request->idStaff;
      $dataHeader->d_pcsr_datecreated = date('Y-m-d',strtotime($request->tanggal));
      $dataHeader->d_pcsr_pricetotal = $request->nilaiTotalReturnRaw;
      if ($request->metodeReturn == "PN") 
      {
        $dataHeader->d_pcsr_priceresult = $this->konvertRp($request->nilaiTotalNett) - $request->nilaiTotalReturnRaw;
      }
      elseif ($request->metodeReturn == "TK")
      {
        $dataHeader->d_pcsr_priceresult = $this->konvertRp($request->nilaiTotalNett);
      }
      $dataHeader->save();
      
      //get last lastId then insert id to d_purchasingreturn_dt
      $lastId = d_purchasingreturn::select('d_pcsr_id')->max('d_pcsr_id');
      if ($lastId == 0 || $lastId == '') 
      {
        $lastId  = 1;
      }  

      //variabel untuk hitung array field
      $hitung_field = count($request->fieldItemId);

      //update d_stock, insert d_stock_mutation & insert d_purchasingreturn_dt
      for ($i=0; $i < $hitung_field; $i++) 
      {
        //variabel u/ cek primary satuan
        $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldItemId[$i])->first();
        
        //cek satuan primary, convert ke primary apabila beda satuan
        if ($primary_sat->i_sat1 == $request->fieldSatuanId[$i]) 
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi1;
        }
        elseif ($primary_sat->i_sat2 == $request->fieldSatuanId[$i])
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi2;
        }
        else
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi3;
        }

        $grup = $this->getGroupGudang($request->fieldItemId[$i]);
        //get id d_stock
        $dstock_id = DB::table('d_stock')
          ->select('s_id')
          ->where('s_item', $request->fieldItemId[$i])
          ->where('s_comp', $grup)
          ->where('s_position', $grup)
          ->first();

        if(mutasi::mutasiStok(
            $request->fieldItemId[$i], //item id
            $hasilConvert, //qty hasil convert satuan terpilih -> satuan primary 
            $comp = $grup, //posisi gudang berdasarkan type item
            $position = $grup, //posisi gudang berdasarkan type item
            $flag='MENGURANGI',
            $request->kodeReturn,
            'MENGURANGI',
            Carbon::now(),
            18 //sm mutcat
         
        )) {}

        //insert d_purchasingreturn_dt
        $dataIsi = new d_purchasingreturn_dt;
        $dataIsi->d_pcsrdt_idpcsr = $lastId;
        $dataIsi->d_pcsrdt_item = $request->fieldItemId[$i];
        $dataIsi->d_pcsrdt_sat = $request->fieldSatuanId[$i];
        $dataIsi->d_pcsrdt_qty = $request->fieldQty[$i];
        $dataIsi->d_pcsrdt_price = $request->fieldHargaRaw[$i];
        $dataIsi->d_pcsrdt_pricetotal = $request->fieldHargaTotalRaw[$i];
        $dataIsi->d_pcsrdt_created = Carbon::now();
        $dataIsi->save();
      }//end loop for

      //update status po RC -> RV (Revisied) dan update tanggal buat
      DB::table('d_purchasing')
              ->where('d_pcs_id', $request->cariNotaPurchase)
              ->update([
                'd_pcs_status' => 'RV',
                'd_pcs_date_created' => date('Y-m-d',strtotime(Carbon::now()))
              ]);

      $pcs = DB::table('d_purchasing')
              ->where('d_pcs_id', $request->cariNotaPurchase)
              ->select('d_pcs_code')->first();

      DB::commit();

    } 
    catch (\Exception $e) 
    {
      DB::rollback();
      return response()->json([
          'status' => 'gagal',
          'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
      ]);
    }
    return response()->json([
        'status' => 'sukses',
        'pesan' => 'Data Return Pembelian Berhasil Disimpan'
    ]);
  }

  public function updateDataReturn(Request $request)
  {
    // dd($request->all());
    DB::beginTransaction();
    try {
      //update to table d_purchasingreturn
      $data_header = d_purchasingreturn::find($request->idReturn);
      $data_header->d_pcsr_dateupdated = date('Y-m-d',strtotime(Carbon::now()));
      $data_header->d_pcsr_updated = Carbon::now();
      $data_header->d_pcsr_pricetotal = $request->priceTotalRaw;
      if ($request->methodReturn == "PN") 
      {
        $data_header->d_pcsr_priceresult = $request->priceTotalNett - $request->priceTotalRaw;
      }
      else
      {
        $data_header->d_pcsr_priceresult = $request->priceTotalNett;
      }
      $data_header->save();

      //variabel untuk cek jumlah field
      $hitung_field_edit = count($request->fieldIdItem);
      for ($i=0; $i < $hitung_field_edit; $i++) 
      {
        //variabel u/ cek primary satuan
        $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldIdItem[$i])->first();        
        //konversi stok setelah update
        if ($primary_sat->i_sat1 == $request->fieldSatuanId[$i]) 
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi1;
          $hasilConvertLalu = (int)$request->fieldQtyLalu[$i] * (int)$primary_sat->i_sat_isi1;
          $hasilSelisih = $hasilConvert - $hasilConvertLalu;
        }
        elseif ($primary_sat->i_sat2 == $request->fieldSatuanId[$i])
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi2;
          $hasilConvertLalu = (int)$request->fieldQtyLalu[$i] * (int)$primary_sat->i_sat_isi2;
          $hasilSelisih = $hasilConvert - $hasilConvertLalu;
        }
        else
        {
          $hasilConvert = (int)$request->fieldQty[$i] * (int)$primary_sat->i_sat_isi3;
          $hasilConvertLalu = (int)$request->fieldQtyLalu[$i] * (int)$primary_sat->i_sat_isi3;
          $hasilSelisih = $hasilConvert - $hasilConvertLalu;
        }

        $grup = $this->getGroupGudang($request->fieldIdItem[$i]);
        //update d_stock
        if(mutasi::updateMutasi(
          $request->fieldIdItem[$i], //item id
          $hasilSelisih, //qty hasil convert satuan terpilih -> satuan primary 
          $comp = $grup, //posisi gudang berdasarkan type item
          $position = $grup, //posisi gudang berdasarkan type item
          $flag='MENGURANGI',
          $request->codeReturn,
          'MENGURANGI',
          Carbon::now(),
          18 //sm mutcat
        )) {}

        //update to table d_purchasingreturn_dt
        $data_isi = d_purchasingreturn_dt::find($request->fieldIdDt[$i]);
        $data_isi->d_pcsrdt_qty = $request->fieldQty[$i];
        $data_isi->d_pcsrdt_price = $request->fieldHargaRaw[$i];
        $data_isi->d_pcsrdt_pricetotal = $request->fieldHargaTotalRaw[$i];
        $data_isi->d_pcsrdt_updated = Carbon::now();
        $data_isi->save();
      } 
      
    DB::commit();
    } 
    catch (\Exception $e) 
    {
      DB::rollback();
      return response()->json([
          'status' => 'gagal',
          'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
      ]);
    }
    return response()->json([
          'status' => 'sukses',
          'pesan' => 'Data Retur Pembelian Berhasil Diupdate'
      ]);
  }

  public function getDetailRevisi($id)
  {
      $dataHeader = d_purchasing::join('d_purchasingreturn','d_purchasing.d_pcs_id','=','d_purchasingreturn.d_pcsr_pcsid')
              ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
              ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
              ->select('d_purchasing.*',
                       'd_purchasingreturn.d_pcsr_id',
                       'd_purchasingreturn.d_pcsr_code',
                       'd_purchasingreturn.d_pcsr_pricetotal',
                       'd_purchasingreturn.d_pcsr_priceresult',
                       'm_supplier.s_company',
                       'm_supplier.s_name',
                       'd_mem.m_id',
                       'd_mem.m_name'
                     )
              ->where('d_pcs_id', '=', $id)
              ->orderBy('d_pcs_date_created', 'DESC')
              ->get();

      $datareturdt = DB::table('d_purchasingreturn_dt')
      ->join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
      ->select('d_purchasingreturn_dt.*',
               'd_purchasingreturn.*',
               'd_purchasingreturn_dt.d_pcsrdt_item as item',
               DB::raw('(SELECT d_pcsdt_price FROM d_purchasing_dt WHERE d_pcs_id = "'.$id.'" AND i_id = item) as harganondiskon'))
      ->where('d_pcsrdt_idpcsr', $dataHeader[0]->d_pcsr_id)->get();
      $hargaTotRetur = 0;
      for ($i=0; $i <count($datareturdt); $i++) 
      { 
        $hargaTotRetur += (int)$datareturdt[$i]->d_pcsrdt_qtyconfirm * $datareturdt[$i]->harganondiskon;
      }

      $statusLabel = $dataHeader[0]->d_pcs_status;
      if ($statusLabel == "WT") 
      {
        $spanTxt = 'Waiting';
        $spanClass = 'label-default';
      }
      elseif ($statusLabel == "DE")
      {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
      }
      elseif ($statusLabel == "CF")
      {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-info';
      }
      else if ($statusLabel == "RC") 
      {
        $spanTxt = 'Barang telah diterima';
        $spanClass = 'label-success';
      }
      else 
      {
        $spanTxt = 'PO revisi';
        $spanClass = 'label-warning';
      }

      foreach ($dataHeader as $val) 
      {
        $data = array(
            'hargaBruto' => number_format($val->d_pcs_total_gross - $hargaTotRetur,2,",","."),
            'nilaiDiskon' => number_format((($val->d_pcs_total_gross - $hargaTotRetur) * $val->d_pcs_disc_percent / 100) + $val->d_pcs_discount ,2,",","."),
            'nilaiPajak' => number_format($val->d_pcs_tax_value,2,",","."),
            'hargaNet' => number_format(($val->d_pcs_total_gross - $hargaTotRetur) - ((($val->d_pcs_total_gross - $hargaTotRetur) * $val->d_pcs_disc_percent / 100) + $val->d_pcs_discount) + $val->d_pcs_tax_value,2,",","."),
        );
      }

      $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
              ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.s_id')
              ->select('d_purchasing_dt.d_pcsdt_id',
                       'd_purchasing_dt.d_pcs_id',
                       'd_purchasing_dt.i_id',
                       'm_item.i_name',
                       'm_item.i_code',
                       'm_item.i_sat1',
                       'm_satuan.s_name',
                       'm_satuan.s_id',
                       'd_purchasing_dt.d_pcsdt_prevcost',
                       'd_purchasing_dt.d_pcsdt_qty',
                       'd_purchasing_dt.d_pcsdt_price',
                       'd_purchasing_dt.d_pcsdt_total'
              )
              ->where('d_purchasing_dt.d_pcs_id', '=', $id)
              ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
              ->get();

      //dd($datareturdt, $dataIsi);
      foreach ($dataIsi as $key => $val)
      {
          //cek item type
          $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $val->i_id)->first();
          //get satuan utama
          $sat1[] = $val->i_sat1;
          //compare dengan data returdt, jika sama replace qty
          for ($i=0; $i <count($datareturdt); $i++) { 
            if ($val->i_id == $datareturdt[$i]->d_pcsrdt_item) {
              $dataIsi[$key]->d_pcsdt_qty = $val->d_pcsdt_qty - $datareturdt[$i]->d_pcsrdt_qtyconfirm;
            }
          }
      }

      //variabel untuk count array
      $counter = 0;
      //ambil value stok by item type
      $dataStok = $this->getStokByType($itemType, $sat1, $counter);
      
      return response()->json([
          'status' => 'sukses',
          'header' => $dataHeader,
          'header2' => $data,
          'data_isi' => $dataIsi,
          'data_stok' => $dataStok['val_stok'],
          'data_satuan' => $dataStok['txt_satuan'],
          'spanTxt' => $spanTxt,
          'spanClass' => $spanClass,
          // 'qtyRev' => $qtyRev
      ]);
  }

  public function ubahStatusPo(Request $request, $id)
  {
    //dd($request->all());
    DB::beginTransaction();
    try 
    {   
        $tanggal = Carbon::now('Asia/Jakarta');
        //update d_purchasing
        $tblHeader = d_purchasing::find($id);
        $tblHeader->d_pcs_total_gross = str_replace('.', '', $request->totalHarga);
        $tblHeader->d_pcs_disc_value = str_replace('.', '', $request->diskonHarga);
        $tblHeader->d_pcs_total_net = str_replace('.', '', $request->totalHargaFinal);
        $tblHeader->d_pcs_sisapayment = str_replace('.', '', $request->totalHargaFinal);
        $tblHeader->d_pcs_status = 'RC';
        $tblHeader->d_pcs_updated = $tanggal;
        $tblHeader->save();

        //update d_purchasing_dt
        for ($i=0; $i <count($request->ip_item); $i++) {
          $item = $request->ip_item[$i];
          $tblDetail = d_purchasing_dt::where(function ($query) use ($id, $item) {
                          $query->where('d_pcs_id', '=', $id);
                          $query->where('i_id', '=', $item);
                        })->first();
          $tblDetail->i_id = $item;
          $tblDetail->d_pcsdt_sat = $request->ip_sid[$i];
          $tblDetail->d_pcsdt_qty = $request->ip_qty[$i];
          $tblDetail->d_pcsdt_qtyconfirm = $request->ip_qty[$i];
          $tblDetail->d_pcsdt_prevcost = $request->ip_prevcost[$i];
          $tblDetail->d_pcsdt_price = $request->ip_price[$i];
          $tblDetail->d_pcsdt_total = $request->ip_total[$i];
          $tblDetail->d_pcsdt_updated = $tanggal;
          $update = $tblDetail->save();
        }

        if ($update) 
        {
          $pesan = 'PO Berhasil direvisi';
        }else{
          $pesan = 'PO gagal direvisi';
        }

        DB::commit();
        return response()->json([
          'status' => 'sukses',
          'pesan' => $pesan
        ]);          
    }
    catch (\Exception $e) 
    {
      DB::rollback();
      return response()->json([
          'status' => 'gagal',
          'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
      ]);
    }
  }

  public function deleteDataReturn(Request $request)
  {
    // dd($request->all());
    DB::beginTransaction();
    try {
      //ambil code d_purchasingreturn
      $code_retur = d_purchasingreturn::select('d_pcsr_code','d_pcsr_pcsid')->where('d_pcsr_id', $request->id)->first();
      //ambil data pakai d_stock_mutation 
      $data_sm = DB::table('d_stock_mutation')->where('sm_reff', $code_retur->d_pcsr_code)->orderBy('sm_stock','ASC')
                  ->orderBy('sm_detailid','ASC')->get();
      // return json_encode($code_retur);
      foreach ($data_sm as $value) 
      {
        //array variabel u/ simpan data stok mutasi
        $sm_stock[] = $value->sm_stock;
        $sm_detailid[] = $value->sm_detailid;
        $sm_item[] = $value->sm_item;
        $sm_qty[] = $value->sm_qty;
        $sm_hpp[] = $value->sm_hpp;
        $sm_comp[] = $value->sm_comp;
        $sm_pos[] = $value->sm_position;
      }

      for ($i=0; $i < count($sm_stock); $i++) 
      { 
        //cari id & s_qty d_stock
        $q_dstock = DB::table('d_stock')
                    ->select('s_id', 's_qty')
                    ->where('s_item', $sm_item[$i])
                    ->where('s_comp', $sm_comp[$i])
                    ->where('s_position', $sm_pos[$i])
                    ->first();

        //kembalikan stok sebelum retur
        $stokAkhir = abs($sm_qty[$i]) + (int)$q_dstock->s_qty;
        // update d_stock
        DB::table('d_stock')
          ->where('s_id', $sm_stock[$i])
          ->update(['s_qty' => $stokAkhir]);

        //ambil data penerimaan d_stock_mutation 
        $data_sm_masuk = d_stock_mutation::where('sm_qty_used','>',0)
                            ->where('sm_stock', $sm_stock[$i])
                            ->where('sm_item', $sm_item[$i])
                            ->where('sm_comp', $sm_comp[$i])
                            ->where('sm_position', $sm_pos[$i])
                            ->where('sm_hpp', $sm_hpp[$i])
                            ->orderBy('sm_stock','ASC')
                            ->orderBy('sm_detailid','ASC')
                            ->get();

        $qtyPakai = abs($sm_qty[$i]);
        for ($j=0; $j <count($data_sm_masuk); $j++) 
        { 
          if ($qtyPakai <= $data_sm_masuk[$j]->sm_qty_used) 
          {
            $qty_awal = (int)$data_sm_masuk[$j]->sm_qty_used - (int)$qtyPakai;
            $qty_sisa = (int)$data_sm_masuk[$j]->sm_qty_sisa + (int)$qtyPakai;
            // update d_stock_mutation
            DB::table('d_stock_mutation')
              ->where('sm_stock', '=', $data_sm_masuk[$j]->sm_stock)
              ->where('sm_detailid', $data_sm_masuk[$j]->sm_detailid)
              ->update(array(
                  'sm_qty_used' => $qty_awal,
                  'sm_qty_sisa' => $qty_sisa
              ));
            $j = count($data_sm_masuk);
          }
          elseif ($qtyPakai > $data_sm_masuk[$j]->sm_qty_used)
          {
            $selisih = (int)$qtyPakai - (int)$data_sm_masuk[$j]->sm_qty_used;
            $qty_awal = (int)$data_sm_masuk[$j]->sm_qty_used - ((int)$qtyPakai - (int)$selisih);
            $qty_sisa = (int)$data_sm_masuk[$j]->sm_qty_sisa + ((int)$qtyPakai - (int)$selisih);
            $qtyPakai = $selisih;
            // update d_stock_mutation
            DB::table('d_stock_mutation')
              ->where('sm_stock', '=', $data_sm_masuk[$j]->sm_stock)
              ->where('sm_detailid', $data_sm_masuk[$j]->sm_detailid)
              ->update(array(
                  'sm_qty_used' => $qty_awal,
                  'sm_qty_sisa' => $qty_sisa
              ));
          }
        }

        //delete row table d_stock_mutation
        DB::table('d_stock_mutation')
          ->where('sm_stock', '=', $sm_stock[$i])
          ->where('sm_detailid', '=', $sm_detailid[$i])
          ->delete();
      }

      //get id purchase and update status po RV -> RC (Received)
      $idPurchase = d_purchasingreturn::select('d_pcsr_pcsid')->where('d_pcsr_id', $request->id)->first();
      DB::table('d_purchasing')->where('d_pcs_id', $idPurchase->d_pcsr_pcsid)->update(['d_pcs_status' => 'RC']);
      //delete row table d_purchasingreturn_dt
      $deleteReturnDt = d_purchasingreturn_dt::where('d_pcsrdt_idpcsr', $request->id)->delete();
      //delete row table d_purchasingreturn
      $deleteReturn = d_purchasingreturn::where('d_pcsr_id', $request->id)->delete();
    
      DB::commit();
      return response()->json([
          'status' => 'sukses',
          'pesan' => 'Data Retur Pembelian Berhasil Dihapus'
      ]);
    } 
    catch (\Exception $e) 
    {
      DB::rollback();
      return response()->json([
          'status' => 'gagal',
          'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
      ]);
    }
  }

  public function konvertRp($value)
  {
    $value = str_replace(['Rp', '\\', '.', ' '], '', $value);
    return (int)str_replace(',', '.', $value);
  }

  public function getGroupGudang($id_item)
  {
    $typeBrg = DB::table('m_item')->select('i_type')->where('i_id','=', $id_item)->first();
    if ($typeBrg->i_type == "BB") 
    {
      $cabang=Session::get('user_comp');                
      $dataGudang = DB::table('d_gudangcabang')
                    ->where('gc_comp',$cabang)
                    ->where('gc_gudang','GUDANG BAHAN BAKU')
                    ->select('gc_id','gc_gudang')
                    ->first();
      $idGroupGdg = $dataGudang->gc_id;
    } 
    elseif ($typeBrg->i_type == "BJ") 
    {
      $cabang=Session::get('user_comp');                
      $dataGudang = DB::table('d_gudangcabang')
                    ->where('gc_comp',$cabang)
                    ->where('gc_gudang','GUDANG PENJUALAN')
                    ->select('gc_id','gc_gudang')
                    ->first();
      $idGroupGdg = $dataGudang->gc_id;
    }
    return $idGroupGdg;
  }

  public function getStokByType($arrItemType, $arrSatuan, $counter, $comp)
   {
      // return "klk";
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
            // return 'okee';
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

  public function printRevisiPo($id)
  {
    $dataHeader = d_purchasing::join('d_purchasingreturn','d_purchasing.d_pcs_id','=','d_purchasingreturn.d_pcsr_pcsid')
              ->join('m_supplier','d_purchasing.s_id','=','m_supplier.s_id')
              ->join('d_mem','d_purchasing.d_pcs_staff','=','d_mem.m_id')
              ->select('d_purchasing.*',
                       'd_purchasingreturn.d_pcsr_id',
                       'd_purchasingreturn.d_pcsr_code',
                       'd_purchasingreturn.d_pcsr_pricetotal',
                       'd_purchasingreturn.d_pcsr_priceresult',
                       'm_supplier.s_company',
                       'm_supplier.s_name',
                       'd_mem.m_id',
                       'd_mem.m_name'
                     )
              ->where('d_pcs_id', '=', $id)
              ->orderBy('d_pcs_date_created', 'DESC')
              ->get()->toArray();
  
    $datareturdt = DB::table('d_purchasingreturn_dt')
                    ->join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
                    ->select('d_purchasingreturn_dt.*',
                             'd_purchasingreturn.*',
                             'd_purchasingreturn_dt.d_pcsrdt_item as item',
                             DB::raw('(SELECT d_pcsdt_price FROM d_purchasing_dt WHERE d_pcs_id = "'.$id.'" AND i_id = item) as harganondiskon'))
                    ->where('d_pcsrdt_idpcsr', $dataHeader[0]['d_pcsr_id'])->get()->toArray();

    $hargaTotRetur = 0;
    for ($i=0; $i <count($datareturdt); $i++) 
    { 
      $hargaTotRetur += (int)$datareturdt[$i]->d_pcsrdt_qtyconfirm * $datareturdt[$i]->harganondiskon;
    }

    for ($i=0; $i <count($dataHeader); $i++) { 
      $data = array(
          'hargaBruto' => 'Rp. '.number_format($dataHeader[$i]['d_pcs_total_gross'] - $hargaTotRetur,2,",","."),
          'nilaiDiskon' => 'Rp. '.number_format((($dataHeader[$i]['d_pcs_total_gross'] - $hargaTotRetur) * $dataHeader[$i]['d_pcs_disc_percent'] / 100) + $dataHeader[$i]['d_pcs_discount'] ,2,",","."),
          'nilaiPajak' => 'Rp. '.number_format($dataHeader[$i]['d_pcs_tax_value'],2,",","."),
          'hargaNet' => 'Rp. '.number_format(($dataHeader[$i]['d_pcs_total_gross'] - $hargaTotRetur) - ((($dataHeader[$i]['d_pcs_total_gross'] - $hargaTotRetur) * $dataHeader[$i]['d_pcs_disc_percent'] / 100) + $dataHeader[$i]['d_pcs_discount']) + $dataHeader[$i]['d_pcs_tax_value'],2,",","."),
      );
    }

    $dataIsi = d_purchasing_dt::join('m_item', 'd_purchasing_dt.i_id', '=', 'm_item.i_id')
              ->join('m_satuan', 'd_purchasing_dt.d_pcsdt_sat', '=', 'm_satuan.s_id')
              ->select('d_purchasing_dt.d_pcsdt_id',
                       'd_purchasing_dt.d_pcs_id',
                       'd_purchasing_dt.i_id',
                       'm_item.i_name',
                       'm_item.i_code',
                       'm_item.i_sat1',
                       'm_satuan.s_name',
                       'm_satuan.s_id',
                       'd_purchasing_dt.d_pcsdt_prevcost',
                       'd_purchasing_dt.d_pcsdt_qty',
                       'd_purchasing_dt.d_pcsdt_price',
                       'd_purchasing_dt.d_pcsdt_total'
              )
              ->where('d_purchasing_dt.d_pcs_id', '=', $id)
              ->orderBy('d_purchasing_dt.d_pcsdt_created', 'DESC')
              ->get()->toArray();
    
    for ($i=0; $i < count($dataIsi); $i++) { 
      //cek item type
      $itemType[] = DB::table('m_item')->select('i_type', 'i_id')->where('i_id','=', $dataIsi[$i]['i_id'])->first();
      //get satuan utama
      $sat1[] = $dataIsi[$i]['i_sat1'];
      //compare dengan data returdt, jika sama replace qty
      for ($j=0; $j <count($datareturdt); $j++) { 
        if ($dataIsi[$i]['i_id'] == $datareturdt[$j]->d_pcsrdt_item) {
          $dataIsi[$j]['d_pcsdt_qty'] = $dataIsi[$i]['d_pcsdt_qty'] - $datareturdt[$j]->d_pcsrdt_qtyconfirm;
        }
      }
    }

    //variabel untuk count array
    $counter = 0;
    //ambil value stok by item type
    $dataStok = $this->getStokByType($itemType, $sat1, $counter);
    $dataStokQty = array_chunk($dataStok['val_stok'], 10);
    $dataStokTxt = array_chunk($dataStok['txt_satuan'], 10);
    $dataIsi = array_chunk($dataIsi, 10);

    //dd($dataHeader, $dataIsi, $dataStokQty, $dataStokTxt, $data);

    return view('purchasing/returnpembelian/print-revisi-po', compact('dataHeader', 'dataIsi', 'dataStokQty', 'dataStokTxt', 'data'));
  }

  public function printSuratJalan($id)
  {
    $dataHeader = d_purchasingreturn::join('d_purchasing','d_purchasingreturn.d_pcsr_pcsid','=','d_purchasing.d_pcs_id')
          ->join('m_supplier','d_purchasingreturn.d_pcsr_supid','=','m_supplier.s_id')
          ->join('d_mem', 'd_purchasingreturn.d_pcs_staff', '=', 'd_mem.m_id')
          ->select('d_purchasingreturn.*', 'm_supplier.s_id', 'm_supplier.s_company', 'd_purchasing.d_pcs_id', 'd_purchasing.d_pcs_total_net', 'd_purchasing.d_pcs_code', 'd_mem.m_name', 'd_mem.m_id')
          ->where('d_purchasingreturn.d_pcsr_id', '=', $id)
          ->orderBy('d_pcsr_created', 'DESC')
          ->get()->toArray();
  
    foreach ($dataHeader as $val) 
    {
      $data = array(
        'hargaTotalReturn' => 'Rp. '.number_format($val['d_pcsr_pricetotal'],2,",","."),
        'hargaTotalResult' => 'Rp. '.number_format($val['d_pcsr_priceresult'],2,",","."),
        'tanggalReturn' => date('d-m-Y',strtotime($val['d_pcsr_datecreated']))
      );
    }
    
    $dataIsi = d_purchasingreturn_dt::join('d_purchasingreturn', 'd_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', 'd_purchasingreturn.d_pcsr_id')
            ->join('m_item', 'd_purchasingreturn_dt.d_pcsrdt_item', '=', 'm_item.i_id')
            ->join('m_satuan', 'd_purchasingreturn_dt.d_pcsrdt_sat', '=', 'm_satuan.s_id')
            ->select('d_purchasingreturn_dt.*', 'm_item.*', 'd_purchasingreturn.d_pcsr_code', 'm_satuan.s_id', 'm_satuan.s_name')
            ->where('d_purchasingreturn_dt.d_pcsrdt_idpcsr', '=', $id)
            ->orderBy('d_purchasingreturn_dt.d_pcsrdt_created', 'DESC')
            ->get()->toArray();
    $dataIsi = array_chunk($dataIsi, 10);

    //dd($dataHeader, $dataIsi, $data);

    return view('Purchase::returnpembelian/print-sj-retur', compact('dataHeader', 'dataIsi', 'data'));
  }

}
