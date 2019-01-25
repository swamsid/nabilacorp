@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Payroll</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Payroll</li>
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
            <li class="active">
              <a href="#alert-tab" data-toggle="tab">Payroll</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-lg-12">
                  <div class="pull-right" style="margin-bottom: 10px;">
                  </div>
                  <div class="table-responsive">
                    <table id="tbl_pay" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th>Nama</th>
                          <th>Jumlah</th>
                          <th>Action</th>
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
        @endsection @section('extra_scripts')
        <script type="text/javascript">

          var extensions = {
            "sFilterInput": "form-control input-sm",
            "sLengthSelect": "form-control input-sm"
          }
          // Used when bJQueryUI is false
          $.extend($.fn.dataTableExt.oStdClasses, extensions);
          // Used when bJQueryUI is true
          $.extend($.fn.dataTableExt.oJUIClasses, extensions)
          $('#tbl_pay').DataTable({
            processing: true,
            // responsive:true, 
            serverSide: true,
            ajax: {
              url: '{{ url("hrd/payroll/datatable-view") }}/{{Request::segment(4)}}',
            },
            columnDefs: [
              {
                targets: 0,
                className: 'center d_id'
              },
            ],
            "columns": [
              { "data": "c_nama" },
              { "data": "gaji" },
              { "data": "action" }
            ],
            "responsive": true,

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
          function bayar(a) {
            var parent = $(a).parents('tr');
            var id = $(parent).find('.d_id').text();
            console.log(id);
            $.ajax({
              type: "GET",
              url: '{{ url("/hrd/payroll/tambah") }}' + '/' + '{{ Request::segment(4) }}'+ '/' + a,
              success: function (data) {
              },
              complete: function (argument) {
                window.location = (this.url)
              },
              error: function () {

              },
              async: false
            });
          }
        </script> @endsection