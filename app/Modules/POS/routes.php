<?php

	Route::group(['namespace' => 'App\Modules\POS\Controllers', 'middleware'=>['web','auth']], function () {	
		
	Route::get('/showMachine', 'PenjualanController@showMachine')->middleware('auth');
	Route::get('/customer', 'PenjualanController@customer')->middleware('auth');
	Route::get('/paymentmethod', 'PenjualanController@paymentmethod')->middleware('auth');
	Route::get('/paymentmethod/edit/{id}/{flag}', 'PenjualanController@paymentmethodEdit')->middleware('auth');
	/*Item*/
	Route::get('/item', 'PenjualanController@item')->middleware('auth');
	Route::get('/item-rencana', 'PenjualanController@itemRencana')->middleware('auth');
	


Route::get('/penjualan/pos-pesanan/index', 'PenjualanPesananController@posPesanan')->middleware('auth');
Route::get('/penjualan/pos-pesanan/create', 'PenjualanPesananController@create')->middleware('auth');
Route::get('/penjualan/pos-pesanan/update', 'PenjualanPesananController@update')->middleware('auth');
Route::get('/penjualan/pos-pesanan/serah-terima', 'PenjualanPesananController@serahTerima')->middleware('auth');

Route::get('/penjualan/pos-pesanan/{id}/edit', 'PenjualanPesananController@penjualanDtPesanan')->middleware('auth');
Route::get('/penjualan/pos-pesanan/detail-view/{id}', 'PenjualanPesananController@penjualanViewDtPesanan')->middleware('auth');
Route::get('/penjualan/pos-pesanan/listPenjualan', 'PenjualanPesananController@listPenjualanPesanan')->middleware('auth');
Route::post('/penjualan/pos-pesanan/listPenjualan', 'PenjualanPesananController@listPenjualanPesanan')->middleware('auth');
Route::get('/penjualan/pos-pesanan/listPenjualan/data', 'PenjualanPesananController@listPenjualanDataPesanan')->middleware('auth');
/*Route::get('/penjualan/pos-pesanan/printNota/{id}', 'PenjualanPesananController@printNotaPesanan')->middleware('auth');

*/

//mutasi item
//update mi
Route::get('/penjualan/mutasi-item/index', 'mutasiItemController@mutasiItemIndex');
Route::get('/penjualan/mutasi-item/data-mutasi', 'mutasiItemController@dataMutasiItem');
Route::get('/penjualan/mutasi-item/tambah-mutasi-item', 'mutasiItemController@tambahMutasiItem');
Route::get('/penjualan/mutasi-item/store', 'mutasiItemController@store');
Route::get('/penjualan/mutasi-item/perbarui/{id}', 'mutasiItemController@perbarui');
Route::get('/penjualan/mutasi-item/mutasi-item-detail/{id}', 'mutasiItemController@mutasiItemDt');
Route::get('/penjualan/mutasi-item/destroy/{id}', 'mutasiItemController@destroy');
/*

//mutasi item
	//update mi
	Route::get('/penjualan/mutasi-item/index', 'mutasiItemController@mutasiItemIndex');
	Route::get('/penjualan/mutasi-item/data-mutasi', 'mutasiItemController@dataMutasiItem');
	Route::get('/penjualan/mutasi-item/tambah-mutasi-item', 'mutasiItemController@tambahMutasiItem');
	Route::get('/penjualan/mutasi-item/store', 'mutasiItemController@store');
	Route::get('/penjualan/mutasi-item/perbarui/{id}', 'mutasiItemController@perbarui');
	Route::get('/penjualan/mutasi-item/mutasi-item-detail/{id}', 'mutasiItemController@mutasiItemDt');
	Route::get('/penjualan/mutasi-item/destroy/{id}', 'mutasiItemController@destroy');
*/





//pencatatan barang titipan
Route::get('/penjualan/barang-titipan/index', 'itemTitipanController@index');
Route::get('/penjualan/barang-titipan/data', 'itemTitipanController@data');
Route::get('/penjualan/barang-titipan/listData', 'itemTitipanController@listData');
Route::get('/penjualan/barang-titipan/seach-supplier', 'itemTitipanController@seachSupplier');
Route::get('/penjualan/barang-titipan/store', 'itemTitipanController@store');
Route::get('/penjualan/barang-titipan/{id}/edit-titipan-dt', 'itemTitipanController@editTitipanDt');
Route::get('/penjualan/barang-titipan/update', 'itemTitipanController@update');
Route::get('penjualan/barang-titip/search-item-titipan', 'itemTitipanController@itemTitipan');

Route::get('/penjualan/barang-titipan/serahTerima/{id}', 'itemTitipanController@serahTerima');
Route::get('/penjualan/barang-titipan/serah-terima/store', 'itemTitipanController@serahTerimaStore');

Route::get('/penjualan/barang-titipan/detail/{id}', 'itemTitipanController@titipanDt');




Route::get('/penjualan/barang-titipan/chek-qty-return/{item}/{comp}/{position}', 'itemTitipanController@chekQtyReturn');




// pencatatan barang titip
Route::get('/penjualan/barang-titip/index', 'itemTitipController@index');
Route::get('/penjualan/barang-titip/data', 'itemTitipController@data');
Route::get('/penjualan/barang-titip/store', 'itemTitipController@store');
Route::get('/penjualan/barang-titip/{id}/edit', 'itemTitipController@edit');
Route::get('/penjualan/barang-titip/update', 'itemTitipController@update');

Route::get('/penjualan/barang-titip/serahTerima/{id}', 'itemTitipController@serahTerima');

Route::get('/penjualan/barang-titip/search-item-titip', 'itemTitipController@searchItemTitip');

Route::get('/penjualan/barang-titip/detail/{id}', 'itemTitipController@titipDt');

// Routing untuk modul manajemen harga 
Route::get('/penjualan/manajemenharga/harga', 'PenjualanController@harga')->middleware('auth');
Route::get('/penjualan/manajemenharga/find_m_price', 'PenjualanController@find_m_price')->middleware('auth');
Route::get('/penjualan/manajemenharga/update_m_price', 'PenjualanController@update_m_price')->middleware('auth');

// =============================================
Route::get('/penjualan/manajemenpromosi/promosi', 'PenjualanController@promosi')->middleware('auth');
Route::get('/penjualan/layananpesanan/layananpesanan', 'PenjualanController@layananpesanan')->middleware('auth');

Route::get('/penjualan/POSpenjualan/POSpenjualan', 'PenjualanController@POSpenjualan')->middleware('auth');
Route::get('/penjualan/monitorprogress/progress', 'PenjualanController@progress')->middleware('auth');



Route::get('/penjualan/monitoringorder/monitoring', 'PenjualanController@monitoringorder')->middleware('auth');
Route::get('/penjualan/mutasistok/mutasi', 'MutasiController@mutasi')->middleware('auth');
Route::get('/penjualan/layananpesanan/tambah_layananpesanan', 'PenjualanController@tambah_layananpesanan')->middleware('auth');
Route::get('/penjualan/POSpenjualanmobile/POSpenjualanmobile', 'laporanPenjualanTokoController@POSpenjualanmobile')->middleware('auth');
Route::get('/penjualan/produklangsung/produklangsung', 'PenjualanController@produklangsung')->middleware('auth');
Route::get('/penjualan/penjualanexpired/penjualanexpired', 'PenjualanController@penjualanexpired')->middleware('auth');
Route::get('/penjualan/repackaging/repackaging', 'PenjualanController@repackaging')->middleware('auth');
Route::get('/penjualan/POSpenjualankonsinyasi/POSpenjualankonsinyasi', 'PenjualanController@POSpenjualankonsinyasi')->middleware('auth');
Route::get('/penjualan/POSpenjualanpesanan/POSpenjualanpesanan', 'PenjualanController@POSpenjualanPesanan')->middleware('auth');


	Route::get('/item/search-item/code', 'PenjualanController@searchItemCode')->middleware('auth');
	/*Item*/
	Route::get('/s', 'PenjualanController@s')->middleware('auth');
	Route::get('/penjualan/pos-toko/index', 'PenjualanController@posToko')->middleware('auth');
	Route::get('/penjualan/pos-toko/create', 'PenjualanController@create')->middleware('auth');
	Route::get('/penjualan/pos-toko/update', 'PenjualanController@update')->middleware('auth');
	Route::get('/penjualan/pos-toko/{id}/edit', 'PenjualanController@penjualanDtToko')->middleware('auth');
	Route::get('/penjualan/pos-toko/detail-view/{id}', 'PenjualanController@penjualanViewDtToko')->middleware('auth');
	Route::post('/penjualan/pos-toko/listPenjualan', 'PenjualanController@listPenjualan')->middleware('auth');
	Route::post('/penjualan/pos-toko/listPenjualan/data', 'PenjualanController@listPenjualanData')->middleware('auth');
	Route::get('/penjualan/pos-toko/listPenjualan/data', 'PenjualanController@listPenjualanData')->middleware('auth');
	Route::get('/penjualan/pos-toko/printNota/{id}', 'PenjualanController@printNota')->middleware('auth');

	Route::get('/penjualan/pos-pesanan/index', 'PenjualanPesananController@posPesanan')->middleware('auth');
	Route::get('/penjualan/pos-pesanan/create', 'PenjualanPesananController@create')->middleware('auth');
	Route::get('/penjualan/pos-pesanan/update', 'PenjualanPesananController@update')->middleware('auth');
	Route::get('/penjualan/pos-pesanan/serah-terima', 'PenjualanPesananController@serahTerima')->middleware('auth');

	Route::get('/penjualan/pos-pesanan/{id}/edit', 'PenjualanPesananController@penjualanDtPesanan')->middleware('auth');
	Route::get('/penjualan/pos-pesanan/detail-view/{id}', 'PenjualanPesananController@penjualanViewDtPesanan')->middleware('auth');
	Route::get('/penjualan/pos-pesanan/listPenjualan', 'PenjualanPesananController@listPenjualanPesanan')->middleware('auth');
	Route::post('/penjualan/pos-pesanan/listPenjualan', 'PenjualanPesananController@listPenjualanPesanan')->middleware('auth');
	Route::get('/penjualan/pos-pesanan/listPenjualan/data', 'PenjualanPesananController@listPenjualanDataPesanan')->middleware('auth');
	Route::get('/penjualan/pos-pesanan/printNota/{id}', 'PenjualanPesananController@printNotaPesanan')->middleware('auth');



	

	//pencatatan barang titipan
	Route::get('/penjualan/barang-titipan/index', 'itemTitipanController@index');
	Route::get('/penjualan/barang-titipan/data', 'itemTitipanController@data');
	Route::get('/penjualan/barang-titipan/listData', 'itemTitipanController@listData');
	Route::get('/penjualan/barang-titipan/seach-supplier', 'itemTitipanController@seachSupplier');
	Route::get('/penjualan/barang-titipan/store', 'itemTitipanController@store');
	Route::get('/penjualan/barang-titipan/{id}/edit-titipan-dt', 'itemTitipanController@editTitipanDt');
	Route::get('/penjualan/barang-titipan/update', 'itemTitipanController@update');
	Route::get('penjualan/barang-titip/search-item-titipan', 'itemTitipanController@itemTitipan');

	Route::get('/penjualan/barang-titipan/serahTerima/{id}', 'itemTitipanController@serahTerima');
	Route::get('/penjualan/barang-titipan/serah-terima/store', 'itemTitipanController@serahTerimaStore');

	Route::get('/penjualan/barang-titipan/detail/{id}', 'itemTitipanController@titipanDt');




	Route::get('/penjualan/barang-titipan/chek-qty-return/{item}/{comp}/{position}', 'itemTitipanController@chekQtyReturn');




	// pencatatan barang titip
	Route::get('/penjualan/barang-titip/index', 'itemTitipController@index');
	Route::get('/penjualan/barang-titip/data', 'itemTitipController@data');
	Route::get('/penjualan/barang-titip/store', 'itemTitipController@store');
	Route::get('/penjualan/barang-titip/{id}/edit', 'itemTitipController@edit');
	Route::get('/penjualan/barang-titip/update', 'itemTitipController@update');

	Route::get('/penjualan/barang-titip/serahTerima/{id}', 'itemTitipController@serahTerima');

	Route::get('/penjualan/barang-titip/search-item-titip', 'itemTitipController@searchItemTitip');

	Route::get('/penjualan/barang-titip/detail/{id}', 'itemTitipController@titipDt');

	// Routing untuk modul manajemen harga 
	Route::get('/penjualan/manajemenharga/harga', 'PenjualanController@harga')->middleware('auth');
	Route::get('/penjualan/manajemenharga/find_m_price', 'PenjualanController@find_m_price')->middleware('auth');

	// =============================================
	Route::get('/penjualan/manajemenpromosi/promosi', 'PenjualanController@promosi')->middleware('auth');
	Route::get('/penjualan/layananpesanan/layananpesanan', 'PenjualanController@layananpesanan')->middleware('auth');

	Route::get('/penjualan/POSpenjualan/POSpenjualan', 'PenjualanController@POSpenjualan')->middleware('auth');
	Route::get('/penjualan/monitorprogress/progress', 'PenjualanController@progress')->middleware('auth');



	Route::get('/penjualan/monitoringorder/monitoring', 'PenjualanController@monitoringorder')->middleware('auth');
	Route::get('/penjualan/mutasistok/mutasi', 'MutasiController@mutasi')->middleware('auth');
	Route::get('/penjualan/layananpesanan/tambah_layananpesanan', 'PenjualanController@tambah_layananpesanan')->middleware('auth');
	Route::get('/penjualan/POSpenjualanmobile/POSpenjualanmobile', 'laporanPenjualanTokoController@POSpenjualanmobile')->middleware('auth');
	Route::get('/penjualan/produklangsung/produklangsung', 'PenjualanController@produklangsung')->middleware('auth');
	Route::get('/penjualan/penjualanexpired/penjualanexpired', 'PenjualanController@penjualanexpired')->middleware('auth');
	Route::get('/penjualan/repackaging/repackaging', 'PenjualanController@repackaging')->middleware('auth');
	Route::get('/penjualan/POSpenjualankonsinyasi/POSpenjualankonsinyasi', 'PenjualanController@POSpenjualankonsinyasi')->middleware('auth');
	Route::get('/penjualan/POSpenjualanpesanan/POSpenjualanpesanan', 'PenjualanController@POSpenjualanPesanan')->middleware('auth');

	// Laporan penjualan mobile 
	Route::get('/penjualan/penjualanmobile/penjualanmobile', 'laporanPenjualanTokoController@penjualanmobile')->middleware('auth');
	Route::get('/penjualan/penjualanmobile/find_d_sales_dt', 'laporanPenjualanTokoController@find_d_sales_dt')->middleware('auth');
	Route::get('/penjualan/penjualanmobile/print_laporan', 'laporanPenjualanTokoController@print_laporan')->middleware('auth');

	Route::get('/penjualan/penjualanmobile/print_laporan_excel', 'laporanPenjualanTokoController@print_laporan_excel')->middleware('auth');

	//menampilkan total pada ajax
	Route::get('/penjualan/penjualanmobile/totalPenjualan', 'laporanPenjualanTokoController@totalPenjualan')->middleware('auth');
	// ==========================================================================================

	// Laporan penjualan pesanan
	Route::get('penjualan/laporan-penjualan-pesanan/index', 'laporanPenjualanPesananController@index')->middleware('auth');	
	Route::get('penjualan/laporan-penjualan-pesanan/table', 'laporanPenjualanPesananController@table')->middleware('auth');	
	Route::get('penjualan/laporan-penjualan-pesanan/totalPiutang', 'laporanPenjualanPesananController@totalPiutang')->middleware('auth');	
	Route::get('penjualan/laporan-penjualan-pesanan/print_laporan-excel', 'laporanPenjualanPesananController@printLaporanExcel')->middleware('auth');	
	
	
	//selesai  Laporan penjualan pesanan



	Route::get('penjualan/stok/index', 'PenjualanController@indexStok');
	Route::get('penjualan/stok/data', 'PenjualanController@dataStok');


	//rencana penjualan
	Route::get('/penjualan/rencanapenjualan/rencana', 'rencanaPenjualanController@index')->middleware('auth');
	Route::get('/penjualan/rencanapenjualan/simpan', 'rencanaPenjualanController@simpan')->middleware('auth');
	Route::get('/penjualan/rencanapenjualan/find_d_sales_plan', 'rencanaPenjualanController@find_d_sales_plan')->middleware('auth');
	Route::get('/penjualan/rencanapenjualan/hapus/{id}', 'rencanaPenjualanController@hapus')->middleware('auth');
	Route::get('/penjualan/rencanapenjualan/form_perbarui/{id}', 'rencanaPenjualanController@form_perbarui')->middleware('auth');
	Route::get('/penjualan/rencanapenjualan/perbarui', 'rencanaPenjualanController@perbarui')->middleware('auth');
	Route::get('/penjualan/rencanapenjualan/find_m_item', 'rencanaPenjualanController@find_m_item')->middleware('auth');
	//rencana penjualan selesai

	//mahmud retur
	Route::get('/penjualan/manajemenreturn/r_penjualan', 'PenjualanController@r_penjualan')->middleware('auth');
	Route::get('/penjualan/manajemenreturn/tabel', 'ManajemenReturnPenjualanController@tabel');
	Route::get('/penjualan/manajemenreturn/r_penjualan', 'ManajemenReturnPenjualanController@r_penjualan')->middleware('auth');
	Route::get('/penjualan/manajemenreturn/tambahreturn', 'ManajemenReturnPenjualanController@newreturn');
	Route::get('/penjualan/manajemenreturn/preview/{id}', 'ManajemenReturnPenjualanController@preview');
	Route::get('/penjualan/manajemenreturn/carinota', 'ManajemenReturnPenjualanController@carinota');
	Route::get('/penjualan/manajemenreturn/get-data/{id}', 'ManajemenReturnPenjualanController@getdata');
	Route::get('/penjualan/manajemenreturn/tabelpnota/{id}/{metode}', 'ManajemenReturnPenjualanController@tabelpnota');
	Route::get('/penjualan/manajemenreturn/store/{id}', 'ManajemenReturnPenjualanController@store');
	Route::get('/penjualan/manajemenreturn/deleteretur/{id}', 'ManajemenReturnPenjualanController@deleteretur');
	
	// Routing untuk pembayaran piutang
	Route::get('/penjualan/pembayaranpiutang/index', 'PembayaranPiutangController@index');
	Route::get('/penjualan/pembayaranpiutang/find_d_receivable', 'PembayaranPiutangController@find_d_receivable');
	Route::get('/penjualan/pembayaranpiutang/find_d_receivable_dt/{r_id}', 'PembayaranPiutangController@find_d_receivable_dt');
	Route::get('/penjualan/pembayaranpiutang/insert_d_receivable_dt', 'PembayaranPiutangController@insert_d_receivable_dt');
	Route::get('/penjualan/pembayaranpiutang/laporan_pembayaran_piutang', 'PembayaranPiutangController@laporan_pembayaran_piutang');


	Route::get('/penjualan/pos-mobile/index', 'posMobileController@posMobile')->middleware('auth');	
	Route::get('/penjualan/pos-mobile/create', 'PenjualanController@create')->middleware('auth');
	Route::get('/penjualan/pos-mobile/update', 'PenjualanController@update')->middleware('auth');
	Route::get('/penjualan/pos-mobile/{id}/edit', 'PenjualanController@penjualanDtmobile')->middleware('auth');
	Route::get('/penjualan/pos-mobile/detail-view/{id}', 'PenjualanController@penjualanViewDtmobile')->middleware('auth');
	Route::post('/penjualan/pos-mobile/listPenjualan', 'PenjualanController@listPenjualan')->middleware('auth');
	Route::post('/penjualan/pos-mobile/listPenjualan/data', 'PenjualanController@listPenjualanData')->middleware('auth');
	Route::get('/penjualan/pos-mobile/listPenjualan/data', 'PenjualanController@listPenjualanData')->middleware('auth');
	Route::get('/penjualan/pos-mobile/printNota/{id}', 'PenjualanController@printNota')->middleware('auth');
	
	// Section return penjualan
	
});

