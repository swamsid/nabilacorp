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
               {{--    <li><a href="#note-tab" data-toggle="tab" onclick="penjualanItem()">Penjualan Item</a></li> --}}
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
                                          <option value="all">Semua</option>
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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="col-md-5 col-sm-12 col-xs-12">
                              <div class="row">
                                 <div class="col-md-2 col-xs-12">
                                    <label style="padding-top: 7px; font-size: 15px; margin-right:3mm;">Staff</label>
                                 </div>
                                 <div class="col-md-10 col-xs-12">
                                    <div class="form-group">
                                       <select class="form-control input-sm" id="shift-item" onchange="penjualanItem()">
                                          <option value="all">Semua</option>
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
                                                <input id="tgl_awal1" class="form-control input-sm datepicker1" name="tgl_awal" type="text">
                                                <span class="input-group-addon">-</span>
                                                <input id="tgl_akhir2" class="input-sm form-control datepicker2" name="tgl_akhir" type="text" value="{{ date('d-m-Y') }}">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12" align="center">
                                    <button class="btn btn-warning btn-sm btn-flat" type="button" onclick='penjualanItem()'>
                                    <strong>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    </strong>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-flat" type="button" onclick='penjualanItem()'>
                                    <strong>
                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                    </strong>
                                    </button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-2 col-sm-12 col-xs-12" align="right">
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

                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="table-responsive">
                              <table id="tabel-item" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                                 <thead>
                                    <tr>
                                       <th>Kode Nama Item</th>
                                       <th>Tipe Item</th>
                                       <th>Jumlah Penjualan</th>
                                       <th>Satuan</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
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
         @endsection
         @section("extra_scripts")
         @include('POS::laporanPenjualanToko/js/commander')
         @endsection()