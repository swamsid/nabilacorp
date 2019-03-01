<?php

namespace App\Http\Controllers\modul_keuangan\laporan\buku_besar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_akun as akun;

use DB;
use Excel;
use PDF;

class laporan_buku_besar_controller extends Controller
{
    public function index(Request $request){

        $cabang = '';

        if(modulSetting()['support_cabang']){
            $cabang = DB::table(tabel()->cabang->nama)
                                ->where(tabel()->cabang->kolom->id, $request->cab)
                                ->select(tabel()->cabang->kolom->nama.' as nama')
                                ->first()->nama;
        }

    	return view('modul_keuangan.laporan.buku_besar.index', compact('cabang'));
    }

    public function dataResource(Request $request){

    	$tanggal2 = explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0].'-01';
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';
        $d2 = date('Y-m-d', strtotime('+1 months', strtotime($tanggal2)));

        $akun = akun::where('ak_isactive', '1')
                        ->where('ak_comp', modulSetting()['onLogin'])
                        ->select('ak_id as id', DB::raw('concat(ak_nomor, " - ", ak_nama) as text'), 'ak_nomor as nomor')
                        ->orderBy('ak_id')->get();

        if(!isset($request->semua)){
            $data = akun::whereBetween('ak_id', [$request->akun1, $request->akun2])
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with([
                                                                    'detail' => function($query) {
                                                                        $query->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                                            ->select(
                                                                                'dk_akun.ak_nomor',
                                                                                'jrdt_jurnal',
                                                                                'jrdt_akun',
                                                                                'jrdt_dk',
                                                                                'jrdt_value'
                                                                            );   
                                                                    }
                                                                ]);
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1');
        }else{
            $data = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with([
                                                                    'detail' => function($query) {
                                                                        $query->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                                            ->select(
                                                                                'dk_akun.ak_nomor',
                                                                                'jrdt_jurnal',
                                                                                'jrdt_akun',
                                                                                'jrdt_dk',
                                                                                'jrdt_value'
                                                                            );   
                                                                    }
                                                                ]);
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1');
        }

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $data = $data->where('ak_comp', $request->cab)
                                ->select('ak_id', 'ak_nomor', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                                ->get();
            }else{
                $data = $data->select('ak_id', 'ak_nomor', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                                ->get();
            }

        // selesai


    	// return json_encode($data);

    	return json_encode([
    		"data"	        => $data,
            "akun"          => $akun,
    		"requestLawan"  => $request->lawan,
            "requestSemua"  => ($request->semua) ? 'on' : 'off',
            "akun1"         => (!$request->semua) ? $request->akun1 : 'null',
            "akun2"         => (!$request->semua) ? $request->akun2 : 'null',
    	]);
    }

    public function print(Request $request){
        $tanggal2 = explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0].'-01';
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';
        $d2 = date('Y-m-d', strtotime('+1 months', strtotime($tanggal2)));

        // Mengambil Cabang

            $namaCabang = '';

            if(modulSetting()['support_cabang']){
                $namaCabang = DB::table(tabel()->cabang->nama)
                                    ->where(tabel()->cabang->kolom->id, $request->cab)
                                    ->select(tabel()->cabang->kolom->nama.' as nama')
                                    ->first()->nama;
            }

        // Selesai Mengambil Cabang

        if(!isset($request->semua)){
            $res = akun::whereBetween('ak_id', [$request->akun1, $request->akun2])
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with([
                                                                    'detail' => function($query) {
                                                                        $query->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                                            ->select(
                                                                                'dk_akun.ak_nomor',
                                                                                'jrdt_jurnal',
                                                                                'jrdt_akun',
                                                                                'jrdt_dk',
                                                                                'jrdt_value'
                                                                            );   
                                                                    }
                                                                ]);
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1');
        }else{
            $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with([
                                                                    'detail' => function($query) {
                                                                        $query->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                                            ->select(
                                                                                'dk_akun.ak_nomor',
                                                                                'jrdt_jurnal',
                                                                                'jrdt_akun',
                                                                                'jrdt_dk',
                                                                                'jrdt_value'
                                                                            );   
                                                                    }
                                                                ]);
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1');
        }

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('ak_comp', $request->cab)
                                ->select('ak_id', 'ak_nomor', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                                ->get();
            }else{
                $res = $res->select('ak_id', 'ak_nomor', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                                ->get();
            }

        // selesai


        // return json_encode($res[0]->jurnal_detail);

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
        ];

        // return json_encode($data);

        return view('modul_keuangan.laporan.buku_besar.print.index', compact('data', 'namaCabang'));
    }

    public function pdf(Request $request){
        $tanggal2 = explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0].'-01';
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';
        $d2 = date('Y-m-d', strtotime('+1 months', strtotime($tanggal2)));

        // Mengambil Cabang

            $namaCabang = '';

            if(modulSetting()['support_cabang']){
                $namaCabang = DB::table(tabel()->cabang->nama)
                                    ->where(tabel()->cabang->kolom->id, $request->cab)
                                    ->select(tabel()->cabang->kolom->nama.' as nama')
                                    ->first()->nama;
            }

        // Selesai Mengambil Cabang

        if(!isset($request->semua)){
            $res = akun::whereBetween('ak_id', [$request->akun1, $request->akun2])
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with([
                                                                    'detail' => function($query) {
                                                                        $query->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                                            ->select(
                                                                                'dk_akun.ak_nomor',
                                                                                'jrdt_jurnal',
                                                                                'jrdt_akun',
                                                                                'jrdt_dk',
                                                                                'jrdt_value'
                                                                            );   
                                                                    }
                                                                ]);
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1');
        }else{
            $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with([
                                                                    'detail' => function($query) {
                                                                        $query->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                                            ->select(
                                                                                'dk_akun.ak_nomor',
                                                                                'jrdt_jurnal',
                                                                                'jrdt_akun',
                                                                                'jrdt_dk',
                                                                                'jrdt_value'
                                                                            );   
                                                                    }
                                                                ]);
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1');
        }

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('ak_comp', $request->cab)
                                ->select('ak_id', 'ak_nomor', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                                ->get();
            }else{
                $res = $res->select('ak_id', 'ak_nomor', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                                ->get();
            }

        // selesai


        // return json_encode($data);

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
            "cabang"    => $namaCabang
        ];

        // return view('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));

        $title = "Laporan_Buku_Besar_".$d1."__".$d2.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.buku_besar.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($title);
    }

    public function excel(Request $request){

        $tanggal2 = explode('/', $request->d2)[1].'-'.explode('/', $request->d2)[0].'-01';
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';
        $d2 = date('Y-m-d', strtotime('+1 months', strtotime($tanggal2)));

        // Mengambil Cabang

            $namaCabang = '';

            if(modulSetting()['support_cabang']){
                $namaCabang = DB::table(tabel()->cabang->nama)
                                    ->where(tabel()->cabang->kolom->id, $request->cab)
                                    ->select(tabel()->cabang->kolom->nama.' as nama')
                                    ->first()->nama;
            }

        // Selesai Mengambil Cabang

        if(!isset($request->semua)){
            $res = akun::whereBetween('ak_id', [$request->akun1, $request->akun2])
                        ->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with([
                                                                    'detail' => function($query) {
                                                                        $query->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                                            ->select(
                                                                                'dk_akun.ak_nomor',
                                                                                'jrdt_jurnal',
                                                                                'jrdt_akun',
                                                                                'jrdt_dk',
                                                                                'jrdt_value'
                                                                            );   
                                                                    }
                                                                ]);
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1');
        }else{
            $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->with([
                                'jurnal_detail' => function($query) use ($d1, $d2){
                                    $query->select('jrdt_jurnal', 'jrdt_akun', 'jrdt_dk', 'jrdt_value')
                                            ->join('dk_jurnal', 'dk_jurnal.jr_id', '=', 'dk_jurnal_detail.jrdt_jurnal')
                                            ->where('dk_jurnal.jr_tanggal_trans', ">=", $d1)
                                            ->where('dk_jurnal.jr_tanggal_trans', "<", $d2)
                                            ->orderBy('dk_jurnal.jr_tanggal_trans', 'asc')
                                            ->with([
                                                    'jurnal' => function($query){
                                                        $query->select('jr_id', 'jr_tanggal_trans', 'jr_keterangan', 'jr_ref')
                                                                ->with([
                                                                    'detail' => function($query) {
                                                                        $query->join('dk_akun', 'dk_akun.ak_id', '=', 'dk_jurnal_detail.jrdt_akun')
                                                                            ->select(
                                                                                'dk_akun.ak_nomor',
                                                                                'jrdt_jurnal',
                                                                                'jrdt_akun',
                                                                                'jrdt_dk',
                                                                                'jrdt_value'
                                                                            );   
                                                                    }
                                                                ]);
                                                    }
                                            ]);
                                }
                        ])
                        ->where('ak_isactive', '1');
        }

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('ak_comp', $request->cab)
                                ->select('ak_id', 'ak_nomor', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                                ->get();
            }else{
                $res = $res->select('ak_id', 'ak_nomor', 'ak_posisi', 'ak_nama', DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as ak_saldo_awal'), 'dk_akun_saldo.as_periode as ak_periode')
                                ->get();
            }

        // selesai


        $data = [
            "data"      => $res,
            "request"   => $request->all(),
            "cabang"    => $namaCabang
        ];

        // return json_encode($data);

        $title = "Laporan_Buku_Besar_".$d1."__".$d2.".xlsx";

        // return view('modul_keuangan.laporan.jurnal.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.buku_besar.print.excel', $data), $title);
    }
}
