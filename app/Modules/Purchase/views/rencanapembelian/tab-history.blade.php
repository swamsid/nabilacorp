<div id="note-tab" class="tab-pane fade">
  <div class="panel-body">
    <div class="row">

      <div class="col-md-2 col-sm-3 col-xs-12">
        <label class="tebal">Tanggal Rencana</label>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
          <div class="input-daterange input-group">
            <input id="tanggal1" class="form-control input-sm datepicker1" name="iTanggal1" type="text">
            <span class="input-group-addon">-</span>
            <input id="tanggal2" class="input-sm form-control datepicker2" name="iTanggal2" type="text" value="{{ date('d-m-Y') }}">
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"  onclick="lihatHistorybyTgl()">
          <strong>
            <i class="fa fa-search" aria-hidden="true"></i>
          </strong>
        </button>
        <button class="btn btn-info btn-sm btn-flat refresh-data-history" type="button">
          <strong>
            <i class="fa fa-undo" aria-hidden="true"></i>
          </strong>
        </button>
      </div>

      <div class="col-md-3 col-sm-3 col-xs-12" align="right">
        <select name="tampilData" id="tampil_data" class="form-control input-sm">
          <option value="wait" class="form-control">Tampilkan Data : Waiting</option>
          <option value="edit" class="form-control">Tampilkan Data : Dapat diedit</option>
          <option value="confirm" class="form-control">Tampilkan Data : Disetujui</option>
        </select>
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-history">
            <thead>
              <tr>
                <th class="wd-5p">No</th>
                <th class="wd-15p">Id Rencana</th>
                <th class="wd-15p">Nama Barang</th>
                <th class="wd-10p">Satuan</th>
                <th class="wd-15p">Supplier</th>
                <th class="wd-10p">Tgl Pemintaan</th>
                <th class="wd-5p">Qty</th>
                <th class="wd-10p">Tgl Confirm</th>
                <th class="wd-5p">Qty Confirm</th>
                <th class="wd-10p">Status</th>
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