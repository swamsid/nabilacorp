<script>
	

	function form_update_sp_status(obj) {
	    var tr = $(obj).parents('tr');
	    var data = tabel_d_shop_purchase_plan.row( tr ).data();
	    console.log(data);
	    purchase_plan.sp_id = data.sp_id;
	  }
	function update_sp_status() {
		var sp_id = purchase_plan.sp_id;
		var sp_status = $('#modal_alter_status #sp_status').val();
		var formdata = 'sp_id=' + sp_id + '&sp_status=' + sp_status;
		var url = '{{ route("update_sp_status_rencanapembelian") }}';

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
	            	tabel_d_shop_purchase_plan.ajax.reload()
            	}
            	else {
            		iziToast.error({
				        position:'topRight',
				        timeout: 2000,
				        title: '',
				        message: "Terjadi kesalahan.",
				    });
            	}

            },
            error : function() {
            	iziToast.error({
			        position:'topRight',
			        timeout: 1000,
			        title: '',
			        message: "Terjadi kesalahan.",
			    });
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
	               url: '{{ route("delete_d_shop_purchase_plan", ["id" => ""]) }}/' + id,
	               success: function(response){
	                    if (response.status =='sukses') {
	                      toastr.info('Data berhasil di hapus.');
	                      tabel_d_shop_purchase_plan.ajax.reload();
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
	  tabel_d_shop_purchase_plan.ajax.reload();
	}


	// mereset data
	function resetData(){  
	  $('[name="tgl_awal"]').val( moment().subtract(7, 'days').format('DD/MM/YYYY') );
	  $('[name="tgl_akhir"]').val( moment().format('DD/MM/YYYY') );
	  cari();
	}

	function open_form_update(id) {
		var url = '{{ route("form_update_shop_rencanapembelian", ["id" => ""]) }}';
		url = url + "/" + id;
		location.href = url;
	}
	function open_preview(id) {
		var url = '{{ route("preview_shop_rencanapembelian", ["id" => ""]) }}';
		url = url + "/" + id;
		location.href = url;
	}
</script>