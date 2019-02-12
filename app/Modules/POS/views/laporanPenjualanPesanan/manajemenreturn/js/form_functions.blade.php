<script>
  function counting_subtotal() {
    // Function untuk mentrigger perhitungan subtotal return
    var dsrdt_qty_confirm = $('[name="dsrdt_qty_confirm[]"]');
    if(dsrdt_qty_confirm.length > 0) {
      dsrdt_qty_confirm.each(function(){
        $(this).on('change keyup', function(){
           var tr = $(this).parents('tr');
           var dsrdt_price = tr.find('[name="dsrdt_price_disc[]"]');
           var dsrdt_total = tr.find('[name="dsrdt_total[]"]');
           var price = dsrdt_price.val() != '' ? parseInt(dsrdt_price.val()) : 0;
           var qty = $(this).val() != '' ? parseInt($(this).val()) : 0;
           console.log(price);
           console.log(qty);
           var subtotal = price * qty;
           dsrdt_total.val('Rp. ' + SetFormRupiah(subtotal));

           count_grandtotal();
        })
      });
    }
  }

  function count_grandtotal() {
      // Function untuk mentrigger perhitungan subtotal return
    var dsrdt_qty_confirm = $('[name="dsrdt_qty_confirm[]"]');
    var unit_price, unit_qty_confirm;
    var grandtotal = 0;
    if(dsrdt_qty_confirm.length > 0) {
      var dsrdt_price = $('[name="dsrdt_price_disc[]"]');
      for(x = 0;x < dsrdt_qty_confirm.length;x++) {
          unit_price = $(dsrdt_price[x]).val();
          unit_price = unit_price != '' ? parseInt(unit_price) : 0;
          unit_qty_confirm = $(dsrdt_qty_confirm[x]).val();
          unit_qty_confirm = unit_qty_confirm != '' ? parseInt(unit_qty_confirm) : 0;
          grandtotal += (unit_price * unit_qty_confirm);
      }
    }

    $('#t_return').val(
      'Rp. ' + accounting.formatMoney(grandtotal,"",0,'.',',')
    ); 
  }
	function tambah() {
             var kode = $('#kode').val();
             var nama = $('#detailnama').val();
             var harga = SetFormRupiah($('#harga').val());
             var y = ($('#harga').val());
             var qty = parseInt($('#qty').val());
             var satuan = $('#satuan').val();
             var hasil = parseFloat(qty * y).toFixed(2);
             var x = SetFormRupiah(hasil);
             var b = angkaDesimal(x);
             var stok = $('#s_qty').val();
             var pricevalue = 'pricevalue-' + kode + '';
             var event = 'event';
             var Hapus = '<button type="button" class="btn btn-danger hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button>';
             var index = tamp.indexOf(kode);
   
             if (index == -1) {
                 tableDetail.row.add([
                     nama + '<input type="hidden" name="kode_itemsb[]" class="kode_item kode" value="' + kode + '"><input type="hidden" name="nama_item[]" class="nama_item" value="' + nama + '"> ',
   
                     '<input size="30" style="text-align:right" type="number"  name="dsrdt_qty_confirmsb[]" class="dsrdt_qty_confirm form-control qty-' + kode + '" value="' + qty + '" onkeyup="qtyInput(\'' + stok + '\', \'' + kode + '\')" onchange="qtyInput(\'' + stok + '\', \'' + kode + '\')"> ',
   
                     satuan + '<input type="hidden" name="satuan[]" class="satuan" value="' + satuan + '"> ',
   
                     Hapus
   
                 ]);
                 tableDetail.draw();
   
                 index++;
                 tamp.push(kode);
   
             } else {
   
                 var qtyLawas = parseInt($(".qty-" + kode).val());
                 $(".qty-" + kode).val(qtyLawas + qty);
                 var q = parseInt(qtyLawas + qty);
                 var l = parseFloat(q * y).toFixed(2);
                 ;
                 var k = SetFormRupiah(l);
                 $(".hasil-" + kode).val(k);
             }
   
             $(function () {
                 var values = $("input[name='dsrdt_qty_confirm[]']")
                     .map(function () {
                         return $(this).val();
                     }).get();
             });
         }
   
         function hapus(a) {
             var par = a.parentNode.parentNode;
             tableDetail.row(par).remove().draw(false);
   
             var sum = 0;
             $('.hasil').each(function () {
                 sum += Number($(this).val());
             });
             $('#total').val(sum);
   
             var inputs = document.getElementsByClassName('kode'),
                 names = [].map.call(inputs, function (input) {
                     return input.value;
                 });
             tamp = names;
         }
   
       function setQty() {
           var qty = $('#s_qty').val();
           var input = $('#qty').val();
           qty = parseInt(qty);
           input = parseInt(input);
           if (input > qty) {
               $('#qty').val('');
           }
       }
   
       function qtyInput(stok, kode) {
           input = $('.qty-' + kode).val();
           input = parseInt(input);
           stok = parseInt(stok);
           if (input > stok || input < 1) {
               $('.qty-' + kode).val('1');
               toastr.warning('Barang yang di beli melebihi stok');
           }
        }

        function discpercent(inField, e){
       var a = 0;
       $('input.discpercent:text').each(function(evt){
         var getIndex = a; 
         var getIndex = $('input.discpercent:text').index(inField);
         var dataInput = $('input.discpercent:text:eq('+getIndex+')').val();
         var qty = $('input.qty-item:text:eq('+getIndex+')').val();
         var hargaItem =$('input.harga-item:text:eq('+getIndex+')').val();
         var dPersen =$('input.dPersen-item:text:eq('+getIndex+')').val();
         var retur = $('input.qtyreturn:text:eq('+getIndex+')').val();
         hargaItem = convertToAngka(hargaItem);
         x = hargaItem * (qty - retur);
         // console.log(x);
         if (dPersen >= 100) {
           dPersen = 0;
           $('input.discpercent:text:eq('+getIndex+')').val(0);
         }
         hasil = x * dPersen/100;
         $('input.value-persen:text:eq('+getIndex+')').val(hasil);
         totalHarga = (qty - retur) * hargaItem - hasil;
         if (dPersen == '') {
           $('input.discvalue:text:eq('+getIndex+')').attr("readonly",false);
         }else{
           $('input.discvalue:text:eq('+getIndex+')').attr("readonly",true);
         }
         totalHarga = convertToRupiah(totalHarga);
         $('input.totalHarga:text:eq('+getIndex+')').val(totalHarga);
         // $('input.hasilReturn:text:eq('+getIndex+')').val(0);
         // $('input.qtyreturn:text:eq('+getIndex+')').val(0);
       a++;
       }) 
       autoJumlahNet();
   }
   
   function discvalue(inField, e){
     var a = 0;
       $('input.discvalue:text').each(function(evt){
         var getIndex = a; 
         var getIndex = $('input.discvalue:text').index(inField);
         var dataInput = $('input.discvalue:text:eq('+getIndex+')').val();
         var qty = $('input.qty-item:text:eq('+getIndex+')').val();
         var hargaItem = $('input.harga-item:text:eq('+getIndex+')').val();
         // var dValue = $('input.dsrdt_disc_value:text:eq('+getIndex+')').val();
         var retur = $('input.qtyreturn:text:eq('+getIndex+')').val();
         hargaItem = convertToAngka(hargaItem);
         x = hargaItem * (qty - retur);
         y = (qty - retur) * dataInput;
         var dValue = $('input.dsrdt_disc_value:text:eq('+getIndex+')').val(y);
         if (dValue >= x) {
           dValue = 0;
           $('input.discvalue:text:eq('+getIndex+')').val(0);
         }
         if (dValue == '' || dValue == '0') {
           $('input.discpercent:text:eq('+getIndex+')').attr("readonly",false);
         }else{
           $('input.discpercent:text:eq('+getIndex+')').attr("readonly",true);
         }
         hasil = x - y;
         hasil = convertToRupiah(hasil);
         $('input.totalHarga:text:eq('+getIndex+')').val(hasil);
       a++;
       }) 
       autoJumlahNet();
       autoTotalReturn();
   }
   
   function qtyReturn(inField, e){
     var getIndex = $('input.qtyreturn:text').index(inField);
     $('input.discpercent:text:eq('+getIndex+')').val(0);
     $('input.dValue-item:text:eq('+getIndex+')').val(0);
     $('input.dsrdt_disc_value:text:eq('+getIndex+')').val(0);
     var dataInput = $('input.qtyreturn:text:eq('+getIndex+')').val();
     var qty = $('input.qty-item:text:eq('+getIndex+')').val();
     var totalHarga = $('input.totalHarga:text:eq('+getIndex+')').val();
     totalHarga = convertToAngka(totalHarga);
     var hargaItem = $('input.harga-item:text:eq('+getIndex+')').val();
     hargaItem = convertToAngka(hargaItem);
     var valuePersen = $('input.value-persen:text:eq('+getIndex+')').val();
     var dValue = $('input.dValue-item:text:eq('+getIndex+')').val();
     dValue = convertToAngka(dValue);
     var x = qty - dataInput;
     // alert(dValue);
     if (x < 0 ) {
       $('input.qtyreturn:text:eq('+getIndex+')').val(0);
       $('input.hasilReturn:text:eq('+getIndex+')').val(0);
       var hasilA = $('input.qty-return:text:eq('+getIndex+')').val(qty);
       //discpercent(inField, e)
         var dataInput = $('input.discpercent:text:eq('+getIndex+')').val();
         var dPersen =$('input.dPersen-item:text:eq('+getIndex+')').val();
         x = hargaItem * qty;
         if (dPersen >= 100) {
           dPersen = 0;
           $('input.discpercent:text:eq('+getIndex+')').val(0);
         }
         hasil = x * dPersen/100;
         $('input.value-persen:text:eq('+getIndex+')').val(hasil);
         //end discpercent(inField, e)
       dataInput = $('input.qtyreturn:text:eq('+getIndex+')').val();
         if (isNaN(dValue)) {
           dValue=0;
         }
       hasilC = (qty * hargaItem - hasil - dValue) / qty * dataInput;
       totalAkhir = (qty * hargaItem - hasil - dValue) - hasilC;
       hasilC = convertToRupiah(hasilC);
       totalAkhir = convertToRupiah(totalAkhir);
       $('input.hasilReturn:text:eq('+getIndex+')').val(hasilC);
       $('input.totalHarga:text:eq('+getIndex+')').val(totalAkhir);
     }else if (x == 10) {
       var hasilB = $('input.qty-return:text:eq('+getIndex+')').val(qty);
       //discpercent(inField, e)
         var dataInput = $('input.discpercent:text:eq('+getIndex+')').val();
         var dPersen =$('input.dPersen-item:text:eq('+getIndex+')').val();
         x = hargaItem * qty;
         if (dPersen >= 100) {
           dPersen = 0;
           $('input.discpercent:text:eq('+getIndex+')').val(0);
         }
         hasil = x * dPersen/100;
         $('input.value-persen:text:eq('+getIndex+')').val(hasil);
         //end discpercent(inField, e)
       dataInput = $('input.qtyreturn:text:eq('+getIndex+')').val();
         if (isNaN(dValue)) {
           dValue=0;
         }
       hasilC = (qty * hargaItem - hasil - dValue) / qty * dataInput;
       totalAkhir = (qty * hargaItem - hasil - dValue) - hasilC;
       hasilC = convertToRupiah(hasilC);
       totalAkhir = convertToRupiah(totalAkhir);
       $('input.hasilReturn:text:eq('+getIndex+')').val(hasilC);
       $('input.totalHarga:text:eq('+getIndex+')').val(totalAkhir);
     }else{
       var Return = $('input.qty-return:text:eq('+getIndex+')').val(x);
         //discpercent(inField, e)
         var dataInput = $('input.discpercent:text:eq('+getIndex+')').val();
         var dPersen =$('input.dPersen-item:text:eq('+getIndex+')').val();
         x = hargaItem * qty;
         if (dPersen >= 100) {
           dPersen = 0;
           $('input.discpercent:text:eq('+getIndex+')').val(0);
         }
         hasil = x * dPersen/100;
         $('input.value-persen:text:eq('+getIndex+')').val(hasil);
         //end discpercent(inField, e)
         dataInput = $('input.qtyreturn:text:eq('+getIndex+')').val();
         if (isNaN(dValue)) {
           dValue=0;
         }
       hasilC = (qty * hargaItem - hasil - dValue) / qty * dataInput;
       totalAkhir = (qty * hargaItem - hasil - dValue) - hasilC;
       hasilC = convertToRupiah(hasilC);
       totalAkhir = convertToRupiah(totalAkhir);
       $('input.hasilReturn:text:eq('+getIndex+')').val(hasilC);
       $('input.totalHarga:text:eq('+getIndex+')').val(totalAkhir);
     }
     
     autoTotalReturn(); 
     autoJumlahDiskon();  
     autoJumPercent();
     autoJumValue(); 
   }
   
   function autoJumlahNet(){
       var inputs = document.getElementsByClassName( 'totalNet' ),
       hasil  = [].map.call(inputs, function( input ) {
           return input.value;
       });
       var total = 0;
       for (var i = hasil.length - 1; i >= 0; i--) {
         hasil[i] = convertToAngka(hasil[i]);
         hasil[i] = parseInt(hasil[i]);
         total = total + hasil[i];
       }
       total = convertToRupiah(total);
       $('#s_net').val(total);
       autoTotalGross();
       autoTotalReturn();
   }  
   
   function autoJumlahDiskon(){
     var inputs = document.getElementsByClassName( 'totalPersen' ),
     hasil  = [].map.call(inputs, function( input ) {
       if(input.value == '') input.value = 0;
         return input.value;
     });
     var total = 0;
     for (var i = hasil.length - 1; i >= 0; i--) {
       hasil[i] = convertToAngka(hasil[i]);
       hasil[i] = parseInt(hasil[i]);
       total = total + hasil[i];
       // console.log(total);
     }
     total = convertToRupiah(total);
     $('#total_diskon').val(total);
     autoTotalGross();
     autoTotalReturn();
     autoJumPercent();
     autoJumValue();
   } 
   
   function autoTotalGross(){
       var inputs = document.getElementsByClassName( 'totalGross' ),
       hasil  = [].map.call(inputs, function( input ) {
           return input.value;
       });
       var total = 0;
       for (var i = hasil.length - 1; i >= 0; i--) {
         hasil[i] = convertToAngka(hasil[i]);
         hasil[i] = parseInt(hasil[i]);
         total = total + hasil[i];
       }
       total = convertToRupiah(total);
       $('#s_gross').val(total);
   } 
   
   function autoTotalReturn(){
     var inputs = document.getElementsByClassName( 'hasilReturn' ),
     hasil  = [].map.call(inputs, function( input ) {
         return input.value;
     });
     var total = 0;
     for (var i = hasil.length - 1; i >= 0; i--) {
       hasil[i] = convertToAngka(hasil[i]);
       hasil[i] = parseInt(hasil[i]);
       total = total + hasil[i];
     }
     total = convertToRupiah(total);
     $('#t_return').val(total);
   }
   
   function autoJumPercent(){
     var inputs = document.getElementsByClassName( 'value-persen' ),
     hasil  = [].map.call(inputs, function( input ) {
         return input.value;
     });
     var total = 0;
     for (var i = hasil.length - 1; i >= 0; i--) {
       hasil[i] = convertToAngka(hasil[i]);
       hasil[i] = parseInt(hasil[i]);
       total = total + hasil[i];
     }
     total = convertToRupiah(total);
     $('#total_percent').val(total);
   }
   
   function autoJumValue(){
     var inputs = document.getElementsByClassName( 'dsrdt_disc_value' ),
     hasil  = [].map.call(inputs, function( input ) {
         return input.value;
     });
     var total = 0;
     for (var i = hasil.length - 1; i >= 0; i--) {
       hasil[i] = convertToAngka(hasil[i]);
       hasil[i] = parseInt(hasil[i]);
       total = total + hasil[i];
     }
     total = convertToRupiah(total);
     $('#total_value').val(total);
   }
   
   function convertToRupiah(angka) {
     var rupiah = '';        
     var angkarev = angka.toString().split('').reverse().join('');
       for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
       var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
       return hasil+',00'; 
   }
   
   function convertToAngka(rupiah){
     return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
   }

   function simpanReturn(){
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
         $('.button_save').attr('disabled', 'disabled');
         var a = $('#form_return_pembelian').serialize();
         var metode = $('#pilih_metode_return').val();
         $.ajax({
             url: baseUrl + "/penjualan/manajemenreturn/store/" + metode,
             type: 'GET',
             data: a,
             success: function (response) {
                 if (response.status == 'sukses') {
                     iziToast.success({
                         timeout: 5000,
                         position: "topRight",
                         icon: 'fa fa-chrome',
                         title: '',
                         message: 'Data Return Tersimpan.'
                     });
                     window.location.href = baseUrl + "/penjualan/manajemenreturn/r_penjualan";
                     var inputs = document.getElementById('kode'),
                         names = [].map.call(inputs, function (input) {
                             return input.value;
                         });
                     tamp = names;
                 } else {
                     iziToast.error({
                         position: "topRight",
                         title: '',
                         message: 'Terjadi kesalahan.'
                     });
                     $('.button_save').removeAttr('disabled', 'disabled');
                 }
             }
         })
   }
</script>