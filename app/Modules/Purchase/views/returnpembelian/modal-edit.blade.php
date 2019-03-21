<div class="modal fade" id="modal-edit" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="post" id="form-edit-return">
      {{ csrf_field() }}
      <input type="hidden" name="idReturn" id="id_return" class="form-control">
      <input type="hidden" name="idSup" id="id_sup" class="form-control">
      <input type="hidden" name="codeReturn" id="code_return" class="form-control">
      <input type="hidden" name="methodReturn" id="method_return" class="form-control">
      <input type="hidden" name="priceTotal" id="price_total" class="form-control">
      <input type="hidden" name="priceTotalRaw" id="price_total_raw" class="form-control">
      <input type="hidden" name="priceTotalNett" id="price_total_nett" class="form-control">
      <input type="hidden" name="priceResult" id="price_result" class="form-control">
      <input type="hidden" name="idStaffEdit" id="id_staff_edit" class="form-control">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Edit Return Pembelian</h4>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_edit"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Nota Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblNotaPembelianEdit"></label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Kode Return Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblCodeReturnEdit"></label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Return Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglReturnEdit"></label>
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
              <label class="tebal">Supplier</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplierEdit"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Metode</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblMetodeEdit"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total Nilai Return</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTotalReturnEdit"></label>
              </div>
            </div>

          </div>
          
          <div class="table-responsive">
            <table id="tabel-edit" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%;">No</th>
                  <th width="30%;">Kode | Barang</th>
                  <th width="10%">Qty</th>
                  <th width="10%">Satuan</th>
                  <th width="15%">Harga</th>
                  <th width="15%">Total</th>
                  <th width="10%">Stok</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody id="div_item">

              </tbody>
            </table>
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitEdit()" id="btn_update">Update</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>