@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
        <div class="page-title">Form Master Outlet</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Outlet</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Outlet&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Outlet</a></li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                  <div class="col-md-5 col-sm-6 col-xs-8" >
                    <h4>Form Master Outlet</h4>
                  </div>
                  
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/Outlet/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                   
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <form id="form_suplier" method="GET">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-top:30px;padding-bottom:20px;">
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Pemilik Outlet<font color="red">*</font></label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-building"></i>
                            <input type="text" id="nama_sup" name="c_name" class="form-control input-sm" >
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Nama Outlet<font color="red">*</font></label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-user"></i>
                            <input type="text" id="owner" name="c_company" class="form-control input-sm">
                          </div>
                        </div>
                      </div>
                             
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Alamat<font color="red">*</font></label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-home"></i>
                            <textarea id="alamat" name="c_address" class="form-control input-sm"></textarea>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div align="right">
                      <div class="form-group" align="right">
                        <button type="button" onclick="simpan()" class="btn btn-primary">Simpan Data</button>
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
  <!--END TITLE & BREADCRUMB PAGE-->
</div>
                            
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">     

  $(document).ready(function(){
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
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

    var date = new Date();
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate()+7);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
    }).datepicker("setDate", nd);

    //mask money
    $('.hp').inputmask("9999 9999 9999");

  });// end jquery

  function simpan()
  {
      $.ajax({
         type: "GET",
         url: baseUrl + '/master/outlet/simpan',
         data: $('#form_suplier').serialize(),
         success: function(response){
            console.log(response);

            if(response.status=='sukses')
            {
               toastr["success"]("Outlet Berhasil ditambahkan", "Sukses");
               window.location = ( baseUrl + '/master/outlet/index');
            }
            else
            {
               iziToast.error({
                 position: "topRight",
                 title: '',
                 message: 'Mohon melengkapi data.'
               });
            }
         },
         error: function(){
            toastr["error"]("Terjadi Kesalahan", "Error");
         },
         // async: false
      });
  }

</script>
@endsection                            
