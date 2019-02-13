@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
   <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Penerimaan Barang</div>
   </div>
   <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Penerimaan Barang&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;<a href="{{url('penerimaanbarang/POSpenerimaanbarang/POSpenerimaanbarang')}}">Penerimaan Barang</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Penerimaan Barang</li>
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
         <li class="active"><a id="list" href="#penerimaangeneral" data-toggle="tab">List Penerimaan Barang</a></li>
         <li><a id="list" href="#penerimaanapproved" data-toggle="tab">History Penerimaan Barang</a></li>
         <!-- 
            <li><a href="#mobil" data-toggle="tab">Penerimaan Barang Mobil</a></li>
            <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
         <!-- <li><a href="#konsinyasi" data-toggle="tab">Penerimaan Barang Konsinyasi</a></li> -->
      </ul>
      <div id="generalTabContent" class="tab-content responsive">
         <!-- Modal -->
         @include('Nabila::penerimaanbarang/includes/penerimaangeneral')
         @include('Nabila::penerimaanbarang/includes/penerimaanapproved')
         <!-- end div #listoko -->
      </div>
      <!-- End div general-content -->
   </div>
</div>
@endsection
@section("extra_scripts")
@include('Nabila::penerimaanbarang/includes/modal_alter_status')
@include('Nabila::penerimaanbarang/js/format_currency')
@include('Nabila::penerimaanbarang/js/functions')
@include('Nabila::penerimaanbarang/js/commander')
@endsection