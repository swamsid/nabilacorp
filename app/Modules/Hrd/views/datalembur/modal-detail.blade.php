<div class="modal fade" id="modal_detail_data" role="dialog">
  <div class="modal-dialog" style="width: 50%;margin: auto;">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #e77c38;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: white;">Detail Data Lembur</h4>
      </div>

      <div class="modal-body">
        <form method="post" id="form-lembur-detail" name="formLemburDetail">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Pilih Jenis Pegawai</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" name="jenis_peg_det" id="jenis_peg_det" class="form-control input-sm" readonly>
              </div>
            </div>

            <div id="appending">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Tanggal Lembur</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" name="tgl_lembur_det" id="tgl_lembur_det" class="form-control input-sm" readonly>
                </div>  
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <label>Jam Mulai</label>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <label>Jam Akhir</label>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <input type="text" name="jam_awal_det" id="jam_awal_det" class="form-control input-sm" readonly>
                </div>  
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <input type="text" name="jam_akhir_det" id="jam_akhir_det" class="form-control input-sm" readonly>
                </div>  
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Divisi</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" name="divisi_det" id="divisi_det" class="form-control input-sm" readonly>
                </div>  
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Jabatan</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" name="jabatan_det" id="jabatan_det" class="form-control input-sm" readonly>
                </div>  
              </div>
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Nama Pegawai</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" name="pegawai_det" id="pegawai_det" class="form-control input-sm" readonly>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Keperluan</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" name="keperluan_det" id="keperluan_det" class="form-control input-sm" readonly>
                </div>
              </div>
            </div>
                        
          </div>
        </form>

      </div>
  
      <div class="modal-footer" style="border-top: none;">
        <div id="append-detail"></div>
      </div>

    </div>
    <!-- /Modal content-->
  </div>

  </div>
</div>