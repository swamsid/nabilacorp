@extends('main')  
@section('content')
      <!--BEGIN PAGE WRAPPER-->
      <div id="page-wrapper">
          <!--BEGIN TITLE & BREADCRUMB PAGE-->
          <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
              <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                  <div class="page-title">Monitoring Order & Stock</div>
              </div>
              <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                  <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                  <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                  <li class="active">Monitoring Order & Stock</li>
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
                    <li class="active"><a href="#alert-tab" data-toggle="tab">Monitoring Order & Stock</a></li>
                  </ul>
                  <div id="generalTabContent" class="tab-content responsive">   
                    <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row" style="margin-top:-15px;">
                              <!-- Modal Nota-->
                              <div class="modal fade" id="nota" role="dialog">
                                <div class="modal-dialog modal-lg" >
                                    <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header" style="background-color: #e77c38;">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title" style="color: white;">Jumlah Nota</h4>
                                        </div>

                                        <div class="modal-body">
                                          <div class="table-responsive" id="table-nota">

                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-warning " data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              <!-- End Modal -->
                             
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                  <div class="col-md-2 col-sm-4 col-xs-12">
                                    <label class="tebal">Pilih Tampilan :</label>
                                  </div>

                                  <div class="col-md-3 col-sm-8 col-xs-12">
                                    <div class="form-group">
                                      <select class="form-control input-sm" id="fil" onchange="filter()" >
                                        <option value="A">Semua</option>
                                        <option value="O">Hanya Order</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="col-md-7 col-sm-12 col-xs-12" style="margin-bottom: 15px;" align="right">
                                    <a href="#" data-toggle="modal" data-target="#autoModalPlan" class="btn btn-box-tool" id="btn-tambah"><i class="fa fa-plus"></i>&nbsp; Buat Rencana</a>
                                  </div>

                                  <div class="table-responsive">
                                    <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                                     <thead>
                                        <tr>
                                         <th>Kode Item</th>
                                         <th width="25%">Nama Item</th>
                                         <th>No Nota</th>
                                         <th>Jumlah Order</th>
                                         <th>Jumlah Stok</th>
                                         <th>Jumlah Kebutuhan</th>
                                         <th>Jumlah Rencana Produksi</th>
                                         <th>Jumlah Kekuarangan</th>
                                         <th>Aksi</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                                    
                                      </tbody>
                                    </table> 
                                  </div>                                       
                                </div>
                            </div>
                            <!-- Modal Plan-->
                            <div class="modal fade" id="modal" role="dialog">
                              <div class="modal-dialog modal-lg">
                              <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header" style="background-color: #e77c38;">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 id="title-plan" class="modal-title" style="color: white;">Rencana Produksi</h4>
                                    </div>
                                    <form id="form-plan" onsubmit="return false">

                                      <div class="modal-body" id="table-plan">
                                        
                                      </div>
                                               
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                        <button id="btnSimpan" type="submit" class="btn btn-primary" onclick="simpan()">Simpan Data</button>
                                      </div>
                                    </form>
                                  </div>
                              </div>
                            </div>
                            <!-- end modal plan -->
                            {{-- modal auto plan --}}
                            {!! $autoPlan !!}
                            {{-- end modal auto plan --}}
                    </div>
                          <!-- /div alert-tab -->
           <!-- div note-tab -->
                      <div id="note-tab" class="tab-pane fade">
                        <div class="row">
                          <div class="panel-body">
                            <!-- Isi Content -->
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
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">

   var tablex;
   setTimeout(function () {

    table();
   }, 1500);

   function table(){
    /*$('#data').dataTable().fnDestroy();*/
    tablex = $("#data").DataTable({        
      responsive: true,
      "language": dataTableLanguage,
      processing: true,
      /*serverSide: true,*/
      ajax: {
        "url": "{{ url("/produksi/monitoringprogress/tabel") }}",
        "type": "get",
         "data": function(d){
         d._token = "{{ csrf_token() }}";
         d.fil = $('#fil').val();
        }
        
      }
      ,
    "columns": [
        { "data": "pp_item" },
        { "data": "i_name" },
        { "data": "nota" },
        { "data": "jumlahKw" ,"className" : "dt-body-right" },
        { "data": "s_qtyKw" ,"className" : "dt-body-right" },
        { "data": "j_butuhKw" ,"className" : "dt-body-right"},
        { "data": "pp_qtyKw" ,"className" : "dt-body-right"},
        { "data": "j_kurang" ,"className" : "dt-body-right"},
        { "data": "plan" },
    ],
    "order":[2,'desc'],

      'columnDefs': [

      {
        "targets": 4,
        "className": "text-right",
      }
      ],
            //responsive: true,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            
            "rowCallback": function( row, data, index ) {

              /*$node = this.api().row(row).nodes().to$();*/

              if (data['s_status']=='draft') {
                $('td', row).addClass('warning');
              } 
            }   

        });
   }

  $(document).ready(function() {
  var extensions = {
     "sFilterInput": "form-control input-sm",
    "sLengthSelect": "form-control input-sm"
  }
  // Used when bJQueryUI is false
  $.extend($.fn.dataTableExt.oStdClasses, extensions);
  // Used when bJQueryUI is true
  $.extend($.fn.dataTableExt.oJUIClasses, extensions);

  $(document).on('click','.plan',function(){
    var id = $(this).data('id');
    var i_name = $(this).data('name');
      $.ajax({
        url : baseUrl + "/produksi/monitoringprogress/plan/"+id,
        type: 'get',   
        success:function(response){
          $('#table-plan').html(response);
          $("#judul-plan").text(i_name);
        }
      });
    });

  $(document).on('click','.nota',function(){
    var id = $(this).data('id');
      $.ajax({
      url : baseUrl + "/produksi/monitoringprogress/nota/"+id,
      type: 'get',     
        success:function(response){
         $('#table-nota').html(response);
          }
      });
    });

  $('#autoModalPlan').on('shown.bs.modal', function () {
      $("#tableAutoPlan").dataTable().fnDestroy();
      $("#tableAutoPlan").DataTable({        
      responsive: true,
      "language": dataTableLanguage,
      processing: true,
      /*serverSide: true,*/
      ajax: {
        "url": "{{ url("/produksi/monitoringprogress/tabel/autoplan") }}",
        "type": "get",
         "data": function(d){
         d._token = "{{ csrf_token() }}";
         d.fil = $('#fil').val();
        }
        
      }
      ,
    "columns": [
        { "data": "i_name" },
        { "data": "j_butuh" ,"className" : "dt-body-right"},
        { "data": "pp_qty" ,"className" : "dt-body-right"},
        { "data": "j_kurang" ,"className" : "dt-body-right"},
    ],
    "order":[2,'desc'],
            //responsive: true,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            
            "rowCallback": function( row, data, index ) {

              /*$node = this.api().row(row).nodes().to$();*/

              if (data['s_status']=='draft') {
                $('td', row).addClass('warning');
              } 
            }   

        });
    }) 
  

  });

  $(".datepicker").datepicker({
    dateFormat: "yy-mm-dd",
    altFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true
  });

  function filter(){
    var filter=$('#fil').val();  
    tablex.ajax.reload();
  }

  function simpan() {
    $('#btnSimpan').attr('disabled','disabled');
    var form = document.getElementById('form-plan');
    var dataInput = form.getElementsByTagName('input');
    var tabel = $("#table-search input").serialize();
    var pp_item = $('#pp_item').val();
    var rowPlan = $('#rowPlan').val();
    var comp = $('.mem_comp').val();
    var dataSimpan = tabel+'&pp_item='+pp_item+'&rowPlan='+rowPlan+'&mem_comp='+comp;

    for (var i=0; i<dataInput.length ; i++){
    }
    for (var i=7; i<dataInput.length ; i+=2){
      ///validation
      if (dataInput[i].value == '') {
          Command: toastr["warning"]("Kolom Jumlah Rencana tidak boleh kosong ", "Peringatan !")

          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
          $('#btnSimpan').removeAttr('disabled');
          return false;
      }
    }
    for (var i=5; i<dataInput.length ; i+=2){
      if (dataInput[i].value == '') {
          Command: toastr["warning"]("Kolom Tanggal tidak boleh kosong ", "Peringatan !")

          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
          $('#btnSimpan').removeAttr('disabled');
          return false;
      }
    }
    $.ajax({
        url : baseUrl + "/produksi/monitoringprogress/save",
        type: "GET",
        data : dataSimpan,
          success: function(response){
            if (response.status == 'sukses') {
              var table = $('#data').DataTable();
              table.ajax.reload( null, false );
              iziToast.success({timeout: 5000, 
                            position: "topRight",
                            icon: 'fa fa-chrome', 
                            title: '', 
                            message: 'Rencana di tambahkan.'});
              $("#modal").modal("hide");
              $('#btnSimpan').removeAttr('disabled');
            }else{
              iziToast.error({position: "topRight",
                          title: '', 
                          message: 'Rencana gagal di tambahkan.'});
              $('#btnSimpan').removeAttr('disabled');
            }
          },
      });
  }

  function autoPlanSimpan(){
    $.ajax({
        url : baseUrl + "/produksi/monitoringprogress/save/autoplan",
        type: "GET",
        data : $('#formAutoPlan').serialize(),
          success: function(response){
            if (response.status == 'sukses') {
              var table = $('#data').DataTable();
              table.ajax.reload( null, false );
              iziToast.success({timeout: 5000, 
                            position: "topRight",
                            icon: 'fa fa-chrome', 
                            title: '', 
                            message: 'Rencana di tambahkan.'});
              $("#autoModalPlan").modal("hide");
              $('#btnSimpan').removeAttr('disabled');
            }else{
              iziToast.error({position: "topRight",
                          title: '', 
                          message: 'Rencana gagal di tambahkan.'});
              $('#btnSimpan').removeAttr('disabled');
            }
          },
      });
  }

</script>
@endsection()
