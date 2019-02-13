<script>
	tabel_m_customer = $("#tabel_m_customer").DataTable({
		      ajax: {
		        "url": "{{ url('/nabila/membership/get_data_all') }}?",
		        "type": "get",
		        data: {
		          "_token": "{{ csrf_token() }}"
		        },
		      },
		      columns: [
		       
				{ data : 'c_name'},
				{ data : 'c_email'},
				{ data : 'c_hp'},
				{
					data : null,
					render : function(data) {
						var preview_btn = '<button onclick="open_preview(' + data.c_id + ')" class="btn btn-info btn-sm" title="edit" style="margin-right:2mm"><i class="fa fa-eye"></i></button>';
						var edit_btn = '<button onclick="open_form_alter(' + data.c_id + ')" class="btn btn-primary btn-sm" title="edit" style="margin-right:2mm"><i class="fa fa-pencil"></i></button>';
						var remove_btn = '<button onclick="remove_data(' + data.c_id + ')" class="btn btn-danger btn-sm" title="edit"><i class="glyphicon glyphicon-trash"></i></button>';
						var buttons = preview_btn + edit_btn + remove_btn;

						return buttons;
					}
				}
		      ]
		    }); 
</script>