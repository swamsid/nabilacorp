 <div id="gudangtogudang" class="tab-pane fade in active">

<div class="row">
   
      <div class="col-md-12 col-sm-12 col-xs-12">
        

            
              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal</label>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <div class="input-daterange input-group">
                    <input id="tanggal1" class="form-control input-sm tanggal1" name="tanggal1" type="text">
                    <span class="input-group-addon">-</span>
                    <input id="tanggal2" class="input-sm form-control tanggal2" name="tanggal2" type="text">
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
                <th>Kode Hasil Produksi</th>
                <th>Tanggal Produksi</th>
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

  function btnBatal(){

    $('#pr_id').val('');
    $('#pr_date').val('{{date('d-m-Y')}}');
    $('#pr_code').val("Auto");
    $('#pr_note').val('');
            /*dataDetail.html('');      */     
            tamp=[];                                    
            hapus =[];
            hapusDt =[];
$('#simpan').css('display','');
$('#perbarui').css('display','none');
  }
function tambah(){
  $('#from').tab('show');
  btnBatal();
}

var tablex;
setTimeout(function () { 
    table();
      }, 1500);

function cari(){
  table()
}

function table(){
         $('#dataItem').dataTable().fnDestroy();
    tablex = $("#dataItem").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("/produksi/hasil-produksi/data") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",
                    "type"  :"toko",                    
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    },
              },
            columns: [                            
            {data: 'pr_code', name: 'pr_code'},
            {data: 'pr_date', name: 'pr_date'},   
            {data: 'pr_note', name: 'pr_note'},
            {data: 'action', name: 'action'},
           
            ],
             'columnDefs': [
                
               {
                    "targets": 3,
                    "className": "text-center",
               }
               ],
            /*"order": [[ 2, "desc" ]],*/
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
function edit(pr_id,pr_code,pr_date,pr_note){
  $('#pr_id').val(pr_id);
  $('#pr_code').val(pr_code);
  $('#pr_date').val(pr_date);
  $('#pr_note').val(pr_note);



       $.ajax({
          url     :  baseUrl+'/produksi/hasil-produksi/edit-detail/'+pr_id+'/edit',
          type    : 'GET',  
          data    : {
                        "_token": "{{ csrf_token() }}",
                        "type" :'Bahan',
                    },
          success : function(response){              
            dataDetail.html(''); 
            dataDetail.append(response); 
            $('#from').tab('show'); 
            $('#simpan').css('display','none');
            $('#perbarui').css('display','');
            $('#perbarui').attr('disabled',false);
             validationForm();
          }
          
      });

}
function detail(pr_id,pr_code,pr_date,pr_note){
      $('#lCode').text(pr_code);
      $('#lTgl').text(pr_date);
      $('#lNote').text(pr_note);
    $.ajax({
          url     :  baseUrl+'/produksi/hasil-produksi/detail/'+pr_id,
          type    : 'GET',  
          data    : {
                        "_token": "{{ csrf_token() }}",
                        "type" :'Bahan',
                    },
          success : function(response){              
            $('#div_item').html(''); 
            $('#div_item').append(response); 
            $('#modal-detail').modal('show');
            $('#simpan').css('display','none');
            $('#perbarui').css('display','');
            $('#perbarui').attr('disabled',false);
             validationForm();
          }
          
      });


}

function deleteProduksi(id){
    $.ajax({
          url     :  baseUrl+'/produksi/hasil-produksi/destroy/'+id,
          type    : 'GET',           
          dataType: 'json',
          success : function(response){                        
                    if(response.status=='sukses'){
                        dataDetail.html('');           
                        tamp=[];                                    
                        hapus =[];
                        hapusDt =[];                    
                        $('.btn-disabled').removeAttr('disabled');
                        tablex.ajax.reload();                                                                        
                        iziToast.success({
                        position: "center",
                        title: '', 
                        timeout: 1000,
                        message: 'Data berhasil disimpan.'});
                         
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
