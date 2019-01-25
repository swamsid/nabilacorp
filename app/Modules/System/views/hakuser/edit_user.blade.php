@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Manajemen User</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Manajemen User</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen User&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="page-content fadeInRight">
                    <div id="tab-general">
                        <div class="row mbl">
                            <div class="col-lg-12">
                              @foreach ($perusahaandata as $key => $value)
                                <input type="hidden" name="perusahaandata" value="{{$value->mc_comp}}">
                              @endforeach
                              @foreach ($gudangdata as $key => $value)
                                <input type="hidden" name="gudangdata" value="{{$value->mg_gudang}}">
                              @endforeach

                              <input type="hidden" name="id" value="{{$id}}">

                                            <div class="col-md-12">
                                                <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                                                </div>
                                            </div>

                            <ul id="generalTab" class="nav nav-tabs">
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen User</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                          <div class="row">

                         <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                           <div class="col-md-5 col-sm-6 col-xs-8" >
                             <h4>Form Manajemen User</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                             <a href="{{ url('system/hakuser/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>


                            <form method="POST" id="data">

                                <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Username</label>
                                    </div>

                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" id="username" class="form-control input-sm" name="username" value="{{$data[0]->m_username}}" required>
                                            <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="username-error"><small>Username harus diisi.</small></span>
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Password</label>
                                    </div>

                                    <div class="col-md-2 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="password" id="password" class="form-control input-sm" name="password" required>
                                            <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="password-error"><small>Password harus diisi.</small></span>
                                        </div>
                                    </div>
                                    <i style="margin-top:5px;" toggle="#password" class="glyphicon form-control-feedback toggle-password glyphicon-eye-open"></i>

                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Nama Lengkap</label>
                                    </div>

                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" id="nama" class="form-control input-sm" name="nama" value="{{$data[0]->m_name}}" required>
                                            <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="nama-error"><small>Nama harus diisi.</small></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Verifikasi Password</label>
                                    </div>

                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input type="password" id="passwordverif" class="form-control input-sm" name="passwordverif" required>
                                            <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="passwordverif-error"><small>Password verifikasi harus diisi.</small></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-4 col-xs-12">

                                            <label class="tebal">Tanggal Lahir</label>
                                    </div>
                                    <div class="col-md-3 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control datepicker2 input-sm" id="tgllahir" value="{{Carbon\Carbon::parse($data[0]->m_birth_tgl)->format('d/m/Y')}}" type="text" name="tgllahir" required>
                                            <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="tgllahir-error"><small>Tanggal lahir harus diisi.</small></span>
                                        </div>

                                    </div>

                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <label class="tebal">Alamat</label>
                                    </div>

                                    <div class="col-md-6 col-sm-8 col-xs-12">
                                        <div class="form-group">
                                            <textarea class="form-control" id="alamat" name="alamat" required>{{$data[0]->m_addr}}</textarea>
                                            <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="alamat-error"><small>Alamat harus diisi.</small></span>
                                        </div>
                                    </div>





                                    <div class="dinamis" id="dinamis">
                                      <div class="col-md-2">

                                            <label class="tebal">Perusahaan</label>

                                      </div>

                                      <div class="col-md-9">
                                        <div class="form-group col-sm-5">
                                          <select class="js-example-basic-multiple form-control" id="perusahaan" name="perusahaan[]" multiple="multiple">
                                            @foreach ($perusahaan as $key => $value)
                                              <option value="{{$value->c_id}}">{{$value->c_name}}</option>
                                            @endforeach
                                          </select>
                                          <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="perusahaan-error0"><small>Perusahaan harus diisi.</small></span>
                                        </div>
                                        <div class="col-md-2" style="margin-left:20px;">

                                              <label for="">Gudang </label>

                                        </div>
                                      <div class="form-group col-sm-4">
                                        <select class="js-example-basic-multiple form-control" id="gudang" name="gudang[]" multiple="multiple">
                                          @foreach ($gudang as $key => $value)
                                            <option value="{{$value->g_id}}">{{$value->g_name}}</option>
                                          @endforeach
                                        </select>
                                        <span style="color:#ed5565;display:none;" class="help-block m-b-none" id="gudang-error0"><small>Gudang harus diisi.</small></span>
                                      </div>
                                    </div>
                                  </div>

                                </div>


                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>Akses Pengguna</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <form class="row form-akses" style="padding-right: 18px; padding-left: 18px;">
                                            <table class="table table-bordered table-striped" id="table-akses">
                                                <thead>
                                                <tr>
                                                    <th>Nama Fitur</th>
                                                    <th class="text-center">Read</th>
                                                    <th class="text-center">Insert</th>
                                                    <th class="text-center">Update</th>
                                                    <th class="text-center">Delete</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                  @foreach($akses as $data)
                                                     <tr>
                                                         <td>@if($data->a_parrent == $data->a_id) <strong>{{ $data->a_name }}</strong> @else<span
                                                                     style="margin-left: 20px;">{{ $data->a_name }}</span> @endif
                                                         </td>
                                                         <td>
                                                             <div class="text-center">
                                                                 <div class="checkbox checkbox-success checkbox-single checkbox-inline">
                                                                     <input type="checkbox" class="read{{ $data->a_parrent }}"
                                                                            @if($data->a_parrent == $data->a_id) id="read{{ $data->a_parrent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'read{{ $data->a_parrent }}');"
                                                                            @endif name="read[]" value="{{ $data->a_id }}" @if($data->ma_read == 'Y') checked @endif>
                                                                     <label class=""> </label>
                                                                 </div>
                                                             </div>
                                                         </td>
                                                         <td>
                                                             <div class="text-center">
                                                                 <div class="checkbox checkbox-primary checkbox-single checkbox-inline">
                                                                     <input type="checkbox" class="insert{{ $data->a_parrent }}"
                                                                            @if($data->a_parrent == $data->a_id) id="insert{{ $data->a_parrent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'insert{{ $data->a_parrent }}');"
                                                                            @endif name="insert[]" value="{{ $data->a_id }}" @if($data->ma_insert == 'Y') checked @endif>
                                                                     <label class=""> </label>
                                                                 </div>
                                                             </div>
                                                         </td>
                                                         <td>
                                                             <div class="text-center">
                                                                 <div class="checkbox checkbox-warning checkbox-single checkbox-inline">
                                                                     <input type="checkbox" class="update{{ $data->a_parrent }}"
                                                                            @if($data->a_parrent == $data->a_id) id="update{{ $data->a_parrent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'update{{ $data->a_parrent }}');"
                                                                            @endif name="update[]" value="{{ $data->a_id }}" @if($data->ma_update == 'Y') checked @endif>
                                                                     <label class=""> </label>
                                                                 </div>
                                                             </div>
                                                         </td>
                                                         <td>
                                                             <div class="text-center">
                                                                 <div class="checkbox checkbox-danger checkbox-single checkbox-inline">
                                                                     <input type="checkbox" class="delete{{ $data->a_parrent }}"
                                                                            @if($data->a_parrent == $data->a_id) id="delete{{ $data->a_parrent }}" onchange="handleChange(this);" @else onchange="checkParent(this, 'delete{{ $data->a_parrent }}');"
                                                                            @endif name="delete[]" value="{{ $data->a_id }}" @if($data->ma_delete == 'Y') checked @endif>
                                                                     <label class=""> </label>
                                                                 </div>
                                                             </div>
                                                         </td>
                                                     </tr>
                                                 @endforeach
                                                </tbody>
                                            </table>
                                            <button style="float: right;" class="btn btn-primary" onclick="simpan()" type="button">Simpan
                                            </button>
                                            <a style="float: right; margin-right: 10px;" type="button" class="btn btn-white" href="{{ url('system/hakuser/index') }}" >Kembali</a>
                                        </form>
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
$(document).ready(function() {

      $('.datepicker2').datepicker({
        format:"dd/mm/yyyy",
        endDate:'0d'
      });

      var perusahaandata = [];

      $('input[name^="perusahaandata"]').each(function() {
         perusahaandata.push($(this).val());
      });

      var gudangdata = [];

      $('input[name^="gudangdata"]').each(function() {
         gudangdata.push($(this).val());
      });

      $('#perusahaan').val(perusahaandata).trigger('change');
      $('#gudang').val(gudangdata).trigger('change');

      $('#perusahaan').select2();
      $('#gudang').select2();

});
      $(".toggle-password").click(function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    function validateForm() {
      var username = document.getElementById('username');
      var nama = document.getElementById('nama');
      var tgllahir = document.getElementById('tgllahir');
      var perusahaan = document.getElementById('perusahaan');
      var password = document.getElementById('password');
      var passwordverif = document.getElementById('passwordverif');
      var alamat = document.getElementById('alamat');
      var gudang = document.getElementById('gudang');

      if (username.value == '') {
          $('#username-error').css('display', '');
          return false;
      }
      else if (nama.value == '') {
          $('#nama-error').css('display', '');
          return false;
      }
      else if (tgllahir.value == '') {
          $('#tgllahir-error').css('display', '');
          return false;
      }
      else if (perusahaan.value == '') {
          $('#perusahaan-error').css('display', '');
          return false;
      }
      else if (password.value == '') {
          $('#password-error').css('display', '');
          return false;
      }
      else if (passwordverif.value == '') {
          $('#passwordverif-error').css('display', '');
          return false;
      }
      else if (alamat.value == '') {
          $('#alamat-error').css('display', '');
          return false;
      }
      else if (gudang.value == '') {
          $('#gudang-error').css('display', '');
          return false;
      }

      return true;
  }

  function simpan(){
    var id = $('input[name=id]').val();
    if (validateForm()) {
      if (cekpassword()) {
        $.ajax({
          type: 'get',
          data: $('#data').serialize()+'&id='+id,
          url: baseUrl + '/system/hakuser/update',
          dataType: 'json',
          success : function(result){
            if (result.status == 'berhasil') {
              swal({
                  title: "Berhasil",
                  text: "Data berhasil disimpan!",
                  type: "success",
                  showConfirmButton: false,
                  timer: 1400
              });
              window.location.reload();
            }
          }
        });
      }
    }
  }

  function handleChange(checkbox) {
      if (checkbox.checked) {
          var klas = checkbox.className;
          $('input[class="'+klas+'"]').prop("checked", true);
      } else {
          var klas = checkbox.className;
          $('input[class="'+klas+'"]').prop("checked", false);
      }
  }

  function checkParent(checkbox, id){
      if (checkbox.checked) {
          $('input[id="'+id+'"]').prop("checked", true);
      }
  }

  function cekpassword(){
    var password = document.getElementById('password');
    var passwordverif = document.getElementById('passwordverif');

    if (password.value != passwordverif.value) {
      swal({
          title: "Informasi",
          text: "Password tidak sama!",
          type: "info",
          showConfirmButton: false,
          timer: 1400
      });

      $('#password').val('');
      $('#passwordverif').val('');

      return false;
    }

    return true
  }

</script>
@endsection
