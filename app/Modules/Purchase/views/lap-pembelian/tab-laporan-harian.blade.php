<div id="harian-tab" class="tab-pane fade">
  <div class="panel-body">
    <div class="row">

      <div class="col-md-2 col-sm-3 col-xs-12">
        <label class="tebal">Periode Laporan</label>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
          <div class="input-daterange input-group">
            <input class="form-control input-sm datepicker1" name="tgl_awal_belanjaharian" type="text" id="tgl_awal_belanjaharian">
            <span class="input-group-addon">-</span>
            <input class="input-sm form-control datepicker2" name="tgl_akhir_belanjaharian" id="tgl_akhir_belanjaharian" type="text" value="">
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="search_purchasingharian()">
          <strong>
            <i class="fa fa-search" aria-hidden="true"></i>
          </strong>
        </button>
        <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refresh_purchasingharian()">
          <strong>
            <i class="fa fa-undo" aria-hidden="true"></i>
          </strong>
        </button>
      </div>

      <div id="" class="col-md-3 col-sm-3 col-xs-12" align="right">
        <button class="btn btn-primary" onclick="print_lap_belanja_harian()"><i class="fa fa-print"></i>  Print</button>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabel_d_purchaseharian">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Staff</th>
                <th>Peminta</th>
                <th>Keperluan</th>
                <th>Tanggal</th>
                <th>Harga Nett</th>
              </tr>
            </thead>

            <tbody>
            </tbody>
        </table> 
        </div>
      </div>
                
    </div>
  </div>
</div>