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
                           <a href="{{ url('purchasing/returnpembelian/pembelian') }}" class="btn">
                           <i class="fa fa-arrow-left"></i>
                           </a>
                        </div>
                     </div>
                     <form method="post" id="form_return_pembelian" name="formReturnPembelian">
                        <input type="hidden" name="pr_id" value="{{ $d_purchase_return->pr_id }}">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                           <div class="col-md-2 col-sm-3 col-xs-12">
                              <label class="tebal">Metode Return</label>
                           </div>
                           <div class="col-md-4 col-sm-9 col-xs-12">
                              <div class="form-group">
                                 <input readonly class="form-control input-sm" id="pilih_metode_return" name="pr_method" value="{{ $d_purchase_return->pr_method }}">
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
                                    <input readonly class="form-control input-sm" name="pr_purchase" value="{{ $d_purchase_return->pr_purchase }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Kode Return</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="kodeReturn"class="form-control input-sm" value="{{ $d_purchase_return->pr_code  }}">
                                    <input readonly type="hidden" name="metodeReturn" readonly="" class="form-control input-sm">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Tanggal Return</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly id="pr_datecreated" class="form-control input-sm datepicker2 " name="pr_datecreated" type="text" value="{{ $d_purchase_return->pr_datecreated }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Staff</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="namaStaff" readonly="" class="form-control input-sm" id="nama_staff" value="{{ $d_purchase_return->m_name  }}">
                                    <input readonly type="hidden" name="pr_staff" class="form-control input-sm" id="id_staff" value="">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Supplier</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="namaSup" class="form-control input-sm" id="nama_sup" value="{{ $d_purchase_return->s_company  }}">
                                    <input readonly type="hidden" name="idSup" readonly="" class="form-control input-sm" id="id_sup">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Metode Bayar</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="methodBayar" class="form-control input-sm" id="method_bayar" value="{{ $d_purchase_return->po_method  }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Total Pembelian</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="nilaiTotalGross" class="form-control input-sm right" id="nilai_total_gross" value="{{ $d_purchase_return->po_code }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Total Diskon</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="nilaiTotalDisc" readonly="" class="form-control input-sm right" id="nilai_total_disc" value="{{ $d_purchase_return->po_disc_value  }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Pajak</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="nilaiTotalTax" readonly="" class="form-control input-sm right" id="nilai_total_tax" value="{{ $d_purchase_return->po_disc_value  }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Total Pembelian (Nett)</label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input readonly type="text" name="nilaiTotalNett" readonly="" class="form-control input-sm right" id="nilai_total_nett">
                                    <input readonly type="hidden" name="nilaiTotalReturnRaw" readonly="" class="form-control input-sm" id="nilai_total_return_raw" value="{{ $d_purchase_return->total_net  }}">
                                 </div>
                              </div>
                              <div class="col-md-2 col-sm-3 col-xs-12">
                                 <label class="tebal">Nilai Total Return </label>
                              </div>
                              <div class="col-md-4 col-sm-9 col-xs-12">
                                 <div class="form-group">
                                    <input type="text" name="nilaiTotalReturn" readonly="" class="form-control input-sm right" id="prdt_pricetotal" value='{{ $d_purchase_return->pr_pricetotal }}'>
                                 </div>
                                 
                              </div>
                              <div class="table-responsive">
                                    <table class="table tabelan table-bordered" id="tabel_d_purchasereturn_dt">
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
@include('Purchase::returnpembelian/js/format_currency')
@include('Purchase::returnpembelian/js/form_functions')
@include('Purchase::returnpembelian/js/form_commander')
<script>
   $(document).ready(function(){
    tabel_d_purchasereturn_dt = $('#tabel_d_purchasereturn_dt').DataTable({
        'columnDefs': [
               {
                  'targets': [3, 4, 5],
                  'createdCell':  function (td) {
                     $(td).attr('align', 'right'); 
                  }
               }
        ],
        "createdRow": function( row, data, dataIndex ) {
            var prdt_qtyreturn = $(row).find('[name="prdt_qtyreturn[]"]');
            if(prdt_qtyreturn.length > 0) {

              format_currency(prdt_qtyreturn);
            }
            var remove_btn = $(row).find('.remove_btn');


            prdt_qtyreturn.next().keyup(function(){
              var tr = $(this).parents('tr');
              var price = tr.find('[name="prdt_price[]"]').val();
              var qtyreturn = $(this).prev().val();
              var pricetotal = qtyreturn * price;
        var td = tr.find('td');
        $( td[4] ).text(
          get_currency( pricetotal )
        ); 
 
              count_prdt_pricetotal();
            });
            prdt_qtyreturn.next().change(function(){
              $(this).trigger('keyup')
            });

            remove_btn.click(function(){
              var tr = $(this).parents('tr');
              tabel_d_purchasereturn_dt.row( tr ).remove().draw();
            });
     }
      });

      tabel_d_purchasereturn_dt.on('draw.dt', count_prdt_pricetotal);
     var purchasereturn_dt = {!! $d_purchasereturn_dt !!};
     var data;
     if(purchasereturn_dt.length > 0) {
       for(var x = 0;x < purchasereturn_dt.length;x++) {
         data = purchasereturn_dt[x];
   
         var prdt_item = "<input readonly type='hidden' name='prdt_item[]' value='" + data.i_id + "'>" + data.i_code + ' - ' + data.i_name;
         var prdt_qtyreturn = data.prdt_qtyreturn;
         var s_detname = data.s_detname;
         var prdt_price = data.prdt_price ;
         var prdt_pricetotal = data.prdt_pricetotal;
   
         prdt_qty = prdt_qtyreturn;
         prdt_price = "<input readonly type='hidden' name='prdt_price[]' value='" + prdt_price + "'>" + get_currency(prdt_price);
         prdt_pricetotal = get_currency(prdt_pricetotal);
   
         tabel_d_purchasereturn_dt.row.add(
           [prdt_item, prdt_qty, s_detname, prdt_price, prdt_pricetotal, '-']
         );
   
       }
       tabel_d_purchasereturn_dt.draw();
     }
   });
</script>    
@endsection