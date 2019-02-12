<div id="listtoko" class="tab-pane fade">
   <form method="post">
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div style="padding-top: 20px;padding-bottom: 20px;">
               <div id="listPenjualan">
                  <div class="row">
                     <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 2mm">
                        <div class="col-md-9 col-sm-9 col-xs-12" style="display: flex;align-items: center">
                           <label class="tebal" style="margin-right: 2mm">Tanggal</label>
                           <div class="" style="margin-right: 1.5mm">
                              <div class="input-daterange input-group">
                                 <input id="tanggal1" class="form-control input-sm" name="tgl_awal" type="text">
                                 <span class="input-group-addon">-</span>
                                 <input id="tanggal2"" class="input-sm form-control" name="tgl_akhir" type="text">
                              </div>
                           </div>

                           <div>
                             <button class="btn btn-primary btn-sm btn-flat search_btn" type="button">
                                <strong>
                                  <i class="fa fa-search" aria-hidden="true"></i>
                                </strong>
                              </button>
                              <button class="btn btn-info btn-sm btn-flat reset_btn" type="button">
                               <strong>
                                  <i class="fa fa-undo" aria-hidden="true"></i>
                               </strong>
                           </button>
                           </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-3 col-xs-12" align="right">
                           <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" onclick="tambah()">
                           <i class="fa fa fa-plus"></i> &nbsp;&nbsp;Tambah Data
                           </button>
                        </div>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table table-stripped tabelan table-bordered table-hover dt-responsive tableListToko" id="tableListToko" width="100%">
                        <thead align="right">
                           <tr>
                              <th width="10%">Tanggal</th>
                              <th>Kode</th>
                              <!-- <th width="20%">Pelangan</th> -->
                              <th width="10%">Action</th>
                           </tr>
                        </thead>
                        <tbody>                
                        </tbody>
                     </table>
                  </div>
                  <div class="modal fade" id="modalDataDetail" role="dialog">
                     <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                           <div class="modal-header" style="background-color: #e77c38;">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title" style="color: white;">Detail Penjualan</h4>
                           </div>
                           <div class="modal-body" style="padding:0px">
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" >
                                 <label class="tebal">Status : </label>&nbsp;&nbsp;
                                 <span class="" id="txt_span_status"></span>
                                 <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <label class="tebal">Tanggal</label>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <div class="form-group">
                                          <label id="lTgl"></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <label class="tebal">No. Nota</label>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <div class="form-group">
                                          <label id="lCode"></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <label class="tebal">Nama Pelanggan</label>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <div class="form-group">
                                          <label id="lCustomer"></label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="table-responsive">
                                    <table class="table tabelan table-bordered table-hover dt-responsive">
                                       <thead align="right">
                                          <tr>
                                             <th width="25%">Nama</th>
                                             <th width="4%">Jumlah</th>
                                             <th width="5%">Satuan</th>
                                             <th width="6%">Harga</th>
                                             <th width="4%">Disc(Rp.)</th>
                                             <th width="3%">Disc(%)</th>
                                             <th width="10%">Total</th>
                                          </tr>
                                       </thead>
                                       <tbody class="dataDetail">
                                       </tbody>
                                    </table>
                                 </div>
                                 <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <label class="tebal">Sub Total</label>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <div class="form-group">
                                          <label id="lSubttl"></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <label class="tebal">Total Diskon</label>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <div class="form-group">
                                          <label id="lDiskon"></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <label class="tebal">Biaya Kirim</label>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <div class="form-group">
                                          <label id="lBkirim"></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <div class="form-group">
                                          <label id="lTtl"></label>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <label class="tebal">Total Bayar</label>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                       <div class="form-group">
                                          <label id="lBiaya"></label>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Modal Proses -->
                  <script type="text/javascript">
                     function editPenjualan(s_id,s_note,s_machine,s_date,s_duedate,s_finishdate,s_gross,s_disc_percent,s_disc_value,s_grand,s_ongkir,s_bulat,s_net,s_bayar,s_kembalian,s_customer,c_name,s_status,chek) {
                     
                             $('.reset').val('');
                             $('#s_created_by').val('{{Auth::user()->m_name}}')
                             $('#s_id').val(s_id);
                             
                             $('#s_status').val(s_status);
                             $('#s_date').val(s_date);
                             $('#s_note').val(s_note);            
                             $('#s_machine').val(s_machine);
                             $('#s_gross').val(s_gross);        
                             if(s_disc_value!='' && s_disc_value!=0 ){
                               s_disc_value=SetFormRupiah(s_disc_value)
                             }
                             $('#discountRp').val(s_disc_value);
                             if(s_disc_percent!='' && s_disc_percent!=0 ){
                               s_disc_percent=SetFormRupiah(s_disc_percent)
                             }
                             $('#discountP').val(s_disc_percent);
                             $('#discount').val(SetFormRupiah(s_disc_value+s_disc_percent));
                             
                             $('#vbiaya_kirim').val(s_ongkir);            
                             $('#biaya_kirim').val(s_ongkir);            
                             $('#grand').val(s_grand);
                             $('#grand_biaya').val(s_net);
                             $('#s_bulat').val(s_bulat);
                             $('#akumulasiTotal').val(s_net);
                             $('#penjualan').tab('show');
                             $('#customer').val(c_name)
                             $('#s_customer').val(s_customer)
                             $('#totalBayar').val(s_bayar)
                             $('#kembalian').val(s_kembalian)
                     
                                 if(parseInt(chek)>0){
                                 $('.perbarui').css('display','');
                                 $('.terima').css('display','none');
                             }
                             if(parseInt(chek)<0){
                               $('.perbarui').css('display','none');
                               $('.terima').css('display','');
                     
                             }
                             
                             detail(s_id);
                     
                     }
                     
                           
                  </script>
               </div>
            </div>
         </div>
      </div>
   </form>
</div>