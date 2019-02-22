@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Rencana Pembelian</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Rencana Pembelian</li>
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
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Daftar Rencana Pembelian</a></li>
                  <li hidden=""><a href="#note-tab" data-toggle="tab" onclick="lihatHistorybyTgl()">History Rencana Pembelian</a></li>
                           <!--  <li><a href="#label-badge-tab" data-toggle="tab">Belanja Harian</a></li> -->
              </ul>
        <div id="generalTabContent" class="tab-content responsive">
         {!!$daftar!!}
         {!!$tabHistory!!}
              <!-- div note-tab -->
{{--               <div id="note-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                    <!-- Isi Content -->
                  </div>
                </div>
              </div><!--/div note-tab --> --}}
              <!-- div label-badge-tab -->
              <div id="label-badge-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                    <!-- Isi content -->
                  </div>
                </div>
              </div><!-- /div label-badge-tab -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{!!$modalDetail!!}
{!!$modalEdit!!}
@endsection
@section("extra_scripts")
   <script type="text/javascript">
   $(document).ready(function() {

      var d = new Date();
      d.setDate(d.getDate()-7);
      $('#tanggal1').datepicker({
          format:"dd-mm-yyyy",        
          autoclose: true,
      }).datepicker( "setDate", d);
      $('.datepicker1').datepicker({
         autoclose: true,
         format:"dd-mm-yyyy",
         endDate: 'today'
      }).datepicker("setDate", d);
      $('#tanggal2').datepicker({
          format:"dd-mm-yyyy",        
          autoclose: true,
      }).datepicker( "setDate", new Date());

      $(".modal").on("hidden.bs.modal", function(){        
         $('tr').remove('.tbl_modal_detail_row');
         $('tr').remove('.tbl_modal_edit_row');      
         $("#txt_span_status").removeClass();
         $('#txt_span_status_edit').removeClass();
      });

      table();

      $('#tampil_data').on('change', function() {
         lihatHistorybyTgl();
       })

   });

   function resetData(){  
      table();
   }


  function editPlanAll (argument){
    window.location.href=(baseUrl+'/purcahse-plan/get-edit-plan/'+argument);
  }

   function table()
   {
      $('#tablePlan').dataTable().fnDestroy();
      tablex = $("#tablePlan").DataTable({        
            responsive: true,
           "language": dataTableLanguage,
      processing: true,
               serverSide: true,
               ajax: {
                 "url": "{{ url("/purcahse-plan/data-plan") }}",
                 "type": "get",
                 data: {
                       "_token": "{{ csrf_token() }}",                    
                       "tanggal1" :$('#tanggal1').val(),
                       "tanggal2" :$('#tanggal2').val()
                       },
                 },
               columns: [
               {data: 'tglBuat', name: 'tglBuat', "width": "15%"},
               {data: 'p_code', name: 'p_code', "width": "15%"},            
               {data: 'm_name', name: 'm_name', "width": "15%"},
               {data: 's_name', name: 's_name', "width": "15%"},                        
               {data: 'status', name: 'status', "width": "10%"}, 
               {data: 'tglConfirm', name: 'tglConfirm', "width": "15%"},                         
               {data: 'aksi', name: 'aksi', "width": "15%"},
              
               ],
               //responsive: true,

               "pageLength": 10,
               "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
               
                "rowCallback": function( row, data, index ) {
                       
                       

                   if (data['s_status']=='draft') {
                        $('td', row).addClass('warning');
                   } 
                 }   
              
      });
   }

   function lihatHistorybyTgl(){
      var tgl1 = $('#tanggal1').val();
      var tgl2 = $('#tanggal2').val();
      var tampil = $('#tampil_data').val();
         $('#tbl-history').dataTable({
         "destroy": true,
         "processing" : true,
         "serverside" : true,
         "ajax" : {
           url: baseUrl + "/purchasing/rencanapembelian/get-data-tabel-history/"+tgl1+"/"+tgl2+"/"+tampil,
           type: 'GET'
         },
         "columns" : [
           {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
           {"data" : "p_code", "width" : "10%"},
           {"data" : "i_name", "width" : "15%"},
           {"data" : "s_name", "width" : "10%"},
           {"data" : "s_company", "width" : "15%"},
           {"data" : "tglBuat", "width" : "10%"},
           {"data" : "ppdt_qty", "width" : "5%"},
           {"data" : "tglConfirm", "width" : "10%"},
           {"data" : "ppdt_qtyconfirm", "width" : "5%"},
           {"data" : "status", "width" : "10%"}
         ],
         /*"rowsGroup": [
           'first:name'
         ],*/
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

   function detailPlanAll(id) 
   {
      $.ajax({
         url : baseUrl + "/purchasing/rencanapembelian/get-detail-plan/"+id+"/all",
         type: "GET",
         dataType: "JSON",
         success: function(data)
         {
           var key = 1;
           //ambil data ke json->modal
           $('#txt_span_status').text(data.spanTxt);
           $("#txt_span_status").addClass('label'+' '+data.spanClass);
           $('#lblCodePlan').text(data.header[0].p_code);
           $('#lblTglPlan').text(data.header[0].p_created);
           $('#lblStaff').text(data.header[0].m_name);
           $('#lblSupplier').text(data.header[0].s_company);
           //loop data
           Object.keys(data.data_isi).forEach(function(){
             $('#tabel-detail').append('<tr class="tbl_modal_detail_row">'
                             +'<td>'+key+'</td>'
                             +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                             +'<td>'+data.data_isi[key-1].s_name+'</td>'
                             +'<td>'+data.data_isi[key-1].ppdt_qty+'</td>'
                             +'<td>'+data.data_isi[key-1].ppdt_qtyconfirm+'</td>'
                             +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                             +'</tr>');
             key++;
           });
           $('#modal-detail').modal('show');
         },
         error: function (jqXHR, textStatus, errorThrown)
         {
             alert('Error get data from ajax');
         }
      });
   }

      </script>
@endsection()