<div class="modal fade" id="form_payment" role="dialog">
  <div class="modal-dialog">
      
    <form method="get" action="#" id="form_m_price">
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Form Manajemen Harga</h4>
          </div>

          <div class="modal-body">

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
                                        
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="tebal">Kode Pembayaran</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <input type="hidden" name="rd_receivable" id="rd_receivable">
                  <input type="text" class="form-control input-sm" readonly name="r_code" id='r_code' readonly>
                </div>
              </div>
                                        
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="tebal">Ref</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <input type="hidden" name="m_pid" id="m_pid">
                  <input type="text" class="form-control input-sm" readonly name="r_ref" id='r_ref' >
                </div>
              </div>
                    
              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="tebal">Jumlah Piutang</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <input type="hidden" name="m_pid" id="m_pid">
                  <input type="text" class="form-control input-sm" readonly name="r_value" id='r_value' >
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="tebal">Tanggal Pembayaran</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm" name="rd_datepay" id='rd_datepay' >
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="tebal">Jumlah Pembayaran</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm" name="rd_value" id='rd_value' >
                </div>
              </div>



              <div class="col-md-6 col-sm-6 col-xs-12">
                <label class="tebal">Jumlah Piutang Terbayar</label>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <input type="hidden" name="m_pid" id="m_pid">
                  <input type="text" class="form-control input-sm" readonly name="r_pay" id='r_pay' >
                </div>
              </div>

              <div class="col-md-4 col-sm-0 col-xs-0" style="height: 45px;">
                
              </div>


              
            </div>
          
          </div>
      
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id='insert_m_price_btn' onclick="insert_d_receivable_dt()">Simpan Data</button>
          </div>
        </div>
      </form>   
    </div>
</div>