@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Master Data Pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Master&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Data Pegawai</li>
      <li>
        <i class="fa fa-angle-right"></i>&nbsp;Form Master Data Pegawai&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
              <a href="#alert-tab" data-toggle="tab">Form Master Data Pegawai</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Form Master Data Pegawai</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/datapegawai/pegawai') }}" class="btn">
                      <i class="fa fa-arrow-left"></i>
                    </a>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  <form method="POST" action="{{ url('master/datapegawai/update-pegawai-pro') }}/{{$data->c_id}}">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">ID Pegawai</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input disabled="" type="text" name="" value="{{$data->c_code}}" class="form-control input-sm">
                          <input type="hidden" name="c_code" value="{{$data->c_code}}" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Tanggal Masuk</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="tgl_masuk" value="{{$data->c_tahun_masuk}}" name="c_tahun_masuk" data-date-format="dd-mm-yyyy" class="datepicker form-control input-sm"
                            placeholder="dd-mm-yyyy">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Tugas</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="divisi" name="c_jabatan_pro_id" class="form-control input-sm">
                            <?php foreach($tugas as $div){ ?>
                            <?php if($div->c_id == $data->c_jabatan_pro_id){ ?>
                            <option value="{{ $div->c_id }}" selected="">{{ $div->c_jabatan_pro }}</option>
                            <?php }else{ ?>
                            <option value="{{ $div->c_id }}">{{ $div->c_jabatan_pro }}</option>
                            <?php }} ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Produksi</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select name="c_rumah_produksi" class="form-control input-sm">
                            <option <?php if($data->c_rumah_produksi == "1"){ echo "selected"; }?> value="1">1</option>
                            <option <?php if($data->c_rumah_produksi == "2"){ echo "selected"; }?>value="2">2</option>
                            <option <?php if($data->c_rumah_produksi == "3"){ echo "selected"; }?>value="3">3</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Pegawai</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_nama" value="{{$data->c_nama}}" data-date-format="dd-mm-yyyy" class="datepicker form-control input-sm">
                        </div>
                      </div>
                      <div align="right">
                        <input type="submit" value="Simpan Data" class="btn btn-primary">
                      </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>
            @endsection @section("extra_scripts")
            <script type="text/javascript">
              $("#nik").load("/master/datapegawai/tambah_pegawai", function () {
                $("#nik").focus();
              });
              $('#tgl_masuk').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
              });
              
            </script> @endsection