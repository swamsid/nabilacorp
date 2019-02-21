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
         <div class="page-title">Form Rencana Penjualan</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
         <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li>Rencana Pembelian&nbsp;&nbsp;</li><i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
         <li class="active">Form Rencana Penjualan</li>
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
                              <a href="{{ url('/purcahse-plan/plan-index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>
                           <form id="data">
                              <input type="hidden" name="id_purchaseplan" value="{{ $data_header->p_id }}">
                              <div class="taruh_sini">
                              </div>
                              
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Kode Rencana Pembelian</label>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input type="text" readonly="" value="{{ $data_header->p_code }}" class="form-control input-sm" name="nota">
                                    </div>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Tanggal Rencana Pembelian</label>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <input class="form-control input-sm" type="text" id="date" name="p_date" value="{{date_format($data_header->p_created, 'd-m-Y')}}" >
                                    </div>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Supplier</label>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                       <select class="form-control input-sm select-2" id="cari_sup" name="id_supplier" style="width: 100%;" >
                                          @foreach ($supplier as $data)
                                          @if ($data->s_id == $data_header->p_supplier)
                                          <option  selected="" value="{{ $data->s_id }}"> {{ $data->s_name }}</option>
                                          @else
                                          <option value="{{ $data->s_id }}">{{ $data->s_name }}
                                          </option>
                                          @endif
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label class="tebal">Gudang</label>
                                 </div>
                                 <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="input-group input-group-sm" style="width: 100%;">
                                       <select name="gudang"readonly="" style="pointer-events: none" id="gudang" class="form-control select-2">
                                          @foreach ($gudang as $element)
                                             <option selected="" value="{{ $element->gc_id }}" data-name="{{ $element->gc_gudang }}">{{ $element->c_name }} - {{ $element->gc_gudang }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              {{-- form input trigger --}}
                              <div class="col-md-12 tamma-bg" style="margin-top: 5px;margin-bottom: 5px;margin-bottom: 20px; padding-bottom:20px;padding-top:20px;">
                                 <div class="col-md-3" style="padding: 3px">
                                    <label class="control-label tebal" for="">Masukan Kode / Nama</label>
                                    <div class="input-group input-group-sm" style="width: 100%;">
                                       <input type="text" class="form-control input-sm ui-autocomplete" id="searchitem"
                                       onclick="autoSearchitem()">
                                       <input type="hidden" class="form-control input-sm " name="" id="i_id">
                                    </div>
                                 </div>
                                 <div class="col-md-3" style="padding: 3px">
                                    <label class="control-label tebal">Stok</label>
                                    <div class="input-group input-group-sm" style="width: 100%;">
                                       <input type="text" readonly="" class="form-control input-sm text-right" name="stock" id="stock">
                                    </div>
                                 </div>
                                 <div class="col-md-2" style="padding: 3px">
                                    <label class="control-label tebal">Harga / Satuan Utama</label>
                                    <div class="input-group input-group-sm" style="width: 100%;">
                                       <input type="text" readonly="" class="form-control input-sm text-right" name="price" id="ip_hargaPrev">
                                    </div>
                                 </div>
                                 
                                 <div class="col-md-3" style="padding: 3px">
                                    <label class="control-label tebal">Jumlah</label>
                                    <div class="input-group input-group-sm" style="width: 100%;">
                                       <input type="text" class="form-control input-sm text-right currenc" name="fQty" id="fQty">
                                    </div>
                                 </div>
                                 <div class="col-md-1" style="padding: 3px">
                                    <label class="control-label tebal">Satuan</label>
                                    <div class="input-group input-group-sm" style="width: 100%;">
                                       <div class="drop_here">
                                          <select class="form-control input-sm" id="ip_sat" name="ipSat" style="width: 100%;">
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              
                              <div style="padding-top: 20px;padding-bottom: 20px;">
                                 <div class="table-responsive" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a">
                                    <table id="barang_table" class="table tabelan table-bordered table-striped">
                                       <thead>
                                          <tr>
                                             <th>Kode - Barang</th>
                                             <th>Stok Gudang</th>
                                             <th>Harga / Satuan Utama</th>
                                             <th>Qty</th>
                                             <th>Satuan</th>
                                             <th>Aksi</th>
                                          </tr>
                                       </thead>
                                       <tbody id="div_item">
                                          @for ($i = 0; $i < count($dataItem['data_isi']); $i++)
                                          <tr class="detail{{ $dataItem['data_isi'][$i]['i_id'] }}">
                                             <td width="30%">
                                                <input style="width:100%" type="hidden" class="kode_item kode" name="ppdt_item[]" value='{{ $dataItem['data_isi'][$i]['i_id'] }}''>
                                                <div style="padding-top:6px">{{ $dataItem['data_isi'][$i]['i_code'] }} - {{ $dataItem['data_isi'][$i]['i_name'] }}</div>
                                             </td>
                                             <td width="20%">
                                                <input type="text" class="form-control input-sm text-right" value="{{ $dataItem['data_stok'][$i]->qtyStok }} {{ $dataItem['data_satuan'][$i] }}" readonly>

                                             </td>
                                             <td width="15%">
                                                <input class="form-control input-sm text-right" name="ppdt_prevcost[]" value="{{ $dataItem['data_isi'][$i]['ppdt_prevcost'] }}" readonly>
                                             </td>
                                             <td width="20%">
                                                <input class="form-control input-sm text-right currenc" id="qty-{{ $dataItem['data_isi'][$i]['i_id'] }}" name="ppdt_qty[]" value='{{ $dataItem['data_isi'][$i]['ppdt_qty'] }}'>
                                             </td>
                                             <td width="10%">
                                                <input type="text" class="form-control input-sm" name="" value='{{ $dataItem['data_isi'][$i]['s_name'] }}' readonly>
                                                <input type="hidden" class="form-control input-sm" name="ppdt_satuan[]" value='{{ $dataItem['data_isi'][$i]['ppdt_satuan'] }}' readonly>
                                             </td>
                                             <td width="5%">
                                                <button type="button" class="btn btn-danger btn_remove" id="{{ $dataItem['data_isi'][$i]['i_id'] }}"><i class="fa fa-trash-o"></i></button>
                                             </td>                          
                                          </tr>
                                          @endfor
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                        <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" onclick="simpan()" disabled="">
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
<script type="text/javascript">

$(document).ready(function(){ 
      $('#date').datepicker({
          format:"dd-mm-yyyy",  
          autoclose: true,      
      });    

      $('.select-2').select2();  

      $('.currenc').inputmask("currency", {
         radixPoint: ",",
         groupSeparator: ".",
         digits: 0,
         autoGroup: true,
         prefix: '', //Space after $, this will not truncate the first character.
         rightAlign: false,
         oncleared: function () { self.Value(''); }
      });

      $('#searchitem').focus();

      ////autocomplete
      var gudang = $('#gudang').val();
      var key = 1;
      $("#searchitem").autocomplete({
               source: baseUrl + '/seach-item-purchase/' + gudang,
               minLength: 1,        
               select: function(event, ui) 
               { 
                  $('#searchitem').val(ui.item.label);
                  $('#i_id').val(ui.item.id);   
                  $('#stock').val(ui.item.stok+' '+ui.item.satTxt[0]);   
                  Object.keys(ui.item.sat).forEach(function(){
                         $('#ip_sat').append($('<option>', { 
                           value: ui.item.sat[key-1] +'|'+ ui.item.satTxt[key-1],
                           text : ui.item.satTxt[key-1]
                         }));
                         key++;
                  });   
                  $('#s_price').val(ui.item.satuan); 
                  $('#ip_hargaPrev').val(ui.item.prevCost);       
                  $("#fQty").focus();
               }
         }); 

      $( "#searchitem" ).focus(function() {
         var key = 1;
         var gudang = $('#gudang').val();
         $("#searchitem").autocomplete({
               source: baseUrl + '/seach-item-purchase/' + gudang,
               minLength: 1,        
               select: function(event, ui) 
               { 
                  $('#searchitem').val(ui.item.label);
                  $('#i_id').val(ui.item.id);   
                  $('#stock').val(ui.item.stok+' '+ui.item.satTxt[0]);   
                  Object.keys(ui.item.sat).forEach(function(){
                         $('#ip_sat').append($('<option>', { 
                           value: ui.item.sat[key-1] +'|'+ ui.item.satTxt[key-1],
                           text : ui.item.satTxt[key-1]
                         }));
                         key++;
                  });   
                  $('#s_price').val(ui.item.satuan); 
                  $('#ip_hargaPrev').val(ui.item.prevCost);       
                  $("#fQty").focus();
               }
         }); 
         $('#searchitem').val('');
         $('#i_id').val('');
         $('#stock').val('');
         $('#ip_hargaPrev').val('');
         $("#fQty").val('');
         $('#ip_sat').empty();
      }); 

   });

   function  autoSearchitem()
   {
      $("#searchitem" ).focus(function() {
         var key = 1;
         var gudang = $('#gudang').val();
         $("#searchitem").autocomplete({
               source: baseUrl + '/seach-item-purchase/' + gudang,
               minLength: 1,        
               select: function(event, ui) 
               { 
                  $('#searchitem').val(ui.item.label);
                  $('#i_id').val(ui.item.id);   
                  $('#stock').val(ui.item.stok+' '+ui.item.satTxt[0]);   
                  Object.keys(ui.item.sat).forEach(function(){
                         $('#ip_sat').append($('<option>', { 
                           value: ui.item.sat[key-1] +'|'+ ui.item.satTxt[key-1],
                           text : ui.item.satTxt[key-1]
                         }));
                         key++;
                  });   
                  $('#s_price').val(ui.item.satuan); 
                  $('#ip_hargaPrev').val(ui.item.prevCost);       
                  $("#fQty").focus();
               }
         }); 
         $('#searchitem').val('');
         $('#i_id').val('');
         $('#stock').val('');
         $('#ip_hargaPrev').val('');
         $("#fQty").val('');
         $('#ip_sat').empty();
      }); 
   }

   $('#fQty').keypress(function(e) {   
      var charCode;
      if ((e.which && e.which == 13)) 
      {
          charCode = e.which;
      } 
      else if (window.event) 
      {
          e = window.event;
          charCode = e.keyCode;
      }
      if ((e.which && e.which == 13)) 
      {
         var item = $('#i_id').val();
         var satuan = $('#ip_sat').val();
         var qty = $("#fQty").val();
         if (item == '' || satuan == '' || qty == 0)
         {
            toastr.warning('Data harus lengkap');
            return false;
         }
         setFormDetail();
         $('#searchitem').val('');
         $('#i_id').val('');
         $('#stock').val('');
         $('#ip_hargaPrev').val('');
         $("#fQty").val('');
         $('#ip_sat').empty();
         $('#searchitem').focus();
         return false;
      }
   });   

   // var index             = 0;
   // var tamp              = [];
   function setFormDetail()
   {
      var tamp = [];
      tamp [0] = $('#i_id').val();
      var item = $('#searchitem').val();
      var i_id = $('#i_id').val();
      var stok =  $('#stock').val();
      var harga = $('#ip_hargaPrev').val();
      var qty = $("#fQty").val();
      var satuan = $('#ip_sat').val();
      var hasil=satuan.split('|');
      var s_id = hasil[0];
      var s_name = hasil[1];
      var inputs = document.getElementsByClassName('kode_item'),
                idItem = [].map.call(inputs, function (input) {
                    return input.value;
                });

            var res = tamp.filter(function (n) {
                return !this.has(n)
            }, new Set(idItem));
    
      if ( res.length != 0 )
      {                   
         $('#div_item').append(
         '<tr class="detail'+i_id+'">'
            //item
            +'<td width="30%">'
               +'<input style="width:100%" type="hidden" class="kode_item kode" name="ppdt_item[]" value='+i_id+'>'
               +'<div style="padding-top:6px">'+item+'</div>'
            +'</td>'
            //stock gudang
            +'<td width="20%">'
               +'<input type="text" class="form-control input-sm text-right" value="'+stok+'" readonly>'
            +'</td>'
            //Harga
            +'<td width="15%">'
               +'<input class="form-control input-sm text-right" name="ppdt_prevcost[]" value="'+harga+'" readonly>'
            +'</td>'
            //qty
            +'<td width="20%">'
               +'<input class="form-control input-sm text-right currenc" id="qty-'+i_id+'" name="ppdt_qty[]" value='+qty+'>'
            +'</td>'
            //satuan
            +'<td width="10%">'
               +'<input type="text" class="form-control input-sm" name="" value='+s_name+' readonly>'
               +'<input type="hidden" class="form-control input-sm" name="ppdt_satuan[]" value='+s_id+' readonly>'
            +'</td>'
            //hapus tombol
            +'<td width="5%">'
               +'<button type="button" class="btn btn-danger btn_remove" id="'+i_id+'"><i class="fa fa-trash-o"></i></button>'
            +'</td>'                            
         +'</tr>');

         $('.currenc').inputmask("currency", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 0,
            autoGroup: true,
            prefix: '', //Space after $, this will not truncate the first character.
            rightAlign: false,
            oncleared: function () { self.Value(''); }
         });         
      }
      else
      {                  
         var qtyLama = parseInt($('#qty-'+i_id).val().replace(/\./g, ''));
         qty = parseInt(qty.replace(/\./g, ''));
         var doubleQty = $('#qty-'+i_id).val(qtyLama + qty);        
      }
   }

   $(document).on('click', '.btn_remove', function(a)
   {
      var button_id = $(this).attr('id');
      // var arrayIndex = tamp.findIndex(e => e === button_id);
      // tamp.splice(arrayIndex, 1);
      $('.detail'+button_id).remove();
      $('#searchitem').focus();

      var inputs = document.getElementsByClassName('kode'),
          names = [].map.call(inputs, function (input) {
              return input.value;
          });
      tamp = names;
});


    </script>
@endsection()


