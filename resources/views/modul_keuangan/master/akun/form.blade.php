@extends('main')

@section('title', 'Tambah Data Akun')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/wait_me_v_1_1/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/select2/dist/css/select2.min.css') }}">

@endsection


@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Form Data Akun Keuangan</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Master Data Akun Keuangan</li>
        </ol>
        <div class="clearfix">
        </div>
    </div>
    <div class="page-content fadeInRight">
        <div id="tab-general">
            <div class="row mbl">
                <div class="col-lg-12">
                    <div id="generalTabContent" class="tab-content responsive">
                        <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <form id="data-form" v-cloak>
                                            <input type="hidden" readonly name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" readonly name="ak_id" v-model="singleData.ak_id">
                                            <div class="row">
                                                <div class="col-md-6" style="background: none;">
                                                    <div class="row">
                                                        <div class="col-md-12 mt-form">
                                                            <div class="row">
                                                                <div class="col-md-4">
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
                                                                <div class="col-md-4">
                                                                    <label class="modul-keuangan">Kelompok Akun</label>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <vue-select :name="'ak_kelompok'" :id="'ak_kelompok'" :options="kelompok" :disabled="onUpdate" @input="kelompokChange" :search="true"></vue-select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-form">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="modul-keuangan">Nomor Akun *</label>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <div class="input-group">
                                                                      <span class="input-group-addon" id="basic-addon1">@{{ singleData.parrentId }}.</span>
                                                                      <input type="text" name="ak_nomor" class="form-control modul-keuangan" placeholder="contoh: 001" v-model="singleData.ak_nomor" title="Tidak Boleh Kosong, Hanya Angka" @keypress="onlyNumber" :readonly="onUpdate">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-form">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="modul-keuangan">Nama Akun *</label>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <input type="text" name="ak_nama" class="form-control modul-keuangan" :placeholder="singleData.placeholderNama" v-model="singleData.ak_nama" title="Tidak Boleh Kosong">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-form" v-if="conteks == 'detail'">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="modul-keuangan">Posisi Debet/Kredit</label>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <vue-select :name="'ak_posisi'" :id="'ak_posisi'" :options="posisi"></vue-select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-form" v-if="conteks == 'detail'">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="modul-keuangan">Saldo Pembukaan</label>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <vue-inputmask :name="'ak_opening'" :id="'ak_opening'"></vue-inputmask>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(modulSetting()['support_cabang'])
                                                        <div class="col-md-12 mt-form">
                                                            <div class="row">
                                                                <div class="col-md-4">
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
                                                                    <i class="fa fa-arrow-right"></i> &nbsp;Data Akun Yang Sudah Disimpan &nbsp;<small style="color: #666;"> - Sesuai Dengan kelompok Akun Yang Dipilih</small>
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
                                                    <a href="{{ route('akun.index') }}">
                                                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-arrow-left" :disabled="btnDisabled"></i> &nbsp;Kembali Ke Halaman Data Akun</button>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ez-popup" id="data-popup">
        <div class="layout" style="width: 70%">
            <div class="top-popup" style="background: none;">
                <span class="title">
                    Data Akun Akun Yang Sudah Dibuat
                </span>
                <span class="close"><i class="fa fa-times" style="font-size: 12pt; color: #CC0000"></i></span>
            </div>
            
            <div class="content-popup">
                <vue-datatable :data_resource="list_data_table" :columns="data_table_columns" :selectable="true" :ajax_on_loading="onAjaxLoading" :index_column="'ak_id'" @selected="dataSelected"></vue-datatable>
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
            el: '#page-wrapper',
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
                    {name: 'Nomor Akun', context: 'ak_nomor', width: '20%', childStyle: 'text-align: center'},
                    {name: 'Nama Akun', context: 'ak_nama', width: '40%', childStyle: 'text-align: left'},
                    {name: 'Posisi Akun', context: 'ak_posisi', width: '20%', childStyle: 'text-align: center', override: function(e){
                        if(e == 'D')
                            return 'Debet';
                        else if(e == 'K')
                            return 'Kredit';
                        else
                            return '-';
                    }},
                    {name: 'Aktif', context: 'ak_isactive', width: '20%', childStyle: 'text-align: center', override: function(e){
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

                axios.get('{{route('akun.form_resource')}}')
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

                        axios.post('{{ route('akun.store') }}', $('#data-form').serialize())
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

                        axios.post('{{ route('akun.update') }}', $('#data-form').serialize())
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

                            axios.post('{{ route('akun.delete') }}', { ak_id: this.singleData.ak_id, _token: '{{ csrf_token() }}' })
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

                    axios.get('{{ Route('akun.datatable') }}?type='+$('#ak_type').val())
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
                    var idx = this.list_data_table.findIndex(a => a.ak_id === e);
                    var conteks = this.list_data_table[idx];
                    var cek = (parseInt(this.list_data_table[idx]['ak_kelompok'].length) + 1);

                    $('#ak_kelompok').val(conteks['ak_kelompok']).trigger('change.select2');

                    this.singleData.ak_nomor = conteks['ak_nomor'].substring(cek);
                    this.singleData.ak_nama = conteks['ak_nama'];
                    this.singleData.ak_id = conteks['ak_id'];
                    this.resiprokal = (conteks['ak_resiprokal'] == '1') ? true : false;

                    $('#ak_posisi').val(conteks['ak_posisi']).trigger('change.select2');
                    $('#ak_opening').val(conteks['ak_opening']);

                    if(this.list_data_table[idx].ak_status == 'locked'){
                        this.locked = true;
                    }

                    if(this.list_data_table[idx].ak_isactive == '0'){
                        this.dataIsActive = false;
                    }

                    this.onUpdate = true;
                    this.kelompokChange(this.list_data_table[idx]['ak_kelompok']);
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