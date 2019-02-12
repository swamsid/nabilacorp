<div id="penerimaanapproved" class="tab-pane fade">
            <div class="row">
               <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="row">
                           <div class="form-group col-md-6">
                              <div class="input-group mb-3">
                                 <div class="input-group-addon">Tanggal Penerimaan</div>
                                 <input id="tgl_awal" class="form-control input-sm" name="tgl_awal" type="text">
                                 <span class="input-group-addon">-</span>
                                 <input id="tgl_akhir"" class="input-sm form-control datepicker2" name="tgl_akhir" type="text">
                                 <div class="input-group-btn">
                                    <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="cari()">
                                    <strong>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    </strong>
                                    </button>
                                    <button class="btn btn-info btn-sm btn-flat" type="button" onclick="resetData()">
                                    <strong>
                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                    </strong>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-6 col-xs-12" align="right">
                        <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" onclick="location.href = '{{ route('form_insert_shop_penerimaanbarang') }}'">
                        <i class="fa fa fa-plus"></i> &nbsp;&nbsp;Tambah Data
                        </button>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive">
                     <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabel_d_shop_terima_pembelian_dt">
                        <thead>
                           <tr>
                              <th width="10%">Kode Penerimaan</th>
                              <th width="10%">Tanggal Penerimaan</th>
                              <th width="7%">Barang</th>
                              <th width="7%">Supplier</th>
                              <th width="10%">Qty PO</th>
                              <th width="10%">Qty Diterima</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>