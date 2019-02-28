<script>
  function search_purchasingharian() {
    tabel_d_purchaseharian.ajax.reload();
  }
	function refresh_purchasingharian() {
    $('#tgl_awal_belanjaharian').val(
      moment().subtract(7, 'days').format('DD/MM/YYYY')
    );
    $('#tgl_akhir_belanjaharian').val(
      moment().format('DD/MM/YYYY')
    );
    search_purchasingharian();
  }

  function print_lap_belanja_harian() {
    var tgl_awal = $('#tgl_awal_belanjaharian').val();
    var tgl_akhir = $('#tgl_akhir_belanjaharian').val();
    var send_to = '{{ url("purchasing/lap-pembelian/print-lap-belanja-harian") }}/';
    send_to += tgl_awal + '/' + tgl_akhir;
    window.open(send_to, '_blank');
  }
</script>