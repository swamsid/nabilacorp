<div class="modal fade" id="modal_tambah" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="get" action="#" id="form_m_price">
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Form Manajemen Harga</h4>
          </div>

          <div class="modal-body">

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
                                        
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Kode Item</label>
              </div>
              <div class="col-md-4 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="hidden" name="m_pid" id="m_pid">
                  <input type="text" class="form-control input-sm" readonly="" maxlength="10" name="i_code" id='i_code' readonly>
                </div>
              </div>

              <div class="col-md-4 col-sm-0 col-xs-0" style="height: 45px;">
                
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item</label>
              </div>

              <div class="col-md-4 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm datepicker2"; name="i_name" id='i_name' readonly>
                </div>
              </div>

              
            </div>
          
            <div class="table-responsive">
              <table class="table tabelan table-bordered table-hover" id="data2">
                <thead>
                  <tr>
                    <th>Harga A</th>
                    <th>Harga B</th>
                    <th>Harga C</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input type="text" class="form-control" name="m_pbuy1" id="m_pbuy1">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="m_pbuy2" id="m_pbuy2">
                    </td>
                    <td>
                      <input type="text" class="form-control" name="m_pbuy3" id="m_pbuy3">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            
          </div>
      
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id='insert_m_price_btn'>Simpan Data</button>
          </div>
        </div>
      </form>   
    </div>
</div>