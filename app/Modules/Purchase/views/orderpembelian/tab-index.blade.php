<div id="index-tab" class="tab-pane fade in active">
                           
  <div class="row" style="margin-top: -10px;">
    
    <div class="col-md-3 col-sm-3 col-xs-12" align="left">
      <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refreshTabelIndex()">
        <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
      </button>
    </div>

    <div class="col-md-9 col-sm-9 col-xs-12" >

      <div align="right">
        <a href="{{ url('/purcahse-order/form-order') }}" class="btn btn-box-tool" style="margin-bottom: 10px;"><i class="fa fa-plus"></i>&nbsp;Tambah Order</a>
      </div>

    </div>
    
    <div class="col-md-12 col-sm-12 col-xs-12"> 
      <div class="table-responsive">
        <table class="table tabelan table-bordered" id="tbl-index">
          <thead>
            <tr>
              <th>No</th>
              <th>Tgl Order</th>
              <th>No Order</th>
              <th>Staff</th>
              <th>Supplier</th>
              <th>Cara Bayar</th>
              <th>Harga Total</th>
              <th>Tgl Kirim</th>
              <th>Status</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>

  </div>
              
</div>