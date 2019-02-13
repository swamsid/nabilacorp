<script>
  function randString(angka) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function simpanReturn() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      zindex: 999,
      title: 'Simpan Retur Pembelian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formReturnPembelian']").valid();
          if(IsValid)
          {
            var countRow = $('#div_item tr').length;
            if(countRow >= 1)
            {
              $('#button_save').text('Menyimpan...'); //change button text
              $('#button_save').attr('disabled',true); //set button disable 
              $.ajax({
                url : baseUrl + "/nabila/returnpembelian/insert_d_shop_purchase_return",
                type: "POST",
                dataType: "JSON",
                data: $('#form_return_pembelian').serialize(),
                success: function(response) {

                  $('#button_save').text('Simpan Data'); //change button text
                  $('#button_save').removeAttr('disabled'); //set button disable 
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.status,
                      onClosing: function(instance, toast, closedBy){
                        $('#button_save').text('Simpan Data'); //change button text
                        $('#button_save').attr('disabled',false); //set button enable 
                        window.location.href = baseUrl + "/nabila/returnpembelian/index";
                      }
                    });
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    $('#button_save').text('Simpan Data'); //change button text
                        $('#button_save').attr('disabled',false); //set button enable 
                    iziToast.error({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.status,
                      onClosing: function(instance, toast, closedBy){
                        $('#button_save').text('Simpan Data'); //change button text
                        $('#button_save').attr('disabled',false); //set button enable 
                      }
                    }); 
                  }
                },
                error: function(){
                  $('#button_save').text('Simpan Data'); //change button text
                  $('#button_save').removeAttr('disabled'); //set button disable 
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              });
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                 position: 'center',
                 message: "Mohon isi data pada tabel form !"
              });
            }//end check count form table
          }
          else
          {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            iziToast.warning({
              position: 'center',
              message: "Mohon Lengkapi data form !"
            });
          } //end check valid
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function updateReturn() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      zindex: 999,
      title: 'Update Retur Pembelian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formReturnPembelian']").valid();
          if(IsValid)
          {
            var countRow = $('#div_item tr').length;
            if(countRow >= 1)
            {
              $('#button_save').text('Menyimpan...'); //change button text
              $('#button_save').attr('disabled',true); //set button disable 
              $.ajax({
                url : baseUrl + "/nabila/returnpembelian/update_d_shop_purchase_return",
                type: "POST",
                dataType: "JSON",
                data: $('#form_return_pembelian').serialize(),
                success: function(response) {

                  $('#button_save').text('Simpan Data'); //change button text
                  $('#button_save').removeAttr('disabled'); //set button disable 
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.status,
                      onClosing: function(instance, toast, closedBy){
                        $('#button_save').text('Simpan Data'); //change button text
                        $('#button_save').attr('disabled',false); //set button enable 
                        window.location.href = baseUrl + "/nabila/returnpembelian/index";
                      }
                    });
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.error({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.status,
                      onClosing: function(instance, toast, closedBy){
                        $('#button_save').text('Simpan Data'); //change button text
                        $('#button_save').attr('disabled',false); //set button enable 
                      }
                    }); 
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              });
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                 position: 'center',
                 message: "Mohon isi data pada tabel form !"
              });
            }//end check count form table
          }
          else
          {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            iziToast.warning({
              position: 'center',
              message: "Mohon Lengkapi data form !"
            });
          } //end check valid
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00';
  }

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function convertToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function totalNilaiReturn()
  {
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) 
    {
      if(input.value == '') input.value = 0;
      return input.value;
    });
    //console.log(hasil);
    var total = 0;
    for (var i = hasil.length - 1; i >= 0; i--){

      hasil[i] = convertToAngka(hasil[i]);
      hasil[i] = parseInt(hasil[i]);
      total = total + hasil[i];
    }
      if (isNaN(total)) {
          total=0;
        }
    total = convertToRupiah(total);
    // console.log(total);
    $('[name="nilaiTotalReturn"]').val(total);
  }

  function totalNilaiReturnRaw()
  {
    var inputs = document.getElementsByClassName( 'hargaTotalItemRaw' ),
    hasil  = [].map.call(inputs, function( input ) 
    {
      if(input.value == '') input.value = 0;
      return input.value;
    });
    //console.log(hasil);
    var total = 0;
    for (var i = 0; i < hasil.length; i++){
      total = (parseFloat(total) + parseFloat(hasil[i])).toFixed(2);
      // console.log(total);
    }
      if (isNaN(total)) {
        total = parseFloat(0).toFixed(2);
      }
    $('[name="nilaiTotalReturnRaw"]').val(total);
  }

  function formatAngka(decimal) 
  {
    var angka = parseInt(decimal);
    var fAngka = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++){
      if(i%3 == 0) fAngka += angkarev.substr(i,3)+'.';
    } 
    var hasil = fAngka.split('',fAngka.length-1).reverse().join('');
    return hasil;
  }

  function find_d_shop_purchaseorder_dt() {
      tabel_d_shop_purchasereturn_dt.clear().draw();
      var po_id = $('[name="spr_purchase"]').val();

      $.ajax({
        url : "{{ url('nabila/pembelian/find_d_shop_purchaseorder_dt') }}/" + po_id,
        type: "GET",
        success: function(res) {
          var units = res.d_shop_purchaseorder_dt; 
          if(units.length > 0) {
            var unit;
            var i_id;
            var spodt_qty;
            var spodt_price;
            var spodt_total;
            var remove_btn, subtotal, stock, satuan;

            
              for(x = 0;x < units.length;x++) {
                  unit = units[x];
                  sprdt_item = '<input type="hidden" name="sprdt_item[]" value="' + unit.i_id + '">' + unit.i_id + ' | ' + unit.i_name;
                  sprdt_qtyreturn = '<input type="hidden" name="sprdt_qty[]" value="' + unit.spodt_qty + '"><input type="text" name="sprdt_qtyreturn[]" value="' + unit.spodt_qty + '" style="text-align:right">';
                  sprdt_price = '<input type="hidden" name="sprdt_price[]" value="' + unit.spodt_price + '">Rp ' + accounting.formatMoney(unit.spodt_price, '', 0, '.', 
                    ',');
                  remove_btn = '<button type="button" class="btn btn-danger remove_btn"><i class="fa fa-trash-o"></i></button>';
                  subtotal = unit.spodt_qty * unit.spodt_price;
                  subtotal = 'Rp ' + accounting.formatMoney(subtotal, '', 0, '.', 
                    ',');
                  stock = unit.s_qty;
                  s_name = unit.s_name;
                  tabel_d_shop_purchasereturn_dt.row.add([
                    sprdt_item, sprdt_qtyreturn, s_name, sprdt_price, subtotal, stock, remove_btn
                  ]);
              } 
              tabel_d_shop_purchasereturn_dt.draw()
            

          }
        },
        error: function(){
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!'
          });
        },
        async: false
      });
  }

  function count_sprdt_pricetotal() {
    var grand_total = 0, subtotal, qtyreturn, price;
          var sprdt_qtyreturn = $('[name="sprdt_qtyreturn[]"]');
          if( sprdt_qtyreturn.length > 0 ) {
            var sprdt_price = $('[name="sprdt_price[]"]');
            for(x = 0; x < sprdt_qtyreturn.length;x++) {
              qtyreturn = $( sprdt_qtyreturn[x] ).val();
              price = $( sprdt_price[x] ).val();
              subtotal = qtyreturn * price;
              grand_total += subtotal;
            }
          }
        $('#sprdt_pricetotal').val(
          'Rp. ' + get_currency(grand_total)
        );
  }
</script>