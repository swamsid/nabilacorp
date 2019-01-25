@extends('main')
@section('content')
  <div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Manajemen User</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Manajemen User</li>
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
                      <li class="active"><a href="#alert-tab" data-toggle="tab">Manajemen User</a></li>
                      <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                      <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">

                      <div id="alert-tab" class="tab-pane fade in active">

                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="profile-info">
                    <div class="">
                        <div>
                            <h2 class="no-margins">
                                {{ $user->m_name }}
                            </h2>
                            <small>
                                {{ $user->m_addr }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <table class="table small m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>Perusahaan</strong>
                        </td>
                        <td>
                            {{ $user->c_name }}
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <strong>Last Login</strong>
                        </td>
                        <td>
                            {{ $user->m_lastlogin }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Last Logout</strong>
                        </td>
                        <td>
                            {{ $user->m_lastlogout }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">
                <small>Username</small>
                <h2 class="no-margins">{{ $user->m_username }}</h2>
                <div id="sparkline1"><canvas style="display: inline-block; width: 247px; height: 50px; vertical-align: top;" width="247" height="50"></canvas></div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-title">
                <h5>Akses Pengguna</h5>
            </div>
            <div class="ibox-content">
                <form class="row form-akses" style="padding-right: 18px; padding-left: 18px;">
                    <input type="hidden" name="id" value="{{ $id }}">
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
                    <a style="float: right; margin-right: 10px;" type="button" class="btn btn-white" href="{{ url('system/hakuser/user') }}" >Kembali</a>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>


@endsection
@section("extra_scripts")
    <script type="text/javascript">
        function handleChange(checkbox) {
          alert(checkbox);
            if (checkbox.checked) {
                var klas = checkbox.className;
                $('input[class="'+klas+'"]').prop("checked", true);
            } else {
                var klas = checkbox.className;
                $('input[class="'+klas+'"]').prop("checked", false);
            }
        }

        function checkParent(checkbox, id){
          alert(id);
            if (checkbox.checked) {
                $('input[id="'+id+'"]').prop("checked", true);
            }
        }

        function simpan(){
            waitingDialog.show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ url('system/hakakses/simpan') }}',
                type: 'post',
                data: $('.form-akses').serialize(),
                success: function(response){
                    if (response.status == 'sukses') {
                        waitingDialog.hide();
                        location.reload();
                    }
                }, error:function(x, e) {
                    waitingDialog.hide();
                    if (x.status == 0) {
                        alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                    } else if (x.status == 404) {
                        alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                    } else if (x.status == 500) {
                        alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout'){
                        alert('Request Time out. Harap coba lagi nanti');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            })
        }
    </script>
@endsection
