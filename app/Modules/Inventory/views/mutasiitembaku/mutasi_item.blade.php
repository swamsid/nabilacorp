<div id="gudangtogudang" class="tab-pane fade in active">

  <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12">



              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal</label>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <div class="input-daterange input-group">
                    <input id="tanggal1" class="form-control input-sm datepicker2" name="tanggal1" type="text">
                    <span class="input-group-addon">-</span>
                    <input id="tanggal2"" class="input-sm form-control datepicker2" name="tanggal2" type="text">
                  </div>
                </div>
              </div>


              <div class="col-md-3 col-sm-6 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="cari()">
                  <strong>
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button">
                  <strong>
                    <i class="fa fa-undo" aria-hidden="true"></i>
                  </strong>
                </button>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12" align="right">
                  <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" onclick="tambah()">
                        <i class="fa fa fa-plus"></i> &nbsp;&nbsp;Tambah Data
                  </button>
              </div>


        <div class="table-responsive" style="margin-top: 50px;">
          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="dataItem">
            <thead>
              <tr>
                <th>Kode Mutasi</th>
                <th>Tanggal Mutasi</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>

      </div>
  </div>
</div>

<script type="text/javascript">

var tablex;
setTimeout(function () {
    table();
      }, 1500);
function cari(){
  table();
}
function table(){

  $('#dataItem').dataTable().fnDestroy();
   tablex = $("#dataItem").DataTable({
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("/penjualan/mutasi-item/data-mutasi") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",
                    "type"  :"toko",
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    },
              },
            columns: [
            {data: 'mi_code', name: 'mi_code'},
            {data: 'mi_date', name: 'mi_date'},
            {data: 'mi_keterangan', name: 'mi_keterangan'},
            {data: 'action', name: 'action'},

            ],
             'columnDefs': [

               {
                    "targets": 3,
                    "className": "text-center",
               }
               ],
            //responsive: true,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],

             "rowCallback": function( row, data, index ) {



                if (data['s_status']=='draft') {
                     $('td', row).addClass('warning');
                }
              }

    });
}

function detailMutasi(id,tgl,code,ket){
    $('#mi_id').val(id);
    $('#mi_date').val(tgl);
    $('#mi_code').val(code);
    $('#mi_keterangan').val(ket);
    $('#from').tab('show');


}
function tambah(){
  $('#from').tab('show');
  btnBatal();
}
function editMutasi(id,tgl,code,ket){


    $('#mi_id').val(id);
    $('#mi_date').val(tgl);
    $('#mi_code').val(code);
    $('#mi_keterangan').val(ket);
    $('#from').tab('show');


       $.ajax({
          url     :  baseUrl+'/penjualan/mutasi-item/mutasi-item-detail/'+id,
          type    : 'GET',
          data: {
                    "_token": "{{ csrf_token() }}",
                    "type" :'Bahan',
            },
          success : function(response){
            dBahan.html('');
            dBahan.append(response);
          }

      });


      $.ajax({
          url     :  baseUrl+'/penjualan/mutasi-item/mutasi-item-detail/'+id,
          type    : 'GET',
          data: {
                  "_token": "{{ csrf_token() }}",
                  "type" :'Hasil',
            },
          success : function(response){
            dHasil.html('');
            dHasil.append(response);
          }

      });
$('#simpan').css('display','none');
$('#perbarui').css('display','');
$('#perbarui').attr('disabled',false);



}


function deleteMutasi(id){
     $.ajax({
          url     :  baseUrl+'/penjualan/mutasi-item/destroy/'+id,
          type    : 'GET',
          dataType: 'json',
          success : function(response){
                    if(response.status=='sukses'){
                        $('.btn-disabled').removeAttr('disabled');
                        tablex.ajax.reload();
                        iziToast.success({
                        position: "center",
                        title: '',
                        timeout: 1000,
                        message: 'Data berhasil dihapus.'});

                         btnBatal();
                        }
                       else if(response.status=='gagal'){
                      $('.btn-disabled').removeAttr('disabled');
                        iziToast.error({
                          position:'topRight',
                          timeout: 2000,
                          title: '',
                          message: response.data,
                        });



                    }
          }
      });
}

</script>
