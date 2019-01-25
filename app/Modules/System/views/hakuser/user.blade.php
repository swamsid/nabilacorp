@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Manajemen User</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Manajemen User</li>
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
                                <li class="active"><a href="#alert-tab" data-toggle="tab">Manajemen User</a></li>
                                <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                                <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">

                                <div id="alert-tab" class="tab-pane fade in active">

                                  <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                      <div align="right">
                                        <a href="{{ url('/system/hakuser/tambah') }}" class="btn btn-box-tool" style="margin-bottom: 10px;"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>
                                      </div>

                                      <div class="table-responsive" >
                                        <table class="table tabelan table-hover table-bordered" id="data">
                                          <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>Nama</th>
                                              <th>Tanggal Lahir</th>
                                              <th>Alamat</th>
                                              <th>Aksi</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($data as $key => $value)
                                              <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$value->m_name}}</td>
                                                <td>{{Carbon\Carbon::parse($value->m_birth_tgl)->format('d/m/Y')}}</td>
                                                <td>{{$value->m_addr}}</td>
                                                <td align="center">
                                                  <button class="btn btn-warning btn-sm" title="Edit" onclick="edit({{$value->m_id}})"><i class="fa fa-pencil"></i></button>
                                                  <button class="btn btn-danger btn-sm" title="Hapus" onclick="hapus({{$value->m_id}})"><i class="fa fa-trash-o"></i></button>
                                                </td>
                                              </tr>
                                            @endforeach
                                          </tbody>
                                        </table>
                                      </div>

                                    </div>
                                  </div>

                                </div><!-- /div alert-tab -->
                 <!-- div note-tab -->
                  <div id="note-tab" class="tab-pane fade">
                    <div class="row">
                      <div class="panel-body">
                        <!-- Isi Content -->we we we
                      </div>
                    </div>
                  </div><!--/div note-tab -->
                  <!-- div label-badge-tab -->
                  <div id="label-badge-tab" class="tab-pane fade">
                    <div class="row">
                      <div class="panel-body">
                        <!-- Isi content -->we
                      </div>
                    </div>
                  </div><!-- /div label-badge-tab -->
                            </div>

            </div>
          </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">
     $(document).ready(function() {
    var extensions = {
         "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    $('#data').dataTable({
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
      });

      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd-mm-yyyy"
      });

      function edit(id){
          window.location.href = baseUrl + '/system/hakuser/edit?id='+id;
      }

      function hapus(id){
        swal({
                title: "Konfirmasi",
                text: "Apakah anda yakin ingin menghapus data ini?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function () {
                swal.close();
                $("#modal-detail").modal('hide');
                setTimeout(function () {
                    $.ajax({
                      type: 'get',
                      data: {id:id},
                      url: baseUrl + '/system/hakuser/hapus',
                      dataType: 'json',
                      timeout: 10000,
                        success: function (response) {
                            if (response.status == 'berhasil') {
                                swal({
                                    title: "Data Dihapus",
                                    text: "Data berhasil dihapus!",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 900
                                });
                                setTimeout(function(){
                                      window.location.reload();
                              }, 850);
                            }
                        }, error: function (x, e) {
                            var message;
                            if (x.status == 0) {
                                message = 'ups !! gagal menghubungi server, harap cek kembali koneksi internet anda';
                            } else if (x.status == 404) {
                                message = 'ups !! Halaman yang diminta tidak dapat ditampilkan.';
                            } else if (x.status == 500) {
                                message = 'ups !! Server sedang mengalami gangguan. harap coba lagi nanti';
                            } else if (e == 'parsererror') {
                                message = 'Error.\nParsing JSON Request failed.';
                            } else if (e == 'timeout') {
                                message = 'Request Time out. Harap coba lagi nanti';
                            } else {
                                message = 'Unknow Error.\n' + x.responseText;
                            }
                            waitingDialog.hide();
                            throwLoadError(message);
                            //formReset("store");
                        }
                    })
                }, 2000);

            });
      }

      </script>
@endsection()
