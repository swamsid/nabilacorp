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
                            <div class="page-title">Form Penerimaan Barang</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li>Penerimaan Barang&nbsp;&nbsp;</li><i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li class="active">Form Penerimaan Barang</li>
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
                                        <li class="active"><a href="#alert-tab" data-toggle="tab">Form Penerimaan Barang</a></li>
                                    </ul>
                                    <div id="generalTabContent" class="tab-content responsive" >
                                        <div id="alert-tab" class="tab-pane fade in active">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: -10px;margin-bottom: 10px;">
                                                        <div class="form-group">
                                                          <h4>Form Penerimaan Barang</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6" align="right">
                                                        <a href="{{ route('index_shop_penerimaanbarang') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                                    </div>  
                                                    <form id="form_shop_terima_pembelian">
                                                        <input type="hidden" name="stb_mem" value="{{ $d_shop_terima_pembelian->stb_mem }}">
                                                        <input type="hidden" name="stb_id" value="{{ $d_shop_terima_pembelian->stb_id }}">
                                                        {{ csrf_field() }}
                                                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Kode Penerimaan Barang</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" readonly="" class="form-control input-sm" name="stb_code" value="{{ $d_shop_terima_pembelian->stb_code }}">
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
                                                                    <label class="tebal">Tanggal Penerimaan Barang</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input class="form-control input-sm" type="text" id="stb_date" name="stb_date" value="{{ $d_shop_terima_pembelian->stb_date }}" readonly>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Cara Pembayaran</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" name="stb_method" value="{{ $d_shop_terima_pembelian->stb_method }}" id="stb_method" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Kode Rencana</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input name="stb_purchaseplan" value="{{ $d_shop_terima_pembelian->sp_code }}" type="text" class="form-control" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="tebal">Supplier</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" name="stb_supplier" value="{{ $d_shop_terima_pembelian->s_company }}" class="form-control input-sm"  
                                                                     readonly>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>


      {{-- form input trigger --}}
                                           
            <div style="padding-top: 20px;padding-bottom: 20px;">                                              
              <div class="table-responsive" style="">
                <table id="tabel_d_shop_terima_pembelian_dt" class="table tabelan table-bordered table-striped">
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
                      <th>Aksi</th>
                  </tr>
                  </thead>
                     <tbody class="tabel_d_shop_terima_pembelian_dt"></tbody>
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
                     <input type="text" id="stb_total_gross" name="stb_total_gross" value="{{ $d_shop_terima_pembelian->stb_total_gross }}" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                  </div>
               </div>
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">Potongan Harga</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="text" id="stb_disc_value" name="stb_disc_value" value="{{ $d_shop_terima_pembelian->stb_disc_value }}" class="form-control input-sm reset" style="text-align: right;">
                  </div>
               </div>
              
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">PPN</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="number" id="stb_tax_percent" name="stb_tax_percent" value="{{ $d_shop_terima_pembelian->stb_tax_percent }}"  class="form-control input-sm reset" style="text-align: right;">
                  </div>
               </div>
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">Total</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="text" id="stb_total_net" name="stb_total_net" value="{{ $d_shop_terima_pembelian->stb_total_net }}" readonly="true" class="form-control input-sm reset" style="text-align: right;">
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
                <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" onclick="perbarui_d_shop_terima_pembelian()">
                        <i class="fa fa-save"></i> Simpan (F10)
                </button>
            </div>


                                        </form>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
@section("extra_scripts")

@include('Nabila::penerimaanbarang/js/form_functions')
@include('Nabila::penerimaanbarang/js/form_commander')
<script>
  $(document).ready(function(){
    var d_shop_terima_pembelian_dt = {!! $d_shop_terima_pembelian_dt !!};
    for(i = 0; i < d_shop_terima_pembelian_dt.length;i++) {

            unit = d_shop_terima_pembelian_dt[i];
            stbdt_item = "<input type='hidden' name='stbdt_item[]' value='" + unit.i_id + "'>" + unit.i_code + " - " + unit.i_name; 
            stbdt_qty = "<input type='hidden' name='stbdt_qty[]' value='" + unit.stbdt_qty + "'>" + unit.stbdt_qty; 
            stbdt_qtyconfirm = "<input type='number' name='stbdt_qtyconfirm[]' value='" + unit.stbdt_qtyconfirm + "' class='form-control'>";
            stbdt_satuan = "<input type='hidden' name='stbdt_satuan[]' value='" + unit.s_id + "'>" + unit.s_name; 
            price = unit.stbdt_price;
            price_label = 'Rp ' + accounting.formatMoney(price, '', 0, '.', 
                    ',');  
            stbdt_price = "<input type='hidden' name='stbdt_price[]' value='" + price + "'>" + price_label; 
            stbdt_prevcost = "<input type='hidden' name='stbdt_prevcost[]' value='0'> 0";
            subtotal = unit.stbdt_qtyconfirm * unit.stbdt_price;
            subtotal = 'Rp ' + accounting.formatMoney(subtotal, '', 0, '.', ',');
            remove_btn = "<button class='btn btn-danger remove_btn' onclick='hapus_detail(this)' type='button'><i class='glyphicon glyphicon-trash'></i></button>";
            s_qty = unit.s_qty;

            tabel_d_shop_terima_pembelian_dt.row.add([
              stbdt_item, stbdt_qty, stbdt_qtyconfirm, stbdt_satuan, stbdt_price, stbdt_prevcost, subtotal, s_qty, remove_btn
            ]);
    }
    tabel_d_shop_terima_pembelian_dt.draw();
  });
</script>
@endsection()


