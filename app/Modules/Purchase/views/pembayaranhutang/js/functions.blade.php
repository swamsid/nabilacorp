<script>
	

	 function refresh_d_payable() {
	 	$('#tgl_awal, #tgl_akhir').val('')
	 	tabel_d_payable.ajax.url("{{ url('/purchasing/pembayaran_hutang/find_d_payable') }}").load();
	 }
	 function find_d_payable() {
	 	var tgl_awal = $('[name="tgl_awal"]').val();
	 	var tgl_akhir = $('[name="tgl_akhir"]').val();
	 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
	 	var url_target =  "{{ url('/purchasing/pembayaran_hutang/find_d_payable') }}" + arg;
	 	tabel_d_payable.ajax.url(url_target).load();
	 	// tabel_d_payable.ajax.reload();
	 }

	 function open_payment(obj) {
	 	var tr = $(obj).parents('tr');
	 	var data = tabel_d_payable.row( tr ).data();
	 	var o_payment = $('#form_payment');
	 	o_payment.find('#pd_payable').val( 
	 		get_currency(data.p_id )
	 	);
	 	o_payment.find('#p_pay').val( 
	 		get_currency(data.p_pay )
	 	);
	 	o_payment.find('#p_value').val( 
	 		get_currency(data.p_value )
	 	);
	 	o_payment.find('#p_code').val( data.p_code );
	 	o_payment.find('#p_ref').val( data.p_ref );
	 	o_payment.find('#p_outstanding').val( 
	 		get_currency(data.p_outstanding )
	 	);
	 }

	 function open_detail(obj) {
	 	var tr = $(obj).parents('tr');
	 	var data = tabel_d_payable.row( tr ).data();
	 	var o_detail = $('#form_detail');
	 	o_detail.find('#p_date').text( 
	 		moment(data.p_date).format('DD/MM/YYYY') 
	 	);
		o_detail.find('#p_duedate').text( 
			moment(data.p_duedate).format('DD/MM/YYYY')
		);
		o_detail.find('#p_code').text( data.p_code );
		o_detail.find('#p_value').text( 
			get_currency(data.p_value) 
		);
		o_detail.find('#p_pay').text( 
			get_currency(data.p_pay) 
		);
		o_detail.find('#p_outstanding').text( 
			get_currency(data.p_outstanding) 
		);

		find_d_payable_dt(data.p_id);

	 }

	 function find_d_payable_dt(p_id) {
	 	$.ajax({
		      url: "{{ url('/purchasing/pembayaran_hutang/find_d_payable_dt') }}/" + p_id,
		      type: 'GET',
		      dataType: 'json',
		      success: function (response) {
				  render_d_payable_dt(response.data);
		      }
		});
	 }

	 function render_d_payable_dt(d_payable_dt) {
	 	var list_group = $('#list_d_payable_dt');
	 	list_group.html('');
	 	if(d_payable_dt.length > 0) {
	 		for(x = 0;x < d_payable_dt.length;x++) {
	 			var data = d_payable_dt[x];
	 			var pd_datepay = moment(data.pd_datepay).format('DD/MM/YYYY');
	 			var list_group_item = $('<a href="#" class="list-group-item"></a>')
	 			var pd_datepay_item = $('<h4>' + pd_datepay + '</h4>');
	 			var pd_value_item = $('<p>' + get_currency(data.pd_value) + '</p>');

	 			list_group_item.append(pd_datepay_item);
	 			list_group_item.append(pd_value_item);

	 			list_group.append(list_group_item);
	 		}
	 	}
	 	else {
	 		list_group.html('<a href="#" class="list-group-item">Belum ada pembayaran</div>')
	 	}
	 }

	 function insert_d_payable_dt() {
	 	var data = $('#form_payment form').serialize();
	 	$.ajax({
		      url: "{{ url('/purchasing/pembayaran_hutang/insert_d_payable_dt') }}",
		      type: 'GET',
		      data: data,
		      dataType: 'json',
		      success: function (response) {
				  if(response.status == 'sukses') {
				  	iziToast.success({
				  		title : 'Info',
				  		message : 'Sukses menyimpan data'
				  	});

				  	tabel_d_payable.ajax.reload();
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

	 function print_laporan_pembayaran_hutang() {
	 	var tgl_awal = $('[name="tgl_awal"]').val();
	 	var tgl_akhir = $('[name="tgl_akhir"]').val();
	 	var arg = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;
	 	arg = arg.replace(/\//g, '-');
	 	var url_target =  "{{ url('/purchasing/pembayaran_hutang/laporan_pembayaran_hutang') }}" + arg;
	 	location.href = url_target;
	 }
</script>