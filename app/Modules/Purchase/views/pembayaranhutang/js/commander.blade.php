<script type="text/javascript">

     $(document).ready(function(){
          // Datepicker 
          $('#tgl_awal, #tgl_akhir, #pd_datepay').attr('autocomplete', 'off');
	      $('#tgl_awal, #tgl_akhir, #pd_datepay').datepicker({
	        format:"dd/mm/yyyy"
	      });   

	      $('#tgl_awal').val( moment().subtract(7, 'days').format('DD/MM/YYYY') );
	      $('#tgl_akhir').val( moment().format('DD/MM/YYYY') );

	      var req = 'tgl_awal=' + $('#tgl_awal').val() + '&tgl_akhir=' + $('#tgl_akhir').val();
	      req = req.replace('/', '%2F');
	      format_currency( $('#pd_value') );

			tabel_d_payable = $("#tabel_d_payable").DataTable({
		      ajax: {
		        "url": "{{ url('/purchasing/pembayaran_hutang/find_d_payable') }}?" + req,
		        "type": "get",
		        data: {
		          "_token": "{{ csrf_token() }}"
		        },
		      },
		      columns: [
		        { 
		        	data : null,
		        	render : function(res) {
		        		var result = moment(res.p_date).format('DD/MM/YYYY');
		        		return result;
		        	}
		        },
		        { 
		        	data : null,
		        	render : function(res) {
		        		var result = moment(res.p_duedate).format('DD/MM/YYYY');
		        		return result;
		        	}
		        },
				{ data : 'p_code'},
				{ 
					data : null,
					render : function(res) {
						return get_currency(res.p_value);
					}
				},
				{ 
					data : null,
					render : function(res) {
						return get_currency(res.p_pay);
					}
				},
				{ 
					data : null,
					render : function(res) {
						return get_currency(res.p_outstanding);
					}
				},
		        { 
		        	data : null,
		        	render : function(res) {
		        		var is_paid_off = res.p_outstanding <= 0 ? 'disabled' : '';  
		        		
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
	          		var duedate = moment(data.p_duedate);
	          		var difference = moment.duration( duedate.diff(today) ).asDays();

	          		if(data.p_outstanding <= 0) {
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