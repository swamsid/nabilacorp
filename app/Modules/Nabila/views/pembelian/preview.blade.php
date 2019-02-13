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
                            <div class="page-title">Preview Pembelian</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li>Pembelian&nbsp;&nbsp;</li><i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li class="active">Preview Pembelian</li>
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
                                        <li class="active"><a href="#alert-tab" data-toggle="tab">Preview Pembelian</a></li>
                                    </ul>
                                    <div id="generalTabContent" class="tab-content responsive" >
                                        <div id="alert-tab" class="tab-pane fade in active">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: -10px;margin-bottom: 10px;">
                                                        <div class="form-group">
                                                          <h4>Preview Pembelian</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6" align="right">
                                                        <a href="{{ route('index_shop_pembelian') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                                    </div>  
                                                    <form id="form_shop_purchase_order">
                                                        <input type="hidden" name="spo_mem" value="{{ $d_shop_purchase_order->spo_mem }}">
                                                        <input type="hidden" name="spo_id" value="{{ $d_shop_purchase_order->spo_id }}">
                                                        {{ csrf_field() }}
                                                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Kode Pembelian</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" readonly="" class="form-control input-sm" name="spo_code" value="{{ $d_shop_purchase_order->spo_code }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Staff</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" value="{{ Auth::user()->m_id }}">
                                                                    <input type="text" readonly class="form-control input-sm" value="{{ Auth::user()->m_name }}">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Tanggal Pembelian</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input class="form-control input-sm" type="text" id="spo_date" name="spo_date" value="{{ $d_shop_purchase_order->spo_date }}" readonly>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Cara Pembayaran</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" name="spo_method" value="{{ $d_shop_purchase_order->spo_method }}" id="spo_method" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Kode Rencana</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input name="spo_purchaseplan" value="{{ $d_shop_purchase_order->sp_code }}" type="text" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="tebal">Supplier</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" name="spo_supplier" value="{{ $d_shop_purchase_order->s_company }}" class="form-control input-sm"  
                                                                     readonly>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>


      {{-- form input trigger --}}
                                           
            <div style="padding-top: 20px;padding-bottom: 20px;">                                              
              <div class="table-responsive" style="">
                <table id="tabel_d_shop_purchaseorder_dt" class="table tabelan table-bordered table-striped">
                  <thead>
                   <tr>

                      <th>Kode - Barang</th>
                      <th>Qty</th>
                      <th>Qty Confirm</th>         
                      <th>Satuan</th>    
                      <th>Harga Satuan </th>         
                      <th>Harga Prev </th>         
                      <th>Total </th>         
                      <th>Stok Gudang </th>         
                  </tr>
                  </thead>
                     <tbody class="tabel_d_shop_purchaseorder_dt"></tbody>
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
                     <input type="text" id="spo_total_gross" name="spo_total_gross" value="{{ $d_shop_purchase_order->spo_total_gross }}" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                  </div>
               </div>
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">Potongan Harga</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="text" id="spo_disc_value" name="spo_disc_value" value="{{ $d_shop_purchase_order->spo_disc_value }}" class="form-control input-sm reset" style="text-align: right;" readonly>
                  </div>
               </div>
              
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">PPN</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="number" id="spo_tax_percent" name="spo_tax_percent" value="{{ $d_shop_purchase_order->spo_tax_percent }}"  class="form-control input-sm reset" style="text-align: right;" readonly>
                  </div>
               </div>
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">Total</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="text" id="spo_total_net" name="spo_total_net" value="{{ $d_shop_purchase_order->spo_total_net }}" readonly="true" class="form-control input-sm reset" style="text-align: right;">
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
          
            <div class="col-md-12 col-sm-12 col-xs-12" align="right">
               
            </div>


                                        </form>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
@section("extra_scripts")

@include('Nabila::pembelian/js/form_functions')
@include('Nabila::pembelian/js/form_commander')
<script>
  $(document).ready(function(){
    var d_shop_purchaseorder_dt = {!! $d_shop_purchaseorder_dt !!};
    for(i = 0; i < d_shop_purchaseorder_dt.length;i++) {

            unit = d_shop_purchaseorder_dt[i];
            spodt_item = "<input type='hidden' name='spodt_item[]' value='" + unit.i_id + "'>" + unit.i_code + " - " + unit.i_name; 
            spodt_qty = "<input type='hidden' name='spodt_qty[]' value='" + unit.spodt_qty + "'>" + unit.spodt_qty; 
            spodt_qtyconfirm = "<input type='hidden' name='spodt_qtyconfirm[]' value='" + unit.spodt_qtyconfirm + "' >" + unit.spodt_qtyconfirm;
            spodt_satuan = "<input type='hidden' name='spodt_satuan[]' value='" + unit.s_id + "'>" + unit.s_name; 
            price = unit.spodt_price;
            price_label = 'Rp ' + accounting.formatMoney(price, '', 0, '.', 
                    ',');  
            spodt_price = "<input type='hidden' name='spodt_price[]' value='" + price + "'>" + price_label; 
            spodt_prevcost = "<input type='hidden' name='spodt_prevcost[]' value='0'> 0";
            subtotal = unit.spodt_qtyconfirm * unit.spodt_price;
            subtotal = 'Rp ' + accounting.formatMoney(subtotal, '', 0, '.', ',');
            remove_btn = "<button class='btn btn-danger remove_btn' onclick='hapus_detail(this)' type='button'><i class='glyphicon glyphicon-trash'></i></button>";
            s_qty = unit.s_qty;

            tabel_d_shop_purchaseorder_dt.row.add([
              spodt_item, spodt_qty, spodt_qtyconfirm, spodt_satuan, spodt_price, spodt_prevcost, subtotal, s_qty
            ]);
    }
    tabel_d_shop_purchaseorder_dt.draw();
    $('#spo_disc_value').val(
          'Rp ' + accounting.formatMoney($('#spo_disc_value').val(), '', 0, '.', 
                    ',')
    )
  });
</script>
@endsection()


