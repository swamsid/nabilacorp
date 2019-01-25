@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <style type="text/css">
        .ui-autocomplete {
            z-index: 2147483647;
        }
    </style>
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Penerimaan Barang Hasil Produksi</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Penerimaan Barang Hasil Produksi</li>
            </ol>
            <div class="clearfix">
            </div>
        </div>

        <div class="page-content fadeInRight">
            <div id="tab-general">
                <div class="row mbl">
                    <div class="col-lg-12">

                        <div class="col-md-12">
                            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                            </div>
                        </div>

                        <ul id="generalTab" class="nav nav-tabs">
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Penerimaan Barang Hasil
                                    Produksi</a></li>
                            {{-- <li><a href="#waitingResult-tab" data-toggle="tab" onclick="cariTanggal2()">Daftar
                                    Tunggu</a></li> --}}
                            <li><a href="#finishResult-tab" data-toggle="tab" onclick="cariTanggal()">Daftar Hasil
                                    Penerimaan</a></li>
                        </ul>

                        <div id="generalTabContent" class="tab-content responsive">

                            {!! $modalTerima !!}

                            <div id="alert-tab" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">

                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                <label class="tebal">Nomor Surat Jalan (DO) :</label>
                                            </div>

                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="input-group">
                                                    <select class="form-control input-sm" id="cari_sj" name="cariSj"
                                                            style="width: 300px;">
                                                        <option> - Pilih No. Surat Jalan (DO)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-12" align="left">
                                                <button class="btn btn-info btn-sm btn-flat" type="button"
                                                        id="btn_refresh_index" onclick="refreshTabelIndex()">
                                                    <strong>
                                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                                    </strong>
                                                </button>
                                            </div>

                                        </div>

                                        <div class="table-responsive">
                                            <div id="tabelPenerimaan">
                                             {!! $tabelPenerimaan !!}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- End div #alert-tab  -->

                            <!-- div finishResult-tab -->
                            <div id="finishResult-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">

                                        <div class="col-md-2 col-sm-3 col-xs-12">
                                            <label class="tebal">Tanggal Penerimaan</label>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <div class="input-daterange input-group">
                                                    <input id="tanggal1" class="form-control input-sm datepicker1 "
                                                           name="tanggal"
                                                           type="text" {{-- value="{{ date('d-m-Y') }}" --}}>
                                                    <span class="input-group-addon">-</span>
                                                    <input id="tanggal2" class="input-sm form-control datepicker2"
                                                           name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                            <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                                    onclick="cariTanggal()">
                                                <strong>
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </strong>
                                            </button>
                                            <button class="btn btn-info btn-sm btn-flat" type="button"
                                                    onclick="refreshTabel()">
                                                <strong>
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </strong>
                                            </button>
                                        </div>

                                        <div class="table-responsive" style="padding-top: 15px;">
                                            <div id="tabelPenerimaanFinal">
                                               {!! $tabPenFinal !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End DIv note-tab -->

                            <!-- div waitingResult-tab -->
                            <div id="waitingResult-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">

                                        <div class="col-md-2 col-sm-3 col-xs-12">
                                            <label class="tebal">Tanggal Surat Jalan</label>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <div class="input-daterange input-group">
                                                    <input id="tanggal3" class="form-control input-sm datepicker1 "
                                                           name="tanggal"
                                                           type="text" {{-- value="{{ date('d-m-Y') }}" --}}>
                                                    <span class="input-group-addon">-</span>
                                                    <input id="tanggal4" class="input-sm form-control datepicker2"
                                                           name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                            <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                                    onclick="cariTanggal2()">
                                                <strong>
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </strong>
                                            </button>
                                            <button class="btn btn-info btn-sm btn-flat" type="button"
                                                    onclick="refreshTabel2()">
                                                <strong>
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </strong>
                                            </button>
                                        </div>

                                        <div class="table-responsive" style="padding-top: 15px;">
                                            <div id="tabelPenerimaanFinal">
                                                {!! $tabPenWaiting !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End DIv waitingResult-tab -->

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--END PAGE WRAPPER-->

@endsection
@section("extra_scripts")
    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
    <script type="text/javascript">
        var save_method;
        $(document).ready(function () {
            //fix to issue select2 on modal when opening in firefox
            $.fn.modal.Constructor.prototype.enforceFocus = function () {
            };
            var extensions = {
                "sFilterInput": "form-control input-sm",
                "sLengthSelect": "form-control input-sm"
            }
            // Used when bJQueryUI is false
            $.extend($.fn.dataTableExt.oStdClasses, extensions);
            // Used when bJQueryUI is true
            $.extend($.fn.dataTableExt.oJUIClasses, extensions);

            // var timepicker = new TimePicker('time', {
            //     lang: 'en',
            //     theme: 'dark'
            // });
            // timepicker.on('change', function (evt) {

            //     var value = (evt.hour || '00') + ':' + (evt.minute || '00');
            //     evt.element.value = value;
            // });

            var date = new Date();
            var newdate = new Date(date);
            newdate.setDate(newdate.getDate() - 3);
            var nd = new Date(newdate);


            $('.datepicker1').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            }).datepicker("setDate", nd);

            $('.datepicker2').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            });//datepicker("setDate", "0");

            $(".datepicker").datepicker({
                format: "dd-mm-yyyy",
                changeMonth: true,
                changeYear: true
            });

            $('.datepicker').on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });

            $('.datepicker1').on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });

            $('.datepicker2').on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });

            //force integer input in textfield
            $('input.numberinput').bind('keypress', function (e) {
                return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
            });

            //select2
            var comp = $('.mem_comp').val();           
            $("#cari_sj").select2({
                placeholder: "Pilih Nota SPK...",
                ajax: {
                    url: baseUrl + '/inventory/p_hasilproduksi/get_data_sj/'+comp,
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
            });

            //autofill
            var fill = true;
            var statusPrdt;
            $('#cari_sj').change(function () {
                $('#btn_refresh_index').prop('disabled', false);
                var sj_code = $('#cari_sj').select2('data')[0].text;
                //remove tr before appending
                $('tr').remove('.tbl_spk_row');
                $.ajax({
                    url: baseUrl + "/inventory/p_hasilproduksi/list_sj",
                    type: 'GET',
                    data: {sj_code: sj_code},
                    success: function (response) {
                        //$('#tabelPenerimaan').html(response.tabel);
                        $('#data2').DataTable({
                            "destroy": true,
                            "processing": true,
                            "serverside": true,
                            "ajax": {
                                url: baseUrl + "/inventory/p_hasilproduksi/get_tabel_data/" + response.idSj,
                                type: 'GET'
                            },
                            "columns": [
                                {"data": "DT_Row_Index", orderable: true, searchable: false, "width": "5%"}, //memanggil column row
                                {"data": "do_nota", "width": "15%"},
                                {"data": "i_name", "width": "25%"},
                                {"data": "dod_qty_send", "width": "5%"},
                                {"data": "dod_qty_received", "width": "5%"},
                                {"data": "tanggalTerima", "width": "10%"},
                                {"data": "jamTerima", "width": "10%"},
                                {"data": "status", "width": "10%"},
                                {"data": "action", orderable: false, searchable: false, "width": "15%"}
                            ],
                            "language": {
                                "searchPlaceholder": "Cari Data",
                                "emptyTable": "Tidak ada data",
                                "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                                "sSearch": '<i class="fa fa-search"></i>',
                                "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                                "infoEmpty": "",
                                "paginate": {
                                    "previous": "Sebelumnya",
                                    "next": "Selanjutnya",
                                }
                            }
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Gagal request data dari server');
                    }
                });
            });

            // clear field pda modal apabila modal hidden
            $("#modalTerima").on("hidden.bs.modal", function () {
                $('#update-terima-produk')[0].reset();
            });

            //disable button refresh, jika select2 option = ""
            if ($('#cari_sj').select2('data')[0].text == " - Pilih No. Surat Jalan (DO)") {
                $('#btn_refresh_index').prop('disabled', true);
            } else {
                $('#btn_refresh_index').prop('disabled', false);
            }

            $('#data2').DataTable();
            $('#data3').DataTable();
            $('#data4').DataTable();

            $('#modalTerima').on('shown.bs.modal', function () {
                $('#qtyDiterima').focus()
            })

        });

        $('#time').keypress(function (e) {
            var charCode;
            if ((e.which && e.which == 13)) {
                charCode = e.which;
            } else if (window.event) {
                e = window.event;
                charCode = e.keyCode;
            }
            if ((e.which && e.which == 13)) {
                $("input[name='qtyDiterima']").focus();
                return false;
            }
        });

        function randString(angka) {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < angka; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }

        function terimaHasilProduksi(id, id2) {
            save_method = 'add';
            $.ajax({
                url: baseUrl + "/inventory/p_hasilproduksi/terima_hasil_produksi/" + id + "/" + id2,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $('#idItemMasuk').val(data[0].dod_item);
                    $('#namaItemMasuk').val(data[0].i_name);
                    $('[name="qtyMasuk"]').val(data[0].dod_qty_send);
                    $('#noNotaMasuk').val(data[0].do_nota);
                    $('#detailId').val(data[0].dod_detailid);
                    $('#doId').val(data[0].dod_do);
                    $('#prdtId').val(data[0].dod_prdt_productresult);
                    $('#prdtDetailId').val(data[0].dod_prdt_detail);
                    $('[name="qtyMasukPrev"]').val("0");
                    $('#modalTerima').modal('show');
                }
            });
        }

        function editHasilProduksi(id, id2) {
            save_method = 'update';
            $.ajax({
                url: baseUrl + "/inventory/p_hasilproduksi/edit_hasil_produksi/" + id + "/" + id2,
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    //ambil data ke json->modal
                    $('#idItemMasuk').val(data[0].dod_item);
                    $('#namaItemMasuk').val(data[0].i_name);
                    $('[name="qtyMasuk"]').val(data[0].dod_qty_send);
                    $('#noNotaMasuk').val(data[0].do_nota);
                    $('#detailId').val(data[0].dod_detailid);
                    $('#doId').val(data[0].dod_do);
                    $('#prdtId').val(data[0].dod_prdt_productresult);
                    $('#prdtDetailId').val(data[0].dod_prdt_detail);
                    $('[name="qtyDiterima"]').val(data[0].dod_qty_received);
                    $('[name="qtyMasukPrev"]').val(data[0].dod_qty_received);
                    $('[name="tglMasuk"]').val(data[0].dod_date_received);
                    $('[name="jamMasuk"]').val(data[0].dod_time_received);
                    $('#modalTerima').modal('show');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function save_update() {
            $('#btn-simpan').prop('disabled', true);
            url = baseUrl + "/inventory/p_hasilproduksi/simpan_update_data";
            var data = $('#update-terima-produk :input').serialize();
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
                data: data,
                success: function (response) {
                    if (response.status == "Sukses") {
                        $('#update-terima-produk')[0].reset();
                        $('#modalTerima').modal('hide');
                        $('#btn-simpan').prop('disabled', false);
                        $('#data2').DataTable().ajax.reload();
                        iziToast.success({
                            timeout: 5000,
                            position: "topRight",
                            icon: 'fa fa-chrome',
                            title: '',
                            message: 'Berhasil menyimpan item produksi.'
                        });
                    } else {
                        $('#btn-simpan').prop('disabled', false);
                        $('#modalTerima').modal('hide');
                        iziToast.error({
                            position: "topRight",
                            title: '',
                            message: 'Gagal menyimpan item produksi.'
                        });
                    }
                }
            });
        }

        function cariTanggal() {
            var tgl1 = $('#tanggal1').val();
            var tgl2 = $('#tanggal2').val();
            var akses = 'inventory';
            var comp = $('.mem_comp').val();
            $('#data3').DataTable({
                "destroy": true,
                "processing": true,
                "serverside": true,
                "ajax": {
                    url: baseUrl + "/inventory/p_hasilproduksi/get_penerimaan_by_tgl/" + tgl1 + '/' + tgl2 + '/' + akses + '/' + comp,
                    type: 'GET'
                },
                "columns": [
                    {"data": "DT_Row_Index", orderable: true, searchable: false, "width": "5%"}, //memanggil column row
                    {"data": "do_nota", "width": "15%"},
                    {"data": "i_name", "width": "25%"},
                    {"data": "dod_qty_send", "width": "5%"},
                    {"data": "dod_qty_received", "width": "5%"},
                    {"data": "tanggalTerima", "width": "10%"},
                    {"data": "jamTerima", "width": "10%"},
                    {"data": "status", "width": "10%"},
                ],
                "language": {
                    "searchPlaceholder": "Cari Data",
                    "emptyTable": "Tidak ada data",
                    "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                    "sSearch": '<i class="fa fa-search"></i>',
                    "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                    "infoEmpty": "",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya",
                    }
                }
            });
        }

        function cariTanggal2() {
            var tgl1 = $('#tanggal3').val();
            var tgl2 = $('#tanggal4').val();
            $('#data4').DataTable({
                "destroy": true,
                "processing": true,
                "serverside": true,
                "ajax": {
                    url: baseUrl + "/inventory/p_hasilproduksi/get_list_waiting_by_tgl/" + tgl1 + '/' + tgl2,
                    type: 'GET'
                },
                "columns": [
                    {"data": "DT_Row_Index", orderable: true, searchable: false, "width": "5%"}, //memanggil column row
                    {"data": "do_nota", "width": "15%"},
                    {"data": "i_name", "width": "25%"},
                    {"data": "dod_qty_send", "width": "5%"},
                    {"data": "dod_qty_received", "width": "5%"},
                    {"data": "tanggalTerima", "width": "10%"},
                    {"data": "jamTerima", "width": "10%"},
                    {"data": "status", "width": "10%"},
                    {"data": "action", orderable: false, searchable: false, "width": "15%"}
                ],
                "language": {
                    "searchPlaceholder": "Cari Data",
                    "emptyTable": "Tidak ada data",
                    "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                    "sSearch": '<i class="fa fa-search"></i>',
                    "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                    "infoEmpty": "",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya",
                    }
                }
            });
        }

        function refreshTabelIndex() {
            $('#data2').DataTable().ajax.reload();
        }

        function refreshTabel() {
            $('#data3').DataTable().ajax.reload();
        }

        function refreshTabel2() {
            $('#data4').DataTable().ajax.reload();
        }

        function bandingQty() {
            var terima = parseInt($('#qtyDiterima').val());
            var kirim = parseInt($('#qtyMasuk').val());
            if (terima > kirim) {
                $('#qtyDiterima').val(kirim);
                iziToast.error({
                    position: "topRight",
                    title: '',
                    message: 'Jumlah melebihi pengiriman.'
                });
            }
        }

    </script>
@endsection
