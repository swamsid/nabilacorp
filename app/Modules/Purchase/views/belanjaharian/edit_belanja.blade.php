@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Update Belanja Harian</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Belanja Harian&nbsp;&nbsp;</li><i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Form Update Belanja Harian</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Update Belanja Harian</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                          </ul>
                    <div id="generalTabContent" class="tab-content responsive" >
                      <!-- div alert-tab -->
                      <div id="alert-tab" class="tab-pane fade in active">
                      <div class="row">  
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          
                          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                           <div class="col-md-5 col-sm-6 col-xs-8" >
                             <h4>Form Update Belanja Harian</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                             <a href="{{ url('purchasing/belanjaharian/belanja') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>
                         </div>

                         <form id='form_d_purchasingharian'>
                              <input type="hidden" name="d_pcsh_id" value="{{ $d_purchasingharian->d_pcsh_id }}">
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-top:30px;padding-bottom:20px;">
                               
                               
                              

                                 <div class="col-md-2 col-sm-3 col-xs-12">
                                  
                                      <label class="tebal">Tanggal Beli</label>
                                  
                                </div>

                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-icon ">
                                      <i class="glyphicon glyphicon-calendar"></i>
                                        
                                        <input type="text" name="d_pcsh_date" id="d_pcsh_date" value="{{ $d_purchasingharian->d_pcsh_date }}" class="form-control" readonly>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">
                                  
                                      <label class="tebal">No Nota</label>
                                </div>

                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                   
                                      <input type="text" readonly="" class="form-control input-sm" value="{{ $d_purchasingharian->d_pcsh_code }}">                
                                    
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">
                                  
                                      <label class="tebal">Petugas Administrator</label>
                                  
                                </div>

                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" readonly="" value="{{ $d_purchasingharian->m_name }}" class="form-control input-sm" >
                                      
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">
                                  
                                    <label class="tebal">Keperluan</label>
                                 
                                </div>

                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                   
                                      <input readonly type="text" id="d_pcsh_keperluan" name="d_pcsh_keperluan" class="form-control input-sm" value="{{ $d_purchasingharian->d_pcsh_keperluan }}">
                                    
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">
                                  
                                      <label class="tebal">Total bayar</label>
                                  
                                </div>

                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                      <input type="text"  readonly id="total_bayar" class="form-control input-sm">
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">
                                  
                                      <label class="tebal">Divisi Peminta</label>
                                  
                                </div>

                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" value="{{ $d_purchasingharian->d_divisi }}" class="form-control input-sm" readonly>
                                  </div>
                                </div>
                                
                                <div class="col-md-12 tamma-bg" style="margin-top: 5px;margin-bottom: 5px;margin-bottom: 20px; padding-bottom:20px;padding-top:20px;">
               <div class="col-md-6">
                  <label class="control-label tebal" for="">Masukan Kode / Nama</label>
                  <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="text" name="d_pcshdt_item" id="d_pcshdt_item" class="form-control">
                  </div>
               </div>
               
               <div class="col-md-6">
                  <label class="control-label tebal" name="qty";>Jumlah</label>
                  <div class="input-group input-group-sm" style="width: 100%;">
                     <input type="number" class="move up3 form-control input-sm alignAngka reset reset-seach" id="d_pcshdt_qty" onclick="" >   
                  </div>
               </div>
            </div>
                              </div>


                              <div class="table-responsive">
                                <table class="table tabelan table-bordered" id="tabel_d_purchasingharian_dt">
                                  <thead>
                                    <tr>
                                      <th width="25%">Nama Barang</th>
                                      <th>QTY</th>
                                      <th width="5%">Satuan</th>
                                      <th>Harga Satuan</th>
                                      <th>Total Harga</th>
                                      <th>Aksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                                </table>
                              </div>

                              <div align="right" style="margin-top:20px;">
                                <div class="form-group" align="right">
                                  <input type="button" name="tambah_data" value="Simpan Data" class="btn btn-primary" onclick="update_d_purchasingharian()">
                                </div>
                              </div>

                            </form>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
@endsection
@section("extra_scripts")
    @include('Purchase::belanjaharian/js/format_currency')
    @include('Purchase::belanjaharian/js/form_functions')
    @include('Purchase::belanjaharian/js/form_commander')
    <script>
      $(document).ready(function(){
        var d_purchasingharian_dt = {!! $d_purchasingharian_dt !!};
        var data;
        if(d_purchasingharian_dt.length > 0) {
          for(var x = 0;x < d_purchasingharian_dt.length;x++) {
            data = d_purchasingharian_dt[x];

            var d_pcshdt_item = "<input type='hidden' name='d_pcshdt_item[]' value='" + data.i_id + "'>" + data.i_code + ' - ' + data.i_name;
            var d_pcshdt_qty = data.d_pcshdt_qty;
            var s_detname = data.s_detname;
            var i_price = data.i_price ;
            var total_harga = i_price * d_pcshdt_qty;
            var aksi = "<button onclick='remove_item(this)' type='button' class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i></button";

            d_pcshdt_qty = "<input type='hidden' name='d_pcshdt_qty[]' value='" + d_pcshdt_qty + "'>" + d_pcshdt_qty;
            i_price = "<input type='hidden' name='d_pcshdt_price[]' value='" + i_price + "'>" + get_currency(i_price);
            total_harga = get_currency(total_harga);

            tabel_d_purchasingharian_dt.row.add(
              [d_pcshdt_item, d_pcshdt_qty, s_detname, i_price, total_harga, aksi]
            );

          }
          tabel_d_purchasingharian_dt.draw();
        }
      });
    </script>
@endsection()