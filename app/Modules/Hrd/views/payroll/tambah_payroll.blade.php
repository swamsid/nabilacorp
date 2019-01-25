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
                  <form method="POST" action="{{ url('hrd/payroll/simpan') }}">
                    {{ csrf_field() }}
                    <table id="" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th>Gaji</th>
                          <th>Jumlah</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($bayaran as $bay){ ?>
                        <tr>
                          <td>
                            {{$bay->nm_gaji}}
                            <input type="hidden" name="c_payroll_id[]" value="{{ Request::segment(4) }}" class="form-control input-sm">
                            <input type="hidden" name="c_pegawai_man_id[]" value="{{ Request::segment(5) }}" class="form-control input-sm">
                          </td>
                          <td>
                            <div>Rp.
                              <span class="pull-right">
                                {{ number_format( $bay->gaji ,2,',','.') }}
                              </span>
                            </div>
                            <input type="hidden" name="c_gaji_man_id[]" value="{{ $bay->c_id }}" class="form-control input-sm">
                            <input type="hidden" name="c_jumlah[]" value="{{ $bay->gaji }}" class="form-control input-sm">
                          </td>
                          <td><?php if($bay->is_harian == "y"){ ?>
                              <input type="number" name="c_keterangan[]" class="form-control input-sm">
                            <?php }else{ ?>
                              <input type="hidden" name="c_keterangan[]" value="1" class="form-control input-sm">
                            <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <table id="" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th>Potongan</th>
                          <th>Jumlah</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($potongan as $pot){ ?>
                        <tr>
                          <td>{{$pot->c_nama}}</td>
                          <td>
                            <input type="hidden" name="c_potongan_id[]" value="{{ $pot->c_id }}" class="form-control input-sm">
                            <input type="number" name="potongan[]" class="form-control input-sm">
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <input type="submit" value="Simpan" class="btn btn-primary btn-block">
                    </div>
                    </form>
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
              url: '{{ url("hrd/payroll/datatable-payroll") }}',
            },
            columnDefs: [
              {
                targets: 0,
                className: 'center d_id'
              },
            ],
            "columns": [
              { "data": "c_code" },
              { "data": "c_tanggal" },
              { "data": "status" },
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
          function view(a) {
            var parent = $(a).parents('tr');
            var id = $(parent).find('.d_id').text();
            console.log(id);
            $.ajax({
              type: "GET",
              url: '{{ url("hrd/payroll/view/") }}' + '/' + a,
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