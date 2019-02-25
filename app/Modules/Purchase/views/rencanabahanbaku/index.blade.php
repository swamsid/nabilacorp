@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete {
    z-index: 2147483647;
  }

  .error {
    border: 1px solid #f00;
  }

  .valid {
    border: 1px solid #8080ff;
  }

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
      <div class="page-title">Rencana Bahan Baku Produksi</div>
    </div>

    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Rencana Bahan Baku Produksi</li>
    </ol>

    <div class="clearfix"></div>
  </div>
  <!--END TITLE & BREADCRUMB PAGE-->
  <div class="page-content fadeInRight">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">
          <div class="col-md-12">
            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
            </div>
          </div>

          <ul id="generalTab" class="nav nav-tabs">
            <li class="active"><a href="#alert-tab" data-toggle="tab">Rencana Bahan Baku Produksi</a></li>
             <li><a href="#note-tab" data-toggle="tab">Relasi Barang Supplier</a>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    @if ($message = Session::has('sukses'))
                    <div class="alert alert-success alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Sukses!</strong> {{ Session::get('sukses') }}
                    </div>
                    @elseif($message = Session::has('gagal'))
                    <div class="alert alert-danger alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Gagal!</strong> {{ Session::get('gagal') }}
                    </div>
                    @endif
                  </div>
                  <div class="col-md-2 col-sm-3 col-xs-12">
                    <label class="tebal">Tanggal SPK</label>
                  </div>

                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <div class="input-daterange input-group">
                        <input id="tanggal1" class="form-control input-sm datepicker1" name="iTanggal1" type="text">
                        <span class="input-group-addon">-</span>
                        <input id="tanggal2" class="input-sm form-control datepicker2" name="iTanggal2" type="text"
                          value="{{ date('d-m-Y') }}">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                    <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="lihatRencanaByTanggal()">
                      <strong>
                        <i class="fa fa-search" aria-hidden="true"></i>
                      </strong>
                    </button>
                    <button class="btn btn-info btn-sm btn-flat refresh-data-history" type="button" onclick="refreshTabel()">
                      <strong>
                        <i class="fa fa-undo" aria-hidden="true"></i>
                      </strong>
                    </button>
                  </div>

                  <div class="table-responsive">
                    <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th>Nama</th>
                          <th>Qty SPK</th>
                          <th>Stok</th>
                          <th>Satuan</th>
                          <th>Kekurangan</th>
                          <th>Rencana PO</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div id="note-tab" class="tab-pane fade">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="row" style="margin-top:-20px;">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <form id="ItemHarga">
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Pilih Supplier :</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="form-control input-sm select2" name="supplier" id="idSupp" onchange="pilihSupplier()" >
                            @foreach ($supplier as $data)
                              <option value="{{ $data->s_id }}">{{ $data->s_company}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="col-md-12 tamma-bg"  style="margin-top: 5px;margin-bottom: 5px;
                        margin-bottom: 40px; padding-bottom:20px;padding-top:20px;">
                          <div class="col-md-12">
                              <label class="control-label tebal" for="">Masukan Kode / Nama</label>
                              <div class="input-group input-group-sm" style="width: 100%;">
                                 <input type="text" class="form-control input-sm" id="cariItem" name="">
                                 <input type="hidden" class="form-control input-sm" id="i_id" name="i_id">
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel-body">
                      <div class="table-responsive">
                        <table class="table tabelan table-hover table-responsive table-bordered" width="100%" cellspacing="0" id="tbl_groupitem">
                          <thead>
                            <tr>
                              <th class="wd-15p">Kode - Nama Item</th>
                              <th class="wd-15p">Aksi</th>
                            </tr>
                          </thead>

                          <tbody>

                          </tbody>


                        </table>
                      </div>
                    </div>
                  </form>
                  </div>

                </div>
                </div>
              </div>
            </div>

            <div id="label-badge-tab" class="tab-pane fade">
              <div class="row">
                <div class="panel-body"></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--END PAGE WRAPPER-->
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    var extensions = {
      "sFilterInput": "form-control input-sm",
      "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
      return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    $('.select2').select2();

    function __debounce(calback, timer){
        window.clearTimeout(windowTimeOut);

        windowTimeOut = window.setTimeout(calback, timer)
    }

    $( "#cariItem" ).autocomplete({
          source: baseUrl+'/purchasing/get-item/autocomplete',
          minLength: 1,
          select: function(event, ui) {
            $('#i_id').val(ui.item.id);
            }
        });


    var date = new Date();
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate() - 30);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format: "dd-mm-yyyy",
      endDate: 'today'
    }).datepicker("setDate", nd);

    $('.datepicker2').datepicker({
      autoclose: true,
      format: "dd-mm-yyyy",
      endDate: 'today'
    }); //datepicker("setDate", "0");

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function () {
      $('tr').remove('.tbl_modal_row');
    });

    $('#tampil_data').on('change', function () {
      lihatRencanaByTanggal();
    });

    lihatRencanaByTanggal();
  }); //end jquery

  function lihatRencanaByTanggal() {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil = $('#tampil_data').val();
    $('#data').dataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + "/purchasing/rencanabahanbaku/get-rencana-bytgl/" + tgl1 + "/" + tgl2,
        type: 'GET'
      },
      "columns": [
        {"data": "i_name", "width": "20%"},
        {"data": "qtyTotal","width": "15%",render: $.fn.dataTable.render.number( '.', '.', 0,),"className" : "dt-body-right"},
        {"data": "stok","width": "15%",render: $.fn.dataTable.render.number( '.', '.', 0,),"className" : "dt-body-right"},
        {"data": "s_name","width": "5%"},
        {"data": "kekurangan","width": "15%",render: $.fn.dataTable.render.number( '.', '.', 0,),"className" : "dt-body-right"},
        {"data": "qtyorderplan","width": "15%",render: $.fn.dataTable.render.number( '.', '.', 0,),"className" : "dt-body-right"},
        {"data": "action",orderable: false,searchable: false,"width": "10%"}
      ],
      "responsive": true,
      "lengthMenu": [
        [-1],
        ["All"]
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

  function proses(id, tgl1, tgl2) {

    $.ajax({
      url: baseUrl + "/purchasing/rencanabahanbaku/proses-purchase-plan",
      data: {
        id: id,
        tgl1: tgl1,
        tgl2: tgl2
      },
      type: "GET",
      dataType: "JSON",
      success: function (data) {},
      complete: function (argument) {
        window.location = (this.url)
      },
      error: function () {},
      async: false
    });
  }

  function gantiStatus(id, isPO) {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      // id: 'question',
      zindex: 999,
      title: 'Ubah Status',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            type: "POST",
            url: baseUrl + "/purchasing/rencanabahanbaku/ubah-status-spk",
            data: {
              id: id,
              isPO: isPO,
              "_token": "{{ csrf_token() }}"
            },
            success: function (response) {
              if (response.status == "sukses") {
                instance.hide({
                  transitionOut: 'fadeOut'
                }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function (instance, toast, closedBy) {
                    refreshTabel();
                  }
                });
              } else {
                instance.hide({
                  transitionOut: 'fadeOut'
                }, toast, 'button');
                iziToast.error({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function (instance, toast, closedBy) {
                    refreshTabel();
                  }
                });
              }
            },
            error: function () {
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({
            transitionOut: 'fadeOut'
          }, toast, 'button');
        }],
      ]
    });
  }

  function randString(angka) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

   function refreshTabel() {
      $('#data').DataTable().ajax.reload();
   }

   pilihSupplier();

   function pilihSupplier(){
     var x = document.getElementById("idSupp").value;
     $('#tbl_groupitem').dataTable().fnDestroy();
     $('#tbl_groupitem').DataTable({
         processing: true,
         // responsive:true,
         serverSide: true,
         ajax: {
             url: baseUrl + '/master/supplier/table/'+x,
         },
         "columns": [
         { "data": "i_name", width: '90%' },
         { "data": "action", width: '10%' },
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
     });
   }

   $('#cariItem').keypress(function(e)
   {
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
         var bahan_baku  = $('#cariItem').val();
         var qty         = $('#i_id').val();
         if(bahan_baku == '' || qty == '')
         {
            toastr.warning('Item Harus di Isi');
            return false;
         }
         else
         {
            tambahItemSupp();
            $('#cariItem').val('');
            $('#i_id').val('');
            return false;
         }

      }
   });

   function tambahItemSupp(){
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
        $('.submit-group').attr('disabled', 'disabled');
        $.ajax({
            url: baseUrl + "/master/supplier/tambahSupp",
            type: 'GET',
            data: $('#ItemHarga').serialize(),
            success: function (response) {
                if (response.status == 'sukses') {
                     pilihSupplier();
                     $('#cariItem').val('');
                     $('#i_id').val('');
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Data Berhasil di Tambah.'
                    });
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Data Gagal Menambah.'
                    });
                    $('.submit-group').removeAttr('disabled', 'disabled');
                }
            }
        })
    }

   function hapus(a) {
        iziToast.show({
          color: 'red',
          title: 'Peringatan',
          message: 'Apakah anda yakin!',
          position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
          progressBarColor: 'rgb(0, 255, 184)',
          buttons: [
            [
              '<button>Ok</button>',
              function (instance, toast) {
                instance.hide({
                  transitionOut: 'fadeOutUp'
                }, toast);
                var idGroup = $('#idGroup').val();
                console.log(idGroup);
                $.ajax({
                     type: "get",
                     url: baseUrl + '/master/supplier/hapus/'+a,
                     data: {idGroup},
                     success: function(response){
                          if (response.status=='sukses') {
                            toastr.info('Data berhasil di hapus.');
                            pilihSupplier();
                          }else{
                            toastr.error('Data gagal di simpan.');
                          }
                        }
                     })
              }
            ],
            [
              '<button>Close</button>',
               function (instance, toast) {
                instance.hide({
                  transitionOut: 'fadeOutUp'
                }, toast);
              }
            ]
          ]
        });

      }
</script>
@endsection()