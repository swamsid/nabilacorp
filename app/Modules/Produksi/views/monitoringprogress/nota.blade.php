<div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
	<div class="col-md-3 col-sm-3 col-xs-12" align="left">
		<h4 id="judul-item" style="padding-bottom: 5px; margin-left: 10px">Nota Rencana</h4>
	</div>
	<table class="table tabelan table-hover table-bordered" id="tableNotaPlan">
		<thead>
			<tr>
				<th>No</th>
				<th>Nota</th>
				<th>Tanggal</th>
				<th style="width:13%;">Jumlah Order</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($rencana as $index => $item)
			<tr>
				<td>{{$index+1}}</td>
				<td>{{$item->sp_code}}</td>
				<td>{{date('d M Y', strtotime($item->sp_date))}}</td>
				<td class="text-right">{{$item->spdt_qty}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
	<div class="col-md-3 col-sm-3 col-xs-12" align="left">
		<h4 id="judul-item" style="padding-bottom: 5px; margin-left: 10px">Nota Pesanan</h4>
	</div>
	<table class="table tabelan table-hover table-bordered" id="tableNotaPlan1">
		<thead>
			<tr>
				<th>No</th>
				<th>Nota</th>
				<th>Tanggal Pemesanan</th>
				<th>Tanggal Selesai</th>
				<th style="width:13%;">Jumlah Order</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($pesanan as $index => $item)
			<tr>
				<td>{{$index+1}}</td>
				<td>{{$item->s_note}}</td>
				<td>{{date('d M Y', strtotime($item->s_date))}}</td>
				<td>{{date('d M Y', strtotime($item->s_finishdate))}}</td>
				<td class="text-right">{{$item->sd_qty}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$('#tableNotaPlan').DataTable();
	$('#tableNotaPlan1').DataTable();
</script>