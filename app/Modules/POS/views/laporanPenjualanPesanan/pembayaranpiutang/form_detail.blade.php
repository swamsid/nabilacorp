<div class="modal fade" id="form_detail" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="get" action="#" id="form_m_price">
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Detail Pembayaran Piutang</h4>
          </div>

          <div class="modal-body">

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
                                        
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Kode Pembayaran</label>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <label id="r_code"></label>
                </div>
              </div>
                                        
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Ref</label>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <label id="r_ref"></label>
                </div>
              </div>

              
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Tanggal Piutang</label>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <label id="r_date"></label>
                </div>
              </div>
                    
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Tanggal Jatuh Tempo</label>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <label id="r_duedate"></label>
                </div>
              </div>
                    
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Jumlah Piutang</label>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">  
                  <label id="r_value"></label>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Jumlah Piutang Terbayar</label>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                  <input type="hidden" name="m_pid" id="m_pid">
                <div class="form-group">  
                  <label id='r_pay' ></label>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Sisa Pembayaran</label>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">  

                  <p id='r_outstanding' ></p>

                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="container-fluid" style="background: white">
                  
                    <h3>Daftar Pembayaran</h3>
                    <table class="table tabelan table-bordered table-striped table-hover data-table">
                      <thead>
                        <tr>
                          <th>Tanggal?</th>
                          <th>Bayar?</th>
                        </tr>
                      </thead>
                      <tbody class="list_d_receivable_dt">
                            
                          </tr>
                          
                      </tbody>
                    </table>
                    <!-- <div class="list-group" id="list_d_receivable_dt"></div> -->
                </div>
              </div>

              
            </div>
          
          </div>
      
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            
          </div>
        </div>
      </form>   
    </div>
</div>