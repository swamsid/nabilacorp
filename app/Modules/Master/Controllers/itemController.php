<?php

namespace App\Modules\Master\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_customer;
use App\m_satuan;
use App\m_group;
use App\m_price;
use App\m_itemm;
use Carbon\carbon;
use App\Http\Controllers\Controller;

use DB;
use File;
use Storage;
use Datatables;


use Auth;






class itemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
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

    public function contoh_dokumen() {
      $filename = public_path('print_queue.txt');
      $content = File::get($filename);
      Storage::put('print_queue.txt', '["Your name", "My Name"]');
      $data = Storage::get('print_queue.txt') ;
      
      $res = ['data' => $data];
      return response()->json($res)->header('Filename', 'Echo.txt');
      // $headers = [
      //     'Content-Type' => 'application/text'
      // ];
      // $file = public_path('..\assets\contoh_dokumen.pdf');

      // return response()->download($file, 'contoh_dokumen.pdf', $headers);
    }

    public function index(){
      return view('Master::databarang/barang');
    }
    public function dataBarang(){
      return m_itemm::dataBarang();
    }


    public function tambah(){
      $kelompok = DB::table('m_group')
                  ->get();

      $satuan = DB::table('m_satuan')
                ->get();

      return view('Master::databarang/tambah_barang', compact('kelompok','satuan'));
    }

    public function Supplier(){
      $supplier = DB::table('m_supplier')
                  ->get();

      return response()->json($supplier);
    }

    public function simpan(Request $request){
      DB::beginTransaction();
      try {

        $id = DB::table('m_item')
              ->max('i_id');

        $tmp = $id + 1;

        $kode = sprintf("%04s", $tmp);
        $i_code = 'BRG' . $kode;
        $i_group = $request->i_group;
        $i_group = $i_group != null ? $i_group : '';
        $i_type = $request->i_type;
        $i_type = $i_type != null ? $i_type : '';
        $i_name = $request->i_name;
        $i_name = $i_name != null ? $i_name : '';
        $i_det = $request->i_det;
        $i_det = $i_det != null ? $i_det : '';
        $i_sat1 = $request->i_sat1;
        $i_sat1 = $i_sat1 != null ? $i_sat1 : '';
        $i_sat2 = $request->i_sat2;
        $i_sat2 = $i_sat2 != null ? $i_sat2 : '';
        $i_sat3 = $request->i_sat3;
        $i_sat3 = $i_sat3 != null ? $i_sat3 : '';
        $i_sat_isi1 = $request->i_sat_isi1;
        $i_sat_isi1 = $i_sat_isi1 != null ? $i_sat_isi1 : '';
        $i_sat_isi2 = $request->i_sat_isi2;
        $i_sat_isi2 = $i_sat_isi2 != null ? $i_sat_isi2 : '';
        $i_sat_isi3 = $request->i_sat_isi3;
        $i_sat_isi3 = $i_sat_isi3 != null ? $i_sat_isi3 : '';
        $i_min_stock = $request->i_min_stock;
        $i_min_stock = $i_min_stock != null ? $i_min_stock : '';
        
        $is_price1 = $request->is_price1;
        $is_price1 = $is_price1 != null ? $is_price1 : '';
        $is_price2 = $request->is_price2;
        $is_price2 = $is_price2 != null ? $is_price2 : '';
        $is_price3 = $request->is_price3;
        $is_price3 = $is_price3 != null ? $is_price3 : '';
        // Ke tabel d_item_supplier
        $is_supplier = $request->is_supplier;
        $is_supplier = $is_supplier != null ? $is_supplier : array();
        // $is_price = $request->is_price;
        // $is_price = $is_price != null ? $is_price : array();
        // ===============================================
        // if (!empty($request->supplier)) {
        //   for ($i=0; $i < count($request->supplier); $i++) {
        //     $tmp = str_replace('.', '', $request->hargasupplier[$i]);
        //     $hargasupplier = str_replace('Rp ', '', $tmp);

        //     $idsupplier = DB::table('d_item_supplier')
        //                   ->max('is_id');


        //       DB::table('d_item_supplier')
        //       ->insert([
        //         'is_id' => $idsupplier + 1,
        //         'is_item' => $id + 1,
        //         'is_supplier' => $request->supplier[$i],
        //         'is_price' => $hargasupplier,
        //         'is_active' => 'Y'
        //       ]);
        //   }
        // }

        DB::table('m_item')
          ->insert([
            'i_id' => $tmp,
            'i_code' => $i_code,
            'i_group' => $i_group,
            'i_type' => $i_type,
            'i_name' => $i_name,
            'i_sat1' => $i_sat1,
            'i_sat2' => $i_sat2,
            'i_sat3' => $i_sat3,
            'i_sat_isi1' => $i_sat_isi1,
            'i_sat_isi2' => $i_sat_isi2,
            'i_sat_isi3' => $i_sat_isi3,
            'i_min_stock' => $i_min_stock,
            'i_det' => $i_det,            
            'i_active' => 'Y',
            'i_insert' => Carbon::now('Asia/Jakarta')
          ]);
      

        for($x = 0; $x < count($is_supplier);$x++) {
          DB::table('d_item_supplier')
            ->insert([
              'is_item' => $tmp,
              'is_supplier' => $is_supplier[$x],
              'is_price1' => $is_price1,
              'is_price2' => $is_price2,
              'is_price3' => $is_price3,
              'is_active' => 'Y',
              'is_created' => Carbon::now('Asia/Jakarta')
            ]);
        }


        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal. '. $e
        ]);
      }

    }

    public function edit($id){

      $m_item = DB::table('m_item')
                    ->leftjoin('m_group', 'i_group', '=', 'g_id')
                    ->leftjoin(DB::raw('m_satuan S1'), 'i_sat1', '=', 'S1.s_id')
                    ->leftjoin(DB::raw('m_satuan S2'), 'i_sat2', '=', 'S2.s_id')
                    ->leftjoin(DB::raw('m_satuan S3'), 'i_sat3', '=', 'S3.s_id')
                    ->where('i_id', $id)
                    ->first();
      $m_group = m_group::all();                    
      $m_satuan = m_satuan::all();                    
      $d_item_supplier = DB::table('d_item_supplier')
        ->leftjoin('m_supplier', 'is_supplier', '=', 's_id')->where('is_item', $id)->get();
      $res = array(
        'm_item' => $m_item, 
        'd_item_supplier' => $d_item_supplier, 
        'kelompok' => $m_group, 
        'satuan' => $m_satuan
      );
      
      // die(json_encode($res));
      return view('Master::databarang/edit_barang', $res);
    }

    public function update(Request $request){

      DB::beginTransaction();
      try {

        $i_id = $request->i_id;
        $i_id = $i_id != null ? $i_id : '';
        $i_group = $request->i_group;
        $i_group = $i_group != null ? $i_group : '';
        $i_type = $request->i_type;
        $i_type = $i_type != null ? $i_type : '';
        $i_name = $request->i_name;
        $i_name = $i_name != null ? $i_name : '';
        $i_det = $request->i_det;
        $i_det = $i_det != null ? $i_det : '';
        $i_sat1 = $request->i_sat1;
        $i_sat1 = $i_sat1 != null ? $i_sat1 : '';
        $i_sat2 = $request->i_sat2;
        $i_sat2 = $i_sat2 != null ? $i_sat2 : '';
        $i_sat3 = $request->i_sat3;
        $i_sat3 = $i_sat3 != null ? $i_sat3 : '';
        $i_sat_isi1 = $request->i_sat_isi1;
        $i_sat_isi1 = $i_sat_isi1 != null ? $i_sat_isi1 : '';
        $i_sat_isi2 = $request->i_sat_isi2;
        $i_sat_isi2 = $i_sat_isi2 != null ? $i_sat_isi2 : '';
        $i_sat_isi3 = $request->i_sat_isi3;
        $i_sat_isi3 = $i_sat_isi3 != null ? $i_sat_isi3 : '';
        $i_min_stock = $request->i_min_stock;
        $i_min_stock = $i_min_stock != null ? $i_min_stock : '';
        // Ke tabel m_price
        $is_price1 = $request->is_price1;
        $is_price1 = $is_price1 != null ? $is_price1 : '';
        $is_price2 = $request->is_price2;
        $is_price2 = $is_price2 != null ? $is_price2 : '';
        $is_price3 = $request->is_price3;
        $is_price3 = $is_price3 != null ? $is_price3 : '';
        // Ke tabel m_supplier
        $is_supplier = $request->is_supplier;
        $is_supplier = $is_supplier != null ? $is_supplier : array();
        
        // ===============================================
        // if (!empty($request->supplier)) {
        //   for ($i=0; $i < count($request->supplier); $i++) {
        //     $tmp = str_replace('.', '', $request->hargasupplier[$i]);
        //     $hargasupplier = str_replace('Rp ', '', $tmp);

        //     $idsupplier = DB::table('d_item_supplier')
        //                   ->max('is_id');


        //       DB::table('d_item_supplier')
        //       ->insert([
        //         'is_id' => $idsupplier + 1,
        //         'is_item' => $id + 1,
        //         'is_supplier' => $request->supplier[$i],
        //         'is_price' => $hargasupplier,
        //         'is_active' => 'Y'
        //       ]);
        //   }
        // }

        DB::table('m_item')
          ->where('i_id', $i_id)
          ->update([
            'i_group' => $i_group,
            'i_type' => $i_type,
            'i_name' => $i_name,
            'i_sat1' => $i_sat1,
            'i_sat2' => $i_sat2,
            'i_sat3' => $i_sat3,
            'i_sat_isi1' => $i_sat_isi1,
            'i_sat_isi2' => $i_sat_isi2,
            'i_sat_isi3' => $i_sat_isi3,
            'i_min_stock' => $i_min_stock,
            'i_det' => $i_det,
            'i_update' => Carbon::now('Asia/Jakarta')
          ]);
      
        
        // Ke tabel d_item_supplier
        DB::table('d_item_supplier')->where('is_item', $i_id)->delete();
        for($x = 0; $x < count($is_supplier);$x++) {
          DB::table('d_item_supplier')
            ->insert([
              'is_item' => $i_id,
              'is_supplier' => $is_supplier[$x],
              'is_price1' => $is_price1,
              'is_price2' => $is_price2,
              'is_price3' => $is_price3,
              'is_active' => 'Y',
              'is_updated' => Carbon::now('Asia/Jakarta')
            ]);
        }

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal. ' . $e
        ]);
      }
    }

    public function hapus(Request $request){
      DB::beginTransaction();
      try {

        DB::table('d_item_supplier')
          ->where('is_item', $request->id)
          ->update([
            'is_active' => 'N'
          ]);

        DB::table('m_item')
          ->where('i_id', $request->id)
          ->update([
            'i_active' => 'N',            
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
