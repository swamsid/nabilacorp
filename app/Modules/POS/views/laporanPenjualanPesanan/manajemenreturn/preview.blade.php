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
                                 <input type="text" value='{{ $d_sales_return->dsr_status_label }}' readonly>
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
                                 <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 10px; padding-top:25px;padding-bottom:20px;">
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                       <label class="tebal">Nota Penjualan<font color="red">*</font></label>
                                    </div>
                                    <div class="col-md-4 col-sm-9 col-xs-12">
                                       <div class="form-group">
                                          <input type="text" value='{{ $d_sales_return->s_note }}' readonly>
                                       </div>
                                    </div>
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                       <label class="tebal">Tanggal Return</label>
                                    </div>
                                    <div class="col-md-4 col-sm-9 col-xs-12">
                                       <div class="form-group">
                                          <input id="tanggalReturn" class="form-control input-sm datepicker2 " name="tanggal" type="text" value="{{ date('d-m-Y', strtotime($d_sales_return->dsr_date)) }}">
                                       </div>
                                    </div>
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                       <label class="tebal">Metode Pembayaran</label>
                                    </div>
                                    <div class="col-md-4 col-sm-9 col-xs-12">
                                       <div class="form-group">
                                          <input type="text" name="pm_name" readonly="" class="form-control input-sm" id="pm_name">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px; padding-top:25px;padding-bottom:20px;">
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                       <label class="tebal">Detail Pelanggan</label>
                                    </div>
                                    <div class="col-md-10 col-sm-9 col-xs-12">
                                       <div class="form-group">
                                          <input type="text" name="c_name" value="{{ $d_sales_return->dsr_customer . '. ' . $d_sales_return->dsr_alamat_customer }}" readonly class="form-control input-sm" id="c_name">
                                       </div>
                                    </div>
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                       <label class="tebal">Total Return</label>
                                    </div>
                                    <div class="col-md-4 col-sm-9 col-xs-12">
                                       <div class="form-group">
                                          <input type="text" name="t_return" readonly value="{{ $d_sales_return->dsr_price_return }}" class="form-control input-sm" id="t_return" value="">
                                       </div>
                                    </div>
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                       <label class="tebal">S Gross</label>
                                    </div>
                                    <div class="col-md-4 col-sm-9 col-xs-12">
                                       <div class="form-group">
                                          <input type="text" name="s_gross" readonly="" class="form-control input-sm" id="s_gross" value="{{ $d_sales_return->dsr_sgross }}">
                                       </div>
                                    </div>
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                       <label class="tebal">Total Diskon</label>
                                    </div>
                                    <div class="col-md-4 col-sm-9 col-xs-12">
                                       <div class="form-group">
                                          <input type="text" name="total_diskon" readonly="" class="form-control input-sm totalGross" id="total_diskon">
                                          <input type="hidden" name="total_value" readonly="" class="form-control input-sm total_value" id="total_value">
                                          <input type="hidden" name="total_percent" readonly="" class="form-control input-sm total_percent" id="total_percent">
                                       </div>
                                    </div>
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                       <label class="tebal">Total Penjualan (Nett)</label>
                                    </div>
                                    <div class="col-md-4 col-sm-9 col-xs-12">
                                       <div class="form-group">
                                          <input type="text" name="s_net" readonly="" class="form-control input-sm totalGross" id="s_net" value="{{ $d_sales_return->net }}">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="table-responsive">
                                    <table class="table tabelan table-bordered" id="tabel-return-sales" width="100%">
                                       {{ csrf_field() }}
                                       <thead>
                                          <tr>
                                             <th width="18%">Nama</th>
                                             <th width="2%">Return</th>
                                             <th width="2%">Satuan</th>
                                             <th width="10%">Harga</th>
                                             <th width="10%">Harga Setelah Diskon</th>
                                             <th width="11%">Total</th>
                                             <th width="6%">Desc</th>
                                          </tr>
                                       </thead>
                                       <tbody id="dataDt">
                                          @if( count($d_sales_returndt) > 0 )
                                             @foreach( $d_sales_returndt as $data )
                                                <tr>
  <td>
      {{$data->i_name}}
  </td>
  <td>
      {{$data->dsrdt_qtyconfirm}}
  </td>
  <td>
      {{$data->s_name}}
  </td>
  <td>
      Rp. {{number_format($data->sd_price,2,',','.')}}
  </td>
 
  <td>
      Rp. {{number_format($data->dsrdt_price,2,',','.')}}
  </td>
 
  
  <td>
    Rp. {{number_format($data->sd_price * $data->dsrdt_price,2,',','.')}}
  </td>
  <td>
        {{ $data->dsrdt_description }}
  </td>
</tr>
                                             @endforeach
                                          @else
                                             <tr>
                                                <td colspan="7">Tidak ada data</td>
                                             </tr>
                                          @endif
                                       </tbody>
                                    </table>
                                 </div>
                                 <div align="right" style="padding-top: 15px;">
                                    <div id="div_button_save" class="form-group">
                                       <button type="button" id="button_save" class="btn btn-primary" onclick="simpanReturn()">Simpan Data</button>
                                    </div>
                                 </div>
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
@endsection