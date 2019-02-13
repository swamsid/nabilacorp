<script>
	items = null;
	
	$(document).ready(function(){
		$('#spo_date').datepicker({
			format : 'dd-mm-yyyy'
		})

		$('#spo_supplier').select2({
          placeholder: "Pilih Supplier",
          ajax: {
            url: "{{ route('find_m_supplier') }}",
            dataType: 'json',
            data: function (params) {
              return {
                  keyword: $.trim(params.term),
              };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
          }, 
        });

		$('#spo_purchaseplan').select2({
          placeholder: "Pilih Kode Rencana",
          ajax: {
            url: "{{ route('find_d_shop_purchase_plan') }}",
            dataType: 'json',
            data: function (params) {
              return {
                  keyword: $.trim(params.term),
                  sp_status : 'AP'
              };
            },
            processResults: function (res) {
            	for(x in res.data) {
            		res.data[x].id = res.data[x].sp_id; 
            		res.data[x].text = res.data[x].sp_code; 
            	}
                return {
                    results: res.data
                };
            },
            cache: true
          }, 
        });

		$('#spo_purchaseplan').change(function(){
        	var id = $(this).val();
        	var data = $(this).select2('data')[0];
        	var opt = $('<option value="' + data.s_id + '">' + data.s_company + '</option>');
        	$('#spo_supplier').append(opt);
        	$('#spo_supplier').val(data.s_id).trigger('change');
        	find_d_shop_purchaseplan_dt(id);
        });

		tabel_d_shop_purchaseorder_dt = $('#tabel_d_shop_purchaseorder_dt').DataTable({
			'columnDefs': [

		   		{
		   			"targets": [1, 2, 4, 5, 6, 7],
		   			"className": "text-right",
		   		}
	   		],
	   		"createdRow": function( row, data, dataIndex ) {
	   				// Function untuk mengkalkulasi subtotal dan grand total
	          		var spodt_qtyconfirm = $(row).find('[name="spodt_qtyconfirm[]"]');
	          		spodt_qtyconfirm.on('change keyup', function(){
	          			var qtyconfirm = $(this).val();
	          			qtyconfirm = qtyconfirm != '' ? qtyconfirm : 0;
	          			var tr = $(this).parents('tr');
	          			var price = tr.find('[name="spodt_price[]"]').val();
	          			var subtotal = qtyconfirm * price;
	          			subtotal = 'Rp ' + accounting.formatMoney(subtotal, '', 0, '.', 
	          				',');
	          			tr.find('td:eq(6)').text(subtotal);
	          			count_grandtotal();
	          		});	

			  }
		});
		$('#sppdt_item').autocomplete({
			source: function (request, response) {
	            $.ajax({
	                url: '{{ route("find_m_item") }}',
	                data: request,
	                success: function (data) {
	                    response($.map(data.m_item, function(value){
	                    	value.label = value.i_code + ' - ' + value.i_name;
	                    	return value;
	                    }));
	                }
	            });
	        },
		    minLength: 1,
		    dataType: 'json',
		    select : function(e, res) {
		    	$('#sppdt_qty').focus();
		    	items = res.item;
		    	$('#stock').val(items.s_qty);
		    	$('#sppdt_satuan').val(items.s_name);
		    	$('#qty').focus();
		    }
		});
		

		$('#qty').keypress(function(e){
			if(e.keyCode == 13) {
				e.preventDefault();
				if( $(this).val() == '' || $(this).val() == 0) {
					iziToast.error({
	                    title: 'Info',
	                    message: 'Jumlah tidak boleh kosong.'
	                });
				}
				else if( $('#sppdt_item').val() == '' || $('#sppdt_item').val() == null) {
					iziToast.error({
	                    title: 'Info',
	                    message: 'Item tidak boleh kosong'
	                });	
				}
				else {

					var item_selected = items;
					var sppdt_item = "<input type='hidden' name='sppdt_item[]' value='" + item_selected.i_id + "'>" + item_selected.label;
					var sppdt_qty = $(this).val();
					var sppdt_satuan = "<input type='hidden' name='sppdt_satuan[]' value='" + item_selected.s_id + "'>" + item_selected.s_name;
					var s_qty = item_selected.s_qty ;
					var sppdt_price = item_selected.i_price ;
					var total_harga = sppdt_price * sppdt_qty;
					var aksi = "<button onclick='remove_item(this)' type='button' class='btn btn-danger'><i class='glyphicon glyphicon-trash'></i></button";

					sppdt_qty = "<input type='number' name='sppdt_qty[]' value='" + sppdt_qty + "'>";
					sppdt_price = "<input type='hidden' name='sppdt_price[]' value='" + sppdt_price + "'>Rp " + accounting.formatMoney(sppdt_price,"",0,'.',',');
					total_harga = 'Rp ' + accounting.formatMoney(total_harga, "", 0, '.', ',');

					tabel_d_shop_purchaseorder_dt.row.add(
						[sppdt_item, s_qty, sppdt_qty, sppdt_price, sppdt_satuan, total_harga, aksi]
					).draw();

					$(this).val('');
					var empty_option = $('<option value=""></option>');
					$('#sppdt_item').val('');
					$('#stock').val('');
					$('#sppdt_satuan').val('');
					$('#sppdt_item').focus();
				}
				$('#sppdt_item').focus();
			} 
		});


		$('#tabel_d_shop_purchaseorder_dt').on( 'draw.dt', function () {
			// Menghitung grand total pembelian 
		   count_grandtotal();
		} );
		$('#spo_disc_value').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
		$('#spo_disc_value, #spo_tax_percent').on('change keyup', function(){
			count_grandtotal();
		});
	});
</script>