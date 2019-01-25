<script>
	var tabel_d_purchasereturn_dt;

	 $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    $('.datepicker').datepicker({
      format: "mm-yyyy",
      viewMode: "months",
      minViewMode: "months"
    });

    //autofill
    $('#pilih_metode_return').change(function()
    {
      //remove child div inside appending-form before appending
      $('#appending-form div').remove();
      var method = $(this).val();
      var methodTxt = $(this).text();
      if (method == "") 
      {
        //alert("Mohon untuk Memilih salah satu dari metode return pembelian")
        $('#appending-form div').remove();
      }
      
      else {
        //remove child div inside appending-form before appending
        $('#appending-form div').remove();
        $('#appending-form').append('<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nota Pembelian</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<select class="form-control input-sm select2" name="pr_purchase" style="width: 100% !important;">'
                                          +'<option> - Pilih Nota Pembelian</option>'
                                        +'</select>'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Kode Return</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="kodeReturn" readonly="" placeholder="(Auto)" class="form-control input-sm" value="">'
                                        +'<input type="hidden" name="metodeReturn" readonly="" class="form-control input-sm">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Tanggal Return</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input id="tanggalReturn" class="form-control input-sm datepicker2 " name="pr_datecreated" type="text" value="{{ date('d-m-Y') }}">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Staff</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="namaStaff" readonly="" class="form-control input-sm" id="nama_staff" value="{{ $staff['nama'] }}">'
                                        +'<input type="hidden" name="pr_staff" class="form-control input-sm" id="id_staff" value="{{ $staff['id'] }}">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Supplier</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="namaSup" readonly="" class="form-control input-sm" id="nama_sup">'
                                        +'<input type="hidden" name="idSup" readonly="" class="form-control input-sm" id="id_sup">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Metode Bayar</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="methodBayar" readonly="" class="form-control input-sm" id="method_bayar">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Pembelian</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalGross" readonly="" class="form-control input-sm right" id="nilai_total_gross">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Diskon</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalDisc" readonly="" class="form-control input-sm right" id="nilai_total_disc">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Pajak</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalTax" readonly="" class="form-control input-sm right" id="nilai_total_tax">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Pembelian (Nett)</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalNett" readonly="" class="form-control input-sm right" id="nilai_total_nett">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Return</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalReturn" readonly="" class="form-control input-sm right" id="prdt_pricetotal">'
                                        +'<input type="hidden" name="nilaiTotalReturnRaw" readonly="" class="form-control input-sm" id="nilai_total_return_raw">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="table-responsive">'
                                      	+'<table class="table tabelan table-bordered" id="tabel_d_purchasereturn_dt">'
                                          +'{{ csrf_field() }}'
                                          +'<thead>'
                                            +'<tr>'
                                              +'<th width="30%">Kode | Barang</th>'
                                              +'<th width="10%">Qty</th>'
                                              +'<th width="10%">Satuan</th>'
                                              +'<th width="15%">Harga</th>'
                                              +'<th width="15%">Total</th>'
                                              +'<th width="10%">Stok</th>'
                                              +'<th width="5%">Aksi</th>'
                                            +'</tr>'
                                          +'</thead>'
                                          +'<tbody id="div_item">'
                                          +'</tbody>'
                                      	+'</table>'
                                    +'</div>'
                                      +'<div align="right">'
                                        +'<div id="div_button_save" class="form-group">'
                                          +'<button type="button" id="button_save" style="margin-top:2mm" class="btn btn-primary" onclick="simpanReturn()">Simpan Data</button>'
                                        +'</div>'
                                      +'</div>');
      }

      tabel_d_purchasereturn_dt = $('#tabel_d_purchasereturn_dt').DataTable({
      	'columnDefs': [
               {
                  'targets': [3, 4, 5],
                  'createdCell':  function (td) {
                     $(td).attr('align', 'right'); 
                  }
               }
        ],
        "createdRow": function( row, data, dataIndex ) {
          	var prdt_qtyreturn = $(row).find('[name="prdt_qtyreturn[]"]');
          	format_currency(prdt_qtyreturn);
          	var remove_btn = $(row).find('.remove_btn');


          	prdt_qtyreturn.next().keyup(function(){
          		var tr = $(this).parents('tr');
          		var price = tr.find('[name="prdt_price[]"]').val();
          		var qtyreturn = $(this).prev().val();
          		var pricetotal = qtyreturn * price;
				var td = tr.find('td');
				$( td[4] ).text(
					get_currency( pricetotal )
				); 
 
          		count_prdt_pricetotal();
          	});
          	prdt_qtyreturn.next().change(function(){
          		$(this).trigger('keyup')
          	});

          	remove_btn.click(function(){
          		var tr = $(this).parents('tr');
          		tabel_d_purchasereturn_dt.row( tr ).remove().draw();
          	});
		 }
      });

      tabel_d_purchasereturn_dt.on('draw.dt', count_prdt_pricetotal);

      //Mengambil data transaksi penjualan
      $('[name="pr_purchase"]').each(function(){
        $(this).select2({
          placeholder: "Pilih Nota Pembelian...",
          ajax: {
            url: baseUrl + '/purchasing/returnpembelian/find_d_purchase_order',
            dataType: 'json',
            data: function (params) {
              return {
                  q: $.trim(params.term)
              };
            },
            processResults: function (res) {
                for(x = 0;x < res.data.length;x++) {
                  res.data[x]['id'] = res.data[x].po_id;
                  res.data[x]['text'] = res.data[x].po_code;
                }

                return {
                    results: res.data
                };
            },
            cache: true
          }, 
        });

        $(this).change(function(){

        //remove existing appending row
        $('tr').remove('.tbl_form_row');
        var idPo = $('#pr_purchase').val();
        var pr_purchase = $(this).select2('data');
        pr_purchase = pr_purchase[0];

            //total diskon didapat dari value diskon + percentase diskon
            var discTotalVal = parseInt(pr_purchase.po_discount)+parseInt(pr_purchase.po_disc_value);
            var totalGross = pr_purchase.po_total_gross;
            var taxPercent = pr_purchase.po_tax_percent;
            var totalTax = pr_purchase.po_tax_value;
            //persentase diskon berdasarkan total harga bruto
            var percentDiscTotalGross = parseFloat(discTotalVal*100/totalGross);
            //console.log(percentDiscTotalGross);
            //harga total setelah diskon dan 
            var totalNett = pr_purchase.po_total_net;
            //data header
            $('#nama_sup').val(pr_purchase.s_company);
            $('#id_sup').val(pr_purchase.s_id);
            $('#method_bayar').val(pr_purchase.po_method);
            $('[name="metodeReturn"]').val($('#pilih_metode_return').val());
            $('#nilai_total_gross').val(convertDecimalToRupiah(totalGross));
            $('#nilai_total_disc').val(convertDecimalToRupiah(discTotalVal));
            $('#nilai_total_tax').val(convertDecimalToRupiah(totalTax));
            $('#nilai_total_nett').val(convertDecimalToRupiah(totalNett));
            var totalHarga = 0;
            var key = 1;
            i = randString(5);
            //loop data
            find_d_purchaseorder_dt();
            //set readonly to enabled

            //force integer input in textfield
            $('input.numberinput').bind('keypress', function (e) {
                return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
            });
        });
      });

      //datepicker
      $('.datepicker2').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      });
      
      //event onchange select option
      
 
    });

    $(document).on('click', '.btn_remove', function(){
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
      totalNilaiReturn();
      totalNilaiReturnRaw();
    });

    //event focus on input qty
    $(document).on('focus', '.field_qty',  function(e){
      var qty = $(this).val();
      $(this).val(qty);
      $('#button_save').attr('disabled', true);
    });

    $(document).on('blur', '.field_qty',  function(e){
      var getid = $(this).attr("id");
      var qtyReturn = $(this).val();
      var cost = $('#costRaw_'+getid+'').val();
      var hasilTotal = parseInt(qtyReturn * cost);
      var hasilTotalRaw = parseFloat(qtyReturn * cost).toFixed(2);
      var totalCost = $('#total_'+getid+'').val(convertDecimalToRupiah(hasilTotal));
      var totalCostRaw = $('#totalRaw_'+getid+'').val(hasilTotalRaw);
      // $(this).val(potonganRp);
      totalNilaiReturn();
      totalNilaiReturnRaw();
      $('#button_save').attr('disabled', false);
    });

    $(document).on('keyup', '.field_qty', function(e) {
      var val = parseInt($(this).val());
      var getid = $(this).attr("id");
      var anchor = $('#qtyAnchor_'+getid+'').val();
      //console.log(anchor());
      if (val > anchor || $(this).val() == "" || val == 0) {
        $(this).val(anchor);
      }
    });

    //validasi
    $("#form_return_pembelian").validate({
      rules:{
        tanggal: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  //end jquery
  });
</script>