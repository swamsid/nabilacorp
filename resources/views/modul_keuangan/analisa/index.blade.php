@extends('main')

@section('title', 'Analisa Keuangan')

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

    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Analisa Keuangan</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">

                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                <li><i></i>&nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                <li class="active">Analisa Keuangan</li>
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
                        <li class="active"><a href="#alert-tab" data-toggle="tab">Pilih Analisa Keuangan</a></li>
                      </ul>

                      <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row text-center" style="padding-left: 7em;">

                                <a href="{{ Route('analisa.keuangan.npo', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                    <div class="col-md-3" style="margin-left: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-line-chart" style="font-size: 24pt; color: #33b5e5;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                                Analisa Net Profit/OCF
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ Route('analisa.keuangan.hutang_piutang', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                    <div class="col-md-3" style="margin-left: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-line-chart" style="font-size: 24pt; color: #33b5e5;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                                Analisa Hutang Piutang
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ Route('analisa.keuangan.pertumbuhan_aset', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                    <div class="col-md-3" style="margin-left: 30px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-line-chart" style="font-size: 24pt; color: #33b5e5;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                                Analisa Pertumbuhan Aset
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ Route('analisa.keuangan.aset_ekuitas', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                    <div class="col-md-3" style="margin-left: 30px; margin-top: 20px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-line-chart" style="font-size: 24pt; color: #33b5e5;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                                Analisa Aset Terhadap Ekuitas
                                            </div>
                                        </div> 
                                    </div>
                                </a>

                                <a href="{{ Route('analisa.keuangan.cashflow', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                    <div class="col-md-3" style="margin-left: 30px; margin-top: 20px;">
                                        <div class="row" style="box-shadow: 0px 0px 10px #ccc; padding: 30px 20px;">
                                            <div class="col-md-12 text-center">
                                                <i class="fa fa-line-chart" style="font-size: 24pt; color: #33b5e5;"></i>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                                Analisa Cashflow
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