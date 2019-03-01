<?php

namespace App\Http\Controllers\modul_keuangan\laporan\neraca_lampiran;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_akun_group_subclass as subclass;
use App\Model\modul_keuangan\dk_hierarki_lvl_dua as level_2;

use DB;
use Excel;
use PDF;

class laporan_neraca_lampiran_controller extends Controller
{
    public function index(Request $request){
    	$cabang = '';

        if(modulSetting()['support_cabang']){
            $cabang = DB::table(tabel()->cabang->nama)
                                ->where(tabel()->cabang->kolom->id, $request->cab)
                                ->select(tabel()->cabang->kolom->nama.' as nama')
                                ->first()->nama;
        }

    	return view('modul_keuangan.laporan.neraca_lampiran.index', compact('cabang'));
    }

    public function dataResource(Request $request){
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $data = level_2::where('hld_level_1', '<=', '3')
                            ->with([
                                'akun' => function($query) use ($d1, $request){
                                    $query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->where('ak_comp', $request->cab)
                                            ->select(
                                                'ak_id',
                                                'ak_nomor',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(as_saldo_akhir, 2) as saldo_akhir')
                                            );
                                }
                            ])
                            ->select('hld_id', 'hld_nama')
                            ->get();
            }else{
                $data = level_2::where('hld_level_1', '<=', '3')
                            ->with([
                                'akun' => function($query) use ($d1, $request){
                                    $query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->select(
                                                'ak_id',
                                                'ak_nomor',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(as_saldo_akhir, 2) as saldo_akhir')
                                            );
                                }
                            ])
                            ->select('hld_id', 'hld_nama')
                            ->get();
            }

        // selesai

        // return json_encode($data);

        // return json_encode($res);

    	return json_encode([
    		"data"	        => $data
    	]);
    }

    public function print(Request $request){
    	$d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

    	 // Mengambil Cabang

            $namaCabang = '';

            if(modulSetting()['support_cabang']){
                $namaCabang = DB::table(tabel()->cabang->nama)
                                    ->where(tabel()->cabang->kolom->id, $request->cab)
                                    ->select(tabel()->cabang->kolom->nama.' as nama')
                                    ->first()->nama;
            }

        // Selesai Mengambil Cabang


        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $data = level_2::where('hld_level_1', '<=', '3')
                            ->with([
                                'akun' => function($query) use ($d1, $request){
                                    $query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->where('ak_comp', $request->cab)
                                            ->select(
                                                'ak_id',
                                                'ak_nomor',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(as_saldo_akhir, 2) as saldo_akhir')
                                            );
                                }
                            ])
                            ->select('hld_id', 'hld_nama')
                            ->get();
            }else{
                $data = level_2::where('hld_level_1', '<=', '3')
                            ->with([
                                'akun' => function($query) use ($d1, $request){
                                    $query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->select(
                                                'ak_id',
                                                'ak_nomor',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(as_saldo_akhir, 2) as saldo_akhir')
                                            );
                                }
                            ])
                            ->select('hld_id', 'hld_nama')
                            ->get();
            }

        // selesai

        // return json_encode($data);

        // return json_encode($res);

    	return view('modul_keuangan.laporan.neraca_lampiran.print.index', compact('data', 'namaCabang'));
    }

    public function pdf(Request $request){
    	$d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

    	 // Mengambil Cabang

            $namaCabang = '';

            if(modulSetting()['support_cabang']){
                $namaCabang = DB::table(tabel()->cabang->nama)
                                    ->where(tabel()->cabang->kolom->id, $request->cab)
                                    ->select(tabel()->cabang->kolom->nama.' as nama')
                                    ->first()->nama;
            }

        // Selesai Mengambil Cabang


        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $data = level_2::where('hld_level_1', '<=', '3')
                            ->with([
                                'akun' => function($query) use ($d1, $request){
                                    $query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->where('ak_comp', $request->cab)
                                            ->select(
                                                'ak_id',
                                                'ak_nomor',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(as_saldo_akhir, 2) as saldo_akhir')
                                            );
                                }
                            ])
                            ->select('hld_id', 'hld_nama')
                            ->get();
            }else{
                $data = level_2::where('hld_level_1', '<=', '3')
                            ->with([
                                'akun' => function($query) use ($d1, $request){
                                    $query->leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', 'dk_akun.ak_id')
                                            ->where('as_periode', $d1)
                                            ->select(
                                                'ak_id',
                                                'ak_nomor',
                                                'ak_kelompok',
                                                'ak_nama',
                                                'ak_posisi',
                                                DB::raw('coalesce(as_saldo_akhir, 2) as saldo_akhir')
                                            );
                                }
                            ])
                            ->select('hld_id', 'hld_nama')
                            ->get();
            }

        $data = [
            "data"       => $data,
            "cabang"     => $namaCabang
        ];

        // return view('modul_keuangan.laporan.jurnal.print.pdf', compact('data'));

        $title = "Laporan_Neraca_".$d1.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.neraca_lampiran.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download($title);
    }
}
