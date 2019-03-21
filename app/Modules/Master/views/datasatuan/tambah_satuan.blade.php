@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Master Data Satuan</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Master Data Customer</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Satuan&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Satuan</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                          <div class="row">
                            <div class="col-md-12" style="margin-top: -10px;margin-bottom: 20px;">
                           <div class="col-md-5 col-sm-6 col-xs-8">
                             <h4>Form Master Data Satuan</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                             <a href="{{ url('master/datasatuan/satuan') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>
                         </div>
                        <hr>
                         <div class="col-md-12 col-sm-12 col-xs-12">

                            <form id="form-save">
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
                                <div class="col-md-2 col-sm-3 col-xs-12"> 
                                      <label class="tebal">Kode Satuan</label>
                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" class="form-control input-sm" value="{{ $nota }}" id="id" readonly="true" name="id">
                                      <input type="hidden" name="id_cus_ut">
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-12">
                                      <label class="tebal">Nama Satuan</label>
                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-icon right">
                                      <input type="text" id="nama" name="nama" class="form-control input-sm" > 
                                    </div>                           
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">
                                      <label class="tebal">Detail Satuan</label>
                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-icon right">
                                      <input type="text" id="nama" name="detail" class="form-control input-sm" > 
                                    </div>                           
                                  </div>
                                </div>
                              </div>

                              <div align="right">
                                <div class="form-group">
                                  <button type="button" name="tambah_data" class="btn btn-primary" onclick="simpan()">Simpan Data</button>
                                </div> 
                              </div>
                             
                            </form>
                        


                </div>                                       
                    </div>
                        </div>
                                
                                    </div>
                                         </div>
                            </div>
                            
@endsection
@section("extra_scripts")
<script type="text/javascript">     

    function simpan (){
      var id = $("#id").val();
      var nama = $("#nama").val();

      if(id == '' || id == null ){

      Command: toastr["error"]('Kolom "Nama Customer" tidak boleh kosong ', "Peringatan !")

      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
        return false;
      }

      if(nama == '' || nama == null ){

      Command: toastr["error"]('Kolom "Tanggal Lahir" tidak boleh kosong ', "Peringatan !")

      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
        return false;
      }
      
      $.ajax({
        url : '{{ route('simpan_satuan') }}',
        type:'get',
        data: $('#form-save').serialize(),
        success:function(response){
            if (response.status == 'sukses')
            {
            toastr.success('Data Telah Tersimpan!','Pemberitahuan')
              window.location = ('{{ route('satuan') }}')
            
            }
            else
            {
               iziToast.error({
                 position: "topRight",
                 title: '',
                 message: 'Mohon melengkapi data.'
               });
            }
        }
        
      })

    }

    
    $(document).on("click","input[name='tambah_data']",function(e){
     

      });

      $("#nama_cus").load("/master/datacust/tambah_cust", function(){
      $("#nama_cus").focus();
      });
      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format: "dd/mm/yyyy",
        
      });


</script>
@endsection                            
