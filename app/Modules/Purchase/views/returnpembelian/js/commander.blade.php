<script>
	purchase_return = { pr_id : null }
	$(document).ready(function(){
		$('#tgl_awal').val(
	      moment().subtract(7, 'days').format('DD/MM/YYYY')
	    );
	    $('#tgl_akhir').val(
	      moment().format('DD/MM/YYYY')
	    );

	    $('#tgl_awal').datepicker({
	         format: "dd/mm/yyyy"
	    });

	    $('#tgl_akhir').datepicker({
	         format: "dd/mm/yyyy"
	    });

		tabel_d_purchase_return = $("#tabel_d_purchase_return").DataTable({
		      ajax: {
		        "url": "{{ url('/purchasing/returnpembelian/find_d_purchase_return') }}?",
		        "type": "get",
		        data: {
		          "_token": "{{ csrf_token() }}"
		        },
		      },
		      columns: [
		        { 
		        	data : null,
		        	render : function(res) {
		        		var date = moment(res.pr_datecreated).format('DD/MM/YYYY');
		        		return date;
		        	}
		        },
				{ data : 'pr_code' },
				{ data : 'm_name' },
				{ data : 'pr_method' },
				{ data : 's_company' },
				{ 
					data : null,
					render : function(res) {
						var currency = 'Rp. ' + get_currency(res.pr_pricetotal);
						return currency;
					} 
				},
				{ 
					data : null,
					render : function(res) {
						var classname;
						if(res.pr_status == 'WT') {
							classname = 'label-info';
						}
						else if(res.pr_status == 'AP') {
							classname = 'label-primary';

						}
						else if(res.pr_status == 'NA') {
							classname = 'label-danger';

						}
						var label = "<label class='label " + classname + "'>" + res.pr_status_label + "</label>"
						return label;
					} 
				},

				{ 
					data : null,
					render : function(res) {
						var is_disabled = 'disabled';
						if(res.pr_status != 'DE') {
							is_disabled ='';
						}
						var btn = "<button " + is_disabled + " class='btn btn-success'><i class='fa fa-check' data-toggle='modal' data-target='#modal_alter_status'></i></button"
						return btn;
					} 
				},

		        { 
		        	data : null,
		        	render : function(res) {
		        		var is_disabled = 'disabled';
						if(res.pr_status != 'DE') {
							is_disabled ='';
						}
		        		var detail_btn = '<button id="detail_btn" onclick="form_preview(this)" class="btn btn-warning btn-sm" title="Detail" data-toggle="modal" data-target="#form_detail" ><i class="fa fa-eye"></i></button>';
		        		var edit_btn = '<button ' + is_disabled + ' id="edit_btn" onclick="form_perbarui(this)" class="btn btn-primary btn-sm" title="Approve"><i class="fa fa-pencil"></i></button>';

		        		var remove_btn = '<button ' + is_disabled + ' id="remove_btn" onclick="remove_data(this)" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash-o"></i></button>';

		        		var result = '<div class="btn-group">' + detail_btn + edit_btn + remove_btn + '</div>';

		        		return result;
		        	}
		        },
		      ],
		      'columnDefs': [
	               {
	                  'targets': 5,
	                  'createdCell':  function (td) {
	                     $(td).attr('align', 'right'); 
	                  }
	               },
	               {
	                  'targets': [6, 7, 8],
	                  'className' : 'text-center'
	               }
	          ],				
	          
		    });
	});
</script>