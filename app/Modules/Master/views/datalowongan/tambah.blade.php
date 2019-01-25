@extends('main')
@section('content')
<!-- style for jquery validation error -->
<style>
  .ui-autocomplete { z-index:2147483647; }
  .error { border: 1px solid #f00; }
  .valid { border: 1px solid #8080ff; }
  .has-error .select2-selection {
    border: 1px solid #f00 !important;
  }
  .has-valid .select2-selection {
    border: 1px solid #8080ff !important;
  }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Master Data Lowongan</div>
    </div>

    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Data Lowongan</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Lowongan&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Lowongan</a></li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Form Master Data Lowongan</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/datalowongan/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
            
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  <form method="POST" id="form-save" name="formTambah">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Divisi<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group" id="divSelectDivisi">
                          <select class="form-control input-sm select2" id="ip_divisi" name="divisi" style="width: 100% !important;">
                          </select>
                        </div> 
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Level<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group" id="divSelectLevel">
                          <select class="form-control input-sm select2" id="ip_level" name="level" style="width: 100% !important;">
                          </select>
                        </div> 
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Jabatan<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group" id="divSelectJabatan">
                          <select class="form-control input-sm select2" id="ip_jabatan" name="jabatan" style="width: 100% !important;">
                          </select>
                        </div> 
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12" align="right" id="change_function">
                        <input type="button" name="tambah_data" value="Simpan Data" id="save_data" class="btn btn-primary">
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
<!--END PAGE WRAPPER-->
</div>                         
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">     

  $( document ).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    //select2
    $( "#ip_jabatan" ).select2({
    });
    $( "#ip_level" ).select2({
    });

    $( "#ip_divisi" ).select2({
      placeholder: "Pilih Divisi...",
      ajax: {
        url: baseUrl + '/master/datalowongan/lookup-data-divisi',
        dataType: 'json',
        data: function (params) {
          return {
              q: $.trim(params.term)
          };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
      }, 
    });

    $('#ip_divisi').change(function() 
    {
      $('#ip_level').empty();
      $('#ip_jabatan').empty();
      $( "#ip_level" ).select2({
        placeholder: "Pilih Level...",
        ajax: {
          url: baseUrl + '/master/datalowongan/lookup-data-level',
          dataType: 'json',
          data: function (params) {
            return {
                q: $.trim(params.term)
            };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
        }, 
      });
    });

    $('#ip_level').change(function() 
    {
      $('#ip_jabatan').empty();
      var divisi = $('#ip_divisi').val();
      var level = $('#ip_level').val();
      $( "#ip_jabatan" ).select2({
        placeholder: "Pilih Jabatan...",
        ajax: {
          url: baseUrl + '/master/datalowongan/lookup-data-jabatan',
          dataType: 'json',
          data: function (params) {
            return {
                q: $.trim(params.term),
                divisi : divisi,
                level : level
            };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
        }, 
      });
    });
    
    $('#change_function').on("click", "#save_data",function(){
      var IsValid = $("form[name='formTambah']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/master/datalowongan/simpan_lowongan",
          data: $('#form-save').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/master/datalowongan/index";
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/master/datalowongan/index";
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    });

    //validasi
    $("#form-save").validate({
      // Specify validation rules
      rules:{
          divisi : "required",
          level : "required",
          jabatan : "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $('#ip_divisi').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectDivisi').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectDivisi').addClass('has-error').removeClass('has-valid');
      }
    });

    $('#ip_level').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectLevel').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectLevel').addClass('has-error').removeClass('has-valid');
      }
    });

    $('#ip_jabatan').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectJabatan').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectJabatan').addClass('has-error').removeClass('has-valid');
      }
    });

  }); //end jquery
</script>
@endsection