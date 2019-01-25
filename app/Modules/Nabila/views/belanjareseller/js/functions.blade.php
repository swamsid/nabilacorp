<script>
	function deleteProduksi(id) {
		var url = "{{ route('delete_belanjareseller', [ 'id' => '']) }}/";
		url += id;

		$.ajax({
            url : url,
            type: 'get',
            dataType:'json',
            success:function (response){
            	if(response.status == 'sukses') {
            		iziToast.success({
				        position:'topRight',
				        timeout: 2000,
				        title: '',
				        message: "Data berhasil dihapus.",
				    });
	            	 
            	}
            	else {
            		iziToast.error({
				        position:'topRight',
				        timeout: 2000,
				        title: '',
				        message: "Terjadi kesalahan.",
				    });
            	}

            }
        })
	};

	function form_update_s_status(obj) {
		var tr = $(obj).parents('tr');
		var data = tablex.row( tr ).data();
		d_sales.s_id = data.s_id;
	}

	function update_s_status() {
		var s_id = d_sales.s_id;
		var s_status = $('#modal_alter_status #s_status').val();
		var formdata = 's_id=' + s_id + '&s_status=' + s_status;
		var url = '{{ route("update_s_status_belanjareseller") }}';

		$.ajax({
            url : url,
            type: 'get',
            data : formdata,
            dataType:'json',
            success:function (response){
            	if(response.status == 'sukses') {
            		iziToast.success({
				        position:'topRight',
				        timeout: 2000,
				        title: '',
				        message: "Status berhasil diupdate.",
				    });
	            	$('#modal_alter_status').modal('hide');
	            	tablex.ajax.reload()
            	}
            	else {
            		iziToast.error({
				        position:'topRight',
				        timeout: 2000,
				        title: '',
				        message: "Terjadi kesalahan.",
				    });
            	}

            }
        })
	}
</script>