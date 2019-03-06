<script>
  purchase_order = { spo_id : null};
  tabel_d_shop_purchase_order = null;
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

    tabel_d_shop_purchase_order = $("#tabel_d_shop_purchase_order").DataTable({
      ajax: {
        "url": "{{ route('find_d_shop_purchase_order') }}",
        
        data: {
          "_token": "{{ csrf_token() }}",
        },
      },
      columns: [

        { data : 'spo_date_label' },
        { data : 'spo_code' },
    		{ data : 'm_name' },
        { data : 's_company' },
        { data : 'spo_method' },
        { data : 'spo_total_net_label' },
    		{ data : 'spo_status_label' },
        {
          data : null,
          render : function(res) {
            var btn = '-';
            if(res.sp_status != '') {
                btn = '<button data-target="#modal_alter_status" data-toggle="modal" class="btn btn-success btn-sm" title="alter_status" style="width:100%" onclick="form_update_spo_status(this)"><i class="fa fa-pencil"></i></button>';
            }

            return btn;
          }
        },
        { 
          data : null,
          render : function(res) {
            var preview_btn = '<button onclick="open_preview(' + res.spo_id + ')" class="btn btn-info btn-sm" title="preview" ><i class="fa fa-eye"></i></button>';
            var edit_btn = '';
            var hapus_btn = '';
            if(res.spo_status == 'WT') {	
            	edit_btn = '<button onclick="open_form_update(' + res.spo_id + ')" class="btn btn-primary btn-sm" title="edit"><i class="fa fa-pencil"></i></button>';
              hapus_btn = '<button onclick="hapus(' + res.spo_id + ')" class="btn btn-danger btn-sm" title="hapus"><i class="fa fa-trash-o"></i></button>';
            }

              var result =  '<div class="btn-group">' + preview_btn + edit_btn + hapus_btn + '</div>';

              return result;
          } 
        }
      ],
      columnDefs : [
        {
          targets : 5,
          className : 'text-right'
        },
        {
          targets : 8,
          className : 'text-center'
        }
      ]
    });
  });
</script>