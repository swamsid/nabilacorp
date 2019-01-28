@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Data Jabatan</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Data Jabatan</li>
      <li>
        <i class="fa fa-angle-right"></i>&nbsp;Tambah Data Jabatan&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
    </ol>
    <div class="clearfix">
    </div>
  </div>
  <div class="page-content">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">

          <div class="col-md-12">
            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
            </div>
          </div>

          <ul id="generalTab" class="nav nav-tabs">
            <li class="active">
              <a href="#alert-tab" data-toggle="tab">Data Jabatan</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px; margin-bottom: 10px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Tambah Data Jabatan</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('/master/datajabatan') }}" class="btn">
                      <i class="fa fa-arrow-left"></i>
                    </a>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
                  <form id="jPro">
                    {{ csrf_field() }}
                    <table class="table">
                   
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Jabatan</label>
                      </div>
                      <div class="col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input required type="text" name="c_jabatan_pro" id="c_jabatan_pro" class="form-control input-sm">
                        </div>
                      </div>
                    </table>
                  </form>
                  <div class="col-sm-12">
                      <input type="submit" value="Simpan" onclick="simpanJPro()" class="btn btn-warning pull-right" id="simpabjPro">
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      @endsection @section('extra_scripts')
      <script type="text/javascript">
        function klik() {
          swal({
            title: "Apa anda yakin?",
            text: "Data Yang Dihapus Tidak Dapat Dikembalikan",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
          },
            function (isConfirm) {
              if (isConfirm) {
                swal("Deleted!", "Your imaginary data has been delete.", "success");
              } else {
                swal("Cancelled", "Your imaginary data is safe :)", "error");
              }
            });
        }

        function simpanJPro(){
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $('.simpabjPro').attr('disabled', 'disabled');
        var a = $('#jPro').serialize();
        $.ajax({
            url: baseUrl + "/datajabatan/simpan-jabatanpro",
            type: 'GET',
            data: a,
            success: function (response, customer) {
                if (response.status == 'sukses') {
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Berhasil Menyimpan.'
                    });
                    $('.simpabjPro').removeAttr('disabled', 'disabled');
                    window.location.href = baseUrl + "/master/datajabatan";
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Gagal Menyimpan.'
                    });
                    $('.simpabjPro').removeAttr('disabled', 'disabled');
                }
            }
        })
        }

      </script> @endsection