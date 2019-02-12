<script>
	function remove_data(id) {
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
                    var url = "{{ route('delete_m_customer', ['id' => '']) }}/";
                    url += id;
                		$.ajax({
                          url     :  url,
                          type    : 'GET', 
                          dataType: 'json',
                          success : function(response){    
                                    
                            if( response.status=='sukses'){
                            	iziToast.success({
                	   				position:'topRight',
                	   				timeout: 2000,
                	   				title: '',
                	   				message: "Hapus data berhasil.",
                	   			});
                              	
                              	tabel_m_customer.ajax.reload();
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
            	});
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

	function open_form_alter(id) {
		location.href = '{{ url("master/membership/form_alter") }}/' + id;
	}

	function open_preview(id) {
		location.href = '{{ url("master/membership/preview") }}/' + id;
	}
</script>