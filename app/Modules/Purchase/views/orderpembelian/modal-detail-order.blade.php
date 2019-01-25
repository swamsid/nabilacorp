<div class="modal fade" id="modal-confirm-order" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="get" id="form-confirm-order">
      {{ csrf_field() }}
      <input type="hidden" name="idOrder" id="id_order">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Konfirmasi Order Pembelian</h4>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_order_"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">                          
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Kode Order Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblCodeOrder"></label>
              </div>  
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblOrderDate"></label>
              </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaffOrder"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Suplier</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplierOrder"></label>
              </div>
            </div>
          </div>
          
          <div class="table-responsive ">
            <table id="tabel-order-confirm" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%;">No</th>
                  <th width="20%;">Kode | Barang</th>
                  <th width="5%;">Qty</th>
                  <th width="5%;">Qty Confirm</th>
                  <th width="10%;">Satuan</th>
                  {{-- <th width="15%;">Harga prev</th> --}}
                  <th width="15%;">Harga Satuan</th>
                  <th class="15%">Harga Total</th>
                  {{-- <th width="5%;">Stok Gudang</th> --}}
                </tr>
              </thead>
              <tbody id="div_item" class="drop_here">

              </tbody>
            </table>
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>