<script>
  purchase_plan = { sp_id : null};
  tabel_d_shop_purchase_plan = null;
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

    tabel_d_shop_purchase_plan = $("#tabel_d_shop_purchase_plan").DataTable({
      serverSide : true,
      processing : true,
      ajax: {
        "url": "{{ route('find_d_shop_purchase_plan') }}",
        
        data: function(res){
          var tgl_awal = $('#tgl_awal').val();
          var tgl_akhir = $('#tgl_akhir').val();
          
            res['_token'] = "{{ csrf_token() }}";
            res['tgl_awal'] = tgl_awal;
            res['tgl_akhir'] = tgl_akhir;

          return res;
        },
      },
      columns: [

        { data : 'sp_date_label' },
    		{ data : 'sp_code' },
    		{ data : 's_company' },
    		{ 
          data : null,
          render : function(res) {
            var classname = 'label-info';
            if(res.sp_status == 'AP') {
              classname = 'label-success'; 
            }
            else if(res.sp_status == 'NAP') {
              classname = 'label-danger';
            }
            var outp = "<span class='label " + classname + "'>" + res.sp_status_label + "</span>"

            return outp;
          }
        },
        {
          data : null,
          render : function(res) {
            var btn = '-';
            if(res.sp_status != '') {
                btn = '<button data-target="#modal_alter_status" data-toggle="modal" class="btn btn-success btn-sm" title="alter_status" style="width:100%" onclick="form_update_sp_status(this)"><i class="fa fa-pencil"></i></button>';
            }

            return btn;
          }
        },
        { 
          data : null,
          render : function(res) {
            var preview_btn = '<button onclick="open_preview(' + res.sp_id + ')" class="btn btn-info btn-sm small" title="preview"><i class="fa fa-eye"></i></button>';
            var edit_btn = '';
            var hapus_btn = '';
            if(res.sp_status == 'WT') {	
            	edit_btn = '<button onclick="open_form_update(' + res.sp_id + ')" class="btn btn-primary btn-sm" title="edit" style=""><i class="fa fa-pencil small"></i></button>';
              hapus_btn = '<button onclick="hapus(' + res.sp_id + ')" class="btn btn-danger btn-sm" title="hapus"><i class="fa fa-trash-o "></i></button>';
            }

              var result =  '<div class="btn-group">' + preview_btn + edit_btn + hapus_btn + '</div>' ;

              return result;
          } 
        }
      ],
      columnDefs : [
        {
          targets : [3, 5],
          className : 'text-center'
        },
        {
          targets : [3, 4, 5],
          orderable : false
        }
      ]
    });
  });
</script>