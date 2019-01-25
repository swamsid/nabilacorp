<script>
  $(document).ready(function(){
    $('#tgl_awal').val(
      moment().subtract(7, 'days').format('DD/MM/YYYY')
    );
    $('#tgl_akhir').val(
      moment().format('DD/MM/YYYY')
    );

    tabel_d_purchaseharian = $("#tabel_d_purchaseharian").DataTable({
      ajax: {
        "url": "{{ url('/purchasing/belanjaharian/find_d_purchasingharian') }}",
        
        data: {
          "_token": "{{ csrf_token() }}",
        },
      },
      columns: [
          { 
            data : null,
            render : function(res) {
              var result = moment(res.d_pcsh_date).format('DD/MM/YYYY');
              return result;
            }  
          },

          { data : 'm_name' },
          { data : 'd_pcsh_code' },
          { data : 'd_divisi' },
          { data : 'd_pcsh_keperluan' },
          { 
            data : null, 
            render : function(res) {
              var currency = 'Rp. ' + get_currency(res.d_pcsh_totalprice);

              return currency;
            }
          },
          { data : 'd_pcsh_status' },
          { 
            data : null,
            render : function(res) {
              var edit_btn = '<button onclick="open_form_update(' + res.d_pcsh_id + ')" class="btn btn-primary btn-sm" title="edit" style="margin-right:2mm"><i class="fa fa-pencil"></i></button>';
                var hapus_btn = '<button onclick="hapus(' + res.d_pcsh_id + ')" class="btn btn-danger btn-sm" title="hapus"><i class="glyphicon glyphicon-trash"></i></button>';

                var result = edit_btn + hapus_btn;

                return result;
            } 
          }
      ],
      'columnDefs' : [
        {
          targets : 5,
          className : 'text-right'
        }
      ],
      "rowCallback": function (row, data, index) {

        /*$node = this.api().row(row).nodes().to$();*/

        if (data['s_status'] == 'draft') {
          $('td', row).addClass('warning');
        }
      }

    });
  });
</script>