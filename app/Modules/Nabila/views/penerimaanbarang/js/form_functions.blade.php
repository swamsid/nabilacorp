<script>
  
	// Function untuk meng-insert shop_purchase order
  function count_grandtotal() {
      var qty = $('[name="stbdt_qty[]"]');
      var price = $('[name="stbdt_price[]"]');
      var item_qty, item_price, tax_percent, disc_value, total_net, total_gross = 0;

      for(x = 0;x < qty.length;x++) {
        item_qty = parseInt( $( qty[x] ).val() );
        item_qty = item_qty != '' ? item_qty : 0;
        item_price = parseInt( $( price[x] ).val() );
        item_price = item_price != '' ? item_price : 0;
        total_gross += ( item_qty * item_price );
      }

      tax_percent = $('#stb_tax_percent').val();
      tax_percent = tax_percent != '' ? parseInt(tax_percent) : 0 ;
      tax_value = total_gross * ( tax_percent / 100 );

      disc_value = $('#stb_disc_value').val();
      disc_value = disc_value.replace(/\D/g, '');
      disc_value = disc_value != '' ? parseInt(disc_value) : 0 ;

      total_net = total_gross + tax_value - disc_value;

      $('#stb_total_gross').val(
        'Rp ' + accounting.formatMoney( total_gross, '', '.', ',' )
      );

      $('#stb_total_net').val(
        'Rp ' + accounting.formatMoney( total_net, '', '.', ',' )
      );
  }  

  function insert_d_shop_terima_pembelian() {
    var data = $('#form_shop_terima_pembelian').serialize();
    $.ajax({
      url: "{{ route('insert_d_shop_terima_pembelian') }}",
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function (response) {
        if(response.status == 'sukses') {
          
          iziToast.success({
            position: "center",
            title: '',
            timeout: 1000,
            message: 'Data berhasil disimpan.',
            onClosing : function() {
              location.reload();
            }
          });

        }
        else {
            iziToast.error({
              position: "center",
              title: '',
              timeout: 1000,
              message: 'Terjadi kesalahan.',
              
            });          
        }
      }
    });
  }

  function hapus_detail(obj) {
    var tr = $(obj).parents('tr');
    tabel_d_shop_terima_pembelian_dt.row(tr).remove().draw();
  }

  // Function untuk memperbarui shop_purchase order
  function perbarui_d_shop_terima_pembelian() {
    var data = $('#form_shop_terima_pembelian').serialize();
    $.ajax({
      url: "{{ route('update_d_shop_terima_pembelian') }}",
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function (response) {
        if(response.status == 'sukses') {
          
          iziToast.success({
            position: "center",
            title: '',
            timeout: 1000,
            message: 'Data berhasil diperbarui',
            onClosing : function() {
              location.href = "{{ route('index_shop_penerimaanbarang') }}";
            }
          });

        }
        else {
          iziToast.error({
            position: "center",
            title: '',
            timeout: 1000,
            message: 'Terjadi kesalahan'
          });          
        }
      }
    });
  }

  function find_d_shop_purchaseorder_dt(id) {
    tabel_d_shop_terima_pembelian_dt.clear().draw();
    var url = '{{ url("nabila/penerimaanbarang/find_d_shop_purchaseorder_dt") }}'; 
    url = url + "/" + id;
    $.ajax({
      url: url,
      type: 'GET',
      success: function (response) {
        var unit;
        if(response.d_shop_purchaseorder_dt.length > 0) {
          for(x = 0;x < response.d_shop_purchaseorder_dt.length;x++) {
            unit = response.d_shop_purchaseorder_dt[x];
            stbdt_item = "<input type='hidden' name='stbdt_item[]' value='" + unit.i_id + "'>" + unit.i_code + " - " + unit.i_name; 
            stbdt_qty = "<input type='hidden' value='" + unit.spodt_qty + "'>" + unit.spodt_qty; 
            qty_masuk = unit.qty_masuk;
            stbdt_qtyconfirm = "<input type='number' name='stbdt_qty[]' value='" + unit.spodt_qty + "' class='form-control' style='text-align:right'>";
            stbdt_satuan = "<input type='hidden' name='stbdt_sat[]' value='" + unit.s_id + "'>" + unit.s_name; 
            price = unit.spodt_price;
            price_label = 'Rp ' + accounting.formatMoney(price, '', 0, '.', 
                    ',');  
            stbdt_price = "<input type='hidden' name='stbdt_price[]' value='" + price + "'>" + price_label; 
            subtotal = unit.spodt_qty * unit.spodt_price;
            subtotal = 'Rp ' + accounting.formatMoney(subtotal, '', 0, '.', ',');
            remove_btn = "<button class='btn btn-danger remove_btn' onclick='hapus_detail(this)' type='button'><i class='glyphicon glyphicon-trash'></i></button>";
            s_qty = unit.s_qty;

            tabel_d_shop_terima_pembelian_dt.row.add([
              stbdt_item, stbdt_qty, qty_masuk, stbdt_qtyconfirm, stbdt_satuan, stbdt_price, subtotal, s_qty, remove_btn
            ]);
          }

          tabel_d_shop_terima_pembelian_dt.draw();
        }
      }
    });
  }

  // Function untuk menghitung grand total ketika menambahkan atau mengurangi item
  function totalPerItem() {
    var sd_qty_item = $('[name="sd_qty[]"]');
    var sd_qty, row, sd_price;
    var grand_total = 0;
    if(sd_qty_item.length > 0) {
      for(x = 0;x < sd_qty_item.length;x++) {
        sd_qty = $( sd_qty_item[x] );
        row = sd_qty.parents('tr');
        sd_price = row.find('[name="sd_price[]"]');
        grand_total += (parseInt( sd_qty.val() ) + parseInt( sd_price.val() ));
      }
    }

    $('#grand_biaya').val(grand_total);
  }

  function buttonSimpanPos($status) {

    if ($('#s_id').val() != '' && $status == 'draft') {
      iziToast.error({
        position: 'topRight',
        timeout: 1500,
        title: '',
        message: "Ma'af, data telah di simpan sebagai draft.",
      });
      return false;
    }


    if ($('#proses').is(':visible') == false) {
      if ($('#grand_biaya').val() != '' && $('#grand_biaya').val() != '0') {
        modalShow();
      } else {
        iziToast.error({
          position: 'topRight',
          timeout: 1500,
          title: '',
          message: "Ma'af, Data yang di masukkan belum sempurna.",
        });


      }
    } else if ($('#proses').is(':visible') == true) {
      $chekTotal = angkaDesimal($('#akumulasiTotal').val()) - angkaDesimal($('#totalBayar').val());
      if ($chekTotal <= 0) {
        var textIzi = '';
        if ($('#s_id').val() == '') {
          textIzi = "Apakah anda yakin menyimpan sebagai final?";

        } else if ($('#s_id').val() != '') {
          textIzi = "Apakah anda yakin Mengupdate sebagai final?"
        }
        if ($('#s_id').val() == '') {
          simpanPos('final');
        } else if ($('#s_id').val() != '') {
          perbaruiData();
        }

        /*simpanPos($status);*/
      } else {
        iziToast.error({
          position: 'topRight',
          timeout: 1500,
          title: '',
          message: "Ma'af,.",
        });
      }

    }
  }

  function tambah() {
    $('#penerimaanbarang').tab('show');
    $('.reset-seach').val('');
  }

  function addf2(e) {
    {
      if (e.keyCode == 113) {
        payment();
      }
    }

  }

  function payment() {
    $html = '';
    $html += '<td>' +
      '<input class="minu mx f2 nominal alignAngka nominal' + dataIndex + '" style="width:90%" type="" name="stb_nominal[]"' +
      'id="nominal" onkeyup="hapusPayment(event,this);addf2(event);totalPembayaran(\'nominal' + dataIndex + '\');rege(event,\'nominal' + dataIndex + '\')"' + 'onblur="setRupiah(event,\'nominal' + dataIndex + '\')" onclick="setAwal(event,\'nominal' + dataIndex + '\')"' +
      'autocomplete="off">' +
      '</td>' +
      '<td>' +
      '<button type="button" class="btn btn-sm btn-danger hapus" onclick="btnHapusPayment(this)"  ><i class="fa fa-trash-o">' +
      '</i></button>' +
      '</td>' +
      '</tr>';

    $('.tr_clone').append($html);

    dataIndex++;

    var arrow = {
        left: 37,
        up: 38,
        right: 39,
        down: 40
      },

      ctrl = 17;
    $('.minu').keydown(function (e) {
      if (e.ctrlKey && e.which === arrow.right) {

        var index = $('.minu').index(this) + 1;
        $('.minu').eq(index).focus();

      }
      if (e.ctrlKey && e.which === arrow.left) {
        /*if (e.keyCode == ctrl && arrow.left) {*/
        var index = $('.minu').index(this) - 1;
        $('.minu').eq(index).focus();
      }
      if (e.ctrlKey && e.which === arrow.up) {

        var upd = $(this).attr('class').split(' ')[1];

        var index = $('.' + upd).index(this) - 1;
        $('.' + upd).eq(index).focus();
      }
      if (e.ctrlKey && e.which === arrow.down) {

        var upd = $(this).attr('class').split(' ')[1];

        var index = $('.' + upd).index(this) + 1;
        $('.' + upd).eq(index).focus();

      }
    });


  }


  function nextFocus(e, id) {

  }

  function buttonDisable() {
    if (tamp.length > 0) {
      $('.btn-disabled').removeAttr('disabled');
    } else {
      $('.btn-disabled').attr('disabled', 'disabled');
    }
  }

  function validationForm() {
    // $chekDetail = 0;
    // for (var i = 0; i < tamp.length; i++) {
    //   if ($('.fQty' + tamp[0]).val() == '' || $('.fQty' + tamp[0]).val() == '0') {
    //     $chekDetail++;
    //   }
    // }
    // if ($chekDetail > 0) {
    //   iziToast.error({
    //     position: 'topRight',
    //     timeout: 2000,
    //     title: '',
    //     message: "Maaf, data detail belum sesuai.",
    //   });
    //   $('.btn-disabled').attr('disabled', 'disabled');
    //   $('.fQty' + tamp[0]).focus();
    //   $('.fQty' + tamp[0]).css('border', '2px solid red');
    //   return false;
    // } else {
    //   $('.fQty' + tamp[0]).css('border', 'none');
    //   $('.btn-disabled').removeAttr('disabled');
    //   return true;
    // }
    return true;
  }


  function simpanPos(status = '') {
    $('#totalBayar').removeAttr('disabled');
    $('#kembalian').removeAttr('disabled');
    $('.btn-disabled').attr('disabled', 'disabled');


    var formPos = $('#dataPos').serialize();
    $.ajax({
      url: "{{ url('') }}" + '/penerimaanbarang/pos-toko/create',
      type: 'GET',
      data: formPos + '&status=' + status,
      dataType: 'json',
      success: function (response) {

        if (response.status == 'sukses') {
          $('.tr_clone').html('');
          payment();
          tamp = [];
          hapusSalesDt = [];
          $('#kembalian').attr('disabled', 'disabled');
          $('#totalBayar').attr('disabled', 'disabled');
          tablex.ajax.reload();
          bSalesDetail.html('');
          $('.reset').val('');
          $('#proses').modal('hide');

          iziToast.success({
            position: "center",
            title: '',
            timeout: 1000,
            message: 'Data berhasil disimpan.'
          });


          $('#s_date').val('{{date("d-m-Y")}}');
          $('#s_created_by').val('{{Auth::user()->m_name}}');
          $('#s_date').focus();
          if (response.s_status == 'final') {


            qz.findPrinter("POS-80");
            window['qzDoneFinding'] = function () {
              var p = document.getElementById('printer');
              var printer = qz.getPrinter();
              window['qzDoneFinding'] = null;
            };


            $.ajax({
              url: "{{ url('') }}" + '/penerimaanbarang/pos-toko/printNota/' + response.s_id,
              type: 'get',
              data: formPos + '&status=' + status,
              success: function (response) {

                qz.appendHTML(
                  '<html>' + response + '</html>'
                );
                qz.printHTML();
              }
            })


          }
        } else if (response.status == 'gagal') {
          $('.btn-disabled').removeAttr('disabled');
          $('#kembalian').attr('disabled', 'disabled');
          $('#totalBayar').attr('disabled', 'disabled');

          iziToast.error({
            position: 'topRight',
            timeout: 2000,
            title: '',
            message: response.data,
          });


        }
      }
    });
  }


  function perbaruiData() {
    $('#kembalian').removeAttr('disabled');
    $('#totalBayar').removeAttr('disabled');
    $('#btn-disabled').attr('disabled', 'disabled');

    var formPos = $('#dataPos').serialize();
    $.ajax({
      url: "{{ url('') }}" + '/penerimaanbarang/pos-toko/update',
      type: 'GET',
      data: formPos + '&hapusdt=' + hapusSalesDt,
      dataType: 'json',
      success: function (response) {
        $('.tr_clone').html('');
        payment();
        tamp = [];
        hapusSalesDt = [];
        if (response.status == 'sukses') {
          $('#kembalian').attr('disabled', 'disabled');
          $('#totalBayar').attr('disabled');
          tablex.ajax.reload();
          bSalesDetail.html('');
          $('.reset').val('');
          $('#s_date').val('{{date("d-m-Y")}}');
          $('#s_created_by').val('{{Auth::user()->m_name}}');
          $('#proses').modal('hide');
          $('.perbarui').css('display', 'none');
          /*$('.perbarui').attr('disabled');*/
          $('.final').css('display', '');
          $('.draft').css('display', '');

          if (response.s_status == 'final') {
            var childwindow = window.open("{{ url('') }}" + '/penerimaanbarang/pos-toko/printNota/' + response.s_id, '_blank');
          }

        } else if (response.status == 'gagal') {
          $('.btn-disabled').removeAttr('disabled');
          alert(response.data);
          $('#totalBayar').attr('disabled', 'disabled');
          $('#kembalian').attr('disabled', 'disabled');

        }
      }
    });
  }


  function detail(s_id) {
    var statusPos = $('#s_status').val();
    dataIndex = 1;
    $.ajax({
      url: "{{ url('') }}" + '/penerimaanbarang/pos-toko/' + s_id + '/edit',
      type: 'GET',
      data: {
        "_token": "{{ csrf_token() }}",
        "s_status": statusPos,
      },

      /*dataType: 'json',*/
      success: function (response) {

        $('.perbarui').css('display', '');
        $('.perbarui').removeAttr('disabled');
        $('.final').css('display', 'none');
        $('.draft').css('display', 'none');
        bSalesDetail.html('');
        bSalesDetail.append(response);
        $.ajax({
          url: "{{ url('') }}" + '/paymentmethod/edit/' + s_id + '/a',
          type: 'GET',
          success: function (response) {
            $('.tr_clone').html('');
            $('.tr_clone').append(response.view);
            dataIndex = response.jumlah;
            dataIndex++;


          }
        });


      }

    });

  }

  function batal() {
    bSalesDetail.html('');
    $('.tr_clone').html('');
    payment();
    $('.reset').val('');
    $('#s_date').val('{{date("d-m-Y")}}');
    $('#s_created_by').val('{{Auth::user()->m_name}}');
    tamp = [];
    hapusSalesDt = [];
    $('.perbarui').css('display', 'none');
    /*$('.perbarui').attr('disabled');*/
    $('.final').css('display', '');
    $('.draft').css('display', '');
    dataIndex = 1;

    $('#s_date').focus();
  }
	function count_total() {
		var grandtotal = 0;
		var spdt_qty = $('[name="spdt_qty[]"]');
		if(spdt_qty.length > 0 ) {
			for(x = 0;x < spdt_qty.length;x++) {
				unit_qty = $( spdt_qty[x] ).val();
				unit_qty = unit_qty != '' ? parseInt(unit_qty) : 0;
				grandtotal += unit_qty;
			}
		}

		$('#grandtotal').val(
			get_currency(grandtotal)
		);
	}
</script>