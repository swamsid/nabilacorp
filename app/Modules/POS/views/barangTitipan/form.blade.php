<style type="text/css">


</style>
<div id="toko" class="tab-pane fade in active">
  <form method="post" id="dataPos">
      <div class="row">
        {{ csrf_field() }}
        <div class="col-md-12">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-top: 15px;" no>
           
           <div class="col-md-2 col-sm-6 col-xs-12">
             <label>Tanggal</label>
           </div>     

           <div class="col-md-4 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="move up1 form-control input-sm reset "  name="it_date" id="it_date" value="{{date('d-m-Y')}}" autocomplete="off">
               <input type="hidden" class="form-control input-sm reset"  name="it_id" id="it_id" readonly="">
               <input type="hidden" class="form-control input-sm reset"  name="it_status" id="it_status" readonly="">
             </div>
           </div>

          <div class="col-md-2 col-sm-6 col-xs-12">
             <label>No Nota</label>
           </div>     

           <div class="col-md-4 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" class="form-control input-sm reset" name="it_code" id="it_code" placeholder="(Auto)" disabled="">
             </div>
           </div>

           <div class="col-md-2 col-sm-6 col-xs-12">
             <label>Pengguna</label>
           </div>     

           <div class="col-md-4 col-sm-6 col-xs-12">
             <div class="form-group">
               <input type="text" id="s_created_by" class="form-control input-sm reset" name="s_created_by" readonly="" value="{{Auth::user()->m_name}}">
             </div>
           </div>

          <div class="col-md-2 col-sm-6 col-xs-12">
            <label class="tebal">Supplier</label>
          </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <input type="" name="" class="form-control input-sm"  
                id="supplier" onkeyup="clearSupplier()">
                <input type="hidden" name="id_supplier" class="form-control input-sm reset" id="id_supplier" value="20">
            </div>                
          </div>



        <div class="col-md-2 col-sm-6 col-xs-12">
            <label class="tebal">Keterangan</label>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <textarea class="form-control reset" name="it_keterangan" id="it_keterangan" style="margin-top: 0px; margin-bottom: 0px; height: 71px;"></textarea>
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
                 <th width="4%">Sisa</th>
                 <th width="4%" style="display:none">JumlahAwal</th>
                 <th width="4%">Jumlah</th>  
                 <!-- <th width="4%">jml Return</th>   -->
                 <th width="5%">Satuan</th>
                 <th width="6%">Harga</th>               
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
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    
                      <label class="control-label tebal" for="penjualan">Total</label>

                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <input type="text" id="s_gross" name="it_total" readonly="true" class="form-control input-sm reset" style="text-align: right;">
                      </div>
                  </div>
               
                          
                
                    
                         
                 

              </div>

               <!-- Start Modal Proses -->
                

              
        </div>

      
                  <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                    <button class="btn btn-danger " type="button" onclick="batal()">Batal</button>
                   <!--   <button style="display: none;" class="btn btn-warning btn-disabled terima" type="button" onclick="Terima('draft')">Terima</button>     -->                          
                    <!-- <button class="btn btn-warning btn-disabled draft" type="button" onclick="simpanPos('draft')" disabled="">Draft</button> -->
                    <button type="button" class="btn-primary btn btn-disabled perbarui" data-toggle="modal" disabled="" style="display: none;" id="perbarui" 
                    onclick="perbaruiData()">Perbarui</button>
                    <button class="btn btn-primary btn-disabled draft" type="button" onclick="simpanPos('final')" disabled="">Simpan</button>
                  </div>
             
        
      </div>
  </form>
</div>

