@extends('main')
@section('content')
    <link href="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Form Manajemen Output Produksi</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Manajemen Output Produksi</li>
                <li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen Output Produksi&nbsp;&nbsp;</i>&nbsp;&nbsp;
                </li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen Output Produksi</a>
                            </li>
                            {{--        <li><a href="#note-hasil-produksi" data-toggle="tab">Form Hasil Produksi</a></li> --}}
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form onsubmit="return false" autocomplete="off">

                                            <div class="col-md-2 col-sm-3 col-xs-12">
                                                <label class="tebal">Tanggal Hasil Produksi</label>
                                            </div>

                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <div class="input-daterange input-group">
                                                        <input id="tanggal1" class="form-control input-sm datepicker1"
                                                               name="tanggal" type="text">
                                                        <span class="input-group-addon">-</span>
                                                        <input id="tanggal2" class="input-sm form-control datepicker2"
                                                               name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-12" align="left">
                                                <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                                        onclick="cariTanggal()">
                                                    <strong>
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </strong>
                                                </button>
                                            </div>

                                            <!-- Modal -->
                                            {!!$modalCreate!!}
                                            <div class="col-md-3 col-sm-3 col-xs-12" align="right">
                                                <button class="btn btn-primary PostingHasil" type="submit"
                                                        onclick="simpanHasilProduct()">Simpan
                                                </button>
                                            </div>
                                            
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table tabelan table-bordered table-striped"
                                                           id="oProduct" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Tanggal Spk</th>
                                                            <th>Nota Spk</th>
                                                            <th>Kode - Nama Item</th>
                                                            <th>Jumlah SPK</th>
                                                            <th>Total Produksi</th>
                                                            <th>Jumlah Sekarang</th>
                                                         {{--    <th>Detail</th> --}}
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

    @endsection
    @section("extra_scripts")
    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
    <script src="{{ asset('assets/script/inputmask.jquery.js') }}"></script>
    <script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            var extensions = {
                "sFilterInput": "form-control input-sm",
                "sLengthSelect": "form-control input-sm"
            }
            // Used when bJQueryUI is false
            $.extend($.fn.dataTableExt.oStdClasses, extensions);
            // Used when bJQueryUI is true
            $.extend($.fn.dataTableExt.oJUIClasses, extensions);

            cariTanggal();

            $('#result-spk').inputmask("currency", {
                radixPoint: ".",
                groupSeparator: ",",
                digits: 2,
                allowMinus: false,
                autoGroup: true,
                prefix: '', //Space after $, this will not truncate the first character.
                rightAlign: false,
                oncleared: function () {  }
            });
        });



        var date = new Date();
        var newdate = new Date(date);

        newdate.setDate(newdate.getDate() - 7);
        var nd = new Date(newdate);

        $('.datepicker').datepicker({
            format: "mm",
            viewMode: "months",
            minViewMode: "months"
        });
        $('.datepicker1').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        }).datepicker("setDate", nd);
        $('.datepicker2').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy"
        });//.datepicker("setDate", "0");

        function SetTanggalProduksi() {
            var tgl1 = $('#TanggalProduksi').val();
            var comp = $('.mem_comp').val();
            $.ajax({
                url: baseUrl + '/produksi/o_produksi/select2/spk/' + tgl1 +'/'+ comp,
                type: 'get',
                success: function (response) {
                    $("#ubahselect").html(response);
                    $("#cari_spk").select2();
                }
            })
        }

        function setResultSpk() {
            var x = document.getElementById("cari_spk").value;
            $.ajax({
                url: baseUrl + '/produksi/o_produksi/select2/pilihspk/' + x,
                type: 'get',
                success: function (response) {
                    $('#NamaItem').val(response[0].i_name);
                    $('#JumlahItemSpk').val(response[0].pp_qty);
                    $('#JumlahItemHasilSpk').val(response[0].prdt_qty);
                    $('#spk_id').val(response[0].spk_id);
                    $('#id_item').val(response[0].i_id);
                }
            })
        }

        function maxQty() {
            var qty_plan = parseInt($("#JumlahItemSpk").val());
            var qty_result = parseInt($("#JumlahItemHasilSpk").val());
            var JumlahItem = parseInt($("#JumlahItem").val());
            var total = qty_plan - qty_result;

            if (qty_plan < JumlahItem) {
                $("#JumlahItem").val('');
                toastr.warning('Jumlah Pembuatan tidak boleh melebihi rencana');
            } else if (JumlahItem > total) {
                $("#JumlahItem").val('');
                toastr.warning('Jumlah Pembuatan tidak boleh melebihi rencana');
            }
        }

        function simpanHasilProduct() {
            $('.PostingHasil').attr('disabled', 'disabled');
            var spkId = $('.spk-id').serialize();
            var resultSpk = $('.resultSpk').serialize();
            var spkItem = $('.spk-item').serialize();
            $.ajax({
                url: baseUrl + "/produksi/o_produksi/store",
                type: 'GET',
                data: spkId + '&' + resultSpk + '&' + spkItem,
                success: function (response) {
                    if (response.status == 'sukses') {
                        $(".spk-id").val('');
                        $(".spk-item").val('');
                        $(".result-spk").val('');
                        cariTanggal();
                        iziToast.success({
                            timeout: 5000,
                            position: "topRight",
                            icon: 'fa fa-chrome',
                            title: '',
                            message: 'Berhasil ditambahkan.'
                        });
                        $('.PostingHasil').removeAttr('disabled', 'disabled');
                    } else {
                        iziToast.error({
                            position: "topRight",
                            title: '',
                            message: 'Gagal menyimpan.'
                        });
                        $('.PostingHasil').removeAttr('disabled', 'disabled');
                    }
                }
            })
        }

        function cariTanggal()
        {
            $('#oProduct').dataTable().fnDestroy();
            var tgl1 = $('#tanggal1').val();
            var tgl2 = $('#tanggal2').val();
            $('#oProduct').DataTable({
                processing: true,
                serverSide: true,
                scrollY: 500,
                scrollX: true,
                ajax: {
                    url: baseUrl + "/produksi/o_produksi/tabel/" + tgl1 + "/" + tgl2,
                },
                columns: [
                    {data: 'spk_date', name: 'spk_date', width: '10%'},
                    {data: 'spk_code', name: 'spk_code', width: '15%'},
                    {data: 'item', name: 'item', orderable: false, width: '45%'},
                    {data: 'pp_qty', name: 'pp_qty', width: '5%'},
                    {data: 'produksi', name: 'produksi', className: 'right', width: '5%'},
                    {data: 'result', name: 'result', className: 'right', width: '10%'},
                    // {data: 'action', name: 'action', width: '10%'},
                ],
                "responsive": true,

                "pageLength": 10,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
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

    function batasHasil(qty)
    {
        var plan = $('.plan-spk-'+qty).val();
        var result = $('.produksi-spk-'+qty).val();
        var batas = plan - result;
        var inputHasil = $('.result-spk-'+qty).val();
        if (inputHasil > batas) 
        {
            $('.result-spk-'+qty).val(batas);
            toastr.warning('input hasil produksi melebihi batas SPK!');
        }
    }

    </script>
@endsection()
