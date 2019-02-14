<script>
	items = null;
	
	$(document).ready(function(){
		$('#stb_date').datepicker({
			format : 'dd-mm-yyyy'
		})
		$('#stb_date').val(
	      moment().format('DD/MM/YYYY')
	    );
		
		$('#stb_pid').select2({
          placeholder: "Pilih Kode PO",
          ajax: {
            url: "{{ route('find_d_shop_purchase_order') }}",
            dataType: 'json',
            data: function (params) {
              return {
                  keyword: $.trim(params.term),
              };
            },
            processResults: function (res) {
            	for(x in res.data) {
            		res.data[x].id = res.data[x].spo_id; 
            		res.data[x].text = res.data[x].spo_code; 
            	}
                return {
                    results: res.data
                };
            },
            cache: true
          }, 
        });

        $('#stb_pid').change(function(){
        	var data = $(this).select2('data')[0];
        	var s_company = data.s_company;
        	var disc_value = data.spo_disc_value;
        	var tax_percent = data.spo_tax_percent;
        	$('#stb_disc_value').val(
        		accounting.formatMoney(disc_value, '', 0, '.', ',')
        	);
        	$('#stb_tax_percent').val(
        		accounting.formatMoney(tax_percent, '', 0, '.', ',')
        	);
        	$('#stb_sup').val(s_company);
        	find_d_shop_purchaseorder_dt(data.id);
        });

		tabel_d_shop_terima_pembelian_dt = $('#tabel_d_shop_terima_pembelian_dt').DataTable({
			'columnDefs': [

		   		{
		   			"targets": [1, 2, 5, 6, 7],
		   			"className": "text-right",
		   		}
	   		],
	   		"createdRow": function( row, data, dataIndex ) {
	   				// Function untuk mengkalkulasi subtotal dan grand total
	          		var stbdt_qtyconfirm = $(row).find('[name="stbdt_qty[]"]');
          			var spodt_qty = $(row).find('[name="spodt_qty[]"]').val();
          			var qty_masuk = $(row).find('[name="qty_masuk[]"]').val();
          			if(qty_masuk >= spodt_qty) {
          				stbdt_qtyconfirm.attr('readonly', 'readonly');
          			}
	          		stbdt_qtyconfirm.on('change keyup', function(){
	          			var qtyconfirm = $(this).val();
	          			qtyconfirm = qtyconfirm != '' ? qtyconfirm : 0;
	          			var tr = $(this).parents('tr');
	          			// Menghitung batas maksimal pengambilan barang
	          			var spodt_qty = tr.find('[name="spodt_qty[]"]').val();
	          			var qty_masuk = tr.find('[name="qty_masuk[]"]').val();
	          			var selisih = spodt_qty - qty_masuk;
	          			if(qtyconfirm > selisih) {
	          				iziToast.error({
			                    title: 'Info',
			                    message: 'Jumlah yang anda masukkan melebihi batas maksimal.'
			                });
			                $(this).val(0);
			                qtyconfirm = 0;
	          			}

	          			var price = tr.find('[name="stbdt_price[]"]').val();
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

					tabel_d_shop_terima_pembelian_dt.row.add(
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


		$('#tabel_d_shop_terima_pembelian_dt').on( 'draw.dt', function () {
			// Menghitung grand total penerimaanbarang 
		   count_grandtotal();
		} );
		$('#stb_disc_value').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
		$('#stb_disc_value, #stb_tax_percent').on('change keyup', function(){
			count_grandtotal();
		});
	});
</script>