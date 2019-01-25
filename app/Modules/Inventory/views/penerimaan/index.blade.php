@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Penerimaan Barang Hasil Produksi</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Penerimaan Barang Hasil Produksi</li>
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
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Penerimaan Barang Hasil Produksi</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                         <div id="generalTabContent" class="tab-content responsive">

                                  @include('inventory.p_suplier.modal')

                                    <div id="alert-tab" class="tab-pane fade in active">
                                      <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">

                                          <div class="col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                              <label class="tebal">No Nota :</label>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                              <div class="input-group">
                                                <select class="form-control input-sm select2" id="cariId" name="CariId" onchange="getdata()">
                                                  <option value=""> - Pilih Nomor Nota</option>
                                                  @foreach ($data as $key => $value)
                                                  <option value="{{$value->p_id}}">{{$value->p_code}}</option>
                                                  @endforeach
                                                </select>
                                                <input type="hidden" name="id" id="id">
                                                <span class="input-group-btn">
                                                  <a href="#" class="btn btn-info btn-sm"><i class="fa fa-search" alt="search"></i></a>
                                                </span>
                                              </div>
                                            </div>

                                          </div>

                                          <div class="table-responsive">
                                            <table class="table tabelan table-hover table-bordered" id="data2">
                                              <thead>
                                                <tr>
                                                  <th width="5%">No</th>
                                                  <!-- <th>No Pengiriman</th> -->
                                                  <th>Item</th>
                                                  <th>QTY</th>
                                                  <th>Status</th>
                                                  <!-- <th>Aksi</th> -->
                                                </tr>
                                              </thead>
                                              <tbody id="showdata">

                                              </tbody>
                                            </table>
                                          </div>

                                          <div class="modal-footer">
                              <button type="button" class="minu mx btn btn-danger" >Batal</button>
                              <button class="btn final btn-primary minu mx" type="button" onclick="simpan('final')"> Simpan</button>
                            </div>

                                        </div>

                                      </div>
                                    </div>
                                     <!-- End div #alert-tab  -->

@endsection
@section("extra_scripts")
    <script type="text/javascript">
      $('.select2').select2();

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
        $("#id").val('');
        swal({
              title: 'Loading!',
              showCancelButton: false,
              showConfirmButton: false
            });
        var id = $('#cariId').val();
        var html = '';
        $.ajax({
          type: 'get',
          dataType: 'json',
          data: {id:id},
          url: baseUrl + '/inventory/p_hasilproduksi/getdata',
          success : function(result){
            $("#id").val(result[0].pd_pengiriman);
            for (var i = 0; i < result.length; i++) {

              if (result[i].pd_status_diterima == 'N') {
                var status = '<span class="badge badge-warning">Belum DIterima</span>';
                /*var button = '<td align="center"><button type="button" class="btn btn-info btn-sm" onclick="terima('+result[i].pd_id+')" name="button">Terima</button></td>';*/
              } else if (result[i].pd_status_diterima == 'Y') {
                var status = '<span class="badge badge-success">Sudah DIterima</span>';
                /*var button = '<td align="center"><button type="button" class="btn btn-info btn-sm" onclick="terima('+result[i].pd_id+')" disabled name="button">Terima</button></td>';*/
              }
              html += '<tr>'+
                      '<td>'+(i + 1)+'</td>'+
                      /*'<td>'+result[i].p_code+'</td>'+*/
                      '<td>'+result[i].i_name+'</td>'+
                      '<td>'+result[i].pd_qty+'</td>'+
                      '<td align="center">'+status+'</td>'+
                      /*button+*/
                      '</tr>';
            }
            $('#showdata').html(html);
            swal.close();
          }
        });
      }

      function simpan(){
        var id=$("#id").val();
        swal({
              title: 'Loading!',
              showCancelButton: false,
              showConfirmButton: false
            });
          $.ajax({
            type: 'get',
            data: {id:id},
            dataType: 'json',
            url: baseUrl + '/inventory/p_hasilproduksi/terima',
            success : function(result){
              if (result.status == 'berhasil') {
                swal("Success!", "Berhasil Diterima.", "success");
              }
              setTimeout(function(){
                window.location.reload();
              }, 500);
            }
          });
      }

      </script>
@endsection
