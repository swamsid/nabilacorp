<div id="pesanan" class="tab-pane fade in active">
  <form method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-top: 15px;">
           
           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Tanggal</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="form-control input-sm" readonly="" name="" value="{{date('d-m-Y')}}">
             </div>
           </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
             <label>No Nota</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="form-control input-sm" name="">
             </div>
           </div>

           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Akses</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="form-control input-sm" name="" readonly="" value="{{Auth::user()->name}}">
             </div>
           </div>

           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Customer</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="form-control input-sm" name="">
             </div>
           </div>

           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Tanggal Jadi</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="form-control input-sm datepicker2" name="">
             </div>
           </div>

          
          </div>
            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top: 15px;padding-top: 15px;">

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Nama Item</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" name="" id="n_item">
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Qty</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="number" class="form-control input-sm" name="" id="q_qty">
                </div>
              </div>
            </div>
        </div>
  
        <div class="col-md-12 col-sm-12 col-xs-12">      
          <div style="padding-top: 20px;padding-bottom: 20px;">     
            <div class="table-responsive">
              <table class="table tabelan table-bordered table-hover dt-responsive data-table" id="t64">
               <thead align="right">
                <tr>
                 <th>Kode</th>
                 <th>Nama</th>
                 <th width="5%">Jumlah</th>
                 <th>Satuan</th>
                 <th>Harga</th>
                 <th>Total</th>
                 <th>Disc</th>
                 <th>Aksi</th>
                </tr>
               </thead> 
               <tbody>
               </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12" >
              
              <div class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top: 10px;">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    
                      <label class="control-label tebal" for="penjualan">Sub Total</label>

                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" id="penjualan" name="" readonly="true" class="form-control input-sm" style="text-align: right;">
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <label class="control-label tebal" for="discount">Total Diskon</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" id="discount" name="" readonly="true" class="form-control input-sm" style="text-align: right;">
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <label class="control-label tebal" for="grand">Grand Total</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" id="grand" name="" readonly="true" class="form-control input-sm" style="text-align: right;font-weight: bold;">
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label tebal" for="jumlah">DP</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="jumlah" name="" class="form-control input-sm" style="text-align: right;" onkeyup="numberOnly()">
                        </div>
                  </div>
                      
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <label class="control-label tebal" for="kembalian">Sisa Pembayaran</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" id="kembalian" name="" readonly="true" class="form-control input-sm" style="text-align: right;font-weight: bold;">
                      </div>
                  </div>
                    
                    
                         
                 

              </div>

               <!-- Start Modal Proses -->
                <div class="modal fade" id="proses" role="dialog">
                    <div class="modal-dialog">
                        
                    
                        <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header" style="background-color: #e77c38;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title" style="color: white;">Proses Form Penjualan Retail</h4>
                            </div>

                            <div class="modal-body">
                              
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:15px;padding-top:15px; ">

                                <div class="col-md-6 col-sm-6 col-xs-12"> 
                                  <label class="control-label tebal" for="ongkos_kirim">Ongkos Kirim</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-group input-group-sm" style="width: 100%;">
                                      <input type="text" id="ongkos_kirim" name="" class="form-control">
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label tebal" for="cara" >Cara Pembayaran</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                      <div class="input-group input-group-sm" style="width: 100%;">
                                        <select class="form-control" name="" id="cara">
                                          <option value="">Tunai</option>
                                          <option value="">Deposit</option>
                                          <option value="">Tempo</option>
                                        </select>
                                      </div>
                                  
                                </div>
                                          
                              </div>
                            </div>
                        
                            <div class="modal-footer">
                              <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                              <button class="btn btn-primary" type="button">Proses</button>
                            </div>
                          </div>
                          
                      </div>
                  </div>
                <!-- End Modal Proses -->

              
        </div>
              
                  <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                    <button class="btn btn-warning" type="button">Draft</button>
                    <button type="button" class="btn-primary btn" data-toggle="modal" data-target="#proses">Proses</button>
                  </div>
              
        
      </div>
  </form>
</div>