@extends('main')
@section('content')

<!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Input Transaksi</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">

                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Keuangan</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                <li class="active">Proses Input Transaksi</li>
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
                        <li class="active"><a href="#alert-tab" data-toggle="tab">Pilih Transaksi</a></li>
                      </ul>

                      <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row" style="margin-top:-20px;">

                              <div class="col-md-12 col-sm-12 col-xs-12">
                                  <div class="table-responsive">
                                      <div class="row" style="padding: 20px;">

                                        <div class="col-md-4" style="padding: 20px; border-bottom: 1px solid #ccc;">
                                            <div class="row laporan-wrap">
                                                <div class="col-md-12 text-center">
                                                    <a href="{{ Route('transaksi.kas.index') }}">
                                                        <i class="fa fa-clipboard" style="font-size: 42pt;"></i>
                                                    </a>
                                                </div>

                                                <div class="col-md-12 text-center text" style="padding-top: 15px;">
                                                    <a href="">
                                                        Transaksi Kas
                                                    </a>
                                                </div>    
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="padding: 20px; border-bottom: 1px solid #ccc;">
                                            <div class="row laporan-wrap">
                                                <div class="col-md-12 text-center">
                                                    <a href="{{ Route('transaksi.bank.index') }}">
                                                        <i class="fa fa-clipboard" style="font-size: 42pt;"></i>
                                                    </a>
                                                </div>

                                                <div class="col-md-12 text-center text" style="padding-top: 15px;">
                                                    <a href="">
                                                        Transaksi Bank
                                                    </a>
                                                </div>    
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="padding: 20px; border-bottom: 1px solid #ccc;">
                                            <div class="row laporan-wrap">
                                                <div class="col-md-12 text-center">
                                                    <a href="{{ Route('transaksi.memorial.index') }}">
                                                        <i class="fa fa-clipboard" style="font-size: 42pt;"></i>
                                                    </a>
                                                </div>

                                                <div class="col-md-12 text-center text" style="padding-top: 15px;">
                                                    <a href="">
                                                        Transaksi Memorial
                                                    </a>
                                                </div>    
                                            </div>
                                        </div>

                                      </div>
                                  </div>
                              </div>
                    
                            </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("extra_scripts")
    
@endsection()