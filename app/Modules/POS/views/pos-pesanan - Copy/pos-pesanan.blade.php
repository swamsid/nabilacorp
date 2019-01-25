@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">POS Penjualan Pesanan</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;<a href="{{url('penjualan/POSpenjualan/POSpenjualan')}}">POS Penjualan Pesanan</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">POS Penjualan Pesanan</li>
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
                                <li class="active"><a id="penjualan" href="#toko" data-toggle="tab">Penjualan Pesanan</a></li>
                                <li><a id="list" href="#listtoko" data-toggle="tab">List Penjualan Pesanan</a></li><!-- 
                                <li><a href="#mobil" data-toggle="tab">Penjualan Mobil</a></li>
                                <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
                                <!-- <li><a href="#konsinyasi" data-toggle="tab">Penjualan Konsinyasi</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                <!-- Modal -->
                               {!!$data['toko']!!}
                                <!-- End Modal -->
                                
                                <!-- div #alert-tab -->
                                
                                <!-- /div #alert-tab -->

                                <!-- Div #listtoko -->
                                <!-- @include('penjualan.POSpenjualanToko.listtoko') -->                               
                                {!!$data['listtoko']!!}
                                <!-- end div #listoko -->
                           

                            </div> <!-- End div general-content -->
                    
            </div>
          </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">
  //define class dan id
  var searchitem        =$("#searchitem");      
  var i_id              = $("#i_id");      
  var i_code            = $("#i_code");
  var itemName          = $("#itemName");    
  var fQty             = $("#fQty");  
  var s_satuan          =$('#s_satuan') ;
  var bSalesDetail      = $(".bSalesDetail");
  var i_price           =$('#i_price');

  var index             =0;
  var tamp              =[];
  var flag              ='Pesanan';
  var dataIndex         =1;

$(document).ready(function(){          
       $("#searchitem").autocomplete({
        source: baseUrl+'/item',
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
        fQty.focus();
        
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
        
        }
      });

     });

      $('#s_finishdate').datepicker({
          format:"dd-mm-yyyy",        
      });    
      $('#s_duedate').datepicker({
          format:"dd-mm-yyyy",        
      }); 
      $('#s_date').datepicker({
          format:"dd-mm-yyyy",        
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

  
payment();
function addf2(e){
   {                
        if (e.keyCode == 113) {                 
             payment();
        }
    }
    
  }

function payment(){
  $.ajax({
          url     :  baseUrl+'/paymentmethod',
          type    : 'GET', 
          
           data: {
        "dataIndex": dataIndex
            },         
          /*dataType: 'json',*/
          success : function(response){   
            $('.tr_clone').append(response.view);  
            dataIndex=(response.jumlah);
            dataIndex++;            
              }
          });

}

  
    fQty.keypress(function(e) {        
      if(e.which == 13 || e.keyCode == 13){     
      
          setFormDetail();
          totalPerItem();
      }
    } );
 

var tablex;
setTimeout(function () {
            
    tablex = $("#tableListToko").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("penjualan/pos-pesanan/listPenjualan/data") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",
                    "type"  :"Pesanan",
                    },
              },
            columns: [
            {data: 's_date', name: 's_date'},
            {data: 's_note', name: 's_note'},            
            {data: 'c_name', name: 'c_name'},            
            {data: 's_kasir', name: 's_kasir'},            
            {data: 'item', name: 'item'}, 
            
            {data: 's_status', name: 's_status'}, 
            {data: 'action', name: 'action'},
           
            ],
            //responsive: true,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            //"scrollY": '50vh',
            //"scrollCollapse": true,
           
    });
      }, 1500);





    function setFormDetail(){
      var index = tamp.indexOf(i_id.val());      
       if ( index == -1){        
      var Hapus = '<button type="button" class="btn btn-sm btn-danger hapus" onclick="hapus('+i_id.val()+')"><i class="fa fa-trash-o"></i></button>';            
      var vTotalPerItem = angkaDesimal(fQty.val())*angkaDesimal(i_price.val());


      var iSalesDetail='';  //isi
          iSalesDetail+='<tr>';        
          iSalesDetail+='<tr class="detail'+i_id.val()+'">';
          iSalesDetail+='<td><input style="width:100%" type="hidden" name="sd_item[]" value='+i_id.val()+'>'; 
          iSalesDetail+='<input style="width:100%" type="hidden" name="sd_sales[]" value="">';
          iSalesDetail+='<input style="width:100%" type="hidden" name="sd_detailid[]" value="">';
          iSalesDetail+='<div style="padding-top:6px">'+i_code.val()+' - '+itemName.val()+'</div></td>';

          iSalesDetail+='<td><input class="stock stock'+i_id.val()+'" style="width:100%;text-align:right;border:none" value='+$('#stock').val()+'></td>';

          iSalesDetail+='<td style="display:none"><input class="jumlahAwal'+i_id.val()+'" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="0"></td>';

          iSalesDetail+='<td><input onblur="validationForm();" onkeyup="validationForm();hitungTotalPerItemPesanan(\'' + i_id.val() + '\')" class="jumlah fQty'+i_id.val()+'" style="width:100%;text-align:right;border:none" name="sd_qty[]" value='+fQty.val()+'></td>';

          iSalesDetail+='<td><div style="padding-top:6px">'+s_satuan.val()+'</div></td>';
          
          iSalesDetail+='<td><input class="harga'+i_id.val()+' alignAngka" style="width:100%;border:none" name="sd_price[]" value="Rp. '+i_price.val()+'"" readonly></td>';

          iSalesDetail+='<td><input class="alignAngka discRp'+i_id.val()+'" style="width:100%;border:none" name="sd_disc_value[]" id="discRp" onkeyup="hitungTotalPerItemPesanan(\'' + i_id.val() + '\');rege(event,\'discRp' + i_id.val() + '\')" onblur="setRupiah(event,\'discRp' + i_id.val() + '\')" onclick="setAwal(event,\'discRp' + i_id.val() + '\')" value="0"></td>'; 

          iSalesDetail+='<td><input class="alignAngka discP'+i_id.val()+'" onkeyup="hitungTotalPerItemPesanan(\'' + i_id.val() + '\')" style="width:100%;border:none" name="sd_disc_percent[]" id="discP" value="0"></td>'; 

          iSalesDetail+='<td style="display:none"><input class="alignAngka discPV'+i_id.val()+'" onkeyup="hitungTotalPerItemPesanan(\'' + i_id.val() + '\')" style="width:100%;border:none" name="sd_disc_percentvalue[]" id="discPV"></td>'; 
          

          iSalesDetail+='<td style="display:none"><input style="width:100%;border:none" name="sd_total[]" class="totalPerItem alignAngka totalPerItem'+i_id.val()+'" readonly></td>';                   

          iSalesDetail+='<td><input style="width:100%;border:none" name="sd_total_disc[]" class="totalPerItemDisc alignAngka totalPerItemDisc'+i_id.val()+'" readonly></td>';  
          iSalesDetail+='<td>'+Hapus+'</td>';          
          iSalesDetail+='</tr>';        
          if(validationForm()){
          bSalesDetail.append(iSalesDetail);        
          $('.totalPerItem'+i_id.val()).val(SetFormRupiah(vTotalPerItem));
          $('.totalPerItemDisc'+i_id.val()).val(SetFormRupiah(vTotalPerItem));
          searchitem.focus();
          itemName.val('');
          searchitem.val('');
          fQty.val('');
           $('#stock').val('');
          
          tamp.push(i_id.val());

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
        hitungTotalPerItemPesanan(i_id.val());
        }else{            
            toastr.warning("Ma'af, jumlah permintaan melebihi stok gudang.");
        }
      }
console.log(tamp);
    }



function hapus(a){
  $('.detail'+a).remove();
  var index = tamp.indexOf(''+a);  
  if(index!==-1)
  tamp.splice(index,1);
  totalPerItem();
  buttonDisable();
  console.log(tamp);
}





/*$('#add').live('click',function(e){ 
    $(this).closest('tr').remove();    
    
})*/



$('.add1').on('keydown',function(e)
    {           
        if (e.keyCode == 113) {  
            var $tr=$(this).closest('.tr_clone');
            var $clone=$tr.clone();    
            console.log($clone);
            $tr.after($clone);
        }
    }
);



function buttonDisable(){
  if(tamp.length>0){
      $('.btn-disabled').removeAttr('disabled');
  }else{
      $('.btn-disabled').attr('disabled','disabled');
  }
}

function validationForm(){  
  $chekDetail=0;
  for (var i=0 ; i <tamp.length; i++) {
      if($('.fQty'+tamp[0]).val()==''){
          $chekDetail++;
      }
  }
  if($chekDetail>0){
    
    toastr.warning('form isian detail belum lengkap');
    $('.btn-disabled').attr('disabled','disabled');
    $('.fQty'+tamp[0]).focus();
    $('.fQty'+tamp[0]).css('border','2px solid red');
    return false;
  }else{
    $('.fQty'+tamp[0]).css('border','none');
    $('.btn-disabled').removeAttr('disabled');
    return true;
  }

}

function simpanPos(status=''){
  $('#totalBayar').removeAttr('disabled');
  $('#kembalian').removeAttr('disabled');

  var formPos=$('#dataPos').serialize();
     $.ajax({
          url     :  baseUrl+'/penjualan/pos-pesanan/create',
          type    : 'GET', 
          data    :  formPos+'&status='+status,
          dataType: 'json',
          success : function(response){    
                    if(response.status=='sukses'){

                $('.terima').css('display','none');
                        $('#kembalian').attr('disabled','disabled');
                        $('#totalBayar').attr('disabled','disabled');
                        
                        tablex.ajax.reload();
                        bSalesDetail.html('');
                        $('.reset').val('');
                        $('#proses').modal('hide');                        
                        if(response.s_status=='final'){
                        window.open(baseUrl+'/penjualan/pos-toko/printNota/'+response.s_id,'_blank');
                        var win=window.open(baseUrl+'/cut','_blank');

                    var timer = setInterval(function() {
                          if (win.closed) {
                              clearInterval(timer);
                              alert("'Secure Payment' window closed !");
                          }
                      }, 500);

                        }

                        $('#s_date').val('{{date("d-m-Y")}}');                        
                        $('#s_created_by').val('{{Auth::user()->m_name}}');
                    }else if(response.status=='gagal'){
                      $('#kembalian').attr('disabled','disabled');
                      $('#totalBayar').attr('disabled','disabled');
                        alert(response.data);

                    }
          }
      });
}
function modalShow(){
  $('#proses').modal('show');
}
function perbaruiData(){
  $('#kembalian').removeAttr('disabled');
  $('#totalBayar').removeAttr('disabled');

  var formPos=$('#dataPos').serialize();
     $.ajax({
          url     :  baseUrl+'/penjualan/pos-pesanan/update',
          type    : 'GET', 
          data    :  formPos,
          dataType: 'json',
          success : function(response){    
                    if(response.status=='sukses'){
                      $('#kembalian').attr('disabled','disabled');
                      $('#totalBayar').attr('disabled');
                      $('.terima').css('display','none');
                        tablex.ajax.reload();
                        bSalesDetail.html('');
                        $('.reset').val('');                        
                        $('#s_date').val('{{date("d-m-Y")}}');                        
                        $('#s_created_by').val('{{Auth::user()->m_name}}');
                        $('#proses').modal('hide');
                        tamp=[];
                        $('.perbarui').css('display','none');  
                        /*$('.perbarui').attr('disabled');*/
                        $('.final').css('display','');
                        $('.draft').css('display','');

                         if(response.s_status=='final'){
                       var childwindow= window.open(baseUrl+'/penjualan/pos-toko/printNota/'+response.s_id,'_blank');
                       var timer = setInterval(function() {   
                            if(childwindow.closed) {  
                              clearInterval(timer);  
                              window.open(baseUrl+'/cut');
                              
                            }  
                          }, 1000); 

                 
                        
                        }

                    }else if(response.status=='gagal'){
                        alert(response.data);
                        $('#totalBayar').attr('disabled','disabled');
                        $('#kembalian').attr('disabled','disabled');

                    }
          }
      });
}


function detail(s_id){  
      dataIndex=1;
     $.ajax({
          url     :  baseUrl+'/penjualan/pos-pesanan/'+s_id+'/edit',
          type    : 'GET',           
          /*dataType: 'json',*/
          success : function(response){  

            $('.perbarui').css('display','');  
            $('.perbarui').removeAttr('disabled');
            $('.final').css('display','none');
            $('.draft').css('display','none');
            bSalesDetail.html(''); 
            bSalesDetail.append(response);  
            $.ajax({
          url     :  baseUrl+'/paymentmethod/edit/'+s_id+'/a',
          type    : 'GET',                     
          success : function(response){  
            $('.tr_clone').html('');
              $('.tr_clone').append(response.view);
              dataIndex=response.jumlah;
              dataIndex++;
              


            }
          });

                  
          }
          
      });

}
function batal(){                        
         bSalesDetail.html('');
         $('.reset').val('');
         $('#s_date').val('{{date("d-m-Y")}}');                        
                        $('#s_created_by').val('{{Auth::user()->m_name}}');
                        tamp=[];
            $('.perbarui').css('display','none');  
                        /*$('.perbarui').attr('disabled');*/
            $('.final').css('display','');
            $('.draft').css('display','');
            $('.perbarui').css('display','none');
            dataIndex=1;
}
function hapusPayment(a){
     var par = a.parentNode.parentNode;
      $(par).remove();      
 }

listPenjualan();
function listPenjualan(){
    $.ajax({
          url     :  baseUrl+'/penjualan/pos-pesanan/listPenjualan',
          type    : 'Get',                     
          data: {
        "_token": "{{ csrf_token() }}"
            },
          success : function(response){    
            $('#listPenjualan').html(response);
                  
          }
      });
  
}


function caraxx(hutang_id){
  
  if($('#cara'+hutang_id).val()==6){    
    $('.hutang'+hutang_id).css('display','')
    $('.add1').val();
         
    
  }else{
    $('.hutang'+hutang_id).css('display','none')   
    $('.add1').val(''); 
  }

}

function dataDetail(s_id){
    $('#modalDataDetail').modal('show');
     $.ajax({
          url     :  baseUrl+'/penjualan/pos-pesanan/'+s_id+'/edit',
          type    : 'GET',                     
          success : function(response){  
            $('.dataDetail').html(''); 
            $('.dataDetail').append(response);  
                  
          }
      });
}

function resetUlang(){
  /*$('.dataDetail').*/
}

      </script>
@endsection