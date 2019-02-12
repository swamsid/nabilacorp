@extends('main')
@section('content')

<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
   <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Rencana Pembelian</div>
   </div>
   <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Pembelian&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;<a href="{{url('pembelian/POSpembelian/POSpembelian')}}">Rencana Pembelian</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Rencana Pembelian</li>
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
         <li class="active"><a id="list" href="#listtoko" data-toggle="tab">List Rencana Pembelian</a></li>
         <!-- 
            <li><a href="#mobil" data-toggle="tab">Pembelian Mobil</a></li>
            <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
         <!-- <li><a href="#konsinyasi" data-toggle="tab">Pembelian Konsinyasi</a></li> -->
      </ul>
      <div id="generalTabContent" class="tab-content responsive">
         <!-- Modal -->
         <div id="alert-tab" class="tab-pane fade in active">
    <div class="row">



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
                  <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" onclick="location.href = '{{ route('form_insert_shop_rencanapembelian') }}'">
                        <i class="fa fa fa-plus"></i> &nbsp;&nbsp;Tambah Data
                  </button>
              </div>
        


      </div>
  </div>


   
    <div class="col-md-12 col-sm-12 col-xs-12">                          
      <div class="table-responsive">
        <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabel_d_shop_purchase_plan">
              <thead>
                  <tr>                    
                    <th width="10%">Tgl Buat</th>     
                    <th width="30%">Kode rencana</th>
                    <th width="15%">Suplier</th>                                      
                    <th width="10%">Status</th>
                    <th width="15%">Ubah Status</th>
                    <th width="15">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                   
                </tbody>                           
        </table> 
      </div>  
    </div>  

    </div>
  </div>
                                        
         <!-- end div #listoko -->
      </div>
      <!-- End div general-content -->
   </div>
</div>
@endsection
@section("extra_scripts")

@include('Nabila::rencanapembelian/includes/modal_alter_status')
@include('Nabila::rencanapembelian/js/format_currency')
@include('Nabila::rencanapembelian/js/format_currency')
@include('Nabila::rencanapembelian/js/form_functions')
@include('Nabila::rencanapembelian/js/form_commander')
@include('Nabila::rencanapembelian/js/functions')
@include('Nabila::rencanapembelian/js/commander')

@endsection