<script>
	function remove_data(obj) {
		  var tr = $(obj).parents('tr');
		  var id = tabel_d_purchase_return.row(tr).data().pr_id;
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
                       url: '{{ url("/purchasing/returnpembelian/delete_d_purchase_return") }}/' + id,
                       success: function(response){
                            if (response.status =='sukses') {
                              iziToast.success({
				                    title: 'Info',
				                    message: 'Data berhasil dihapus.'
				              });
                              tabel_d_purchase_return.ajax.reload();
                            }
                            else {
                              iziToast.error({
				                    title: 'Info',
				                    message: 'Data gagal dihapus.'
				              });
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

	function form_perbarui(obj) {
		  var tr = $(obj).parents('tr');
		  var id = tabel_d_purchase_return.row(tr).data().pr_id;
		  location.href = '{{ url("/purchasing/returnpembelian/form_perbarui") }}/' + id;
    }      

	function form_preview(obj) {
		  var tr = $(obj).parents('tr');
		  var id = tabel_d_purchase_return.row(tr).data().pr_id;
		  location.href = '{{ url("/purchasing/returnpembelian/form_preview") }}/' + id;
    }      

</script>