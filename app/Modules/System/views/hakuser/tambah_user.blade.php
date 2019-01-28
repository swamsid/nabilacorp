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
            <li class="active">Manajemen User</li>
            <li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen User&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                        <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen User</a></li>
                        <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                        <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                                    <div class="col-md-5 col-sm-6 col-xs-8">
                                        <h4>Form Manajemen User</h4>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                                        <a href="{{ url('system/hakuser/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                    </div>


                                    <form id="data">
                                        {{csrf_field()}}
                                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Username:<font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" id="username" class="form-control input-sm" name="username"
                                                        required>
                                                    <span style="color:#ed5565;display:none;" class="help-block m-b-none"
                                                        id="username-error"><small>Username harus diisi.</small></span>
                                                </div>
                                            </div>


                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Password:<font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-2 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="password" id="password" class="form-control input-sm"
                                                        name="password" required>
                                                </div>
                                            </div>
                                            <i style="margin-top:5px;" toggle="#password" class="glyphicon form-control-feedback toggle-password glyphicon-eye-open"></i>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Nama Lengkap:<font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" id="nama" class="form-control input-sm" name="NamaLengkap">
                                                    <input type="hidden" name="IdPegawai" class="form-control input-sm ui-autocomplete-input">
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Tanggal Lahir:<font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input class="form-control input-sm" id="tgllahir" type="text" name="TanggalLahir" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Jabatan/Posisi:<font color="red">*</font></label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm" name="pp_jabatan" id="pp_jabatan" readonly>
                                                    <input type="hidden" class="form-control input-sm" name="id_jabatan" id="id_jabatan" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Alamat:<font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <textarea name="alamat" class="form-control" readonly></textarea>
                                                </div>
                                            </div>

                                            <div class="dinamis" id="dinamis">
                                                <div class="col-md-3 col-sm-4 col-xs-12">
                                                    <label class="tebal">Outlet:<font color="red">*</font></label>
                                                </div>
                                                <div class="col-md-3 col-sm-8 col-xs-12">
                                                    <select class="js-example-basic-multiple form-control input-sm" id="perusahaan" name="perusahaan[]" multiple="multiple">
                                                        @foreach ($perusahaan as $key => $value)
                                                            <option value="{{$value->c_id}}">{{$value->c_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div align="right" style="padding-top:10px;" class="col-md-12 col-sm-12 col-xs-12">
                                                <div id="div_button_save" class="form-group">
                                                    <button style="float: right;" class="btn btn-primary" onclick="simpan()"
                                                        type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i>  &nbsp; Simpan User
                                                        
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12" id="detail">
                                                <label class="tebal">- Hak Akses User:<font color="red">*</font></label>

                                            <div class="table-responsive">
                                                <form class="row form-akses" style="padding-right: 18px; padding-left: 18px;">
                                                    <table class="table tabelan table-bordered table-hover" id="table-akses">
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
                                                        @php
                                                            $nomor=1;
                                                        @endphp
                                                        @foreach($akses as $index => $data)
                                                            @if($data->a_parrent == 0)
                                                                <tr style="background: #f7e8e8">
                                                                    <td>
                                                                        <input type="hidden" name="id_access[]" value="{{$data->a_id}}">
                                                                        {{$nomor}}. &nbsp; <strong>{{$data->a_name}}</strong>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center">
                                                                            <input type="hidden" value="N" class="checkbox" name="ma_read[]" id="iRead-{{$data->a_id}}"> 
                                                                            <input type="checkbox" class="checkbox" onchange="simpanRead('{{$data->a_id}}')" id="cRead-{{$data->a_id}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center">
                                                                            <input type="hidden" value="N" class="checkbox" name="ma_insert[]" id="iInsert-{{$data->a_id}}"> 
                                                                            <input type="checkbox" class="checkbox" onchange="simpanInsert('{{$data->a_id}}')" id="cInsert-{{$data->a_id}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center">
                                                                            <input type="hidden" value="N" class="checkbox" name="ma_update[]" id="iUpdate-{{$data->a_id}}"> 
                                                                            <input type="checkbox" class="checkbox" onchange="simpanUpdate('{{$data->a_id}}')" id="cUpdate-{{$data->a_id}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center">
                                                                            <input type="hidden" value="N" class="checkbox" name="ma_delete[]" id="iDelete-{{$data->a_id}}"> 
                                                                            <input type="checkbox" class="checkbox" onchange="simpanDelete('{{$data->a_id}}')" id="cDelete-{{$data->a_id}}">
                                                                        </div>
                                                                    </td>
                                                                    @php
                                                                        $nomor++;
                                                                    @endphp
                                                                </tr>
                                                            @else
                                                                
                                                                    <td>
                                                                        <input type="hidden" name="id_access[]" value="{{$data->a_id}}">
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$data->a_name}}
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center">
                                                                            <input type="hidden" value="N" class="checkbox" name="ma_read[]" id="iRead-{{$data->a_id}}"> 
                                                                            <input type="checkbox" class="checkbox" onchange="simpanRead('{{$data->a_id}}')" id="cRead-{{$data->a_id}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center">
                                                                            <input type="hidden" value="N" class="checkbox" name="ma_insert[]" id="iInsert-{{$data->a_id}}"> 
                                                                            <input type="checkbox" class="checkbox" onchange="simpanInsert('{{$data->a_id}}')" id="cInsert-{{$data->a_id}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center">
                                                                            <input type="hidden" value="N" class="checkbox" name="ma_update[]" id="iUpdate-{{$data->a_id}}"> 
                                                                            <input type="checkbox" class="checkbox" onchange="simpanUpdate('{{$data->a_id}}')" id="cUpdate-{{$data->a_id}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="text-center">
                                                                            <input type="hidden" value="N" class="checkbox" name="ma_delete[]" id="iDelete-{{$data->a_id}}"> 
                                                                            <input type="checkbox" class="checkbox" onchange="simpanDelete('{{$data->a_id}}')" id="cDelete-{{$data->a_id}}">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    
                                                    <a style="float: right; margin-right: 10px;" type="button" class="btn btn-white"
                                                        href="{{ url('system/hakuser/index') }}">Kembali</a>
                                                </form>
                                            </div>
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

@endsection
@section("extra_scripts")
<script type="text/javascript">
    var iddinamis = 0;
    $(document).ready(function () {

        $('.js-example-basic-multiple').select2();

        $('input[name="NamaLengkap"]').focus(function() {
            var key = 1;
            $('input[name="NamaLengkap"]').autocomplete({
               source: baseUrl+'/system/hakuser/autocomplete-pegawai',
               minLength: 1,
               select: function(event, ui) {
                 $('input[name="NamaLengkap"]').val(ui.item.label);
                 $('input[name="IdPegawai"]').val(ui.item.id);
                 $('input[name="TanggalLahir"]').val(ui.item.lahir_txt);
                 $('input[name="id_jabatan"]').val(ui.item.jabatan_id);
                 $('input[name="pp_jabatan"]').val(ui.item.jabatan_txt);
                 $('textarea[name="alamat"]').text(ui.item.alamat_txt);
               }
             });
             $('input[name="NamaLengkap"]').val('');
             $('input[name="IdPegawai"]').val('');
             $('input[name="TanggalLahir"]').val('');
             $('input[name="id_jabatan"]').val('');
             $('input[name="pp_jabatan"]').val('');
             $('textarea[name="alamat"]').text('');
         });

    });

    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


    function simpan() 
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            data: $('#data').serialize() + '&' + $('.form-akses').serialize(),
            url: baseUrl + '/system/hakuser/simpan',
            type: 'POST',
            dataType: 'json',
            success: function (result) {
                if (result.status == 'berhasil') 
                {
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'User Baru Tersimpan.'
                    });
                    window.location = baseUrl + '/system/hakuser/index';
                    $('input[type=text]').val('');
                    $('input[type=password]').val('');
                    $('#alamat').val('');
                    $('#perusahaan').val('').trigger('change');
                    $('#gudang').val('').trigger('change');
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
        });

    }

    function simpanRead(id) {
        if ($('#cRead-' + id).prop('checked')) {
            $('#iRead-' + id).val('Y')
        } else {
            $('#iRead-' + id).val('N')
        }
    }

    function simpanInsert(id) {
        if ($('#cInsert-' + id).prop('checked')) {
            $('#iInsert-' + id).val('Y')
        } else {
            $('#iInsert-' + id).val('N')
        }
    }

    function simpanUpdate(id) {
        if ($('#cUpdate-' + id).prop('checked')) {
            $('#iUpdate-' + id).val('Y')
        } else {
            $('#iUpdate-' + id).val('N')
        }
    }

    function simpanDelete(id) {
        if ($('#cDelete-' + id).prop('checked')) {
            $('#iDelete-' + id).val('Y')
        } else {
            $('#iDelete-' + id).val('N')
        }
    }

</script>
@endsection