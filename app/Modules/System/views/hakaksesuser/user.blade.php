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
                              <table class="table tabelan table-hover table-bordered" id="table_user">
                                <thead>
                                  <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Aksi</th>
                                  </tr>
                                </thead>
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
  var user;
  $(document).ready(function(){
    setTimeout(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        user = $("#table_user").DataTable({
            processing: true,
            searching: true,
            paging: false,
            ordering: false,
            "ajax": {
                "url": "{{ url('system/hakaksespengguna/dataUsers') }}",
                "type": "get"
            },
            columns: [
                {data: 'm_name', name: 'm_name'},
                {data: 'm_username', name: 'm_username'},
                {data: 'aksi', name: 'aksi'}
            ],
            responsive: false,
            "language": dataTableLanguage,
        });
    }, 500);
  });

  function akses(id){
    location.href = ('{{ url('system/hakaksespengguna/edit') }}/' + id);
  }

</script>
@endsection()
