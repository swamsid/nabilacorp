<div id="alert-tab" class="tab-pane fade in active">
    <div class="row">



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
                <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="resetData()">
                  <strong>
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button" onclick="resetData()">
                  <strong>
                    <i class="fa fa-undo" aria-hidden="true"></i>
                  </strong>
                </button>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12" align="right">
                  <button type="button" class="btn btn-box-tool" onclick="tambah()">
                        <i class="fa fa fa-plus"></i> &nbsp;&nbsp;Tambah Data
                  </button>
              </div>
        


      </div>
  </div>


   
    <div class="col-md-12 col-sm-12 col-xs-12">                          
      <div class="table-responsive">
        <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tablePlan">
              <thead>
                  <tr>                    
                    <th>Tgl Pembuatan</th>     
                    <th>Kode rencana</th>
                    <th>Staff</th>
                    <th>Suplier</th>                                      
                    <th>Status</th>
                    <th>Tgl Setujui</th>
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

  function tambah(){    
    window.location.href = baseUrl +"/purchasing/rencanapembelian/create";
  }


var statusDetail='all';

 function detailPlan(id,code,supplier,date,statusLabel,mem) 
  {    

    $.ajax({
      url : baseUrl + "/purcahse-plan/get-detail-plan/"+id+"/"+statusDetail,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        //ambil data ke json->modal

      
      if (statusLabel == "WT") 
      {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
      }
      else if (statusLabel == "PE")
      {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
      }
      else
      {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
      }


        $('#txt_span_status').text($spanTxt);
        $("#txt_span_status").addClass('label'+' '+$spanClass);
        $('#lblCodePlan').text(code);
        $('#lblTglPlan').text(date);        
        $('#lblSupplier').text(supplier);
        $('#lblStaff').text(mem);
      
        //loop data
        Object.keys(data.data_isi).forEach(function(){

          $('#tabel-detail').append('<tr class="tbl_modal_detail_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td class="alignAngka">'+data.data_isi[key-1].s_qty+'</td>'
                          +'<td class="alignAngka">'+data.data_isi[key-1].ppdt_qty+'</td>'
                          +'<td class="alignAngka">'+data.data_isi[key-1].ppdt_qtyconfirm+'</td>'                          
                          +'<td>'+data.data_isi[key-1].s_name+'</td>'
                          +'</tr>');
          key++;
        });
        $('#modal-detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }


function editPlan(id,code,supplier,date,statusLabel,mem) 
  {
    $.ajax({
      url : baseUrl + "/purcahse-plan/get-edit-plan/"+id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        //ambil data ke json->modal

      
      if (statusLabel == "WT") 
      {
        $spanTxt = 'Waiting';
        $spanClass = 'label-info';
      }
      else if (statusLabel == "PE")
      {
        $spanTxt = 'Dapat Diedit';
        $spanClass = 'label-warning';
      }
      else
      {
        $spanTxt = 'Di setujui';
        $spanClass = 'label-success';
      }
        $('#lblStaffEdit').text(mem);
        $('#txt_span_status_edit').text($spanTxt);
        $("#txt_span_status_edit").addClass('label'+' '+$spanClass);
        $('#lblCodeEdit').text(code);
        $('#lblTglEdit').text(date);        
        $('#lblSupplierEdit').text(supplier);
        $('#id_plan').val(id);
        $('#p_status').val(statusLabel);        
        var s_stock=0;
        Object.keys(data.data_isi).forEach(function(){
          if(data.data_isi[key-1].s_qty!=null){
            s_stock=data.data_isi[key-1].s_qty;
          }
          $('#tabel-edit').append('<tr class="tbl_modal_edit_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td class="alignAngka">'+s_stock+'</td>'
                          +'<td><input type="hidden" value="'+data.data_isi[key-1].ppdt_qty+'" name="oldppdt_qty[]" class="form-control numberinput input-sm alignAngka" autocomplete="off" />'
                          +'<input type="text" value="'+data.data_isi[key-1].ppdt_qty+'" name="ppdt_qty[]" class="form-control numberinput input-sm alignAngka" autocomplete="off" />'
                          +'<input type="hidden" value="'+data.data_isi[key-1].ppdt_detailid+'" name="ppdt_detailid[]" class="form-control"/></td>'                          
                          +'<td class="alignAngka">'+data.data_isi[key-1].ppdt_qtyconfirm+'</td>'
                          +'<td>'+data.data_isi[key-1].s_name
                          +'<input style="width:100%" type="hidden" name="ppdt_pruchaseplan[]" value="'+data.data_isi[key-1].ppdt_pruchaseplan+'"></td>'
                          +'<td class="alignAngka">'+SetFormRupiah(data.data_isi[key-1].ppdt_prevcost)+'</td>'
                          +'</tr>');
          key++;
        });
          
        $('#modal-edit').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function perbarui(){
    var formPos=$('#form-edit-plan').serialize()
     $.ajax({
      url : baseUrl + "/purcahse-plan/update-plan",
      type: 'get',
      dataType: "JSON",
      data    :  formPos,         
      success: function(response)
      {
        if(response.sukses='sukses'){
              iziToast.success({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Data berhasil diperbarui.",
              });
              tablex.ajax.reload();
              $('#modal-edit').modal('hide');
        }
       
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });

  }

  function deletePlan(id){
    iziToast.show({
      color: 'red',
      title: 'Peringatan',
      message: 'Apakah anda yakin!',
      position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      progressBarColor: 'rgb(0, 255, 184)',
      buttons: [
        [
          '<button>Ok</button>',
          function (instance, toast) {
            instance.hide({
              transitionOut: 'fadeOutUp'
            }, toast);
    $.ajax({
      url : baseUrl + "/purcahse-plan/get-delete-plan/"+id,
      type: 'GET',
      success : function(response){
        if (response.status=='sukses') {
          iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: '', 
                          message: 'Data berhasil di hapus.'});
          tablex.ajax.reload();
        }else{
          iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Data gagal di hapus.'});
        }
      }
    });
    }
        ],
        [
          '<button>Close</button>',
           function (instance, toast) {
            instance.hide({
              transitionOut: 'fadeOutUp'
            }, toast);
          }
        ]
      ]
    }); 
  }
  </script>