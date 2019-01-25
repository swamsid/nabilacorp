    
       
//menjadi rupiah
function setQty(evt, nilai)
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
