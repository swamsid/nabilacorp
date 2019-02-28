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

                        <div class="col-md-8 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                        <div style="margin-left:-30px;">
                                          <div class="col-md-3 col-sm-2 col-xs-12">
                                            <label class="tebal">Tanggal</label>
                                          </div>

                                          <div class="col-md-6 col-sm-7 col-xs-12">
                                            <div class="form-group" style="display: ">
                                              <div class="input-daterange input-group">
                                                <input id="tgl_awal" class="form-control input-sm" name="tgl_awal" type="text">
                                                <span class="input-group-addon">-</span>
                                                <input id="tgl_akhir" class="input-sm form-control" name="tgl_akhir" type="text">
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                          <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="find_d_purchase_return()">
                                            <strong>
                                              <i class="fa fa-search" aria-hidden="true"></i>
                                            </strong>
                                          </button>
                                          <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refresh_d_purchase_return()">
                                            <strong>
                                              <i class="fa fa-undo" aria-hidden="true"></i>
                                            </strong>
                                          </button>
                                        </div>
                                        
                                      </div>


  
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
                  <tr>
                      <th >Tgl Return</th>
                      <th>ID Return</th>
                      <th>Staff</th>
                      <th>Metode</th>
                      <th>Supplier</th>
                      <th>Total Retur</th>
                      <th>Status</th>
                      <th>Ubah Status</th>
                      <th>Aksi</th>
                  </tr>
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
    @include("Purchase::returnpembelian/includes/modal_alter_status") 
    @include("Purchase::returnpembelian/js/functions") 
    @include("Purchase::returnpembelian/js/format_currency") 
    @include("Purchase::returnpembelian/js/commander") 
      
@endsection