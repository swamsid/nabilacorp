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
                       url: '{{ url("/purchasing/belanjaharian/hapus") }}/' + id,
                       success: function(response){
                            if (response.status =='sukses') {
                              iziToast.success({
				                    title: 'Info',
				                    message: 'Data berhasil dihapus.'
				              });
                              tabel_d_purchasingharian.ajax.reload();
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

    function open_form_update(id) {
    	location.href = "{{ url('purchasing/belanjaharian/form_perbarui/') }}/" + id;
    }

    function find_d_purchasingharian() {
    	var tgl_awal = $('#tgl_awal').val();
    	var tgl_akhir = $('#tgl_akhir').val();
    	var req = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;

    	var url_target = "{{ url('/purchasing/belanjaharian/find_d_purchasingharian') }}" + req;
    	tabel_d_purchasingharian.ajax.url(url_target).load();
    }

    function refresh_d_purchasingharian() {
    	var tgl_awal = moment().subtract(7, 'days').format('DD/MM/YYYY');
    	var tgl_akhir = moment().format('DD/MM/YYYY');
    	$('#tgl_awal').val( tgl_awal );
    	$('#tgl_akhir').val( tgl_akhir );

    	var req = '?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir;

    	var url_target = "{{ url('/purchasing/belanjaharian/find_d_purchasingharian') }}" + req;
    	tabel_d_purchasingharian.ajax.url(url_target).load();
    }
</script>