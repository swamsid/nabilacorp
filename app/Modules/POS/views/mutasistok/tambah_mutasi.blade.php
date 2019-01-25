<div class="modal fade" id="tambah" role="dialog">
  <div class="modal-dialog modal-lg">
      
    <form method="get" action="#">
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Form Mutasi Stock</h4>
          </div>

          <div class="modal-body">

            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">  
                <label class="tebal">Tanggal Mutasi</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" readonly="" value="{{date('d-m-Y')}}" name="">
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">  
                <label class="tebal">No Mutasi</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" readonly="" name="">
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Gudang Asal</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select class="form-control input-sm">
                    <option>--Pilih Gudang--</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Gudang Tujuan</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select class="form-control input-sm">
                    <option>--Pilih Gudang--</option>
                  </select>
                </div>
              </div>

            </div><!-- end div row -->
            <div class="row" style="border-bottom: 1px solid #DDDDDD;padding-top: 15px;border-top: 1px solid #DDDDDD;margin-bottom: 15px;">
              <div class="col-md-3 col-sm-6 col-xs-12">  
                <label class="tebal">Nama Item</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" name="" id="m_item">
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-12">  
                <label class="tebal">Qty</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="number" class="form-control input-sm" name="" id="m_qty">
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table tabelan table-bordered table-hover data-table" cellspacing="0" id="t90">
                <thead>
                  <tr>
                    <th>Nama Item</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div><!-- end div modal-content -->
      
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Simpan Data</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>   
    </div>
</div>

<script type="text/javascript">
  
</script>