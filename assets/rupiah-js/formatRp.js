//menghitung total grand dan sub total
function totalPerItem(){
    var totalDisc=0;

    var discountP=0;
    var discountRp=0;

  for (var disc =0; disc < tamp.length; disc++) {
        var a=0;
        var b=0;

        var discPV=0;
        var discRp=0;
        if($('.discPV'+tamp[disc]).val()!=''){            
            discPV=angkaDesimal($('.discPV'+tamp[disc]).val());
        }
        if($('.discRp'+tamp[disc]).val()!=''){

            discRp=angkaDesimal($('.discRp'+tamp[disc]).val());
        }

        totalDisc+=(discPV+discRp);
        discountRp+=discRp;
        discountP+=discPV;
        
  }  

    $('#discountP').val(SetFormRupiah(discountP));
    $('#discountRp').val(SetFormRupiah(discountRp));
    $('#discount').val(SetFormRupiah(totalDisc));
  

         hitungTotal();

}

function hitungPurchaseItem(id){
    if(isNaN($('.fQty'+id).val())){
            return false;
    }

    var fQty=angkaDesimal($('.fQty'+id).val());        
    var harga=angkaDesimal($('.harga'+id).val());
    $('.hargaTotalItem'+id).val(SetFormRupiah(fQty*harga))

    hitungTotalPurchase();
    }

function hitungTotalPurchase(){    

    var total_gross = 0;
    var total_nett  = 0;
    var diskon=0;
    var diskon_val=0;
    var potongan_harga = angkaDesimal($('#potongan_harga').val()); 
    var diskon_harga = $('#diskon_harga').val(); 
    var ppn_harga = $('#ppn_harga').val(); 

    if(isNaN(potongan_harga)) {
        potongan_harga =0;
    } 
    if(isNaN(diskon_harga)) {
        diskon =0;
    } 
    if(isNaN(ppn_harga)) {
        ppn_harga =0;
    } 
      
    var key= 1;
    $(".totalPerItem").each(function() {
    var value = angkaDesimal($(this).val()); 
    // console.log(value + " value ke "+ key);   
    // add only if the value is number
        if(!isNaN(value) && value.length != 0) {
            total_gross += parseFloat(value);
        }    
        key++;
    });

    if(diskon_harga!='' && diskon_harga !='0'){
        diskon=(diskon_harga);
        diskon_val=(diskon_harga/total_gross);
        // console.log(diskon);
        // console.log(diskon_val);
    }  
    var index = 1;
    var hit = 0;    
    $(".totalPerItem").each(function() {
        var value = angkaDesimal($(this).val()); 
        var total_disc = value*diskon_val;
        $('.disc_detail_'+index).val(parseFloat(total_disc).toFixed(2));
        var total_hit = value-parseFloat(total_disc).toFixed(2);
        // console.log(parseFloat(total_disc).toFixed(2) + " value ke "+ index);   
        // console.log(parseFloat(total_hit).toFixed(2) + " value ke "+ index);   
        $('.hargaTotalItem_net_'+index).val(parseFloat(total_hit).toFixed(2));
        index++;
    });
     
    total_nett= total_gross - potongan_harga - diskon;
  
    $('#total_gross').val(SetFormRupiah(total_gross));    
    $('#total_nett').val(SetFormRupiah(total_nett));    
    
  
}




// menhitung total per item id harga * qty
  function hitungTotalPerItem(id){      
    var fQty=angkaDesimal($('.fQty'+id).val());    
  if(isNaN(fQty)){    
    return false;
  }
    var total=0;
    var nilaiTotal=0;
    var nilaiDiscP=0;    
    var nilaiDiscV=0;   
    var update=0;
    var discP=$('.discP'+id).val();
    var discV=$('.discRp'+id).val();        
    var stock=angkaDesimal($('.stock'+id).val());
    var harga=angkaDesimal($('.harga'+id).val());

    if(discP!=''){
        nilaiDiscP=(total*discP)/100;        
    }   
    if(discV!=''){
        nilaiDiscV=angkaDesimal(discV);        
    }   
 

    if(stock<fQty){             

            
                    iziToast.error({
                      position:'topRight',
                      timeout: 2000,
                      title: '',
                      message: "Ma'af, jumlah permintaan melebihi stok gudang.",
                    });

        $('.fQty'+id).val(1);        
        var fQty=angkaDesimal($('.fQty'+id).val());    
        update=(fQty*harga)-nilaiDiscP- nilaiDiscV;        
        $('.totalPerItem'+id).val(SetFormRupiah(update));
        $('.totalPerItemDisc'+id).val(SetFormRupiah(update));        
        return false;
    }





    total = angkaDesimal($('.harga'+id).val()) * angkaDesimal($('.fQty'+id).val()) ;        

    if(discP!=''){
        nilaiDiscP=(total*discP)/100;        
    }   
    if(discV!=''){
        nilaiDiscV=angkaDesimal(discV);        
    }   

    nilaiTotal =total-nilaiDiscP- nilaiDiscV;    
    $('.discPV'+id).val(SetFormRupiah(nilaiDiscP));    
    $('.totalPerItem'+id).val(SetFormRupiah(total));    
    $('.totalPerItemDisc'+id).val(SetFormRupiah(nilaiTotal));    
    hitungTotal();
  }

//hitungTotalPerItem Pesanan
  function hitungTotalPerItemPesanan(id){        
    var total=0;
    var nilaiTotal=0;
    var nilaiDiscP=0;    
    var nilaiDiscV=0;   
    var update=0;    
    var discP=$('.discP'+id).val();
    var discV=$('.discRp'+id).val();
    var fQty=angkaDesimal($('.fQty'+id).val());    
    var stock=angkaDesimal($('.stock'+id).val());
    var harga=angkaDesimal($('.harga'+id).val());

    if(discP!=''){
        nilaiDiscP=(total*discP)/100;        
    }   
    if(discV!=''){
        nilaiDiscV=angkaDesimal(discV);        
    }   
 





    total = angkaDesimal($('.harga'+id).val()) * angkaDesimal($('.fQty'+id).val()) ;        

    if(discP!=''){
        nilaiDiscP=(total*discP)/100;        
    }   
    if(discV!=''){
        nilaiDiscV=angkaDesimal(discV);        
    }   

    nilaiTotal =total-nilaiDiscP- nilaiDiscV;    
    $('.discPV'+id).val(SetFormRupiah(nilaiDiscP));    
    $('.totalPerItem'+id).val(SetFormRupiah(total));    
    $('.totalPerItemDisc'+id).val(SetFormRupiah(nilaiTotal));    
    hitungTotal();
  }


//menghitung total
function hitungTotal(){    
     var s_bulat=0;
      var grandTotal = 0;    
      var s_gross = 0;
      var ongkos=0;
      var totalDisc=0;      
      var discountP=0;
      var discountRp=0;
  for (var disc =0; disc < tamp.length; disc++) {
        var a=0;
        var b=0;

        var discPV=0;
        var discRp=0;
        if($('.discPV'+tamp[disc]).val()!=''){
            discPV=angkaDesimal($('.discPV'+tamp[disc]).val());
        }
        if($('.discRp'+tamp[disc]).val()!=''){
            discRp=angkaDesimal($('.discRp'+tamp[disc]).val());
        }

        totalDisc+=(discPV+discRp);
        discountRp+=discRp;
        discountP+=discPV;
        
  }
   if(discountP!='' || discountP!=0){
    discountP=SetFormRupiah(discountP);
  }
  if(discountRp!='' || discountRp!=0){
    discountRp=SetFormRupiah(discountRp);
  }
  if(totalDisc!='' || totalDisc!=0){
    totalDisc=SetFormRupiah(totalDisc);
  }
   

    $('#discountP').val(discountP);
    $('#discountRp').val(discountRp);
    $('#discount').val(totalDisc);    
    


    $(".totalPerItem").each(function() {
    var value = angkaDesimal($(this).val());    
    // add only if the value is number
    if(!isNaN(value) && value.length != 0) {
        s_gross += parseFloat(value);
    }    
    });

    $(".totalPerItemDisc").each(function() {
    var value = angkaDesimal($(this).val());    
    // add only if the value is number
    if(!isNaN(value) && value.length != 0) {
        grandTotal += parseFloat(value);
    }    
    });

    if($('#s_bulat').val()!='' && !isNaN($('#s_bulat').val())){
        s_bulat=angkaDesimal($('#s_bulat').val());        
    }    

    
    if($('#biaya_kirim').val()!=''){
    ongkos=angkaDesimal($('#biaya_kirim').val());
    $('#vbiaya_kirim').val($('#biaya_kirim').val())
    }    
    

    $('#grand').val(SetFormRupiah(grandTotal));        
    $('#s_gross').val(SetFormRupiah(s_gross));   
    $('#grand_biaya').val(SetFormRupiah(grandTotal+ongkos+s_bulat));       
    $('#akumulasiTotal').val(SetFormRupiah(grandTotal+ongkos+s_bulat));   
    totalPembayaran('q');
}


function totalPulusOngkos(){
    var ongkos=0;
    var grandTotal=0;
    grandTotal=angkaDesimal($('#grand').val());    
    ongkos=angkaDesimal($('#biaya_kirim').val());  
    
    $('#akumulasiTotal').val(SetFormRupiah(grandTotal+ongkos));    
}





//menjadi rupiah
function setRupiah(evt, nilai)
    {
        var uang=$('.' + nilai).val();
        if(uang==0 || uang=='0,00'){   

    return '';
        }else{
            $('.' + nilai).css('border','1px solid #ccc');
        }

         if($('.' + nilai).val()==undefined){            
            return false;
        }

        $minus=0;
        var code =  (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
        var uangDe;
        if (code != 37 && code != 39 && code != 16 && code != 36 && code != 8)
            var uang = $('.' + nilai).val().replace(/[^0-9,-]*/g, '');
        $('.' + nilai).val(uang);
        var hitungKoma = 0;
        var pisah = new Array();
        var chekArray;
        for (o = 0; o < uang.length; o++) {                        
            if ((uang.charAt(0)) == '-' && uang.length>1) {                
                $minus=1;
                uang=uang.replace(/[^0-9,]*/g, '');
                
                
            } 
             
            else if ((uang.charAt(0)) == '-' && uang.length==1) {                                
                uang.replace(/[^0-9,]*/g, '');                
                uang='';
            } 
            if ((uang.charAt(o)) == ',') {
                hitungKoma++;
                if (hitungKoma == 1) {                        
                    uangDe=parseFloat(uang.replace(',', '.')).toFixed(2);
                    uang=uangDe.replace('.', ',');                       
                    chekArray = uang.split(',');                    
                    
                }else if(hitungKoma > 1){
                    toastr.warning('Harap perikasa kembali inputan anda');
                    var $notifyContainer = $('#toast-container').closest('.toast-top-center');
                            if ($notifyContainer) {
                               // align center
                               var windowHeight = $(window).height() - 90;
                               $notifyContainer.css("margin-top", windowHeight / 2);
                            }
                    return false;
                }
            }

        }
        if ($.isArray(chekArray)) {            
            
            var rev = parseInt(chekArray[0], 10).toString().split('').reverse().join('');            
            var rev2 = '';
            for (var l = 0; l < rev.length; l++) {
                rev2 += rev[l];
                if ((l + 1) % 3 === 0 && l !== (rev.length - 1)) {
                    rev2 += '.';
                }
            }
            if (chekArray[1] == '' && $minus==0) {
                $('.' + nilai).val(rev2.split('').reverse().join('') );
            }
            if (chekArray[1] == '' && $minus>0) {
                $('.' + nilai).val('-' + rev2.split('').reverse().join(''));
            }
            if (chekArray[1] != '' && $minus==0) {
                $rp=parseFloat(rev2.split('').reverse().join('') + '.' + chekArray[1]);
                $('.' + nilai).val($rp);
            }
            if (chekArray[1] != '' && $minus>0) {
                 $rp=parseFloat(rev2.split('').reverse().join('') + ',' + chekArray[1]);
                $('.' + nilai).val($rp);
            }
        } else {            
            var rev = parseInt(uang, 10).toString().split('').reverse().join('');
            var rev2 = '';
            for (var u = 0; u < rev.length; u++) {
                rev2 += rev[u];
                if ((u + 1) % 3 === 0 && u !== (rev.length - 1)) {
                    rev2 += '.';
                }
            }
            if($minus==0){
            $('.' + nilai).val(rev2.split('').reverse().join(''));
            }
            if($minus>0){
            $('.' + nilai).val('-' + rev2.split('').reverse().join(''));
            }
            if (uang == '' || uang == '0') {
                $('.' + nilai).val('');
            }
        }
    }

    
    function setAwal(evt, nilai)
    {		
        
        
        if($('.' + nilai).val()==undefined){
            return false;
        }
        var code =  (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
        if (code != 37 || code != 39 || code != 16 || code != 36 || code != 8 )
            var uang = $('.' + nilai).val().replace(/[^0-9,-]*/g, '');
        
        var array = uang.split(',');
        
        if(array[1]=='00'){
            $('.' + nilai).val(array[0]);
        }else{
            $('.' + nilai).val(uang);
        }
        
            
    }    
    function angkaDesimal(angka){  
        
        var r     =angka;
        var regex =r.replace(/[^0-9,-]*/g, '');		        
        return parseFloat(regex.replace(',', '.'));
    }
    function decimalTwo(angka){    
         if($('.'+angka).val()!='' && $('.'+angka).val()!=0 ){
        var dt     =$('.'+angka).val();        
        var regex =dt.replace(/[^0-9,-]*/g, '');		
        var hasil=parseFloat(regex.replace(',', '.')).toFixed(2)
        hasil=hasil.replace('.', ',');
        $('.'+angka).val( hasil);
        }
    }
    

    function rege(evt, data){		
        var hitungKoma=0;        
        var uang=$('.' + data).val();
        
        if(isNaN(uang)){
            return false;

        }
        var code =  (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
        
            for (m = 0; m < uang.length; m++) {
//            if ((uang.charAt(0)) == '-') {                
//                          
//            }    
            if ((uang.charAt(m)) == ',') {
                hitungKoma++;
            }            
            if (hitungKoma ==1 || hitungKoma ==0) {    
					 if(code == 37 || code == 39 || code == 16 || code == 36 && code == 8 
						&& code >= 48 || code <= 57){        
        
						}else{
        
					uang = $('.' + data).val().replace(/[^0-9,-]*/g, '');
                    $('.' + data).val(uang);
					
       
						}
					
					
                }else if (hitungKoma >1) { 
                    $('.'+data).focus();
                    $('.'+data).css('border','1px solid red');                                       
                    toastr.warning('Harap perikasa kembali inputan anda');
                   
                    var $notifyContainer = $('#toast-container').closest('.toast-top-center');
if ($notifyContainer) {
   // align center
   var windowHeight = $(window).height() - 90;
   $notifyContainer.css("margin-top", windowHeight / 2);
}
                    return false;
                     
                }
        }
    }
    
    
    function ubahNilai(evt, nilai){	        
        var hitungKoma=0;
        var uang=$('.' + nilai).val();
        var code =  (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
            for (var e = 0; e < uang.length; e++) {
            if ((uang.charAt(e)) == ',') {
                hitungKoma++;
            }            
                if (hitungKoma ==1 || hitungKoma ==0) {                    
        	 if(code == 37 || code == 39 || code == 16 || code == 36 && code == 8 
						&& code >= 48 || code <= 57){        
        
						}else{        
	            uang = $('.' + nilai).val().replace(/[^0-9,-]*/g, '');
                    $('.' + nilai).val(uang);
		}
					
					
                }else if (hitungKoma >1) {                                        
                    toastr.warning('Harap perikasa kembali inputan anda');
                    var $notifyContainer = $('#toast-container').closest('.toast-top-center');
if ($notifyContainer) {
   // align center
   var windowHeight = $(window).height() - 90;
   $notifyContainer.css("margin-top", windowHeight / 2);
}
                    return false;
                }

        }
    }
    
    
    //SetFormRupiah
    function SetFormRupiah(uang)
    {        

        if(uang==0 || uang=='0,00' || uang==''){
            return 0;
        }

        if (uang) {
            var rev = parseInt(uang, 10).toString().split('').reverse().join('');
            var rev2 = '';
            for (var w = 0; w < rev.length; w++) {
                rev2 += rev[w];
                if ((w+ 1) % 3 === 0 && w !== (rev.length - 1)) {
                    rev2 += '.';
                }
            }
            
            if(uang!='NaN'){                
              return rev2.split('').reverse().join('');    
              
            }
            else if(uang=='NaN'){
               //return 'Rp. 0,00'
               
            }
           
            else if(uang=='undefined'){
                
               return '0'
            }
        } 
       /* else{
            return 'Rp. 0';
        }*/
    }
   
  
       
 function totalPembayaran($nominal){
    var totalPembayaran =0;
    if($('#akumulasiTotal').val()==''){        

        iziToast.error({
          timeout: 1000,
          title: 'Error',
          message: "Ma'af, Grand total + biaya kirim masih kosong",
        });

        return false;
    }
    var akumulasiTotal=angkaDesimal($('#akumulasiTotal').val());
   $(".nominal").each(function() {    
    var value = angkaDesimal($(this).val());    
    // add only if the value is number
    if(!isNaN(value) && value.length != 0) {
        totalPembayaran += parseFloat(value);
    }    
    });
   

   $('#totalBayar').val(SetFormRupiah(totalPembayaran));

   if(totalPembayaran>akumulasiTotal){
        $('#kembalian').val(SetFormRupiah(totalPembayaran-akumulasiTotal));
        $('#kembalian').css('background-color','#f5cec8')
   }else{
    $('#kembalian').val(SetFormRupiah(totalPembayaran-akumulasiTotal));
    $('#kembalian').css('background-color','#eee')
   }
}
 