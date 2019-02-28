<?php

Route::group(['namespace' => 'App\Modules\Purchase\Controllers', 'middleware'=>['web','auth']], function () {	
// Pembayaran hutang
	Route::get('/purchasing/pembayaran_hutang/index', 'PembayaranHutangController@index');
	Route::get('/purchasing/pembayaran_hutang/find_d_payable', 'PembayaranHutangController@find_d_payable');
	Route::get('/purchasing/pembayaran_hutang/find_d_payable_dt/{p_id}', 'PembayaranHutangController@find_d_payable_dt');
	Route::get('/purchasing/pembayaran_hutang/insert_d_payable_dt', 'PembayaranHutangController@insert_d_payable_dt');
	Route::get('/purchasing/pembayaran_hutang/laporan_pembayaran_hutang', 'PembayaranHutangController@laporan_pembayaran_hutang');
/*Purchasing plan*/	
	Route::get('/seach-item-purchase/{gudang}', 'purchasePlanController@seachItemPurchase')->middleware('auth');
	Route::get('/purcahse-plan/plan-index', 'purchasePlanController@planIndex')->middleware('auth');
	Route::get('/purcahse-plan/data-plan', 'purchasePlanController@dataPlan')->middleware('auth');
	Route::get('/purcahse-plan/get-detail-plan/{id}', 'purchasePlanController@getDetailPlan')->middleware('auth');
	Route::get('/purcahse-plan/get-edit-plan/{id}', 'purchasePlanController@getEditPlan')->middleware('auth');
	Route::get('/purcahse-plan/update-plan', 'purchasePlanController@updatePlan')->middleware('auth');
	Route::get('/purcahse-plan/get-delete-plan/{id}', 'purchasePlanController@deletePlan')->middleware('auth');
	Route::get('/purchasing/rencanapembelian/get-detail-plan/{id}/{type}', 'purchasePlanController@getDetailPlan');
	Route::get('/purcahse-plan/update/{id}', 'purchasePlanController@updatePlan');
	Route::get('/purchasing/rencanapembelian/get-data-tabel-history/{tgl1}/{tgl2}/{tampil}', 'purchasePlanController@getDataTabelHistory');
//mahmud konfirm plan
	Route::get('/keuangan/konfirmasipembelian/get-data-tabel-daftar', 'purchaseConfirmController@getDataRencanaPembelian');
	Route::get('/keuangan/konfirmasipembelian/confirm-plan/{id}/{type}', 'purchaseConfirmController@confirmRencanaPembelian');
	Route::get('/keuangan/konfirmasipembelian/confirm-plan-submit', 'purchaseConfirmController@submitRencanaPembelian');
//keuangan
	Route::get('/konfirmasi-purchase/index', 'purchaseConfirmController@confirmIndex')->middleware('auth');
	Route::get('/konfirmasi-purchase/purchase-plane/data/confirm-plan/{id}/{type}', 'purchaseConfirmController@confirmRencanaPembelian')->middleware('auth');
	Route::get('/konfirmasi-purchase/purchase-plane/data/confirm-purchase-plan', 'purchaseConfirmController@konfirmasiPurchasePlan')->middleware('auth');
//mahmud konfirmasi order
	Route::get('keuangan/konfirmasipembelian/get-data-tabel-order','purchaseConfirmController@getDataOrderPembelian')->middleware('auth');
	Route::get('keuangan/konfirmasipembelian/confirm-order/{id}/{type}','purchaseConfirmController@confirmOrderPembelian')->middleware('auth');
	Route::get('/keuangan/konfirmasipembelian/confirm-order-submit', 'purchaseConfirmController@submitOrderPembelian');
//mahmud order
	Route::get('/purchasing/orderpembelian/get-data-rencana-beli', 'purchaseOrderController@getDataRencanaBeli');
	Route::get('/purchasing/rencanapembelian/get-supplierorder', 'purchaseOrderController@getDataSupplier');
	Route::get('/purchasing/orderpembelian/get-data-form/{id}', 'purchaseOrderController@getDataForm');
	Route::get('/purchasing/orderpembelian/get-order-by-tgl/{tgl1}/{tgl2}', 'purchaseOrderController@getOrderByTgl');
	Route::get('/purchasing/orderpembelian/get-data-tabel-history/{tgl1}/{tgl2}/{tampil}', 'purchaseOrderController@getDataTabelHistory');
	Route::get('/purchasing/orderpembelian/get-data-detail/{id}', 'purchaseOrderController@getDataDetail');
	Route::get('/purchasing/orderpembelian/get-edit-order/{id}', 'purchaseOrderController@getEditOrder');
	Route::post('/purchasing/orderpembelian/delete-data-order', 'purchaseOrderController@deleteDataOrder');
/*Purchasing order*/	
	Route::get('/purcahse-order/order-index', 'purchaseOrderController@orderIndex')->middleware('auth');
	Route::get('/purcahse-order/data-order', 'purchaseOrderController@dataOrder')->middleware('auth');
	Route::get('/purcahse-order/form-order', 'purchaseOrderController@formOrder')->middleware('auth');
	Route::get('/purcahse-order/get-data-form/{id}', 'purchaseOrderController@getDataForm')->middleware('auth');
	Route::get('/purcahse-order/get-data-detail/{id}', 'purchaseOrderController@getDataDetail')->middleware('auth');
	Route::get('/purcahse-order/get-data-edit/{id}', 'purchaseOrderController@getDataEdit')->middleware('auth');
	Route::get('/purcahse-order/get-data-code-plan', 'purchaseOrderController@getDataCodePlan')->middleware('auth');
	Route::get('/purcahse-order/seach-supplier', 'purchaseOrderController@seachSupplier')->middleware('auth');
	Route::get('/purcahse-order/delete-data-order', 'purchaseOrderController@deleteDataOrder')->middleware('auth');
	Route::get('/purcahse-order/save-po', 'purchaseOrderController@savePo')->middleware('auth');
	Route::get('/purcahse-plan/store-plan', 'purchasePlanController@storePlan')->middleware('auth');
	Route::get('/purcahse-plan/form-plan', 'purchasePlanController@formPlan')->middleware('auth');
	Route::get('/purchasing/rencanapembelian/rencana', 'rencanapembelianController@rencana')->middleware('auth');
	Route::get('/purchasing/rencanapembelian/create', 'rencanapembelianController@create')->middleware('auth');
	Route::get('/purchasing/returnpembelian/pembelian', 'PurchasingController@pembelian')->middleware('auth');
	Route::get('/purchasing/returnpembelian/update_pr_status', 'PurchasingController@update_pr_status')->middleware('auth')->name('update_pr_status');
	Route::get('/purchasing/belanjasuplier/suplier', 'PurchasingController@suplier')->middleware('auth');
	Route::get('/purchasing/belanjalangsung/langsung', 'PurchasingController@langsung')->middleware('auth');
	Route::get('/purchasing/belanjaproduk/produk', 'PurchasingController@produk')->middleware('auth');
	Route::get('/purchasing/orderpembelian/print/{id}', 'purchaseOrderController@print');
// Routing untuk modul belanja harian

Route::get('/purchasing/belanjaharian/belanja', 'BelanjaHarianController@index')->middleware('auth');
Route::get('/purchasing/belanjaharian/tambah_belanja', 'BelanjaHarianController@tambah_belanja')->middleware('auth');
Route::get('/purchasing/belanjaharian/preview_belanja/{id}', 'BelanjaHarianController@preview_belanja')->middleware('auth')->name('preview_belanjaharian');
Route::get('/purchasing/belanjaharian/insert_d_purchasingharian', 'BelanjaHarianController@insert_d_purchasingharian')->middleware('auth');
Route::get('/purchasing/belanjaharian/update_d_purchasingharian', 'BelanjaHarianController@update_d_purchasingharian')->middleware('auth');
Route::get('/purchasing/belanjaharian/update_d_purchasingharian', 'BelanjaHarianController@update_d_purchasingharian')->middleware('auth');
Route::get('/purchasing/belanjaharian/find_d_purchasingharian', 'BelanjaHarianController@find_d_purchasingharian')->middleware('auth');
Route::get('/purchasing/belanjaharian/update_d_pcsh_status', 'BelanjaHarianController@update_d_pcsh_status')->middleware('auth')->name('update_d_pcsh_status');

Route::get('/purchasing/belanjaharian/find_m_divisi', 'BelanjaHarianController@find_m_divisi')->middleware('auth');
Route::get('/purchasing/belanjaharian/find_m_item', 'BelanjaHarianController@find_m_item')->middleware('auth');

Route::get('/purchasing/belanjaharian/form_perbarui/{id}', 'BelanjaHarianController@form_perbarui')->middleware('auth');
Route::get('/purchasing/belanjaharian/hapus/{id}', 'BelanjaHarianController@hapus')->middleware('auth');

// ============================================================

///// syaifuddin
// Sesi return pembelian
	Route::get('/purchasing/returnpembelian/tambah_pembelian', 'PurchaseReturnController@tambah_pembelian')->middleware('auth');
	Route::get('/purchasing/returnpembelian/pembelian', 'PurchaseReturnController@pembelian')->middleware('auth');
	Route::get('/purchasing/returnpembelian/find_d_purchase_return', 'PurchaseReturnController@find_d_purchase_return')->middleware('auth');
	Route::post('/purchasing/returnpembelian/insert_d_purchase_return', 'PurchaseReturnController@insert_d_purchase_return')->middleware('auth');
	Route::post('/purchasing/returnpembelian/update_d_purchase_return', 'PurchaseReturnController@update_d_purchase_return')->middleware('auth');
	Route::get('/purchasing/returnpembelian/delete_d_purchase_return/{id}', 'PurchaseReturnController@delete_d_purchase_return')->middleware('auth');
	Route::get('/purchasing/returnpembelian/form_perbarui/{id}', 'PurchaseReturnController@form_perbarui')->middleware('auth');
	Route::get('/purchasing/returnpembelian/form_preview/{id}', 'PurchaseReturnController@form_preview')->middleware('auth');
	Route::get('/purchasing/returnpembelian/find_d_purchase_order', 'PurchaseReturnController@find_d_purchase_order')->middleware('auth');
	Route::get('/purchasing/returnpembelian/find_d_purchaseorder_dt', 'PurchaseReturnController@find_d_purchaseorder_dt')->middleware('auth');
//// master
/* ricky */
	Route::get('/purchasing/belanjapasar/pasar', 'PurchasingController@pasar')->middleware('auth');
//purchasing dari spk
	Route::get('/purchasing/rencanabahanbaku/bahan', 'RencanaBahanController@index');
	Route::get('/master/supplier/table/{id}', 'RencanaBahanController@tableRelasiSup');
	Route::get('/master/supplier/hapus/{id}', 'RencanaBahanController@deleteItemSupp');
	Route::get('/master/supplier/tambahSupp', 'RencanaBahanController@saveItemSupp');
	Route::get('/purchasing/get-item/autocomplete', 'RencanaBahanController@getItem');
//selesai purchasing dari spk
// pembelian bahan baku spk
	Route::get('/purchasing/rencanabahanbaku/get-rencana-bytgl/{tgl1}/{tgl2}', 'RencanaBahanController@getRencanaByTgl');
	Route::get('/purchasing/rencanabahanbaku/proses-purchase-plan', 'RencanaBahanController@prosesPurchasePlan');
	Route::get('/purchasing/rencanabahanbaku/suggest-item', 'RencanaBahanController@suggestItem');
	Route::get('/purchasing/rencanabahanbaku/lookup-data-supplier', 'RencanaBahanController@lookupSupplier');
	Route::get('/purchasing/rencanabahanbaku/submit-data', 'RencanaBahanController@submitData');
// Routing laporan pembelian
	Route::get('/purchasing/lap-pembelian/index', 'LaporanPembelianController@index');

	Route::get('/purchasing/lap-pembelian/find_d_purchasingharian', 'LaporanPembelianController@find_d_purchasingharian');
	Route::get('/purchasing/lap-pembelian/get-laporan-bytgl/{tgl1}/{tgl2}', 'LaporanPembelianController@get_laporan_by_tgl');
    Route::get('/purchasing/lap-pembelian/print-lap-beli/{tgl1}/{tgl2}', 'LaporanPembelianController@print_laporan_beli');
    Route::get('/purchasing/lap-pembelian/get-bharian-bytgl/{tgl1}/{tgl2}', 'LaporanPembelianController@get_bharian_by_tgl');
    Route::get('/purchasing/lap-pembelian/print-lap-belanja-harian/{tgl1}/{tgl2}', 'LaporanPembelianController@print_lap_belanja_harian');
    Route::get('/purchasing/lap-supplier/get-bytgl/{tgl1}/{tgl2}', 'LaporanPembelianController@getLapSupplier');
    Route::get('/purchasing/lap-pembelian/print-lap-pembelian/{tgl1}/{tgl2}', 'LaporanPembelianController@print_laporan_pembelian');

// pembelian bahan baku spk selesai
});



