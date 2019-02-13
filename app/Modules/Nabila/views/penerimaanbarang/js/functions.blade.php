<script>
	function form_update_stb_status(obj) {
	    var tr = $(obj).parents('tr');
	    var data = tabel_d_shop_terima_pembelian.row( tr ).data();
	    console.log(data);
	    terima_pembelian.stb_id = data.stb_id;
	  }
	function update_stb_status() {
		var stb_id = terima_pembelian.stb_id;
		var stb_status = $('#modal_alter_status #stb_status').val();
		var formdata = 'stb_id=' + stb_id + '&stb_status=' + stb_status;
		var url = '{{ route("update_stb_status_penerimaanbarang") }}';

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
	            	tabel_d_shop_terima_pembelian.ajax.reload()
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
	               url: '{{ route("delete_d_shop_terima_pembelian", ["id" => ""]) }}/' + id,
	               success: function(response){
	                    if (response.status =='sukses') {
	                      toastr.info('Data berhasil di hapus.');
	                      tabel_d_shop_terima_pembelian.ajax.reload();
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
	  var tgl_awal = $('[name="tgl_awal"]').val();
	  var tgl_akhir = $('[name="tgl_akhir"]').val();
	  var url_target = '{{ route('find_d_shop_terima_pembelian') }}?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir; 
	  tabel_d_shop_terima_pembelian.ajax.url(url_target).load();
	}


	// mereset data
	function resetData(){  
	  $('#tgl_awal').val( moment().subtract(7, 'days').format('DD/MM/YYYY') );
	  $('#tgl_akhir').val( moment().format('DD/MM/YYYY') );
	  var url_target = '{{ route('find_d_shop_terima_pembelian') }}?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir; 
	  tabel_d_shop_terima_pembelian.ajax.url(url_target).load();
	}

	function open_form_update(id) {
		var url = '{{ route("form_update_shop_penerimaanbarang", ["id" => ""]) }}';
		url = url + "/" + id;
		location.href = url;
	}
	function open_preview(id) {
		var url = '{{ route("preview_shop_penerimaanbarang", ["id" => ""]) }}';
		url = url + "/" + id;
		location.href = url;
	}
</script>