<?php

namespace App\Modules\System\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use App\Http\Controllers\Controller;

use DB;

use Datatables;

use Auth;






class hakuserController extends Controller
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

   /* public function cut(){
      $connector = new FilePrintConnector("\\\TAZIZ-PC\POS-80");
      $printer = new Printer($connector);
      $printer -> cut();
      $printer -> close();

    }*/
    public function index(){
      $data = DB::table('d_mem')
              ->get();

      return view('System::hakuser/user', compact('data'));
    }

    public function tambah(){
      $akses = DB::select("select * from d_access order by a_order");

      $perusahaan = DB::table('m_comp')
                    ->get();

      $gudang = DB::table('m_gudang')
                ->get();

      return view('System::hakuser/tambah_user', compact('perusahaan', 'gudang', 'akses'));
    }

    public function simpan(Request $request){
      DB::beginTransaction();
      try {

        $id = DB::table('d_mem')
              ->max('m_id');

        $password = sha1(md5('passwordAllah') . $request->password);

        DB::table('d_mem')
          ->insert([
            'm_id' => $id + 1,
            'm_username' => $request->username,
            'm_passwd' => $password,
            'm_name' => $request->nama,
            'm_birth_tgl' => Carbon::createFromFormat('d/m/Y', $request->tgllahir, 'Asia/Jakarta'),
            'm_addr' => $request->alamat,
            'm_insert' => Carbon::now('Asia/Jakarta')
          ]);

        for ($i=0; $i < count($request->perusahaan); $i++) {
          DB::table('d_mem_comp')
            ->insert([
              'mc_mem' => $id + 1,
              'mc_comp' => (int)$request->perusahaan[$i],
              'mc_active' => 'Y',
              'mc_insert' => Carbon::now('Asia/Jakarta')
            ]);
        }

        for ($x=0; $x < count($request->gudang); $x++) {
          DB::table('d_mem_gudangcomp')
            ->insert([
              'mg_mem' => $id + 1,
              'mg_gudang' => (int)$request->gudang[$x],
              'mg_created' => Carbon::now('Asia/Jakarta')
            ]);
        }

            $read = $request->read;
            $insert = $request->insert;
            $update = $request->update;
            $delete = $request->delete;

            $akses = DB::table('d_access')
                ->select('a_id')
                ->get();

            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $id + 1)
                ->get();

            if (count($cek) > 0){
                //== update data
                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id + 1)
                    ->update([
                        'ma_read' => 'N',
                        'ma_insert' => 'N',
                        'ma_update' => 'N',
                        'ma_delete' => 'N'
                    ]);

                if (!empty($read)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id + 1)
                      ->whereIn('ma_access', $read)
                      ->update([
                          'ma_read' => 'Y'
                      ]);
                }

                if (!empty($insert)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id + 1)
                      ->whereIn('ma_access', $insert)
                      ->update([
                          'ma_insert' => 'Y'
                      ]);
                }

                if (!empty($update)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id + 1)
                      ->whereIn('ma_access', $update)
                      ->update([
                          'ma_update' => 'Y'
                      ]);

                }

                if (!empty($delete)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id + 1)
                      ->whereIn('ma_access', $delete)
                      ->update([
                          'ma_delete' => 'Y'
                      ]);
                }

            } else {
                //== create data
                $addAkses = [];
                for ($i = 0; $i < count($akses); $i++){
                    $temp = [
                        'ma_mem' => $id + 1,
                        'ma_access' => $akses[$i]->a_id
                    ];
                    array_push($addAkses, $temp);
                }
                DB::table('d_mem_access')->insert($addAkses);


                if (!empty($read)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id + 1)
                      ->whereIn('ma_access', $read)
                      ->update([
                          'ma_read' => 'Y'
                      ]);
                }

                if (!empty($insert)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id + 1)
                      ->whereIn('ma_access', $insert)
                      ->update([
                          'ma_insert' => 'Y'
                      ]);
                }

                if (!empty($update)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id + 1)
                      ->whereIn('ma_access', $update)
                      ->update([
                          'ma_update' => 'Y'
                      ]);
                }

                if (!empty($delete)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id + 1)
                      ->whereIn('ma_access', $delete)
                      ->update([
                          'ma_delete' => 'Y'
                      ]);
                }

            }

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::commit();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }

    public function edit(Request $request){
      $id = $request->id;

      $perusahaan = DB::table('m_comp')
                    ->get();

      $gudang = DB::table('m_gudang')
                ->get();


      $data = DB::table('d_mem')
              ->where('m_id', $request->id)
              ->get();

      $perusahaandata = DB::table('d_mem_comp')
                        ->where('mc_mem', $request->id)
                        ->where('mc_active', 'Y')
                        ->get();

      $gudangdata = DB::table('d_mem_gudangcomp')
                        ->where('mg_mem', $request->id)
                        ->select('mg_gudang')
                        ->get();
$isiGudang=[];
foreach ($gudangdata as $key => $gudang1) {
  $isiGudang[$key]=$gudang1->mg_gudang;
}

  $akses = DB::select('select d_access.a_name,d_access.a_order,d_access.a_id,d_access.a_parrent,d_mem_access.* from d_mem join d_mem_access on m_id=ma_mem join d_access on ma_access=a_id where m_id = "'.$id.'" and ma_type is null');

      return view('System::hakuser/edit_user', compact('perusahaan', 'gudang', 'data', 'perusahaandata', 'gudangdata','isiGudang', 'id', 'akses'));
    }

    public function update(Request $request){
      DB::beginTransaction();
      try {

        $id = $request->id;

        $password = sha1(md5('passwordAllah') . $request->password);

        DB::table('d_mem')
          ->where('m_id', $id)
          ->delete();

        DB::table('d_mem_comp')
          ->where('mc_mem', $id)
          ->delete();

        DB::table('d_mem_gudangcomp')
          ->where('mg_mem', $id)
          ->delete();

        DB::table('d_mem')
          ->insert([
            'm_id' => $id,
            'm_username' => $request->username,
            'm_passwd' => $password,
            'm_name' => $request->nama,
            'm_birth_tgl' => Carbon::createFromFormat('d/m/Y', $request->tgllahir, 'Asia/Jakarta'),
            'm_addr' => $request->alamat,
            'm_insert' => Carbon::now('Asia/Jakarta')
          ]);

        for ($i=0; $i < count($request->perusahaan); $i++) {
          DB::table('d_mem_comp')
            ->insert([
              'mc_mem' => $id,
              'mc_comp' => (int)$request->perusahaan[$i],
              'mc_active' => 'Y',
              'mc_insert' => Carbon::now('Asia/Jakarta')
            ]);
        }

        for ($x=0; $x < count($request->gudang); $x++) {
          DB::table('d_mem_gudangcomp')
            ->insert([
              'mg_mem' => $id,
              'mg_gudang' => (int)$request->gudang[$x],
              'mg_created' => Carbon::now('Asia/Jakarta')
            ]);
        }

            $read = $request->read;
            $insert = $request->insert;
            $update = $request->update;
            $delete = $request->delete;

            $akses = DB::table('d_access')
                ->select('a_id')
                ->get();

            $cek = DB::table('d_mem_access')
                ->where('ma_mem', '=', $id)
                ->get();

            if (count($cek) > 0){
                //== update data
                DB::table('d_mem_access')
                    ->where('ma_mem', '=', $id)
                    ->update([
                        'ma_read' => 'N',
                        'ma_insert' => 'N',
                        'ma_update' => 'N',
                        'ma_delete' => 'N'
                    ]);

                if (!empty($read)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id)
                      ->whereIn('ma_access', $read)
                      ->update([
                          'ma_read' => 'Y'
                      ]);
                }

                if (!empty($insert)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id)
                      ->whereIn('ma_access', $insert)
                      ->update([
                          'ma_insert' => 'Y'
                      ]);
                }

                if (!empty($update)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id)
                      ->whereIn('ma_access', $update)
                      ->update([
                          'ma_update' => 'Y'
                      ]);

                }

                if (!empty($delete)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id)
                      ->whereIn('ma_access', $delete)
                      ->update([
                          'ma_delete' => 'Y'
                      ]);
                }

            } else {
                //== create data
                $addAkses = [];
                for ($i = 0; $i < count($akses); $i++){
                    $temp = [
                        'ma_mem' => $id,
                        'ma_access' => $akses[$i]->a_id
                    ];
                    array_push($addAkses, $temp);
                }
                DB::table('d_mem_access')->insert($addAkses);


                if (!empty($read)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id)
                      ->whereIn('ma_access', $read)
                      ->update([
                          'ma_read' => 'Y'
                      ]);
                }

                if (!empty($insert)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id)
                      ->whereIn('ma_access', $insert)
                      ->update([
                          'ma_insert' => 'Y'
                      ]);
                }

                if (!empty($update)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id)
                      ->whereIn('ma_access', $update)
                      ->update([
                          'ma_update' => 'Y'
                      ]);
                }

                if (!empty($delete)) {
                  DB::table('d_mem_access')
                      ->where('ma_mem', '=', $id)
                      ->whereIn('ma_access', $delete)
                      ->update([
                          'ma_delete' => 'Y'
                      ]);
                }

            }

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::commit();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }

    public function hapus(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_mem')
          ->where('m_id', $request->id)
          ->where('m_active', 'Y')
          ->update([
            'm_active' => 'N'
          ]);

        DB::table('d_mem_comp')
          ->where('mc_mem', $request->id)
          ->where('mc_active', 'Y')
          ->update([
            'mc_active' => 'N'
          ]);

        DB::table('d_mem_gudangcomp')
          ->where('mg_mem', $request->id)
          ->where('mg_active', 'Y')
          ->update([
            'mg_active' => 'N'
          ]);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }

}
 /*<button class="btn btn-outlined btn-info btn-sm" type="button" data-target="#detail" data-toggle="modal">Detail</button>*/
