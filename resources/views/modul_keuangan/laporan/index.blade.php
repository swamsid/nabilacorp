@extends('main')

@section('title', 'Laporan Keuangan')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    
    <style type="text/css">
        .laporan-wrap{
            /*box-shadow: 0px 0px 5px #aaa;*/
            border: 1px solid #ccc;
            padding: 20px;
        }

        .laporan-wrap .text{
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-weight: 600;
        }

        .laporan-wrap a{
            color: #777;
            text-decoration: none;
        }
    </style>

@endsection


@section('content')

    <?php 

        // jurnal
            $tanggal = date('Y-m').'-01';

            $tanggalFirst = date('d/m/Y', strtotime($tanggal));
            $tanggalNext = date('d/m/Y', strtotime("+1 months", strtotime($tanggal)));

            $jurnalRequest = "_token=".csrf_token()."&d1=".$tanggalFirst."&d2=".$tanggalNext."&type=K&nama=true";

        // buku besar
            $bulan = date('Y-m');

            $bulanFirst = date('m/Y', strtotime($bulan));
            $bulanNext = date('m/Y', strtotime("+1 months", strtotime($bulan)));

            $buku_besar = "_token=".csrf_token()."&d1=".$bulanFirst."&d2=".$bulanNext."&semua=on&lawan=true";

        // Neraca Saldo
            $neraca_saldo = "_token=".csrf_token()."&d1=".$bulanFirst;

        // Neraca
            $neraca = "_token=".csrf_token()."&d1=".$bulanFirst."&type=bulan&tampilan=tabular&y1=";

        // laba_rugi
            $laba_rugi = "_token=".csrf_token()."&d1=".$bulanFirst."&type=bulan&tampilan=tabular&y1=";
    ?>

    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Laporan Keuangan</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">

                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                <li><i></i>&nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                <li class="active">Laporan Keuangan</li>
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
                        <li class="active"><a href="#alert-tab" data-toggle="tab">Pilih Laporan Keuangan</a></li>
                      </ul>

                      <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row text-center" style="padding-left: 7em;">
                                <a href="{{ route('laporan.keuangan.jurnal_umum', $jurnalRequest) }}">
                                    <div class="col-md-3" style="margin-left: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-clipboard" style="font-size: 24pt; color: #ffbb33;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 10px;">
                                                Laporan Jurnal
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ route('laporan.keuangan.buku_besar', $buku_besar) }}">
                                    <div class="col-md-3" style="margin-left: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-book" style="font-size: 24pt; color: #ffbb33;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 10px;">
                                                Buku Besar
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ Route('laporan.keuangan.neraca_saldo', $neraca_saldo) }}">
                                    <div class="col-md-3" style="margin-left: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-bar-chart" style="font-size: 24pt; color: #ffbb33;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 10px;">
                                                Neraca Saldo
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ Route('laporan.keuangan.neraca', $neraca) }}">
                                    <div class="col-md-3" style="margin-left: 30px; margin-top: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-balance-scale" style="font-size: 24pt; color: #33b5e5;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 10px;">
                                                Laporan Neraca
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ Route('laporan.keuangan.laba_rugi', $laba_rugi) }}">
                                    <div class="col-md-3" style="margin-left: 30px; margin-top: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-list-ul" style="font-size: 24pt; color: #33b5e5;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 10px;">
                                                Laba Rugi
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ Route('laporan.keuangan.arus_kas', $laba_rugi) }}">
                                    <div class="col-md-3" style="margin-left: 30px; margin-top: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-random" style="font-size: 24pt; color: #33b5e5;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 10px;">
                                                Arus Kas
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                            </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section(modulSetting()['extraScripts'])
	
	<script src="{{ asset('modul_keuangan/js/options.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>
	<script src="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>

@endsection