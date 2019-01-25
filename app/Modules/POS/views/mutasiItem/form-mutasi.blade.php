<div id="form-mutasi" class="tab-pane fade">
  <form id="datab">      
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-top: 15px;margin-bottom: 15px;">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">  
              <label class="tebal">Tanggal Mutasi</label>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input type="hidden" id="mi_id" class="form-control input-sm mi_id" name="mi_id">
                <input type="text" id="mi_date" class="form-control input-sm mi_date"  value="{{date('d-m-Y')}}" name="mi_date">
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">  
              <label class="tebal">No Mutasi</label>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <input id="mi_code" type="text" class="form-control input-sm" readonly="" name="mi_code" placeholder="(Auto)">
              </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <label class="tebal">Keterangan</label>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="form-group">
                <textarea  class="form-control" name="mi_keterangan" id="mi_keterangan"></textarea>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12 tamma-bg" style="margin-top: 5px;margin-bottom: 5px;margin-bottom: 20px; padding-bottom:20px;padding-top:20px;">
          <div class="col-md-2">
             <label class="control-label tebal" for="">Jenis</label>
                <div class="input-group input-group-sm" style="width: 100%;">
                   <select style="width: 100%;" id="jenis" name="jenis" class="jenis" onclick="opsiJenis()">
                       <option value="Bahan">Bahan</option>
                       <option value="Hasil Jadi">Hasil Jadi</option>
                   </select>
                </div>
            </div>  

            <div class="input-Bahan">
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
            <div class="col-md-2">
             <label class="control-label tebal" name="qty">Stok</label>
                <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="number" class="form-control input-sm alignAngka reset reset-seach" name="stock" id="stock" disabled="">  
                </div>
            </div>
            <div class="col-md-2">
             <label class="control-label tebal" name="qty">Jumlah</label>
                <div class="input-group input-group-sm" style="width: 100%;">
                   <input type="number" class="move up3 form-control input-sm alignAngka reset reset-seach" name="fQty" id="fQty">   
                   <input type="hidden" class="form-control input-sm alignAngka reset reset-seach" name="cQty" id="cQty" >   
                </div>
            </div>
            </div>



              <div class="input-hasil" style="display: none;">
           <div class="col-md-6">
             <label class="control-label tebal" for="">Masukan hasil / Nama</label>
                <div class="input-group input-group-sm" style="width: 100%;">
                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible">1 result is available, use up and down arrow keys to navigate.</span>
                    <input  class="move up1 form-control input-sm reset-seach" id="mp_searchitem" >
                    <input type="hidden" class="form-control input-sm reset-seach" id="mp_itemName">
                    <input type="hidden" class="form-control input-sm " name="i_id" id="mp_i_id">
                    <input type="hidden" class="form-control input-sm reset-seach" name="i_code" id="mp_i_code">
                    <input type="hidden" class="form-control input-sm reset-seach" id="mp_i_price">
                    <input type="hidden" class="form-control input-sm reset-seach" name="s_satuan" id="mp_s_satuan">

                    <input type="hidden" class="fComp form-control input-sm reset-seach" name="" id="mp_fComp">
                  <input type="hidden" class="fPosition form-control input-sm reset-seach" name="" id="mp_fPosition">
                </div>
            </div>      
            <div class="col-md-2">
             <label class="control-label tebal" name="mp_qty">Stok hasil</label>
                <div class="input-group input-group-sm" style="width: 100%;">
                    <input type="number" class="form-control input-sm alignAngka reset reset-seach" name="stock" id="mp_stock" disabled="">  
                </div>
            </div>
            <div class="col-md-2">
             <label class="control-label tebal" name="qty">Jumlah hasil</label>
                <div class="input-group input-group-sm" style="width: 100%;">
                   <input type="number" class="move up3 form-control input-sm alignAngka reset reset-seach" name="fQty" id="mp_fQty">   
                   <input type="hidden" class="form-control input-sm alignAngka reset reset-seach" name="cQty" id="mp_cQty" >   
                </div>
            </div>
            </div>



      </div>
    </div>

    <ul id="captainTab" class="nav nav-tabs">
      <li class="active"><a id="tab-bahan" href="#tab_bahan" data-toggle="tab" onclick="tabJenis('Bahan')">Bahan</a></li>
      <li><a id="tab-hasil" href="#tab_hasil" data-toggle="tab" onclick="tabJenis('Hasil Jadi')">Hasil Jadi</a></li>

    </ul>

    <div id="captainTabContent" class="tab-content responsive">
      <div class="tab-pane fade in active" id="tab_bahan">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">      
            <div style="padding-top: 20px;padding-bottom: 20px;">     
              <div class="table-responsive" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a">
                <table class="table tabelan table-bordered table-hover dt-responsive" id="bahan">
                 <thead align="right">
                  <tr>                 
                      <th>Nama Item</th>
                      <th>Stok</th>
                      <th>Qty</th>
                      <th>Satuan</th>                    
                      <th>Aksi</th>       
                  </tr>
                 </thead> 
                 <tbody class="dBahan">
                 </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="tab_hasil">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">      
            <div style="padding-top: 20px;padding-bottom: 20px;">     
              <div class="table-responsive" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a">
                <table class="table tabelan table-bordered table-hover dt-responsive" id="hasil">
                 <thead align="right">
                  <tr>                 
                      <th>Nama Item</th>
                      <th>Stok</th>
                      <th>Qty</th>
                      <th>Satuan</th>
                      <th>Harga Hpp</th>
                      <th>Aksi</th>       
                  </tr>
                 </thead> 
                 <tbody class="dHasil">
                 </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    

    


    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" align="right">
      <button type="button" id="batal" class="btn btn-xs btn-danger btn-disabled btn-flat batal" title="Batal" onclick="btnBatal()">
                  Batal
      </button>
      <button id="simpan" type="button" class="btn btn-xs btn-primary btn-disabled btn-flat simpan" title="Simpan Data (Ctrl + F10)" onclick="btnSimpan()"             disabled="disabled">
                  <i class="fa fa-save"></i> &nbsp;&nbsp; Simpan (Ctrl + F10)
      </button>

      <button id="perbarui" type="button" class="btn btn-xs btn-primary btn-disabled btn-flat perbarui" title="Perbarui Data (Ctrl + F10)" onclick="btnPerbarui()" disabled="disabled" style="display: none;">
                  <i class="fa fa-save"></i> &nbsp;&nbsp; Perbarui (Ctrl + F10)
      </button>
      </div>
    </div>
  </form>

  </div>
</div>


<script type="text/javascript">
  function opsiJenis() {
    var jenis=$('#jenis').val();
      if(jenis=='Bahan'){
        $('#tab-bahan').tab('show');
        $('.input-Bahan').css('display','');
        $('.input-hasil').css('display','none');
      }
      else if(jenis=='Hasil Jadi'){
        $('#tab-hasil').tab('show');
        $('.input-Bahan').css('display','none');
        $('.input-hasil').css('display','');
      }
    
  }

  function tabJenis(jenis) {    
      if(jenis=='Bahan'){
        $('.input-Bahan').css('display','');
        $('.input-hasil').css('display','none');
        $('#jenis').val('Bahan');
      }
      else if(jenis=='Hasil Jadi'){        
        $('.input-Bahan').css('display','none');
        $('.input-hasil').css('display','');
        $('#jenis').val('Hasil Jadi');
      }
    
  }

  function hapusBahanB(e,a){
    if(e.which===46 && e.ctrlKey){
      hapusBahan.push(a);
        $('.detailBahan'+a).remove();
        var index = tampBahan.indexOf(''+a);  
        if(index!==-1)
        tampBahan.splice(index,1);
    }
}


function hapusButtonBahan(a){

      a=''+a;
      hapusBahan.push(a);
        $('.detailBahan'+a).remove();
        var index = tampBahan.indexOf(''+a);  
        if(index!==-1)
        tampBahan.splice(index,1);
}



  function hapusHasilH(e,a){
    if(e.which===46 && e.ctrlKey){
      hapusHasil.push(a);
        $('.detailHasil'+a).remove();
        var index = tampHasil.indexOf(''+a);  
        if(index!==-1)
        tampHasil.splice(index,1);
    }
}


function hapusButtonHasil(a){
      a=''+a;
     hapusHasil.push(a);
        $('.detailHasil'+a).remove();
        var index = tampHasil.indexOf(''+a);  
        if(index!==-1)
        tampHasil.splice(index,1);
}





 function cekStockMutasi(id){        
  var fQty=angkaDesimal($('.fQty'+id).val());        
  if(isNaN(fQty)){    
    return false;
  }
       
    var stock=angkaDesimal($('.stock'+id).val());
    if(stock==0){
                    iziToast.error({
                      position:'topRight',
                      timeout: 2000,
                      title: '',
                      message: "Ma'af, jumlah melebihi stok.",
                    });
                    $('.fQty'+id).val('');     
                    return false;                   
    }
    if(stock<fQty){             

            
                    iziToast.error({
                      position:'topRight',
                      timeout: 2000,
                      title: '',
                      message: "Ma'af, jumlah melebihi stok.",
                    });
        $('.fQty'+id).val(1);                  
        return false;
    }


  }


  function btnBatal(){

    $('#mi_id').val('');
    $('#mi_date').val('{{date('d-m-Y')}}');
    $('#mi_code').val('Auto');
    $('#mi_keterangan').val('');
            dBahan.html(''); 
            dHasil.html(''); 
            tampBahan=[];                        
            tampHasil=[];            
            hapusBahan =[];
            hapusHasil =[];
$('#simpan').css('display','');
$('#perbarui').css('display','none');


  }


</script>