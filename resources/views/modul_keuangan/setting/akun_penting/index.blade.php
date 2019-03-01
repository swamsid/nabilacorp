@extends('main')

@section('title', 'Setting Klasifikasi Akun')

@section(modulSetting()['extraStyles'])

    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/wait_me_v_1_1/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/select2/dist/css/select2.min.css') }}">

    <style type="text/css">

        #button-wrap{
            background-color: none;
            padding:0px;
        }

        #button-wrap .button-ctn{
            background-color: white;
            border: 1px solid #eee;
            border-right: 0px;
            padding:10px 0px 10px 0px;
            cursor: pointer;
            font-weight: bold;
        }

        #button-wrap .button-ctn.active{
            background-color: #0099CC;
            color: white;
        }

        #main-content{
            background: #fff;
            box-shadow: 0px 0px 5px #ccc;
            padding: 15px 25px;
            /*color: white;*/
        }

        #main-content .title{
            border-bottom: 1px solid #eee;
            font-weight: 600;
            font-size: 11pt;
            padding-bottom: 8px;
            font-style: italic;
        }

        #main-content .text-intro{
            font-size: 9pt;
            margin-top: 10px;
        }

        input:focus{
            box-shadow: none;
            border: 0px;
            outline: none;
        }

        select{
            border: 0px;
            cursor: pointer;
            /*outline: none;*/
        }

    </style>

@endsection


@section('content')
    <div class="col-md-12" style="background: none; margin-bottom: 0px;" id="vue-component">
        {{-- <div class="col-md-12" style="border-bottom: 1px solid #eee; padding-bottom: 12px;">
            <div class="row">
                <div class="col-md-6 content-title">
                    Setting Klasifikasi Akun
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
        </div> --}}

        <div class="col-md-12 table-content" style="background: none; box-shadow: none; margin-top: 8px;" v-cloak>
                <div class="row">
                    <div class="col-md-1 offset-1" id="button-wrap">
                        <div class="col-md-12" style="padding: 0px;">
                            <div class="col-md-6 offset-6 text-center button-ctn active" id="inv-0">
                                <i class="fa fa-info"></i>
                            </div>
                        </div>

                        <div class="col-md-12" style="padding: 0px;">
                            <div class="col-md-6 offset-6 text-center button-ctn" id="inv-1">
                                <strong><small>1</small></strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8" id="main-content" v-if="stateNumber == 0">
                        <div class="row">
                            <div class="col-md-12 title">
                                <span>Sekilas Tentang Akun Penting !</span> 
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-intro">
                                Perlu Anda Ketahui, Beberapa Proses Pembukuan Pada System Terjadi Secara Otomatis. Untuk Itu Anda Perlu Mendefinisikan Akun-Akun Penting Yang Telah Dipilih Oleh System. Akun Penting Bukanlah Akun Baru, Melainkan Akun Yang Sudah Anda Buat, Yang Fungsinya Adalah Sebagai Rujukan Bagi System Agar Tidak Salah Dalam Melakukan Pembukuan Secara Otomatis.
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-12 text-detail" style="background-color: none; margin-top: 15px; padding-left: 25px; max-height: 254px; min-height: 254px;">
                                <div class="row">
                                    <div class="col-md-7" style="box-shadow: 5px 0px 10px #ccc;">
                                        <img src="{{ asset('modul_keuangan/klasifikasi.jpg') }}">
                                    </div><br>
                                    <div class="col-md-12 text-intro">
                                        Hierarki Level 1 dan Level 2 Adalah Hierarki Yang Wajib Dibuat Sedangkan Untuk Sub Hierarki Bersifat Optional (Tidak Wajib).
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-12" style="border-top: 1px solid #eee; padding: 21px 10px 8px 10px; margin-top: 25px;">
                                <div class="row">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-7 text-right">
                                        <button class="btn btn-info btn-sm" @click="nextState">
                                            <i class="fa fa-map-marker"></i> &nbsp;Mulai Kenalkan System Pada Akun-Akun Penting
                                        </button>
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="data-form-lvl1" class="col-md-8" v-if="stateNumber == 1" style="padding: 0px;">
                        <div class="col-md-12" id="main-content">
                            <div class="row">
                                <div class="col-md-12 title">
                                    <span>1. Akun-Akun Penting Pada System<small>&nbsp; - {{ $cabang }}</small></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-intro">
                                   Haloo. Jangan Biarkan Kami Tersesat, Tolong System Kami Dalam Menentukan Akun-Akun Dibawah Ini. <small style="font-weight: bold;">(Pastikan Akun Yang Anda Pilih Benar)</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-detail" style="background-color: none; margin-top: 15px; padding-left: 15px; max-height: 254px; min-height: 254px; overflow-y: scroll;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="form-data-level-1">
                                                <table class="table table-stripped table-bordered table-mini">
                                                    <tbody>
                                                        <tr v-for="(lvl1, index) in level_1">
                                                            <td class="text-center" width="5%" style="vertical-align: middle;">@{{ (index+1) }}</td>
                                                            <td width="20%" class="text-left" style="vertical-align: middle;">
                                                                @{{ lvl1.ap_nama }}
                                                                <input type="hidden" name="id[]" :value="lvl1.ap_id" readonly>
                                                            </td>
                                                            <td width="70%">
                                                                <vue-select :name="'akun[]'" :id="'akun'+lvl1.ap_id" :options="akun"></vue-select>
                                                            </td>
                                                            <td width="5%" class="text-center" style="vertical-align: middle;">
                                                                <i class="fa fa-info-circle" :title="lvl1.ap_keterangan" style="cursor: help;"></i>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" style="border-top: 1px solid #eee; padding: 21px 10px 8px 10px; margin-top: 25px;">
                                    <div class="row">
                                        <div class="col-md-5 form-status" style="padding-top: 10px;">
                                            
                                        </div>

                                        <div class="col-md-7 text-right">
                                            <button class="btn btn-info btn-sm" type="button" @click="simpanLevel1" :disabled="btnDisabled">
                                                Simpan Perubahan
                                            </button>
                                            &nbsp;
                                            <button class="btn btn-default btn-sm" type="button" @click="previousState" :disabled="btnDisabled">
                                                <i class="fa fa-arrow-left"></i> &nbsp;Sebelumnya
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
                btnDisabled: false,
                onAjaxLoading: false,
                onUpdate: false,

                stateNumber: 0,

                // resource
                    lvl2New : 0,
                    lvlSubclassNew : 0,

                    level1 : 0,
                    level1Subclass : 0,

                    level_1 : [],
                    akun : [],
                    level_2 : [],
                    levelSubclass : [],

                    data2Print: [],
                    dataSubclassPrint: [],
                    dataSubclassPrintLvl2: [],

                    printLvl2 : [],

            },

            created: function(){
                console.log('Initializing Vue');
            },

            mounted: function(){
                console.log('Vue Ready');
                this.kelompok = this.kelompokParrent;
                register_validator();

                axios.get('{{route('setting.akun_penting.form_resource')}}')
                          .then((response) => {
                            console.log(response.data);
                            if(response.data.level_1.length > 0){
                                this.level_1 = response.data.level_1;
                                // alert(response.data.subclass[0].id);
                                this.level1Change(parseInt(response.data.level_1[0].id));
                            }

                            if(response.data.akun.length > 0){
                                this.akun = response.data.akun;
                            }

                            var that = this;
                                        
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
                nextState: function(){
                    this.stateNumber++;
                    $('.button-ctn').removeClass('active');
                    $('#inv-'+this.stateNumber).addClass('active');
                    this.lvl2New = 0;

                    that = this;

                    if(this.stateNumber == 1){
                        setTimeout(function(){
                            $.each(that.level_1, function(idx, n){
                                $('#akun'+n.ap_id).val(n.ap_akun).trigger('change.select2');
                            })
                        }, 0);
                    }
                },

                previousState: function(){
                    this.stateNumber--;
                    $('.button-ctn').removeClass('active');
                    $('#inv-'+this.stateNumber).addClass('active');
                    this.lvl2New = 0;
                },

                level1Change: function(e){
                    var alpha = (typeof(e) === 'number') ? e : e.srcElement.value;
                    var dataLevel2 = $.grep(this.level_2, function(n){ return n.lvl1 == alpha });
                    var dataLevelSubclass = $.grep(this.levelSubclass, function(n){ return n.level1 == alpha });
                    
                    this.level1 = alpha;
                    this.data2Print = dataLevel2;
                    this.dataSubclassPrintLvl2 = dataLevelSubclass;
                    this.lvl2New = 0;
                },

                level1SubclassChange: function(e){
                    var alpha = (typeof(e) === 'number') ? e : e.srcElement.value;
                    var dataLevel2 = $.grep(this.levelSubclass, function(n){ return n.level1 == alpha });

                    this.level1Subclass = alpha;
                    this.dataSubclassPrint = dataLevel2;
                    this.lvl2New = 0;
                },

                simpanLevel1: function(e){
                    this.btnDisabled = true;

                    var toast = $.toast({
                        text: "Menyimpan Hierarki Level 1",
                        showHideTransition: 'slide',
                        position: 'bottom-right',
                        icon: 'info',
                        hideAfter: false,
                        showHideTransition: 'slide',
                        allowToastClose: false,
                        stack: false
                    });

                    axios.post('{{ route('setting.akun_penting.store') }}', $('#data-form-lvl1').serialize())
                                .then((response) => {
                                    console.log(response.data);
                                    
                                    if(response.data.status == 'berhasil'){
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'bottom-right',
                                            icon: 'success',
                                            hideAfter: 5000,
                                            allowToastClose: true,
                                        });

                                        this.status = 'standby';
                                    }else{
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false,
                                            allowToastClose: true,
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
                },

                simpanLevel2: function(e){
                    this.btnDisabled = true;

                    var toast = $.toast({
                        text: "Menyimpan Hierarki Level 2",
                        showHideTransition: 'slide',
                        position: 'bottom-right',
                        icon: 'info',
                        hideAfter: false,
                        showHideTransition: 'slide',
                        allowToastClose: false,
                        stack: false
                    });

                    axios.post('{{ route('setting.klasifikasi_akun.simpan.level_2') }}', $('#data-form-lvl2').serialize())
                                .then((response) => {
                                    // console.log(response.data);
                                    
                                    if(response.data.status == 'berhasil'){
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'bottom-right',
                                            icon: 'success',
                                            hideAfter: 5000,
                                            allowToastClose: true,
                                        });

                                        if(response.data.level_2.length > 0){
                                            this.level_2 = response.data.level_2;
                                        }

                                        this.level1Change(parseInt(this.level1));
                                        this.status = 'standby';
                                        this.lvl2New = 0;

                                    }else{
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false,
                                            allowToastClose: true,
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
                },

                simpanLevelSubclass: function(e){
                    this.btnDisabled = true;

                    var toast = $.toast({
                        text: "Menyimpan Hierarki Subclass",
                        showHideTransition: 'slide',
                        position: 'bottom-right',
                        icon: 'info',
                        hideAfter: false,
                        showHideTransition: 'slide',
                        allowToastClose: false,
                        stack: false
                    });

                    axios.post('{{ route('setting.klasifikasi_akun.simpan.subclass') }}', $('#data-form-lvlsubclass').serialize())
                                .then((response) => {
                                    // console.log(response.data);
                                    
                                    if(response.data.status == 'berhasil'){
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'bottom-right',
                                            icon: 'success',
                                            hideAfter: 5000,
                                            allowToastClose: true,
                                        });

                                        if(response.data.subclass.length > 0){
                                            this.levelSubclass = response.data.subclass;
                                        }

                                        this.level1SubclassChange(parseInt(this.level1Subclass));
                                        this.status = 'standby';
                                        this.lvl2New = 0;
                                    }else{
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false,
                                            allowToastClose: true,
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
                },

                hapusHierarki2: function(e){
                    var cfrm = confirm('Apakah Anda Yakin ?')

                    if(cfrm){
                        this.btnDisabled = true;

                        var toast = $.toast({
                            text: "Menghapus Hierarki Level 2",
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'info',
                            hideAfter: false,
                            showHideTransition: 'slide',
                            allowToastClose: false,
                            stack: false
                        });

                        axios.post('{{ route('setting.klasifikasi_akun.hapus.level_2') }}', {id: e, _token: '{{ csrf_token() }}' })
                                .then((response) => {
                                    // console.log(response.data);
                                    
                                    if(response.data.status == 'berhasil'){
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'bottom-right',
                                            icon: 'success',
                                            hideAfter: 5000,
                                            allowToastClose: true,
                                        });

                                        if(response.data.level_2.length > 0){
                                            this.level_2 = response.data.level_2;
                                        }

                                        this.level1Change(this.level1);
                                        this.status = 'standby';
                                        this.lvl2New = 0;

                                        console.log(this.level_2);
                                    }else{
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false,
                                            allowToastClose: true,
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

                hapusHierarkiSubclass: function(e){
                    var cfrm = confirm('Apakah Anda Yakin ?')

                    if(cfrm){
                        this.btnDisabled = true;

                        var toast = $.toast({
                            text: "Menghapus Hierarki Level Subclass",
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'info',
                            hideAfter: false,
                            showHideTransition: 'slide',
                            allowToastClose: false,
                            stack: false
                        });

                        axios.post('{{ route('setting.klasifikasi_akun.hapus.subclass') }}', {id: e, _token: '{{ csrf_token() }}' })
                                .then((response) => {
                                    // console.log(response.data);
                                    
                                    if(response.data.status == 'berhasil'){
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'bottom-right',
                                            icon: 'success',
                                            hideAfter: 5000,
                                            allowToastClose: true,
                                        });

                                        if(response.data.subclass.length > 0){
                                            this.levelSubclass = response.data.subclass;
                                        }

                                        this.level1SubclassChange(this.level1Subclass);
                                        this.status = 'standby';
                                        this.lvl2New = 0;

                                    }else{
                                        toast.update({
                                            text: response.data.message,
                                            showHideTransition: 'slide',
                                            position: 'top-right',
                                            icon: 'error',
                                            hideAfter: false,
                                            allowToastClose: true,
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

                tambahLevel2: function(e){
                    this.lvl2New++;
                    setTimeout(function() {
                      var elem = document.getElementById('content-lvl-2');
                      elem.scrollTop = elem.scrollHeight;
                    }, 0);
                },

                checkIdlvl2: function(e){
                    var conteks = $('#'+e.srcElement.id);
                    var recentVal = conteks.data('value');
                    var id = conteks.attr('id');
                    var val = conteks.val();
                    
                    // console.log(val);

                    var greping = $('.idLevel2').filter(function(e){ 
                        return $(this).val() == val && $(this).attr('id') != id
                     });

                    if(greping.length > 0){
                        $.toast({
                            text: 'ID Yang Anda Inputkan Sudah Digunakan Oleh Data Yang Lain',
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'error',
                            hideAfter: 5000,
                            allowToastClose: true,
                        });

                        conteks.val(recentVal);
                        conteks.focus();
                        return;
                    }

                    if(conteks.val() == ''){
                        conteks.val(recentVal);
                    }
                },

                checkValue: function(e){
                    var conteks = $('#'+e.srcElement.id);
                    var recentVal = conteks.data('value');
                    if(conteks.val() == ''){
                        conteks.val(recentVal);
                    }
                },

                onlyNumber: function(e){
                    var conteks = $('#'+e.srcElement.id);
                    var max = conteks.data('max');
                    var now = parseInt(conteks.val().length) + 1;

                    if(now > max){
                        $.toast({
                            text: 'Panjang ID Yang Dibolehkan Hanya 3 Digit',
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'error',
                            hideAfter: 5000,
                            allowToastClose: true,
                        });

                        e.preventDefault();
                        return false;
                    }

                    if(isNaN(e.key))
                      e.preventDefault()
                    else
                      return true;
                }
            }
        })

    </script>

@endsection