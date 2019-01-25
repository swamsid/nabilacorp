<?php
namespace App\Modules\Inventory\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\m_customer;
use Carbon\carbon;
use DB;

use Datatables;

use App\Http\Inventory\model\d_mutasi_item;

use Session;

use App\Lib\format;
	

use App\Lib\mutasi;

use App\Modules\POS\Controllers\mutasiItemController;

use Response;

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

class mutasiitembakuController extends Controller {
	public function __construct(){
        $this->middleware('auth');
    }

	public function index(){
			$mutasiItem=view('Inventory::mutasiitembaku/mutasi_item');
			$form=view('Inventory::mutasiitembaku/form-mutasi');

			return view('Inventory::mutasiitembaku.mutasi',compact('mutasiItem','form'));
	}

	public function dataMutasiItem(Request $request)
	{
		return d_mutasi_item::mutasiItem($request);
	}

	public function store(Request $request){
		return DB::transaction(function () use ($request) {
$mi_id=DB::table('d_mutasi_item')->max('mi_id')+1;



$query = DB::select(DB::raw("SELECT MAX(RIGHT(mi_code,4)) as kode_max from d_mutasi_item WHERE DATE_FORMAT(mi_created, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')"));
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


 $mi_code = "MI-".date('ym')."-".$kd;

 $mp_code = "MP-".date('ym')."-".$kd;
 DB::table('d_mutasi_item')->insert([
			 'mi_id'=>$mi_id,
			 'mi_comp'=>Session::get('user_comp'),
			 'mi_code'=>$mi_code,
			 'mi_date'=>date('Y-m-d',strtotime($request->mi_date)),
			 'mi_keterangan'=>$request->mi_keterangan,
			 'mi_created'=> date('Y-m-d H:i:s'),
	 ]);


 $jumlah=count($request->mm_item);
for ($i=0; $i <$jumlah ; $i++) {

	     $mm_comp=$request->mm_comp[$i];
        $mm_position=$request->mm_position[$i];

        if(mutasi::mutasiStok($request->mm_item[$i],format::format($request->mm_qty[$i]),$mm_comp,$mm_position,$flag='',$mi_id,$flagTujuan='Mutasi Item Bahan Baku Pengeluaran',$idMutasiTujuan='')){


			 $mm_detailid=DB::table('d_mutationitem_material')->where('mm_mutationitem',$mi_id)
													->max('mm_detailid')+1;
			 $mm_qty= format::format($request->mm_qty[$i]);
			 DB::table('d_mutationitem_material')->insert([
					 'mm_mutationitem'=>$mi_id,
					 'mm_detailid'=>$mm_detailid,
					 'mm_comp'=>$mm_comp,
					 'mm_position'=>$mm_position,
					 'mm_item'=>$request->mm_item[$i],
					 'mm_qty'=>$mm_qty
			 ]);

	}
      else{


            $data=['status'=>'gagal','data'=>'Stok tidak mencukupi.'];
            DB::rollBack();
            return $data;
      }
}


$jumlah=count($request->mp_item);
for ($s=0; $s <$jumlah ; $s++) {
	 $mp_comp=$request->mp_comp[$s];
	 $mp_position=$request->mp_position[$s];
	 $mp_hpp= format::format($request->mp_hpp[$s]);
	 $mp_detailid=DB::table('d_mutationitem_product')->where('mp_mutationitem',$mi_id)
																->max('mp_detailid')+1;
			 $mp_qty=format::format($request->mp_qty[$s]);
			 DB::table('d_mutationitem_product')->insert([
							 'mp_mutationitem'=>$mi_id,
							 'mp_detailid'=>$mp_detailid,
							 'mp_comp'=>$mm_comp,
							 'mp_position'=>$mm_position,
							 'mp_item'=>$request->mp_item[$s],
							 'mp_qty'=>$mp_qty,
							 'mp_hpp'=>$mp_hpp,
				 ]);

			  

	mutasi::tambahmutasi($request->mp_item[$s],$mp_qty,$mp_comp,$mp_position,'Mutasi Item Bahan Baku Penambahan',15,$mi_code,'','',$mp_hpp,date('Y-m-d',strtotime($request->mi_date)));

	 }

		 $data=['status'=>'sukses','data'=>'sukses'];
		 return json_encode($data);
 });
}


	public function perbarui(Request $request,$id){
		return DB::transaction(function () use ($request, $id) {

			$mic = new mutasiItemController;
			$mic->destroy($id);

$mi_id=DB::table('d_mutasi_item')->max('mi_id')+1;


 DB::table('d_mutasi_item')->insert([
			 'mi_id'=>$mi_id,
			 'mi_comp'=>Session::get('user_comp'),
			 'type' => 'BB',
			 'mi_code'=>$request->mi_code,
			 'mi_date'=>date('Y-m-d',strtotime($request->mi_date)),
			 'mi_keterangan'=>$request->mi_keterangan,
	 ]);


 $jumlah=count($request->mm_item);
for ($i=0; $i <$jumlah ; $i++) {
	 $mm_comp=$request->mm_comp[$i];
	 $mm_position=$request->mm_position[$i];

			 $mm_detailid=DB::table('d_mutationitem_material')->where('mm_mutationitem',$mi_id)
													->max('mm_detailid')+1;
			 $mm_qty= format::format($request->mm_qty[$i]);
			 DB::table('d_mutationitem_material')->insert([
					 'mm_mutationitem'=>$mi_id,
					 'mm_detailid'=>$mm_detailid,
					 'mm_comp'=>$mm_comp,
					 'mm_position'=>$mm_position,
					 'mm_item'=>$request->mm_item[$i],
					 'mm_qty'=>$mm_qty
			 ]);

		$stock = DB::table('d_stock')
								->where('s_comp', $mm_comp)
								->where('s_position', $mm_position)
								->where('s_item', $request->mm_item[$i])
								->first();

			DB::table('d_stock')
					->where('s_comp', $mm_comp)
					->where('s_position', $mm_position)
					->where('s_item', $request->mm_item[$i])
					->update([
						's_qty' => $stock->s_qty - $request->mm_qty[$i]
					]);
}


$jumlah=count($request->mp_item);
for ($s=0; $s <$jumlah ; $s++) {
	 $mp_comp=$request->mp_comp[$s];
	 $mp_position=$request->mp_position[$s];
	 $mp_hpp= format::format($request->mp_hpp[$s]);
	 $mp_detailid=DB::table('d_mutationitem_product')->where('mp_mutationitem',$mi_id)
																->max('mp_detailid')+1;
			 $mp_qty=format::format($request->mp_qty[$s]);
			 DB::table('d_mutationitem_product')->insert([
							 'mp_mutationitem'=>$mi_id,
							 'mp_detailid'=>$mp_detailid,
							 'mp_comp'=>$mm_comp,
							 'mp_position'=>$mm_position,
							 'mp_item'=>$request->mp_item[$s],
							 'mp_qty'=>$mp_qty,
							 'mp_hpp'=>$mp_hpp,
				 ]);

				 $stock = DB::table('d_stock')
										 ->where('s_comp', $mp_comp)
										 ->where('s_position', $mp_position)
										 ->where('s_item', $request->mp_item[$s])
										 ->first();

					 DB::table('d_stock')
							 ->where('s_comp', $mp_comp)
							 ->where('s_position', $mp_position)
							 ->where('s_item', $request->mp_item[$s])
							 ->update([
								 's_qty' => $stock->s_qty + $request->mp_qty[$s]
							 ]);

	 }

		 $data=['status'=>'sukses','data'=>'sukses'];
		 return json_encode($data);
 });
	}

	function mutasiItemDt($id,Request $request){
		$chek=$request->type;
			if($chek=='Bahan'){
				$status=$request->s_status;
				$data=d_mutationitem_material::mutasiItemDt($id);
				$tamp=[];
				foreach ($data as $key => $value) {
						$tamp[$key]=$value->i_id;
				}
				$tamp=array_map("strval",$tamp);
				return view('Inventory::mutasiitembaku/editDetailBahan',compact('data','tamp','status'));
			}

			else if($chek=='Hasil'){
				$status=$request->s_status;
				$data=d_mutationitem_product::mutasiItemDt($id);
				$tamp=[];
				foreach ($data as $key => $value) {
						$tamp[$key]=$value->i_id;
				}
				$tamp=array_map("strval",$tamp);
				return view('Inventory::mutasiitembaku/editDetailHasil',compact('data','tamp','status'));
			}
	}

	function destroy($id){
		$mic = new mutasiItemController;
		$mic->destroy($id);
	}

	public function searchItem(Request $request){
		$search = $request->term;

		$cabang=Session::get('user_comp');
		$position=DB::table('d_gudangcabang')
									->where('gc_gudang','GUDANG BAHAN BAKU')
									->where('gc_comp',$cabang)
									->select('gc_id')->first();

		$comp=$position->gc_id;
		$position=$position->gc_id;

		$groupName=['BB'];

		$sql=DB::table('m_item')
				 ->leftjoin('d_stock',function($join) use ($comp,$position) {
							$join->on('s_item','=','i_id');
							$join->where('s_comp',$comp);
							$join->where('s_position',$position);


				 })
				 ->leftJoin('m_satuan','m_satuan.s_id','=','i_satuan')
				 /*->join('m_group','g_id','=','i_group')*/
				 ->select('i_id','i_name','m_satuan.s_name as s_name','i_price','s_qty','i_code');


		if($search!=''){
				$sql->where(function ($query) use ($search,$groupName) {
							$query->where('i_name','like','%'.$search.'%');
							$query->whereIn('i_type',$groupName);

							$query->orWhere('i_code','like','%'.$search.'%');
							$query->whereIn('i_type',$groupName);
							});
							}
		else{
			$results[] = [ 'id' => null, 'label' =>'Data belum lengkap'];
			return Response::json($results);
		}

		$sql=$sql->get();



		$results = array();

		if (count($sql)==0) {
			$results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
		} else {
			foreach ($sql as $data)
			{
				$results[] = ['label' => $data->i_name.'  (Rp. ' .number_format($data->i_price,0,',','.').')', 'i_id' => $data->i_id,'satuan' =>$data->s_name,'stok' =>number_format($data->s_qty,0,',','.'),'i_code' =>$data->i_code,'i_price' =>number_format($data->i_price,0,',','.'),'item' => $data->i_name ,'position'=>$position,
					'comp'=>$comp];
			}
		}
		return Response::json($results);

	}
}
