@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Setting Potongan</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Setting Potongan</li>
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
            <li class="active">
              <a href="#alert-tab" data-toggle="tab">Setting Potongan</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12">
                  <form method="POST" action="{{ url('hrd/payroll/update-potongan') }}/{{ $data->c_id }}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Potongan</label>
                      </div>
                      <div class="col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input value="{{ $data->c_nama }}" type="text" name="c_nama" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <a href="{{ url('hrd/payroll/setting-gaji') }}">
                        <input type="button" value="Batal" class="btn btn-danger btn-block">
                        </a>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="submit" value="Simpan" class="btn btn-primary btn-block">
                      </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endsection @section('extra_scripts')
          <script type="text/javascript">
          </script> @endsection