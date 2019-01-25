<?php

namespace App\Modules\Inventory\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\d_stock;
use Datatables;
use App\d_pakai_barang;
use App\d_pakai_barangdt;
use App\d_gudangcabang;
use Carbon\Carbon;
use Response;

class PemakaianBrgGdgController extends Controller
{
    public function barang()
    {
    	$tabIndex = view('Inventory::b_digunakan.tab-index');
    	$tabHistory = view('Inventory::b_digunakan.tab-history');
    	$comp = Session::get('user_comp');
    	$gudang = d_gudangcabang::where('gc_comp',$comp)
            ->where(function ($query) {
                $query->where('gc_gudang','GUDANG PENJUALAN')
                      ->orWhere('gc_gudang','GUDANG PRODUKSI');
            })
            ->get();
    	$modal = view('Inventory::b_digunakan.modal',compact('gudang'));
    	$modalDetail = view('Inventory::b_digunakan.modal-detail');
    	$modalEdit = view('Inventory::b_digunakan.modal-edit');
        return view('Inventory::b_digunakan.index',compact('tabIndex','tabHistory','modal','modalDetail','modalEdit'));
    }

    public function getPemakaianByTgl($tgl1, $tgl2, $comp)
    {
        $y = substr($tgl1, -4);
        $m = substr($tgl1, -7,-5);
        $d = substr($tgl1,0,2);
        $tanggal1 = $y.'-'.$m.'-'.$d;

        $y2 = substr($tgl2, -4);
        $m2 = substr($tgl2, -7,-5);
        $d2 = substr($tgl2,0,2);
        $tanggal2 = $y2.'-'.$m2.'-'.$d2;

        $data = d_pakai_barang::join('d_gudangcabang','d_pakai_barang.d_pb_gdg','=','d_gudangcabang.gc_id')
              ->whereBetween('d_pb_date', [$tanggal1, $tanggal2])
              ->orderBy('d_pb_created', 'DESC')
              ->where('d_pb_comp',$comp)
              ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('tglBuat', function ($data) 
        {
            if ($data->d_pb_date == null) 
            {
                return '-';
            }
            else 
            {
                return $data->d_pb_date ? with(new Carbon($data->d_pb_date))->format('d M Y') : '';
            }
        })
        ->addColumn('action', function($data)
        {
            return '<div class="text-center">
                        <button class="btn btn-sm btn-success" title="Detail"
                            onclick=detailPemakaian("'.$data->d_pb_id.'")><i class="fa fa-eye"></i> 
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit"
                            onclick=editPemakaian("'.$data->d_pb_id.'")><i class="glyphicon glyphicon-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete"
                            onclick=deletePemakaian("'.$data->d_pb_id.'")><i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>'; 
        })
        ->rawColumns(['status', 'action'])
        ->make(true);
    }

    public function autocompleteBarang(Request $request)
    {
        // dd($request->all());
        $term = $request->term;
        $id_gdg = $request->id_gudang;
        $results = array();
        $queries = DB::table('m_item')
            ->join('d_stock', 'm_item.i_id', '=', 'd_stock.s_item')
            ->select('m_item.i_id',
                     'm_item.i_type',
                     'm_item.i_sat1',
                     'm_item.i_sat2',
                     'm_item.i_sat3',
                     'm_item.i_code',
                     'm_item.i_name',
                     'd_stock.s_id',
                     'd_stock.s_qty',
                     'd_stock.s_position',
                     'd_stock.s_comp')
            ->where('i_name', 'LIKE', '%'.$term.'%')
            ->where('d_stock.s_comp', '=', $id_gdg)
            ->where('d_stock.s_position', '=', $id_gdg)
            ->take(25)->get();
        // dd($queries);
        if ($queries == null) 
        {
            $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
        } 
        else 
        {
            foreach ($queries as $val) 
            {
                //get data txt satuan
                $txtSat1 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat1)->first();
                $txtSat2 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat2)->first();
                $txtSat3 = DB::table('m_satuan')->select('s_name', 's_id')->where('s_id','=', $val->i_sat3)->first();

                $results[] = [  'id' => $val->i_id,
                                'label' => $val->i_code .'  '.$val->i_name,
                                'stok' => (int)$val->s_qty,
                                'sat' => [$val->i_sat1, $val->i_sat2, $val->i_sat3],
                                'satTxt' => [$txtSat1->s_name, $txtSat2->s_name, $txtSat3->s_name],
                                's_comp' => $val->s_comp,
                                's_pos' => $val->s_position,
                            ];
            }
        }

      return Response::json($results);
    }

    public function simpanDataPakai(Request $request)
    {
        dd($request->all());
        DB::beginTransaction();
        try 
        {
            $kode = $this->kodePemakaianAuto();
            //insert to table d_pakai_barang
            $dataHeader = new d_pakai_barang;
            $dataHeader->d_pb_code = $kode;
            $dataHeader->d_pb_date = date('Y-m-d',strtotime($request->headTglPakai));
            $dataHeader->d_pb_peminta = strtoupper($request->headPeminta);
            $dataHeader->d_pb_keperluan = strtoupper($request->headKeperluan);
            $dataHeader->d_pb_staff = $request->headStaffId;
            $dataHeader->d_pb_gdg = $request->headGudang;
            $dataHeader->d_pb_created = Carbon::now();
            $dataHeader->save();

            //get last lastId header
            $lastId = d_pakai_barang::select('d_pb_id')->max('d_pb_id');
            if ($lastId == 0 || $lastId == '') { $lastId  = 1; } 

            for ($i=0; $i < count($request->fieldIpItem); $i++) 
            { 
                //cari harga satuan n total dari d_stock mutation
                $data_sm =  d_stock_mutation::where('sm_item',$request->fieldIpItem[$i])
                                      ->where('sm_comp',$request->fieldIpScomp[$i])
                                      ->where('sm_position',$request->fieldIpSpos[$i])
                                      ->where('sm_qty_sisa', '>', 0)
                                      ->orderBy('sm_item','ASC')
                                      ->orderBy('sm_detailid','ASC')
                                      ->get();
                //variabel u/ cek primary satuan
                $primary_sat = DB::table('m_item')->select('m_item.*')->where('i_id', $request->fieldIpItem[$i])->first();
            
                //cek satuan primary, convert ke primary apabila beda satuan
                if ($primary_sat->i_sat1 == $request->fieldIpSatId[$i]) 
                {
                    $hasilConvert = (int)$request->fieldIpQty[$i] * (int)$primary_sat->i_sat_isi1;
                    $isiQty = $primary_sat->i_sat_isi1;
                    $flagMasterHarga = 1;
                }
                elseif ($primary_sat->i_sat2 == $request->fieldIpSatId[$i])
                {
                    $hasilConvert = (int)$request->fieldIpQty[$i] * (int)$primary_sat->i_sat_isi2;
                    $isiQty = $primary_sat->i_sat_isi2;
                    $flagMasterHarga = 2;
                }
                else
                {
                    $hasilConvert = (int)$request->fieldIpQty[$i] * (int)$primary_sat->i_sat_isi3;
                    $isiQty = $primary_sat->i_sat_isi3;
                    $flagMasterHarga = 3;
                }

                if (count($data_sm) > 0) 
                {
                    $qty_req = $hasilConvert;
                    for ($j=0; $j < count($data_sm); $j++) 
                    {
                        $qty_sisa = $data_sm[$j]->sm_qty_sisa;

                        if ($qty_req <= $qty_sisa) 
                        {
                            $h_satsm = $data_sm[$j]->sm_hpp;
                            // $h_satsm = $data_sm[$j]->sm_hpp / $data_sm[$j]->sm_qty;
                            $h_sat = $h_satsm * $isiQty;
                            $h_total = $h_sat * ($qty_req / $isiQty);

                            $dataIsi = new d_pakai_barangdt;
                            $dataIsi->d_pbdt_pbid = $lastId;
                            $dataIsi->d_pbdt_item = $request->fieldIpItem[$i];
                            $dataIsi->d_pbdt_sat = $request->fieldIpSatId[$i];
                            $dataIsi->d_pbdt_qty = $qty_req / $isiQty;
                            $dataIsi->d_pbdt_price = $h_sat;
                            $dataIsi->d_pbdt_pricetotal = $h_total;
                            $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                            $dataIsi->d_pbdt_created = Carbon::now();
                            $dataIsi->save();
                            $j = count($data_sm);
                        }
                        elseif ($qty_req > $qty_sisa) 
                        {
                            $h_satsm = $data_sm[$j]->sm_hpp;
                            //$h_satsm = $data_sm[$j]->sm_hpp / $data_sm[$j]->sm_qty;
                            $h_sat = $h_satsm * $isiQty;
                            $h_total = $h_sat * ($qty_sisa / $isiQty);
                            $qty_form = $qty_sisa / $isiQty; //qty yg diminta pada form 
                            $qty_req = $qty_req - $qty_sisa;
                            
                            $dataIsi = new d_pakai_barangdt;
                            $dataIsi->d_pbdt_pbid = $lastId;
                            $dataIsi->d_pbdt_item = $request->fieldIpItem[$i];
                            $dataIsi->d_pbdt_sat = $request->fieldIpSatId[$i];
                            $dataIsi->d_pbdt_qty = $qty_form;
                            $dataIsi->d_pbdt_price = $h_sat;
                            $dataIsi->d_pbdt_pricetotal = $h_total;
                            $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                            $dataIsi->d_pbdt_created = Carbon::now();
                            $dataIsi->save();
                        }
                    }   
                }
                else
                {
                    //ambil harga dari master
                    $harga_master = DB::table('m_price')
                                        ->select('m_pbuy1', 'm_pbuy2', 'm_pbuy3')
                                        ->where('m_pitem', $request->fieldIpItem[$i])->first();

                    if ($flagMasterHarga == 1) 
                    {
                        $dt_price = $harga_master->m_pbuy1;
                        $dt_pricetotal = $dt_price * $request->fieldIpQty[$i];
                    }
                    elseif ($flagMasterHarga == 2)
                    {
                        $dt_price = $harga_master->m_pbuy2;
                        $dt_pricetotal = $dt_price * $request->fieldIpQty[$i];   
                    }
                    else
                    {
                        $dt_price = $harga_master->m_pbuy3;
                        $dt_pricetotal = $dt_price * $request->fieldIpQty[$i];
                    }

                    $dataIsi = new d_pakai_barangdt;
                    $dataIsi->d_pbdt_pbid = $lastId;
                    $dataIsi->d_pbdt_item = $request->fieldIpItem[$i];
                    $dataIsi->d_pbdt_sat = $request->fieldIpSatId[$i];
                    $dataIsi->d_pbdt_qty = $request->fieldIpQty[$i];
                    $dataIsi->d_pbdt_price = $dt_price;
                    $dataIsi->d_pbdt_pricetotal = $dt_pricetotal;
                    $dataIsi->d_pbdt_keterangan = strtoupper($request->fieldIpKet[$i]);
                    $dataIsi->d_pbdt_created = Carbon::now();
                    $dataIsi->save();
                }

                if(mutasi::mutasiStok(
                    $request->fieldIpItem[$i], //item id
                    $hasilConvert, //qty hasil convert satuan terpilih -> satuan primary 
                    $comp = $request->fieldIpScomp[$i], //posisi gudang berdasarkan type item
                    $position = $request->fieldIpSpos[$i], //posisi gudang berdasarkan type item
                    $flag = 10, //sm mutcat
                    $kode //sm reff
                )) {}
            }//end loop for                

            DB::commit();
            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Data Barang Digunakan Berhasil Disimpan'
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
}
