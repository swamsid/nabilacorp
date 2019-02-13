<?php

Route::group(['namespace' => 'App\Modules\Produksi\Controllers', 'middleware'=>['web','auth']], function () {
	
/* Rencana Produksi */
    Route::get('/produksi/rencanaproduksi/tabel','RencanaProduksiController@tabel');
    Route::get('/produksi/rencanaproduksi/produksi','RencanaProduksiController@produksi');
    Route::get('/produksi/rencanaproduksi/save','RencanaProduksiController@save');
    Route::get('/produksi/rencanaproduksi/hapus_rencana/{id}','RencanaProduksiController@hapus_rencana');
    Route::patch('/produksi/rencanaproduksi/produksi/edit_rencana','RencanaProduksiController@edit_rencana');
    Route::get('/produksi/rencanaproduksi/produksi/autocomplete','RencanaProduksiController@autocomplete');
/* Hasil Rencana Produksi */
/*spk*/
	Route::get('/produksi/spk/spk', 'spkProductionController@spk');
	Route::get('/produksi/spk/get_spk_by_tgl/{tgl1}/{tgl2}/{comp}', 'spkProductionController@getSpkByTgl');
	Route::get('/produksi/spk/get_spk_by_tglCL/{tgl1}/{tgl2}', 'spkProductionController@getSpkByTglCL');
	Route::get('/produksi/spk/lihat-detail', 'spkProductionController@lihatFormula');
	Route::get('/produksi/spk/ubah-status-spk/{id}', 'spkProductionController@ubahStatusSpk');
	Route::get('/produksi/o_produksi/select2/pilihspk/{x}', 'ManOutputProduksiController@selectDataSpk');
	Route::get('produksi/spk/input-data', 'spkProductionController@inputData');
/* selesai spk*/
//mahmud output produksi
	Route::get('/produksi/hasil-produksi/index', 'ManOutputProduksiController@index')->middleware('auth');
	Route::get('/produksi/o_produksi/tabel/{tgl1}/{tgl2}', 'ManOutputProduksiController@tabel');	
	// Route::get('/produksi/o_produksi/select2/spk/{tgl1}/{comp}', 'ManOutputProduksiController@setSpk');
	Route::get('/produksi/o_produksi/store', 'ManOutputProduksiController@store');
//mahmud output produksi
	Route::get('/produksi/bahanbaku/baku', 'produksiController@baku')->middleware('auth');
	Route::get('/produksi/sdm/sdm', 'produksiController@sdm')->middleware('auth');
	Route::get('/produksi/produksi/produksi2', 'produksiController@produksi2')->middleware('auth');
	Route::get('/produksi/waste/waste', 'produksiController@waste')->middleware('auth');		
	Route::get('/produksi/o_produksi/tambah_produksi', 'produksiController@tambah_produksi')->middleware('auth');
//Actual SPK
	Route::get('/produksi/data_actual/tabel/{tgl1}/{tgl2}', 'dataActualController@tableActual');
	Route::get('/produksi/o_produksi/save/actual/{id}', 'spkProductionController@saveActual');
//ITEM PRODUKSI
	Route::get('/seach-item-Produksi', 'hasilProduksiController@seachItemProduksi');
	Route::get('/seach-item-mutasi', 'hasilProduksiController@seachItemMutasi');
	Route::get('/produksi/hasil-produksi/data', 'hasilProduksiController@data')->middleware('auth');
	Route::get('/produksi/hasil-produksi/create', 'hasilProduksiController@create')->middleware('auth');
	Route::POST('/produksi/hasil-produksi/create', 'hasilProduksiController@create')->middleware('auth');
	Route::get('/produksi/hasil-produksi/edit-detail/{id}/edit', 'hasilProduksiController@editDetail')->middleware('auth');		
	Route::get('/produksi/hasil-produksi/detail/{id}', 'hasilProduksiController@detail')->middleware('auth');	
	Route::POST('/produksi/hasil-produksi/update/{id}', 'hasilProduksiController@updateData')->middleware('auth');
	Route::get('/produksi/hasil-produksi/update/{id}', 'hasilProduksiController@updateData')->middleware('auth');
	Route::get('/produksi/hasil-produksi/destroy/{id}', 'hasilProduksiController@destroy')->middleware('auth');
//monitoring order
	Route::get('/produksi/monitoringprogress/monitoring', 'MonitoringProgressController@monitoring');
	Route::get('/produksi/monitoringprogress/tabel', 'MonitoringProgressController@tabel');
	Route::get('/produksi/monitoringprogress/nota/{id}', 'MonitoringProgressController@bukaNota');
	Route::get('/penjualan/monitoringorder/nota/tabel/{id}', 'MonitoringOrderController@nota');
	Route::get('/produksi/monitoringprogress/plan/{id}', 'MonitoringProgressController@plan');
	Route::get('/produksi/monitoringprogress/save', 'MonitoringProgressController@save');
	Route::get('/produksi/monitoringprogress/tabel-filter-monitoring', 'MonitoringProgressController@tabelFilterMonitoring');
	Route::get('/produksi/monitoringprogress/tabel/autoplan', 'MonitoringProgressController@autoPlan');
	Route::get('/produksi/monitoringprogress/save/autoplan', 'MonitoringProgressController@saveAutoPlan');
//monitoring order selesai
//coba print qz
	Route::get('/penjualan/pos-toko/printNote/{id}', 'ProduksiController@printNota')->middleware('auth');

});

