   
            <div class="table-responsive">
              <table class="table tabelan table-bordered table-hover dt-responsive data-table tableListToko" id="tableListToko" width="100%">
               <thead align="right">
                <tr>
                 <th>Tanggal</th>
                 <th>No Nota</th>
                 <th>Pengguna</th>
                 <th>Kasir</th>     
                 <th>Item</th>     
                 <th>Status</th> 
                 <th>Action</th>
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
                              <h4 class="modal-title" style="color: white;">Proses Form Penjualan Retail</h4>
                            </div>

                            <div class="modal-body" style="padding:0px">
                              
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:15px;padding-top:15px; ">
                                
                              
                                
                                <div class="table-responsive">
              <table class="table tabelan table-bordered table-hover dt-responsive">
               <thead align="right">
                <tr>                 
                 <th width="25%">Nama</th>
                 <th width="4%">stok</th>
                 <th width="4%" style="display:none">JumlahAwal</th>
                 <th width="4%">Jumlah</th>
                 <th width="5%">Satuan</th>
                 <th width="6%">Harga</th>
                 <th width="4%">Disc(Rp.)</th>
                 <th width="3%">Disc(%)</th>
                 <th width="3%" style="display:none">DiscValue(%)</th>
                 <th width="10%" style="display:none">Total+Diskon</th>  
                 <th width="10%">Total</th>                 
                 <th width="3%">Aksi</th>
                </tr>
               </thead> 
               <tbody class="dataDetail">
               </tbody>
              </table>
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
          
     function editPenjualan(s_id,s_note,s_machine,s_date,s_duedate,s_finishdate,s_gross,s_disc_percent,s_disc_value,s_grand,s_ongkir,s_net,s_bayar,s_kembalian,s_customer,c_name,chek) {
            $('.reset').val('');

            $('#s_id').val(s_id);
            $('#s_date').val(s_date);
            $('#s_duedate').val(s_duedate);    
            $('#s_finishdate').val(s_finishdate);    
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
            $('#biaya_kirim').val(s_ongkir);
            $('#grand').val(s_grand);
            $('#grand_biaya').val(s_net);
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