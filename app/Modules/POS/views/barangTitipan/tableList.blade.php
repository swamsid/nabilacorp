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
                <button class="btn btn-info btn-sm btn-flat" type="button" onclick="resetData()">
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
        


      </div>
  </div>



           

            <div class="table-responsive">
              <table class="table table-stripped tabelan table-bordered table-hover dt-responsive data-table tableListToko" id="tableListToko" width="100%">
               <thead align="right">
                <tr>
                 <th width="10%">Tanggal</th>
                 <th width="10%">No Nota</th>
                 <th width="15%">Supplier</th>
                 <th width="10%">Keterangan</th>  
                 <th width="10%">Total</th>                      
                 <th width="15%">Action</th>
                </tr>
               </thead> 
               <tbody>                
               </tbody>
              </table>
            </div>
                <!-- End Modal Proses -->
          <script type="text/javascript">
 function cari(){
  table();
 }

dateAwal();
function dateAwal(){
      var d = new Date();
      d.setDate(d.getDate()-7);

      /*d.toLocaleString();*/
      $('#tanggal1').datepicker({
            format:"dd-mm-yyyy",        
            autoclose: true,
      }).datepicker( "setDate", d);
      $('#tanggal2').datepicker({
            format:"dd-mm-yyyy",        
            autoclose: true,
      }).datepicker( "setDate", new Date());
}


function resetData(){  
  dateAwal();
  table();
}
  

                                                
    function editPenjualan(s_id,s_note,s_machine,s_date,s_duedate,s_finishdate,s_gross,s_disc_percent,s_disc_value,s_grand,s_ongkir,s_bulat,s_net,s_bayar,s_kembalian,s_customer,c_name,s_status,chek) {

            $('.reset').val('');
            $('#s_created_by').val('{{Auth::user()->m_name}}')
            $('#s_id').val(s_id);
            $('#s_status').val(s_status);
            $('#s_date').val(s_date);
            $('#s_note').val(s_note);            
            $('#s_machine').val(s_machine);
            $('#s_gross').val(s_gross);        
            if(s_disc_value!='' && s_disc_value!=0 ){
              s_disc_value=SetFormRupiah(s_disc_value)
            }
            $('#discountRp').val(s_disc_value);
            if(s_disc_percent!='' && s_disc_percent!=0 ){
              s_disc_percent=SetFormRupiah(s_disc_percent)
            }
            $('#discountP').val(s_disc_percent);
            $('#discount').val(SetFormRupiah(s_disc_value+s_disc_percent));
            
            $('#vbiaya_kirim').val(s_ongkir);            
            $('#biaya_kirim').val(s_ongkir);            
            $('#grand').val(s_grand);
            $('#grand_biaya').val(s_net);
            $('#s_bulat').val(s_bulat);
            $('#akumulasiTotal').val(s_net);
            $('#penjualan').tab('show');
            $('#customer').val(c_name)
            $('#s_customer').val(s_customer)
            $('#totalBayar').val(s_bayar)
            $('#kembalian').val(s_kembalian)

                if(parseInt(chek)>0){
                $('.perbarui').css('display','');
                $('.terima').css('display','none');
            }
            if(parseInt(chek)<0){
              $('.perbarui').css('display','none');
              $('.terima').css('display','');

            }
            
            detail(s_id);

    }

          </script>