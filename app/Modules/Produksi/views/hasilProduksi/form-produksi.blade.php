<div id="form-mutasi" class="tab-panel fade">






      <form id="kirimData">

                                                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">


                                                            <div class="col-md-3 col-sm-12 col-xs-12">

                                                                    <label class="tebal">Tanggal Produksi</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input id="pr_date" value="{{ date('d-m-Y') }}" class="form-control pr_date input-sm" type="text" name="pr_date"/>
                                                                    <input type="hidden" name="pr_id" class="pr_id" id="pr_id">

                                                                </div>

                                                            </div>

                                                            <div class="col-md-3 col-sm-12 col-xs-12">

                                                                    <label class="tebal">No Hasil Produksi</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input id="pr_code" type="text" readonly="" class="form-control input-sm pr_code" name="pr_code" placeholder="(Auto)">
                                                                </div>

                                                            </div>


                                                              <div class="col-md-3 col-sm-12 col-xs-12">

                                                                    <label class="tebal">Keterangan</label>
                                                            </div>
                                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <textarea id="pr_note" class="form-control pr_note" name="pr_note"></textarea>
                                                                </div>

                                                            </div>
                                                        </div>

   <div class="col-md-12 tamma-bg" style="margin-top: 5px;margin-bottom: 5px;margin-bottom: 20px; padding-bottom:20px;padding-top:20px;">
         <div class="col-md-6">
           <label class="control-label tebal" for="">Masukan Kode / Nama</label>
              <div class="input-group input-group-sm" style="width: 100%;">
                  <span role="status" aria-live="polite" class="ui-helper-hidden-accessible">1 result is available, use up and down arrow keys to navigate.</span>
                  <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input class="move up1 form-control input-sm reset-seach ui-autocomplete-input" id="searchitem" autocomplete="off">
                  {{ csrf_field() }}
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
                 <input type="number" class="move up3 form-control input-sm alignAngka reset reset-seach" name="fQty" id="fQty" onclick="validationForm();">
                 <input type="hidden" class="form-control input-sm alignAngka reset reset-seach" name="cQty" id="cQty" onclick="validationForm();">
              </div>
          </div>
    </div>




                                                            <div class="table-responsive" style="overflow-y : auto;height : 350px; border: solid 1.5px #bb936a">
                                                                <table class="table tabelan table-bordered table-striped" id="data">
                                                                  <thead>
                                                                 <tr>
                                                                    <th width="40%">Nama Item</th>
                                                                    <th width="10%">Stok </th>
                                                                    <th width="10%">Qty</th>
                                                                    <th width="10%">Satuan</th>
                                                                    <th width="10%">Harga HPP</th>
                                                                    <!-- <th width="10%">Ttl HPP</th> -->
                                                                    <th width="10%">Aksi</th>
                                                                </tr>
                                                                </thead>
                                                                  <tbody class="dataDetail">
                                                                  </tbody>
                                                                </table>
                                                            </div>

                                                    </form>
<br>
<br>
<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12" align="right">
      <button type="button" id="batal" class="btn btn-xs btn-danger btn-disabled btn-flat batal" title="Batal" onclick="btnBatal()">
                  Batal
      </button>
      <button id="simpan" type="button" class="btn btn-xs btn-primary btn-disabled btn-flat simpan" title="Simpan Data (Ctrl + F10)" onclick="btnSimpan()" disabled="disabled">
                  <i class="fa fa-save"></i> &nbsp;&nbsp; Simpan (Ctrl + F10)
      </button>

      <button id="perbarui" type="button" class="btn btn-xs btn-primary btn-disabled btn-flat perbarui" title="Perbarui Data (Ctrl + F10)" onclick="btnPerbarui()" disabled="disabled" style="display: none;">
                  <i class="fa fa-save"></i> &nbsp;&nbsp; Perbarui (Ctrl + F10)
      </button>
      </div>
</div>





  </div>
</div>

@section("extra_scripts")
<script type="text/javascript">

  var searchitem        =$("#searchitem");
  var i_id              = $("#i_id");
  var i_code            = $("#i_code");
  var itemName          = $("#itemName");
  var fQty             = $("#fQty");
  var cQty             = $("#cQty");

  var s_satuan          =$('#s_satuan') ;
  var dataDetail      = $(".dataDetail");
  var i_price           =$('#i_price');

  var index             =0;
  var tamp              =[];
  var flag              ='PESANAN';
  var dataIndex         =1;

  var hapusDt =[];

$(document).ready(function(){


       $("#searchitem").autocomplete({
        source: baseUrl+'/seach-item-Produksi',
        minLength: 1,
        dataType: 'json',
        select: function(event, ui)
        {
        $('#i_id').val(ui.item.i_id);
        $('#i_code').val(ui.item.i_code);
        $('#searchitem').val(ui.item.label);
        $('#itemName').val(ui.item.item);
        $('#i_price').val(ui.item.i_price);

        $('#fComp').val(ui.item.comp);
        $('#fPosition').val(ui.item.position);

        $('#s_satuan').val(ui.item.satuan);

         $('#stock').val(ui.item.stok);

        fQty.val(1);
        cQty.val(1);
        fQty.focus();

        }
      });

var arrow = {
    left: 37,
    up: 38,
    right: 39,
    down: 40
},

ctrl = 17;
 $('.minu').keydown(function(e) {
                      if (e.ctrlKey && e.which === arrow.right) {

                         var index = $('.minu').index(this) + 1;
                         $('.minu').eq(index).focus();

                      }
                       if (e.ctrlKey && e.which === arrow.left) {
                      /*if (e.keyCode == ctrl && arrow.left) {*/
                         var index = $('.minu').index(this) - 1;
                         $('.minu').eq(index).focus();
                      }
    });


     });


 $('#searchitem').keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
  var code = $('#searchitem').val();
  $.ajax({
    source: baseUrl+'/seach-item-purchase?id_supplier='+$('#id_supplier').val(),
    type: 'get',
    dataType:'json',
    data: {code:code},
    success:function (response){

        $('#i_id').val(response[0].i_id);
        $('#i_code').val(response[0].i_code);
        $('#searchitem').val(response[0].label);
        $('#itemName').val(response[0].item);
        $('#i_price').val(response[0].i_price);

        $('#s_satuan').val(response[0].satuan);

        $('#stock').val(response[0].stok);


        fQty.val(1);
        fQty.focus();


    }
  })
  }
  });


   function setFormDetail(){
      if(i_id.val()==''){
      return false;
      }
      console.log('sebelum' + tamp);
      if(fQty.val()<=0){
          iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah permintaan tidak boleh 0.",
              });
          return false;
      }
      var index = tamp.indexOf(i_id.val());
       if ( index == -1){
      var Hapus = '<button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButton('+i_id.val()+')"><i class="fa fa-trash-o"></i></button>';
      var vTotalPerItem = angkaDesimal(fQty.val())*angkaDesimal(i_price.val());
      var iSalesDetail='';  //isi
          /*iSalesDetail+='<tr>';        */
          iSalesDetail+='<tr class="detail'+i_id.val()+'">';
          iSalesDetail+='<td width="23%"><input style="width:100%" type="hidden" name="prdt_item[]" value='+i_id.val()+'>';

          iSalesDetail+='<input value="'+$('#fComp').val()+'" style="width:100%" type="hidden" name="comp[]">';
          iSalesDetail+='<input value="'+$('#fPosition').val()+'" style="width:100%" type="hidden" name="position[]">';

          iSalesDetail+='<input style="width:100%" type="hidden" name="prdt_productresult[]" value="">';
          iSalesDetail+='<input style="width:100%" type="hidden" name="prdt_detailid[]" value="">';
          iSalesDetail+='<div style="padding-top:6px">'+i_code.val()+' - '+itemName.val()+'</div></td>';

          iSalesDetail+='<td width="4%"><input class="stock stock'+i_id.val()+' form-control" style="width:100%;text-align:right;border:none" value='+$('#stock').val()+' readonly></td>';

          iSalesDetail+='<td width="4%" style="display:none"><input class="jumlahAwal'+i_id.val()+'" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="0"></td>';

          iSalesDetail+='<td width="4%"><input  onblur="validationForm();setQty(event,\'fQty' + i_id.val() + '\')" onkeyup="hapusTrDt(event,'+i_id.val()+');hitungTotalHpp(\'' + i_id.val() + '\')" onclick="setAwal(event,\'fQty' + i_id.val() + '\')" class="move up1  alignAngka jumlah fQty'+i_id.val()+'" style="width:100%;bor class="move up1  alignAngka jumlah fQty'+i_id.val()+'" style="width:100%;border:none" name="prdt_qty[]" value="'+SetFormRupiah(angkaDesimal(fQty.val()))+'" autocomplete="off"></td>';

          iSalesDetail+='<td width="5%"><div style="padding-top:6px">'+s_satuan.val()+'</div></td>';

          iSalesDetail+='<td width="6%"><input class="move up2 harga'+i_id.val()+' alignAngka form-control" onblur="validationForm();setRupiah(event,\'harga' + i_id.val() + '\')" onkeyup="hapusTrDt(event,'+i_id.val()+');hitungTotalHpp(\'' + i_id.val() + '\')" onclick="setAwal(event,\'harga' + i_id.val() + '\')"  style="width:100%;border:none" name="prdt_hpp[]" value="'+i_price.val()+'"" ></td>';


        /*  iSalesDetail+='<td width="10%""><input style="width:100%;border:none" name="sd_total_disc[]" class="totalPerItemDisc alignAngka totalPerItemDisc'+i_id.val()+'" readonly></td>';  */
          iSalesDetail+='<td align="center" width="3%">'+Hapus+'</td>'                            
          iSalesDetail+='</tr>';
          if(validationForm()){
          dataDetail.append(iSalesDetail);
          $('.totalPerItem'+i_id.val()).val(SetFormRupiah(vTotalPerItem));
          $('.totalPerItemDisc'+i_id.val()).val(SetFormRupiah(vTotalPerItem));
          searchitem.focus();
          itemName.val('');
          searchitem.val('');
          fQty.val('');
           $('#stock').val('');

          tamp.push(i_id.val());

          $('.reset-seach').val('');
          validationForm();



var arrow = {
    left: 37,
    up: 38,
    right: 39,
    down: 40
},

ctrl = 17;
         $('.move').keydown(function (e) {
                    if (e.ctrlKey && e.which === arrow.right) {

                         var index = $('.move').index(this) + 1;
                         $('.move').eq(index).focus();

                      }
                       if (e.ctrlKey && e.which === arrow.left) {
                      /*if (e.keyCode == ctrl && arrow.left) {*/
                         var index = $('.move').index(this) - 1;
                         $('.move').eq(index).focus();
                      }
                      if (e.ctrlKey && e.which === arrow.up) {

                         var upd=$(this).attr('class').split(' ')[ 1 ];

                         var index = $('.'+upd).index(this) - 1;
                         $('.'+upd).eq(index).focus();
                      }
                      if (e.ctrlKey && e.which === arrow.down) {

                         var upd=$(this).attr('class').split(' ')[ 1 ];

                         var index = $('.'+upd).index(this) + 1;
                         $('.'+upd).eq(index).focus();

                      }

     });

          }

      }else{
        var updateQty=0;
        var updateTotalPerItem=0;
        var fStok=parseFloat(angkaDesimal($('.stock'+i_id.val()).val()));
        var a=0;
        var b=0;

        a=angkaDesimal($('.fQty'+i_id.val()).val()) || 0;

        b=angkaDesimal(fQty.val()) || 0;

        updateQty=SetFormRupiah(parseFloat(a)+parseFloat(b));

        /*if(fStok>=updateQty){*/
          $('.fQty'+i_id.val()).val(updateQty)
          itemName.val('');
          fQty.val('');
          $('#stock').val('');
          searchitem.val('');
          searchitem.focus();
         hitungTotalHpp(i_id.val());
        $('.reset-seach').val('');
        /*}else{
              iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah sdsds.",
              });
        }*/
      }
console.log('setelah' + tamp);
    }


 fQty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
          setFormDetail();
      }
    });




function validationForm(){
  $chekDetail=0;

  for (var i=0 ; i <tamp.length; i++) {
      if($('.fQty'+tamp[0]).val()=='' || $('.fQty'+tamp[0]).val()=='0'){
          $chekDetail++;
      }
  }
  if($chekDetail>0){
    if(tamp.length!=0){

      iziToast.error({
                          position:'topRight',
                          timeout: 2000,
                          title: '',
                          message: "Ma'af, data detail belum sesuai.",
                        });
  }
    $('.btn-disabled').attr('disabled','disabled');
    $('.fQty'+tamp[0]).focus();
    $('.fQty'+tamp[0]).css('border','2px solid red');
    return false;
  }else{
    $('.fQty'+tamp[0]).css('border','none');
    $('.btn-disabled').removeAttr('disabled');
    if(tamp.length==0){
      $('.btn-disabled').attr('disabled',true);
    }else if(tamp.length!=0){
      $('.btn-disabled').attr('disabled',false);
    }
    return true;
  }

}



  function btnBatal(){

    $('#pr_id').val('');
    $('#pr_date').val('{{date('d-m-Y')}}');
    $('#pr_code').val("Auto");
    $('#pr_note').val('');
            dataDetail.html('');
            tamp=[];
            hapus =[];
            hapusDt =[];
$('#simpan').css('display','');
$('#perbarui').css('display','none');
  }

  $('#pr_date').datepicker({
      format:"dd-mm-yyyy",
      autoclose: true,
}).datepicker( "setDate",  new Date());



function hapusTrDt(e,a){

    if(e.which===46 && e.ctrlKey){
      hapusDt.push(a);
        $('.detail'+a).remove();
        var index = tamp.indexOf(''+a);
        if(index!==-1)
        tamp.splice(index,1);
      validationForm();
    }
}


function hapusButton(a){
      a=''+a;
      hapusDt.push(a);
        $('.detail'+a).remove();
        var index = tamp.indexOf(''+a);
        if(index!==-1)
        tamp.splice(index,1);
      validationForm();

}

function hitungTotalHpp(id){

    total = angkaDesimal($('.harga'+id).val()) * angkaDesimal($('.fQty'+id).val()) ;
    $('.totalPerItemDisc'+id).val(SetFormRupiah(total));
}

$('#fQty').keyup(function(e) {

    if($('#cQty').val()==='1' &&  e.which != 13){
        $('#cQty').val('');
        $('#fQty').val($('#fQty').val().substring(1));
    }
  })

$('#searchitem').click(function(){
    $('.reset-seach').val('');
});


function btnSimpan(){
  simpan();
}

function simpan(){
  $('.btn-disabled').attr('disabled','disabled');
  var formPos=$('#kirimData').serialize();

     $.ajax({
          url     :  baseUrl+'/produksi/hasil-produksi/create',
          /*type    : 'POST',*/
          type    : 'GET',
          data    :  formPos+'&status='+status,
          dataType: 'json',
          success : function(response){
                    if(response.status=='sukses'){
                        dataDetail.html('');
                        tamp=[];
                        hapus =[];
                        hapusDt =[];
                        $('.btn-disabled').removeAttr('disabled');
                        tablex.ajax.reload();
                        iziToast.success({
                        position: "center",
                        title: '',
                        timeout: 1000,
                        message: 'Data berhasil disimpan.'});
                         $('#pr_date').focus();
                         btnBatal();
                        }
                       else if(response.status=='gagal'){
                      $('.btn-disabled').removeAttr('disabled');
                        iziToast.error({
                          position:'topRight',
                          timeout: 2000,
                          title: '',
                          message: response.data,
                        });



                    }
          }
      });
}




function perbarui(){
  var id=$('#pr_id').val();
  $('.btn-disabled').attr('disabled','disabled');
  var formPos=$('#kirimData').serialize();
     $.ajax({
          url     :  baseUrl+'/produksi/hasil-produksi/update/'+id,
          /*type    : 'POST',*/
          type    : 'GET',
          data    :  formPos+'&hapusdtHasil='+hapusDt,
          dataType: 'json',
          success : function(response){
                    if(response.status=='sukses'){
                        dataDetail.html('');
                        tamp=[];
                        hapus =[];
                        hapusDt =[];
                        $('.btn-disabled').removeAttr('disabled');
                        tablex.ajax.reload();
                        iziToast.success({
                        position: "center",
                        title: '',
                        timeout: 1000,
                        message: 'Data berhasil diperbarui.'});
                         $('#pr_date').focus();
                         btnBatal();
                        }
                       else if(response.status=='gagal'){
                      $('.btn-disabled').removeAttr('disabled');
                        iziToast.error({
                          position:'topRight',
                          timeout: 2000,
                          title: '',
                          message: response.data,
                        });



                    }
          }
      });
}
function btnPerbarui(){
  perbarui();
}

var d = new Date();

d.setDate(d.getDate()-7);

/*d.toLocaleString();*/
$('#tanggal1').datepicker({
      format:"dd-mm-yyyy",
      autoclose: true,
}).datepicker( "setDate", d);
$('#tanggal2').datepicker({
      format:"dd-mm-yyyy",
      autoclose: true,
}).datepicker( "setDate", new Date());
</script>
@endsection()
