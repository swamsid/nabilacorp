<script>
	function form_update_spo_status(obj) {
	    var tr = $(obj).parents('tr');
	    var data = tabel_d_shop_purchase_order.row( tr ).data();
	    console.log(data);
	    purchase_order.spo_id = data.spo_id;
	  }
	function update_spo_status() {
		var spo_id = purchase_order.spo_id;
		var spo_status = $('#modal_alter_status #spo_status').val();
		var formdata = 'spo_id=' + spo_id + '&spo_status=' + spo_status;
		var url = '{{ route("update_spo_status_pembelian") }}';

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
	            	tabel_d_shop_purchase_order.ajax.reload()
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

	function hapus(id) {
	  iziToast.show({
	    color: 'red',
	    title: 'Peringatan',
	    message: 'Apakah anda yakin!',
	    position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
	    progressBarColor: 'rgb(0, 255, 184)',
	    buttons: [
	      [
	        '<button>Ok</button>',
	        function (instance, toast) {
	          instance.hide({
	            transitionOut: 'fadeOutUp'
	          }, toast);
	          
	          $.ajax({
	               type: "get",
	               url: '{{ route("delete_d_shop_purchase_order", ["id" => ""]) }}/' + id,
	               success: function(response){
	                    if (response.status =='sukses') {
	                      toastr.info('Data berhasil di hapus.');
	                      tabel_d_shop_purchase_order.ajax.reload();
	                    }
	                    else {

	                      toastr.error('Data gagal di simpan.');
	                    }
	                  }
	               })
	        }
	      ],
	      [
	        '<button>Close</button>',
	         function (instance, toast) {
	          instance.hide({
	            transitionOut: 'fadeOutUp'
	          }, toast);
	        }
	      ]
	    ]
	  });

	}

	// Mencari data
	function cari(){
	   
	  tabel_d_shop_purchase_order.ajax.reload();
	}


	// mereset data
	function resetData(){  
	  cari(); 
	  tabel_d_shop_purchase_order.ajax.url(url_target).load();
	}

	function open_form_update(id) {
		var url = '{{ route("form_update_shop_pembelian", ["id" => ""]) }}';
		url = url + "/" + id;
		location.href = url;
	}
	function open_preview(id) {
		var url = '{{ route("preview_shop_pembelian", ["id" => ""]) }}';
		url = url + "/" + id;
		location.href = url;
	}
</script>