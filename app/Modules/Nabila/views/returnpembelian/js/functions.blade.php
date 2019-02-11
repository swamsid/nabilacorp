<script>
  function form_update_spr_status(obj) {
      var tr = $(obj).parents('tr');
      var data = tabel_d_shop_purchase_return.row( tr ).data();
      console.log(data);
      purchase_return.spr_id = data.spr_id;
    }
  function update_spr_status() {
    var spr_id = purchase_return.spr_id;
    var spr_status = $('#modal_alter_status #spr_status').val();
    var formdata = 'spr_id=' + spr_id + '&spr_status=' + spr_status;
    var url = '{{ route("update_spr_status_returnpembelian") }}';

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
                tabel_d_shop_purchase_return.ajax.reload()
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

	function remove_data(obj) {
		  var tr = $(obj).parents('tr');
		  var id = tabel_d_shop_purchase_return.row(tr).data().spr_id;
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
                       url: '{{ url("/nabila/returnpembelian/delete_d_shop_purchase_return") }}/' + id,
                       success: function(response){
                            if (response.status =='sukses') {
                              iziToast.success({
				                    title: 'Info',
				                    message: 'Data berhasil dihapus.'
				              });
                              tabel_d_shop_purchase_return.ajax.reload();
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
		  var id = tabel_d_shop_purchase_return.row(tr).data().spr_id;
		  location.href = '{{ url("/nabila/returnpembelian/form_perbarui") }}/' + id;
    }      

	function form_preview(obj) {
		  var tr = $(obj).parents('tr');
		  var id = tabel_d_shop_purchase_return.row(tr).data().spr_id;
		  location.href = '{{ url("/nabila/returnpembelian/form_preview") }}/' + id;
    }      

    // Mencari data
  function cari(){
    var tgl_awal = $('[name="tgl_awal"]').val();
    var tgl_akhir = $('[name="tgl_akhir"]').val();
    var url_target = '{{ route('find_d_shop_purchase_return') }}?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir; 
    tabel_d_shop_purchase_return.ajax.url(url_target).load();
  }


  // mereset data
  function resetData(){  
    $('#tgl_awal').val( moment().subtract(7, 'days').format('DD/MM/YYYY') );
    $('#tgl_akhir').val( moment().format('DD/MM/YYYY') );
    var url_target = '{{ route('find_d_shop_purchase_return') }}?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir; 
    tabel_d_shop_purchase_return.ajax.url(url_target).load();
  }

</script>