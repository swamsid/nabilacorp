    @extends('main')
    @section('content')
    <style type="text/css">
 .btn-flat{
 border: 0;
 border-radius:0 !important;
}
    </style>
                <div id="page-wrapper">
                    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                            <div class="page-title">Form Rencana Pembelian</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li>Rencana Pembelian&nbsp;&nbsp;</li><i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li class="active">Form Rencana Pembelian</li>
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
                                        <li class="active"><a href="#alert-tab" data-toggle="tab">Form Rencana Pembelian</a></li>
                                    </ul>
                                    <div id="generalTabContent" class="tab-content responsive" >
                                        <div id="alert-tab" class="tab-pane fade in active">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: -10px;margin-bottom: 10px;">
                                                        <div class="form-group">
                                                          <h4>Form Rencana Pembelian</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6" align="right">
                                                        <a href="{{ route('index_shop_rencanapembelian') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                                    </div>  
                                                    <form id="form_shop_purchase_plan">
                                                        <input type="hidden" name="sp_id" value="{{ $d_shop_purchase_plan->sp_id }}">
                                                        <input type="hidden" name="sp_mem" value="{{ $d_shop_purchase_plan->sp_mem }}">
                                                        {{ csrf_field() }}
                                                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Kode Rencana Pembelian</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" readonly="" class="form-control input-sm" name="nota" value="{{ $d_shop_purchase_plan->sp_code }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Tanggal Rencana Pembelian</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input class="form-control input-sm" type="text" id="sp_date" name="sp_date" value="{{ $d_shop_purchase_plan->sp_date_label }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Supplier</label>
                                                            </div>
                                                            <div class="col-md-9 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" value="{{ $d_shop_purchase_plan->s_company }}" readonly>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Gudang</label>
                                                            </div>
                                                            <div class="col-md-9 col-sm-12 col-xs-12">
                                                               <div class="input-group input-group-sm" style="width: 100%;">
                                                                    <input type="text" class="form-control" value="{{ $d_shop_purchase_plan->c_owner }} - {{ $d_shop_purchase_plan->gc_gudang }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>


      {{-- form input trigger --}}

                                               
            <div style="padding-top: 20px;padding-bottom: 20px;">                                              
              <div class="table-responsive" style="">
                <table id="tabel_d_shop_purchaseplan_dt" class="table tabelan table-bordered table-striped">
                  <thead>
                   <tr>

                      <th>Kode - Barang</th>
                      <th>Stok Gudang</th>
                      <th>Qty</th>
                      <th>Harga</th>         
                      <th>Satuan</th>    
                      <th>Harga Total</th>         
                  </tr>
                  </thead>
                     <tbody class="tabel_d_shop_purchaseplan_dt"></tbody>
                </table>
              </div>
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12" >
            <div class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top: 10px;">
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">Total Harga</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="text" id="total_bayar" name="total_bayar" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                  </div>
               </div>
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: none;">
                  <div class="form-group">
                     <input type="text" id="grand" name="" readonly="true" class="form-control input-sm reset" style="text-align: right;font-weight: bold;">
                  </div>
               </div>
                   
               <!--      <div class="col-md-6 col-sm-6 col-xs-12">
                  <label class="control-label tebal" for="jumlah">Jumlah Pembayaran</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" id="jml_bayar" name="" class="form-control input-sm jml_bayar reset" style="text-align: right;" onkeyup="numberOnly()" disabled="">
                  </div>
                  </div> -->
            </div>
            <!-- Start Modal Proses -->
            
            <!-- End Modal Proses -->
         </div>
          


                                        </form>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
@section("extra_scripts")

@include('Nabila::rencanapembelian/js/form_functions')
@include('Nabila::rencanapembelian/js/form_commander')
<script>
      $(document).ready(function(){
        var d_shop_purchaseplan_dt = {!! $d_shop_purchaseplan_dt !!};
        var data;
        if(d_shop_purchaseplan_dt.length > 0) {
          for(var x = 0;x < d_shop_purchaseplan_dt.length;x++) {
            data = d_shop_purchaseplan_dt[x];

            var sppdt_item = "<input type='hidden' name='sppdt_item[]' value='" + data.i_id + "'>" + data.i_code + ' - ' + data.i_name;
            var s_qty = data.s_qty;
            var sppdt_qty = "<input type='hidden' name='sppdt_qty[]' value='" + data.sppdt_qty + "'>" + data.sppdt_qty;
            var sppdt_satuan = "<input type='hidden' name='sppdt_satuan[]' value='" + data.sppdt_satuan + "'>" + data.sppdt_satuan;
            var sppdt_price = data.sppdt_price ;
            var total_harga = data.sppdt_qty * data.sppdt_price;
            var aksi = "<button onclick='remove_item(this)' type='button' class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i></button";

            sppdt_price = "<input type='hidden' name='sppdt_price[]' value='" + sppdt_price + "'>Rp " + accounting.formatMoney( sppdt_price, '', '.', ',' );
            total_harga = "Rp " + accounting.formatMoney( total_harga, '', '.', ',' );

            tabel_d_shop_purchaseplan_dt.row.add(
              [sppdt_item, s_qty, sppdt_qty, sppdt_price, sppdt_satuan, total_harga]
            );

          }
          tabel_d_shop_purchaseplan_dt.draw();
        }
      });
    </script>
@endsection()


