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
            {{--       <li hidden=""><a href="#note-tab" data-toggle="tab">History Rencana Pembelian</a></li> --}}
                           <!--  <li><a href="#label-badge-tab" data-toggle="tab">Belanja Harian</a></li> -->
              </ul>
        <div id="generalTabContent" class="tab-content responsive">
         {!!$daftar!!}
         {!!$history!!}
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
     $(".modal").on("hidden.bs.modal", function(){        
      $('tr').remove('.tbl_modal_detail_row');
      $('tr').remove('.tbl_modal_edit_row');      
      $("#txt_span_status").removeClass();
      $('#txt_span_status_edit').removeClass();
    });
  });


date(); 
function resetData(){  
  date();
  table();
}
function cari(){  
  table();
}

function date(){
  var d = new Date();
    d.setDate(d.getDate()-7);
    $('#tanggal1').datepicker({
          format:"dd-mm-yyyy",        
          autoclose: true,
    }).datepicker( "setDate", d);
    $('#tanggal2').datepicker({
          format:"dd-mm-yyyy",        
          autoclose: true,
    }).datepicker( "setDate", new Date());
}

var tablex;
setTimeout(function () {
      table();
      }, 1500);

  function editPlanAll (argument){
    window.location.href=(baseUrl+'/purcahse-plan/get-edit-plan/'+argument);
  }


function table(){
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
                    "tanggal2" :$('#tanggal2').val(),
                    },
              },
            columns: [
            {data: 'p_date', name: 'p_date'},
            {data: 'p_code', name: 'p_code'},            
            {data: 's_company', name: 's_company'},                        
            {data: 'status', name: 'status'}, 
            {data: 'tglConfirm', name: 'tglConfirm'},                         
            {data: 'aksi', name: 'aksi'},
           
            ],
             'columnDefs': [
                
               {
                    "targets": 3,
                    "className": "text-center",
               }
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
  function detailPlanAll(argument) {
    $.ajax({
          url     :  baseUrl+'/purcahse-plan/get-detail-plan/'+argument,
          type    : 'GET', 
          dataType: 'json',
          success : function(response){    
                 $('#modal-detail').modal('show');
                 console.log(response);
                 $('#lblCodePlan').text(response.data_header.p_code);
                 $('#lblTglPlan').text(response.data_header.p_date);
                 $('#lblStaff').text(response.data_header.m_name);
                 $('#lblSupplier').text(response.data_header.s_company);

            $('#div_item').empty();
            var key = 1;
            Object.keys(response.data_isi).forEach(function(){
            var i_id=response.data_isi[key-1].i_id;
                if (response.data_header.p_status == 'WT') {
                  $('#txt_span_status').text('Waiting');
                }else if(response.data_header.p_status == 'DE') {
                  $('#txt_span_status').text('Dapat di edit');
                }else{
                  $('#txt_span_status').text('Disetujui');
                }
            $('#div_item').append(
                            '<tr class="tbl_form_row" id="row'+i_id+'">'
                            +'<td style="text-align:center">'+key+'</td>'
                            +'<td><input type="text" value="'+response.data_isi[key-1].i_code+' | '+response.data_isi[key-1].i_name+'" class="form-control input-sm" readonly/></td>'
                            +'<td><input type="text" value="'+accounting.formatMoney(response.data_isi[key-1].s_qty,"",0,'.',',')+'" class="form-control input-sm" readonly/></td>'
                            +'<td><input type="text" value="'+response.data_isi[key-1].ppdt_qty+'" class="form-control input-sm" readonly/></td>'
                            +'<td><input type="text" value="'+response.data_isi[key-1].s_name+'" class="form-control input-sm" readonly/></td>'
                            +'</tr>');
            // tamp.push(i_id);
            // i = randString(5);
            key++;
          });

          }
      });
  }

      </script>
@endsection()