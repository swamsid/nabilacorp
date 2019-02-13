<div class="modal fade" id="modal_alter_status" role="dialog">
    <div class="modal-dialog">
      
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Pilih Untuk Merubah Status</h4>
            </div>
            <div class="modal-body">

              <div>
                <div class="form-horizontal">
                  <label for="spr_status" class="control-label">Status</label>
                <select id="spr_status" class="form-control">
                    <option value="AP">Disetujui</option>
                    <option value="NAP">Tidak Disetujui</option>
                </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="update_spr_status()">Submit</button>
            </div>
          </div>
    </div>
</div>