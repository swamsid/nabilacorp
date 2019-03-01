@extends('main')

@section('title', 'Tambah Data Akun Cabang')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/wait_me_v_1_1/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/select2/dist/css/select2.min.css') }}">

@endsection


@section('content')
    <div class="col-md-12" style="background: none;" id="vue-component">
    	<div class="col-md-12">
    		<div class="row">
    			<div class="col-md-6 content-title">
    				Tambah Data Akun Cabang &nbsp;
                    <i class="fa fa-info-circle" title="Akun Cabang Adalah Akun-Akun Yang Nantinya Akan Digunakan Oleh Cabang-Cabang Perusahaan."></i>
    			</div>

    			<div class="col-md-6 text-right form-status">
    				<span v-if="stat == 'standby'" v-cloak>
                        <i class="fa fa-exclamation"></i> &nbsp; Pastikan Data Terisi Dengan Benar            
                    </span>

                    <div class="loader" v-if="stat == 'loading'" v-cloak>
                       <div class="loading"></div> &nbsp; <span>@{{ statMessage }}</span>
                    </div>
    			</div>
    		</div>	
    	</div>

    	<div class="col-md-12 table-content">
            <form id="data-form" v-cloak>
                <input type="hidden" readonly name="_token" value="{{ csrf_token() }}">
                <input type="hidden" readonly name="ak_id" v-model="singleData.ak_id">
                <div class="row">
                    <div class="col-md-6" style="background: none;">
                        <div class="row">
                            <div class="col-md-12 mt-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="modul-keuangan">Type Akun</label>
                                    </div>

                                    <div class="col-md-3">
                                        <vue-select :name="'ak_type'" :id="'ak_type'" :options="type" :disabled="onUpdate"></vue-select>
                                    </div>

                                    <div class="col-md-1 form-info-icon link" @click="search" v-if="!onUpdate">
                                        <i class="fa fa-search" title="Cari Akun Berdasarkan Type Akun"></i>
                                    </div>

                                    <div class="col-md-1 form-info-icon link" @click="formReset" v-if="onUpdate">
                                        <i class="fa fa-times" title="Bersihkan Pencarian" style="color: #CC0000;"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="modul-keuangan">Kelompok Akun</label>
                                    </div>

                                    <div class="col-md-5">
                                        <vue-select :name="'ak_kelompok'" :id="'ak_kelompok'" :options="kelompok" :disabled="onUpdate" @input="kelompokChange" :search="true"></vue-select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="modul-keuangan">Nomor Akun *</label>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="input-group">
                                          <div class="input-group-prepend modul-keuangan">
                                            <span class="input-group-text" id="basic-addon1">@{{ singleData.parrentId }}.</span>
                                          </div>

                                          <input type="text" name="ak_nomor" class="form-control modul-keuangan" placeholder="contoh: 001" v-model="singleData.ak_nomor" title="Tidak Boleh Kosong, Hanya Angka" @keypress="onlyNumber" :readonly="onUpdate">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="modul-keuangan">Nama Akun *</label>
                                    </div>

                                    <div class="col-md-7">
                                        <input type="text" name="ak_nama" class="form-control modul-keuangan" :placeholder="singleData.placeholderNama" v-model="singleData.ak_nama" title="Tidak Boleh Kosong">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-form" v-if="conteks == 'detail'">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="modul-keuangan">Posisi Debet/Kredit</label>
                                    </div>

                                    <div class="col-md-7">
                                        <vue-select :name="'ak_posisi'" :id="'ak_posisi'" :options="posisi"></vue-select>
                                    </div>
                                </div>
                            </div>

                            @if(modulSetting()['support_cabang'])
                                <div class="col-md-12 mt-form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="modul-keuangan"></label>
                                        </div>

                                        <div class="col-md-7">
                                            <input type="checkbox" name="resiprokal" title="Centang Untuk Menjadikan Akun Ini Sebagai Akun Resiprokal" v-model="resiprokal">

                                            <span style="font-size: 8pt; margin-left: 5px;">
                                                Akun Ini Termasuk Akun Resiprokal. &nbsp;
                                                <a href="https://www.google.com/search?q=akun+resiprokal&oq=akun+res&aqs=chrome.0.69i59j69i57j69i60l3j0.3851j0j7&sourceid=chrome&ie=UTF-8" target="_blank" title="Akun Resiprokal Adalah Akun-Akun Yang Nantinya Akan Dieliminasi Saat Penyusunan Laporan Keuangan Gabungan.">
                                                   <i class="fa fa-info-circle"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-9" v-if="locked">
                                <div class="modul-keuangan-alert primary" role="alert" style="margin-top: 30px;">
                                  <i class="fa fa-info-circle"></i> &nbsp;&nbsp;Akun Dikunci. Tidak Bisa Dinonaktifkan
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">

                        <table class="table table-stripped table-bordered table-mini">
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align: left; color: #0099CC; padding-left: 20px;">
                                        <i class="fa fa-arrow-right"></i> &nbsp;Data Akun Cabang Yang Sudah Disimpan &nbsp;<small style="color: #666;"> - Sesuai Dengan kelompok Akun Yang Dipilih</small>
                                    </th>
                                </tr>
                            </thead>
                        </table>

                        <div style="height: 300px; background: #fafafa; overflow-y: scroll;">
                            <table class="table table-stripped table-bordered table-mini">
                                <thead>
                                    <tr>
                                        <th width="30%">Nomor Akun</th>
                                        <th width="60%">Nama Akun</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <template v-for="data in listAkun">
                                        <tr>
                                            <td style="text-align: center;">@{{ data.nomor }}</td>
                                            <td style="text-align: left;">@{{ data.text }}</td>
                                        </tr>
                                    </template>

                                    <template v-if="listAkun.length == 0">
                                        <tr>
                                            <td colspan="2" style="text-align: center;">Tidak Ada Data</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row content-button">
                    <div class="col-md-6">
                        <a href="{{ route('akun.cabang.index') }}">
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-arrow-left" :disabled="btnDisabled"></i> &nbsp;Kembali Ke Halaman Data Akun Cabang</button>
                        </a>
                    </div>

                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-info btn-sm" @click="updateData" :disabled="btnDisabled" v-if="onUpdate"><i class="fa fa-floppy-o"></i> &nbsp;Simpan Perubahan</button>

                        <button type="button" class="btn btn-danger btn-sm" @click="deleteData" :disabled="btnDisabled" v-if="onUpdate && dataIsActive"><i class="fa fa-times"></i> &nbsp;Nonaktifkan</button>

                        <button type="button" class="btn btn-success btn-sm" @click="deleteData" :disabled="btnDisabled" v-if="onUpdate && !dataIsActive"><i class="fa fa-check-square-o"></i> &nbsp;Aktifkan</button>

                        <button type="button" class="btn btn-primary btn-sm" @click="saveData" :disabled="btnDisabled" v-if="!onUpdate"><i class="fa fa-floppy-o"></i> &nbsp;Simpan</button>
                    </div>
                </div>
            </form>
    	</div>

        <div class="ez-popup" id="data-popup">
            <div class="layout" style="width: 70%">
                <div class="top-popup" style="background: none;">
                    <span class="title">
                        Data Akun Cabang Yang Sudah Dibuat
                    </span>

                    <span class="close"><i class="fa fa-times" style="font-size: 12pt; color: #CC0000"></i></span>
                </div>
                
                <div class="content-popup">
                    <vue-datatable :data_resource="list_data_table" :columns="data_table_columns" :selectable="true" :ajax_on_loading="onAjaxLoading" :index_column="'ac_id'" @selected="dataSelected"></vue-datatable>
                </div>
            </div>
        </div>

    </div>
@endsection


@section(modulSetting()['extraScripts'])
	
	<script src="{{ asset('modul_keuangan/js/options.js') }}"></script>

    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/vue_2_x.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/datatable.component.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/select.component.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/vue_2_x/components/inputmask.component.js') }}"></script>

    <script src="{{ asset('modul_keuangan/js/vendors/wait_me_v_1_1/wait.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/inputmask/inputmask.jquery.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/validator/bootstrapValidator.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>

	<script type="text/javascript">

        function register_validator(){
            $('#data-form').bootstrapValidator({
                feedbackIcons : {
                  valid : 'glyphicon glyphicon-ok',
                  invalid : 'glyphicon glyphicon-remove',
                  validating : 'glyphicon glyphicon-refresh'
                },
                fields : {
                  ak_nama : {
                    validators : {
                      notEmpty : {
                        message : 'Nama Akun Tidak Boleh Kosong',
                      }
                    }
                  },

                  ak_nomor : {
                    validators : {
                      notEmpty : {
                        message : 'Nomor Akun Tidak Boleh Kosong',
                      }
                    }
                  },

                  ak_kelompok : {
                    validators : {
                      notEmpty : {
                        message : 'Kelompok Akun Harus Dipilih',
                      }
                    }
                  },

                }
            });
        }

		var app = new Vue({
            el: '#vue-component',
            data: {
                stat: 'standby',
                statMessage: '',
                btnDisabled: false,
                onAjaxLoading: false,
                onUpdate: false,
                locked: false,
                dataIsActive: true,
                resiprokal: false,
                conteks: 'detail',

                data_table_columns : [
                    {name: 'Nomor Akun', context: 'ac_nomor', width: '20%', childStyle: 'text-align: center'},
                    {name: 'Nama Akun', context: 'ac_nama', width: '40%', childStyle: 'text-align: left'},
                    {name: 'Posisi Akun', context: 'ac_posisi', width: '20%', childStyle: 'text-align: center', override: function(e){
                        if(e == 'D')
                            return 'Debet';
                        else if(e == 'K')
                            return 'Kredit';
                        else
                            return '-';
                    }},
                    {name: 'Aktif', context: 'ac_isactive', width: '20%', childStyle: 'text-align: center', override: function(e){
                        if(e === '1')
                            return '<i class="fa fa-check-square-o" style="color: #007E33;"></i>';

                        return '<i class="fa fa-square-o" style="color: #CC0000;"></i>';
                    }},
                ],

                list_data_table : [],

                type: [
                    {
                        id      : 'detail',
                        text    : 'Detail'
                    },
                ],

                posisi: [
                    {
                        id      : 'D',
                        text    : 'Debet'
                    },

                    {
                        id      : 'K',
                        text    : 'Kredit'
                    }
                ],

                kelompok: [],

                kelompokDetail: [],
                kelompok: [],
                groupNeraca: [],
                groupArusKas: [],
                groupLabaRugi: [],

                listAkun: [],

                singleData: {
                    ak_id: '',
                    ak_nama: '',
                    ak_nomor: '',
                    parrentId: 1,
                    placeholderNama: 'Contoh : Kas / Bank / Piutang Usaha',
                }
            },

            created: function(){
                console.log('Initializing Vue');
            },

            mounted: function(){
                console.log('Vue Ready');
                this.kelompok = this.kelompokParrent;
                register_validator();

                axios.get('{{route('akun.cabang.form_resource')}}')
                          .then((response) => {
                            // console.log(response.data.akun_parrent);
                            this.kelompokDetail = response.data.akun_parrent;
                            this.kelompok = response.data.kelompok;
                            this.singleData.parrentId = response.data.kelompok[0].id

                            this.kelompokChange(this.kelompok[0].id);

                          })
                          .catch((e) => {
                            alert('error '+e);
                          })
            },

            computed: {
                // ---
            },

            watch: {
                // ---
            },

            methods: {
                saveData: function(evt){
                    evt.preventDefault();
                    evt.stopImmediatePropagation();

                    if($('#data-form').data('bootstrapValidator').validate().isValid()){
                        this.stat = 'loading';
                        this.statMessage = 'Sedang Menyimpan Data ..'
                        this.btnDisabled = true;

                        axios.post('{{ route('akun.cabang.store') }}', $('#data-form').serialize())
                                .then((response) => {
                                    console.log(response.data);
                                    
                                    if(response.data.status == 'berhasil'){
                                        $.toast({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'success',
                                            hideAfter: 5000
                                        });

                                        if(typeof response.data.akun_parrent !== 'undefined'){
                                            this.kelompokDetail = response.data.akun_parrent;
                                            this.kelompokChange($('#ak_kelompok').val());
                                        }

                                        this.formReset();
                                    }else{
                                        $.toast({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false
                                        });

                                        this.stat = 'standby';
                                    }

                                })
                                .catch((err) => {
                                    alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                                })
                                .then(() => {
                                    this.btnDisabled = false;
                                })
                    }
                },

                updateData: function(evt){
                    evt.preventDefault();
                    evt.stopImmediatePropagation();

                    if($('#data-form').data('bootstrapValidator').validate().isValid()){
                        this.stat = 'loading';
                        this.statMessage = 'Sedang Memperbarui Data ..'
                        this.btnDisabled = true;

                        axios.post('{{ route('akun.cabang.update') }}', $('#data-form').serialize())
                                .then((response) => {
                                    console.log(response.data);
                                    
                                    if(response.data.status == 'berhasil'){
                                        $.toast({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'success',
                                            hideAfter: 5000
                                        });

                                        if(typeof response.data.akun_parrent !== 'undefined'){
                                            this.kelompokDetail = response.data.akun_parrent;
                                            this.kelompokChange($('#ak_kelompok').val());
                                        }

                                        this.formReset();
                                    }else{
                                        $.toast({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false
                                        });

                                        this.stat = 'standby';
                                    }

                                })
                                .catch((err) => {
                                    alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                                })
                                .then(() => {
                                    this.btnDisabled = false;
                                })
                    }
                },

                deleteData: function(evt){
                    evt.preventDefault();
                    evt.stopImmediatePropagation();

                    if(this.locked){
                        $.toast({
                            text: "Akun Ini Sedang Dikunci (Digunakan Oleh Sistem). Tidak Bisa Dinonaktifkan",
                            showHideTransition: 'slide',
                            position: 'top-right',
                            icon: 'info',
                            hideAfter: 10000
                        });
                    }else{
                        var cfrm = confirm('Apakah Anda Yakin ?');

                        if(cfrm){
                            this.stat = 'loading';
                            this.statMessage = 'Sedang Merubah Status Aktif Data ..'
                            this.btnDisabled = true;

                            axios.post('{{ route('akun.cabang.delete') }}', { ak_id: this.singleData.ak_id, _token: '{{ csrf_token() }}' })
                                    .then((response) => {
                                        // console.log(response.data);
                                        
                                        if(response.data.status == 'berhasil'){
                                            $.toast({
                                                text: response.data.message,
                                                showHideTransition: 'slide',
                                                position: 'top-right',
                                                icon: 'success',
                                                hideAfter: 5000
                                            });

                                            if(typeof response.data.akun_parrent !== 'undefined')
                                                this.kelompokDetail = response.data.akun_parrent;

                                            this.formReset();
                                        }else{
                                            $.toast({
                                                text: response.data.message,
                                                showHideTransition: 'slide',
                                                position: 'top-right',
                                                icon: 'error',
                                                hideAfter: false
                                            });

                                            this.stat = 'standby';
                                        }

                                    })
                                    .catch((err) => {
                                        alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                                    })
                                    .then(() => {
                                        this.btnDisabled = false;
                                    })
                        }
                    }
                },

                kelompokChange: function(e){
                    this.singleData.parrentId = e;

                    this.listAkun = $.grep(this.kelompokDetail, function(x) { return x.nomor.substring(0, e.length) == e })
                },

                search: function(e){
                    e.preventDefault();
                    this.list_data_table = [];
                    this.onAjaxLoading = true;

                    axios.get('{{ Route('akun.cabang.datatable') }}?type='+$('#ak_type').val())
                            .then((response) => {
                                // console.log(response.data);
                                if(response.data.length){
                                    this.list_data_table = response.data;
                                }
                            })
                            .then(() => {
                                this.onAjaxLoading = false;
                            })
                            .catch((err) => {
                                alert('Ups. Sistem Mengalami kesalahan. Message: '+err);
                            })

                    $('#data-popup').ezPopup('show');
                },

                dataSelected: function(e){
                    var idx = this.list_data_table.findIndex(a => a.ac_id === e);
                    var conteks = this.list_data_table[idx];
                    var cek = (parseInt(this.list_data_table[idx]['ac_kelompok'].length) + 1);

                    $('#ak_kelompok').val(conteks['ac_kelompok']).trigger('change.select2');

                    this.singleData.ak_nomor = conteks['ac_nomor'].substring(cek);
                    this.singleData.ak_nama = conteks['ac_nama'];
                    this.singleData.ak_id = conteks['ac_id'];
                    this.resiprokal = (conteks['ac_resiprokal'] == '1') ? true : false;

                    console.log(conteks);
                    // alert(conteks['ac_resiprokal']);

                    $('#ak_posisi').val(conteks['ac_posisi']).trigger('change.select2');
                    $('#ak_opening').val(conteks['ac_opening']);

                    if(this.list_data_table[idx].ac_status == 'locked'){
                        this.locked = true;
                    }

                    if(this.list_data_table[idx].ac_isactive == '0'){
                        this.dataIsActive = false;
                    }

                    this.onUpdate = true;
                    this.kelompokChange(this.list_data_table[idx]['ac_kelompok']);
                    $('#data-popup').ezPopup('close');
                },

                onlyNumber: function(e){
                    if(isNaN(e.key))
                      e.preventDefault()
                    else
                      return true;
                },

                formReset: function(){
                    this.singleData.ak_nomor = '';
                    this.singleData.ak_nama = '';
                    this.resiprokal = false;


                    // if(this.kelompok.length > 0){
                    //     $('#ak_kelompok').val(this.kelompok[0]['id']).trigger('change.select2');
                    //     this.kelompokChange(this.kelompok[0]['id']);
                    // }
                    
                    if(this.groupNeraca.length > 0)
                        $('#ak_group_neraca').val(this.groupNeraca[0]['id']).trigger('change.select2');
                    
                    if(this.groupLabaRugi.length > 0)
                        $('#ak_group_lr').val(this.groupLabaRugi[0]['id']).trigger('change.select2');
                    
                    if(this.groupArusKas.length > 0)
                        $('#ak_group_ak').val(this.groupArusKas[0]['id']).trigger('change.select2');

                    $('#ak_posisi').val(this.posisi[0]['id']).trigger('change.select2');
                    $('#ak_opening').val(0);

                    this.stat = 'standby';
                    this.onUpdate = false;
                    this.locked = false;
                    this.dataIsActive = true;

                    $('#data-form').data('bootstrapValidator').resetForm();
                }
            }
        })

    </script>

@endsection