@extends('main')
@section('content')
<!-- $printPl -->
<style type="text/css">
  @media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
}


</style>
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">POS Penjualan Mobile</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;<a href="{{url('penjualan/POSpenjualan/POSpenjualan')}}">POS Penjualan Toko / Mobile</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">POS Penjualan Mobile</li>
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
                                <li class="active"><a id="penjualan" href="#toko" data-toggle="tab">Penjualan Mobile</a></li>
                                <li><a id="list" href="#listtoko" data-toggle="tab">List Penjualan Mobile</a></li><!-- 
                                <li><a href="#mobil" data-toggle="tab">Penjualan Mobil</a></li>
                                <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
                                <!-- <li><a href="#konsinyasi" data-toggle="tab">Penjualan Konsinyasi</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">
                                <!-- Modal -->
                               {!!$data['mobile']!!}
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
  var cQty             = $("#cQty");
  
  
  var s_satuan          =$('#s_satuan') ;
  var bSalesDetail      = $(".bSalesDetail");
  var i_price           =$('#i_price');

  var index             =0;
  var tamp              =[];
  var flag              ='TOKO';
  var dataIndex         =1;

  var hapusSalesDt =[];
$('#harga').change(function(){
  batal();
})

$(document).ready(function(){      


       
        $("#searchitem").autocomplete({        
        source: function(request, response) {
            $.getJSON(baseUrl+"/item", {term:$('#searchitem').val(),harga: $('#harga').val() }, 
              response);
        },
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
        
        
        if($('.jumlahAwal'+i_id.val()).val()!=undefined && $('.jumlahAwal'+i_id.val()).val()!=0){
            /*jumlah=parseFloat(ui.item.stok)+parseFloat($('.jumlahAwal'+i_id.val()).val());*/
            if($('#s_status').val()=='final'){
                jumlah=parseFloat(angkaDesimal(ui.item.stok))+parseFloat(angkaDesimal($('.jumlahAwal'+i_id.val()).val()));
                
                $('#stock').val(SetFormRupiah(jumlah));        
              }else if($('#s_status').val()=='draft'){
                
                $('#stock').val(ui.item.stok);
              }




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
        /*$('#biaya_kirim').focus();*/
        
        
        }
      });

     });



   /*   $('#s_date').datepicker({
          format:"dd-mm-yyyy",        
          autoclose: true,
      });    */

      /*function tgl(){
        $('#s_machine').focus();
      }*/


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
            /*jumlah=parseFloat(response[0].stok)+parseFloat($('.jumlahAwal'+i_id.val()).val());
            $('#stock').val(response[0]); */   
          if($('#s_status').val()=='final'){
            jumlah=parseFloat(angkaDesimal(response[0].stok))+parseFloat(angkaDesimal($('.jumlahAwal'+i_id.val()).val()));
            $('#stock').val(SetFormRupiah(jumlah));      
          }else if($('#s_status').val()=='draft'){
            $('#stock').val(response[0].stok);        
          }
          
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
        return true;
      }
      else if($('#stock').val()==''){         
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
          setFormDetail();
          totalPerItem();
        }
      }
    } );
    
 

var tablex;
setTimeout(function () {
            
   table();
      }, 1500);

function table(){
   $('#tableListToko').dataTable().fnDestroy();
   tablex = $("#tableListToko").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("penjualan/pos-mobile/listPenjualan/data") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",
                    "type"  :"Mobile",
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    },
              },
            columns: [
            {data: 's_date', name: 's_date'},
            {data: 's_note', name: 's_note'},            
            /*{data: 'c_name', name: 'c_name'}, */           
            {data: 'm_name', name: 'm_name'},                        
            {data: 's_gross', name: 's_gross'}, 
            {data: 's_disc_percent', name: 's_disc_percent'}, 
            {data: 's_ongkir', name: 's_ongkir'},
            {data: 's_net', name: 's_net'},            
            {data: 's_status', name: 's_status'}, 
            {data: 'action', name: 'action'},
           
            ],
             'columnDefs': [
                
               {
                    "targets": 5,
                    "className": "text-right",
               },{
                    "targets": 6,
                    "className": "text-right",
               },{
                    "targets": 7,
                    "className": "text-right",
               },{
                    "targets": 8,
                    "className": "text-right",
               }
               ],
            //responsive: true,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            
             "rowCallback": function( row, data, index ) {
                    
                    /*$node = this.api().row(row).nodes().to$();*/

                if (data['s_status']=='draft') {
                     $('td', row).addClass('warning');
                } 
              }   
           
    });
}





    function setFormDetail(){
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
          iSalesDetail+='<td width="23%"><input style="width:100%" type="hidden" name="sd_item[]" value='+i_id.val()+'>'; 
          iSalesDetail+='<input style="width:100%" type="hidden" name="sd_sales[]" value="">';
          iSalesDetail+='<input style="width:100%" type="hidden" name="sd_detailid[]" value="">';
          iSalesDetail+='<input value="'+$('#fComp').val()+'" style="width:100%" type="hidden" name="comp[]">';
          iSalesDetail+='<input value="'+$('#fPosition').val()+'" style="width:100%" type="hidden" name="position[]">';
          iSalesDetail+='<div style="padding-top:6px">'+i_code.val()+' - '+itemName.val()+'</div></td>';

          iSalesDetail+='<td width="4%"><input class="stock stock'+i_id.val()+'" style="width:100%;text-align:right;border:none" value='+$('#stock').val()+' readonly></td>';

          iSalesDetail+='<td width="4%" style="display:none"><input class="jumlahAwal'+i_id.val()+'" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="0"></td>';

          iSalesDetail+='<td width="4%"><input  onblur="validationForm();setQty(event,\'fQty' + i_id.val() + '\')" onkeyup="hapus(event,'+i_id.val()+');hitungTotalPerItem(\'' + i_id.val() + '\');" onclick="setAwal(event,\'fQty' + i_id.val() + '\')" class="move up1  alignAngka jumlah fQty'+i_id.val()+'" style="width:100%;border:none" name="sd_qty[]" value="'+SetFormRupiah(angkaDesimal(fQty.val()))+'" autocomplete="off" ></td>';

          iSalesDetail+='<td width="5%"><div style="padding-top:6px">'+s_satuan.val()+'</div></td>';
          
          iSalesDetail+='<td width="6%"><input class="harga'+i_id.val()+' alignAngka" style="width:100%;border:none" name="sd_price[]" value="'+i_price.val()+'"" readonly></td>';

          iSalesDetail+='<td width="4%"><input class="move up2 alignAngka discRp'+i_id.val()+'" style="width:100%;border:none" name="sd_disc_value[]" id="discRp" onkeyup="hapus(event,'+i_id.val()+');hitungTotalPerItem(\'' + i_id.val() + '\');rege(event,\'discRp' + i_id.val() + '\')" onblur="setRupiah(event,\'discRp' + i_id.val() + '\')" onclick="setAwal(event,\'discRp' + i_id.val() + '\')" onfocus="setAwal(event,\'discRp' + i_id.val() + '\')" value="0" autocomplete="off"></td>'; 

          iSalesDetail+='<td width="3%"><input class="move up3 alignAngka discP'+i_id.val()+'" onkeyup="hapus(event,'+i_id.val()+');;hitungTotalPerItem(\'' + i_id.val() + '\')" style="width:100%;border:none" name="sd_disc_percent[]" id="discP" value="0" autocomplete="off"></td>'; 

          iSalesDetail+='<td width="2%" style="display:none"><input class="alignAngka discPV'+i_id.val()+'" onkeyup="hitungTotalPerItem(\'' + i_id.val() + '\')" style="width:100%;border:none" name="sd_disc_percentvalue[]" id="discPV"></td>'; 
          

          iSalesDetail+='<td width="10%" style="display:none"><input style="width:100%;border:none" name="sd_total[]" class="totalPerItem alignAngka totalPerItem'+i_id.val()+'" readonly></td>';                   

          iSalesDetail+='<td width="10%""><input style="width:100%;border:none" name="sd_total_disc[]" class="totalPerItemDisc alignAngka totalPerItemDisc'+i_id.val()+'" readonly></td>';  
          iSalesDetail+='<td width="3%">'+Hapus+'</td>'                            
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


        /*
        var index = hapusSalesDt.indexOf(i_id.val());
        if(index!==-1)
        hapusSalesDt.splice(index,1);*/
        
          

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
                        setDatePicker();
                         var index = $('.move').index(this) + 1;                         
                         $('.move').eq(index).focus();                         
                         
                      }
                       if (e.ctrlKey && e.which === arrow.left) {
                        setDatePicker();
                         var index = $('.move').index(this) - 1;
                         $('.move').eq(index).focus();
                      }
                      if (e.ctrlKey && e.which === arrow.up) {
                          setDatePicker(); 
                         var upd=$(this).attr('class').split(' ')[ 1 ];
                         var index = $('.'+upd).index(this) - 1;
                         $('.'+upd).eq(index).focus();
                      }
                      if (e.ctrlKey && e.which === arrow.down) {
                         setDatePicker();
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
        if(fStok>=updateQty){        
          $('.fQty'+i_id.val()).val(updateQty)
          itemName.val('');
          fQty.val('');
          $('#stock').val('');
          searchitem.val('');
          searchitem.focus();  
        hitungTotalPerItem(i_id.val());
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
console.log('setelah' + tamp);
    }



function hapus(e,a){
    if(e.which===46 && e.ctrlKey){
      hapusSalesDt.push(a);
        $('.detail'+a).remove();
        var index = tamp.indexOf(''+a);  
        if(index!==-1)
        tamp.splice(index,1);
        totalPerItem();
        buttonDisable();
        searchitem.focus();
        
    }
}


function hapusButton(a){
      a=''+a;
      hapusSalesDt.push(a);
        $('.detail'+a).remove();
        var index = tamp.indexOf(''+a);  
        if(index!==-1)
        tamp.splice(index,1);
        totalPerItem();
        buttonDisable();
        
    
}






/*$('#add').live('click',function(e){ 
    $(this).closest('tr').remove();    
    
})*/

payment();
function addf2(e){
   {                
        if (e.keyCode == 113) {                 
             payment();
        }
    }
    
  }

function payment(){
  
         $('.minu').keydown(function (e) {              
                    if (e.ctrlKey && e.which === arrow.right) {
                        
                         var index = $('.minu').index(this) + 1;                         
                         $('.minu').eq(index).focus();
                         
                      }
                       if (e.ctrlKey && e.which === arrow.left) {
                      /*if (e.keyCode == ctrl && arrow.left) {*/
                         var index = $('.minu').index(this) - 1;
                         $('.minu').eq(index).focus();
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


function nextFocus(e,id){
   
}
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
      if($('.fQty'+tamp[0]).val()=='' || $('.fQty'+tamp[0]).val()=='0'){
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
    $('.fQty'+tamp[0]).focus();
    $('.fQty'+tamp[0]).css('border','2px solid red');
    return false;
  }else{
    $('.fQty'+tamp[0]).css('border','none');    
    $('.btn-disabled').removeAttr('disabled');
    return true;
  }

}




function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
    $('#div_print').html('');
    $('#div_prints').html('');
}


$status=true;
function simpanPos(status=''){
  $('#totalBayar').removeAttr('disabled');
  $('#kembalian').removeAttr('disabled');
  $('.btn-disabled').attr('disabled','disabled');

  
if($status==true){ 
  $status=false;     
  var formPos=$('#dataPos,#dst').serialize();  
  
     $.ajax({
          url     :  baseUrl+'/penjualan/pos-mobile/create',
          type    : 'GET', 
          data    :  formPos+'&status='+status,
          dataType: 'json',
          success : function(response){    
                    
                    if(response.status=='sukses'){
                      
                      $('#nominal').val('');          
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

                        
                        $('#s_date').val('{{date("d-m-Y")}}');                        
                        $('#s_created_by').val('{{Auth::user()->m_name}}');
                        $('#searchitem').focus();
                        $status=true;
                        if(response.s_status=='final'){
                        







 /*qz.findPrinter("POS-80");
        window['qzDoneFinding'] = function() {
            var p = document.getElementById('printer');
            var printer = qz.getPrinter();
            window['qzDoneFinding'] = null;
        };*/


 $.ajax({
    url : baseUrl+'/penjualan/pos-mobile/printNota/'+response.s_id,
    type: 'get',
    data    :  formPos+'&status='+status,
    success:function (response){
      
        $('#div_print').html(response);
              /*qz.appendHTML(
                  '<html>' +response +'</html>'
              );
              qz.printHTML();*/

              
    printElement(document.getElementById("div_print"));
        
    }
    })












                    }
                  }
                    else if(response.status=='gagal'){
                      $('.btn-disabled').removeAttr('disabled');
                      $('#kembalian').attr('disabled','disabled');
                      $('#totalBayar').attr('disabled','disabled');
                        
                        iziToast.error({
                          position:'topRight',
                          timeout: 2000,
                          title: '',
                          message: response.data,
                        });


                        $status=true;
                    }
          }
      });
   }
}


  

function perbaruiData(){
  $('#kembalian').removeAttr('disabled');
  $('#totalBayar').removeAttr('disabled');
  $('#btn-disabled').attr('disabled','disabled');

  var formPos=$('#dataPos,#dst').serialize();  
  

     $.ajax({
          url     :  baseUrl+'/penjualan/pos-mobile/update',
          type    : 'GET', 
          data    :  formPos+'&hapusdt='+hapusSalesDt,
          dataType: 'json',
          success : function(response){    
                    $('.tr_clone').html('');    
                    payment();                          
                    tamp=[];
                    hapusSalesDt=[];
                    if(response.status=='sukses'){                      
                      $('#kembalian').attr('disabled','disabled');
                      $('#totalBayar').attr('disabled');
                        tablex.ajax.reload();
                        bSalesDetail.html('');
                        $('.reset').val('');                        
                        $('#s_date').val('{{date("d-m-Y")}}');                        
                        $('#s_created_by').val('{{Auth::user()->m_name}}');
                        $('#proses').modal('hide');
                        $('.perbarui').css('display','none');  
                        /*$('.perbarui').attr('disabled');*/
                        $('.final').css('display','');
                        $('.draft').css('display','');

                         if(response.s_status=='final'){
                       var childwindow= window.open(baseUrl+'/penjualan/pos-mobile/printNota/'+response.s_id,'_blank');                    
                        }

                    }else if(response.status=='gagal'){
                      $('.btn-disabled').removeAttr('disabled');
                        alert(response.data);
                        $('#totalBayar').attr('disabled','disabled');
                        $('#kembalian').attr('disabled','disabled');

                    }
          }
      });
}


function detail(s_id){  
      var statusPos=$('#s_status').val();
      dataIndex=1;
     $.ajax({
          url     :  baseUrl+'/penjualan/pos-mobile/'+s_id+'/edit',
          type    : 'GET',  
          data: {
        "_token": "{{ csrf_token() }}",
        "s_status" :statusPos,
            },

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
         $('#nominal').val('');     
          /*payment();                */      
         $('.reset').val('');
         $('#s_date').val('{{date("d-m-Y")}}');                        
                        $('#s_created_by').val('{{Auth::user()->m_name}}');
                        tamp=[];
                        hapusSalesDt=[];
            $('.perbarui').css('display','none');  
                        /*$('.perbarui').attr('disabled');*/
            $('.final').css('display','');
            $('.draft').css('display','');
            dataIndex=1;

            $('#searchitem').focus();
}

listPenjualan();
function listPenjualan(){
    $.ajax({
          url     :  baseUrl+'/penjualan/pos-mobile/listPenjualan',
          type    : 'POST',                     
          data: {
        "_token": "{{ csrf_token() }}"
            },
          success : function(response){    
            $('#listPenjualan').html(response);
                  
          }
      });
  
}
function hapusPayment(e,a){
  if(e.which===46 && e.ctrlKey){

        $ttlJenisPayment=0;        
        $(".nominal").each(function() {       
          $ttlJenisPayment++;
        });

        if($ttlJenisPayment==1){
          return false;
        }
     var par = a.parentNode.parentNode;
      $(par).remove();   
      $('.nominal').focus()
  }   
 }

 function btnHapusPayment(a){
        $ttlJenisPayment=0;        
        $(".nominal").each(function() {       
          $ttlJenisPayment++;
        });
        
        if($ttlJenisPayment==1){
          return false;
        }
     var par = a.parentNode.parentNode;
      $(par).remove();   
      $('.nominal').focus()  
 }


function caraxx(hutang_id){
  if($('#cara').val()==6){
    $('.hutang'+hutang_id).css('display','')
    $('.add1').val();
         
    
  }else{
    $('.hutang').css('display','none')   
    $('.add1').val(''); 
  }

}

function dataDetailView(s_id){
    $('#modalDataDetail').modal('show');
     $.ajax({
          url     :  baseUrl+'/penjualan/pos-mobile/detail-view/'+s_id,
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


$('#fQty').keyup(function(e) {    

    if($('#cQty').val()==='1' &&  e.which != 13){      
        $('#cQty').val('');
        $('#fQty').val($('#fQty').val().substring(1));
    }    
  })

$('#searchitem').click(function(){    
    $('.reset-seach').val('');      
});

/*function g(){
    $('.reset-seach').val('');      
}*/

var arrow = {
    left: 37,
    up: 38,
    right: 39,
    down: 40
},

ctrl = 17;
         $('.move').keydown(function (e) {                       
                    if (e.ctrlKey && e.which === arrow.right) {
                        setDatePicker();
                         var index = $('.move').index(this) + 1;                         
                         $('.move').eq(index).focus();                         
                      }
                       if (e.ctrlKey && e.which === arrow.left) {
                         setDatePicker();
                         var index = $('.move').index(this) - 1;
                         $('.move').eq(index).focus();
                      }
                      if (e.ctrlKey && e.which === arrow.up) {
                         setDatePicker();
                         var upd=$(this).attr('class').split(' ')[ 1 ];
                         var index = $('.'+upd).index(this) - 1;
                         $('.'+upd).eq(index).focus();
                      }
                      if (e.ctrlKey && e.which === arrow.down) {
                         setDatePicker();                         
                         var upd=$(this).attr('class').split(' ')[ 1 ];
                         var index = $('.'+upd).index(this) + 1;
                         $('.'+upd).eq(index).focus();
                      }                    
     });

function setDatePicker(){
  $('#s_date').datepicker('hide');  
}



function dataDetailView(s_id,s_note,s_machine,s_date,s_duedate,s_finishdate,s_gross,s_disc_percent,s_disc_value,s_grand,s_ongkir,s_bulat,s_net,s_bayar,s_kembalian,s_customer,c_name,s_status,chek,s_jenis_bayar) {    
  $('#txt_span_status').text(s_status);
  $('#lCode').val(s_note);
  $('#lTgl').val(s_date);
  $('#sid').val(s_id);
  $('#lCustomer').val(c_name);
  var c_bayar
  if(s_jenis_bayar==1){
    c_bayar='Tunai';
  }else{
    c_bayar='Tempo';
  }
       

        if(s_status == 'draft') {
          $('.status_s').addClass('label-warning').text('Draft');
      }
      else if(s_status == 'final'){
          $('.status_s').addClass('label-success').text('Final');
      }

  $('#lBayar').val(c_bayar);
  $('#lTempo').val(s_duedate);
  $('#lJadi').val(s_finishdate);
  $('#lSubttl').val(s_gross);
  $('#lDiskon').val(SetFormRupiah(s_disc_value+s_disc_percent));
  $('#lBkirim').val(s_ongkir);
  $('#lTtl').val(s_net);
  $('#lBiaya').val(s_bayar);
  
    $('#modalDataDetail').modal('show');
     $.ajax({
          url     :  baseUrl+'/penjualan/pos-pesanan/detail-view/'+s_id,
          type    : 'GET',                     
          success : function(response){  
            $('.dataDetail').html(''); 
            $('.dataDetail').append(response);  
                  
          }
      });
}

function modalShow(){

  
  $('#proses').on("shown.bs.modal", function(e) {    
            $('#nominal').focus();
            
  });  
  $('#proses').modal('show');

}

$(document).keydown(function(e){        
  if(e.which==121 && e.ctrlKey){    
        if($('#proses').is(':visible')==false){           
          if($('#grand_biaya').val()!='' && $('#grand_biaya').val()!='0'){
                 modalShow();
          }else{
                iziToast.error({
                    position:'topRight',
                    timeout: 1500,
                    title: '',
                    message: "Ma'af, Data yang di masukkan belum sempurna.",
                  });
                
                
          }
        }else if($('#proses').is(':visible')==true){
            $chekTotal=angkaDesimal($('#akumulasiTotal').val())-angkaDesimal($('#totalBayar').val());         

                  if($chekTotal<=0){
                    var textIzi='';
                    if($('#s_id').val()==''){
                      textIzi="Apakah anda yakin menyimpan sebagai final?";

                    }else if($('#s_id').val()!=''){
                      textIzi="Apakah anda yakin Mengupdate sebagai final?"
                    }
            /*iziToast.show({
                    theme: 'dark',
                    position:'center',
                    timeout: 15000,
                    progressBarColor: 'rgb(0, 255, 184)',
                    title: '',
                    message: textIzi,
                    buttons: [
                      ['<button>Simpan</button>', function (instance, toast) {   
                          instance.hide({
                              transitionOut: 'fadeOutUp',
                              onClosing: function(instance, toast, closedBy){
                              }
                          }, toast, 'buttonName');
                          if($('#s_id').val()==''){
                              simpanPos('final');
                            }else if($('#s_id').val()!=''){
                              perbaruiData();
                            }
                      }, true], // true to focus
                      ['<button>Tutup</button>', function (instance, toast) {
                          instance.hide({
                              transitionOut: 'fadeOutUp',
                              onClosing: function(instance, toast, closedBy){                               
                              }
                          }, toast, 'buttonName');
                        }]
                      ],
                  });
*/
if($('#s_id').val()==''){
                              simpanPos('final');
                            }else if($('#s_id').val()!=''){
                              perbaruiData();
                            }
                  }else{
                      iziToast.error({
                      position:'topRight',
                      timeout: 1500,
                      title: '',
                      message: "Ma'af, jumlah pembayaran belum sesuai",
                      });
                  }

        }
}else if(e.which==120 && e.ctrlKey){  

              if($('#s_id').val()!=''){
                iziToast.error({
                          position:'topRight',
                          timeout: 1500,
                          title: '',
                          message: "Ma'af, data telah di simpan sebagai draft.",
                          });
                return false;
              }
            if($('#grand_biaya').val()!='' && $('#grand_biaya').val()!='0'){

          /*iziToast.show({
                    theme: 'dark',
                    position:'center',
                    timeout: 15000,
                    progressBarColor: 'rgb(0, 255, 184)',
                    title: '',
                    message: "Apakah anda yakin menyimpan sebagai draft?",
                    buttons: [
                      ['<button>Simpan</button>', function (instance, toast) {   
                          instance.hide({
                              transitionOut: 'fadeOutUp',
                              onClosing: function(instance, toast, closedBy){
                              }
                          }, toast, 'buttonName');
                          simpanPos('draft');  

                      }, true], // true to focus
                      ['<button>Tutup</button>', function (instance, toast) {
                          instance.hide({
                              transitionOut: 'fadeOutUp',
                              onClosing: function(instance, toast, closedBy){                               
                              }
                          }, toast, 'buttonName');
                        }]
                      ],


                  });*/
                  simpanPos('draft');  
              }else{
                iziToast.error({
                    position:'topRight',
                    timeout: 2000,
                    title: '',
                    message: "Ma'af, Data yang di masukkan belum sempurna.",
                  });
                $('#searchitem').focus();
                
          }
}else if(e.which==27){ 
  batal();
}

})






function buttonSimpanPos($status){

      if($('#s_id').val()!='' && $status=='draft'){
                iziToast.error({
                          position:'topRight',
                          timeout: 1500,
                          title: '',
                          message: "Ma'af, data telah di simpan sebagai draft.",
                          });
                return false;
      }
        
   
        if($('#proses').is(':visible')==false){           
          if($('#grand_biaya').val()!='' && $('#grand_biaya').val()!='0'){
                 modalShow();
          }else{
                iziToast.error({
                    position:'topRight',
                    timeout: 1500,
                    title: '',
                    message: "Ma'af, Data yang di masukkan belum sempurna.",
                  });
                
                
          }
        }else if($('#proses').is(':visible')==true){
            $chekTotal=angkaDesimal($('#akumulasiTotal').val())-angkaDesimal($('#totalBayar').val());            
                  if($chekTotal<=0){
                      var textIzi='';
                    if($('#s_id').val()==''){
                      textIzi="Apakah anda yakin menyimpan sebagai final?";

                    }else if($('#s_id').val()!=''){
                      textIzi="Apakah anda yakin Mengupdate sebagai final?"
                    }
                            if($('#s_id').val()==''){
                              simpanPos('final');
                            }else if($('#s_id').val()!=''){
                              perbaruiData();
                            }

                      /*simpanPos($status);*/
                  }else{
                      iziToast.error({
                      position:'topRight',
                      timeout: 1500,
                      title: '',
                      message: "Ma'af,.",
                      });
                  }

        }
}

function tambah(){
  $('#penjualan').tab('show');
  $('.reset-seach').val('');      
}

$("#nominal").keyup(function(event) {
    if (event.keyCode === 13) {
        buttonSimpanPos('final');
    }
});

      </script>
@endsection