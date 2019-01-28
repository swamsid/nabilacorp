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
                              <a href="{{ url('/system/hakuser/tambah') }}" class="btn btn-box-tool" style="margin-bottom: 10px;"><i
                                    class="fa fa-plus"></i>&nbsp;Tambah Data</a>
                           </div>

                           <div class="table-responsive">
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
                  </div>
                  <!--/div note-tab -->
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
            $(document).ready(function () {
               var extensions = {
                  "sFilterInput": "form-control input-sm",
                  "sLengthSelect": "form-control input-sm"
               }
               // Used when bJQueryUI is false
               $.extend($.fn.dataTableExt.oStdClasses, extensions);
               // Used when bJQueryUI is true
               $.extend($.fn.dataTableExt.oJUIClasses, extensions);

               data = $('#data').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: {
                      url : baseUrl + "/system/hakuser/tableuser",
                  },
                  columns: [
                  {data: 'DT_Row_Index', name: 'DT_Row_Index', width: '5%'},
                  {data: 'm_username', name: 'm_username', width: '25%'},
                  {data: 'm_birth_tgl', name: 'm_birth_tgl', width: '20%'},
                  {data: 'm_addr', name: 'm_addr', width: '40%'},
                  {data: 'action', name: 'action', orderable: false, searchable: false, width: '10%'},
                  ],
                });

            });

            $('.datepicker').datepicker({
               format: "mm",
               viewMode: "months",
               minViewMode: "months"
            });
            $('.datepicker2').datepicker({
               format: "dd-mm-yyyy"
            });

            function edit(id) {
               window.location.href = baseUrl + '/system/hakuser/edit-user-akses/' + id + '/edit';
            }

            function hapusUser(id) {
               iziToast.question({
                 close: false,
                 overlay: true,
                 displayMode: 'once',
                 //zindex: 999,
                 title: 'Hapus Data',
                 message: 'Apakah anda yakin ?',
                 position: 'center',
                 buttons: [
                   ['<button><b>Ya</b></button>', function (instance, toast) {
                     $.ajax({
                       url: baseUrl +'/system/hakuser/hapus-user',
                       type: "POST",
                       dataType: "JSON",
                       data: {id:id, "_token": "{{ csrf_token() }}"},
                       success: function(response)
                       {
                         if(response.status == "sukses")
                         {
                           data.ajax.reload( null, false );
                           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                           iziToast.success({
                             position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                             title: 'Pemberitahuan',
                             message: response.pesan,
                             onClosing: function(instance, toast, closedBy){
                              
                             }
                           });
                         }
                         else
                         {
                           instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                           iziToast.error({
                             position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                             title: 'Pemberitahuan',
                             message: response.pesan,
                             onClosing: function(instance, toast, closedBy){

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
         </script>
         @endsection()