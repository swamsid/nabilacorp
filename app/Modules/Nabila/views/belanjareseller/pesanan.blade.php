<style type="text/css">
  table#tSalesDetail{
    border: none;
  }
</style>
<div id="toko" class="tab-pane fade in active">
  <form method="post" id="dataPos">
      <div class="row">
        {{ csrf_field() }}
        <div class="col-md-12">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-top: 15px;" no>
           
           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Tanggal</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="move up1 form-control input-sm reset "  name="s_date" id="s_date" value="{{date('d-m-Y')}}" autocomplete="off">
               <input type="hidden" class="form-control input-sm reset"  name="s_id" id="s_id" readonly="">
               <input type="hidden" class="form-control input-sm reset"  name="s_status" id="s_status" readonly="">
             </div>
           </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
             <label>No Nota</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="form-control input-sm reset" name="s_note" id="s_note" placeholder="(Auto)" disabled="">
             </div>
           </div>


           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Pengguna</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" id="s_created_by" class="form-control input-sm reset" name="s_created_by" disabled="" value="{{Auth::user()->m_name}}">
             </div>
           </div>

           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Kasir</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input class="form-control" type="" name="" value="{{$machine->m_name}}" disabled="">
             </div>
           </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Nama Pelanggan</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">               
               <input type="text" class="move up1 form-control input-sm reset" id="s_nama_cus" name="s_nama_cus">
             </div>
           </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Alamat Pelanggan</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">               
               <input type="text" class="move up2 form-control input-sm reset" id="s_alamat_cus" name="s_alamat_cus">
               
             </div>
           </div>
            <!-- 
           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input class="move up2 form-control input-sm reset ui-autocomplete-input" id="customer" autocomplete="off">
               <input type="hidden" class="form-control input-sm reset" id="s_customer" name="s_customer" value="0">
               
             </div>
           </div> -->

           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Pembayaran</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <select  class="move up1 form-control input-sm s_jenis_bayar" id="s_jenis_bayar" name="s_jenis_bayar" onchange="jenis_bayar()">
                 <option value="1">Tunai</option>
                 <option value="2">Tempo</option>
               </select>
             </div>
           </div>


          <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Jatuh Tempo</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="move up2 form-control input-sm s_duedate" name="s_duedate" id="s_duedate" disabled="">
             </div>
           </div>





           <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Tanggal Jadi</label>
           </div>     

           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
               <input onblur="jatuhTempo()" type="text" class="move up1 form-control input-sm s_finishdate" name="s_finishdate" id="s_finishdate" onchange="tglf()">
             </div>
           </div>


        


            <div class="col-md-3 col-sm-6 col-xs-12">
             <label>Pilih Harga</label>
           </div>     
           <div class="col-md-3 col-sm-6 col-xs-12">
             <div class="form-group">
                <select class="move up1 form-control input-sm" id="harga" name="s_type_price" onchange="harga()">
                @foreach($daftarHarga as $daftar)
                 <option value="{{$daftar->pg_id}}">
                   {{$daftar->pg_name}}
                 </option>
                 @endforeach
               </select>
             </div>
           </div>







          
          </div>




           <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top: 5px;margin-bottom: 5px;margin-bottom: 20px; padding-bottom:20px;padding-top:20px;">
               <div class="col-md-6">
                 <label class="control-label tebal" for="">Masukan Kode / Nama</label>
                    <div class="input-group input-group-sm" style="width: 100%;">
                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible">1 result is available, use up and down arrow keys to navigate.</span>
                        <input  class="move up1 form-control input-sm reset-seach" id="searchitem" >
                        <input type="hidden" class="form-control input-sm reset-seach" id="itemName">
                        <input type="hidden" class="form-control input-sm " name="i_id" id="i_id">
                        <input type="hidden" class="form-control input-sm reset-seach" name="i_code" id="i_code">
                        <input type="hidden" class="form-control input-sm reset-seach" id="i_price">
                        <input type="hidden" class="form-control input-sm reset-seach" name="s_satuan" id="s_satuan">
                        <input type="hidden" class="fComp form-control input-sm reset-seach" name="" id="fComp">
                        <input type="hidden" class="fPosition form-control input-sm reset-seach" name="" id="fPosition">
                    </div>
                </div>      
                <div class="col-md-3">
                 <label class="control-label tebal" name="qty">Stok</label>
                    <div class="input-group input-group-sm" style="width: 100%;">
                        <input type="number" class="form-control input-sm alignAngka reset reset-seach" name="stock" id="stock" disabled="">  
                    </div>
                </div>
                <div class="col-md-3">
                 <label class="control-label tebal" name="qty">Jumlah</label>
                    <div class="input-group input-group-sm" style="width: 100%;">
                       <input type="number" class="move up3 form-control input-sm alignAngka reset reset-seach" name="fQty" id="fQty" onclick="validationForm();" >   
                       <input type="hidden" class="form-control input-sm alignAngka reset reset-seach" name="cQty" id="cQty" onclick="validationForm();">   
                    </div>
                </div>
          </div>


        </div>
 
        <div class="col-md-12 col-sm-12 col-xs-12">      
          <div style="padding-top: 20px;padding-bottom: 20px;">     
            <div class="table-responsive" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a">
              <table class="table tabelan table-bordered table-hover dt-responsive" id="tSalesDetail">
               <thead align="right">
                <tr>                 
                 <th width="23%">Nama</th>
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
               <tbody class="bSalesDetail">
               </tbody>
              </table>
            </div>
          </div>
        </div>






        <div class="col-md-12 col-sm-12 col-xs-12" >
              
              <div class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top: 10px;">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    
                      <label class="control-label tebal" for="penjualan">Sub Total</label>

                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" id="s_gross" name="s_gross" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                      </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                      <label class="control-label tebal" for="discount">Total Diskon(%)</label>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                      <div class="form-group">
                        <input type="text" id="discountP" name="s_disc_percent" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                      </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                      <label class="control-label tebal" for="discount">Total Diskon(Rp.)</label>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                      <div class="form-group">
                        <input type="text" id="discountRp" name="s_disc_value" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                      </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <label class="control-label tebal" for="discount">Total Diskon</label>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <input type="text" id="discount" name="discount" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                      </div>
                  </div>                  
                  <div class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                      <label class="control-label tebal" for="grand">Grand Total</label>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                      <div class="form-group">
                        <input type="text" id="grand" name="" readonly="true" class="form-control input-sm reset" style="text-align: right;font-weight: bold;">
                      </div>
                  </div>


                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <label class="control-label tebal" for="grand">Biaya Kirim</label>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                   <input type="text" id="vbiaya_kirim" name="s_ongkir" class="form-control input-sm vbiaya_kirim reset" style="text-align: right;" autocomplete="off" readonly="">
                      </div>
                  </div>


                      


                
                  <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label tebal" for="jumlah">Grand Total + Biaya Kirim</label>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="grand_biaya" name="s_net" class="form-control form-control-xl input-sm reset" style="text-align: right;" readonly="" autocomplete="off">
                        </div>
                  </div>

             <!--      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label tebal" for="jumlah">Jumlah Pembayaran</label>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="jml_bayar" name="" class="form-control input-sm jml_bayar reset" style="text-align: right;" onkeyup="numberOnly()" disabled="">
                        </div>
                  </div> -->

                      
                
                    
                         
                 

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



                             


                                 <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <label class="control-label tebal" for="ongkos_kirim">Biaya Kirim</label>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <div class="form-group">
                                    <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                <input type="text" id="biaya_kirim" name="s_ongkir" class="minu mx form-control input-sm biaya_kirim reset" style="text-align: right;" onkeyup="hitungTotal();rege(event,'biaya_kirim')"  onblur="setRupiah(event,'biaya_kirim')" onclick="setAwal(event,'biaya_kirim')" value="0" autocomplete="off">
                                    </div>
                                  </div>
                                </div>


   <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <label class="control-label tebal" for="ongkos_kirim">Pembulatan</label>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <div class="form-group">
                                    <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                       <input type="text" id="s_bulat" name="s_bulat" class="minu mx form-control input-sm s_bulat reset" style="text-align: right;" onkeyup="hitungTotal();rege(event,'s_bulat')"  onblur="setRupiah(event,'s_bulat')" onclick="setAwal(event,'s_bulat')"  autocomplete="off">
                                    </div>
                                  </div>
                                </div>


                                <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <label class="control-label tebal" for="ongkos_kirim">Grand Total + Biaya Kirim</label>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <div class="form-group">
                                    <div class="input-group pull-right" style="width: 93%;">
                                      <input type="text" id="akumulasiTotal" name="" class="form-control form-control-xl reset" style="text-align: right;" " readonly="">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12" style="border-bottom: 4px solid #9e5a2e; padding-top:8px ">                                  
                                </div>                         
                                
<table style="width: 100%" class="table c">
  <thead>
    <th>Cara Bayar</th>
    <th>Jumlah</th>
    <td class="hutang" style="display: none;">Jatuh Tempo</th>
  </thead>
  <tbody class="tr_clon">
      <tr>
        <td>
          <select style="width:90%" class="minu mx" name="sp_method[]" >
              @foreach($paymentmethod as $pm)
                <option value="{{$pm->pm_id}}">{{$pm->pm_name}}</option>
              @endforeach
          </select>
      </td>
      <td>
    <input class="minu mx f2 nominal alignAngka nominal" style="width:90%" type="" name="sp_nominal[]"
     id="nominal" 
     onkeyup="totalPembayaran('nominal');rege(event,'nominal');"      
     onblur="setRupiah(event,'nominal')" onclick="setAwal(event,'nominal')
    autocomplete="off">
      </td>
  </tbody>
</table>
                                <div class="col-md-12" style="border-bottom: 4px solid #9e5a2e; padding-top:8px ">
                                </div>

                              <!--    <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <label class="control-label tebal" for="ongkos_kirim">Pembulatan</label>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <div class="form-group">
                                    <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                       <input type="text" id="s_bulat" name="s_bulat" class="minu mx form-control input-sm s_bulat reset" style="text-align: right;" onkeyup="hitungTotal();rege(event,'s_bulat')"  onblur="setRupiah(event,'s_bulat')" onclick="setAwal(event,'s_bulat')"  autocomplete="off">
                                    </div>
                                  </div>
                                </div>
 -->

                                <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <label class="control-label tebal" for="ongkos_kirim">Jumlah Bayar</label>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <div class="form-group">
                                    <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                      <input type="text" id="totalBayar" name="s_bayar" class="form-control reset" style="text-align: right;" disabled="" ="">
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-5 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <label class="control-label tebal">Kembalian</label>
                                </div>
                                <div class="col-md-7 col-sm-6 col-xs-12" style="padding-top: 8px"> 
                                  <div class="form-group">
                                    <div class="input-group input-group-sm pull-right" style="width: 93%;">
                                      <input id="kembalian" type="text" name="kembalian" class="form-control reset" style="text-align: right;" readonly="">
                                    </div>
                                  </div>
                                </div>

                                          
                              </div>
                            </div>
                        
                            <div class="modal-footer">
                            <div id="div_print"></div>
                              <button type="button" class="minu mx btn btn-warning" data-dismiss="modal">Close</button>
                              <button class="btn terima btn-primary minu mx" type="button" onclick="buttonSimpanPos('terima')">Simpan & Print</button>
                              <button type="button" class="minu mx btn-primary btn btn-disabled perbarui" data-toggle="modal" disabled="" style="display: none;"  onclick="buttonSimpanPos()">Perbarui</button>
                            </div>
                          </div>
                          
                      </div>
                  </div>
                <!-- End Modal Proses -->

              
        </div>
                  <div class="col-md-1 col-sm-1 col-xs-1">
                  </div>
                  <div class="col-md-11 col-sm-11 col-xs-11" align="right">
                    <button class="btn btn-danger btn-disabled" type="button" onclick="batal()">Batal</button>
                     <button style="display: none;" class="btn btn-warning btn-disabled terima" type="button" onclick="Terima('draft')">Terima</button>                              
                    <button class="btn btn-warning btn-disabled draft" type="button" onclick="simpanPos('draft')">Draft</button>
                    <button type="button" class="btn-primary btn btn-disabled perbarui" data-toggle="modal" disabled="" style="display: none;" id="perbarui" 
                    onclick="modalShow()">Perbarui</button>
                    <button onclick="modalShow()"
                     type="button" class="move btn-primary btn btn-disabled terima" data-toggle="modal" disabled="" >Proses</button>
                  </div>
             
        
      </div>
  </form>
</div>

<script>
  
</script>