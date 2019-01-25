@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Pengiriman Barang Hasil Produksi</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Pengiriman Barang Hasil Produksi</li>
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
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Pengiriman Barang Hasil Produksi</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                         <div id="generalTabContent" class="tab-content responsive">

                                    <div id="alert-tab" class="tab-pane fade in active">
                                      <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                          <form id="formdata">
                                            <input type="hidden" name="nota">
                                            <input type="hidden" name="p_code" value="{{$pengiriman[0]->p_code}}">
                                            <input type="hidden" name="id" value="{{$id}}">
                                          <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                              <label class="tebal">No Nota :</label>
                                            </div>
                                            <div class="col-md-8 col-sm-12 col-xs-12">
                                              <div class="input-group">
                                                <select class="form-control input-sm select2" id="cariId" name="CariId" onchange="getdata()">
                                                  <option value=""> - Pilih Nomor Nota</option>
                                                    <option value="{{$pengiriman[0]->pr_id}}" selected>{{$pengiriman[0]->pr_code}}</option>
                                                </select>
                                                <span class="input-group-btn">
                                                  <a href="#" class="btn btn-info btn-sm"><i class="fa fa-search" alt="search"></i></a>
                                                </span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                              <label class="tebal">Tujuan :</label>
                                            </div>
                                            <div class="col-md-8 col-sm-12 col-xs-12">
                                              <div class="input-group">
                                                <select class="form-control input-sm select2" name="tujuan">
                                                  <option value=""> - Pilih Tujuan - </option>
                                                  @foreach ($tujuan as $key => $value)
                                                    <option value="{{$value->gc_id}}" @if ($value->gc_id == $pengiriman[0]->pd_position)
                                                      selected
                                                    @endif>{{$value->gc_gudang}}</option>
                                                  @endforeach
                                                </select>
                                                <span class="input-group-btn">
                                                  <a href="#" class="btn btn-info btn-sm"><i class="fa fa-search" alt="search"></i></a>
                                                </span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                              <label class="tebal">Keterangan :</label>
                                            </div>
                                            <div class="col-md-8 col-sm-12 col-xs-12">
                                              <div class="input-group">
                                                <textarea name="keterangan" rows="4" cols="50">{{$pengiriman[0]->p_keterangan}}</textarea>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                              <label class="tebal">Tanggal Transfer :</label>
                                            </div>
                                            <div class="col-md-8 col-sm-12 col-xs-12">
                                              <div class="input-group">
                                                <input id="tanggaltransfer" class="form-control date input-sm" type="text" name="p_tanggal_transfer" value="{{Carbon\Carbon::parse($pengiriman[0]->p_tanggal_transfer)->format('d/m/Y')}}">
                                              </div>
                                            </div>
                                          </div>

                                          <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                              <label class="tebal">Nota Pengiriman :</label>
                                            </div>
                                            <div class="col-md-8 col-sm-12 col-xs-12">
                                              <div class="input-group">
                                                <input id="notapengiriman" class="form-control date input-sm" disabled type="text" name="p_tanggal_transfer" placeholder="( Auto )">
                                              </div>
                                            </div>
                                          </div>

                                          <div class="table-responsive">
                                            <table class="table tabelan table-hover table-bordered" >
                                              <thead>
                                                <tr>
                                                  <th width="5%">No</th>
                                                  <th>No Product Result</th>
                                                  <th>Nama Barang</th>
                                                  <th>Qty</th>
                                                  <th>Dikirim</th>
                                                  <th>Sisa</th>
                                                  <th width="5%">Status</th>
                                                  <th width="10%">Kirim</th>
                                                </tr>
                                              </thead>
                                              <tbody id="showdata">
                                                @foreach ($produkhasil as $key => $value)
                                                  {{$sisa = $value->prdt_qty - $value->prdt_kirim}}
                                                  <tr>
                                                          <td>{{$key + 1}}</td>
                                                          <td>{{$value->pr_code}}</td>
                                                          <td>{{$value->i_name}}</td>
                                                          <td>{{$value->prdt_qty}}</td>
                                                          <td>{{$value->prdt_kirim}}</td>
                                                          <td>{{$sisa}}</td>
                                                          @if ($sisa == 0)
                                                            <td><span class="label label-success">Terkirim</span></td>
                                                          @else
                                                            <td><span class="label label-warning">Belum Terkirim</span></td>
                                                          @endif
                                                          <td><input type="text" id="kirim{{$key}}" class="form-control number" onkeypress="return isNumberKey(event)" onkeydown="filter({{$key}},{{$sisa}})" name="kirim[]" value="{{$sisa}}"></td>
                                                          <input type="hidden" name="item[]" value="{{$value->prdt_item}}">
                                                  </tr>
                                                @endforeach
                                              </tbody>
                                            </table>
                                          </form>
                                          </div>
                                          <br>
                                          <br>
                                          <a href="{{url('/inventory/pengirimanproduksi/pengirimanproduksi')}}" class="btn btn-default pull-right">Cancel</a>&nbsp;
                                          <button type="button" class="btn btn-primary pull-right" style="margin-right:10px;" onclick="simpan()" name="button">Simpan</button>
                                        </div>

                                      </div>
                                    </div>
                                     <!-- End div #alert-tab  -->

@endsection
@section("extra_scripts")
    <script type="text/javascript">
     $(document).ready(function() {
       var data;
       $('.select2').select2();
       $( "#tanggaltransfer" ).datepicker();


    var extensions = {
         "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    $('#data').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
    $('#data2').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
    $('#data3').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });

        var id = $('#cariId').val();
        var html = '';
        $.ajax({
          type: 'get',
          data: {id:id},
          dataType: 'json',
          url: baseUrl + '/inventory/pengirimanproduksi/getdata',
          success : function(result){
            data = result;
            for (var i = 0; i < result.length; i++) {
              var sisa = parseInt(result[i].prdt_qty) - parseInt(result[i].prdt_kirim);
              if (sisa == 0) {
                var status = '<span class="label label-success">Terkirim</span>';
              } else if (sisa != 0) {
                var status = '<span class="label label-warning">Belum Terkirim</span>';
              }
              html += '<tr>'+
                      '<td>'+(i + 1)+'</td>'+
                      '<td>'+result[i].pr_code+'</td>'+
                      '<td>'+result[i].i_name+'</td>'+
                      '<td>'+result[i].prdt_qty+'</td>'+
                      '<td>'+result[i].prdt_kirim+'</td>'+
                      '<td>'+sisa+'</td>'+
                      '<td>'+status+'</td>'+
                      '<td><input type="text" id="kirim'+i+'" class="form-control number" onkeypress="return isNumberKey(event)" onkeydown="filter('+i+','+sisa+')" name="kirim[]" value="'+sisa+'"></td>'+
                      '<input type="hidden" name="item[]" value="'+result[i].prdt_item+'">'+
                      '</tr>';
            }
            $('#showdata').html(html);
            $('input[name=nota]').val(result[0].pr_code);
            swal.close();
          }
        })
});
      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd-mm-yyyy",
        autoclose:true,
        endDate:"today"
      });

      function getdata(){
        swal({
              title: 'Loading!',
              showCancelButton: false,
              showConfirmButton: false
            });
          var id = $('#cariId').val();
          var html = '';
          $.ajax({
            type: 'get',
            data: {id:id},
            dataType: 'json',
            url: baseUrl + '/inventory/pengirimanproduksi/getdata',
            success : function(result){
              data = result;
              for (var i = 0; i < result.length; i++) {
                var sisa = parseInt(result[i].prdt_qty) - parseInt(result[i].prdt_kirim);
                if (sisa == 0) {
                  var status = '<span class="label label-success">Terkirim</span>';
                } else if (sisa != 0) {
                  var status = '<span class="label label-warning">Belum Terkirim</span>';
                }
                html += '<tr>'+
                        '<td>'+(i + 1)+'</td>'+
                        '<td>'+result[i].pr_code+'</td>'+
                        '<td>'+result[i].i_name+'</td>'+
                        '<td>'+result[i].prdt_qty+'</td>'+
                        '<td>'+result[i].prdt_kirim+'</td>'+
                        '<td>'+sisa+'</td>'+
                        '<td>'+status+'</td>'+
                        '<td><input type="text" id="kirim'+i+'" class="form-control number" onkeypress="return isNumberKey(event)" onkeydown="filter('+i+','+sisa+')" name="kirim[]" value="'+sisa+'"></td>'+
                        '<input type="hidden" name="item[]" value="'+result[i].prdt_item+'">'+
                        '</tr>';
              }
              $('#showdata').html(html);
              $('input[name=nota]').val(result[0].pr_code);
              swal.close();
            }
          });
      }

      function filter(id, sisa){
        var kirim = $('#kirim'+id).val();
            if (kirim > data[id].prdt_qty) {
              swal("Info!", "Tidak boleh melebihi qty!");
              $('#kirim'+id).val(sisa);
              i = data.length + 1;
            }
      }

      function simpan(){
        $.ajax({
          type: 'get',
          data: $('#formdata').serialize(),
          dataType: 'json',
          url: baseUrl + '/inventory/pengirimanproduksi/update',
          success : function(result){
            if (result.status == 'berhasil') {
              swal({
                    title: 'Berhasil!',
                    text: 'Berhasil Disimpan!'
                  });
              setTimeout(function () {
                window.location.href = baseUrl + '/inventory/pengirimanproduksi/pengirimanproduksi';
              }, 500);
            }
          }
        });
      }

      function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode
             if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

             return true;
          }

      </script>
@endsection
