<div id="index-tab" class="tab-pane fade in active">
  <div class="panel-body">
    <div class="row">

        <div class="col-md-2 col-sm-3 col-xs-12">
          <label class="tebal">Tanggal Return</label>
        </div>

        <div class="col-md-4 col-sm-7 col-xs-12">
          <div class="form-group" style="display: ">
            <div class="input-daterange input-group">
              <input id="tanggal1" data-provide="datepicker" class="form-control input-sm datepicker1" name="tanggal1" type="text">
              <span class="input-group-addon">-</span>
              <input id="tanggal2" data-provide="datepicker" class="input-sm form-control datepicker2" name="tanggal2" type="text" value="{{ date('d-m-Y') }}">
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
          <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="lihatReturnByTanggal()">
            <strong>
              <i class="fa fa-search" aria-hidden="true"></i>
            </strong>
          </button>
          <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelIndex()"> 
            <strong>
              <i class="fa fa-undo" aria-hidden="true"></i>
            </strong>
          </button>
        </div>

        <div align="right">
          <a href="{{ url('/purchasing/returnpembelian/tambah-return') }}"><button type="button" class="btn btn-box-tool" title="Tambahkan Data Return">
            <i class="fa fa-plus" aria-hidden="true">
               &nbsp;
            </i>Tambah Data
            </button>
          </a>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="table-responsive">
            <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabel-return">
              <thead>
                <tr>
                  <th class="wd-5p">No.</th>
                  <th class="wd-10p">Tgl Return</th>
                  <th class="wd-15p">ID Return</th>
                  <th class="wd-10p">Staff</th>
                  <th class="wd-10p">Metode</th>
                  <th class="wd-15p">Supplier</th>
                  <th class="wd-15p">Total Retur</th>
                  <th class="wd-15p">Status</th>
                  <th class="wd-15p" style="text-align: center;">Aksi</th>
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