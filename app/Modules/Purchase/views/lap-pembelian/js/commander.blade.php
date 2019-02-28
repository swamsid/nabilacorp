<script>
  purchasingharian = { d_pcsh_id : null };
  $(document).ready(function(){
    $('#tgl_awal_belanjaharian').val(
      moment().subtract(7, 'days').format('DD-MM-YYYY')
    );
    $('#tgl_akhir_belanjaharian').val(
      moment().format('DD-MM-YYYY')
    );
    tabel_d_purchaseharian = $("#tabel_d_purchaseharian").DataTable({
      ajax: {
        "url": "{{ url('/purchasing/belanjaharian/find_d_purchasingharian') }}",
        
        data: function(){
          var tgl_awal = $('#tgl_awal_belanjaharian').val();
          var tgl_akhir = $('#tgl_akhir_belanjaharian').val();
          var outp = {
            "tgl_awal" : tgl_awal,
            "tgl_akhir" : tgl_akhir,
            "_token": "{{ csrf_token() }}",
          }

          return outp;
        },
      },
      columns: [
          { 
            data : null,
            render : function() {
              return '';
            }
          },
          { 
            data : null,
            render : function(res) {
              var result = moment(res.d_pcsh_date).format('DD/MM/YYYY');
              return result;
            }  
          },

          { data : 'm_name' },
          { data : 'd_pcsh_code' },
          { data : 'c_divisi' },
          { data : 'd_pcsh_keperluan' },
          { 
            data : null, 
            render : function(res) {
              var currency = 'Rp. ' + accounting.formatMoney(res.d_pcsh_totalprice,"",0,'.',',');

              return currency;
            }
          },
          
          
          
      ],
      'order' : [[1, 'asc']],
      'columnDefs' : [
        {
          targets : 6,
          className : 'text-right'
        },
        {
          targets : 0,
          searchable : false,
          orderable : false
        }

      ],
      "rowCallback": function (row, data, index) {

        /*$node = this.api().row(row).nodes().to$();*/

        if (data['s_status'] == 'draft') {
          $('td', row).addClass('warning');
        }
      }

    });

    tabel_d_purchaseharian.on( 'order.dt search.dt', function () {
        tabel_d_purchaseharian.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
  });
</script>