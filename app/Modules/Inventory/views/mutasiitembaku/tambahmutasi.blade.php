@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
  .error { border: 1px solid #f00; }
  .valid { border: 1px solid #8080ff; }
  .has-error .select2-selection {
    border: 1px solid #f00 !important;
  }
  .has-valid .select2-selection {
    border: 1px solid #8080ff !important;
  }
</style>
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
          <div class="page-title"></div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
          <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li class="active">Mutasi Item Bahan Baku</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Item Bahan Baku&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
      </ol>
      <div class="clearfix">
      </div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

    <div class="page-content fadeInRight">
      <div id="tab-general">
        <div class="row mbl">
          <div class="col-lg-12">

            <div class="col-md-12">
                <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                </div>
            </div>
        <form id="datab">
            <ul id="generalTab" class="nav nav-tabs">
              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Mutasi Item</a></li>
            </ul>

            <div id="generalTabContent" class="tab-content responsive">
              <div id="alert-tab" class="tab-pane fade in active">
                <div class="row">

                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                    <div class="col-md-5 col-sm-6 col-xs-8" >
                      <h4></h4>
                    </div>

                    <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                      <a href="{{ url('purcahse-order/order-index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                    </div>
                  </div>


                  <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Tanggal Mutasi</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" id="m_date" class="form-control input-sm m_date"  value="{{date('d-m-Y')}}" name="mi_date">
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">No Mutasi</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" readonly="" name="mi_code" placeholder="(Auto)">
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label class="tebal">Keterangan</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <textarea  class="form-control" name="mi_keterangan"></textarea>
                </div>
              </div>


            </div><!-- end div row -->





                  </div>



 <div class="col-md-12 tamma-bg" style="margin-top: 5px;margin-bottom: 5px;margin-bottom: 20px; padding-bottom:20px;padding-top:20px;">
        <div class="col-md-2">
           <label class="control-label tebal" for="">Jenis</label>
              <div class="input-group input-group-sm" style="width: 100%;">
                 <select style="width: 100%;" id="jenis" name="jenis" class="jenis">
                     <option>Bahan</option>
                     <option>Hasil Jadi</option>
                 </select>
              </div>
          </div>

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
                 <input type="number" class="move up3 form-control input-sm alignAngka reset reset-seach" name="fQty" id="fQty" onclick="validationForm();" >
                 <input type="hidden" class="form-control input-sm alignAngka reset reset-seach" name="cQty" id="cQty" onclick="validationForm();">
              </div>
          </div>
    </div>


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



<div class="col-md-12 col-sm-12 col-xs-12" align="right">
    <button type="button" class="btn btn-xs btn-primary btn-disabled btn-flat" title="Simpan Data (Ctrl + F10)" onclick="btnSimpan()" disabled="disabled">
            <i class="fa fa-save"></i> Simpan (Ctrl + F10)
    </button>
</div>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
  </form>
  <!--END PAGE WRAPPER-->

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  var searchitem        =$("#searchitem");
  var i_id              = $("#i_id");
  var i_code            = $("#i_code");
  var itemName          = $("#itemName");
  var fQty              = $("#fQty");
  var cQty              = $("#cQty");

  var s_satuan          =$('#s_satuan') ;
  var dBahan            = $(".dBahan");
  var dHasil            = $(".dHasil");
  var i_price           =$('#i_price');

  var index             =0;
  var tampBahan         =[];
  var tampHasil         =[];

  var dataIndex         =1;

  var hapusSalesDt =[];


    $('#m_date').datepicker({
          format:"dd-mm-yyyy",
          autoclose: true,
      });

$(document).ready(function(){


       $("#searchitem").autocomplete({
        source: baseUrl+'/inventory/mutasiitembaku/searchItem',
        minLength: 1,
        dataType: 'json',
        select: function(event, ui)
        {
        $('#i_id').val(ui.item.i_id);
        $('#i_code').val(ui.item.i_code);
        $('#searchitem').val(ui.item.label);
        $('#itemName').val(ui.item.item);
        $('#i_price').val(ui.item.i_price);

        $('#s_satuan').val(ui.item.satuan);
        var jumlah=0;
        if($('.jumlahAwal'+i_id.val()).val()!=undefined){
            jumlah=parseFloat(ui.item.stok)+parseFloat($('.jumlahAwal'+i_id.val()).val());
            $('#stock').val(jumlah);
        }else{
            $('#stock').val(ui.item.stok);
        }

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

        $("#customer").autocomplete({
        source: baseUrl+'/customer',
        minLength: 1,
        dataType: 'json',
        select: function(event, ui)
        {
        $('#customer').val(ui.item.label);
        $('#s_customer').val(ui.item.c_id);
        $('#biaya_kirim').focus();


        }
      });

     });


 //fungsi barcode
   $('#searchitem').keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
  var code = $('#searchitem').val();
  $.ajax({
    url : baseUrl + "/item/search-item/code",
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
        var jumlah=0;
        if($('.jumlahAwal'+i_id.val()).val()!=undefined){
            jumlah=parseFloat(response[0].stok)+parseFloat($('.jumlahAwal'+i_id.val()).val());
            $('#stock').val(response[0]);
        }else{
            $('#stock').val(response[0].stok);
        }

        fQty.val(1);
        fQty.focus();


    }
  })
  }
  });


    fQty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
            if($('#jenis').val()=='Bahan'){
               setFormDetailBahan();
            }else if($('#jenis').val()=='Hasil Jadi'){
                setFormDetailHasil();
            }

      }
    });


    function setFormDetailBahan(){
      console.log('sebelum' + tampBahan);
      if(fQty.val()<=0){
          iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah permintaan tidak boleh 0.",
              });
          return false;
      }
      var index = tampBahan.indexOf(i_id.val());
       if ( index == -1){
      var Hapus = '<button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButtonBahan('+i_id.val()+')"><i class="fa fa-trash-o"></i></button>';
      var vTotalPerItem = angkaDesimal(fQty.val())*angkaDesimal(i_price.val());
      var iSalesDetail='';  //isi
          /*iSalesDetail+='<tr>';        */
          iSalesDetail+='<tr class="detail'+i_id.val()+'">';
          iSalesDetail+='<td width="23%"><input style="width:100%" type="hidden" name="mm_item[]" value='+i_id.val()+'>';
          iSalesDetail+='<input style="width:100%" type="hidden" name="mm_mutationitem[]" value="">';
          iSalesDetail+='<input style="width:100%" type="hidden" name="mm_detailid[]" value="">';
          iSalesDetail+='<div style="padding-top:6px">'+i_code.val()+' - '+itemName.val()+'</div></td>';

          iSalesDetail+='<td width="4%"><input class="stock stock'+i_id.val()+'" style="width:100%;text-align:right;border:none" value='+$('#stock').val()+' readonly></td>';

          iSalesDetail+='<td width="4%" style="display:none"><input class="jumlahAwal'+i_id.val()+'" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="0"></td>';

          iSalesDetail+='<td width="4%"><input  onblur="validationForm();" onkeyup="hapus(event,'+i_id.val()+');" class="move up1  alignAngka jumlah fQty'+i_id.val()+'" style="width:100%;border:none" name="mm_qty[]" value="'+angkaDesimal(fQty.val())+'" autocomplete="off"></td>';

          iSalesDetail+='<td width="5%"><div style="padding-top:6px">'+s_satuan.val()+'</div></td>';

          iSalesDetail+='<td width="3%">'+Hapus+'</td>'
          iSalesDetail+='</tr>';
          if(validationForm()){

          dBahan.append(iSalesDetail);

          $('.totalPerItem'+i_id.val()).val(SetFormRupiah(vTotalPerItem));
          $('.totalPerItemDisc'+i_id.val()).val(SetFormRupiah(vTotalPerItem));
          searchitem.focus();
          itemName.val('');
          searchitem.val('');
          fQty.val('');
           $('#stock').val('');

          tampBahan.push(i_id.val());

          $('.reset-seach').val('');



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
        var fStok=parseFloat($('.stock'+i_id.val()).val());
        var a=0;
        var b=0;

        a=angkaDesimal($('.fQty'+i_id.val()).val()) || 0;

        b=angkaDesimal(fQty.val()) || 0;



        updateQty=parseFloat(a)+parseFloat(b);
        if(fStok>=updateQty){
          $('.fQty'+i_id.val()).val(updateQty)
          itemName.val('');
          fQty.val('');
          $('#stock').val('');
          searchitem.val('');
          searchitem.focus();

        $('.reset-seach').val('');
        }else{
              iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah sdsds.",
              });
        }
      }

    }



    function setFormDetailHasil(){
      console.log('sebelum' + tampHasil);
      if(fQty.val()<=0){
          iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah permintaan tidak boleh 0.",
              });
          return false;
      }
      var index = tampHasil.indexOf(i_id.val());
       if ( index == -1){
      var Hapus = '<button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButton('+i_id.val()+')"><i class="fa fa-trash-o"></i></button>';
      var vTotalPerItem = angkaDesimal(fQty.val())*angkaDesimal(i_price.val());
      var iSalesDetail='';  //isi
          /*iSalesDetail+='<tr>';        */
          iSalesDetail+='<tr class="detail'+i_id.val()+'">';
          iSalesDetail+='<td width="23%"><input style="width:100%" type="hidden" name="mp_item[]" value='+i_id.val()+'>';
          iSalesDetail+='<input style="width:100%" type="hidden" name="mp_mutationitem[]" value="">';
          iSalesDetail+='<input style="width:100%" type="hidden" name="mp_detailid[]" value="">';
          iSalesDetail+='<div style="padding-top:6px">'+i_code.val()+' - '+itemName.val()+'</div></td>';

          iSalesDetail+='<td width="4%"><input class="stock stock'+i_id.val()+'" style="width:100%;text-align:right;border:none" value='+$('#stock').val()+' readonly></td>';

          iSalesDetail+='<td width="4%" style="display:none"><input class="jumlahAwal'+i_id.val()+'" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="0"></td>';

          iSalesDetail+='<td width="4%"><input  onblur="validationForm();" onkeyup="hapus(event,'+i_id.val()+');" class="move up1  alignAngka jumlah fQty'+i_id.val()+'" style="width:100%;border:none" name="mp_qty[]" value="'+angkaDesimal(fQty.val())+'" autocomplete="off"></td>';

          iSalesDetail+='<td width="5%"><div style="padding-top:6px">'+s_satuan.val()+'</div></td>';

            iSalesDetail+='<td width="4%"><input class="move up2 alignAngka discRp'+i_id.val()+'" style="width:100%;border:none" name="mp_hpp[]" id="discRp" onkeyup="hapus(event,'+i_id.val()+');hitungTotalPerItemPesanan(\'' + i_id.val() + '\');rege(event,\'discRp' + i_id.val() + '\')" onblur="setRupiah(event,\'discRp' + i_id.val() + '\')" onclick="setAwal(event,\'discRp' + i_id.val() + '\')" onfocus="setAwal(event,\'discRp' + i_id.val() + '\')" value="0" autocomplete="off"></td>';

          iSalesDetail+='<td width="3%">'+Hapus+'</td>'
          iSalesDetail+='</tr>';
          if(validationForm()){

          dHasil.append(iSalesDetail);

          $('.totalPerItem'+i_id.val()).val(SetFormRupiah(vTotalPerItem));
          $('.totalPerItemDisc'+i_id.val()).val(SetFormRupiah(vTotalPerItem));
          searchitem.focus();
          itemName.val('');
          searchitem.val('');
          fQty.val('');
           $('#stock').val('');

          tampHasil.push(i_id.val());

          $('.reset-seach').val('');



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
        var fStok=parseFloat($('.stock'+i_id.val()).val());
        var a=0;
        var b=0;

        a=angkaDesimal($('.fQty'+i_id.val()).val()) || 0;

        b=angkaDesimal(fQty.val()) || 0;



        updateQty=parseFloat(a)+parseFloat(b);
        if(fStok>=updateQty){
          $('.fQty'+i_id.val()).val(updateQty)
          itemName.val('');
          fQty.val('');
          $('#stock').val('');
          searchitem.val('');
          searchitem.focus();

        $('.reset-seach').val('');
        }else{
              iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah sdsds.",
              });
        }
      }

    }


function validationForm(){
  $chekDetail=0;
  for (var i=0 ; i <tampBahan.length; i++) {
      if($('.fQty'+tampBahan[0]).val()=='' || $('.fQty'+tampBahan[0]).val()=='0'){
          $chekDetail++;
      }
  }
  if($chekDetail>0){
      iziToast.error({
                          position:'topRight',
                          timeout: 2000,
                          title: '',
                          message: "Ma'af, data detail belum sesuai.",
                        });
    $('.btn-disabled').attr('disabled','disabled');
    $('.fQty'+tampBahan[0]).focus();
    $('.fQty'+tampBahan[0]).css('border','2px solid red');
    return false;
  }else{
    $('.fQty'+tampBahan[0]).css('border','none');
    $('.btn-disabled').removeAttr('disabled');
    return true;
  }

}

$('#fQty').keyup(function(e) {

    if($('#cQty').val()==='1' &&  e.which != 13){
        $('#cQty').val('');
        $('#fQty').val($('#fQty').val().substring(1));
    }
  })




function simpan(){
  $('.btn-disabled').attr('disabled','disabled');
  var form=$('#datab').serialize();
  alert(form);
     $.ajax({
          url     :  baseUrl+'/inventory/mutasiitembaku/store',
          type    : 'GET',
          data    :  form,
          dataType: 'json',
          success : function(response){

                    if(response.status=='sukses'){
                      $('.tr_clone').html('');
                      payment();
                      tamp=[];
                      hapusSalesDt=[];
                        $('#kembalian').attr('disabled','disabled');
                        $('#totalBayar').attr('disabled','disabled');
                        tablex.ajax.reload();
                        bSalesDetail.html('');
                        $('.reset').val('');
                        $('#proses').modal('hide');

                        iziToast.success({
                        position: "center",
                        title: '',
                        timeout: 1000,
                        message: 'Data berhasil disimpan.'});

                        }
                        $('#s_date').val('{{date("d-m-Y")}}');
                        $('#s_created_by').val('{{Auth::user()->m_name}}');
                        $('#s_date').focus();
                        if(response.s_status=='final'){
                        window.open(baseUrl+'/penjualan/pos-toko/printNota/'+response.s_id,'_blank');
                    }else if(response.status=='gagal'){
                      $('.btn-disabled').removeAttr('disabled');
                      $('#kembalian').attr('disabled','disabled');
                      $('#totalBayar').attr('disabled','disabled');

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



function btnSimpan(){
  simpan();
}



</script>

@endsection
