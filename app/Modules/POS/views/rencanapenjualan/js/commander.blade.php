
<script>
	$(document).ready(function(){
		// Jika menggunakan hashtag list
		var hashtag = window.location.hash;
		if( hashtag == '#list' ) {
			$('#list').trigger('click');
		}

		$('[name="tgl_awal"]').val( moment().subtract(7, 'days').format('DD/MM/YYYY') );
	    $('[name="tgl_akhir"]').val( moment().format('DD/MM/YYYY') );
	    var url_request = "{{ url('/penjualan/rencanapenjualan/find_d_sales_plan') }}?tgl_awal=" + $('[name="tgl_awal"]').val() + "&tgl_akhir=" + $('[name="tgl_akhir"]').val();
		tablex = $("#tableListToko").DataTable({
	      responsive: true,
	      "language": dataTableLanguage,
	      processing: true,
	      ajax: {
	        "url": url_request,
	        "type": "get",
	        data: {
	          "_token": "{{ csrf_token() }}",
	          "type": "toko"
	        },
	      },
	      columns: [
	        { 
	          data : null,
	          render : function(res) {
	            var date = new Date(res.sp_date);
	            var day = date.getDate();
	            var month = date.getMonth() + 1;
	            var year = date.getFullYear();

	            var content = day + '/' + month + '/' + year;
	            return content;
	          } 
	        },
	        { data : 'sp_code' },
	        { 
	            data : null,
	            render : function(res) {
	              var content = '<div style="display:flex;justify-content:center"><button id="edit" style="margin-right:1mm" onclick="location.href=\'{{ url("/penjualan/rencanapenjualan/form_perbarui") }}/' + res.sp_id + '\'" class="btn btn-warning btn-xs" title="Edit" type="button"><i class="glyphicon glyphicon-pencil"></i></button><button id="delete" onclick="hapus(' + res.sp_id + ')" class="btn btn-danger btn-xs" title="Hapus" type="button"><i class="glyphicon glyphicon-trash"></i></button></div>';

	              return content;
	            }
	        }
	      ],
	      'columnDefs': [{
	        "targets": 2,
	        "className": "text-right",
	      }],
	      "rowCallback": function (row, data, index) {

	        /*$node = this.api().row(row).nodes().to$();*/

	        if (data['s_status'] == 'draft') {
	          $('td', row).addClass('warning');
	        }
	      }

	    });

	    $('.search_btn').click(function(){
	    	cari();
	    });
	    $('.reset_btn').click(function(){
	    	resetData();
	    });
	    $('[name="tgl_awal"]').keypress(function(e){
	    	if(e.keyCode == 13) {
	    		$('[name="tgl_akhir"]').focus();
	    	}
	    });
	    $('[name="tgl_akhir"]').keypress(function(e){
	    	if(e.keyCode == 13) {
	    		$('.search_btn').trigger('click');
	    	}
	    });
	});
</script>