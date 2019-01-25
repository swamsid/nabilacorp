<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
  /*  Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');*/

Route::group(['middleware' => ['guest', 'web']], function() {
Route::get('/', function () {
	return view('auth.login');
})->name('login');
/*Route::get('/', 'loginController@authenticate');*/

Route::get('login', 'loginController@authenticate');
Route::post('login', 'loginController@authenticate');
/*Route::post('/login', [ 'as' => 'login', 'uses' => 'loginController@authenticate']);*/

});
Route::group(['middleware' => ['auth', 'web']], function() {

Route::get('/session-set-comp/{id}','mMemberController@setComp');
Route::get('not-allowed', 'mMemberController@notAllowed');
Route::get('logout', 'mMemberController@logout');

/*Auth::routes();*/
Route::get('/seach-supplier', 'supplierController@datasupplier');

Route::get('/home', 'HomeController@index')->name('home');

/*Master*/
Route::get('/master/datasuplier/suplier', 'MasterController@suplier')->middleware('auth');
/* ari */
Route::get('/master/datacust/cust', 'MasterController@cust')->middleware('auth');
Route::get('/getdata', 'MasterController@getdata')->middleware('auth');
Route::get('/master/datacust/simpan_cust', 'MasterController@simpan_cust')->middleware('auth');

Route::get('/master/datacust/cust_edit/{id_cus_ut}', 'MasterController@cust_edit')->middleware('auth');
Route::get('/master/datacust/cust_edit/cust_edit_proses/{id_cus_ut}', 'MasterController@cust_edit_proses')->middleware('auth');
Route::get('/master/datacust/cust_delete/{id_cus_ut}', 'MasterController@cust_delete')->middleware('auth');
/*---------*/
Route::get('/master/databaku/baku', 'MasterController@baku')->middleware('auth');
Route::get('/master/databaku/tambah_baku', 'MasterController@tambah_baku')->middleware('auth');
Route::get('/master/datajenis/jenis', 'MasterController@jenis')->middleware('auth');
Route::get('/master/datajenis/tambah_jenis', 'MasterController@tambah_jenis')->middleware('auth');

// Section pegawai
Route::get('/master/datapegawai/pegawai', 'MasterController@pegawai')->middleware('auth');
Route::get('/master/datapegawai/find_m_pegawai', 'MasterController@find_m_pegawai')->middleware('auth');
// ======================================================================================

Route::get('/master/datakeuangan/keuangan', 'MasterController@keuangan')->middleware('auth');
Route::get('/master/datatransaksi/transaksi', 'MasterController@transaksi')->middleware('auth');
Route::get('/master/datasuplier/tambah_suplier', 'MasterController@tambah_suplier')->middleware('auth');
Route::get('/master/datacust/tambah_cust', 'MasterController@tambah_cust')->middleware('auth');
Route::get('/master/datatransaksi/tambah_transaksi', 'MasterController@tambah_transaksi')->middleware('auth');
Route::get('/master/datapegawai/tambah_pegawai', 'MasterController@tambah_pegawai')->middleware('auth');

Route::get('/master/databarang/barang', 'MasterController@barang')->middleware('auth');
Route::get('/master/databarang/tambah_barang', 'MasterController@tambah_barang')->middleware('auth');


/*Inventory*/
Route::get('/inventory/p_hasilproduksi/produksi', 'InventoryController@produksi')->middleware('auth');
Route::get('/inventory/p_returncustomer/cust', 'InventoryController@cust')->middleware('auth');
// Route::get('/inventory/b_digunakan/barang', 'InventoryController@barang')->middleware('auth');
Route::get('/inventory/stockopname/opname', 'InventoryController@opname')->middleware('auth');
Route::get('/inventory/p_suplier/cari_nota', 'InventoryController@cari_nota_sup')->middleware('auth');
Route::get('/inventory/p_hasilproduksi/cari_nota', 'InventoryController@cari_nota_produksi')->middleware('auth');
Route::get('/inventory/p_returncustomer/cari_nota', 'InventoryController@cari_nota_cust')->middleware('auth');
Route::get('/inventory/b_digunakan/tambah_barang', 'InventoryController@tambah_barang')->middleware('auth');
Route::get('/inventory/stockopname/tambah_opname', 'InventoryController@tambah_opname')->middleware('auth');

/*Produksi*/
/*Route::get('/produksi/rencanaproduksi/produksi', 'ProduksiController@produksi')->middleware('auth');
Route::get('/produksi/spk/spk', 'ProduksiController@spk')->middleware('auth');
Route::get('/produksi/bahanbaku/baku', 'ProduksiController@baku')->middleware('auth');
Route::get('/produksi/sdm/sdm', 'ProduksiController@sdm')->middleware('auth');
Route::get('/produksi/produksi/produksi2', 'ProduksiController@produksi2')->middleware('auth');
Route::get('/produksi/o_produksi/produksi3', 'ProduksiController@produksi3')->middleware('auth');
Route::get('/produksi/waste/waste', 'ProduksiController@waste')->middleware('auth');
Route::get('/produksi/monitoringprogress/monitoring', 'ProduksiController@monitoring')->middleware('auth');
Route::get('/produksi/o_produksi/tambah_produksi', 'ProduksiController@tambah_produksi')->middleware('auth');*/

/*Penjualan
Route::get('/penjualan/manajemenharga/harga', 'PenjualanController@harga')->middleware('auth');
Route::get('/penjualan/manajemenpromosi/promosi', 'PenjualanController@promosi')->middleware('auth');
Route::get('/penjualan/layananpesanan/layananpesanan', 'PenjualanController@layananpesanan')->middleware('auth');

Route::get('/penjualan/POSpenjualan/POSpenjualan', 'PenjualanController@POSpenjualan')->middleware('auth');
Route::get('/penjualan/manajemenreturn/r_penjualan', 'PenjualanController@r_penjualan')->middleware('auth');
Route::get('/penjualan/monitorprogress/progress', 'PenjualanController@progress')->middleware('auth');
Route::get('/penjualan/rencanapenjualan/tambah_rencana', 'PenjualanController@tambah_rencana')->middleware('auth');
Route::get('/penjualan/monitoringorder/monitoring', 'PenjualanController@monitoringorder')->middleware('auth');
Route::get('/penjualan/mutasistok/mutasi', 'PenjualanController@mutasi')->middleware('auth');
Route::get('/penjualan/layananpesanan/tambah_layananpesanan', 'PenjualanController@tambah_layananpesanan')->middleware('auth');
Route::get('/penjualan/POSpenjualanmobile/POSpenjualanmobile', 'PenjualanController@POSpenjualanmobile')->middleware('auth');
Route::get('/penjualan/produklangsung/produklangsung', 'PenjualanController@produklangsung')->middleware('auth');
Route::get('/penjualan/penjualanexpired/penjualanexpired', 'PenjualanController@penjualanexpired')->middleware('auth');
Route::get('/penjualan/repackaging/repackaging', 'PenjualanController@repackaging')->middleware('auth');
Route::get('/penjualan/POSpenjualankonsinyasi/POSpenjualankonsinyasi', 'PenjualanController@POSpenjualankonsinyasi')->middleware('auth');
Route::get('/penjualan/POSpenjualanpesanan/POSpenjualanpesanan', 'PenjualanController@POSpenjualanPesanan')->middleware('auth');
Route::get('/penjualan/POSpenjualanToko/POSpenjualanToko', 'PenjualanController@POSpenjualanToko')->middleware('auth');
Route::get('/penjualan/penjualanmobile/penjualanmobile', 'PenjualanController@penjualanmobile')->middleware('auth');
*/
//POSRetail
Route::get('/penjualan/POSretail/retail', 'Penjualan\POSRetailController@retail')->middleware('auth');
Route::get('/penjualan/POSretail/retail/store', 'Penjualan\POSRetailController@store')->middleware('auth');
Route::get('/penjualan/POSretail/retail/autocomplete', 'Penjualan\POSRetailController@autocomplete')->middleware('auth');
Route::get('/penjualan/POSretail/retail/setnama/{id}', 'Penjualan\POSRetailController@setnama')->middleware('auth');
Route::get('/penjualan/POSretail/retail/sal_save', 'Penjualan\POSRetailController@sal_save')->middleware('auth');
Route::get('/penjualan/POSretail/retail/create', 'Penjualan\POSRetailController@create')->middleware('auth');
Route::get('/penjualan/POSretail/retail/create_sal', 'Penjualan\POSRetailController@create_sal')->middleware('auth');
Route::get('/penjualan/POSretail/retail/edit_sales/{id}', 'Penjualan\POSRetailController@edit_sales')->middleware('auth');
Route::get('/penjualan/POSretail/retail/distroy/{id}', 'Penjualan\POSRetailController@distroy')->middleware('auth');
Route::get('/penjualan/POSretail/retail/update/{id}', 'Penjualan\POSRetailController@update')->middleware('auth');

/*HRD*/
Route::get('/hrd/manajemenkpipegawai/kpi', 'HrdController@kpi')->middleware('auth');
Route::get('/hrd/payroll/payroll', 'HrdController@payroll')->middleware('auth');
Route::get('/hrd/recruitment/rekrut', 'HrdController@rekrut')->middleware('auth');
Route::get('/hrd/datakaryawan/karyawan', 'HrdController@karyawan')->middleware('auth');
Route::get('/hrd/dataadministrasi/admin', 'HrdController@admin')->middleware('auth');
Route::get('/hrd/datalembur/lembur', 'HrdController@lembur')->middleware('auth');
Route::get('/hrd/scoreboard/score', 'HrdController@score')->middleware('auth');
Route::get('/hrd/training/training', 'HrdController@training')->middleware('auth');

/*Keuangan*/
Route::get('/keuangan/p_inputtransaksi/transaksi', 'KeuanganController@transaksi')->middleware('auth');
Route::get('/keuangan/l_hutangpiutang/hutang', 'KeuanganController@hutang')->middleware('auth');
Route::get('/keuangan/l_jurnal/jurnal', 'KeuanganController@jurnal')->middleware('auth');
Route::get('/keuangan/analisaprogress/analisa', 'KeuanganController@analisa')->middleware('auth');
Route::get('/keuangan/analisaocf/analisa2', 'KeuanganController@analisa2')->middleware('auth');
Route::get('/keuangan/analisaaset/analisa3', 'KeuanganController@analisa3')->middleware('auth');
Route::get('/keuangan/analisacashflow/analisa4', 'KeuanganController@analisa4')->middleware('auth');
Route::get('/keuangan/analisaindex/analisa5', 'KeuanganController@analisa5')->middleware('auth');
Route::get('/keuangan/analisarasio/analisa6', 'KeuanganController@analisa6')->middleware('auth');
Route::get('/keuangan/analisabottom/analisa7', 'KeuanganController@analisa7')->middleware('auth');
Route::get('/keuangan/analisaroe/analisa8', 'KeuanganController@analisa8')->middleware('auth');

/*System*/
Route::get('/system/hakuser/user', 'SystemController@user')->middleware('auth');
Route::get('/system/hakakses/akses', 'SystemController@akses')->middleware('auth');
Route::get('/system/profilperusahaan/profil', 'SystemController@profil')->middleware('auth');
Route::get('/system/thnfinansial/finansial', 'SystemController@finansial')->middleware('auth');
Route::get('/system/hakuser/tambah_user', 'SystemController@tambah_user')->middleware('auth');
Route::get('/system/hakakses/tambah_akses', 'SystemController@tambah_akses')->middleware('auth');

	// Dirga Route
		
		// Route Modul Keuangan
			
			Route::get('modul_keuangan/connection', function () {
	            return keuangan::connection()->version();
	        });

	        // periode keuangan

				Route::post('modul/keuangan/periode/store', 'modul_keuangan\master\periode_keuangan\periode_keuangan_controller@save')->name('modul_keuangan.periode.save');

			// periode keuangan selesai

			// Master Data Group Akun

				Route::get('master/modul/keuangan/master/group-akun', [
					"uses"	=> 'modul_keuangan\master\group_akun\group_akun_controller@index'
				])->name('grup-akun.index');

				Route::get('master/modul/keuangan/master/group-akun/create', [
					"uses"	=> 'modul_keuangan\master\group_akun\group_akun_controller@create'
				])->name('grup-akun.create');

				Route::get('master/modul/keuangan/master/group-akun/datatable', [
					"uses"	=> 'modul_keuangan\master\group_akun\group_akun_controller@datatable'
				])->name('grup-akun.datatable');

				Route::get('master/modul/keuangan/master/group-akun/form_resource', [
					"uses"	=> 'modul_keuangan\master\group_akun\group_akun_controller@form_resource'
				])->name('grup-akun.form_resource');

				Route::post('master/modul/keuangan/master/group-akun/store', [
					"uses"	=> 'modul_keuangan\master\group_akun\group_akun_controller@store'
				])->name('grup-akun.store');

				Route::post('master/modul/keuangan/master/group-akun/update', [
					"uses"	=> 'modul_keuangan\master\group_akun\group_akun_controller@update'
				])->name('grup-akun.update');

				Route::post('master/modul/keuangan/master/group-akun/delete', [
					"uses"	=> 'modul_keuangan\master\group_akun\group_akun_controller@delete'
				])->name('grup-akun.delete');

			//  Group Akun End


			// Master Data Akun 

				Route::get('master/modul/keuangan/master/akun', [
					"uses"	=> 'modul_keuangan\master\akun\akun_controller@index'
				])->name('akun.index');

				Route::get('master/modul/keuangan/master/akun/create', [
					"uses"	=> 'modul_keuangan\master\akun\akun_controller@create'
				])->name('akun.create');

				Route::get('master/modul/keuangan/master/akun/create/form-resource', [
					"uses"	=> 'modul_keuangan\master\akun\akun_controller@form_resource'
				])->name('akun.form_resource');

				Route::post('master/modul/keuangan/master/akun/store', [
					"uses"	=> 'modul_keuangan\master\akun\akun_controller@store'
				])->name('akun.store');

				Route::get('master/modul/keuangan/master/akun/datatable', [
					"uses"	=> 'modul_keuangan\master\akun\akun_controller@datatable'
				])->name('akun.datatable');

				Route::post('master/modul/keuangan/master/akun/update', [
					"uses"	=> 'modul_keuangan\master\akun\akun_controller@update'
				])->name('akun.update');

				Route::post('master/modul/keuangan/master/akun/delete', [
					"uses"	=> 'modul_keuangan\master\akun\akun_controller@delete'
				])->name('akun.delete');

			// Data Akun Selesai


			// Golongan Aset

				Route::get('modul/keuangan/manajemen-aset/group-aset', [
					"uses"	=> 'modul_keuangan\aset\group\group_aset_controller@index'
				])->name('group.aset.index');

				Route::get('modul/keuangan/manajemen-aset/group-aset/create', [
					"uses"	=> 'modul_keuangan\aset\group\group_aset_controller@create'
				])->name('group.aset.create');

				Route::get('modul/keuangan/manajemen-aset/group-aset/form_resource', [
					"uses"	=> 'modul_keuangan\aset\group\group_aset_controller@form_resource'
				])->name('group.aset.form_resource');

				Route::post('modul/keuangan/manajemen-aset/group-aset/store', [
					"uses"	=> 'modul_keuangan\aset\group\group_aset_controller@store'
				])->name('group.aset.store');

				Route::get('modul/keuangan/manajemen-aset/group-aset/datatable', [
					"uses"	=> 'modul_keuangan\aset\group\group_aset_controller@datatable'
				])->name('group.aset.datatable');

				Route::post('modul/keuangan/manajemen-aset/group-aset/update', [
					"uses"	=> 'modul_keuangan\aset\group\group_aset_controller@update'
				])->name('group.aset.update');

				Route::post('modul/keuangan/manajemen-aset/group-aset/delete', [
					"uses"	=> 'modul_keuangan\aset\group\group_aset_controller@delete'
				])->name('group.aset.delete');

			// Golongan Aset


			// Aset

				Route::get('modul/keuangan/manajemen-aset/aset', [
					"uses"	=> 'modul_keuangan\aset\aset\aset_controller@index'
				])->name('aset.index');

				Route::get('modul/keuangan/manajemen-aset/aset/create', [
					"uses"	=> 'modul_keuangan\aset\aset\aset_controller@create'
				])->name('aset.create');

				Route::get('modul/keuangan/manajemen-aset/aset/form_resource', [
					"uses"	=> 'modul_keuangan\aset\aset\aset_controller@form_resource'
				])->name('aset.form_resource');

				Route::post('modul/keuangan/manajemen-aset/aset/store', [
					"uses"	=> 'modul_keuangan\aset\aset\aset_controller@store'
				])->name('aset.store');

				Route::get('modul/keuangan/manajemen-aset/aset/datatable', [
					"uses"	=> 'modul_keuangan\aset\aset\aset_controller@datatable'
				])->name('aset.datatable');

				Route::post('modul/keuangan/manajemen-aset/aset/update', [
					"uses"	=> 'modul_keuangan\aset\aset\aset_controller@update'
				])->name('aset.update');

				Route::post('modul/keuangan/manajemen-aset/aset/delete', [
					"uses"	=> 'modul_keuangan\aset\aset\aset_controller@delete'
				])->name('aset.delete');

			// Aset


			// Transaksi Kas

				Route::get('keuangan/modul/keuangan/transaksi/kas', [
					"uses"	=> 'modul_keuangan\transaksi\kas\transaksi_kas_controller@index'
				])->name('transaksi.kas.index');

				Route::get('keuangan/modul/keuangan/transaksi/kas/form-resource', [
					"uses"	=> 'modul_keuangan\transaksi\kas\transaksi_kas_controller@form_resource'
				])->name('transaksi.kas.form_resource');

				Route::post('keuangan/modul/keuangan/transaksi/kas/store', [
					"uses"	=> 'modul_keuangan\transaksi\kas\transaksi_kas_controller@store'
				])->name('transaksi.kas.store');

				Route::get('keuangan/modul/keuangan/transaksi/kas/datatable', [
					"uses"	=> 'modul_keuangan\transaksi\kas\transaksi_kas_controller@datatable'
				])->name('transaksi.kas.datatable');

				Route::post('keuangan/modul/keuangan/transaksi/kas/update', [
					"uses"	=> 'modul_keuangan\transaksi\kas\transaksi_kas_controller@update'
				])->name('transaksi.kas.update');

				Route::post('keuangan/modul/keuangan/transaksi/kas/delete', [
					"uses"	=> 'modul_keuangan\transaksi\kas\transaksi_kas_controller@delete'
				])->name('transaksi.kas.delete');

			// Transaksi Kas Selesai


			// Transaksi Bank

				Route::get('keuangan/modul/keuangan/transaksi/bank', [
					"uses"	=> 'modul_keuangan\transaksi\bank\transaksi_bank_controller@index'
				])->name('transaksi.bank.index');

				Route::get('keuangan/modul/keuangan/transaksi/bank/form-resource', [
					"uses"	=> 'modul_keuangan\transaksi\bank\transaksi_bank_controller@form_resource'
				])->name('transaksi.bank.form_resource');

				Route::post('keuangan/modul/keuangan/transaksi/bank/store', [
					"uses"	=> 'modul_keuangan\transaksi\bank\transaksi_bank_controller@store'
				])->name('transaksi.bank.store');

				Route::get('keuangan/modul/keuangan/transaksi/bank/datatable', [
					"uses"	=> 'modul_keuangan\transaksi\bank\transaksi_bank_controller@datatable'
				])->name('transaksi.bank.datatable');

				Route::post('keuangan/modul/keuangan/transaksi/bank/update', [
					"uses"	=> 'modul_keuangan\transaksi\bank\transaksi_bank_controller@update'
				])->name('transaksi.bank.update');

				Route::post('keuangan/modul/keuangan/transaksi/bank/delete', [
					"uses"	=> 'modul_keuangan\transaksi\bank\transaksi_bank_controller@delete'
				])->name('transaksi.bank.delete');

			// Transaksi Bank Selesai


			// Transaksi Memorial

				Route::get('keuangan/modul/keuangan/transaksi/memorial', [
					"uses"	=> 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@index'
				])->name('transaksi.memorial.index');

				Route::get('keuangan/modul/keuangan/transaksi/memorial/form-resource', [
					"uses"	=> 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@form_resource'
				])->name('transaksi.memorial.form_resource');

				Route::post('keuangan/modul/keuangan/transaksi/memorial/store', [
					"uses"	=> 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@store'
				])->name('transaksi.memorial.store');

				Route::get('keuangan/modul/keuangan/transaksi/memorial/datatable', [
					"uses"	=> 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@datatable'
				])->name('transaksi.memorial.datatable');

				Route::post('keuangan/modul/keuangan/transaksi/memorial/update', [
					"uses"	=> 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@update'
				])->name('transaksi.memorial.update');

				Route::post('keuangan/modul/keuangan/transaksi/memorial/delete', [
					"uses"	=> 'modul_keuangan\transaksi\memorial\transaksi_memorial_controller@delete'
				])->name('transaksi.memorial.delete');

			// Transaksi Memorial Selesai


			// Penerimaan Piutang

				Route::get('modul/keuangan/transaksi/penerimaan_piutang', [
					"uses"	=> 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@index'
				])->name('transaksi.penerimaan_piutang.index');

				Route::get('modul/keuangan/transaksi/penerimaan_piutang/form-resource', [
					"uses"	=> 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@form_resource'
				])->name('transaksi.penerimaan_piutang.form_resource');

				Route::post('modul/keuangan/transaksi/penerimaan_piutang/store', [
					"uses"	=> 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@store'
				])->name('transaksi.penerimaan_piutang.store');

				Route::get('modul/keuangan/transaksi/penerimaan_piutang/datatable', [
					"uses"	=> 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@datatable'
				])->name('transaksi.penerimaan_piutang.datatable');

				Route::get('modul/keuangan/transaksi/penerimaan_piutang/get/nota', [
					"uses"	=> 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@get_nota'
				])->name('transaksi.penerimaan_piutang.get_nota');

				Route::post('modul/keuangan/transaksi/penerimaan_piutang/update', [
					"uses"	=> 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@update'
				])->name('transaksi.penerimaan_piutang.update');

				Route::post('modul/keuangan/transaksi/penerimaan_piutang/delete', [
					"uses"	=> 'modul_keuangan\transaksi\penerimaan_piutang\penerimaan_piutang_controller@delete'
				])->name('transaksi.penerimaan_piutang.delete');

			// Penerimaan Piutang


			// Pelunasan Hutang

				Route::get('modul/keuangan/transaksi/pelunasan_hutang', [
					"uses"	=> 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@index'
				])->name('transaksi.pelunasan_hutang.index');

				Route::get('modul/keuangan/transaksi/pelunasan_hutang/form-resource', [
					"uses"	=> 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@form_resource'
				])->name('transaksi.pelunasan_hutang.form_resource');

				Route::post('modul/keuangan/transaksi/pelunasan_hutang/store', [
					"uses"	=> 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@store'
				])->name('transaksi.pelunasan_hutang.store');

				Route::get('modul/keuangan/transaksi/pelunasan_hutang/datatable', [
					"uses"	=> 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@datatable'
				])->name('transaksi.pelunasan_hutang.datatable');

				Route::get('modul/keuangan/transaksi/pelunasan_hutang/get/nota', [
					"uses"	=> 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@get_nota'
				])->name('transaksi.pelunasan_hutang.get_nota');

				Route::post('modul/keuangan/transaksi/pelunasan_hutang/update', [
					"uses"	=> 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@update'
				])->name('transaksi.pelunasan_hutang.update');

				Route::post('modul/keuangan/transaksi/pelunasan_hutang/delete', [
					"uses"	=> 'modul_keuangan\transaksi\pelunasan_hutang\pelunasan_hutang_controller@delete'
				])->name('transaksi.pelunasan_hutang.delete');

			// Pelunasan Hutang


			// Laporan Keuangan

				Route::get('modul/keuangan/laporan', function(){
					return view('modul_keuangan.laporan.index');
				})->name('laporan.keuangan.index');


				// laporan Jurnal Umum
					Route::get('modul/keuangan/laporan/jurnal_umum', [
						'uses'	=> 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@index'
					])->name('laporan.keuangan.jurnal_umum');

					Route::get('modul/keuangan/laporan/jurnal_umum/data_resource', [
						'uses'	=> 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@dataResource'
					])->name('laporan.keuangan.jurnal_umum.data_resource');

					Route::get('modul/keuangan/laporan/jurnal_umum/print', [
						'uses'	=> 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@print'
					])->name('laporan.keuangan.jurnal_umum.print');

					Route::get('modul/keuangan/laporan/jurnal_umum/print/excel', [
						'uses'	=> 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@excel'
					])->name('laporan.keuangan.jurnal_umum.print.excel');

					Route::get('modul/keuangan/laporan/jurnal_umum/print/pdf', [
						'uses'	=> 'modul_keuangan\laporan\jurnal\laporan_jurnal_controller@pdf'
					])->name('laporan.keuangan.jurnal_umum.print.pdf');


				// laporan Buku Besar
					Route::get('modul/keuangan/laporan/buku_besar', [
						'uses'	=> 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@index'
					])->name('laporan.keuangan.buku_besar');

					Route::get('modul/keuangan/laporan/buku_besar/data_resource', [
						'uses'	=> 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@dataResource'
					])->name('laporan.keuangan.buku_besar.data_resource');

					Route::get('modul/keuangan/laporan/buku_besar/print', [
						'uses'	=> 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@print'
					])->name('laporan.keuangan.buku_besar.print');

					Route::get('modul/keuangan/laporan/buku_besar/print/pdf', [
						'uses'	=> 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@pdf'
					])->name('laporan.keuangan.buku_besar.print.pdf');

					Route::get('modul/keuangan/laporan/buku_besar/print/excel', [
						'uses'	=> 'modul_keuangan\laporan\buku_besar\laporan_buku_besar_controller@excel'
					])->name('laporan.keuangan.buku_besar.print.excel');


				// laporan Neraca Saldo
					Route::get('modul/keuangan/laporan/neraca_saldo', [
						'uses'	=> 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@index'
					])->name('laporan.keuangan.neraca_saldo');

					Route::get('modul/keuangan/laporan/neraca_saldo/data_resource', [
						'uses'	=> 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@dataResource'
					])->name('laporan.keuangan.neraca_saldo.data_resource');

					Route::get('modul/keuangan/laporan/neraca_saldo/print', [
						'uses'	=> 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@print'
					])->name('laporan.keuangan.neraca_saldo.print');

					Route::get('modul/keuangan/laporan/neraca_saldo/print/pdf', [
						'uses'	=> 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@pdf'
					])->name('laporan.keuangan.neraca_saldo.print.pdf');

					Route::get('modul/keuangan/laporan/neraca_saldo/print/excel', [
						'uses'	=> 'modul_keuangan\laporan\neraca_saldo\laporan_neraca_saldo_controller@excel'
					])->name('laporan.keuangan.neraca_saldo.print.excel');


				// laporan Neraca
					Route::get('modul/keuangan/laporan/neraca', [
						'uses'	=> 'modul_keuangan\laporan\neraca\laporan_neraca_controller@index'
					])->name('laporan.keuangan.neraca');

					Route::get('modul/keuangan/laporan/neraca/data_resource', [
						'uses'	=> 'modul_keuangan\laporan\neraca\laporan_neraca_controller@dataResource'
					])->name('laporan.keuangan.neraca.data_resource');

					Route::get('modul/keuangan/laporan/neraca/print', [
						'uses'	=> 'modul_keuangan\laporan\neraca\laporan_neraca_controller@print'
					])->name('laporan.keuangan.neraca.print');

					Route::get('modul/keuangan/laporan/neraca/print/pdf', [
						'uses'	=> 'modul_keuangan\laporan\neraca\laporan_neraca_controller@pdf'
					])->name('laporan.keuangan.neraca.print.pdf');

					Route::get('modul/keuangan/laporan/neraca/print/excel', [
						'uses'	=> 'modul_keuangan\laporan\neraca\laporan_neraca_controller@excel'
					])->name('laporan.keuangan.neraca.print.excel');


				// laporan Laba Rugi
					Route::get('modul/keuangan/laporan/laba_rugi', [
						'uses'	=> 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@index'
					])->name('laporan.keuangan.laba_rugi');

					Route::get('modul/keuangan/laporan/laba_rugi/data_resource', [
						'uses'	=> 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@dataResource'
					])->name('laporan.keuangan.laba_rugi.data_resource');

					Route::get('modul/keuangan/laporan/laba_rugi/print', [
						'uses'	=> 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@print'
					])->name('laporan.keuangan.laba_rugi.print');

					Route::get('modul/keuangan/laporan/laba_rugi/print/pdf', [
						'uses'	=> 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@pdf'
					])->name('laporan.keuangan.laba_rugi.print.pdf');

					Route::get('modul/keuangan/laporan/laba_rugi/print/excel', [
						'uses'	=> 'modul_keuangan\laporan\laba_rugi\laporan_laba_rugi_controller@excel'
					])->name('laporan.keuangan.laba_rugi.print.excel');

			// laporan Keuangan

		// End Route Modul

	// End Dirga Route

});
