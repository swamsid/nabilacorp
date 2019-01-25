@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Return Pembelian</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Return Pembelian</li>
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
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Return Pembelian</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive" >
                            <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row">
                           <div class="col-lg-12">

                        


  
    <div align="right" style="margin-bottom: 10px;">
    <a href="{{ url('purchasing/returnpembelian/tambah_pembelian') }}"><button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                               <i class="fa fa-plus" aria-hidden="true">
                                   &nbsp;
                               </i>Tambah Data
                            </button></a>
    </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered" width="100%" cellspacing="0" id="tabel_d_purchase_return">
                          <thead>
                <tr role="row"><th class="wd-10p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Tgl Return: activate to sort column ascending" style="width: 84.0039px;">Tgl Return</th><th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="ID Return: activate to sort column ascending" style="width: 84.0039px;">ID Return</th><th class="wd-10p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Staff: activate to sort column ascending" style="width: 44.0039px;">Staff</th><th class="wd-10p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Metode: activate to sort column ascending" style="width: 84.0039px;">Metode</th><th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Supplier: activate to sort column ascending" style="width: 151.004px;">Supplier</th><th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Total Retur: activate to sort column ascending" style="width: 151.004px;">Total Retur</th><th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 44.0039px;">Status</th><th class="wd-15p sorting_disabled" style="text-align: center; width: 246px;" rowspan="1" colspan="1" aria-label="Aksi">Aksi</th></tr>
              </thead>

                          <tbody>
                          </tbody>

                          
            </table> 
          </div>
                                                      
                    </div>
                        </div>
                                
                                    </div>
                                         </div>
                            </div>
@endsection
@section("extra_scripts")
    @include("Purchase::returnpembelian/js/functions") 
    @include("Purchase::returnpembelian/js/format_currency") 
    @include("Purchase::returnpembelian/js/commander") 
      
@endsection