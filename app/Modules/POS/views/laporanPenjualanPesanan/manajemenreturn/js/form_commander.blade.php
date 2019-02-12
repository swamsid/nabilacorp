<script type="text/javascript">
   $(document).ready(function() {
     //fix to issue select2 on modal when opening in firefox
     $.fn.modal.Constructor.prototype.enforceFocus = function() {};
   
     var extensions = {
         "sFilterInput": "form-control input-sm",
         "sLengthSelect": "form-control input-sm"
     }
     // Used when bJQueryUI is false
     $.extend($.fn.dataTableExt.oStdClasses, extensions);
     // Used when bJQueryUI is true
     $.extend($.fn.dataTableExt.oJUIClasses, extensions);
   
     $('.datepicker').datepicker({
       format: "mm-yyyy",
       viewMode: "months",
       minViewMode: "months"
     });
   
     //autofill
     $('#pilih_metode_return').change(function() {
       //remove child div inside appending-form before appending
       var template;
       $('#appending-form div').remove();
       var method = $(this).val();
       var methodTxt = $(this).text();
       if (method == "")  {
           //alert("Mohon untuk Memilih salah satu dari metode return pembelian")
           $('#appending-form div').remove();
       }
       else if(method == "TB")
       {
         //remove child div inside appending-form before appending
         template = '{!! $tb_template !!}';

         $('#appending-form div').remove();
         $('#appending-form').append(template);
       }
       else if(method == "PN")
       {

         template = '{!! $pn_template !!}'; 
         //remove child div inside appending-form before appending
         $('#appending-form div').remove();
         $('#appending-form').append(template);
       }

       //select2
       $( "#cari_nota_sales" ).select2({
         placeholder: "Pilih Nota Penjualan...",
         ajax: {
           url: baseUrl + '/penjualan/manajemenreturn/carinota',
           dataType: 'json',
           data: function (params) {
             return {
                 q: $.trim(params.term)
             };
           },
           processResults: function (data) {
               if(data.length > 0) {
                  for(x in data) {
                    data[x]['id'] = data[x]['s_id'];
                    data[x]['text'] = data[x]['s_note'];
                  }
               }
               return {
                   results: data
               };
           },
           cache: true
         }, 
       });
   
       //datepicker
       $('.datepicker2').datepicker({
         autoclose: true,
         format:"dd-mm-yyyy",
         endDate: 'today'
       });
       //event onchange select option
       $('#cari_nota_sales').change(function() {
         var e=$('#tabel-return-sales').dataTable().fnDestroy();                
         var id = $('#cari_nota_sales').val();
         var metode = $('#pilih_metode_return').val();
         $.ajax({
           url : baseUrl + "/penjualan/manajemenreturn/get-data/"+id,
           type: "GET",
           dataType: "JSON",
           success: function(response){
             var c_name =  response.s_nama_cus;            
             var c_address = response.s_alamat_cus;
             $('#dsr_customer').val(c_name);
             $('#dsr_alamat_customer').val(c_address);
             if (response.s_alamat_cus == null) {
               c_address = '';              
             }
             $('#c_name').val( c_name +'. '+ c_address);
               var s_gross = parseInt(response.s_gross);
               s_gross = convertToRupiah(s_gross);
             $('#s_gross').val(s_gross); 
               var persen = parseInt(response.s_disc_percent);
               var value = (response.s_disc_value);
               value = parseFloat(value);
               var total_diskon = persen + value;
               total_diskon = convertToRupiah(total_diskon);      
             $('#total_diskon').val(total_diskon);
               var s_net = parseInt(response.s_net);
               s_net = convertToRupiah(s_net);
             $('#s_net').val(s_net);            
               var s_disc_value = parseInt(response.s_disc_value);
               s_disc_value = convertToRupiah(s_disc_value);
             $('#total_value').val(s_disc_value);
               var s_disc_percent = parseInt(response.s_disc_percent);
               s_disc_percent = convertToRupiah(s_disc_percent);
             $('#total_percent').val(s_disc_percent);
             $('#typeSales').val(response.s_channel);
   
   
          $.ajax({
               url : baseUrl + "/penjualan/manajemenreturn/tabelpnota/"+id+'/'+metode,          
           type    : 'GET',                     
           success : function(response){    
             $('#dataDt').append(response);
             counting_subtotal();
             count_grandtotal();
   
           }
         });
           /*  var tableReturn = $('#tabel-return-sales').DataTable({              
               "scrollY": 500,
               "scrollX": true,
               "paging":  false,
               "autoWidth": false,
               ajax: {
                   url : baseUrl + "/penjualan/manajemenreturn/tabelpnota/"+id+'/'+metode,
               },
               columns: [
               {data: 'i_name', name: 'i_name'},
               {data: 'dsrdt_qty', name: 'dsrdt_qty'},              
               {data: 's_name', name: 's_name'},              
               {data: 'dsrdt_price', name: 'dsrdt_price'},
               {data: 'dsrdt_disc_percent', name: 'dsrdt_disc_percent', orderable: false},
               {data: 'dsrdt_disc_value', name: 'dsrdt_disc_value', orderable: false},              
               {data: 'dsrdt_total', name: 'dsrdt_total', orderable: false},
               {data: 'description', name: 'description'},
               ],
               "responsive":true,
                 "pageLength": 10,
               "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
               "language": {
                   "searchPlaceholder": "Cari Data",
                   "emptyTable": "Tidak ada data",
                   "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                   "sSearch": '<i class="fa fa-search"></i>',
                   "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                   "infoEmpty": "",
                   "paginate": {
                           "previous": "Sebelumnya",
                           "next": "Selanjutnya",
                  }
                 }
             });*/
           },
         });
       });
   
       $("#namaitem").focus(function () {
         var type = $('#typeSales').val();
             var key = 1;
             $("#namaitem").autocomplete({
                 source: baseUrl + '/penjualan/manajemenreturn/setname/' + type,
                 minLength: 1,
                 select: function (event, ui) {
                     $('#harga').val(ui.item.harga);
                     $('#kode').val(ui.item.kode);
                     $('#detailnama').val(ui.item.nama);
                     $('#namaitem').val(ui.item.label);
                     $('#satuan').val(ui.item.satuan);
                     if (ui.item.s_qty == null) {
                         $('#s_qty').val('0');
                     } else {
                         $('#s_qty').val(ui.item.s_qty);
                     }
                     $('#qty').val(ui.item.qty);
                     $('#i-type').val(ui.item.i_type);
                     $('#qty').val('');
                     $("input[name='qty']").focus();
                 }
             });
             $("#s_qty").val('');
             $("#qty").val('');
             $("#namaitem").val('');
         });
   
       // tableDetail = $('#detail-penjualan').DataTable();
   
         $('#qty').keypress(function (e) {
             var charCode;
             if ((e.which && e.which == 13)) {
                 charCode = e.which;
             } else if (window.event) {
                 e = window.event;
                 charCode = e.keyCode;
             }
             if ((e.which && e.which == 13)) {
                 var isi = $('#qty').val();
                 var jumlah = $('#detailnama').val();
                 var stok = $('#s_qty').val();
                 if (isi == '' || jumlah == '' || stok == '') {
                     toastr.warning('Isi nama item dan jumlah');
                     return false;
                 }
                 var kode = $('#kode').val();
                 tambah();
                 qtyInput(stok, kode);
                 $("#s_qty").val('');
                 $("#qty").val('');
                 $("#namaitem").val('');
                 $("input[name='item']").focus();
                 return false;
             }
         });
   
     });
     
   });
   
   
         var index = 0;
         var tamp = [];
         
   
   
   //event focus on input harga
   $(document).on('focus', '.field_harga',  function(e){
       var harga = convertToAngka($(this).val());
       if (isNaN(harga)) {
         harga = 0;
       }
       if (harga == 0) {
         harga = 0;
       }
       $(this).val(harga);
   });
   
   //event onblur input harga
   $(document).on('blur', '.field_harga',  function(e){
     //ubah format ke rupiah
     var hargaRp = convertToRupiah($(this).val());
     $(this).val(hargaRp);
   });
   
   
   
</script>