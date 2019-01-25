<script>
	function remove_item(obj) {
		// Function untuk menghapus item di tabel detail
		var tr = $(obj).parents('tr');
		console.log(tabel_d_purchasingharian_dt.row( tr ));
		tabel_d_purchasingharian_dt.row( tr ).remove().draw();
	}

	function insert_d_purchasingharian() {
		var form_data = $('#form_d_purchasingharian').serialize();
		$.ajax({
            url: "{{ url('/purchasing/belanjaharian/insert_d_purchasingharian') }}",
            data: form_data,
            success: function(res) {
              if(res.status == 'sukses') {
              	iziToast.success({
                    title: 'Info',
                    message: 'Data Berhasil Tersimpan.'
                });

                setTimeout(function(){
                	location.reload();
                }, 500);
              }
              else {
              	iziToast.error({
                    title: 'Info',
                    message: 'Data Gagal Tersimpan.'
                });

              }
            }
        });
	}

	function update_d_purchasingharian() {
		var form_data = $('#form_d_purchasingharian').serialize();
		$.ajax({
            url: "{{ url('/purchasing/belanjaharian/update_d_purchasingharian') }}",
            data: form_data,
            success: function(res) {
              if(res.status == 'sukses') {
              	iziToast.success({
                    title: 'Info',
                    message: 'Data Berhasil Tersimpan.'
                });

                location.reload();
              }
              else {
              	iziToast.error({
                    title: 'Info',
                    message: 'Data Gagal Tersimpan.'
                });

              }
            }
        });
	}
</script>