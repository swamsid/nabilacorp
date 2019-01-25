<div class="modal fade" id="modal_tambah_data" role="dialog">
  <div class="modal-dialog" style="width: 50%;margin: auto;">
    
    <form method="post" id="form-lembur" name="formLembur">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Tambah Data Lembur</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Pilih Jenis Pegawai</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group divjenis">
                <select class="form-control input-sm select2 jenis_pegawai" id="jenis_pegawai" name="jenis_pegawai" style="width: 100% !important;">
                  <option value="">Pilih Jenis Pegawai</option>
                  <option value="man">Management</option>
                  <option value="pro">Produksi</option>
                </select>
              </div>  
            </div>

            <div id="appending">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Tanggal Lembur</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input id="tgl_lembur" class="form-control input-sm datepicker2 " name="tglLembur" type="text" value="{{ date('d-m-Y') }}">
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
                  <input type="text" class="form-control input-sm timepicker" name="jamAwal" id="jam_awal">
                </div>  
              </div>

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <input type="text" class="form-control input-sm timepicker" name="jamAkhir" id="jam_akhir">
                </div>  
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Divisi</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group divDivisi">
                  <select class="form-control input-sm select2 kode_divisi" id="kode_divisi" name="kodeDivisi" style="width: 100% !important;" disabled="">
                  </select>
                </div>  
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Jabatan</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group divJabatan">
                  <select class="form-control input-sm select2 kode_jabatan" id="kode_jabatan" name="kodeJabatan" style="width: 100% !important;" disabled="">
                  </select>
                </div>  
              </div>
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Nama Pegawai</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group divPegawai">
                  <select class="form-control input-sm select2 pegawai" id="pegawai" name="pegawai" style="width: 100% !important;" disabled="">
                  </select>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="tebal">Keperluan</label>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <input type="text" name="keperluan" id="keperluan" class="form-control input-sm">
                  <input type="hidden" name="namapeg" id="namapeg" readonly="" class="form-control input-sm">
                </div>
              </div>
            </div>
                        
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitLembur()" id="btn_simpan">Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->

  </div>

  </div>
</div>