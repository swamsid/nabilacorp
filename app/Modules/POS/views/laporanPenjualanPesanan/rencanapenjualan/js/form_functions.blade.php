<script>
	// Function untuk meng-insert sales plan
  function insert_sales_plan() {
    var data = $('#form_sales_plan').serialize();
    $.ajax({
      url: "{{ url('/penjualan/rencanapenjualan/simpan') }}",
      type: 'GET',
      data: data,
      dataType: 'json',
      success: function (response) {
        if(response.data == 'sukses') {
          
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
      }
    });
  }

  // Function untuk memperbarui sales plan
  function perbarui_sales_plan() {
    var data = $('#form_sales_plan').serialize();
    $.ajax({
      url: "{{ url('/penjualan/rencanapenjualan/perbarui') }}",
      type: 'GET',
      data: data,
      dataType: 'json',
      success: function (response) {
        if(response.data == 'sukses') {
          
          iziToast.success({
            position: "center",
            title: '',
            timeout: 1000,
            message: 'Data berhasil diperbarui',
            onClosing : function() {
              location.href = "{{ url('/penjualan/rencanapenjualan/rencana#list') }}";
            }
          });

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
    $('#penjualan').tab('show');
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
      '<input class="minu mx f2 nominal alignAngka nominal' + dataIndex + '" style="width:90%" type="" name="sp_nominal[]"' +
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
      url: "{{ url('') }}" + '/penjualan/pos-toko/create',
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
              url: "{{ url('') }}" + '/penjualan/pos-toko/printNota/' + response.s_id,
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
      url: "{{ url('') }}" + '/penjualan/pos-toko/update',
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
            var childwindow = window.open("{{ url('') }}" + '/penjualan/pos-toko/printNota/' + response.s_id, '_blank');
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
      url: "{{ url('') }}" + '/penjualan/pos-toko/' + s_id + '/edit',
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