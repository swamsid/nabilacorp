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
          <div class="col-md-12 col-sm-12 col-xs-12">
        

              <div class="col-md-9">
                  <div class="row">
                    
                      <div class="form-group col-md-6">
                        <div class="input-group mb-3">
                          <div class="input-group-addon">Tanggal</div>
                          <input id="tgl_awal" class="form-control input-sm" name="tgl_awal" type="text">
                            
                          <span class="input-group-addon">-</span>
                          <input id="tgl_akhir"" class="input-sm form-control datepicker2" name="tgl_akhir" type="text">

                          <div class="input-group-btn">
                            <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="cari()">
                              <strong>
                                <i class="fa fa-search" aria-hidden="true"></i>
                              </strong>
                            </button>
                            <button class="btn btn-info btn-sm btn-flat" type="button" onclick="resetData()">
                              <strong>
                                <i class="fa fa-undo" aria-hidden="true"></i>
                              </strong>
                            </button>
                          </div>

                          
                        </div>
                    </div>
                  </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12" align="right">
                  <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" onclick="location.href = '{{ url('nabila/returnpembelian/tambah_pembelian') }}'">
                        <i class="fa fa fa-plus"></i> &nbsp;&nbsp;Tambah Data
                  </button>
              </div>
        


      </div>
        </div>

         <div class="row">
            <div class="col-md-12" >
               
               <div class="table-responsive">
                  <table class="table table-hover table-bordered" width="100%" cellspacing="0" id="tabel_d_shop_purchase_return">
                     <thead>
                        <tr role="row">
                           <th class="wd-10p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Tgl Return: activate to sort column ascending" style="width: 84.0039px;">Tgl Return</th>
                           <th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="ID Return: activate to sort column ascending" style="width: 84.0039px;">ID Return</th>
                           <th class="wd-10p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Staff: activate to sort column ascending" style="width: 44.0039px;">Staff</th>
                           <th class="wd-10p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Metode: activate to sort column ascending" style="width: 84.0039px;">Metode</th>
                           <th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Supplier: activate to sort column ascending" style="width: 151.004px;">Supplier</th>
                           <th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Total Retur: activate to sort column ascending" style="width: 151.004px;">Total Retur</th>
                           <th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 44.0039px;">Status</th>
                           <th class="wd-15p sorting" tabindex="0" aria-controls="tabel-return" rowspan="1" colspan="1" aria-label="Total Retur: activate to sort column ascending" style="width: 151.004px;">Ubah Status</th>

                           <th style="width: 15%"></th>
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
@include("Nabila::returnpembelian/includes/modal_alter_status") 
@include("Nabila::returnpembelian/js/functions") 
@include("Nabila::returnpembelian/js/format_currency") 
@include("Nabila::returnpembelian/js/commander") 
@endsection