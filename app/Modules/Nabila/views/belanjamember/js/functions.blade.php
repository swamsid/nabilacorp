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
	            	setTimeout(function(){
	            		location.href = "{{ route('index_belanjareseller') }}";
	            	}, 2000); 
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