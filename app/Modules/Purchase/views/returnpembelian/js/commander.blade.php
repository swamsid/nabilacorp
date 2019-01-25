<script>
	$(document).ready(function(){
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
				{ data : 'pr_status' },

		        { 
		        	data : null,
		        	render : function(res) {
		        		
		        		var detail_btn = '<button id="detail_btn" onclick="form_preview(this)" class="btn btn-warning btn-sm" title="detail" data-toggle="modal" data-target="#form_detail"  style="margin-right:2mm"><i class="fa fa-eye"></i></button>';
		        		var edit_btn = '<button id="edit_btn" onclick="form_perbarui(this)" class="btn btn-primary btn-sm" title="payment"  style="margin-right:2mm"><i class="fa fa-pencil"></i></button>';

		        		var remove_btn = '<button id="remove_btn" onclick="remove_data(this)" class="btn btn-danger btn-sm" title="payment"><i class="glyphicon glyphicon-trash"></i></button>';

		        		var result = detail_btn + edit_btn + remove_btn;

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
	               }
	          ],				
	          
		    });
	});
</script>