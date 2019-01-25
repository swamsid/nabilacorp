@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
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
      <div class="page-title">Barang Digunakan</div>
    </div>
    
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Barang Digunakan</li>
    </ol>
    
    <div class="clearfix"></div>
  </div>
  
  <div class="page-content">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">
          <div class="col-md-12">
            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;"></div>
          </div>

          <ul id="generalTab" class="nav nav-tabs">
            <li class="active"><a href="#index-tab" data-toggle="tab">Barang Digunakan</a></li>
            <li><a href="#history-tab" data-toggle="tab" onclick="lihatHistoryByTgl()">History Pemakaian Barang</a></li>
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            {!! $tabIndex !!}
            {!! $tabHistory !!}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
    <!--modal Pemakaian Barang-->
    {!! $modal !!}
    {!! $modalDetail !!}
    {!! $modalEdit !!}
  <!-- /modal -->
</div>
<!--END PAGE WRAPPER-->
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
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

    //select2
    $( "#head_gudang" ).select2();

    $('#head_gudang').change(function(event) {
      clearInput();
      $('#ip_barang').focus();
    });

    //autocomplete w/parameters
    $( "#ip_barang" ).focus(function() {
      var key = 1;
      $('#btn_simpan').attr('disabled', true);
      $("#ip_barang").autocomplete({
        source: function(request, response) {
          $.ajax({
            url: baseUrl + "/inventory/b_digunakan/autocomplete-barang",
            dataType: "JSON",
            data: {
              term : request.term,
              id_gudang : $('#head_gudang').val()
            },
            success: function(data) {
              response(data);
            }
          });
        },
        select: function(event, ui) {
          $('#ip_item').val(ui.item.id);
          $('#ip_barang').val(ui.item.label);
          $('#ip_scomp').val(ui.item.s_comp);
          $('#ip_spos').val(ui.item.s_pos);
          $('#ip_qtyStok').val(ui.item.stok+' '+ui.item.satTxt[0]);
          Object.keys(ui.item.sat).forEach(function(){
            $('#ip_sat').append($('<option>', { 
              value: ui.item.sat[key-1],
              text : ui.item.satTxt[key-1]
            }));
            key++;
          });
          $("input[name='ipQtyReq']").focus();
        },
        minLength: 1,
        delay: 300
      });
      clearInput();
    });

    $('#ip_barang').blur(function(event) {
      $('#btn_simpan').attr('disabled', false);
    });

    $(document).on('click', '.btn_remove', function(){
      nomor--;
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
    });

    //validasi
    $("#form-pakai-barang").validate({
      rules:{
        headGudang: "required",
        headTglPakai: "required",
        headPeminta: "required",
        headKeperluan: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      //remove append tr
      $('tr').remove('.tbl_form_row');
      $('tr').remove('.tbl_modal_detail_row');
      $('tr').remove('.tbl_modal_edit_row');
      //reset all input txt field
      $('#form-pakai-barang')[0].reset();
      //empty select2 field
      $('#head_gudang').empty();
      //set datepicker to today 
      $('.datepicker2').datepicker('setDate', 'today');
      //remove class all jquery validation error
      $('.form-group').find('.error').removeClass('error');
      $('.form-group').removeClass('has-valid has-error');
    });

    $('#head_gudang').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectNota').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectNota').addClass('has-error').removeClass('has-valid');
      }
    });

    $('#tampil_data').change(function() {
      lihatHistoryByTgl();
    });

    //load fungsi
    lihatPemakaianByTanggal();

  });//end jquery

  var nomor = 1;
  function addItemRow() 
  {
    var i = randString(5);
    var ambilSatuanId = $("#ip_sat option:selected").val();
    var ambilSatuanTxt = $("#ip_sat option:selected").text();
    $('#ip_sat').empty();
    var ambilIdBarang = $('#ip_item').val();
    var ambilBarang = $('#ip_barang').val();
    var scomp = $('#ip_scomp').val();
    var spos = $('#ip_spos').val();
    var ambilQty = $('#ip_qtyreq').val();
    var ambilStok = $('#ip_qtyStok').val();
    var ambilKet = $('#ip_keterangan').val();
    if (ambilIdBarang == "" || ambilBarang == "" || ambilQty == "" || ambilSatuanId == "" || scomp == "" || spos == "") 
    {
      iziToast.warning({
        position: 'center',
        title: 'Pemberitahuan',
        message: "Terdapat kolom yang kosong, dimohon cek lagi !"
      });
      clearInput();
      $('#ip_barang').focus();

    } 
    else
    {
      $('#div_item').append(
        '<tr class="tbl_form_row" id="row'+i+'">'
          +'<td style="text-align:center">'+nomor+'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpBarang[]" value="'+ambilBarang+'" id="field_ip_barang" class="form-control" required readonly>'
            +'<input type="hidden" name="fieldIpItem[]" value="'+ambilIdBarang+'" id="field_ip_item" class="form-control">'
            +'<input type="hidden" name="fieldIpSpos[]" value="'+spos+'" id="field_ip_spos" class="form-control">'
            +'<input type="hidden" name="fieldIpScomp[]" value="'+scomp+'" id="field_ip_scomp" class="form-control">'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpQty[]" value="'+ambilQty+'" id="field_ip_qty" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpSatTxt[]" value="'+ambilSatuanTxt+'" id="field_ip_sat_txt" class="form-control" required readonly>'
            +'<input type="hidden" name="fieldIpSatId[]" value="'+ambilSatuanId+'" id="field_ip_sat_id" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpStok[]" value="'+ambilStok+'" id="field_ip_stok" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpKet[]" value="'+ambilKet+'" id="field_ip_ket" class="form-control" readonly>'
          +'</td>'
          +'<td>'
            +'<button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>'
          +'</td>'
        +'</tr>');
      i = randString(5);
      nomor++;
      //kosongkan field setelah append row
      clearInput();
      // totalPembelian();
    }
  }

  function submitPakai() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Simpan pemakaian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formPakaiBarang']").valid();
          if(IsValid)
          {
            var countRow = $('#div_item tr').length;
            if(countRow > 0)
            {
              $('#divSelectNota').removeClass('has-error');
              $('#btn_simpan').text('Saving...');
              $('#btn_simpan').attr('disabled',true);
              $.ajax({
                url : baseUrl + "/inventory/b_digunakan/simpan-data-pakai",
                type: "POST",
                dataType: "JSON",
                data: $('#form-pakai-barang').serialize(),
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
                        $('#btn_simpan').text('Submit'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        $('#modal_pakai_barang').modal('hide');
                        $('#tbl-daftar').DataTable().ajax.reload();
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
                        $('#btn_simpan').text('Submit'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        $('#modal_pakai_barang').modal('hide');
                        $('#tbl-daftar').DataTable().ajax.reload();
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
                message: "Mohon maaf, form pada tabel dilarang kosong !"
              });
            }//end check table form
          }
          else
          {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            iziToast.warning({
              position: 'center',
              message: "Mohon Lengkapi data form !",
              onClosing: function(instance, toast, closedBy){
                $('#divSelectNota').addClass('has-error');
              }
            });
          } //end check valid
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function lihatPemakaianByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var comp = $('.mem_comp').val();
    $('#tbl-daftar').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/inventory/b_digunakan/get-pemakaian-by-tgl/"+tgl1+"/"+tgl2+"/"+comp,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_pb_code", "width" : "10%"},
        {"data" : "gc_gudang", "width" : "15%"},
        {"data" : "d_pb_peminta", "width" : "10%"},
        {"data" : "d_pb_keperluan", "width" : "15%"},
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
  }

  function lihatHistoryByTgl()
  {
    var tgl1 = $('#tanggal3').val();
    var tgl2 = $('#tanggal4').val();
    var tampil = $('#tampil_data').val();
    $('#tbl-history').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/inventory/b_digunakan/get-history-by-tgl/"+tgl1+"/"+tgl2+"/"+tampil,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglPakai", "width" : "10%"},
        {"data" : "d_pb_code", "width" : "10%"},
        {"data" : "i_name", "width" : "15%"},
        {"data" : "m_sname", "width" : "5%"},
        {"data" : "qty_pakai", "width" : "10%"},
        {"data" : "d_pb_peminta", "width" : "15%"},
        {"data" : "d_pb_keperluan", "width" : "20%"},
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

  function detailPemakaian(id) 
  {
    $.ajax({
      url : baseUrl + "/inventory/b_digunakan/get-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        $('#lblGudang').text(data.header[0].cg_cabang);
        $('#lblKodePakai').text(data.header[0].d_pb_code);
        $('#lblTglPakai').text(data.header2.tgl_pakai);
        $('#lblStaff').text(data.header[0].m_name);
        $('#lblPeminta').text(data.header[0].d_pb_peminta);
        $('#lblKeperluan').text(data.header[0].d_pb_keperluan);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-detail').append('<tr class="tbl_modal_detail_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].qty_pakai+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+data.stok[key-1]+' '+data.txtSat1[key-1].m_sname+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pbdt_keterangan+'</td>'
                          +'</tr>');
          key++;
        });
        $('#apdsfs').html('<a href="'+ baseUrl +'/inventory/b_digunakan/print/'+ id +'" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>'+
        '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
        $('#modal_detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function editPemakaian(id) 
  {
    $.ajax({
      url : baseUrl + "/inventory/b_digunakan/get-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#id_pakai_edit').val(data.header[0].d_pb_id);
        $('#id_staff_edit').val(data.staff.id);
        $('#code_pakai_edit').val(data.header[0].d_pb_code);
        $('#lblGudangEdit').text(data.header[0].cg_cabang);
        $('#lblKodePakaiEdit').text(data.header[0].d_pb_code);
        $('#lblTglPakaiEdit').text(data.header2.tgl_pakai);
        $('#lblStaffEdit').text(data.staff.nama);
        $('#lblPemintaEdit').text(data.header[0].d_pb_peminta);
        $('#lblKeperluanEdit').text(data.header[0].d_pb_keperluan);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-edit').append(
            '<tr class="tbl_modal_edit_row" id="row'+i+'">'
              +'<td style="text-align:center">'+key+'</td>'
              +'<td>'
                +'<input type="text" name="fieldEditBarang[]" value="'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'" id="field_edit_barang" class="form-control" required readonly>'
                +'<input type="hidden" name="fieldEditItem[]" value="'+data.data_isi[key-1].d_pbdt_item+'" id="field_edit_item" class="form-control">'
                +'<input type="hidden" name="fieldEditIdDet[]" value="'+data.data_isi[key-1].d_pbdt_id+'" id="field_edit_id_det" class="form-control">'
                +'<input type="hidden" name="fieldEditSpos[]" value="'+data.header[0].cg_id+'" id="field_edit_spos" class="form-control">'
                +'<input type="hidden" name="fieldEditScomp[]" value="'+data.header[0].cg_id+'" id="field_edit_scomp" class="form-control">'
              +'</td>'
              +'<td>'
                +'<input type="text" name="fieldEditQty[]" value="'+data.data_isi[key-1].qty_pakai+'" id="field_edit_qty" class="form-control">'
                +'<input type="hidden" name="fieldEditQtyLalu[]" value="'+data.data_isi[key-1].qty_pakai+'" id="field_edit_qty_lalu" class="form-control">'
              +'</td>'
              +'<td>'
                +'<input type="text" name="fieldEditSatTxt[]" value="'+data.data_isi[key-1].m_sname+'" id="field_edit_sat_txt" class="form-control" readonly>'
                +'<input type="hidden" name="fieldEditSatId[]" value="'+data.data_isi[key-1].d_pbdt_sat+'" id="field_edit_sat_id" class="form-control" readonly>'
                +'<input type="hidden" name="fieldHargaSat[]" value="'+data.data_isi[key-1].harga_sat+'" id="field_edit_harga_sat" class="form-control" readonly>'
              +'</td>'
              +'<td>'
                +'<input type="text" name="fieldEditStok[]" value="'+data.stok[key-1]+' '+data.txtSat1[key-1].m_sname+'" id="field_edit_stok" class="form-control" readonly>'
              +'</td>'
              +'<td>'
                +'<input type="text" name="fieldEditKet[]" value="'+data.data_isi[key-1].d_pbdt_keterangan+'" id="field_edit_ket" class="form-control">'
              +'</td>'
            +'</tr>');
          i = randString(5);
          key++;
        });
        $('#modal-edit').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function submitEdit()
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Update data Pemakaian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#btn_update').text('Updating...'); //change button text
          $('#btn_update').attr('disabled',true); //set button disable 
          $.ajax({
            url : baseUrl + "/inventory/b_digunakan/update-data-pakai",
            type: "POST",
            dataType: "JSON",
            data: $('#form-edit-pakai').serialize(),
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
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tbl-daftar').DataTable().ajax.reload();
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
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tbl-daftar').DataTable().ajax.reload();
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

  function deletePemakaian(id)
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus Data Pemakaian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/inventory/b_digunakan/delete-data-pakai",
            type: "POST",
            dataType: "JSON",
            data: {id:id, "_token": "{{ csrf_token() }}"},
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
                    $('#tbl-daftar').DataTable().ajax.reload();
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
                    $('#tbl-daftar').DataTable().ajax.reload();
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

  function clearInput() 
  {
    $('#ip_sat').empty();
    $('#ip_item').val("");
    $('#ip_barang').val("");
    $('#ip_scomp').val("");
    $('#ip_spos').val("");
    $('#ip_qtyreq').val("");
    $('#ip_qtyStok').val("");
    $('#ip_keterangan').val("");
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

  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00';
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function refreshTabelIndex()
  {
    $('#tbl-daftar').DataTable().ajax.reload(); 
  }

  function refreshTabelHistory()
  {
    $('#tbl-history').DataTable().ajax.reload(); 
  }
  
</script>
@endsection