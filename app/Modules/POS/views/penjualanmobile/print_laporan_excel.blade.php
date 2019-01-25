		<table width="100%" cellpadding="2px" class="tabel" border="1px" style="margin-bottom: 10px;">
			<thead>
				<tr>
					<th width="100px">Nama Barang</th>
					<th>No Bukti</th>
					<th>Tanggal</th>
					<th>Jatuh Tempo</th>
					<th>Customer</th>
					<th>Sat</th>
					<th>Qty</th>
					<th>Harga</th>
					<th>Diskon %</th>
					<th>Diskon Value</th>
					<th>DPP</th>
					<th>PPN</th>
					<th>Total</th>
					
				</tr>
			</thead>
			<tbody>
			@foreach( $data as $item )
				<tr>
					<td>{{ $item->i_name }}</td>
					<td>{{ $item->s_note }}</td>
					<td>{{ $item->sd_date }}</td>
					<td>{{ $item->s_finishdate }}</td>
					<td>{{ $item->s_nama_cus }}</td>
					<td>{{ $item->s_detname }}</td>
					<td>{{ $item->sd_qty }}</td>
					<td>{{ $item->sd_price }}</td>
					<td>{{ $item->sd_disc_percent }}</td>
					<td>{{ $item->sd_disc_percentvalue }}</td>
					<td>0</td>
					<td>0</td>
					<td>{{ $item->sd_total }}</td>
				</tr>
			@endforeach
			</tbody>

		</table>
		
		<div class="float-left" style="width: 30vw;">
			<table class="border-none" width="100%">
				<tr>
					<td>Diskon %</td>
					<td>:</td>
					<td>0,00</td>
				</tr>
				<tr>
					<td>Diskon Value</td>
					<td>:</td>
					<td>{{ $total_discountvalue }}</td>
				</tr>
				<tr>
					<td>DPP</td>
					<td>:</td>
					<td>0, 00</td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td>:</td>
					<td>{{ $grand_total }}</td>
				</tr>
			</table>
		</div>
		
	
