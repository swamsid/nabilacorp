<?php

Route::group(['namespace' => 'App\Modules\Keuangan\Controllers', 'middleware'=>['web','auth']], function () {
	Route::get('/keuangan/spk/spk', 'spkFinancialController@spk');
	Route::get('/keuangan/spk/get-data-tabel-index', 'spkFinancialController@getDataTabelIndex');
	Route::get('/produksi/spk/create-id/{x}', 'spkFinancialController@spkCreateId');
	Route::get('/produksi/lihatadonan/tabel/{id}/{qty}/{comp}', 'spkFinancialController@tabelFormula');
	Route::get('/produksi/spk/draft/simpan-spk', 'spkFinancialController@simpanDraftSpk');
	Route::get('/keuangan/spk/get-data-tabel-spk/{tgl1}/{tgl2}/{tampil}/{comp}', 'spkFinancialController@getDataTabelSpk');
	Route::get('/produksi/spk/edit/{id}', 'spkFinancialController@editSpk');
	Route::get('/produksi/spk/final/simpan-spk', 'spkFinancialController@simpanSpk');
	Route::get('/keuangan/spk/lihat-detail', 'spkFinancialController@detailSpk');
	Route::get('/keuangan/spk/update-status/{id}', 'spkFinancialController@updateStatus');
});

