<script>
  purchasingharian = { d_pcsh_id : null };
  $(document).ready(function(){
    $('#tgl_awal').val(
      moment().subtract(7, 'days').format('DD/MM/YYYY')
    );
    $('#tgl_akhir').val(
      moment().format('DD/MM/YYYY')
    );

    $('#tgl_awal').datepicker({
         format: "dd/mm/yyyy"
    });

    $('#tgl_akhir').datepicker({
         format: "dd/mm/yyyy"
    });

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
          { data : 'c_divisi' },
          { data : 'd_pcsh_keperluan' },
          { 
            data : null, 
            render : function(res) {
              var currency = 'Rp. ' + get_currency(res.d_pcsh_totalprice);

              return currency;
            }
          },
          { 
            data : null, 
            render : function(res) {
              var classname;
              if(res.d_pcsh_status == 'DE') {
                classname = 'label-info';
              }
              else if(res.d_pcsh_status == 'AP') {
                classname = 'label-success';
              }
              if(res.d_pcsh_status == 'NA') {
                classname = 'label-danger';
              }
              var label = '<label class="label ' + classname + '">' + res.d_pcsh_status_label + '</label>'

              return label;
            }
          },
          { 
            data : null, 
            render : function(res) {
              var is_disabled = 'disabled';
              if(res.d_pcsh_status == 'DE') {
                is_disabled = '';
              } 
                var result = '<div class="btn-group"><button ' + is_disabled + ' type="button" class="btn btn-success" title="Ubah status" data-toggle="modal" data-target="#modal_alter_status" onclick="form_update_d_pcsh_status(this)"><i class="fa fa-check"></i></button></div>';

                return result;
            }
          },
          { 
            data : null,
            render : function(res) {
              var is_disabled = 'disabled';
              if(res.d_pcsh_status == 'DE') {
                is_disabled = '';
              }
              var preview_btn = '<button onclick="open_form_preview(' + res.d_pcsh_id + ')" class="btn btn-success btn-sm" title="Preview"><i class="fa fa-list"></i></button>';
              var edit_btn = '<button ' + is_disabled + ' onclick="open_form_update(' + res.d_pcsh_id + ')" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil"></i></button>';
                var hapus_btn = '<button ' + is_disabled + ' onclick="hapus(' + res.d_pcsh_id + ')" class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash-o"></i></button>';

                var result = '<div class="btn-group">' + preview_btn + edit_btn + hapus_btn + '</div>';

                return result;
            } 
          }
      ],
      'columnDefs' : [
        {
          targets : 5,
          className : 'text-right'
        },
        {
          targets : [6, 7],
          className : 'text-center'
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