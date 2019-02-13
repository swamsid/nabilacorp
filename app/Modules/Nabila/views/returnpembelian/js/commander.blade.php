<script>
	$(document).ready(function(){
		purchase_return = { spr_id : null };

		$('#tgl_awal').val(
	      moment().subtract(7, 'days').format('DD/MM/YYYY')
	    );
	    $('#tgl_akhir').val(
	      moment().format('DD/MM/YYYY')
	    );
	    $('#tgl_akhir, #tgl_awal').datepicker({
	      format : 'dd/mm/yyyy'
	    });
		
		tabel_d_shop_purchase_return = $("#tabel_d_shop_purchase_return").DataTable({
		      ajax: {
		        "url": "{{ url('/nabila/returnpembelian/find_d_shop_purchase_return') }}?",
		        "type": "get",
		        data: {
		          "_token": "{{ csrf_token() }}"
		        },
		      },
		      columns: [
		        { 
		        	data : null,
		        	render : function(res) {
		        		var date = moment(res.spr_datecreated).format('DD/MM/YYYY');
		        		return date;
		        	}
		        },
				{ data : 'spr_code' },
				{ data : 'm_name' },
				{ data : 'spr_method' },
				{ data : 's_company' },
				{ 
					data : null,
					render : function(res) {
						var currency = 'Rp. ' + get_currency(res.spr_pricetotal);
						return currency;
					} 
				},
				{ data : 'spr_status_label' },
				{
		          data : null,
		          render : function(res) {
		            var btn = '-';
		            if(res.spr_status != '') {
		                btn = '<button data-target="#modal_alter_status" data-toggle="modal" class="btn btn-success btn-sm" title="alter_status" style="width:100%" onclick="form_update_spr_status(this)"><i class="fa fa-pencil"></i></button>';
		            }

		            return btn;
		          }
		        },
				

		        { 
		        	data : null,
		        	render : function(res) {
			        	var detail_btn = '<button id="detail_btn" onclick="form_preview(this)" class="btn btn-warning btn-sm" title="detail" data-toggle="modal" data-target="#form_detail"  ><i class="fa fa-eye"></i></button>';
			            var edit_btn = '';
			            var remove_btn = '';
			            if(res.spr_status == 'WT') {	
			        		var edit_btn = '<button id="edit_btn" onclick="form_perbarui(this)" class="btn btn-primary btn-sm" title="payment" ><i class="fa fa-pencil"></i></button>';

			        		var remove_btn = '<button id="remove_btn" onclick="remove_data(this)" class="btn btn-danger btn-sm" title="payment"><i class="fa fa-trash-o"></i></button>';
			        	}

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
	                  'targets': 8,
	                  'className' : 'text-center'
	               }
	          ],				
	          
		    });
	});
</script>