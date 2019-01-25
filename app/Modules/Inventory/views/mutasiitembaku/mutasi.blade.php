@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Mutasi Item Bahan Baku</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Mutasi Item Bahan Baku </li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="page-content fadeInRight">
                    <div id="tab-general">
                        <div class="row mbl">
                            <div class="col-lg-12">

                              <div class="col-md-12">
                                  <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                                  </div>
                              </div>



                              <ul id="generalTab" class="nav nav-tabs">
                                <li class="active"><a id="detail" href="#gudangtogudang" data-toggle="tab">Mutasi Item</a></li>
                                <li><a href="#form-mutasi" id="from" data-toggle="tab">Form Mutasi</a></li>
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                <!-- div gudangtogudang -->
                                {!!$mutasiItem!!}
                                <!-- /div gudangtogudang -->

                               {!!$form!!}

                                </div>

            </div>
          </div>

        </div>
      </div>
    </div>

@endsection
@section("extra_scripts")
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


// hasil
  var mp_searchitem        =$("#mp_searchitem");
  var mp_i_id              = $("#mp_i_id");
  var mp_i_code            = $("#mp_i_code");
  var mp_itemName          = $("#mp_itemName");
  var mp_fQty              = $("#mp_fQty");
  var mp_cQty              = $("#mp_cQty");

  var mp_s_satuan          =$('#mp_s_satuan') ;
  var mp_i_price           =$('#mp_i_price');




//selesai hasil



  var index             =0;
  var tampBahan         =[];
  var tampHasil         =[];

  var dataIndex         =1;

  var hapusBahan =[];
  var hapusHasil =[];


    $('#mi_date').datepicker({
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
        $('#fComp').val(ui.item.comp);
        $('#fPosition').val(ui.item.position);
        $('#s_satuan').val(ui.item.satuan);
        var jumlah=0;

        if($('.jumlahAwal'+i_id.val()).val()!=undefined){
            jumlah=parseFloat(angkaDesimal(ui.item.stok))+parseFloat(angkaDesimal($('.jumlahAwal'+i_id.val()).val()));
            $('#stock').val(SetFormRupiah(jumlah));
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

//hasil

$(document).ready(function(){


       $("#mp_searchitem").autocomplete({
        source: baseUrl+'/inventory/mutasiitembaku/searchItem',
        minLength: 1,
        dataType: 'json',
        select: function(event, ui)
        {
        $('#mp_i_id').val(ui.item.i_id);
        $('#mp_i_code').val(ui.item.i_code);
        $('#mp_searchitem').val(ui.item.label);
        $('#mp_itemName').val(ui.item.item);
        $('#mp_i_price').val(ui.item.i_price);

        $('#mp_fComp').val(ui.item.comp);
        $('#mp_fPosition').val(ui.item.position);

        $('#mp_s_satuan').val(ui.item.satuan);

         $('#mp_stock').val(ui.item.stok);

        mp_fQty.val(1);
        mp_cQty.val(1);
        mp_fQty.focus();

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

//selesai hasil




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
             jumlah=parseFloat(angkaDesimal(response[0].stok))+parseFloat(angkaDesimal($('.jumlahAwal'+i_id.val()).val()));
            $('#stock').val(SetFormRupiah(jumlah));
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
      if(parseFloat(angkaDesimal(fQty.val())) > parseFloat(angkaDesimal($('#stock').val())) ||
        parseFloat(angkaDesimal($('#stock').val()))<=0){
              iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah permintaan melebihi stok gudang.",
              });
        return false;
      }else if($('#stock').val()==''){
          iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, barang harus dipilih.",
              });
          $('.reset-seach').val('');
          searchitem.focus();
          $('#fQty').val('');
          $('#cQty').val('');

        }
        else{
         if($('#jenis').val()=='Bahan'){
               setFormDetailBahan();
            }else if($('#jenis').val()=='Hasil Jadi'){
                setFormDetailHasil();
            }
        }
      }
    } );




    //bahan hasil

    mp_fQty.keypress(function(e) {
      if(e.which == 13 || e.keyCode == 13){
          setFormDetailHasil();
      }
    });
    //hasil selesai





    function setFormDetailBahan(){

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
          iSalesDetail+='<tr class="detailBahan'+i_id.val()+'">';
          iSalesDetail+='<td width="23%"><input style="width:100%" type="hidden" name="mm_item[]" value='+i_id.val()+'>';
          iSalesDetail+='<input style="width:100%" type="hidden" name="mm_mutationitem[]" value="">';
          iSalesDetail+='<input style="width:100%" type="hidden" name="mm_detailid[]" value="">';


          iSalesDetail+='<input value="'+$('#fComp').val()+'" style="width:100%" type="hidden" name="mm_comp[]">';
          iSalesDetail+='<input value="'+$('#fPosition').val()+'" style="width:100%" type="hidden" name="mm_position[]">';


          iSalesDetail+='<div style="padding-top:6px">'+i_code.val()+' - '+itemName.val()+'</div></td>';

          iSalesDetail+='<td width="4%"><input class="stock stock'+i_id.val()+'" style="width:100%;text-align:right;border:none" value='+$('#stock').val()+' readonly></td>';

          iSalesDetail+='<td width="4%" style="display:none"><input class="jumlahAwal'+i_id.val()+'" style="width:100%;text-align:right;border:none" name="jumlahAwalBahan[]" value="0"></td>';

          iSalesDetail+='<td width="4%"><input  onblur="validationFormBahan();setQty(event,\'fQty' + i_id.val() + '\')" onkeyup="cekStockMutasi('+i_id.val()+');hapusBahanB(event,'+i_id.val()+');" class="move up1  alignAngka jumlah fQty'+i_id.val()+'" style="width:100%;border:none" name="mm_qty[]" value="'+SetFormRupiah(angkaDesimal(fQty.val()))+'" autocomplete="off"></td>';

          iSalesDetail+='<td width="5%"><div style="padding-top:6px">'+s_satuan.val()+'</div></td>';

          iSalesDetail+='<td width="3%">'+Hapus+'</td>'
          iSalesDetail+='</tr>';
          if(validationFormBahan()){

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
        var fStok=parseFloat(angkaDesimal($('.stock'+i_id.val()).val()));
        var a=0;
        var b=0;

        a=angkaDesimal($('.fQty'+i_id.val()).val()) || 0;

        b=angkaDesimal(fQty.val()) || 0;


        updateQty=SetFormRupiah(parseFloat(a)+parseFloat(b));
        if(fStok>=(parseFloat(a)+parseFloat(b))){
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
                message: "Ma'af, jumlah permintaan melebihi stok gudang.",
              });
        }
      }

    }



    function setFormDetailHasil(){
      console.log('sebelum' + tampHasil);
      if(mp_fQty.val()<=0){
          iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah permintaan tidak boleh 0.",
              });
          return false;
      }
      var index = tampHasil.indexOf(mp_i_id.val());
       if ( index == -1){
      var Hapus = '<button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButtonHasil('+mp_i_id.val()+')"><i class="fa fa-trash-o"></i></button>';
      var vTotalPerItem = angkaDesimal(mp_fQty.val())*angkaDesimal(mp_i_price.val());
      var iSalesDetail='';  //isi
          /*iSalesDetail+='<tr>';        */
          iSalesDetail+='<tr class="detailHasil'+mp_i_id.val()+'">';
          iSalesDetail+='<td width="23%"><input style="width:100%" type="hidden" name="mp_item[]" value='+mp_i_id.val()+'>';
          iSalesDetail+='<input style="width:100%" type="hidden" name="mp_mutationitem[]" value="">';
          iSalesDetail+='<input style="width:100%" type="hidden" name="mp_detailid[]" value="">';


          iSalesDetail+='<input value="'+$('#mp_fComp').val()+'" style="width:100%" type="hidden" name="mp_comp[]">';
          iSalesDetail+='<input value="'+$('#mp_fPosition').val()+'" style="width:100%" type="hidden" name="mp_position[]">';


          iSalesDetail+='<div style="padding-top:6px">'+mp_i_code.val()+' - '+mp_itemName.val()+'</div></td>';

          iSalesDetail+='<td width="4%"><input class="stock stock'+mp_i_id.val()+'" style="width:100%;text-align:right;border:none" value='+$('#mp_stock').val()+' readonly></td>';

          iSalesDetail+='<td width="4%" style="display:none"><input class="jumlahAwal'+mp_i_id.val()+'" style="width:100%;text-align:right;border:none" name="jumlahAwalHasil[]" value="0"></td>';

          iSalesDetail+='<td width="4%"><input  onblur="validationFormHasil();setQty(event,\'fQty' + mp_i_id.val() + '\')" onkeyup="hapusHasilH(event,'+mp_i_id.val()+');" class="move up1  alignAngka jumlah fQty'+mp_i_id.val()+'" style="width:100%;border:none" name="mp_qty[]" value="'+SetFormRupiah(angkaDesimal(mp_fQty.val()))+'" autocomplete="off"></td>';

          iSalesDetail+='<td width="5%"><div style="padding-top:6px">'+mp_s_satuan.val()+'</div></td>';

            iSalesDetail+='<td width="4%"><input class="move up2 alignAngka discRp'+mp_i_id.val()+'" style="width:100%;border:none" name="mp_hpp[]" id="discRp" onkeyup="hapusHasilH(event,'+mp_i_id.val()+');rege(event,\'discRp' + mp_i_id.val() + '\')" onblur="setRupiah(event,\'discRp' + mp_i_id.val() + '\')" onclick="setAwal(event,\'discRp' + mp_i_id.val() + '\')" onfocus="setAwal(event,\'discRp' + mp_i_id.val() + '\')" value="0" autocomplete="off"></td>';

          iSalesDetail+='<td width="3%">'+Hapus+'</td>'
          iSalesDetail+='</tr>';
          if(validationFormHasil()){

          dHasil.append(iSalesDetail);


          mp_searchitem.focus();
          mp_itemName.val('');
          mp_searchitem.val('');
          mp_fQty.val('');
           $('#stock').val('');

          tampHasil.push(mp_i_id.val());

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
        var mp_fStok=parseFloat(angkaDesimal($('.stock'+mp_i_id.val()).val()));
        var a=0;
        var b=0;

        a=angkaDesimal($('.fQty'+mp_i_id.val()).val()) || 0;

        b=angkaDesimal(mp_fQty.val()) || 0;

        updateQty=SetFormRupiah(parseFloat(a)+parseFloat(b));


          $('.fQty'+mp_i_id.val()).val(updateQty)
          mp_itemName.val('');
          mp_fQty.val('');
          $('#stock').val('');
          mp_searchitem.val('');
          mp_searchitem.focus();
        $('.reset-seach').val('');

      }

    }


function validationFormBahan(){
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



function validationFormHasil(){
  $chekDetail=0;
  for (var i=0 ; i <tampHasil.length; i++) {
      if($('.fQty'+tampHasil[0]).val()=='' || $('.fQty'+tampHasil[0]).val()=='0'){
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
    $('.fQty'+tampHasil[0]).focus();
    $('.fQty'+tampHasil[0]).css('border','2px solid red');
    return false;
  }else{
    $('.fQty'+tampHasil[0]).css('border','none');
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

$('#mp_fQty').keyup(function(e) {

    if($('#mp_cQty').val()==='1' &&  e.which != 13){
        $('#mp_cQty').val('');
        $('#mp_fQty').val($('#mp_fQty').val().substring(1));
    }
  })





function simpan(){
  $('.btn-disabled').attr('disabled','disabled');
  var form=$('#datab').serialize();

     $.ajax({
          url     :  baseUrl+'/inventory/mutasiitembaku/store',
          type    : 'GET',
          data    :  form,
          dataType: 'json',
          success : function(response){

                    if(response.status=='sukses'){
         btnBatal();
            tablex.ajax.reload();
            $('.reset').val('');
                        iziToast.success({
                        position: "center",
                        title: '',
                        timeout: 1000,
                        message: 'Data berhasil disimpan.'});

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
  var mi_id=$('#mi_id').val();
  $('.btn-disabled').attr('disabled','disabled');
  var form=$('#datab').serialize();
     $.ajax({
          url     :  baseUrl+'/inventory/mutasiitembaku/perbarui/'+mi_id,
          type    : 'GET',
          data    :  form+'&hapusdtBahan='+hapusBahan+'&hapusdtHasil='+hapusHasil,
          dataType: 'json',
          success : function(response){

                    if(response.status=='sukses'){
         btnBatal();
            tablex.ajax.reload();
            $('.reset').val('');
                        iziToast.success({
                        position: "center",
                        title: '',
                        timeout: 1000,
                        message: 'Data berhasil disimpan.'});

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

function btnSimpan(){
  simpan();
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


  $('#searchitem').click(function(){
    $('.reset-seach').val('');

});


$('#mp_searchitem').click(function(){
    $('.reset-seach').val('');

});

</script>
      </script>
@endsection()
