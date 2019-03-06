@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Master Data Barang</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Master Data Barang</li>
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
                                <li class="active"><a href="#alert-tab" data-toggle="tab">Master Data Barang</a></li>
                                <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                                <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">

                                <div id="alert-tab" class="tab-pane fade in active">

                                  <div class="row" style="margin-top:-15px;">


                                  <div align="right" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">

                                    <a href="{{ url('master/item/tambah') }}">
                                    <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                                     <i class="fa fa-plus" aria-hidden="true">
                                         &nbsp;
                                     </i>Tambah Data
                                    </button></a>

                                  </div>

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                          <table  class="table table-stripped tabelan table-bordered table-hover dt-responsive data-table tableListToko"  width="100%" cellspacing="0" id="dataBarang">
                            <thead>
                                <tr>
                                <th class="wd-15p" width="3%">No.</th>
                                  <th class="wd-15p" width="5%">Kode</th>
                                  <th class="wd-15p" width="24%">Nama Barang</th>
                                  <th class="wd-15p" width="5%">Satuan</th>
                                  <th width="10%">Harga HPP</th>
                                  <th width="10%">Harga Jual</th>
                                  <th class="wd-15p" width="10%">Kelompok </th>
                                  <th class="wd-15p" width="10%">Status </th>
                                  <th class="wd-15p" width="10%">Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                
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

        </div>
      </div>
    </div>

@endsection
@section("extra_scripts")
    @include('Master::databarang/js/format_currency')
    <script type="text/javascript">

var tablex;
setTimeout(function () {
        table();

    tablex.on('draw.dt', function () {
            var info = tablex.page.info();
            tablex.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
        });
    });

      }, 1500);

function table(){
    $('#dataBarang').dataTable().fnDestroy();
    tablex = $("#dataBarang").DataTable({        
            "language": dataTableLanguage,
            processing: true,
            serverSide: true,
            dom : '<l<"#i_status_control.dataTables_length">f<rt>ip>',
            ajax: {
              "url": "{{ url("master/item/data-barang") }}",
              "type": "get",
              "data" : function(request) {
                request['i_active'] = $('#i_active').val();
                return request;
              }             
            },
            columns: [
              {data: 'i_code', name: 'i_code'}, 
              {data: 'i_code', name: 'i_code'}, 
              {data: 'i_name', name: 'i_name'},
              {data: 's_name', name: 's_name'},            
              {
                data: null, 
                name: 'i_hpp',
                render : function(res) {
                  return 'Rp ' + get_currency(res.i_hpp);
                }
              },      
              {
                data: null, 
                name: 'is_price1',
                render : function(res) {
                  return 'Rp ' + get_currency(res.i_price);
                }
              },      
              {data: 'g_name', name: 'g_name'},            
              {
                data: null, 
                render: function(res) {
                  var answer, classname;
                  if(res.i_active == 'Y') {
                    answer = 'Aktif';
                    classname = 'label-success';
                  }
                  else {
                    answer = "Tidak aktif";
                    classname = "label-danger";
                  }

                  var outp = "<label class='label " + classname + "'>" + answer + "</label>"
                  return outp;
                }
              },            
              {data: 'action', name: 'action'},            
            ],             

            'columnDefs': [
               {
                  'targets': [4, 5],
                  'createdCell':  function (td) {
                     $(td).attr('align', 'right'); 
                  }
               },
               {
                  'targets': [7, 8],
                  'className' : 'text-center'
               },
            ],
            responsive: false,
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
             
           
    });

    var i_status_control = "<select id='i_active' name='i_active' class='form-control input-sm' style='width:5cm'><option value=''>Tampilkan : Semua</option><option value='Y'>Tampilkan : Data Aktif</option><option value='N'>Tampilkan : Data Non-Aktif</option></select>"
    $('#i_status_control').html(i_status_control);
    $('#i_status_control').css({
      marginLeft : '3mm',
      paddingLeft : '3mm',
      borderLeft : '1px solid #8d8d8d',
      width : '5cm'
    })

    $('#i_active').change(function() {
          tablex.ajax.reload();
    });
  }     
                                  
                                      
                                    
                                



    function edit(id){
      window.location.href = baseUrl + '/master/item/edit/'+id;
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
                    url: baseUrl + '/master/item/hapus',
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
                                    tablex.ajax.reload();
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
