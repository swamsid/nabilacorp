<table class="table tabelan table-bordered table-striped" id="detailItemm">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th width="15%">Kode Item</th>
        <th width="40%">Nama Item</th>
        <th width="10%">Jumlah di Kirim</th>
        <th width="10%">Jumlah di Terima</th>
        <th width="20%">Status</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script>
    var id = {{ $data->do_id }};
    $('#detailItemm').DataTable({
        responsive: true,
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl + "/produksi/pengambilanitem/itemkirim/tabel/" + id,
        },
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'i_code', name: 'i_code'},
            {data: 'i_name', name: 'i_name'},
            {data: 'dod_qty_send', name: 'dod_qty_send', orderable: false, className: 'right'},
            {data: 'dod_qty_received', name: 'dod_qty_received', orderable: false, className: 'right'},
            {data: 'dod_status', name: 'dod_status', orderable: false, searchable: false},
        ],
    });
</script>