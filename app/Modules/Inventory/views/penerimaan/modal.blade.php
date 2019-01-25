<div class="modal fade" id="modalTerima" role="dialog">
  <div class="modal-dialog" style="width: 50%;margin: auto;">
      
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title" style="color: white;">Form Terima Hasil Produksi</h4>
          </div>

          <div class="modal-body">
            <form action="#" method="POST" id="update-terima-produk">
              {{ csrf_field() }}

              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">No. Nota</label>
              </div>
              
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="noNotaMasuk" id="noNotaMasuk" autocomplete="off" readonly="" type="text">
                  <input class="form-control" name="detailId" id="detailId" type="hidden">
                  <input class="form-control" name="doId" id="doId" type="hidden">
                  <input class="form-control" name="prdtId" id="prdtId" type="hidden">
                  <input class="form-control" name="prdtDetailId" id="prdtDetailId" type="hidden">
                  <input class="form-control" name="idItemMasuk" id="idItemMasuk" type="hidden">
                </div>
              </div>
                
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="form-control input-sm ui-autocomplete-input" name="namaItemMasuk" id="namaItemMasuk" autocomplete="off" readonly="" type="text">
                </div>
              </div>

              {{-- <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Tanggal Terima</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input class="form-control input-sm datepicker2" id="date" name="tglMasuk" type="text" value="{{ date('d-m-Y') }}">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Jam Terima</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input class="form-control input-sm timepicker" name="jamMasuk" type="text" id="time" value="{{ date('h:i:s') }}">
                </div>
              </div> --}}

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Qty Masuk</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                 <input style="text-align: right;" class="form-control input-sm numberinput" name="qtyMasuk" type="number" readonly id="qtyMasuk">
                 <input style="text-align: right;" class="form-control input-sm numberinput" name="qtyMasukPrev" type="hidden" value="0">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Qty Diterima</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                 <input style="text-align: right;" class="form-control input-sm" name="qtyDiterima" id="qtyDiterima" type="number" onkeyup="bandingQty()">
                </div>
              </div>

            </div>
            </form>
            
          </div>
                            
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn-simpan" onclick="save_update()">Simpan Data</button>
          </div>
        </div>

  </div>
</div>