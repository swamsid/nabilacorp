<?php

namespace App\Modules\Master\Controllers;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_group;
use Datatables;
use URL;

// use App\mmember

class groupController extends Controller
{
    public function group()
    {
        $data = DB::table('m_group')->get();
        return view(' Master::datagroup/group',compact('data'));
    }
    public function datatable_group()
    {
        $list = DB::table('m_group')
          ->select('g_id',
                   'g_code',
                   'g_name',
                   'c.ak_nama as persediaan',
                   'd.ak_nama as penjualan',
                   'e.ak_nama as beban',
                   'g_isactive')
         ->leftjoin('dk_akun as c', function($join) {
             $join->on('c.ak_id', '=', 'm_group.g_akun_persediaan');
           })
         ->leftjoin('dk_akun as d', function($join) {
             $join->on('d.ak_id', '=', 'm_group.g_akun_penjualan');
           })
         ->leftjoin('dk_akun as e', function($join) {
             $join->on('e.ak_id', '=', 'm_group.g_akun_beban');
           })
         ->get();

        // return json_encode($list);
        $data = collect($list);

        // return $data;

        return Datatables::of($list)

                ->addColumn('aksi', function ($data) {
                  if ($data->g_isactive == 'Y') 
                  {
                    return  '<div class="text-center">
                              <button id="edit" 
                                      onclick="edit('.$data->g_id.')"
                                      class="btn btn-warning btn-sm"
                                      title="Edit">
                                      <i class="glyphicon glyphicon-pencil"></i>
                              </button>
                              <button id="status'.$data->g_id.'" 
                                      onclick="ubahStatus('.$data->g_id.')" 
                                      class="btn btn-primary btn-sm" 
                                      title="Aktif">
                                      <i class="fa fa-check-square" aria-hidden="true"></i>
                              </button>
                          </div>';
                  }
                  else
                  {
                    return  '<div class="text-center">'.
                                '<button id="status'.$data->g_id.'" 
                                    onclick="ubahStatus('.$data->g_id.')" 
                                    class="btn btn-danger btn-sm" 
                                    title="Tidak Aktif">
                                    <i class="fa fa-minus-square" aria-hidden="true"></i>
                                </button>'.
                            '</div>';
                  }
                  
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->rawColumns(['aksi','confirmed'])
                ->make(true);
    }
    public function tambah_group(Request $request)
    {
        $kode = DB::table('m_group')->max('g_id');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $tanggal = date("ym");

        $kode = str_pad($kode, 3, '0', STR_PAD_LEFT);

        $nota = $kode;

        $item = DB::table('dk_akun')
          ->select('ak_id',
                    DB::raw('concat(ak_nomor, " - ", ak_nama) as nama_akun' )
                  )
          ->where('ak_isactive','1')
          ->get();

        $penjualan = DB::table('dk_akun')
          ->select('ak_id',
                    DB::raw('concat(ak_nomor, " - ", ak_nama) as nama_akun')
                  )
          ->where('ak_isactive','1')
          ->get();

        $beban = DB::table('dk_akun')
          ->select('ak_id',
                    DB::raw('concat(ak_nomor, " - ", ak_nama) as nama_akun')
                  )
          ->where('ak_isactive','1')
          ->get();

      return view('Master::datagroup.tambah_group',compact('nota','item','penjualan', 'beban'));
    }
    public function simpan_group(Request $request)
    {
        // dd($request->all());
        $id = DB::table('m_group')->max('g_id')+1;
        if ($id == null) {
          $id = 1;
        }else{
          $id +=1;
        }

        $code = m_group::select('g_code')->max('g_code')+1;

        DB::table('m_group')
                  ->insert([
                      'g_id'=>$id,
                      'g_code'=>'0'. $code,
                      'g_name'=>$request->nama,
                      'g_akun_persediaan'=>$request->akun,
                      'g_akun_beban'=>$request->akun_beban,
                      'g_akun_penjualan'=>$request->akun_penjualan,
                      'g_create'=>Carbon::now(),
                    ]);
    }
    public function hapus_group($id)
    {
      $data = DB::table('m_group')->where('g_id',$id)->delete();
      return response()->json(['status'=>1]);
    }
    public function edit_group($id)
    {
      // dd($request->all());
      $data = DB::table('m_group')
        ->select('g_id',
                 'g_name',
                 'g_code',
                 'g_akun_persediaan',
                 'c.ak_id as persediaan',
                 'd.ak_id as penjualan',
                 'e.ak_id as beban',
                 'c.ak_nama as persediaan_nama',
                 'd.ak_nama as penjualan_nama',
                 'e.ak_nama as beban_nama')
        ->leftjoin('dk_akun as c', function($join) {
            $join->on('c.ak_id', '=', 'm_group.g_akun_persediaan');
          })
        ->leftjoin('dk_akun as d', function($join) {
            $join->on('d.ak_id', '=', 'm_group.g_akun_penjualan');
          })
        ->leftjoin('dk_akun as e', function($join) {
            $join->on('e.ak_id', '=', 'm_group.g_akun_beban');
          })
        ->where('g_id','=',$id)
        ->first();
        // dd($data);
      $item = DB::table('dk_akun')
        ->select('ak_id',
                  'ak_nama',
                  DB::raw('concat(ak_nomor, " - ", ak_nama) as nama_akun'))
        ->get();

      $penjualan = DB::table('dk_akun')
          ->select('ak_id',
                  'ak_nama',
                  DB::raw('concat(ak_nomor, " - ", ak_nama) as nama_akun'))
          ->get();

      $beban = DB::table('dk_akun')
          ->select('ak_id',
                  'ak_nama',
                   DB::raw('concat(ak_nomor, " - ", ak_nama) as nama_akun'))
          ->get();

      return view('Master::datagroup/edit_group',compact('data','item','penjualan', 'beban'));
    }
    public function update_group(Request $request)
    {
      // dd($request->all());
      $tanggal = date("Y-m-d h:i:s");

      $kode = DB::table('m_group')
                  ->where('g_id','=',$request->id)
                  ->update([
                      'g_name'=>$request->nama,
                      'g_akun_persediaan'=>$request->akun,
                      'g_akun_beban'=>$request->beban,
                      'g_akun_penjualan'=>$request->penjualan,
                      'g_update'=>$tanggal,
                    ]);
      return response()->json(['status'=>1]);
    }

  public function ubahStatus(Request $request)
  {
    DB::beginTransaction();
        try {
    $cek = m_group::select('g_isactive')
      ->where('g_id',$request->id)
      ->first();

    if ($cek->g_isactive == 'Y') 
    {
      m_group::where('g_id',$request->id)
        ->update([
          'g_isactive' => 'N'
        ]);
    }
    else
    {
      m_group::where('g_id',$request->id)
        ->update([
          'g_isactive' => 'Y'
        ]);
    }
    DB::commit();
        return response()->json([
            'status' => 'sukses'
        ]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'data' => $e
        ]);
    }
  }
}
