<?php

Route::group(['namespace' => 'App\Modules\Inventory\Controllers', 'middleware'=>['web','auth']], function () {
	//versi baru
	Route::get('/inventory/pengirimanproduksi/pengirimanproduksi', 'PengambilanItemController@index');
	Route::get('/produksi/suratjalan/create/delivery/{comp}', 'PengambilanItemController@tabelDelivery');
	Route::get('/produksi/pengambilanitem/kirim/tabel/{tgl1}/{tgl2}/{comp}', 'PengambilanItemController@tabelKirim');
	Route::get('/produksi/pengambilanitem/cari/tabel/{tgl1}/{tgl2}/{comp}', 'PengambilanItemController@tabelKirim');
	Route::get('/produksi/suratjalan/save', 'PengambilanItemController@store');
	Route::get('/produksi/pengambilanitem/lihat/id', 'PengambilanItemController@orderId');
	Route::get('/produksi/pengambilanitem/itemkirim/tabel/{id}', 'PengambilanItemController@itemTabelKirim');

	Route::get('/inventory/p_hasilproduksi/produksi', 'PenerimaanBrgProdController@index');
	Route::get('/inventory/p_hasilproduksi/get_data_sj/{comp}', 'PenerimaanBrgProdController@get_data_sj');
	Route::get('/inventory/p_hasilproduksi/terima', 'penerimaanController@terima');
	Route::get('/inventory/p_hasilproduksi/list_sj', 'PenerimaanBrgProdController@list_sj');
	Route::get('/inventory/p_hasilproduksi/get_tabel_data/{id}', 'PenerimaanBrgProdController@get_tabel_data');
	Route::get('/inventory/p_hasilproduksi/terima_hasil_produksi/{id}/{id2}', 'PenerimaanBrgProdController@terima_hasil_produksi');
	Route::get('/inventory/p_hasilproduksi/simpan_update_data', 'PenerimaanBrgProdController@simpan_update_data');
	Route::get('/inventory/p_hasilproduksi/get_penerimaan_by_tgl/{tgl1}/{tgl2}/{akses}/{comp}', 'PenerimaanBrgProdController@get_penerimaan_by_tgl');

	Route::get('/inventory/mutasiitembaku/index', 'mutasiitembakuController@index');
	Route::get('/inventory/mutasiitembaku/searchItem', 'mutasiitembakuController@searchItem');
	Route::get('/inventory/mutasiitembaku/data-mutasi', 'mutasiitembakuController@dataMutasiItem');
	Route::get('/inventory/mutasiitembaku/tambah-mutasi-item', 'mutasiitembakuController@tambahMutasiItem');
	Route::get('/inventory/mutasiitembaku/store', 'mutasiitembakuController@store');
	Route::get('/inventory/mutasiitembaku/perbarui/{id}', 'mutasiitembakuController@perbarui');
	Route::get('/inventory/mutasiitembaku/mutasi-item-detail/{id}', 'mutasiitembakuController@mutasiItemDt');
	Route::get('/inventory/mutasiitembaku/destroy/{id}', 'mutasiitembakuController@destroy');

//mahmud opnme
	Route::get('/inventory/stockopname/opname', 'stockOpnameController@index');
	Route::get('/inventory/namaitem/autocomplite/{comp}/{position}', 'stockOpnameController@tableOpname');
	Route::get('/inventory/namaitem/simpanopname', 'stockOpnameController@saveOpname');
	Route::get('/inventory/namaitem/history/{tgl1}/{tgl2}', 'stockOpnameController@history');
	Route::get('/inventory/namaitem/detail', 'stockOpnameController@getOPname');
	Route::get('/inventory/stockopname/print_stockopname/{id}', 'stockOpnameController@print_stockopname');
//stok gudang
	Route::get('/inventory/stockgudang/index', 'stockGudangController@index');
	Route::get('/inventory/namaitem/tablegudang/{x}', 'stockGudangController@tableGudang');
	

//barang di gumakam
	Route::get('/inventory/b_digunakan/barang', 'PemakaianBrgGdgController@barang');
	Route::get('/inventory/b_digunakan/get-pemakaian-by-tgl/{tgl1}/{tgl2}/{comp}', 'PemakaianBrgGdgController@getPemakaianByTgl');
	Route::get('/inventory/b_digunakan/autocomplete-barang', 'PemakaianBrgGdgController@autocompleteBarang');
	Route::post('/inventory/b_digunakan/simpan-data-pakai', 'PemakaianBrgGdgController@simpanDataPakai');

	Route::get('/inventory/penerimaan_suplier/suplier', 'penerimaanController@index')->middleware('auth');
	Route::get('/inventory/penerimaan_suplier/suplier_cari/{id}', 'penerimaanController@suplier_cari')->middleware('auth');
	Route::get('/inventory/penerimaan_suplier/suplier_save', 'penerimaanController@suplier_save')->middleware('auth');
	Route::get('/inventory/penerimaan_suplier/suplier_datatable', 'penerimaanController@suplier_datatable')->middleware('auth');
	/*Route::get('/inventory/p_hasilproduksi/produksi', 'penerimaanController@produksi')->middleware('auth');*/
	Route::get('/inventory/p_returncustomer/cust', 'penerimaanControllerr@cust')->middleware('auth');

//penerimaan supplier
	Route::get('/inventory/p_suplier/suplier', 'PenerimaanBrgSupController@index')->middleware('auth');
	Route::get('/inventory/p_suplier/get-penerimaan-by-tgl/{tgl1}/{tgl2}/{akses}/{comp}', 'PenerimaanBrgSupController@get_penerimaan_by_tgl');
	Route::get('/inventory/p_suplier/lookup-data-pembelian', 'PenerimaanBrgSupController@lookupDataPembelian');
	Route::get('/inventory/p_suplier/get-data-form/{id}', 'PenerimaanBrgSupController@getdataform');
	Route::get('/inventory/p_suplier/get-data-detail/{id}', 'PenerimaanBrgSupController@getdatadetail');
	Route::get('/inventory/p_suplier/simpan-penerimaan', 'PenerimaanBrgSupController@simpan_penerimaan');


});
