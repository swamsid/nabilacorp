<script type="text/javascript">
	function open_form_edit(obj) {
		var tr = $(obj).parents('tr');
		var data = tabel_m_price.row( tr ).data()
		var m_pid = $('#m_pid');
		var i_code = $('#i_code');
		var i_name = $('#i_name');
		var m_pbuy1 = $('#m_pbuy1');
		var m_pbuy2 = $('#m_pbuy2');
		var m_pbuy3 = $('#m_pbuy3');
		m_pid.val(data.m_pid);
		i_code.val(data.i_code);
		i_name.val(data.i_name);
		m_pbuy1.val(data.m_pbuy1);
		m_pbuy2.val(data.m_pbuy2);
		m_pbuy3.val(data.m_pbuy3);
	}

	
     $(document).ready(function(){
            // Datepicker untuk rentang waktu
            $('#tgl_awal, #tgl_akhir').attr('autocomplete', 'off');
	        $('#tgl_awal, #tgl_akhir').datepicker({
	          format:"dd/mm/yyyy"
	        });   

			tabel_m_price = $("#tabel_m_price").DataTable({
		      ajax: {
		        "url": "{{ url('/penjualan/manajemenharga/find_m_price') }}",
		        "type": "get",
		        data: {
		          "_token": "{{ csrf_token() }}",
		          "tanggal1": $('#tanggal1').val(),
		          "tanggal2": $('#tanggal2').val(),
		        },
		      },
		      columns: [
		        
		        { 
		          data : null,
		          render : function(res) {
		            var content = res.i_code + ' - ' + res.i_name;
		            return content;
		          } 
		        },
				{ data : 'i_type' },
		        { data : 'g_name' },
		        { data : 'm_pbuy1' },
		        { data : 'm_pbuy2' },
		        { data : 'm_pbuy3' },
		        { 
		          data : null,
		          render : function(res) {
		            var content = "<div style='display:flex;justify-content:center'><button class='btn btn-primary' data-toggle='modal' data-target='#modal_tambah' onclick='open_form_edit(this)'><i class='fa fa-pencil'></i></button></div>";
		            return content;
		          } 
		        }
		        
		      ]

		    });

			$('#insert_m_price_btn').click(function(){
				var data = $('#form_m_price').serialize(); 
				$.ajax({
			      url: "{{ url('/penjualan/manajemenharga/update_m_price') }}",
			      type: 'GET',
			      data: data,
			      dataType: 'json',
			      success: function (response) {
			        if(response.status == 'sukses') {
			          iziToast.success({
				            position: "center",
				            title: '',
				            timeout: 1000,
				            message: 'Data berhasil disimpan.',
				            onClosing : function() {
				              $('#modal_tambah').modal('hide');
				              tabel_m_price.ajax.reload();
				            }
			          });

			        }
			        else {
			        	iziToast.error({
			        		title : 'Error!',
			        		message : 'Gagal meng-update harga'
			        	});
			        	 $('#modal_tambah').modal('hide');
			        }
			      }
			    });
			});
     });
</script>