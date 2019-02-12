<script>

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
	               url: '{{ url("/penjualan/rencanapenjualan/hapus") }}/' + id,
	               success: function(response){
	                    if (response.status =='sukses') {
	                      toastr.info('Data berhasil di hapus.');
	                      tablex.ajax.reload();
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
	  var url_target = '{{ url("/penjualan/rencanapenjualan/find_d_sales_plan/?") }}tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir + '&_token={{ csrf_token() }}'; 
	  tablex.ajax.url(url_target).load();
	}


	// mereset data
	function resetData(){  
	  $('[name="tgl_awal"]').val( moment().subtract(7, 'days').format('DD/MM/YYYY') );
	  $('[name="tgl_akhir"]').val( moment().format('DD/MM/YYYY') );
	  var url_target = '{{ url("/penjualan/rencanapenjualan/find_d_sales_plan/?") }}tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir + '&_token={{ csrf_token() }}'; 
	  tablex.ajax.url(url_target).load();
	}
</script>