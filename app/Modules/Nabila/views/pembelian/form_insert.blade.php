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
                            <div class="page-title">Form Pembelian</div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li>Pembelian&nbsp;&nbsp;</li><i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                            <li class="active">Form Pembelian</li>
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
                                        <li class="active"><a href="#alert-tab" data-toggle="tab">Form Pembelian</a></li>
                                    </ul>
                                    <div id="generalTabContent" class="tab-content responsive" >
                                        <div id="alert-tab" class="tab-pane fade in active">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: -10px;margin-bottom: 10px;">
                                                        <div class="form-group">
                                                          <h4>Form Pembelian</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6" align="right">
                                                        <a href="{{ route('index_shop_pembelian') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                                    </div>  
                                                    <form id="form_shop_purchase_order">
                                                        <input type="hidden" name="spo_mem" value="{{ Auth::user()->m_id }}">
                                                        {{ csrf_field() }}
                                                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Kode Pembelian</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input type="text" readonly="" class="form-control input-sm" name="nota" value="(Auto)">
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
                                                                    <input class="form-control input-sm" type="text" id="spo_date" name="spo_date" autocomplete="off">
                                                                </div>
                                                            </div>


                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Cara Pembayaran</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <select name="spo_method" id="spo_method" class="form-control">
                                                                      <option value="TUNAI">Tunai</option>
                                                                      <option value="DEPOSIT">Deposit</option>
                                                                      <option value="TEMPO">Tempo</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                    <label class="tebal">Kode Rencana</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <select name="spo_purchaseplan" id="spo_purchaseplan" class="form-control"></select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    <label class="tebal">Supplier</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                <div class="form-group">
                                                                    <select type="text" name="spo_supplier" class="form-control input-sm"  
                                                                    id="spo_supplier"></select>
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
                      <th>Aksi</th>
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
                     <input type="text" id="spo_total_gross" name="spo_total_gross" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                  </div>
               </div>
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">Potongan Harga</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="text" id="spo_disc_value" name="spo_disc_value" class="form-control input-sm reset" style="text-align: right;">
                  </div>
               </div>
              
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">PPN</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="number" id="spo_tax_percent" name="spo_tax_percent"  class="form-control input-sm reset" style="text-align: right;">
                  </div>
               </div>
              
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">Total</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="text" id="spo_total_net" name="spo_total_net" readonly="true" class="form-control input-sm reset" style="text-align: right;">
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
                <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" onclick="insert_d_shop_purchase_order()">
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

@include('Nabila::pembelian/js/form_functions')
@include('Nabila::pembelian/js/form_commander')

@endsection()


