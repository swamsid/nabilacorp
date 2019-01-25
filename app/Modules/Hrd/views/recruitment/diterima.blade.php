<div class="modal fade" id="diterima" role="dialog">
  <div class="modal-dialog">    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #e77c38;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: white;">Pengaturan Calon Karyawan</h4>
      </div>

      <div class="modal-body">
        
        <div class="row">
          <form method="POST" id="form-peg-baru" name="formPegBaru">
          {{ csrf_field() }}
            <div class="col-md-3 col-sm-3 col-xs-12">
              <label>Nama Pegawai</label>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control input-sm" readonly="" name="tr_nama" id="tr_nama">
                <input type="hidden" class="form-control input-sm" readonly="" name="tr_idlamar" id="tr_idlamar">
                <input type="hidden" class="form-control input-sm" readonly="" name="tr_idpegman" id="tr_idpegman">
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
              <label>Tanggal Masuk Kerja</label>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control input-sm datepicker2" readonly="" style="cursor: pointer;" name="tr_tgl" id="tr_tgl">
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
              <label>Divisi</label>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control input-sm" name="tr_divisi" id="tr_divisi" readonly>
                <input type="hidden" class="form-control input-sm" name="tr_divisiid" id="tr_divisiid" readonly>
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
              <label>Posisi</label>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control input-sm" name="tr_posisi" id="tr_posisi" readonly>
                <input type="hidden" class="form-control input-sm" name="tr_posisiid" id="tr_posisiid" readonly>
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
              <label>Hari Kerja</label>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <select class="form-control input-sm" id="tr_hariawal" name="tr_hariawal">
                  <option value="Senin"> Senin </option>
                  <option value="Selasa"> Selasa </option>
                  <option value="Rabu"> Rabu </option>
                  <option value="Kamis"> Kamis </option>
                  <option value="Jumat"> Jumat </option>
                  <option value="Sabtu"> Sabtu </option>
                </select> 
              </div>
            </div>

            <div class="col-md-1 col-sm-1 col-xs-1">
              <div class="form-group">
               s/d 
              </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-4">
              <div class="form-group">
                <select class="form-control input-sm" id="tr_hariakhir" name="tr_hariakhir">
                  <option value="Senin"> Senin </option>
                  <option value="Selasa"> Selasa </option>
                  <option value="Rabu"> Rabu </option>
                  <option value="Kamis"> Kamis </option>
                  <option value="Jumat"> Jumat </option>
                  <option value="Sabtu"> Sabtu </option>
                </select>
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12">
              <label>Shift</label>
            </div>

            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="form-group">
                <select class="form-control input-sm" id="tr_shift" name="tr_shift"></select> 
              </div>
            </div>
          </form>
        </div>

      </div>
  
      <div class="modal-footer" style="border-top: none;">
        <button type="button" class="btn btn-info" onclick="simpanPegawaiBaru()">Simpan</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>

    </div>
    <!-- /Modal content-->
  </div>

</div>