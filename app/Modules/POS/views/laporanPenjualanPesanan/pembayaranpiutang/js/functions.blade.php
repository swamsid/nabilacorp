<script>
	

	 function refresh_d_receivable() {
	 	$('#tgl_awal, #tgl_akhir').val('')
	 	tabel_d_receivable.ajax.url("{{ url('/penjualan/pembayaranpiutang/find_d_receivable') }}").load();
	 }
	 function find_d_receivable() {
	 	var tgl_awal = $('[name="tgl_awal"]').val();
	 	var tgl_akhir = $('[name="tgl_akhir"]').val();
	 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
	 	var url_target =  "{{ url('/penjualan/pembayaranpiutang/find_d_receivable') }}" + arg;
	 	tabel_d_receivable.ajax.url(url_target).load();
	 	// tabel_d_receivable.ajax.reload();
	 }

	 function open_payment(obj) {
	 	var tr = $(obj).parents('tr');
	 	var data = tabel_d_receivable.row( tr ).data();
	 	var o_payment = $('#form_payment');
	 	o_payment.find('#rd_receivable').val( 
	 		get_currency(data.r_id )
	 	);
	 	o_payment.find('#r_pay').val( 
	 		get_currency(data.r_pay )
	 	);
	 	o_payment.find('#r_value').val( 
	 		get_currency(data.r_value )
	 	);
	 	o_payment.find('#r_code').val( data.r_code );
	 	o_payment.find('#r_ref').val( data.r_ref );
	 	o_payment.find('#r_outstanding').val( 
	 		get_currency(data.r_outstanding )
	 	);
	 }

	 function open_detail(obj) {
	 	var tr = $(obj).parents('tr');
	 	var data = tabel_d_receivable.row( tr ).data();
	 	var o_detail = $('#form_detail');
	 	o_detail.find('#r_ref').text( data.r_ref );
	 	o_detail.find('#r_date').text( 
	 		moment(data.r_date).format('DD/MM/YYYY') 
	 	);
		o_detail.find('#r_duedate').text( 
			moment(data.r_duedate).format('DD/MM/YYYY') 
		);
		o_detail.find('#r_code').text( data.r_code );
		o_detail.find('#r_value').text( 
			get_currency(data.r_value) 
		);
		o_detail.find('#r_pay').text( 
			get_currency(data.r_pay) 
		);
		o_detail.find('#r_outstanding').text( 
			get_currency(data.r_outstanding) 
		);

		find_d_receivable_dt(data.r_id);

	 }

	 function find_d_receivable_dt(r_id) {
	 	$.ajax({
		      url: "{{ url('/penjualan/pembayaranpiutang/find_d_receivable_dt') }}/" + r_id,
		      type: 'GET',
		      dataType: 'json',
		      success: function (response) {
				  render_d_receivable_dt(response.data);
		      }
		});
	 }

	 function render_d_receivable_dt(d_receivable_dt) {
	 	var list_group = $('.list_d_receivable_dt');
	 	list_group.html('');	 	
	 	if(d_receivable_dt.length > 0) {
	 		for(x = 0;x < d_receivable_dt.length;x++) {
	 			var data = d_receivable_dt[x];
	 			var rd_datepay = moment(data.rd_datepay).format('DD/MM/YYYY');
	 			
	 			
	 			$a='<tr><td width="30%">'+rd_datepay+'</td>';
	 			$a+='<td class="text-right" >'+get_currency(data.rd_value)+'</td></tr>';
	 			

	 			list_group.append($a);
	 		}
	 	}
	 	else {
	 		list_group.html('<a href="#" class="list-group-item">Belum ada pembayaran</div>')
	 	}
	 }

	 function insert_d_receivable_dt() {
	 	var data = $('#form_payment form').serialize();
	 	$.ajax({
		      url: "{{ url('/penjualan/pembayaranpiutang/insert_d_receivable_dt') }}",
		      type: 'GET',
		      data: data,
		      dataType: 'json',
		      success: function (response) {
				  if(response.status == 'sukses') {
				  	iziToast.success({
				  		title : 'Info',
				  		message : 'Sukses menyimpan data'
				  	});

				  	tabel_d_receivable.ajax.reload();
				  }
				  else {
				  	iziToast.error({
				  		title : 'Info',
				  		message : 'Gagal menyimpan data'
				  	});
				  }

				 $('#form_payment form')[0].reset();
				  $('#form_payment').modal('hide')
		      }
		});	
	 }

	 function print_laporan_pembayaran_piutang() {
	 	var tgl_awal = $('[name="tgl_awal"]').val();
	 	var tgl_akhir = $('[name="tgl_akhir"]').val();
	 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
	 	arg = arg.replace(/\//g, '-');
	 	var url_target =  "{{ url('/penjualan/pembayaranpiutang/laporan_pembayaran_piutang') }}" + arg;
	 	location.href = url_target;
	 }
</script>