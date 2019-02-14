<script>
	tabel_m_customer = $("#tabel_m_customer").DataTable({
			  processing : true,
			  serverSide : true,
		      ajax: {
		        "url": "{{ url('/master/membership/get_data_all') }}?",
		        "type": "get",
		        data: {
		          "_token": "{{ csrf_token() }}"
		        },
		      },
		      columns: [
		       
				{ data : 'c_name'},
				{ data : 'c_email'},
				{ data : 'c_hp1'},
				{
					data : null,
					render : function(data) {
						var preview_btn = '<button onclick="open_preview(' + data.c_id + ')" class="btn btn-info btn-sm" title="edit" style=""><i class="fa fa-eye"></i></button>';
						var edit_btn = '<button onclick="open_form_alter(' + data.c_id + ')" class="btn btn-primary btn-sm" title="edit" style=""><i class="fa fa-pencil"></i></button>';
						var remove_btn = '<button onclick="remove_data(' + data.c_id + ')" class="btn btn-danger btn-sm" title="edit"><i class="fa fa-trash-o"></i></button>';
						var buttons = '<div class="btn-group">' + preview_btn + edit_btn + remove_btn + "</div>";

						return buttons;
					}
				}
		      ],
		      columnDefs : [{
		      		targets : 3,
		      		className : 'text-center'
		      }]
		    }); 
</script>