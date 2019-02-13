@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Data Actual SPK</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Data Actual</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Data Actual</a></li>

                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">

                            <div id="alert-tab" class="tab-pane fade in active">
                                <div class="row">

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-2 col-sm-3 col-xs-12">
                                            <label class="tebal">Tanggal Actual</label>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <div class="input-daterange input-group">
                                                    <input id="tanggal1" class="form-control input-sm datepicker1"
                                                           name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                                    <span class="input-group-addon">-</span>
                                                    <input id="tanggal2" class="input-sm form-control datepicker2"
                                                           name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3 col-sm-3 col-xs-12" align="left">
                                            <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                                    onclick="cariTanggalSpk()">
                                                <strong>
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </strong>
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table tabelan table-bordered table-hover" id="data-actual"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>No SPK</th>
                                                    <th>Nama Item</th>
                                                    <th>Adonan</th>
                                                    <th width="5%">Satuan</th>
                                                    <th>Kriwilan</th>
                                                    <th width="5%">Satuan</th>
                                                    <th>Sampah</th>
                                                    <th width="5%">Satuan</th>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /div alert-tab -->

                            <!-- div note-tab -->
                            <div id="note-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">
                                        <!-- Isi Content -->we we we
                                    </div>
                                </div>
                            </div>
                            <!--/div note-tab -->

                            <!-- div label-badge-tab -->
                            <div id="label-badge-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">
                                        <!-- Isi content -->we
                                    </div>
                                </div>
                            </div>
                            <!-- /div label-badge-tab -->
                        </div>

                    </div>
                </div>

                @endsection
                @section("extra_scripts")
                    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
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
                            var date = new Date();
                            var newdate = new Date(date);

                            newdate.setDate(newdate.getDate() - 3);
                            var nd = new Date(newdate);

                            $('.datepicker').datepicker({
                                format: "mm",
                                viewMode: "months",
                                minViewMode: "months"
                            });
                            $('.datepicker1').datepicker({
                                autoclose: true,
                                format: "dd-mm-yyyy",
                                endDate: 'today'
                            }).datepicker("setDate", nd);
                            $('.datepicker2').datepicker({
                                autoclose: true,
                                format: "dd-mm-yyyy",
                                endDate: 'today'
                            });//.datepicker("setDate", "0");

                            cariTanggalSpk();

                        });

                        function cariTanggalSpk() {
                            var tgl1 = $('#tanggal1').val();
                            var tgl2 = $('#tanggal2').val();
                            var tableActual = $('#data-actual').DataTable({
                                "destroy": true,
                                "processing": true,
                                "serverside": true,
                                "ajax": {
                                    url: baseUrl + "/produksi/data_actual/tabel/" + tgl1 + '/' + tgl2,
                                    type: 'GET'
                                },
                                "columns": [
                                    {"data": 'spk_date', name: 'spk_date', "width": "10%"},
                                    {"data": 'spk_code', name: 'spk_code', "width": "10%"},
                                    {"data": 'i_name', name: 'i_name', "width": "25%"},
                                    {"data": 'ac_adonan', name: 'ac_adonan', "width": "10%", "className": "right"},
                                    {"data": "s_name", "width": "10%"},
                                    {"data": "ac_kriwilan","width": "10%", "className": "right"},
                                    {"data": 's_name', name: 's_name', "width": "10%"},
                                    {"data": 'ac_sampah', name: 'ac_sampah', "width": "10%", "className": "right"},
                                    {"data": 's_name', name: 's_name', "width": "10%"},
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

                    </script>
@endsection()