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
                  <label for="s_status" class="control-label">Status</label>
                <select id="s_status" class="form-control">
                    <option value="terima">Terima</option>
                </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="update_s_status()">Submit</button>
            </div>
          </div>
    </div>
</div>