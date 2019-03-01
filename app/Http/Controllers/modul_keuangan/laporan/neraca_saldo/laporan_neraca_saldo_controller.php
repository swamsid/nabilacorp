<?php

namespace App\Http\Controllers\modul_keuangan\laporan\neraca_saldo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Export\excel\exporter as exporter;
use App\Model\modul_keuangan\dk_akun as akun;

use DB;
use Excel;
use PDF;

class laporan_neraca_saldo_controller extends Controller
{
    public function index(Request $request){

        $cabang = '';

        if(modulSetting()['support_cabang']){
            $cabang = DB::table(tabel()->cabang->nama)
                                ->where(tabel()->cabang->kolom->id, $request->cab)
                                ->select(tabel()->cabang->kolom->nama.' as nama')
                                ->first()->nama;
        }

        return view('modul_keuangan.laporan.neraca_saldo.index', compact("cabang"));
    }

    public function dataResource(Request $request){
        
        $d1 = explode('/', $request->d1)[1].'-'.explode('/', $request->d1)[0].'-01';

        $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->where('ak_isactive', '1');


        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('ak_comp', $request->cab)
                                ->select(
                                            'ak_id',
                                            'ak_nama',
                                            'ak_nomor',
                                             DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as saldo_awal'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_kas_debet, 0) as kas_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_kas_kredit, 0) as kas_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_bank_debet, 0) as bank_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_bank_kredit, 0) as bank_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_debet, 0) as memorial_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_kredit, 0) as memorial_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_saldo_akhir, 0) as saldo_akhir')
                                        )
                                ->orderBy('ak_id', 'asc')
                                ->get();
            }else{
                $res = $res->select(
                                    'ak_id',
                                    'ak_nama',
                                    'ak_nomor',
                                     DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as saldo_awal'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_kas_debet, 0) as kas_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_kas_kredit, 0) as kas_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_bank_debet, 0) as bank_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_bank_kredit, 0) as bank_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_debet, 0) as memorial_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_kredit, 0) as memorial_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_saldo_akhir, 0) as saldo_akhir')
                                )
                                ->orderBy('ak_id', 'asc')
                                ->get();
            }

        // selesai

        return json_encode([
            "data"          => $res
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

        $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->where('ak_isactive', '1');

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('ak_comp', $request->cab)
                                ->select(
                                            'ak_id',
                                            'ak_nama',
                                            'ak_nomor',
                                             DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as saldo_awal'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_kas_debet, 0) as kas_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_kas_kredit, 0) as kas_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_bank_debet, 0) as bank_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_bank_kredit, 0) as bank_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_debet, 0) as memorial_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_kredit, 0) as memorial_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_saldo_akhir, 0) as saldo_akhir')
                                        )
                                ->orderBy('ak_id', 'asc')
                                ->get();
            }else{
                $res = $res->select(
                                    'ak_id',
                                    'ak_nama',
                                    'ak_nomor',
                                     DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as saldo_awal'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_kas_debet, 0) as kas_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_kas_kredit, 0) as kas_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_bank_debet, 0) as bank_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_bank_kredit, 0) as bank_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_debet, 0) as memorial_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_kredit, 0) as memorial_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_saldo_akhir, 0) as saldo_akhir')
                                )
                                ->orderBy('ak_id', 'asc')
                                ->get();
            }

        // selesai

        // return json_encode($res[0]->jurnal_detail);

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
            "cabang"    => $namaCabang
        ];

        return view('modul_keuangan.laporan.neraca_saldo.print.index', compact('data'));
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

        $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->where('ak_isactive', '1');

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('ak_comp', $request->cab)
                                ->select(
                                            'ak_id',
                                            'ak_nama',
                                            'ak_nomor',
                                             DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as saldo_awal'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_kas_debet, 0) as kas_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_kas_kredit, 0) as kas_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_bank_debet, 0) as bank_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_bank_kredit, 0) as bank_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_debet, 0) as memorial_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_kredit, 0) as memorial_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_saldo_akhir, 0) as saldo_akhir')
                                        )
                                ->orderBy('ak_id', 'asc')
                                ->get();
            }else{
                $res = $res->select(
                                    'ak_id',
                                    'ak_nama',
                                    'ak_nomor',
                                     DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as saldo_awal'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_kas_debet, 0) as kas_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_kas_kredit, 0) as kas_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_bank_debet, 0) as bank_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_bank_kredit, 0) as bank_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_debet, 0) as memorial_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_kredit, 0) as memorial_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_saldo_akhir, 0) as saldo_akhir')
                                )
                                ->orderBy('ak_id', 'asc')
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

        $title = "Laporan_Neraca_Saldo_".$d1.".pdf";

        $pdf = PDF::loadView('modul_keuangan.laporan.neraca_saldo.print.pdf', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($title);
    }

    public function excel(Request $request){

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

        $res = akun::leftJoin('dk_akun_saldo', 'dk_akun_saldo.as_akun', '=', 'dk_akun.ak_id')
                        ->where('dk_akun_saldo.as_periode', $d1)
                        ->where('ak_isactive', '1');

        // ketika support cabang

            if(modulSetting()['support_cabang']){
                $res = $res->where('ak_comp', $request->cab)
                                ->select(
                                            'ak_id',
                                            'ak_nama',
                                            'ak_nomor',
                                             DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as saldo_awal'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_kas_debet, 0) as kas_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_kas_kredit, 0) as kas_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_bank_debet, 0) as bank_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_bank_kredit, 0) as bank_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_debet, 0) as memorial_debet'),
                                             DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_kredit, 0) as memorial_kredit'),
                                             DB::raw('coalesce(dk_akun_saldo.as_saldo_akhir, 0) as saldo_akhir')
                                        )
                                ->orderBy('ak_id', 'asc')
                                ->get();
            }else{
                $res = $res->select(
                                    'ak_id',
                                    'ak_nama',
                                    'ak_nomor',
                                     DB::raw('coalesce(dk_akun_saldo.as_saldo_awal, 0) as saldo_awal'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_kas_debet, 0) as kas_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_kas_kredit, 0) as kas_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_bank_debet, 0) as bank_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_bank_kredit, 0) as bank_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_debet, 0) as memorial_debet'),
                                     DB::raw('coalesce(dk_akun_saldo.as_mut_memorial_kredit, 0) as memorial_kredit'),
                                     DB::raw('coalesce(dk_akun_saldo.as_saldo_akhir, 0) as saldo_akhir')
                                )
                                ->orderBy('ak_id', 'asc')
                                ->get();
            }

        // selesai

        $data = [
            "data"      => $res,
            "request"   => $request->all(),
            "cabang"    => $namaCabang
        ];

        // return json_encode($data);

        $title = "Laporan_Neraca_Saldo_".$d1.".xlsx";

        // return view('modul_keuangan.laporan.jurnal.print.excel', compact('data'));

        return Excel::download(new exporter('modul_keuangan.laporan.neraca_saldo.print.excel', $data), $title);
    }
}
