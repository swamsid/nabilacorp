<script type="text/javascript">

	dateAwal();
	function dateAwal(){	      
	   
     var d = new Date();
	      d.setDate(d.getDate()-7);



		   $('#tgl_awal').datepicker({
		        format:"dd-mm-yyyy",        
		        autoclose: true,
		  }).datepicker( "setDate", d);
		  $('#tgl_akhir').datepicker({
		        format:"dd-mm-yyyy",        
		        autoclose: true,
		  }).datepicker( "setDate", new Date());








	}


	function resetData(){  
	  dateAwal();
	  table();
	}


	function print_laporan() {
		var tgl_awal = $('[name="tgl_awal"]').val();
	 	var tgl_akhir = $('[name="tgl_akhir"]').val();
	 	var shift = $('#shift').val();
	 	if(tgl_awal != '' && tgl_akhir != '') {
		 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir+ '&shift=' + shift;
		 	var url_target =  "{{ url('/penjualan/penjualanmobile/print_laporan') }}" + arg;
		 	window.open(url_target, '_blank');
	 	}
	 	else {
	 		iziToast.error({
	 			title : 'Error!',
	 			message : 'Masukkan tanggal dengan benar'
	 		});
	 	}

	}

	



var tablex;
setTimeout(function () {            
   table();
      }, 1500);


function table(){
		var shift=$('#shift').val();
		var tgl_awal=$('#tgl_awal').val();
		var tgl_akhir=$('#tgl_akhir').val();
	 $.ajax({
          url     :  baseUrl+'/penjualan/laporan-penjualan-pesanan/totalPiutang',
          type    : 'GET', 
          data    :  'shift='+shift+'&tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir,
          dataType: 'json',
          success : function(response){              					
          					$('#r_value').val(response.r_value);          					
          					$('#r_pay').val(response.r_pay);          					
          					$('#r_outstanding').val(response.r_outstanding);          					          					
          			}
          	});

      $('#tabel_d_sales_dt').dataTable().fnDestroy();
    tablex = $("#tabel_d_sales_dt").DataTable({        
         responsive: false,
        "language": dataTableLanguage,
    	processing: true,            
            ajax: {
              "url": "{{ url("penjualan/laporan-penjualan-pesanan/table") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",
                    "type"  :"pesanan",
                    "shift" :$('#shift').val(),
                    "tgl_awal" :$('#tgl_awal').val(),                                        
                    "tgl_akhir" :$('#tgl_akhir').val(),       
                    },
              },
            columns: [
            	{ data : 'DT_Row_Index' },
             	{ data : 'r_date' },
		        { data : 'r_reff' },
		        { data : 'r_cus'},
		        { data : 'r_value' },
		        { data : 'tgl' },
		        { data : 'jml' },
		        { data : 'r_outstanding' },
           
            ],
            "orderable": true,
             'columnDefs': [
                
               {
                    "targets": 5,
                    "className": "text-right",
               }

               ],
            //responsive: true,

            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            
             "rowCallback": function( row, data, index ) {                    
                if (data['s_status']=='draft') {
                     $('td', row).addClass('warning');
                } 
              }   
           
    });
}

function print_excel(){	
		var tgl_awal = $("#tgl_awal").val();
	 	var tgl_akhir = $("#tgl_akhir").val();	 	
	 	if(tgl_awal != '' && tgl_akhir != '') {
		 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
		 	var url_target =  "{{ url('/penjualan/laporan-penjualan-pesanan/print_laporan-excel') }}" + arg;
		 	window.open(url_target, '_blank');
	 	}
	 	else {
	 		iziToast.error({
	 			title : 'Error!',
	 			message : 'Masukkan tanggal dengan benar'
	 		});
	 	}

	
}

</script>