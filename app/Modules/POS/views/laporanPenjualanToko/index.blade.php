@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
   <!--BEGIN TITLE & BREADCRUMB PAGE-->
   <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
         <div class="page-title">Laporan Penjualan Toko</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
         <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li class="active">Laporan Penjualan Toko</li>
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
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Laporan Penjualan</a></li>
                 {{--  <li><a href="#note-tab" data-toggle="tab">Laporan Penjualan Mobil</a></li> --}}
                  {{--              <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> --}}
               </ul>
               <div id="generalTabContent" class="tab-content responsive">
                  <div id="alert-tab" class="tab-pane fade in active">
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="col-md-5 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="col-md-2 col-xs-12">
                                    <label style="padding-top: 7px; font-size: 15px; margin-right:3mm;">Staff</label>
                                 </div>
                                 <div class="col-md-10 col-xs-12">
                                    <div class="form-group">
                                       <select class="form-control input-sm" id="shift" onchange="table()">
                                          @foreach ($pegawai as $data)
                                          <option value="{{ $data->c_id }}">{{ $data->c_code }} - {{ $data->c_nama }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-5 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                              <div class="row">
                                 <div class="col-md-9 col-sm-12 col-xs-12">
                                    <div class="row">
                                       <div class="col-md-2 col-sm-12 col-xs-12">
                                          <label style="padding-top: 7px; font-size: 15px; margin-right:3mm;">Tanggal</label>
                                       </div>
                                       <div class="col-md-10 col-sm-12 col-xs-12">
                                          <div class="form-group">
                                             <div class="input-daterange input-group">
                                                <input id="tgl_awal" class="form-control input-sm datepicker1" name="tgl_awal" type="text">
                                                <span class="input-group-addon">-</span>
                                                <input id="tgl_akhir" class="input-sm form-control datepicker2" name="tgl_akhir" type="text" value="{{ date('d-m-Y') }}">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12" align="center">
                                    <button class="btn btn-warning btn-sm btn-flat" type="button" onclick='table()'>
                                    <strong>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    </strong>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-flat" type="button" onclick='resetData()'>
                                    <strong>
                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                    </strong>
                                    </button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12" align="right">
                              <button class="btn btn-info btn-sm" title="Analisa Penjualan" onclick="analisa()">
                                 <i class="fa fa-line-chart"></i>
                              </button>
                              <button class="btn btn-primary btn-sm" title="Print" onclick="print_laporan()">
                                 <i class="fa fa-print"></i>
                              </button>
                              <button class="btn btn-success btn-sm" title="Excel" type="button" onclick="print_excel()">
                                 <i class="fa fa-file" title="Excel"></i>
                              </button>
                           </div>
                           <!-- selesai -->
                        </div>
                        <!-- Tambahan -->
                        <div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                           <div class="col-md-6 col-xs-12">
                              <label>Total Diskon Percent</label>
                              <div class="form-group">
                                 <input type="text" readonly="" class="form-control form-control-l text-right" name="" id="percent">
                              </div>
                           </div>
                           <div class="col-md-6 col-xs-12">
                              <label>Total Penjualan</label>
                              <div class="form-group">
                                 <input type="text" readonly="" class="form-control form-control-l text-right" name="" id="total">
                              </div>
                           </div>
                           
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="table-responsive">
                              <table id="tabel_d_sales_dt" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                                 <thead>
                                    <tr>
                                       <th>Nama</th>
                                       <th>No Bukti</th>
                                       <th>Tanggal</th>
                                       <th>Sat</th>
                                       <th>Qty</th>
                                       <th>Harga</th>
                                       <th>Disc%(Rp)</th>
                                       <th>Diskon Rp</th>
                                       <th>Total</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- /div alert-tab -->
                  <!-- div note-tab -->
                  <div id="note-tab" class="tab-pane fade">
                     <div class="row">
                        <div class="panel-body">
                           <!-- Isi Content -->
                        </div>
                     </div>
                  </div>
                  <!--/div note-tab -->
                  <!-- div label-badge-tab -->
                  <div id="label-badge-tab" class="tab-pane fade">
                     <div class="row">
                        <div class="panel-body">
                           <!-- Isi content -->we
                        </div>
                     </div>
                  </div>
                  <!-- /div label-badge-tab -->
               </div>
            </div>
         </div>

         <div class="modal fade" id="modal-analisa" role="dialog">
           <div class="modal-dialog">
               
             
               <!-- Modal content-->
                 <div class="modal-content" style="width: 80%; margin: 0 auto;">
                   <div class="modal-header" style="background-color: #e77c38;">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title" style="color: white;">Analisa Penjualan</h4>
                   </div>
                   <form action="{{ Route('analisa_penjualan.index') }}" method="GET" target="_blank">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                      <div class="modal-body">

                        <table class="table">
                           <thead>
                              <tr>
                                 <th width="40%" style="vertical-align: middle; text-align: left;">Type Analisa</th>
                                 <td>
                                    <select class="form-control" id="type" name="type">
                                       <option value="1">Item Terlaris</option>
                                       <option value="2">Detail Penjualan Item</option>
                                    </select>
                                 </td>
                              </tr>

                              <tr>
                                 <th width="40%" style="vertical-align: middle; text-align: left;">Jumlah Data Ditampilkan</th>
                                 <td>
                                    <input type="text" name="counter" class="form-control" placeholder="ex: 4">
                                 </td>
                              </tr>

                              <tr>
                                 <th width="40%" style="vertical-align: middle; text-align: left;">Tanggal</th>
                                 <td>
                                    <input type="text" name="date1" class="form-control datepicker" placeholder="DD-MM-YYY" style="cursor: pointer; padding-left: 10px;" autocomplete="none">
                                 </td>
                              </tr>

                              <tr>
                                 <th width="40%" style="vertical-align: middle; text-align: left;">Sampai Tanggal</th>
                                 <td>
                                    <input type="text" name="date2" class="form-control datepicker" placeholder="DD-MM-YYY" style="cursor: pointer; padding-left: 10px;" autocomplete="none">
                                 </td>
                              </tr>

                              <tr id="optional" style="display: none">
                                 <th style="vertical-align: middle; text-align: left;">Pilih Barang Produksi</th>
                                 <td>
                                    <select class="form-control input-sm select-2" id="cari_sup" name="id_item" style="width: 100%; text-align: left">
                                       @foreach($item as $key => $itm)
                                          <option value="{{ $itm->i_id }}">{{ $itm->i_code }} {{ $itm->i_name }}</option>
                                       @endforeach
                                    </select>
                                 </td>
                              </tr>
                           </thead>
                        </table>
                        
                      </div>
                  
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Proses</button>
                      </div>
                  </form>
                 </div>
                  
             </div>
         </div>

         @endsection
         @section("extra_scripts")
         @include('POS::laporanPenjualanToko/js/commander')
         @endsection()