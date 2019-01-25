<?php
Route::group(['namespace' => 'App\Modules\Nabila\Controllers', 'middleware'=>['web','auth']], function () {
	// Nabila Moslem

	Route::get('/nabila/belanjamember/index', 'BelanjaMemberController@posPesanan')->middleware('auth');
	Route::get('/nabila/belanjamember/create', 'BelanjaMemberController@create')->middleware('auth');
	Route::get('/nabila/belanjamember/update', 'BelanjaMemberController@update')->middleware('auth');
	Route::get('/nabila/belanjamember/serah-terima', 'BelanjaMemberController@serahTerima')->middleware('auth');

	Route::get('/nabila/belanjamember/{id}/edit', 'BelanjaMemberController@nabilaDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjamember/detail-view/{id}', 'BelanjaMemberController@penjualanViewDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjamember/listPenjualan', 'BelanjaMemberController@listPenjualanPesanan')->middleware('auth');
	Route::post('/nabila/belanjamember/listPenjualan', 'BelanjaMemberController@listPenjualanPesanan')->middleware('auth');
	Route::get('/nabila/belanjamember/listPenjualan/data', 'BelanjaMemberController@listPenjualanDataPesanan')->middleware('auth');
	Route::get('/nabila/belanjamember/printNota/{id}', 'BelanjaMemberController@printNotaPesanan')->middleware('auth');
	Route::get('/nabila/belanjamember/find_customer', 'BelanjaMemberController@find_customer')->middleware('auth');
	Route::get('/nabila/belanjamember/delete/{id}', 'BelanjaMemberController@delete')->middleware('auth')->name('delete_belanjamember');


	Route::get('/nabila/belanjakaryawan/index', 'BelanjaKaryawanController@posPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/create', 'BelanjaKaryawanController@create')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/update', 'BelanjaKaryawanController@update')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/serah-terima', 'BelanjaKaryawanController@serahTerima')->middleware('auth');

	Route::get('/nabila/belanjakaryawan/{id}/edit', 'BelanjaKaryawanController@nabilaDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/detail-view/{id}', 'BelanjaKaryawanController@penjualanViewDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/listPenjualan', 'BelanjaKaryawanController@listPenjualanPesanan')->middleware('auth');
	Route::post('/nabila/belanjakaryawan/listPenjualan', 'BelanjaKaryawanController@listPenjualanPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/listPenjualan/data', 'BelanjaKaryawanController@listPenjualanDataPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/printNota/{id}', 'BelanjaKaryawanController@printNotaPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/find_pegawai', 'BelanjaKaryawanController@find_pegawai')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/delete/{id}', 'BelanjaKaryawanController@delete')->middleware('auth')->name('delete_belanjakaryawan');

	// Section belanja reseller
	Route::get('/nabila/belanjareseller/index', 'BelanjaResellerController@posPesanan')->middleware('auth')->name('index_belanjareseller');
	Route::get('/nabila/belanjareseller/create', 'BelanjaResellerController@create')->middleware('auth');
	Route::get('/nabila/belanjareseller/update', 'BelanjaResellerController@update')->middleware('auth');
	Route::get('/nabila/belanjareseller/serah-terima', 'BelanjaResellerController@serahTerima')->middleware('auth');
	Route::get('/nabila/belanjareseller/{id}/edit', 'BelanjaResellerController@nabilaDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjareseller/detail-view/{id}', 'BelanjaResellerController@penjualanViewDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjareseller/listPenjualan', 'BelanjaResellerController@listPenjualanPesanan')->middleware('auth');
	Route::post('/nabila/belanjareseller/listPenjualan', 'BelanjaResellerController@listPenjualanPesanan')->middleware('auth');
	Route::get('/nabila/belanjareseller/listPenjualan/data', 'BelanjaResellerController@listPenjualanDataPesanan')->middleware('auth');
	Route::get('/nabila/belanjareseller/printNota/{id}', 'BelanjaResellerController@printNotaPesanan')->middleware('auth');
	Route::get('/nabila/belanjareseller/find_pegawai', 'BelanjaResellerController@find_pegawai')->middleware('auth');
	Route::get('/nabila/belanjareseller/update_s_status', 'BelanjaResellerController@update_s_status')->middleware('auth')->name('update_s_status_belanjareseller');
	Route::get('/nabila/belanjareseller/delete/{id}', 'BelanjaResellerController@delete')->middleware('auth')->name('delete_belanjareseller');


	// Section belanja marketing
	Route::get('/nabila/belanjamarketing/index', 'BelanjaMarketingController@posPesanan')->middleware('auth')->name('index_belanjamarketing');
	Route::get('/nabila/belanjamarketing/create', 'BelanjaMarketingController@create')->middleware('auth');
	Route::get('/nabila/belanjamarketing/update', 'BelanjaMarketingController@update')->middleware('auth');
	Route::get('/nabila/belanjamarketing/serah-terima', 'BelanjaMarketingController@serahTerima')->middleware('auth');
	Route::get('/nabila/belanjamarketing/{id}/edit', 'BelanjaMarketingController@nabilaDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjamarketing/detail-view/{id}', 'BelanjaMarketingController@penjualanViewDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjamarketing/listPenjualan', 'BelanjaMarketingController@listPenjualanPesanan')->middleware('auth');
	Route::post('/nabila/belanjamarketing/listPenjualan', 'BelanjaMarketingController@listPenjualanPesanan')->middleware('auth');
	Route::get('/nabila/belanjamarketing/listPenjualan/data', 'BelanjaMarketingController@listPenjualanDataPesanan')->middleware('auth');
	Route::get('/nabila/belanjamarketing/printNota/{id}', 'BelanjaMarketingController@printNotaPesanan')->middleware('auth');
	Route::get('/nabila/belanjamarketing/find_pegawai', 'BelanjaMarketingController@find_pegawai')->middleware('auth');
	Route::get('/nabila/belanjamarketing/delete/{id}', 'BelanjaMarketingController@delete')->middleware('auth')->name('delete_belanjamarketing');
	Route::get('/nabila/belanjamarketing/update_s_status', 'BelanjaMarketingController@update_s_status')->middleware('auth')->name('update_s_status_belanjamarketing');


});

