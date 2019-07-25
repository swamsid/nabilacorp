<?php

namespace App\Modules\Master\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Datatables;
use URL;
use App\m_satuan;

// use App\mmember

class satuanController extends Controller
{
    public function satuan()
    {   
        $data = DB::table('m_satuan')->get();
        return view('Master::datasatuan/satuan',compact('data'));
    }
    public function datatable_satuan()
    {
        $list = DB::select("SELECT * from m_satuan");       
        // return $data;

        return Datatables::of($list)
                
          ->addColumn('aksi', function ($data) {

            return  '<div class="text-center">'.
                        '<button id="edit" 
                          onclick="edit('.$data->s_id.')" 
                          class="btn btn-warning btn-xs" 
                          title="Edit">
                          <i class=" fa-fw glyphicon glyphicon-pencil"></i>
                        </button>'.'
                        <button id="status'.$data->s_id.'" 
                            onclick="ubahStatus('.$data->s_id.')" 
                            class="btn btn-primary btn-xs" 
                            title="Aktif">
                            <i class="fa fa-fw  fa-check-square" aria-hidden="true"></i>
                        </button>'.
                    '</div>';      
            
          })
          ->addColumn('none', function ($data) {
              return '-';
          })
          ->rawColumns(['aksi','confirmed'])
          ->make(true);
    }

    public function tambah_satuan(Request $request)
    {
        $kode = DB::table('m_satuan')->max('s_id');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

        $nota = 'ST-'.$kode;

        return view('Master::datasatuan/tambah_satuan',compact('nota'));
    }

    public function simpan_satuan(Request $request)
    {

      DB::beginTransaction();
        try {
        $kode = DB::table('m_satuan')->max('s_id');
        if ($kode == null) {
          $kode = 1;
        }else{
          $kode +=1;
        }
        $kode = DB::table('m_satuan')
                  ->insert([
                      's_id'=>$kode,
                      's_code'=>$request->id,
                      's_name'=>$request->nama,
                      's_detname' => $request->detail
                    ]);
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

    public function hapus_satuan(Request $request)
    {
      $data = DB::table('m_satuan')->where('s_id','=',$request->id)->delete();
      return response()->json(['status'=>'sukses']);
    }

    public function edit_satuan(Request $request)
    {
      $data = DB::table('m_satuan')->where('s_id','=',$request->id)->first();
      json_encode($data);
      return view('Master::datasatuan/edit_satuan',compact('data'));
    }

    public function update_satuan(Request $request)
    {
      $kode = DB::table('m_satuan')
                  ->where('s_code','=',$request->id)
                  ->update([
                      's_name'=>$request->nama,
                      's_detname'=>$request->detail
                    ]);
      return response()->json(['status'=>1]);
    }

  public function ubahStatus(Request $request)
  {
    DB::beginTransaction();
        try {
    $cek = m_satuan::select('s_iactive')
      ->where('s_id',$request->id)
      ->first();

    if ($cek->s_iactive == 'Y') 
    {
      m_satuan::where('s_id',$request->id)
        ->update([
          's_iactive' => 'N'
        ]);
    }
    else
    {
      m_satuan::where('s_id',$request->id)
        ->update([
          's_iactive' => 'Y'
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



