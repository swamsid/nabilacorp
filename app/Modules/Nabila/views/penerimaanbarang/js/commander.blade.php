<script>
  terima_pembelian = { stb_id : null};
  tabel_d_shop_terima_pembelian = null;
  $(document).ready(function(){
    $('#tgl_awal').val(
      moment().subtract(7, 'days').format('DD/MM/YYYY')
    );
    $('#tgl_akhir').val(
      moment().format('DD/MM/YYYY')
    );
    $('#tgl_akhir, #tgl_awal').datepicker({
      format : 'dd/mm/yyyy'
    });

    tabel_d_shop_terima_pembelian = $("#tabel_d_shop_terima_pembelian").DataTable({
      ajax: {
        "url": "{{ url('nabila/penerimaanbarang/find_d_shop_terima_pembelian') }}",
        
        data: {
          "_token": "{{ csrf_token() }}",
        },
      },
      columns: [

        { data : 'stb_code' },
        { data : 'stb_date_label' },
        { data : 'spo_code' },
        { data : 'm_name' },
        { data : 's_company' },
        { 
          data : null,
          render : function(res) {
            var preview_btn = '<button onclick="open_preview(' + res.stb_id + ')" class="btn btn-info btn-sm" title="preview" ><i class="fa fa-eye"></i></button>';
            var edit_btn = '';
            var hapus_btn = '';
            if(res.stb_status == 'WT') {  
              edit_btn = '<button onclick="open_form_update(' + res.stb_id + ')" class="btn btn-primary btn-sm" title="edit"><i class="fa fa-pencil"></i></button>';
            }

              var result =  '<div class="btn-group">' + preview_btn + edit_btn + hapus_btn + '</div>';

              return result;
          } 
        }
      ],
      columnDefs : [
        {
          targets : 5,
          className : 'text-center'
        }
      ]
    });

    tabel_d_shop_terima_pembelian_dt = $("#tabel_d_shop_terima_pembelian_dt").DataTable({
      ajax: {
        "url": "{{ url('nabila/penerimaanbarang/find_d_shop_terima_pembelian_dt') }}",
        
        data: {
          "_token": "{{ csrf_token() }}",
        },
      },
      columns: [

        { data : 'stb_date_label' },
        { data : 'stb_code' },
    		{ 
          data : null,
          render : function(res) {
            var label = res.i_code + ' - ' + res.i_name;
            return label;
          }
        },
        { data : 's_company' },
        { data : 'spodt_qty' },
        { data : 'stbdt_qty' }
      ]
    });
  });
</script>