<script>
	current_item = null;

	$(document).ready(function(){

		$('#d_pcsh_divisi').select2();
		tabel_d_purchasingharian_dt = $('#tabel_d_purchasingharian_dt').DataTable({
				'columnDefs': [
	
			   		{
			   			"targets": [1, 3, 4],
			   			"className": "text-right",
			   		}
		   		],
		   		"createdRow": function( row, data, dataIndex ) {
	          		d_pcshdt_qty = $(row).find('[name="d_pcshdt_qty[]"]');
	          		d_pcshdt_qty.on('keyup change', function(){
	          			count_grandtotal();
	          			var tr = $(this).parents('tr');
	          			var d_pcshdt_price = tr.find("[name='d_pcshdt_price[]']").val();
	          			d_pcshdt_price = d_pcshdt_price.replace(/\D/g, '');
	          			d_pcshdt_price = d_pcshdt_price != '' ? parseInt(d_pcshdt_price) : 0;
	          			var qty = $(this).val();
	          			qty = qty != '' ? parseInt(qty) : 0;
	          			var subtotal = qty * d_pcshdt_price;
	          			subtotal = 'Rp ' + get_currency(subtotal);
	          			tr.find('td:eq(4)').text(subtotal);
	          		})

	          		d_pcshdt_price = $(row).find('[name="d_pcshdt_price[]"]');
	          		d_pcshdt_price.maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
	          		d_pcshdt_price.on('keyup change', function(){
	          			count_grandtotal();
	          			var tr = $(this).parents('tr');
	          			var d_pcshdt_price = $(this).val();
	          			d_pcshdt_price = d_pcshdt_price.replace(/\D/g, '');
	          			d_pcshdt_price = d_pcshdt_price != '' ? parseInt(d_pcshdt_price) : 0;
	          			var qty = tr.find("[name='d_pcshdt_qty[]']").val();
	          			qty = qty != '' ? parseInt(qty) : 0;
	          			var subtotal = qty * d_pcshdt_price;
	          			subtotal = 'Rp ' + get_currency(subtotal);
	          			tr.find('td:eq(4)').text(subtotal);
	          		})

			  	}
			});
		$('#d_pcshdt_item').autocomplete({
			source: '{{ url("/purchasing/belanjaharian/find_m_item") }}',
		    minLength: 1,
		    dataType: 'json',
		    select : function(e, res) {
		    	$('#d_pcshdt_qty').focus();
		    	current_item = res.item;
		    	console.log(current_item);
		    }
		});
		

		$('#d_pcshdt_qty').keypress(function(e){
			if(e.keyCode == 13) {
				e.preventDefault();
				if( $(this).val() == '' || $(this).val() == 0) {
					iziToast.error({
	                    title: 'Info',
	                    message: 'Jumlah tidak boleh kosong.'
	                });
				}
				else if( $('#d_pcshdt_item').val() == '' || $('#d_pcshdt_item').val() == null) {
					iziToast.error({
	                    title: 'Info',
	                    message: 'Item tidak boleh kosong'
	                });	
				}
				else {

					var item_selected = current_item;
					var item_exists = $('[ name="d_pcshdt_item[]"][value="' + item_selected.i_id + '"]');
					var is_exists = item_exists.length;
					if(is_exists > 0) {
						var tr = item_exists.parents('tr');
						var qty_exists = tr.find('[name="d_pcshdt_qty[]"]');
						var qty_number = qty_exists.val();
						var qty_append = $(this).val();
						qty_number = qty_number != '' ? parseInt(qty_number) : 0;
						qty_append = qty_append != '' ? parseInt(qty_append) : 0;
						qty_number += qty_append;
						qty_exists.val(qty_number);
						qty_exists.trigger('change');
					}
					else {

						var d_pcshdt_item = "<input type='hidden' name='d_pcshdt_item[]' value='" + item_selected.i_id + "'>" + item_selected.label;
						var d_pcshdt_qty = $(this).val();
						var s_detname = item_selected.s_detname;
						var m_pbuy1 = item_selected.m_pbuy1 ;
						var total_harga = m_pbuy1 * d_pcshdt_qty;
						var aksi = "<button onclick='remove_item(this)' type='button' class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i></button";

						d_pcshdt_qty = "<input type='number' class='form-control form-control-sm text-right' name='d_pcshdt_qty[]' value='" + d_pcshdt_qty + "'>";
						m_pbuy1 = "<input type='text' class='form-control form-control-sm text-right' name='d_pcshdt_price[]' value='Rp " + accounting.formatMoney(m_pbuy1,"",0,'.',',') + "'>";
						total_harga = 'Rp ' + get_currency(total_harga);

						tabel_d_purchasingharian_dt.row.add(
							[d_pcshdt_item, d_pcshdt_qty, s_detname, m_pbuy1, total_harga, aksi]
						).draw();
					}

					$(this).val('');
					var empty_option = $('<option value=""></option>');
					$('#d_pcshdt_item').append(empty_option);
					$('#d_pcshdt_item').val('').trigger('change');
				}
				$('#d_pcshdt_item').focus();
			} 
		});


		$('#tabel_d_purchasingharian_dt').on( 'draw.dt', function () {
			// Menghitung grand total pembelian 
		    count_grandtotal();
		} );
	});
</script>