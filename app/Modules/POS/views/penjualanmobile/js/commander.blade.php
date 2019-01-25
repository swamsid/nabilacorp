<script type="text/javascript">

	function print_laporan() {
		var tgl_awal = $('[name="tgl_awal"]').val();
	 	var tgl_akhir = $('[name="tgl_akhir"]').val();
	 	if(tgl_awal != '' && tgl_akhir != '') {
		 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
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

	 function refresh_d_sales_dt() {
	 	$('#tgl_awal, #tgl_akhir').val('')
	 	tabel_d_sales_dt.ajax.url("{{ url('/penjualan/penjualanmobile/find_d_sales_dt') }}").load();
	 }
	 function find_d_sales_dt() {
	 	var tgl_awal = $('[name="tgl_awal"]').val();
	 	var tgl_akhir = $('[name="tgl_akhir"]').val();
	 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
	 	var url_target =  "{{ url('/penjualan/penjualanmobile/find_d_sales_dt') }}" + arg;
	 	tabel_d_sales_dt.ajax.url(url_target).load();
	 }

     $(document).ready(function(){
          // Datepicker untuk rentang waktu
          $('#tgl_awal, #tgl_akhir').attr('autocomplete', 'off');
	      $('#tgl_awal, #tgl_akhir').datepicker({
	        format:"dd/mm/yyyy"
	      });   

			tabel_d_sales_dt = $("#tabel_d_sales_dt").DataTable({
		      ajax: {
		        "url": "{{ url('/penjualan/penjualanmobile/find_d_sales_dt') }}",
		        "type": "get",
		        data: {
		          "_token": "{{ csrf_token() }}",
		          "tanggal1": $('#tanggal1').val(),
		          "tanggal2": $('#tanggal2').val(),
		        },
		      },
		      columns: [
		        { data : 'i_name' },
		        { data : 's_note' },
		        { 
		          data : null,
		          render : function(res) {
		            var date = new Date(res.sd_date);
		            var day = date.getDate();
		            var month = date.getMonth() + 1;
		            var year = date.getFullYear();

		            var content = day + '/' + month + '/' + year;
		            return content;
		          } 
		        },
		        
		        
		        { data : 's_nama_cus' },
		        { data : 's_detname' },
		        { data : 'sd_qty' },
		        { data : 'sd_price' },
		        { data : 'sd_disc_percent' },
		        { data : 'sd_disc_value' },
		        { data : 'sd_total' },
		        
		      ]

		    }); 
     });
</script>