@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
  .select2-container { margin: 0; }
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
          <div class="page-title">Form Return Pembelian</div>
      </div>

      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Return Pembelian</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Return Pembelian&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Return Pembelian </a></li>
              <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
              <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
            </ul>

            <div id="generalTabContent" class="tab-content responsive" >
              <div id="alert-tab" class="tab-pane fade in active">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                    <div class="col-md-5 col-sm-6 col-xs-8">
                      <h4>Form Return Pembelian</h4>
                    </div>

                    <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                      <a href="{{ url('purchasing/returnpembelian/pembelian') }}" class="btn">
                        <i class="fa fa-arrow-left"></i>
                      </a>
                    </div>
                  </div>
  
                  <form method="post" id="form_return_pembelian" name="formReturnPembelian">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Metode Return</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <select class="form-control input-sm" id="pilih_metode_return" name="pr_method" style="width: 100%;">
                            <option value=""> - Pilih Metode Return</option>
                            <option value="TK"> Tukar Barang </option>
                            <option value="PN"> Potong Nota </option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <!-- START div#header_form -->
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;" id="header_form">
                      
                        {{ csrf_field() }}
                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 10px; padding-top:10px;padding-bottom:20px;" id="appending-form">
                        </div>
                    </div>
                  </form>
                  <!-- END div#header_form -->

                </div>                                       
              </div>
            </div>
                                
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--END PAGE WRAPPER-->              
@endsection
@section("extra_scripts")
  <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
  @include('Purchase::returnpembelian/js/format_currency')
  @include('Purchase::returnpembelian/js/form_functions')
  @include('Purchase::returnpembelian/js/form_commander')

@endsection                            
