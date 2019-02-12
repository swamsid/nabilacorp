@extends('main')
@section('content')
<style type="text/css">
   .ui-autocomplete { z-index:2147483647; }
   .select2-container { margin: 0; }
   .error { border: 1px solid #f00; }
   .valid { border: 1px solid #8080ff; }
   .has-error .select2-selection {
   border: 1px solid #f00 !important;
   }
   .has-valid .select2-selection {
   border: 1px solid #8080ff !important;
   }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
   <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Preview Return Pembelian</div>
   </div>
   <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Return Pembelian</li>
      <li><i class="fa fa-angle-right"></i>&nbsp;Preview Return Pembelian&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
               <li class="active"><a href="#alert-tab" data-toggle="tab">Preview Return Pembelian </a></li>
               <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                  <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
            </ul>
            <div id="generalTabContent" class="tab-content responsive" >
               <div id="alert-tab" class="tab-pane fade in active">
                  <div class="row">
                     <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                        <div class="col-md-5 col-sm-6 col-xs-8">
                           <h4>Preview Return Pembelian</h4>
                        </div>
                        <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                           <a href="{{ url('nabila/returnpembelian/index') }}" class="btn">
                           <i class="fa fa-arrow-left"></i>
                           </a>
                        </div>
                     </div>
                     <form method="post" id="form_return_pembelian" name="formReturnPembelian">
                        <input type="hidden" name="spr_id" value="{{ $d_shop_purchase_return->spr_id }}">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                           <div class="col-md-2 col-sm-3 col-xs-12">
                              <label class="tebal">Metode Return</label>
                           </div>
                           <div class="col-md-4 col-sm-9 col-xs-12">
                              <div class="form-group">
                                 <input readonly class="form-control input-sm" id="pilih_metode_return" name="spr_method" value="{{ $d_shop_purchase_return->spr_method }}">
                              </div>
                           </div>
                        </div>
                        <!-- START div#header_form -->
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;" id="header_form">
                           {{ csrf_field() }}
                           <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 10px; padding-top:10px;padding-bottom:20px;" id="appending-form">
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nota Pembelian</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly class="form-control input-sm" name="spr_purchase" value="{{ $d_shop_purchase_return->spo_code }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Kode Return</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="kodeReturn"class="form-control input-sm" value="{{ $d_shop_purchase_return->spr_code  }}">
                                    <input readonly type="hidden" name="metodeReturn" readonly="" class="form-control input-sm">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Tanggal Return</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly id="spr_datecreated" class="form-control input-sm datepicker2 " name="spr_datecreated" type="text" value="{{ $d_shop_purchase_return->spr_datecreated }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Staff</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="namaStaff" readonly="" class="form-control input-sm" id="nama_staff" value="{{ $d_shop_purchase_return->m_name  }}">
                                    <input readonly type="hidden" name="spr_staff" class="form-control input-sm" id="id_staff" value="">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Supplier</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="namaSup" class="form-control input-sm" id="nama_sup" value="{{ $d_shop_purchase_return->s_company  }}">
                                    <input readonly type="hidden" name="idSup" readonly="" class="form-control input-sm" id="id_sup">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Metode Bayar</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="methodBayar" class="form-control input-sm" id="method_bayar" value="{{ $d_shop_purchase_return->spo_method  }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Total Pembelian</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="nilaiTotalGross" class="form-control input-sm right" id="nilai_total_gross" value="{{ $d_shop_purchase_return->spo_total_gross }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Total Diskon</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="nilaiTotalDisc" readonly="" class="form-control input-sm right" id="nilai_total_disc" value="{{ $d_shop_purchase_return->spo_disc_value  }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Pajak</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="nilaiTotalTax" readonly="" class="form-control input-sm right" id="nilai_total_tax" value="{{ ($d_shop_purchase_return->spo_total_gross - $d_shop_purchase_return->spo_disc_value) * ($d_shop_purchase_return->spo_tax_percent / 100 ) }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Total Pembelian (Nett)</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="nilaiTotalNett" readonly="" class="form-control input-sm right" id="nilai_total_nett">
                                    <input readonly type="hidden" name="nilaiTotalReturnRaw" readonly="" class="form-control input-sm" id="nilai_total_return_raw" value="{{ $d_shop_purchase_return->spo_total_net  }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Total Return </label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input type="text" name="nilaiTotalReturn" readonly="" class="form-control input-sm right" id="sprdt_pricetotal" value='{{ $d_shop_purchase_return->spr_pricetotal }}'>
                                 </div>
                                 
                              </div>
                              <div class="table-responsive">
                                    <table class="table tabelan table-bordered" id="tabel_d_shop_purchasereturn_dt">
                                       {{ csrf_field() }}
                                       <thead>
                                          <tr>
                                             <th width="30%">Kode | Barang</th>
                                             <th width="10%">Qty</th>
                                             <th width="10%">Satuan</th>
                                             <th width="15%">Harga</th>
                                             <th width="15%">Total</th>
                                             <th width="10%">Stok</th>
                                          </tr>
                                       </thead>
                                       <tbody id="div_item">
                                       </tbody>
                                    </table>
                                 </div>
                                 
                           </div>
                     </form>
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
@include('Nabila::returnpembelian/js/format_currency')
@include('Nabila::returnpembelian/js/form_functions')
@include('Nabila::returnpembelian/js/form_commander')
<script>
   $(document).ready(function(){
    $('#nilai_total_return_raw').val(
      'Rp ' + accounting.formatMoney( $('#nilai_total_return_raw').val() ,"",0,'.',',') 
    );
    $('#nilai_total_gross').val(
      'Rp ' + accounting.formatMoney( $('#nilai_total_gross').val() ,"",0,'.',',') 
    );
    $('#nilai_total_disc').val(
      'Rp ' + accounting.formatMoney( $('#nilai_total_disc').val() ,"",0,'.',',') 
    );
    $('#nilai_total_tax').val(
      'Rp ' + accounting.formatMoney( $('#nilai_total_return_raw').val() ,"",0,'.',',') 
    );
    tabel_d_shop_purchasereturn_dt = $('#tabel_d_shop_purchasereturn_dt').DataTable({
        'columnDefs': [
               {
                  'targets': [3, 4, 5],
                  'createdCell':  function (td) {
                     $(td).attr('align', 'right'); 
                  }
               }
        ],
        "createdRow": function( row, data, dataIndex ) {
            var sprdt_qtyreturn = $(row).find('[name="sprdt_qtyreturn[]"]');
            if(sprdt_qtyreturn.length > 0) {

              format_currency(sprdt_qtyreturn);
            }
            var remove_btn = $(row).find('.remove_btn');


            sprdt_qtyreturn.next().keyup(function(){
              var tr = $(this).parents('tr');
              var price = tr.find('[name="sprdt_price[]"]').val();
              var qtyreturn = $(this).prev().val();
              var pricetotal = qtyreturn * price;
        var td = tr.find('td');
        $( td[4] ).text(
          get_currency( pricetotal )
        ); 
 
              count_sprdt_pricetotal();
            });
            sprdt_qtyreturn.next().change(function(){
              $(this).trigger('keyup')
            });

            remove_btn.click(function(){
              var tr = $(this).parents('tr');
              tabel_d_shop_purchasereturn_dt.row( tr ).remove().draw();
            });
     }
      });

      tabel_d_shop_purchasereturn_dt.on('draw.dt', count_sprdt_pricetotal);
     var purchasereturn_dt = {!! $d_shop_purchasereturn_dt !!};
     var data;
     if(purchasereturn_dt.length > 0) {
       for(var x = 0;x < purchasereturn_dt.length;x++) {
         data = purchasereturn_dt[x];
   
         var sprdt_item = "<input readonly type='hidden' name='sprdt_item[]' value='" + data.i_id + "'>" + data.i_code + ' - ' + data.i_name;
         var sprdt_qtyreturn = data.sprdt_qtyreturn;
         var s_detname = data.s_detname;
         var sprdt_price = data.sprdt_price ;
         var sprdt_pricetotal = data.sprdt_pricetotal;
         var s_qty = data.s_qty;
   
         sprdt_qty = sprdt_qtyreturn;
         sprdt_price = "<input readonly type='hidden' name='sprdt_price[]' value='" + sprdt_price + "'>Rp " + get_currency(sprdt_price);
         sprdt_pricetotal = get_currency(sprdt_pricetotal);
    
         tabel_d_shop_purchasereturn_dt.row.add(
           [sprdt_item, sprdt_qty, s_detname, sprdt_price, sprdt_pricetotal, s_qty]
         );
   
       }
       tabel_d_shop_purchasereturn_dt.draw();
     }
   });
</script>    
@endsection