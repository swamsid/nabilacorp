@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Order Pembelian</div>
        </div>

        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Order Pembelian</li>
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

              <ul id="generalTab" class="nav nav-tabs ">
                <li class="active"><a href="#index-tab" data-toggle="tab">Order Pembelian</a></li>
                <li><a href="#note-tab" data-toggle="tab" onclick="lihatHistorybyTgl()">History Order Pembelian</a></li>
              </ul>

              <div id="generalTabContent" class="tab-content responsive">
                
                <!-- div index-tab -->  
                {!!$tindex!!}
                <!-- div history-tab -->
                {!!$history!!}                
  
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- modal -->
      <!-- modal detail -->      
      {!!$modal!!}
      <!-- modal edit -->
      {!!$modaledit!!}
      <!-- modal detail peritem -->
      {!!$modaldetail!!}
      <!-- /modal -->
      {!!$modaldetail_show!!}
  </div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  var save_method;
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    //add bootstrap class to datatable
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    var date = new Date();
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate()-30);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    }).datepicker("setDate", nd);

    $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    });//datepicker("setDate", "0");

    $('#tbl-index').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/purcahse-order/data-order",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglOrder", "width" : "10%"},
          {"data" : "po_code", "width" : "10%"},
          {"data" : "m_name", "width" : "10%"},
          {"data" : "s_company", "width" : "13%"},
          {"data" : "po_method", "width" : "5%"},
          {"data" : "hargaTotalNet", "width" : "10%"},
          {"data" : "tglMasuk", "width" : "10%"},
          {"data" : "status", "width" : "7%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "15%"}
        ],
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
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_row');
      $('tr').remove('.tbl_modal_edit_row');
      $('tr').remove('.tbl_modal_detailmsk_row');
      //remove span class in modal detail
      $("#txt_span_status_detail").removeClass();
      $('#txt_span_status_edit').removeClass();
    });

    //event focus on input harga
    $(document).on('focus', '.field_harga',  function(e){
      var harga = convertToAngka($(this).val());
      $(this).val(harga);
    });

    $(document).on('focus', '#potongan_harga',  function(e){
        var potHarga = convertToAngka($(this).val());
        $(this).val(potHarga);
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#diskon_harga',  function(e){
        var discChar = convertToAngka($(this).val());
        $(this).val(discChar);
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#ppn_harga',  function(e){
        var ppnChar = convertToAngka($(this).val());
        $(this).val(ppnChar);
        $('#button_save').attr('disabled', true);
    });

    //event onblur input harga
    $(document).on('blur', '.field_harga',  function(e){
      var getid = $(this).attr("id");
      var harga = $(this).val();
      var qtyOrder = $('#qty_'+getid+'').val();
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qtyOrder * harga);
      //ubah format ke rupiah
      var hargaRp = convertToRupiah($(this).val());
      $(this).val(hargaRp);
      $('#total_'+getid+'').val(valueHargaTotal);
      totalPembelianGross();
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur potongan harga
    $(document).on('blur', '#potongan_harga',  function(e){
      //ubah format ke rupiah
      var potonganRp = convertToRupiah($(this).val());
      $(this).val(potonganRp);
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur diskon
    $(document).on('blur', '#diskon_harga',  function(e){
      //ubah format ke diskon
      var discSimbol = $(this).val();
      $(this).val(discSimbol+'%');
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur ppn
    $(document).on('blur', '#ppn_harga',  function(e){
      //ubah format ke diskon
      var ppnSimbol = $(this).val();
      $(this).val(ppnSimbol+'%');
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    $('#tampil_data').on('change', function() {
      lihatHistorybyTgl();
    })

  });

  function detailOrder(id) 
  {
    $('#modal-confirm-order').modal('show');
    $('#append-modal-detail div').remove();
    $.ajax({
      url : baseUrl + "/purcahse-order/get-data-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        console.log(data)
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_detail').text(data.spanTxt);
        $("#txt_span_status_detail").addClass('label'+' '+data.spanClass);
        $('#lblNoOrder').text(data.header.po_id);
        $('#lblCodeOrder').text(data.header.po_code);
        $('#lblOrderDate').text(data.header.po_date);
        $('#lblStaffOrder').text(data.header.m_name);
        $('#lblSupplierOrder').text(data.header.s_company);
        $('#txt_span_status_order_').text(data.header.po_status)

        $('.drop_here').empty();
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('.drop_here').append(
                          '<tr id="row'+key+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].podt_qty+'</td>'
                          +'<td>'+data.data_isi[key-1].podt_qtyconfirm+'</td>'
                          +'<td>'+data.data_isi[key-1].s_name+'</td>'
                          // +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].i_code)+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].podt_price)+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].podt_total)+'</td>'
                          +'</tr>');

          // $('.drop_here').append(key);
          key++;  
          i = randString(5);
        });

          // $('.drop_here').html('aa');
        
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function lihatHistorybyTgl()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil = $('#tampil_data').val();
    $('#tbl-history').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/purchasing/orderpembelian/get-data-tabel-history/"+tgl1+"/"+tgl2+"/"+tampil,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "d_pcs_code", "width" : "10%"},
        {"data" : "i_name", "width" : "15%"},
        {"data" : "m_sname", "width" : "10%"},
        {"data" : "s_company", "width" : "15%"},
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_pcsdt_qtyconfirm", "width" : "5%"},
        {"data" : "tglTerima", "width" : "10%"},
        {"data" : "qtyTerima", "width" : "5%"},
        {"data" : "status", "width" : "10%"},
        {"data" : "action", "width" : "5%"}
      ],
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
    });
  }

  function detailMasukPeritem(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/orderpembelian/get-penerimaan-peritem/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var dateCreated = data.header[0].d_pcs_date_created;
        var newDateCreated = dateCreated.split("-").reverse().join("-");
        //ambil data ke json->modal
        $('#lblHeadItem').text('( '+data.isi[0].i_code+' '+data.isi[0].i_name+' )');
        $('#lblHeadPo').text(data.header[0].d_pcs_code);
        $('#lblHeadQty').text(data.header[0].d_pcsdt_qty);
        $('#lblHeadTglPo').text(data.header[0].d_pcs_date_created);
        $('#lblHeadSup').text(data.header[0].s_company);
        //loop data
        Object.keys(data.isi).forEach(function(){
          $('#tabel-detail-peritem').append('<tr class="tbl_modal_detailmsk_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.isi[key-1].i_code+' '+data.isi[key-1].i_name+'</td>'
                          +'<td>'+data.isi[key-1].m_sname+'</td>'
                          +'<td>'+data.isi[key-1].d_tbdt_qty+'</td>'
                          +'<td>'+data.isi[key-1].d_tb_code+'</td>'
                          +'<td>'+data.tanggalTerima[key-1]+'</td>'
                          +'</tr>');
          key++;
        });
        $('#modal_detail_peritem').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function editOrder(id) 
  {
    // console.log();
    window.location.href=('get-data-edit/'+id);
  }

  function submitEdit()
  {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      title: 'Ubah Status',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/purchasing/orderpembelian/update-data-order",
            type: "post",
            dataType: "JSON",
            data: $('#form-edit-order').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#btn_update').text('Update'); 
                    $('#btn_update').attr('disabled',false);
                    $('#modal-edit').modal('hide');
                    $('#tbl-index').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'center', 
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#btn_update').text('Update');
                    $('#btn_update').attr('disabled',false);
                    $('#modal-edit').modal('hide');
                    $('#tbl-index').DataTable().ajax.reload();
                  }
                }); 
              }
            },
            error: function(){
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function deleteOrder(idPo)  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus data PO',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/purcahse-order/delete-data-order",
            type: "GET",
            dataType: "JSON",
            data: {idPo:idPo},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#tbl-index').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#tbl-index').DataTable().ajax.reload();
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
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
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

  function convertIntToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) 
      if(i%3 == 0) 
        rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function totalPembelianGross(){
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) {
        if(input.value == '') input.value = 0;
        return input.value;
    });
    console.log(hasil);
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
    $('[name="totalGrossEdit"]').val(total);
  }

  function totalPembelianNett() 
  {
    var totalGross = convertToAngka($('#total_gross').val());
    var potongan = convertToAngka($('#potongan_harga').val());
    var disc = convertDiscToAngka($('#diskon_harga').val());
    var tax = convertDiscToAngka($('#ppn_harga').val());
    var discValue = totalGross * disc / 100;
    //var taxValue = totalGross * tax / 100;
    //hitung total pembelian nett
    var hasilNett = (parseInt(totalGross) - parseInt(potongan + discValue));
    var taxValue = hasilNett * tax / 100;
    var finalValue = parseInt(hasilNett + taxValue);
    // $('#total_nett').val(convertToRupiah(finalValue));
    // var hasilNett = (parseInt(totalGross) - (parseInt(potongan + discValue)) + taxValue);
    $('[name="totalNettEdit"]').val(convertToRupiah(finalValue));
  }

  function convertToRupiah(angka) 
  {
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

  function convertDiscToAngka(disc) {
    return parseInt(disc.replace('%', ''), 10);
  }

  function refreshTabelIndex() 
  {
    $('#tbl-index').DataTable().ajax.reload();
  }

</script>
@endsection()