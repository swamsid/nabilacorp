@extends('main')
@section('content')

<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
   <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Rencana Penjualan</div>
   </div>
   <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;<a href="{{url('penjualan/POSpenjualan/POSpenjualan')}}">Rencana Penjualan</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Rencana Penjualan</li>
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
         <li class="active"><a id="penjualan" href="#toko" data-toggle="tab">Rencana Penjualan</a></li>
         <li><a id="list" href="#listtoko" data-toggle="tab">List Rencana Penjualan</a></li>
         <!-- 
            <li><a href="#mobil" data-toggle="tab">Penjualan Mobil</a></li>
            <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
         <!-- <li><a href="#konsinyasi" data-toggle="tab">Penjualan Konsinyasi</a></li> -->
      </ul>
      <div id="generalTabContent" class="tab-content responsive">
         <!-- Modal -->
         {!!$data['toko']!!}
         <!-- End Modal -->
         <!-- div #alert-tab -->
         <!-- /div #alert-tab -->
         <!-- Div #listtoko -->
         <!-- @include('penjualan.POSpenjualanToko.listtoko') -->                               
         {!!$data['listtoko']!!}
         <!-- end div #listoko -->
      </div>
      <!-- End div general-content -->
   </div>
</div>
@endsection
@section("extra_scripts")

@include('POS::rencanapenjualan/js/format_currency')
@include('POS::rencanapenjualan/js/form_functions')
@include('POS::rencanapenjualan/js/form_commander')
@include('POS::rencanapenjualan/js/functions')
@include('POS::rencanapenjualan/js/commander')

@endsection