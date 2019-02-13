<?php
Route::group(['namespace' => 'App\Modules\Nabila\Controllers', 'middleware'=>['web','auth']], function () {
	// Nabila Moslem

	Route::get('/nabila/belanjamember/index', 'BelanjaMemberController@posPesanan')->middleware('auth');
	Route::get('/nabila/belanjamember/create', 'BelanjaMemberController@create')->middleware('auth');
	Route::get('/nabila/belanjamember/update', 'BelanjaMemberController@update')->middleware('auth');
	Route::get('/nabila/belanjamember/serah-terima', 'BelanjaMemberController@serahTerima')->middleware('auth');

	Route::get('/nabila/belanjamember/item', 'BelanjaMemberController@item')->middleware('auth')->name('item_belanjamember');
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
	Route::get('/nabila/belanjakaryawan/item', 'BelanjaKaryawanController@item')->middleware('auth')->name('item_belanjakaryawan');
	Route::get('/nabila/belanjakaryawan/{id}/edit', 'BelanjaKaryawanController@nabilaDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/detail-view/{id}', 'BelanjaKaryawanController@penjualanViewDtPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/listPenjualan', 'BelanjaKaryawanController@listPenjualanPesanan')->middleware('auth');
	Route::post('/nabila/belanjakaryawan/listPenjualan', 'BelanjaKaryawanController@listPenjualanPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/listPenjualan/data', 'BelanjaKaryawanController@listPenjualanDataPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/printNota/{id}', 'BelanjaKaryawanController@printNotaPesanan')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/find_pegawai', 'BelanjaKaryawanController@find_pegawai')->middleware('auth');
	Route::get('/nabila/belanjakaryawan/delete/{id}', 'BelanjaKaryawanController@delete')->middleware('auth')->name('delete_belanjakaryawan');

	// Section belanja reseller
	Route::get('/nabila/belanjareseller/item', 'BelanjaResellerController@item')->middleware('auth')->name('item_belanjareseller');
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
	Route::get('/nabila/belanjamarketing/item', 'BelanjaMarketingController@item')->middleware('auth')->name('item_belanjamarketing');
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
	// =======================================================================
	Route::get('/nabila/rencanapembelian/index', 'RencanaPembelianController@index')->middleware('auth')->name('index_shop_rencanapembelian');
	Route::get('/nabila/rencanapembelian/form_insert', 'RencanaPembelianController@form_insert')->middleware('auth')->name('form_insert_shop_rencanapembelian');
	Route::get('/nabila/rencanapembelian/form_update/{id}', 'RencanaPembelianController@form_update')->middleware('auth')->name('form_update_shop_rencanapembelian');
	Route::get('/nabila/rencanapembelian/preview/{id}', 'RencanaPembelianController@preview')->middleware('auth')->name('preview_shop_rencanapembelian');
	
	Route::get('/nabila/rencanapembelian/find_d_shop_purchase_plan', 'RencanaPembelianController@find_d_shop_purchase_plan')->middleware('auth')->name('find_d_shop_purchase_plan');
	Route::get('/nabila/rencanapembelian/find_d_shop_purchaseplan_dt/{id}', 'RencanaPembelianController@find_d_shop_purchaseplan_dt')->middleware('auth')->name('find_d_shop_purchaseplan_dt');
	Route::get('/nabila/rencanapembelian/delete_d_shop_purchase_plan/{id}', 'RencanaPembelianController@hapus')->middleware('auth')->name('delete_d_shop_purchase_plan');
	Route::get('/nabila/rencanapembelian/update_sp_status', 'RencanaPembelianController@update_sp_status')->middleware('auth')->name('update_sp_status_rencanapembelian');
	Route::post('/nabila/rencanapembelian/insert_d_shop_purchase_plan', 'RencanaPembelianController@insert_d_shop_purchase_plan')->middleware('auth')->name('insert_d_shop_purchase_plan');
	Route::post('/nabila/rencanapembelian/update_d_shop_purchase_plan', 'RencanaPembelianController@update_d_shop_purchase_plan')->middleware('auth')->name('update_d_shop_purchase_plan');

	// ================================================================================
	
	// Sesi pembelian
	Route::get('/nabila/pembelian/index', 'PembelianController@index')->middleware('auth')->name('index_shop_pembelian');
	Route::get('/nabila/pembelian/form_insert', 'PembelianController@form_insert')->middleware('auth')->name('form_insert_shop_pembelian');
	Route::get('/nabila/pembelian/form_update/{id}', 'PembelianController@form_update')->middleware('auth')->name('form_update_shop_pembelian');
	Route::get('/nabila/pembelian/preview/{id}', 'PembelianController@preview')->middleware('auth')->name('preview_shop_pembelian');
	
	Route::get('/nabila/pembelian/find_d_shop_purchase_order', 'PembelianController@find_d_shop_purchase_order')->middleware('auth')->name('find_d_shop_purchase_order');
	Route::get('/nabila/pembelian/find_d_shop_purchaseorder_dt/{id}', 'PembelianController@find_d_shop_purchaseorder_dt')->middleware('auth')->name('find_d_shop_purchaseorder_dt');
	Route::get('/nabila/pembelian/delete_d_shop_purchase_order/{id}', 'PembelianController@hapus')->middleware('auth')->name('delete_d_shop_purchase_order');
	Route::get('/nabila/pembelian/update_spo_status', 'PembelianController@update_spo_status')->middleware('auth')->name('update_spo_status_pembelian');
	Route::post('/nabila/pembelian/insert_d_shop_purchase_order', 'PembelianController@insert_d_shop_purchase_order')->middleware('auth')->name('insert_d_shop_purchase_order');
	Route::post('/nabila/pembelian/update_d_shop_purchase_order', 'PembelianController@update_d_shop_purchase_order')->middleware('auth')->name('update_d_shop_purchase_order');
	// ==========================================================================================================

	// Sesi terima pembelian
	Route::get('/nabila/penerimaanbarang/index', 'PenerimaanBarangController@index')->middleware('auth')->name('index_shop_penerimaanbarang');
	Route::get('/nabila/penerimaanbarang/form_insert', 'PenerimaanBarangController@form_insert')->middleware('auth')->name('form_insert_shop_penerimaanbarang');
	Route::get('/nabila/penerimaanbarang/form_update/{id}', 'PenerimaanBarangController@form_update')->middleware('auth')->name('form_update_shop_penerimaanbarang');
	Route::get('/nabila/penerimaanbarang/preview/{id}', 'PenerimaanBarangController@preview')->middleware('auth')->name('preview_shop_penerimaanbarang');
	
	Route::get('/nabila/penerimaanbarang/find_d_shop_terima_pembelian', 'PenerimaanBarangController@find_d_shop_terima_pembelian')->middleware('auth')->name('find_d_shop_terima_pembelian');
	Route::get('/nabila/penerimaanbarang/find_d_shop_terima_pembelian_dt', 'PenerimaanBarangController@find_d_shop_terima_pembelian_dt')->middleware('auth')->name('find_d_shop_terima_pembelian_dt');
	Route::get('/nabila/penerimaanbarang/find_d_shop_purchaseorder_dt/{id}', 'PenerimaanBarangController@find_d_shop_purchaseorder_dt')->middleware('auth');
	Route::get('/nabila/penerimaanbarang/find_d_shop_terima_pembelian_dt/{id}', 'PenerimaanBarangController@find_d_shop_terima_pembelian_dt')->middleware('auth')->name('find_d_shop_terima_pembelian_dt');
	Route::get('/nabila/penerimaanbarang/delete_d_shop_terima_pembelian/{id}', 'PenerimaanBarangController@hapus')->middleware('auth')->name('delete_d_shop_terima_pembelian');
	Route::get('/nabila/penerimaanbarang/update_stb_status', 'PenerimaanBarangController@update_stb_status')->middleware('auth')->name('update_stb_status_penerimaanbarang');
	Route::post('/nabila/penerimaanbarang/insert_d_shop_terima_pembelian', 'PenerimaanBarangController@insert_d_shop_terima_pembelian')->middleware('auth')->name('insert_d_shop_terima_pembelian');
	Route::post('/nabila/penerimaanbarang/update_d_shop_terima_pembelian', 'PenerimaanBarangController@update_d_shop_terima_pembelian')->middleware('auth')->name('update_d_shop_terima_pembelian');
	// ==========================================================================================================


	// Sesi return pembelian
	Route::get('/nabila/returnpembelian/tambah_pembelian', 'PurchaseReturnController@tambah_pembelian')->middleware('auth')->name('index_shop_purchase_return');;
	Route::get('/nabila/returnpembelian/index', 'PurchaseReturnController@index')->middleware('auth');
	Route::get('/nabila/returnpembelian/find_d_shop_purchase_return', 'PurchaseReturnController@find_d_shop_purchase_return')->middleware('auth')->name('find_d_shop_purchase_return');;
	Route::post('/nabila/returnpembelian/insert_d_shop_purchase_return', 'PurchaseReturnController@insert_d_shop_purchase_return')->middleware('auth');
	Route::post('/nabila/returnpembelian/update_d_shop_purchase_return', 'PurchaseReturnController@update_d_shop_purchase_return')->middleware('auth');
	Route::get('/nabila/returnpembelian/delete_d_shop_purchase_return/{id}', 'PurchaseReturnController@delete_d_shop_purchase_return')->middleware('auth');

	Route::get('/nabila/returnpembelian/form_perbarui/{id}', 'PurchaseReturnController@form_perbarui')->middleware('auth');
	Route::get('/nabila/returnpembelian/form_preview/{id}', 'PurchaseReturnController@form_preview')->middleware('auth');

	Route::get('/nabila/returnpembelian/find_d_shop_purchase_order', 'PurchaseReturnController@find_d_shop_purchase_order')->middleware('auth');
	Route::get('/nabila/returnpembelian/find_d_shop_purchaseorder_dt', 'PurchaseReturnController@find_d_shop_purchaseorder_dt')->middleware('auth');
	Route::get('/nabila/pembelian/update_spr_status', 'PurchaseReturnController@update_spr_status')->middleware('auth')->name('update_spr_status_returnpembelian');
// ====================================================================================

});

