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

    function form_update_pr_status(obj) {
      var tr = $(obj).parents('tr');
      var data = tabel_d_purchase_return.row( tr ).data();
      console.log(data);
      purchase_return.pr_id = data.pr_id;
    }
  function update_pr_status() {
    var pr_id = purchase_return.pr_id;
    var pr_status = $('#modal_alter_status #pr_status').val();
    var formdata = 'pr_id=' + pr_id + '&pr_status=' + pr_status;
    var url = '{{ route("update_pr_status") }}';

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
                tabel_d_purchase_return.ajax.reload()
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

  function find_d_purchase_return() {
      var tgl_awal = $('#tgl_awal').val();
      var tgl_akhir = $('#tgl_akhir').val();
      var req = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;

      var url_target = tabel_d_purchase_return.ajax.url() + req;
      tabel_d_purchase_return.ajax.url(url_target).load();
    }

    function refresh_d_purchase_return() {
      var tgl_awal = moment().subtract(7, 'days').format('DD/MM/YYYY');
      var tgl_akhir = moment().format('DD/MM/YYYY');
      $('#tgl_awal').val( tgl_awal );
      $('#tgl_akhir').val( tgl_akhir );

      var req = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;

      var url_target = tabel_d_purchase_return.ajax.url() + req;
      tabel_d_purchase_return.ajax.url(url_target).load();
    }

</script>