<script type="text/javascript">

     $(document).ready(function(){
          // Datepicker 
          $('#tgl_awal, #tgl_akhir, #rd_datepay').attr('autocomplete', 'off');
	      $('#tgl_awal, #tgl_akhir, #rd_datepay').datepicker({
	        format:"dd/mm/yyyy"
	      });   

	      $('#tgl_awal').val( moment().subtract(7, 'days').format('DD/MM/YYYY') );
	      $('#tgl_akhir').val( moment().format('DD/MM/YYYY') );

	      var req = 'tgl_awal=' + $('#tgl_awal').val() + '&tgl_akhir=' + $('#tgl_akhir').val();
	      req = req.replace('/', '%2F');
	      format_currency( $('#rd_value') );

			tabel_d_receivable = $("#tabel_d_receivable").DataTable({
		      ajax: {
		        "url": "{{ url('/penjualan/pembayaranpiutang/find_d_receivable') }}?" + req,
		        "type": "get",
		        data: {
		          "_token": "{{ csrf_token() }}"
		        },
		      },
		      columns: [
		        { 
		        	data : null,
		        	render : function(res) {
		        		var result = moment(res.r_date).format('DD/MM/YYYY');
		        		return result;
		        	}
		        },
		        { 
		        	data : null,
		        	render : function(res) {
		        		var result = moment(res.r_duedate).format('DD/MM/YYYY');
		        		return result;
		        	}
		        },
				{ data : 'r_code'},
				{ data : 'r_customer_name'},
				{ data : 'r_alamat_cus'},
				{ 
					data : null,
					render : function(res) {
						return get_currency(res.r_value);
					}
				},
				{ 
					data : null,
					render : function(res) {
						return get_currency(res.r_pay);
					}
				},
				{ 
					data : null,
					render : function(res) {
						return get_currency(res.r_outstanding);
					}
				},
		        { 
		        	data : null,
		        	render : function(res) {
		        		var is_paid_off = res.r_outstanding <= 0 ? 'disabled' : '';  
		        		
		        		var detail_btn = '<button id="detail_btn" onclick="open_detail(this)" class="btn btn-success btn-sm" title="detail" data-toggle="modal" data-target="#form_detail"  style="margin-right:2mm"><i class="fa fa-indent"></i></button>';
		        		var payment_btn = '<button id="payment_btn" onclick="open_payment(this)" class="btn btn-primary btn-sm" title="payment" data-toggle="modal" data-target="#form_payment" ' + is_paid_off + '><i class="fa fa-money"></i></button>';

		        		var result = detail_btn + payment_btn;

		        		return result;
		        	}
		        },
		      ],
		      'columnDefs': [
	               {
	                  'targets': [3, 4, 5],
	                  'createdCell':  function (td) {
	                     $(td).attr('align', 'right'); 
	                  }
	               }
	          ],				
	          "createdRow": function( row, data, dataIndex ) {
	          		var today = moment();
	          		var duedate = moment(data.r_duedate);
	          		var difference = moment.duration( duedate.diff(today) ).asDays();

	          		if(data.r_outstanding <= 0) {
	          			$(row).css('background-color', '#9ce2c0');
	          		}
	          		else{
	          			if(difference >= 1 && difference < 4) {
		          			$(row).css('background-color', '#eff2b3');
	          			}
	          			else if(difference <= 0) {
		          			$(row).css('background-color', '#f2cbcc');
	          				
	          			}
	          		}
			 	}
		    }); 

     });
</script>