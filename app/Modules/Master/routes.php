<?php

Route::group(['namespace' => 'App\Modules\Master\Controllers', 'middleware'=>['web']], function () {

// Section master data barang
Route::get('/master/item/contoh_dokumen', 'itemController@contoh_dokumen');
Route::get('/master/item/index', 'itemController@index');
Route::get('/master/item/data-barang', 'itemController@dataBarang');
Route::get('/master/item/tambah', 'itemController@tambah');
Route::get('/master/item/supplier', 'itemController@supplier');
Route::get('/master/item/simpan', 'itemController@simpan');
Route::get('/master/item/edit/{id}', 'itemController@edit');
Route::get('/master/item/update', 'itemController@update');
Route::get('/master/item/hapus', 'itemController@hapus');
// ===============================================================

// Section master data barang titipan
Route::get('/master/item_titipan/index', 'itemTitipanController@index');
Route::get('/master/item_titipan/data-barang', 'itemTitipanController@dataBarang');
Route::get('/master/item_titipan/tambah', 'itemTitipanController@tambah');
Route::get('/master/item_titipan/supplier', 'itemTitipanController@supplier');
Route::get('/master/item_titipan/simpan', 'itemTitipanController@simpan');
Route::get('/master/item_titipan/edit/{id}', 'itemTitipanController@edit');
Route::get('/master/item_titipan/update', 'itemTitipanController@update');
Route::get('/master/item_titipan/hapus', 'itemTitipanController@hapus');
// ===============================================================

//data supplier
    Route::get('/master/datasuplier/find_m_suplier', 'SuplierController@find_m_suplier')->name('find_m_supplier');    
    Route::get('/master/datasuplier/suplier', 'SuplierController@suplier')->name('suplier');    
    Route::get('/master/datasuplier/suplier', 'SuplierController@suplier')->name('suplier');    
    Route::post('master/datasuplier/suplier_proses', 'SuplierController@suplier_proses');
    Route::get('/master/datasuplier/tambah_suplier', 'SuplierController@tambah_suplier');
    Route::get('master/datasuplier/datatable_suplier', 'SuplierController@datatable_suplier')->name('datatable_suplier');
    Route::get('master/datasuplier/suplier_edit/{s_id}', 'SuplierController@suplier_edit');
    Route::post('master/datasuplier/suplier_edit_proses/{s_id}', 'SuplierController@suplier_edit_proses');
    Route::get('master/datasuplier/suplier_hapus', 'SuplierController@suplier_hapus');
    
//data supplier selesai
//customer
    Route::get('/master/datacust/cust', 'custController@cust')->name('cust');
    Route::get('/master/datacust/tambah_cust', 'custController@tambah_cust')->name('tambah_cust');
    Route::get('/master/datacust/simpan_cust', 'custController@simpan_cust')->name('simpan_cust');
    Route::get('/master/datacust/hapus_cust', 'custController@hapus_cust')->name('hapus_cust');
    Route::get('/master/datacust/edit_cust', 'custController@edit_cust')->name('edit_cust');
    Route::get('/master/datacust/update_cust', 'custController@update_cust')->name('update_cust');
    Route::get('/master/datacust/datatable_cust', 'custController@datatable_cust')->name('datatable_cust');
//customer selesai
//Master Formula Mahmud
    Route::get('/master/masterproduksi/index', 'MasterFormulaController@index');
    Route::get('/produksi/masterformula/table', 'MasterFormulaController@table');
    Route::get('/produksi/masterformula/autocomplete', 'MasterFormulaController@autocompFormula');
    Route::get('/produksi/namaitem/autocomplete', 'MasterFormulaController@autocompNamaItem');
    Route::post('/produksi/namaitem/save/formula', 'MasterFormulaController@saveFormula');
    Route::get('/produksi/namaitem/distroy/formula/{id}', 'MasterFormulaController@distroyFormula');
    Route::get('/produksi/namaitem/view/formula', 'MasterFormulaController@viewFormula');
    Route::get('/produksi/namaitem/edit/formula', 'MasterFormulaController@editFormula');
    Route::post('/produksi/namaitem/update/formula', 'MasterFormulaController@updateFormula');
//End Master Formula
//Master Group
    Route::get('/master/grouphargakhusus/index', 'hargaKhususController@index');
    Route::get('/master/grouphargakhusus/tablegroup/{id}', 'hargaKhususController@tableGroup');
    Route::get('/master/grouphargakhusus/mastergroup', 'hargaKhususController@tableMasterGroup');
    Route::get('/master/grouphargakhusus/tambahgroup', 'hargaKhususController@tambahGroup');
    Route::get('/master/grouphargakhusus/tambahgroup/baru', 'hargaKhususController@insertGroup');
    Route::get('/master/grouphargakhusus/ubahstatusgrup/{id}', 'hargaKhususController@moveStatusGroup');
    Route::get('/master/grouphargakhusus/editgroupharga/{id}', 'hargaKhususController@editGroup');
    Route::get('/master/grouphargakhusus/updategroup/{id}', 'hargaKhususController@updateGroup');
    Route::get('/master/grouphargakhusus/autocomplete', 'hargaKhususController@autocomplete');
    Route::get('/master/grouphargakhusus/tambahItemHarga', 'hargaKhususController@saveHargaItem');
    Route::get('/master/grouphargakhusus/itemharga/hapus/{id}', 'hargaKhususController@deleteItemHarga');
//*Data Jabatan*/
    Route::get('/master/datajabatan', 'JabatanController@index');
    Route::get('/master/datajabatan/data-jabatan', 'JabatanController@jabatanData');
    Route::get('/master/datajabatan/edit-jabatan/{id}', 'JabatanController@editJabatan');
    Route::get('/master/datajabatan/datatable-pegawai/{id}', 'JabatanController@pegawaiData');
    Route::post('/master/datajabatan/simpan-jabatan', 'JabatanController@simpanJabatan');
    Route::put('/master/datajabatan/update-jabatan/{id}', 'JabatanController@updateJabatan');
    Route::get('/master/datajabatan/tambah-jabatan', 'JabatanController@tambahJabatan');
    Route::get('/master/datajabatan/delete-jabatan/{id}', 'JabatanController@deleteJabatan');
    Route::get('/master/datajabatan/tableproduksi', 'JabatanController@tablePro');
    Route::get('/master/datajabatan/tambah-jabatanpro', 'JabatanController@tambahJabatanPro');
    Route::get('datajabatan/simpan-jabatanpro', 'JabatanController@simpanJabatanPro');
    Route::get('datajabatan/hapus-jabatanpro/{id}', 'JabatanController@hapusJabatanPro');
    Route::get('/master/datajabatan/pro/edit/{id}', 'JabatanController@editPro');
    Route::post('/master/datajabatan/pro/update-jabatan/{id}', 'JabatanController@updatePro');
    Route::get('/master/datajabatanman/ubahstatus', 'JabatanController@ubahStatusMan');
    Route::get('/master/datajabatanpro/ubahstatus', 'JabatanController@ubahStatusPro');
//pegawai
    Route::get('/master/datapegawai/datatable-pegawaipro', 'PegawaiController@pegawaiPro');
    Route::get('/master/datapegawai/tambah-pegawai-pro', 'PegawaiController@tambahPegawaiPro');
    Route::post('/master/datapegawai/simpan-pegawai-pro', 'PegawaiController@simpanPegawaiPro');
    Route::get('/master/datapegawai/edit-pegawai-pro/{id}', 'PegawaiController@editPegawaiPro');
    Route::put('/master/datapegawai/update-pegawai-pro/{id}', 'PegawaiController@updatePegawaiPro');
    Route::delete('/master/datapegawai/delete-pegawai-pro/{id}', 'PegawaiController@deletePegawaiPro');
    Route::post('/master/datapegawai/import-pro', 'PegawaiController@importPegawaiPro');
    Route::get('/master/datapegawai/`import-pro', 'PegawaiController@getFilePro');
    Route::get('/master/datapegawai/pegawai', 'PegawaiController@pegawai')->name('pegawai');
    Route::get('/master/datapegawai/edit-pegawai/{id}', 'PegawaiController@editPegawai');
    Route::post('/master/datapegawai/update-pegawai/{id}', 'PegawaiController@updatePegawai');
    Route::get('/master/datapegawai/datatable-pegawai', 'PegawaiController@pegawaiData');
    Route::get('/master/datapegawai/tambah-pegawai', 'PegawaiController@tambahPegawai');
    Route::get('/master/datapegawai/data-jabatan/{id}', 'PegawaiController@jabatanData');
    Route::post('/master/datapegawai/simpan-pegawai', 'PegawaiController@simpanPegawai');
    Route::delete('/master/datapegawai/delete-pegawai/{id}', 'PegawaiController@deletePegawai');
    Route::post('/master/datapegawai/import', 'PegawaiController@importPegawai');
    Route::get('/master/datapegawai/master-import', 'PegawaiController@getFile');
    Route::get('/master/datapegawai/ubahstatus', 'PegawaiController@ubahStatusMan');
    Route::get('/master/datapegawai/ubahstatuspro', 'PegawaiController@ubahStatusPro');
//mahmud master divisi dan posii
    Route::get('/master/divisi/pos/index', 'DivisiposController@index');
    Route::get('/master/divisi/pos/table', 'DivisiposController@tableDivisi');
    Route::get('/master/divisi/pos/edit/{id}', 'DivisiposController@editDivisi');
    Route::post('/master/divisi/pos/updatedivisi/{id}', 'DivisiposController@updateDivisi');
    Route::get('/master/divisi/posisi/table', 'DivisiposController@tablePosisi');
    Route::get('/master/divisi/posisi/edit/{id}', 'DivisiposController@editPosisi');
    Route::post('/master/divisi/posisi/update/{id}', 'DivisiposController@updatePosisi');
    Route::get('/master/divisi/pos/tambahposisi/index', 'DivisiposController@tambahPosisi');
    Route::post('/master/divisi/pos/tambahposisi', 'DivisiposController@savePosisi');
    Route::get('/master/divisi/pos/tambahdivisi', 'DivisiposController@tambahDivisi');
    Route::post('/master/divisi/pos/simpandivisi', 'DivisiposController@simpanDivisi');
    Route::get('/master/divisi/pos/hapusdivisi/{id}', 'DivisiposController@hapusDivisi');
    Route::get('/master/divisi/pos/hapusposisi/{id}', 'DivisiposController@hapusPosisi');
    Route::get('/master/divisi/pos/ubahstatus', 'DivisiposController@ubahStatusDiv');
    Route::get('/master/divisi/posisi/ubahstatus', 'DivisiposController@ubahStatusPos');
//Master Data Lowongan
    Route::get('/master/datalowongan/index', 'LowonganController@index');
    Route::get('/master/datalowongan/datatable-index', 'LowonganController@get_datatable_index');
    Route::get('/master/datalowongan/tambah_lowongan', 'LowonganController@tambah_data');
    Route::post('/master/datalowongan/simpan_lowongan', 'LowonganController@simpan_data');
    Route::post('/master/datalowongan/ubah_status', 'LowonganController@ubah_status');
    Route::get('/master/datalowongan/edit_lowongan', 'LowonganController@edit_data');
    Route::post('/master/datalowongan/update_lowongan', 'LowonganController@update_data');
    Route::get('/master/datalowongan/lookup-data-divisi', 'LowonganController@lookup_divisi');
    Route::get('/master/datalowongan/lookup-data-level', 'LowonganController@lookup_level');
    Route::get('/master/datalowongan/lookup-data-jabatan', 'LowonganController@lookup_jabatan');
//Master data Scoreboard
    Route::get('/master/datascore/index', 'ScoreController@index');
    Route::get('/master/datascore/tambah-score', 'ScoreController@tambah_score');
    Route::get('/master/datascore/datatable-index', 'ScoreController@get_datatable_index');
    Route::get('/master/datascore/lookup-data-jabatan', 'ScoreController@lookup_jabatan');
    Route::get('/master/datascore/lookup-data-pegawai', 'ScoreController@lookup_pegawai');
    Route::post('/master/datascore/simpan-score', 'ScoreController@simpan_score');
    Route::get('/master/datascore/edit-score', 'ScoreController@edit_score');
    Route::post('/master/datascore/update-score', 'ScoreController@update_score');
    Route::post('/master/datascore/delete-score', 'ScoreController@delete_score');
//Master data KPI
    Route::get('/master/datakpi/index', 'KpiController@index');
    Route::get('/master/datakpi/tambah-kpi', 'KpiController@tambahKpi');
    Route::post('/master/datakpi/simpan-kpi', 'KpiController@simpanKpi');
    Route::get('/master/datakpi/datatable-index', 'KpiController@getDatatableKpi');
    Route::get('/master/datakpi/edit-kpi', 'KpiController@editKpi');
    Route::post('/master/datakpi/update-kpi', 'KpiController@updateKpi');
    Route::post('/master/datakpi/delete-kpi', 'KpiController@deleteKpi');

    // Section membership
    Route::get('/master/membership/member', 'MemberController@index')->middleware('auth')->name('customer');
    Route::get('/master/membership/get_data_all', 'MemberController@get_data_all')->middleware('auth');
    Route::get('/master/membership/get_data_active', 'MemberController@get_data_active')->middleware('auth');
    Route::get('/master/membership/get_data_nonactive', 'MemberController@get_data_nonactive')->middleware('auth');
    Route::post('/master/membership/simpan_tambah', 'MemberController@simpan_tambah')->middleware('auth')->name('insert_m_customer');
    Route::post('/master/membership/simpan_edit', 'MemberController@simpan_edit')->middleware('auth')->name('update_m_customer');
    Route::get('/master/membership/form_insert', 'MemberController@form_insert')->middleware('auth')->name('form_insert_customer');
    Route::get('/master/membership/form_alter/{id}', 'MemberController@form_alter')->middleware('auth')->name('form_alter_customer');
    Route::get('/master/membership/preview/{id}', 'MemberController@preview')->middleware('auth')->name('preview_customer');
    Route::get('/master/membership/delete/{id}', 'MemberController@delete')->middleware('auth')->name('delete_m_customer');

    Route::get('/master/databarang/find_m_item', 'itemController@find_m_item')->middleware('auth')->name('find_m_item');
});
