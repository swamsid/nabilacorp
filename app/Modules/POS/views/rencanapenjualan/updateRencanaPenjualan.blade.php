   @extends('main')
@section('content')
@include('POS::rencanapenjualan/js/format_currency')
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
         <li class="active"><a id="penjualan" href="#toko" data-toggle="tab">Update Rencana Penjualan</a></li>
         
         <!-- 
            <li><a href="#mobil" data-toggle="tab">Penjualan Mobil</a></li>
            <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
         <!-- <li><a href="#konsinyasi" data-toggle="tab">Penjualan Konsinyasi</a></li> -->
      </ul>
      <div id="generalTabContent" class="tab-content responsive">
         <!-- Modal -->
         <!-- End Modal -->
         <!-- div #alert-tab -->
         <!-- /div #alert-tab -->
         <!-- Div #listtoko -->
         <!-- @include('penjualan.POSpenjualanToko.listtoko') -->
         <style type="text/css">
         </style>
         <div id="toko" class="tab-pane fade in active">
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
            <div class="col-md-5 col-sm-6 col-xs-8">
              <h4>Form Update Rencana Penjualan</h4>
            </div>
            <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
              <a href="{{ url('/penjualan/rencanapenjualan/rencana#list') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
            </div>
          </div>
            <form method="post" id="form_sales_plan">
               <div class="row">
                  {{ csrf_field() }}
                  <div class="col-md-12">
                     <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-top: 15px;" no>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                           <label>Tanggal</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <input readonly type="text" class="move up1 form-control input-sm reset "  name="s_date" id="s_date" value="{{date('d-m-Y')}}" autocomplete="off">
                              <input type="hidden" class="form-control input-sm reset"  name="s_id" id="s_id" readonly="">
                              <input type="hidden" class="form-control input-sm reset"  name="s_status" id="s_status" readonly="">
                           </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                           <label>No Nota</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <input type="hidden"  name="sp_id" id="sp_id" value="{{ $d_sales_plan->sp_id }}">
                              <input type="text" class="form-control input-sm reset" name="s_note" id="s_note" value="{{ $d_sales_plan->sp_code }}" disabled="">
                           </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                           <label>Pengguna</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <input type="hidden" id="sp_mem" class="form-control input-sm reset" name="sp_mem" readonly="" value="{{Auth::user()->m_id}}">
                              <input type="text" id="s_created_by" class="form-control input-sm reset" name="s_created_by" readonly="" value="{{Auth::user()->m_name}}">
                           </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                           <label>Kasir</label>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <input class="form-control" type="" name="" value="{{$d_sales_plan->sp_comp}}" disabled="">
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 tamma-bg" style="margin-top: 5px;margin-bottom: 5px;margin-bottom: 20px; padding-bottom:20px;padding-top:20px;">
                        <div class="col-md-6">
                           <label class="control-label tebal" for="">Masukan Kode / Nama</label>
                           <div class="input-group input-group-sm" style="width: 100%;">
                              <span role="status" aria-live="polite" class="ui-helper-hidden-accessible">1 result is available, use up and down arrow keys to navigate.</span>
                              <input  class="move up1 form-control input-sm reset-seach" id="searchitem" >
                              <input type="hidden" class="form-control input-sm reset-seach" id="itemName">
                              <input type="hidden" class="form-control input-sm " name="i_id" id="i_id">
                              <input type="hidden" class="form-control input-sm reset-seach" name="i_code" id="i_code">
                              <input type="hidden" class="form-control input-sm reset-seach" id="i_price">
                              <input type="hidden" class="form-control input-sm reset-seach" name="s_satuan" id="s_satuan">
                              <input type="hidden" class="fComp form-control input-sm reset-seach" name="" id="fComp">
                              <input type="hidden" class="fPosition form-control input-sm reset-seach" name="" id="fPosition">
                           </div>
                        </div>
                        <div class="col-md-3">
                           <label class="control-label tebal" name="qty">Stok</label>
                           <div class="input-group input-group-sm" style="width: 100%;">
                              <input type="number" class="form-control input-sm alignAngka reset reset-seach" name="stock" id="stock" disabled="">  
                           </div>
                        </div>
                        <div class="col-md-3">
                           <label class="control-label tebal" name="qty">Jumlah</label>
                           <div class="input-group input-group-sm" style="width: 100%;">
                              <input type="number" class="move up3 form-control input-sm alignAngka reset reset-seach" name="fQty" id="d_pcshdt_qty" onclick="validationForm();" >   
                              <input type="hidden" class="form-control input-sm alignAngka reset reset-seach" name="cQty" id="cQty" onclick="validationForm();">   
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div style="padding-top: 20px;padding-bottom: 20px;">
                        <div class="table-responsive" >
                           <table class="table tabelan table-bordered table-hover dt-responsive" id="tSalesDetail">
                              <thead align="right">
                                 <tr>
                                    <th width="23%">Nama</th>
                                    <th width="4%">Stok</th>
                                    <th width="4%">Jumlah</th>
                                    <th width="5%">Satuan</th>
                                    <th width="3%">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody class="bSalesDetail">
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" >
                     <div class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top: 10px;">
               <div class="col-md-6 col-sm-6 col-xs-12" style="display: flex;justify-content: flex-end">
                  <label class="control-label tebal" for="penjualan">Total QTY</label>
               </div>
               <div class="col-md-6 col-sm-6 col-xs-12 ">
                  <div class="form-group">
                     <input type="text" id="grandtotal" name="s_gross" readonly="true" class="form-control input-sm reset" style="text-align: right;">
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
                     <div class="modal fade" id="proses" role="dialog">
                        <div class="modal-dialog">
                           <!-- Modal content-->
                           <div class="modal-content">
                              <div class="modal-header" style="background-color: #e77c38;">
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 <h4 class="modal-title" style="color: white;">Proses Form Penjualan Toko</h4>
                              </div>
                              <div class="modal-body">
                                 <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:15px;padding-top:15px; ">
                                    <!--   <div class="col-md-5 col-sm-6 col-xs-12"> 
                                       <label class="control-label tebal" >Nama Pelangan</lab
                                       el>
                                       </div>
                                       <div class="col-md-7 col-sm-6 col-xs-12">
                                       <div class="form-group">
                                         <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                           <input  class="minu mx  form-control input-sm reset" id="customer" >
                                           <input type="hidden"  class="form-control input-sm reset" id="s_customer" name="s_customer">
                                         </div>
                                       </div>
                                       </div> -->
                                    <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                       <label class="control-label tebal" for="ongkos_kirim">Biaya Kirim</label>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px">
                                       <div class="form-group">
                                          <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                             <input type="text" id="biaya_kirim" name="s_ongkir" class="minu mx form-control input-sm biaya_kirim reset" style="text-align: right;" onkeyup="hitungTotal();rege(event,'biaya_kirim')"  onblur="setRupiah(event,'biaya_kirim')" onclick="setAwal(event,'biaya_kirim')" value="0" autocomplete="off">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                       <label class="control-label tebal" for="ongkos_kirim">Pembulatan</label>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px">
                                       <div class="form-group">
                                          <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                             <input type="text" id="s_bulat" name="s_bulat" class="minu mx form-control input-sm s_bulat reset" style="text-align: right;" onkeyup="hitungTotal();rege(event,'s_bulat')"  onblur="setRupiah(event,'s_bulat')" onclick="setAwal(event,'s_bulat')"  autocomplete="off">
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="col-md-12" style="border-bottom: 4px solid #9e5a2e; padding-top:8px ">                                  
                                    </div>
                                    <table style="width: 100%" class="table c">
                                       <thead>
                                          <th>Cara Bayar</th>
                                          <th>Jumlah</th>
                                          <td class="hutang" style="display: none;">Jatuh Tempo</th>
                                       </thead>
                                       <tbody class="tr_clone">
                                       </tbody>
                                    </table>
                                    <div class="col-md-12" style="border-bottom: 4px solid #9e5a2e; padding-top:8px ">
                                    </div>
                                    <!--    <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                       <label class="control-label tebal" for="ongkos_kirim">Pembulatan</label>
                                       </div>
                                       <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                       <div class="form-group">
                                         <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                            <input type="text" id="s_bulat" name="s_bulat" class="minu mx form-control input-sm s_bulat reset" style="text-align: right;" onkeyup="hitungTotal();rege(event,'s_bulat')"  onblur="setRupiah(event,'s_bulat')" onclick="setAwal(event,'s_bulat')"  autocomplete="off">
                                         </div>
                                       </div>
                                       </div>
                                       -->
                                    <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                       <label class="control-label tebal" for="ongkos_kirim">Jumlah Bayar</label>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px">
                                       <div class="form-group">
                                          <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                             <input type="text" id="totalBayar" name="s_bayar" class="form-control reset" style="text-align: right;" disabled="" ="">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                       <label class="control-label tebal">Kembalian</label>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px">
                                       <div class="form-group">
                                          <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                             <input id="kembalian" type="text" name="kembalian" class="form-control reset" style="text-align: right;" readonly="">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="minu mx btn btn-warning" data-dismiss="modal">Close</button>
                                 <button class="btn final btn-primary minu mx" type="button" onclick="buttonSimpanPos('final')">Simpan & Print</button>
                                 <button type="button" class="minu mx btn-primary btn btn-disabled perbarui" data-toggle="modal" disabled="" style="display: none;"  onclick="buttonSimpanPos()">Perbarui</button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- End Modal Proses -->
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                     <button class="btn btn-danger " type="button" onclick="batal()">Batal</button>
                     <!--   <button style="display: none;" class="btn btn-warning btn-disabled terima" type="button" onclick="Terima('draft')">Terima</button>     -->                          
                     <button type="button" class="btn-primary btn perbarui" id="perbarui" onclick="perbarui_sales_plan()">Perbarui</button>
                     
                  </div>
               </div>
            </form>
         </div>
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
<script>
   $(document).ready(function(){
      // Memformat grand total
      var d_salesplan_dt = {!! $d_salesplan_dt !!};
     

       var unit;
       for(x = 0;x < d_salesplan_dt.length;x++) {
            unit = d_salesplan_dt[x];
             var spdt_item = "<input type='hidden' name='spdt_item[]' value='" + unit.i_id + "'>" + unit.i_name;
             var spdt_qty = "<input type='number' class='form-control' name='spdt_qty[]' value='" + unit.spdt_qty + "'>";
             var stok = '-';
             var satuan = unit.s_name;

             var aksi = "<button class='btn btn-danger' type='button'><i class='glyphicon glyphicon-trash'></i></button>";
             tSalesDetail.row.add(
               [spdt_item, stok, spdt_qty, satuan, aksi]
             );
       }
       tSalesDetail.draw();
   });
</script>
@endsection