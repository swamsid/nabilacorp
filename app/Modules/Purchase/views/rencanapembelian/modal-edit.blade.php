<div class="modal fade" id="modal-edit" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="post" id="form-edit-plan">
      {{ csrf_field() }}
      <input type="hidden" name="idPlan" id="id_plan" class="form-control">
      <input type="hidden" name="p_status" id="p_status">
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Edit Rencana Pembelian</h4>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_edit"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">                          
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Kode Rencana Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblCodeEdit"></label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Rencana Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglEdit"></label>
              </div>  
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaffEdit"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Suplier</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplierEdit"></label>
              </div>
            </div>

          </div>
          
          <div class="table-responsive">
            <table id="tabel-edit" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%;">No</th>
                  <th width="35%;">Kode | Barang</th>                  
                  <th width="10%;">Stok Gudang</th>
                  <th width="10%;">Qty</th>
                  <th width="10%;">Qty Confirm</th>
                  <th width="10%;">Satuan</th>
                  <th width="15%;">Harga prev / satuan</th>                  
                </tr>
              </thead>
              <tbody id="div_item">

              </tbody>
            </table>
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="perbarui()" id="btn_update">Update</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>