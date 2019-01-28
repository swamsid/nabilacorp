<?php

Route::group(['namespace' => 'App\Modules\Hrd\Controllers', 'middleware'=>['web','auth']], function () {
	
//Mahmud Absensi
    Route::get('/hrd/absensi/index', 'AbsensiController@index');
    Route::get('/hrd/absensi/table/manajemen/{tgl1}/{tgl2}/{data}', 'AbsensiController@table');
    Route::get('/hrd/absensi/peg/save', 'AbsensiController@savePeg');
    Route::get('/hrd/absensi/detail/{tgl1}/{tgl2}/{tampil}', 'AbsensiController@detAbsensi');
    Route::post('/import/data-manajemen', 'AbsensiController@importDataManajemen');
    Route::post('/import/data-produksi', 'AbsensiController@importDataProduksi');
    Route::get('/export/id-manajemen', 'AbsensiController@exportManajemen');
    Route::get('/export/id-produksi', 'AbsensiController@exportProduksi');
//Mahmud Setting Payroll
    Route::get('/hrd/payroll/setting-gaji', 'GajiController@settingGajiMan');
    Route::get('/hrd/payroll/datatable-gaji-man', 'GajiController@gajiManData');
    Route::get('/hrd/payroll/tambah-gaji-man', 'GajiController@tambahGajiMan');
    Route::post('/hrd/payroll/simpan-gaji-man', 'GajiController@simpanGajiMan');
    Route::get('/hrd/payroll/edit-gaji-man/{id}', 'GajiController@editGajiMan');
    Route::put('/hrd/payroll/update-gaji-man/{id}', 'GajiController@updateGajiMan');
    Route::get('/hrd/payroll/delete-gaji-man/{id}', 'GajiController@deleteGajiMan');
    Route::get('/hrd/payroll/datatable-gaji-pro', 'GajiController@gajiProData');
    Route::get('/hrd/payroll/tambah-gaji-pro', 'GajiController@tambahGajiPro');
    Route::post('/hrd/payroll/simpan-gaji-pro', 'GajiController@simpanGajiPro');
    Route::get('/hrd/payroll/edit-gaji-pro/{id}', 'GajiController@editGajiPro');
    Route::put('/hrd/payroll/update-gaji-pro/{id}', 'GajiController@updateGajiPro');
    Route::delete('/hrd/payroll/delete-gaji-pro/{id}', 'GajiController@deleteGajiPro');
    Route::get('/hrd/payroll/datatable-potongan', 'GajiController@potonganData');
    Route::get('/hrd/payroll/tambah-potongan', 'GajiController@tambahPotongan');
    Route::post('/hrd/payroll/simpan-potongan', 'GajiController@simpanPotongan');
    Route::get('/hrd/payroll/edit-potongan/{id}', 'GajiController@editPotongan');
    Route::put('/hrd/payroll/update-potongan/{id}', 'GajiController@updatePotongan');
    Route::delete('/hrd/payroll/delete-potongan/{id}', 'GajiController@deletePotongan');
    Route::get('/hrd/payroll/tambah-tunjangan', 'GajiController@tambahTunjangan');
    Route::post('/hrd/payroll/simpan-tunjangan', 'GajiController@simpanTunjangan');
    Route::get('/hrd/payroll/datatable-tunjangan-man', 'GajiController@tunjanganManData');
    Route::get('/hrd/payroll/edit-tunjangan-man/{id}', 'GajiController@editTunjangan');
    Route::post('/hrd/payroll/update-tunjangan/{id}', 'GajiController@updateTunjangan');
    Route::delete('/hrd/payroll/delete-tunjangan/{id}', 'GajiController@deleteTunjangan');
    Route::get('/hrd/payroll/set-tunjangan-pegawai-man', 'GajiController@setTunjanganPegMan');
    Route::get('/hrd/payroll/datatable-tunjangan-pegman', 'GajiController@tunjanganPegManData');
    Route::get('/hrd/payroll/edit-tunjangan-pegman/{id}', 'GajiController@editPegManData');
    Route::post('/hrd/payroll/update-tunjangan-peg/{id}', 'GajiController@updateTunjanganPeg');
/*Data Lembur*/
    Route::get('/hrd/datalembur/index', 'HlemburController@index');
    Route::get('/hrd/datalembur/get-lembur-by-tgl/{tgl1}/{tgl2}', 'HlemburController@getLemburByTgl');
    Route::get('/hrd/datalembur/lookup-data-divisi', 'HlemburController@lookup_divisi');
    Route::get('/hrd/datalembur/lookup-data-jabatan', 'HlemburController@lookup_jabatan');
    Route::get('/hrd/datalembur/lookup-data-pegawai', 'HlemburController@lookup_pegawai');
    Route::post('/hrd/datalembur/simpan-lembur', 'HlemburController@simpanLembur');
    Route::get('/hrd/datalembur/get-detail/{id}/{id2}', 'HlemburController@getDataDetail');
    Route::get('/hrd/datalembur/get-edit/{id}/{id2}', 'HlemburController@getDataEdit');
    Route::post('/hrd/datalembur/update-lembur', 'HlemburController@updateLembur');
    Route::post('/hrd/datalembur/delete-lembur', 'HlemburController@deleteLembur');
    Route::get('/hrd/datalembur/print/{id}/{id2}', 'HlemburController@print');
/*Input SCOREBOARD*/
    Route::get('/hrd/inputkpi/index', 'DkpiController@index');
    Route::get('/hrd/inputkpi/get-kpi-by-tgl/{tgl1}/{tgl2}', 'DkpiController@getKpiByTgl');
    Route::get('/hrd/inputkpi/set-field-modal', 'DkpiController@setFieldModal');
    Route::post('/hrd/inputkpi/simpan-data', 'DkpiController@simpanData');
    Route::get('/hrd/inputkpi/get-edit/{id}', 'DkpiController@getDataEdit');
    Route::post('/hrd/inputkpi/update-data', 'DkpiController@updateData');
    Route::post('/hrd/inputkpi/delete-data', 'DkpiController@deleteData');
/*Manajemen SCOREBOARD*/
    Route::get('/hrd/manajemenkpipegawai/index', 'MankpiController@index');
    Route::get('/hrd/manajemenkpipegawai/get-kpi-by-tgl/{tgl1}/{tgl2}/{tampil}', 'MankpiController@getKpiByTgl');
    Route::get('/hrd/manajemenkpipegawai/get-edit/{id}', 'MankpiController@getDataEdit');
    Route::post('/hrd/manajemenkpipegawai/update-data', 'MankpiController@updateData');
    Route::post('/hrd/manajemenkpipegawai/ubah-status', 'MankpiController@ubahStatus');
/*Input KPI*/
    Route::get('/hrd/inputkpix/index', 'DkpixController@index');
    Route::get('/hrd/inputkpix/tambah-data', 'DkpixController@tambahData');
    Route::get('/hrd/inputkpix/lookup-data-jabatan', 'DkpixController@lookupJabatan');
    Route::get('/hrd/inputkpix/lookup-data-pegawai', 'DkpixController@lookupPegawai');
    Route::get('/hrd/inputkpix/set-field-modal/{id}', 'DkpixController@setFieldModal');
    Route::post('/hrd/inputkpix/simpan-data', 'DkpixController@simpanData');
    Route::get('/hrd/inputkpix/get-kpi-by-tgl/{tgl1}/{tgl2}', 'DkpixController@getKpixByTgl');
    Route::get('/hrd/inputkpix/get-edit/{id}', 'DkpixController@getDataEdit');
    Route::post('/hrd/inputkpix/update-data', 'DkpixController@updateData');
    Route::post('/hrd/inputkpix/delete-data', 'DkpixController@deleteData');
/*Manajemen SCOREBOARD & KPI FINAL*/
    Route::get('/hrd/manscorekpi/index', 'ManscorekpiController@index');
    Route::get('/hrd/manscorekpi/get-kpi-by-tgl/{tgl1}/{tgl2}/{tampil}', 'ManscorekpiController@getKpiByTgl');
    Route::get('/hrd/manscorekpi/get-edit/{id}', 'ManscorekpiController@getDataEdit');
    Route::post('/hrd/manscorekpi/update-data', 'ManscorekpiController@updateData');
    Route::post('/hrd/manscorekpi/ubah-status', 'ManscorekpiController@ubahStatus');
    Route::get('/hrd/manscorekpi/get-score-by-tgl/{tgl1}/{tgl2}/{tampil}', 'ManscorekpiController@getScoreByTgl');
//Mahmud Training
    Route::get('/hrd/training/form_training', 'TrainingContoller@tambah_training')->name('form_training');
    Route::get('/hrd/training/training', 'TrainingContoller@training')->name('training');
    Route::get('/hrd/training/save', 'TrainingContoller@savePengajuan');
    Route::get('/hrd/training/save/form', 'TrainingContoller@savePengajuanForm');
    Route::get('/hrd/training/tablePengajuan/{tgl1}/{tgl2}/{data}/{peg}', 'TrainingContoller@tablePengajuan');
    Route::get('/hrd/training/acc-pelatihan/{id}', 'TrainingContoller@accPelatihan');
    Route::get('/hrd/training/lihat-waktu/{id}', 'TrainingContoller@lihatWaktu');
    Route::get('/hrd/training/wakti-pelatihan', 'TrainingContoller@reqTimeTraining');
    Route::get('/hrd/training/doc-pelatihan/{id}', 'TrainingContoller@printDoc');
/*Recruitment*/
    Route::get('/hrd/recruitment/rekrut', 'RecruitmentController@rekrut')->name('rekrut');
    Route::get('/hrd/recruitment/get-data-hrd', 'RecruitmentController@getDataHrd');
    Route::get('/hrd/recruitment/get-data-hrd-diterima', 'RecruitmentController@getDataHrdDiterima');
    Route::get('/hrd/recruitment/process_rekrut/{id}', 'RecruitmentController@process_rekrut');
    Route::get('/hrd/recruitment/preview_rekrut/{id}', 'RecruitmentController@preview_rekrut');
    Route::post('/hrd/recruitment/approval_1', 'RecruitmentController@approval_1');
    Route::post('/hrd/recruitment/update_approval_1', 'RecruitmentController@update_approval_1');
    Route::post('/hrd/recruitment/approval_2', 'RecruitmentController@approval_2');
    Route::post('/hrd/recruitment/update_approval_2', 'RecruitmentController@update_approval_2');
    Route::post('/hrd/recruitment/skip_approval_2', 'RecruitmentController@skip_approval_2');
    Route::post('/hrd/recruitment/approval_3', 'RecruitmentController@approval_3');
    Route::post('/hrd/recruitment/approval_3_skip', 'RecruitmentController@approval_3_skip');
    Route::get('/hrd/recruitment/autocomplete-pic', 'RecruitmentController@autocomplete');
    Route::get('/hrd/recruitment/get-jadwal-interview/{id}', 'RecruitmentController@getJadwalInterview');
    Route::post('/hrd/recruitment/proc-jadwal-interview', 'RecruitmentController@procJadwalInterview');
    Route::get('/hrd/recruitment/get-jadwal-presentasi/{id}', 'RecruitmentController@getJadwalPresentasi');
    Route::post('/hrd/recruitment/proc-jadwal-presentasi', 'RecruitmentController@procJadwalPresentasi');
    Route::get('/hrd/recruitment/get-data-set-pegawai/{id}/{id2}', 'RecruitmentController@getDataSetPegawai');
    Route::post('/hrd/recruitment/simpan-pegawai-baru', 'RecruitmentController@simpanPegawaiBaru');
    Route::post('/hrd/recruitment/delete-data-pelamar', 'RecruitmentController@deleteDataPelamar');
    Route::get('/hrd/recruitment/buat_pdf', 'RecruitmentController@buat_pdf');
// print KPI
    Route::get('/hrd/manscorekpi/print_kpi/{id}', 'ManscorekpiController@print_pki')->name('print_kpi');
// print payroll
    Route::get('/hrd/payrollman/print-payroll/{id}', 'PayrollmanController@print_payroll');
//payroll produksi Mahmud
    Route::get('/hrd/produksi/payroll', 'PayrollProduksiController@index');
    Route::get('/hrd/payroll/table/gaji/{rumah}/{jabatan}/{tgl1}/{tgl2}', 'PayrollProduksiController@tableDataGarapan');
     Route::get('/hrd/payroll/table/gaji/GR/{rumah}/{jabatan}/{tgl1}/{tgl2}', 'PayrollProduksiController@tableDataGarapanGr');
    Route::get('/hrd/payroll/lihat-gaji/{id}/{tgl1}/{tgl2}', 'PayrollProduksiController@lihatGaji');
    Route::get('/hrd/payroll/lihat-gaji/GR/{id}/{tgl1}/{tgl2}', 'PayrollProduksiController@lihatGajiGR');
    Route::get('/hrd/payroll/pilih/absensi/{pilih}', 'PayrollProduksiController@pilihAbsensi');
    Route::get('/hrd/payroll/print-gaji/GR/{id}/{tgl1}/{tgl2}', 'PayrollProduksiController@printGajiGr');
    Route::get('/hrd/payroll/print-gaji/nonGR/{id}/{tgl1}/{tgl2}', 'PayrollProduksiController@printGajinonGr');
//Data Garapan/
    Route::get('produksi/garapan/index', 'GarapanPegawaiController@index');
    Route::get('produksi/garapan/table/{rumah}/{item}/{jabatan}/{tgl}', 'GarapanPegawaiController@tableGarapan');
    Route::get('produksi/garapan/save', 'GarapanPegawaiController@saveGarapan');
    Route::get('produksi/garapan/table/data/{rumah}/{item}/{jabatan}/{tgl1}/{tgl2}', 'GarapanPegawaiController@tableDataGarapan');

/*PAYROLL MANAJEMEN*/
    Route::get('/hrd/payrollman/index', 'PayrollmanController@index');
    Route::get('/hrd/payrollman/get-payroll-man', 'PayrollmanController@listGajiManajemen');
    Route::get('/hrd/payrollman/lookup-data-divisi', 'PayrollmanController@lookupDivisi');
    Route::get('/hrd/payrollman/lookup-data-jabatan', 'PayrollmanController@lookupJabatan');
    Route::get('/hrd/payrollman/lookup-data-pegawai', 'PayrollmanController@lookupPegawai');
    Route::get('/hrd/payrollman/set-field-modal', 'PayrollmanController@setFieldModal');
    Route::post('/hrd/payrollman/simpan-data', 'PayrollmanController@simpanData');
    Route::get('/hrd/payrollman/get-detail/{id}', 'PayrollmanController@getDataDetail');
    Route::post('/hrd/payrollman/delete-data', 'PayrollmanController@deleteData');
});



