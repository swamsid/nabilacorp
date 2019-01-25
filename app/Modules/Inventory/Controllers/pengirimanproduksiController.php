<?php
namespace App\Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\mMember;
use DB;
use Carbon\Carbon;
use DateTime;
use App\Lib\mutasi;

class pengirimanproduksiController extends Controller {
	public function __construct(){
        $this->middleware('auth');
    }

	public function index()
	{
		$data = DB::table('d_productresult')

						->where('pr_status', 'N')

						/*->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')*/
						->groupBy('pr_id')

						->get();

		/*$datafix = [];

		for ($i=0; $i < count($data); $i++) {
			if ($data[$i]->prdt_qty == $data[$i]->prdt_kirim) {

			} else {
				$datafix[0] = $data[$i];
			}
		}*/

		$tujuan = DB::table('d_gudangcabang')
				  ->join('m_comp','c_id','=','gc_comp')
				  ->where('gc_gudang','GUDANG PENJUALAN')
							->get();

		return view('Inventory::pengiriman.pengirimanproduksi', compact('data', 'tujuan'));
	}

	public function simpan(Request $request){
		return DB::transaction(function () use ($request) {

		if($request->tujuan=='') {
			return response()->json([
				'status' => 'Tujuan Tidak Boleh Kosong'
			]);
		}

			$id = DB::table('d_pengiriman')
						->max('p_id')+1;


			$kode = "";

        $querykode = DB::select(DB::raw("SELECT MAX(MID(p_code,4,3)) as counter, MAX(MID(p_code,8,2)) as bulan, MAX(MID(p_code,10)) as tahun FROM d_pengiriman"));

        if (count($querykode) > 0) {
          if ($querykode[0]->bulan != date('m') || $querykode[0]->tahun != date('Y')) {
              $kode = "001";
          } else {
            foreach($querykode as $k)
              {
                $tmp = ((int)$k->counter)+1;
                $kode = sprintf("%03s", $tmp);
              }
          }
        } else {
          $kode = "001";
        }


        $finalkode = 'PB-' . $kode . '/' . date('m') . date('Y');

				$produksi = DB::table('d_productresult')
										->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
										->where('pr_code', $request->nota)
										->get();

		/*	DB::table('d_productresult')
									->where('pr_code', $request->nota)
									->update([
										'pr_status' => 'Dikirim'
									]);*/

			DB::table('d_pengiriman')
				->insert([
					'p_id' => $id,
					'p_pr' => $request->nota,
					'p_code' => $finalkode,
					/*'p_tanggal_produksi' => $produksi[0]->pr_date,*/
					'p_tanggal_transfer' => Carbon::parse($request->p_tanggal_transfer)->format('Y-m-d'),
					'p_keterangan' => $request->keterangan,
					'p_insert' => Carbon::now('Asia/Jakarta')
				]);


			for ($i=0; $i < count($request->kirim); $i++) {
				$iddt = DB::table('d_pengiriman_dt')
								->max('pd_detailid')+1;

				if ($request->kirim[$i] != 0 || $request->kirim[$i] != null || $request->kirim[$i] != '') {
					$item = DB::table('m_item')
									->where('i_id', $request->item[$i])
									->get();

					$item[0]->i_hpp = str_replace('.','',$item[0]->i_hpp);
					$item[0]->i_hpp = str_replace(',','',$item[0]->i_hpp);

					DB::table('d_pengiriman_dt')
						->insert([
							'pd_pengiriman' => $id,
							'pd_detailid' => $iddt,

							'pd_qty' => $request->kirim[$i],
							'pd_comp' => $request->tujuan,
							'pd_position' => $request->prdt_position[$i],
							'pd_item' => $request->item[$i],
							'pd_hpp' => $request->prdt_hpp[$i],
							'pd_insert' => Carbon::now('Asia/Jakarta')
						]);

					$comp= $request->prdt_comp[$i];
					$position=$request->prdt_position[$i];

					$compTujuan=$request->tujuan;
					$positionTujuan=$request->prdt_position[$i];
					$mutcatTujuan=11;
					$detailTujuan='pengiriman Produksi';
					$date=Carbon::parse($request->p_tanggal_transfer)->format('Y-m-d');

/*dd($request->item[$i].' + '.$request->kirim[$i].' + '.$comp.' + '.$position.' + '.$flag='Penjualan Toko'.' + '.$finalkode.' + '.$ket=''.' + '.$date.' + '.$compTujuan.' + '.$positionTujuan.' + '.$mutcatTujuan.' + '.$detailTujuan);*/


						$simpanMutasi=mutasi::simpanTranferMutasi($request->item[$i],$request->kirim[$i],$comp,$position,$flag='Penjualan Toko',$finalkode,$ket='e',$date,$compTujuan,$positionTujuan,$mutcatTujuan,$detailTujuan);





						$update = DB::table('d_productresult')
											->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
											->where('pr_code', $request->nota)
											->where('prdt_item', $request->item[$i])
											->get();

						if ($update[0]->prdt_kirim == 0) {
						$prdtkirim = $request->kirim[$i]; 	} else {
							$prdtkirim = $request->kirim[$i] + $update[0]->prdt_kirim;
						}

						DB::table('d_productresult_dt')
											->where('prdt_productresult', $update[0]->pr_id)
											->where('prdt_detailid', $update[0]->prdt_detailid)
											->where('prdt_item', $request->item[$i])
											->update([
												'prdt_kirim' => $prdtkirim
							]);

				}
			}



			$produksi = DB::table('d_productresult')
										->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
										->where('pr_code', $request->nota)
										->select(DB::raw('sum(prdt_qty) as prdt_qty,sum(prdt_kirim) as prdt_kirim'))
										->first();
			if($produksi->prdt_qty==$produksi->prdt_kirim){

						$produksi = DB::table('d_productresult')
										->where('pr_code', $request->nota)
										->update([
										'pr_status' => 'Y'
										]);
			}

			return response()->json([
				'status' => 'berhasil'
			]);

		});


	}

	public function getdata(Request $request){
		$data = DB::table('d_productresult')
						->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
						->join('m_item', 'i_id', '=', 'prdt_item')
						->where('pr_id', $request->id)
						->get();

		return response()->json($data);
	}

	public function indexfix(){
		$data = DB::table('d_pengiriman')
						->leftjoin('d_pengiriman_dt', 'pd_pengiriman', '=', 'p_id')
						->groupBy('p_id')
						->get();

		return view('Inventory::pengiriman.index', compact('data'));
	}

	public function hapus(Request $request){
		DB::beginTransaction();
		try {

			$data = DB::table('d_pengiriman')
					->join('d_pengiriman_dt', 'pd_pengiriman', '=', 'p_code')
					->where('p_id', $request->id)
					->get();

					DB::table('d_pengiriman')
							->where('p_id', $request->id)
							->delete();

					DB::table('d_pengiriman_dt')
							->where('pd_pengiriman', $data[0]->p_code)
							->delete();

				$product = DB::table('d_productresult')
							->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
							->where('pr_code', $data[0]->p_pr)
							->get();

							DB::table('d_productresult')
										->where('pr_code', $data[0]->p_pr)
										->update([
											'pr_status' => null
										]);

				for ($i=0; $i < count($data); $i++) {
					DB::table('d_productresult_dt')
							->where('prdt_productresult', '=', $product[$i]->prdt_productresult)
							->where('prdt_item', '=', $data[$i]->pd_item)
							->update([
								'prdt_kirim' => $product[$i]->prdt_kirim - $data[$i]->pd_qty
							]);
				}

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

	public function edit(Request $request){
		$id = $request->id;

		$pengiriman = DB::table('d_pengiriman')
									->join('d_productresult', 'pr_code', '=', 'p_pr')
									->join('d_pengiriman_dt', 'pd_pengiriman', '=', 'p_code')
									->join('m_item', 'i_id', '=', 'pd_item')
									->where('p_id', $request->id)
									->get();

		$produkhasil = DB::table('d_productresult')
										->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
										->join('m_item', 'i_id', '=', 'prdt_item')
										->where('pr_code', '=', $pengiriman[0]->p_code)
										->get();

		$data = DB::table('d_productresult')
						->get();

		$tujuan = DB::table('d_gudangcabang')
							->get();

		return view('Inventory::pengiriman.edit', compact('data', 'tujuan', 'pengiriman', 'produkhasil', 'id'));
	}

	public function update(Request $request){
		DB::beginTransaction();
		try {

			$data = DB::table('d_pengiriman')
					->join('d_pengiriman_dt', 'pd_pengiriman', '=', 'p_code')
					->where('p_id', $request->id)
					->get();

					DB::table('d_pengiriman')
							->where('p_id', $request->id)
							->delete();

					DB::table('d_pengiriman_dt')
							->where('pd_pengiriman', $data[0]->p_code)
							->delete();

				$product = DB::table('d_productresult')
							->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
							->where('pr_code', $data[0]->p_pr)
							->get();

							DB::table('d_productresult')
										->where('pr_code', $data[0]->p_pr)
										->update([
											'pr_status' => null
										]);

				for ($i=0; $i < count($data); $i++) {
					DB::table('d_productresult_dt')
							->where('prdt_productresult', '=', $product[$i]->prdt_productresult)
							->where('prdt_item', '=', $data[$i]->pd_item)
							->update([
								'prdt_kirim' => $product[$i]->prdt_kirim - $data[$i]->pd_qty
							]);
				}

				$id = DB::table('d_pengiriman')
							->max('p_id');

				if ($id < 0) {
					$id = 0;
				}

	        $finalkode = $request->p_code;

					$produksi = DB::table('d_productresult')
											->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
											->where('pr_code', $request->nota)
											->get();

				DB::table('d_productresult')
										->where('pr_code', $request->nota)
										->update([
											'pr_status' => 'Dikirim'
										]);

				DB::table('d_pengiriman')
					->insert([
						'p_id' => $id + 1,
						'p_pr' => $produksi[0]->pr_code,
						'p_code' => $finalkode,
						'p_tanggal_produksi' => $produksi[0]->pr_date,
						'p_tanggal_transfer' => Carbon::parse(date($request->p_tanggal_transfer))->format('Y-m-d'),
						'p_keterangan' => $request->keterangan,
						'p_insert' => Carbon::now('Asia/Jakarta')
					]);

				for ($i=0; $i < count($request->kirim); $i++) {
					$iddt = DB::table('d_pengiriman_dt')
									->max('pd_id');

							if ($iddt < 0) {
								$iddt = 0;
							}

					if ($request->kirim[$i] != 0 || $request->kirim[$i] != null || $request->kirim[$i] != '') {
						DB::table('d_pengiriman_dt')
							->insert([
								'pd_id' => $iddt + 1,
								'pd_pengiriman' => $finalkode,
								'pd_qty' => $request->kirim[$i],
								'pd_comp' => $produksi[$i]->prdt_comp,
								'pd_position' => $request->tujuan,
								'pd_item' => $request->item[$i],
								'pd_insert' => Carbon::now('Asia/Jakarta')
							]);

							$update = DB::table('d_productresult')
												->join('d_productresult_dt', 'prdt_productresult', '=', 'pr_id')
												->where('pr_code', $request->nota)
												->where('prdt_item', $request->item[$i])
												->get();

							if ($update[0]->prdt_kirim == 0) {
								DB::table('d_productresult_dt')
													->where('prdt_productresult', $update[0]->pr_id)
													->where('prdt_detailid', $update[0]->prdt_detailid)
													->where('prdt_item', $request->item[$i])
													->update([
														'prdt_kirim' => $request->kirim[$i]
													]);
							} else {
								$kurang = $request->kirim[$i] + $update[0]->prdt_kirim;
								DB::table('d_productresult_dt')
													->where('prdt_productresult', $update[0]->pr_id)
													->where('prdt_detailid', $update[0]->prdt_detailid)
													->where('prdt_item', $request->item[$i])
													->update([
														'prdt_kirim' => $kurang
													]);
							}
					}
				}

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
