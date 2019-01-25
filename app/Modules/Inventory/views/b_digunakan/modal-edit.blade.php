<div class="modal fade" id="modal-edit" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="post" id="form-edit-pakai" name="formEditPakai">
      {{ csrf_field() }}
      <input type="hidden" name="idPakaiEdit" id="id_pakai_edit" class="form-control">
      <input type="hidden" name="idStaffEdit" id="id_staff_edit" class="form-control">
      <input type="hidden" name="codePakaiEdit" id="code_pakai_edit" class="form-control">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Edit Pemakaian Barang Gudang</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Gudang</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblGudangEdit"></label>
              </div>  
            </div>
            
            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Kode Pemakaian</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblKodePakaiEdit"></label>
              </div>  
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Pemakaian</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglPakaiEdit"></label>
              </div>  
            </div>
            
            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Staff</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaffEdit"></label>
              </div>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Peminta</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblPemintaEdit"></label>
              </div>
            </div>

            <div class="col-md-2 col-sm-12 col-xs-12">
              <label class="tebal">Keperluan</label>
            </div>

            <div class="col-md-4 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblKeperluanEdit"></label>
              </div>
            </div>

          </div>
          
          <div class="table-responsive">
            <table id="tabel-edit" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%;">No</th>
                  <th width="30%;">Kode | Barang</th>
                  <th width="15%">Qty</th>
                  <th width="10%">Satuan</th>
                  <th width="15%">Stok</th>
                  <th width="20%">Keterangan</th>
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