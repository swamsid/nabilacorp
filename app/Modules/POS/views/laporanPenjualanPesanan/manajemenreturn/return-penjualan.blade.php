@extends('main')
@section('content')
<style type="text/css">
   .ui-autocomplete { z-index:2147483647; }
   .select2-container { margin: 0; }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
   <!--BEGIN TITLE & BREADCRUMB PAGE-->
   <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
         <div class="page-title">Form Return Penjualan</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
         <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li class="active">Return Penjualan</li>
         <li><i class="fa fa-angle-right"></i>&nbsp;Form Return Penjualan&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
      </ol>
      <div class="clearfix"></div>
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
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Form Return Penjualan</a></li>
                  <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                     <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
               </ul>
               <div id="generalTabContent" class="tab-content responsive" >
                  <div id="alert-tab" class="tab-pane fade in active">
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                           <div class="col-md-5 col-sm-6 col-xs-8">
                              <h4>Form Return Penjualan</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                              <a href="{{ url('penjualan/manajemenreturn/r_penjualan') }}" class="btn">
                              <i class="fa fa-arrow-left"></i>
                              </a>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                           <div class="col-md-2 col-sm-3 col-xs-12">
                              <label class="tebal">Metode Return</label>
                           </div>
                           <div class="col-md-4 col-sm-9 col-xs-12">
                              <div class="form-group">
                                 <select class="form-control input-sm" id="pilih_metode_return" name="pilihMetodeReturn" style="width: 100%;">
                                    <option value=""> - Pilih Metode Return</option>
                                    <option value="PN"> Potong Nota </option>
                                    <option value="TB"> Tukar Barang </option>
                                    {{-- 
                                    <option value="SB"> Salah Barang </option>
                                    <option value="SA"> Salah Alamat </option>
                                    <option value="KB"> Kurang Barang </option>
                                    --}}
                                 </select>
                              </div>
                           </div>
                        </div>
                        <!-- START div#header_form -->
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;" id="header_form">
                           <form method="post" id="form_return_pembelian">
                              {{ csrf_field() }}
                              <input type="hidden" name="dsr_customer" id="dsr_customer">
                              <input type="hidden" name="dsr_alamat_customer" id="dsr_alamat_customer">
                              <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px; padding-top:10px;padding-bottom:20px;" id="appending-form">
                              </div>
                           </form>
                        </div>
                        <!-- END div#header_form -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--END PAGE WRAPPER-->              
@endsection
@section("extra_scripts")
   <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
   @include('POS::manajemenreturn/js/form_functions')
   @include('POS::manajemenreturn/js/form_commander', ['pn_template' => $pn_template, 'tb_template' => $tb_template])
@endsection