@extends('main')
@section('extra_styles')
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

  @media (min-width: 992px){
    .cari-filter{
      height: 125px;
      padding-left: 50px;
    }
    .cari-filter button{
      margin-top: 86px;
    }
  }
</style>
@endsection
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
        <div class="page-title">Recruitment</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Recruitment</li>
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
  
                
              <ul id="generalTab" class="nav nav-tabs">
                <li class="active"><a href="#index-tab" data-toggle="tab">Recruitment</a></li>
                <li><a href="#diterima-tab" data-toggle="tab" onclick="cariDataDiterima()">Daftar Pelamar Diterima</a></li>
                {{-- <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> --}}
              </ul>
              <div id="generalTabContent" class="tab-content responsive">
                <!-- tab index -->
                  {!!$index!!}
                <!-- tab lolos final -->
                  {!!$tabRekrut!!}
                <!-- modal process peg baru -->
                  {!!$diTerima!!}
              </div>
            </div>
        </div>

    </div>
  </div>
</div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
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

    var date = new Date();
    var newdate = new Date(date);
    // newdate.setDate(newdate.getDate()-30);
    newdate.setDate(newdate.getDate()-30);
    var nd = new Date(newdate);

    $('.datepicker').datepicker({
      format: "mm",
      viewMode: "months",
      minViewMode: "months"
    });

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    }).datepicker("setDate", nd);

    $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy"
    }).datepicker("setDate", "0");

    $(".modal").on("hidden.bs.modal", function(){
      $('#tr_shift').empty();
    });

    cariDataIndex();
  });//end jquery

  function cariDataIndex()
  {
    var tgl1 = $('#head_tgl1').val();
    var tgl2 = $('#head_tgl2').val();
    var grade = $('#head_grade').val();
    var status = $('#head_status').val();
    $('#tbl-index').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/hrd/recruitment/get-data-hrd",
        type: 'GET',
        data: {tgl1:tgl1, tgl2:tgl2, grade:grade, status:status}
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : "tglBuat", "width" : "5%"},
        {"data" : "p_name", "width" : "15%"},
        {"data" : "p_tlp", "width" : "10%"},
        {"data" : "p_email", "width" : "10%"},
        {"data" : "p_education", "width" : "10%"},
        {"data" : "status", "width" : "10%"},
        {"data" : "statusdt", "width" : "15%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "20%"}
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

  function cariDataDiterima()
  {
    var tgl1 = $('#head_tgl3').val();
    var tgl2 = $('#head_tgl4').val();
    var grade = $('#head_grade2').val();
    $('#tbl-diterima').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/hrd/recruitment/get-data-hrd-diterima",
        type: 'GET',
        data: {tgl1:tgl1, tgl2:tgl2, grade:grade}
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : "tglBuat", "width" : "5%"},
        {"data" : "p_name", "width" : "15%"},
        {"data" : "p_tlp", "width" : "10%"},
        {"data" : "p_email", "width" : "10%"},
        {"data" : "p_education", "width" : "10%"},
        {"data" : "status", "width" : "10%"},
        {"data" : "statusdt", "width" : "15%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "20%"}
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

  function prosesPegBaru(id, p_empset) 
  {
    $.ajax({
      url : baseUrl + "/hrd/recruitment/get-data-set-pegawai/"+id+"/"+p_empset,
      type: "GET",
      dataType: "JSON",
      success: function(response)
      {
        var key = 0;
        var date = response.data2['tgl_masuk'];
        var tglbaru = date.split("-").reverse().join("-");
        $('#tr_tgl').val(tglbaru);
        $('#tr_nama').val(response.data2['nama']);
        $('#tr_idlamar').val(response.data2['idpelamar']);
        $('#tr_idpegman').val(response.d_pegman.c_id);
        $('#tr_hariawal').val(response.data2['hari_awal']);
        $('#tr_hariakhir').val(response.data2['hari_akhir']);
        $('#tr_divisi').val(response.data[0].c_divisi);
        $('#tr_divisiid').val(response.data2['id_divisi']);
        $('#tr_posisi').val(response.data[0].c_posisi);
        $('#tr_posisiid').val(response.data2['id_jabatan']);
        // console.log(response.shift[0]);
        Object.keys(response.data2['shift']).forEach(function(){
          $('#tr_shift').append($('<option>', { 
            value: response.data2['shift'][key].c_id,
            text : response.data2['shift'][key].c_name+' | '+response.data2['shift'][key].c_start+' - '+response.data2['shift'][key].c_end,
          }));
          key++;
        });
        $('#tr_shift').val(response.data2['data_shift']);
        $('#diterima').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function simpanPegawaiBaru() 
  {
    $.ajax({
      type: "POST",
      url : baseUrl + "/hrd/recruitment/simpan-pegawai-baru",
      data: $('#form-peg-baru').serialize(),
      success: function(response)
      {
        if(response.status == "sukses")
        {
          iziToast.success({
            position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            title: 'Pemberitahuan',
            message: response.pesan,
            onClosing: function(instance, toast, closedBy){
               $('#diterima').modal('hide');
               refreshTabelDiterima();
            }
          });
        }
        else
        {
          iziToast.error({
            position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            title: 'Pemberitahuan',
            message: "Data Gagal disimpan !",
            onClosing: function(instance, toast, closedBy){
               $('#diterima').modal('hide');
               refreshTabelDiterima();
            }
          });
        }              
      },
      error: function()
      {
        iziToast.error({
          position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
          title: 'Pemberitahuan',
          message: "Data gagal disimpan !",
          onClosing: function(instance, toast, closedBy){
            $('#test_presentasi').modal('hide');
            location.reload();
          }
        });
      },
      async: false
    }); 
  }

  function deleteDataPelamar(idpelamar) 
  {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      title: 'Hapus data',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/hrd/recruitment/delete-data-pelamar",
            type: "POST",
            dataType: "JSON",
            data: {idpelamar:idpelamar, "_token": "{{ csrf_token() }}"},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'topRight',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    refreshTabelIndex();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'topRight',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    refreshTabelIndex();
                  }
                });
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              iziToast.error({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            }
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function refreshTabelIndex() {
    $('#tbl-index').DataTable().ajax.reload();
  }

  function refreshTabelDiterima() {
    $('#tbl-diterima').DataTable().ajax.reload();
  }
</script>
@endsection()