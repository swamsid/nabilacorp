<script type="text/javascript">

  $('.select-2').select2();

  $('.datepicker').datepicker({
      format:"dd-mm-yyyy",  
      autoclose: true,      
  }).datepicker("setDate",'now');


  $('#type').change(function(){
    if($(this).val() == '1'){
      $('#optional').fadeOut();
    }else{
      $('#optional').fadeIn();
    }

    // console.log($('#optional').html());
  })

	dateAwal();

	function dateAwal(){	      
	      $('#tgl_awal').datepicker({
	            format:"dd-mm-yyyy",        
	            autoclose: true,
	      }).datepicker( "setDate", new Date());
	}


	function resetData(){  
	  dateAwal();
	  table();
	}


	function print_laporan() 
   {
		var tgl_awal = $('[name="tgl_awal"]').val();
	 	var tgl_akhir = $('[name="tgl_akhir"]').val();
	 	var shift = $('#shift').val();
	 	if(tgl_awal != '' && tgl_akhir != '') 
      {
		 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir+ '&shift=' + shift;
		 	var url_target =  "{{ url('/penjualan/penjualanmobile/print_laporan') }}" + arg;
		 	window.open(url_target, '_blank');
	 	}
	 	else 
      {
	 		iziToast.error({
	 			title : 'Error!',
	 			message : 'Masukkan tanggal dengan benar'
	 		});
	 	}

	}

   function print_excel() 
   {
      var tgl_awal = $('[name="tgl_awal"]').val();
      var tgl_akhir = $('[name="tgl_akhir"]').val();
      var shift = $('#shift').val();
      if(tgl_awal != '' && tgl_akhir != '') 
      {
         var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir+ '&shift=' + shift;
         var url_target =  "{{ url('/penjualan/penjualanmobile/print_laporan_excel') }}" + arg;
         window.open(url_target, '_blank');
      }
      else 
      {
         iziToast.error({
            title : 'Error!',
            message : 'Masukkan tanggal dengan benar'
         });
      }

   }

   function analisa(){
      $('#modal-analisa').modal('show');
   }



var tablex;
setTimeout(function () {            
   table();
      }, 1500);


   function table()
   {
      var shift=$('#shift').val();
      var tgl_awal=$('#tgl_awal').val();
      var tgl_akhir=$('#tgl_akhir').val();
      $.ajax({
          url     :  baseUrl+'/penjualan/penjualanmobile/totalPenjualan',
          type    : 'GET', 
          data    :  'shift='+shift+'&tgl_awal='+tgl_awal+'&tgl_akhir='+tgl_akhir,
          dataType: 'json',
          success : function(response){              					
          					$('#percent').val(response.sd_disc_value);          					
          					$('#total').val(response.sd_total);
          			}
          	});
      $('#tabel_d_sales_dt').dataTable().fnDestroy();
      tablex = $("#tabel_d_sales_dt").DataTable({        
         responsive: true,
         "language": dataTableLanguage,
         processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("penjualan/penjualanmobile/find_d_sales_dt") }}",
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
               { data : 'i_name' },
               { data : 's_note' },
               { data : 's_date' },
               { data : 's_detname' },
               { data : 'sd_qty', "className": "text-right" },
               { data : 'sd_price', "className": "text-right" },
               { data : 'sd_disc_value', "className": "text-right" },
               { data : 'sd_disc_percentvalue', "className": "text-right" },		        
               { data : 'sd_total', "className": "text-right" },
           
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

   var date = new Date();
   var newdate = new Date(date);

   newdate.setDate(newdate.getDate()-3);
   var nd = new Date(newdate);

   $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
   }).datepicker("setDate", nd);

   $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
   });//datepicker("setDate", "0");

   $('#shift').select2();

</script>