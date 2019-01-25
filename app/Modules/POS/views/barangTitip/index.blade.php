@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
			<div class="page-title">Barang Titip</div>
		</div>
		<ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
			<li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
			<li class="active">Barang Titip</li>
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
						<li class="active"><a id="penjualan" href="#toko" data-toggle="tab">Form Barang Titip</a></li>
                                <li><a id="list" href="#listtoko" data-toggle="tab">List Barang Titip</a></li><!-- 
                                <li><a href="#mobil" data-toggle="tab">Penjualan Mobil</a></li>
                                <li><a href="#listmobil" data-toggle="tab">List Mobil</a></li> -->
                                <!-- <li><a href="#konsinyasi" data-toggle="tab">Penjualan Konsinyasi</a></li> -->
                            </ul>
                            <div id="generalTabContent" class="tab-content responsive">
                            	<!-- Modal -->
                            	{!!$data['form']!!}
                            	<!-- End Modal -->

                            	<!-- div #alert-tab -->

                            	<!-- /div #alert-tab -->

                            	<!-- Div #listtoko -->
                            	<!-- @include('penjualan.POSpenjualanToko.listtoko') -->                               
                            	{!!$data['list']!!}
                            	<!-- end div #listoko -->
                            	

                            </div> <!-- End div general-content -->

                        </div>
                    </div>



 <!-- Modal -->

          <div class="modal fade" id="detail-titipan" role="dialog">
  <div class="modal-dialog modal-lg">
      
    
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Data</h4>
          </div>

          <div class="modal-body">

            <div class="table-responsive">
              <table class="table tabelan table-hover table-bordered" cellspacing="0">
                 <table class="table tabelan table-bordered table-hover dt-responsive">
               <thead align="right">
                <tr>                 
                 <th width="23%">Nama</th>                 
                 <th width="4%">Jumlah</th>                                               
                 <th width="4%">Terjual</th>                 
                 <th width="6%">Return</th>                 
                 <th width="5%">Satuan</th>
                 <th width="6%">Harga</th>                                
                 <th width="12%">Total</th>                                                                 
                </tr>
               </thead> 
               <tbody class="detail-titipan">
               </tbody>
              </table>
            </div>
            
            
          </div>
      
      
        </div>
         
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

function tambah(){
  $('#penjualan').tab('show');
  $('.reset-seach').val('');      
}




function showDetail($id){  
    $('#detail-titipan').modal('show');
     $.ajax({
          url     :  baseUrl+'/penjualan/barang-titip/detail/'+$id,
          type    : 'GET',                     
          success : function(response){  
            $('.detail-titipan').html(''); 
            $('.detail-titipan').append(response);  
                  
          },

          error: function(jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 401) {
                var txt;
                var r = confirm("Anda telah logout, Apakah anda ingin login kembali ?");
                if (r == true) {
                    location.reload();
                } else {
                    alert("Anda menekan tombol batal");
                }                 
            } else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText);
            }
        }

      });
}



  $("#supplier").autocomplete({
  	source: baseUrl+'/seach-supplier',
  	minLength: 1,
  	dataType: 'json',
  	select: function(event, ui) 
  	{   
  		$('#supplier').val(ui.item.label);        
  		$('#id_supplier').val(ui.item.s_id);   
  		$('#searchitem').focus();
  		/*validationHeader();*/

  	}
  });

  function clearSupplier(){
  	if($('#supplier').val()==''){
  		$('#id_supplier').val('');  
  		/*validationHeader(); */
  	}
  }



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


        $('#fComp').val(ui.item.comp);
        $('#fPosition').val(ui.item.position);
        
        $('#s_satuan').val(ui.item.satuan);
        var jumlah=0;
        if($('.jumlahAwal'+i_id.val()).val()!=undefined){
            /*jumlah=parseFloat(ui.item.stok)+parseFloat($('.jumlahAwal'+i_id.val()).val());*/
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
  			/*$('#biaya_kirim').focus();*/


  		}
  	});

  });

  $('#s_date').datepicker({
  	format:"dd-mm-yyyy",        
  	autoclose: true,
  });    

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
   			setFormDetail();  
   			totalHargaItem();        
   		}
   	}
   } );


   function hitung(id){

   	var fQty=angkaDesimal($('.fQty'+id).val());    
   	if(isNaN(fQty)){    
   		return false;
   	}
   	var total=0;
   	var stock=angkaDesimal($('.stock'+id).val());
   	var harga=angkaDesimal($('.harga'+id).val());

   	total = angkaDesimal($('.harga'+id).val()) * angkaDesimal($('.fQty'+id).val()) ;        

   	$('.totalPerItemDisc'+id).val(SetFormRupiah(total));   
   	totalHargaItem();

   }


   function totalHargaItem(){


   	var s_gross=0;
   	$(".totalPerItemDisc").each(function() {
   		var value = angkaDesimal($(this).val());    
    // add only if the value is number
    if(!isNaN(value) && value.length != 0) {
    	s_gross += parseFloat(value);                
    }    
});


   	$('#s_gross').val(SetFormRupiah(s_gross));

   }

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
   			"url": "{{ url("penjualan/barang-titip/data") }}",
   			"type": "get",
   			data: {
   				"_token": "{{ csrf_token() }}",                    
   				"tanggal1" :$('#tanggal1').val(),
   				"tanggal2" :$('#tanggal2').val(),
   			},
   		},
   		columns: [
   		{data: 'it_date', name: 'it_date'},
   		{data: 'it_code', name: 'it_code'},                                       		
   		{data: 'it_keterangan', name: 'it_keterangan'}, 
   		{data: 'it_total', name: 'it_total'},
   		{data: 'action', name: 'action'}

   		],
   		'columnDefs': [

   		{
   			"targets": 4,
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
      iSalesDetail+='<td width="23%"><input style="width:100%" type="hidden" name="idt_item[]" value='+i_id.val()+'>'; 
      iSalesDetail+='<input style="width:100%" type="hidden" name="idt_itemtitipan[]" value="">';
      iSalesDetail+='<input style="width:100%" type="hidden" name="idt_detailid[]" value="">';
      iSalesDetail+='<input value="'+$('#fComp').val()+'" style="width:100%" type="hidden" name="comp[]">';
          iSalesDetail+='<input value="'+$('#fPosition').val()+'" style="width:100%" type="hidden" name="position[]">';
      iSalesDetail+='<div style="padding-top:6px">'+i_code.val()+' - '+itemName.val()+'</div></td>';

      iSalesDetail+='<td width="4%"><input class="form-control stock stock'+i_id.val()+'" style="width:100%;text-align:right;border:none" value='+$('#stock').val()+' readonly></td>';

      iSalesDetail+='<td width="4%" style="display:none"><input class="form-control jumlahAwal'+i_id.val()+'" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="0"></td>';

      iSalesDetail+='<td width="4%"><input  onblur="validationForm();setQty(event,\'fQty' + i_id.val() + '\')" onkeyup="hapus(event,'+i_id.val()+');hitung(\'' + i_id.val() + '\');chekJumlah(\'' + i_id.val() + '\')" onclick="setAwal(event,\'fQty' + i_id.val() + '\')" class="move up1  form-control alignAngka jumlah fQty'+i_id.val()+'" style="width:100%;border:none" name="idt_qty[]" value="'+SetFormRupiah(angkaDesimal(fQty.val()))+'" autocomplete="off" ></td>';

      iSalesDetail+='<td width="5%"><div style="padding-top:6px">'+s_satuan.val()+'</div></td>';

      iSalesDetail+='<td width="6%"><input class="harga'+i_id.val()+' alignAngka form-control" style="width:100%;border:none" name="idt_price[]" value="'+i_price.val()+'" onkeyup="hapus(event,'+i_id.val()+');hitung(\'' + i_id.val() + '\');"  onblur="validationForm();setRupiah(event,\'harga' + i_id.val() + '\')" onclick="setAwal(event,\'harga' + i_id.val() + '\')" readonly></td>';


      iSalesDetail+='<td width="10%""><input style="width:100%;border:none" name="idt_total[]" class="totalPerItemDisc alignAngka totalPerItemDisc'+i_id.val()+' form-control" readonly></td>';  
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


   /*if(fStok>=updateQty){
          $('.fQty'+i_id.val()).val(updateQty)
          itemName.val('');
          fQty.val('');
          $('#stock').val('');
          searchitem.val('');
          searchitem.focus();
         hitungTotalHpp(i_id.val());
        $('.reset-seach').val('');
        }else{
              iziToast.error({
                position:'topRight',
                timeout: 2000,
                title: '',
                message: "Ma'af, jumlah sdsds.",
              });
        }*/                             
	if(fStok>=updateQty){
		$('.fQty'+i_id.val()).val(updateQty)
		itemName.val('');
		fQty.val('');
		$('#stock').val('');
		searchitem.val('');
		searchitem.focus();  
		hitung(i_id.val())

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





function chekJumlah(id){    

    var fQty=angkaDesimal($('.fQty'+id).val());    
  if(isNaN(fQty)){    
    return false;
  }

  var stock=angkaDesimal($('.stock'+id).val());

  if(stock<fQty){             

            
                    iziToast.error({
                      position:'topRight',
                      timeout: 2000,
                      title: '',
                      message: "Ma'af, jumlah permintaan melebihi stok gudang.",
                    });

        $('.fQty'+id).val(1);        
        var fQty=angkaDesimal($('.fQty'+id).val());    
        update=(fQty*harga)-nilaiDiscP- nilaiDiscV;        
        $('.totalPerItem'+id).val(SetFormRupiah(update));
        $('.totalPerItemDisc'+id).val(SetFormRupiah(update));        
        return false;
    }

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

payment();
function addf2(e){
	{                
		if (e.keyCode == 113) {                 
			payment();
		}
	}

}

function payment(){
	$html='';
	$html+={!!$pm!!};
	$html+='<td>'+
	'<input class="minu mx f2 nominal alignAngka nominal'+dataIndex+'" style="width:90%" type="" name="sp_nominal[]"'+
	'id="nominal" onkeyup="hapusPayment(event,this);addf2(event);totalPembayaran(\'nominal' +dataIndex+'\');rege(event,\'nominal' +dataIndex+'\')"'+  'onblur="setRupiah(event,\'nominal' +dataIndex+'\')" onclick="setAwal(event,\'nominal' +dataIndex+'\')"'+
	'autocomplete="off">'+
	'</td>'+
	'<td>'+
	'<button type="button" class="btn btn-sm btn-danger hapus" onclick="btnHapusPayment(this)"  ><i class="fa fa-trash-o">'+
	'</i></button>'+
	'</td>'+
	'</tr>';

	$('.tr_clone').append($html);  

	dataIndex++;            

	var arrow = {
		left: 37,
		up: 38,
		right: 39,
		down: 40
	},

	ctrl = 17;
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


function simpanPos(status=''){

	$('.btn-disabled').attr('disabled','disabled');

	var formPos=$('#dataPos').serialize();

	$.ajax({
		url     :  baseUrl+'/penjualan/barang-titip/store',
		type    : 'GET', 
		data    :  formPos+'&status='+status,
		dataType: 'json',
		success : function(response){    

			if(response.status=='sukses'){
				$('.tr_clone').html('');  

				tamp=[];
				hapusSalesDt=[];                      
				tablex.ajax.reload();
				bSalesDetail.html('');
				$('.reset').val('');
				iziToast.success({
					position: "center",
					title: '', 
					timeout: 1000,
					message: 'Data berhasil disimpan.'});

        $('#s_date').val('{{date("d-m-Y")}}');                        
        $('#s_created_by').val('{{Auth::user()->m_name}}');
        $('#s_date').focus();
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




function perbaruiData(){
	$('#kembalian').removeAttr('disabled');
	$('#totalBayar').removeAttr('disabled');
	$('#btn-disabled').attr('disabled','disabled');

	var formPos=$('#dataPos').serialize();
	$.ajax({
		url     :  baseUrl+'/penjualan/pos-toko/update',
		type    : 'GET', 
		data    :  formPos+'&hapusdt='+hapusSalesDt,
		dataType: 'json',
		success : function(response){    
			$('.tr_clone').html('');    

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
					var childwindow= window.open(baseUrl+'/penjualan/pos-toko/printNota/'+response.s_id,'_blank');                    
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
		url     :  baseUrl+'/penjualan/pos-toko/'+s_id+'/edit',
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
	$('.tr_clone').html('');  

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

	$('#s_date').focus();
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
		url     :  baseUrl+'/penjualan/pos-toko/detail-view/'+s_id,
		type    : 'GET',                     
		success : function(response){  
			$('.dataDetail').html(''); 
			$('.dataDetail').append(response);  

		}
	});
}

function serahterima(id){
	window.location.href = baseUrl+'/penjualan/barang-titip/serahTerima/'+id;
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



function modalShow(){


	$('#proses').on("shown.bs.modal", function(e) {    
		$('#customer').focus();

	});  
	$('#proses').modal('show');

}

$(document).keydown(function(e){        
	if(e.which==121 && e.ctrlKey){    
		simpanPos('final');
	}else if(e.which==120 && e.ctrlKey){              
		simpanPos('draft');              
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


 function cari(){
  table();
 }

dateAwal();
function dateAwal(){
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
}


function resetData(){  
  dateAwal();
  table();
}

</script>
@endsection