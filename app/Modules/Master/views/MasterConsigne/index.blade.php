@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
        <div class="page-title">Master Consigne</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Master Consigne</li>
    </ol>
    <div class="clearfix"></div>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Master Consigne</a></li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row" style="margin-top:-20px;">
                <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 10px;">
                  <a href="{{ url('master/consigne/tambah') }}"><button type="button" class="btn btn-box-tool" title="Tambahkan Data Item"><i class="fa fa-plus" aria-hidden="true">&nbsp;</i>Tambah Data</button></a>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive">
                    <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="table-consigne">
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Nama Consigne</th>
                          <th>Company</th>
                          <th>Alamat</th>
                          <th>No Telp</th>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script>
  $(document).ready(function(){
    var extensions = {
      "sFilterInput": "form-control input-sm",
      "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
  
    $('#table-consigne').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url : baseUrl + "/master/consigne/table",
        type: 'GET'
      },
      "columns" : [
        {"data" : "c_code", "width" : "10%"},
        {"data" : "c_name", "width" : "15%"},
        {"data" : "c_company", "width" : "25%"},
        {"data" : "c_address", "width" : "20%"},
        {"data" : "c_hp", "width" : "15%"},
        {"data" : "aksi", orderable: false, searchable: false, "width" : "10%"}
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
  });

  function ubahStatus(id)
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Ubah Status',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: baseUrl +'/master/consigne/status',
            type: "get",
            dataType: "JSON",
            data: {id:id},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                $('#table-consigne').DataTable().ajax.reload();
                iziToast.success({timeout: 5000,
                                    position: "topRight",
                                    icon: 'fa fa-chrome',
                                    title: '',
                                    message: 'Status brhasil di ganti.'});
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                $('#table-consigne').DataTable().ajax.reload();
                iziToast.error({position: "topRight",
                                  title: '',
                                  message: 'Status gagal di ubah.'});
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
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

  function editConsigne(id)
  {
    $.ajax({
         type: "GET",
         url: baseUrl + '/master/consigne/edit',
         data: {id:id},
         success: function(response){

         },
         complete:function (argument) {
            window.location=(this.url)
         },
         error: function(){
            toastr["error"]("Terjadi Kesalahan", "Error");
         },
         // async: false
      });
  }

</script>
@endsection