		<table width="100%" cellpadding="2px" class="tabel" border="1px" style="margin-bottom: 10px;">
			<thead>
				<tr>
					<th >Nama Barang</th>
					<th width="20px">No Bukti</th>
					<th width="15px">Tanggal</th>					
					<th width="15px">Customer</th>
					<th width="15px">Sat</th>
					<th width="10px">Qty</th>
					<th width="10px">Harga</th>
					<th width="10px">Diskon %</th>
					<th width="10px">Diskon Value</th>
					<!-- <th>DPP</th>
					<th>PPN</th> -->
					<th width="10px">Total</th>
					
				</tr>
			</thead>
			<tbody>
			@foreach( $data as $item )
				<tr>
					<td>{{ $item->i_name }}</td>
					<td>{{ $item->s_note }}</td>
					<td>{{ $item->sd_date }}</td>					
					<td>{{ $item->s_nama_cus }}</td>
					<td>{{ $item->s_detname }}</td>							
					<td align="right" >{{number_format($item->sd_qty ,2,',','.')}}</td>
					<td align="right" >{{number_format($item->sd_price ,2,',','.')}}</td>
					<td align="right" >{{number_format($item->sd_disc_percent ,2,',','.')}}</td>
					<td align="right" >{{number_format($item->sd_disc_percentvalue ,2,',','.')}}</td>
					<!-- <td>0</td>
					<td>0</td> -->
					<td align="right">{{ $item->sd_total }}</td>
				</tr>
			@endforeach
			</tbody>

		</table>
		
		<div class="float-left" style="width: 30vw;">
			<table >
				<tr>
					<td>Diskon % (Rupiah)</td>
					<td>:</td>										
					<td align="right">{{number_format($total_discountPercent,2,',','.')}}</td>
				</tr>
				<tr>				
					<td>Diskon Rupiah</td>
					<td>:</td>
					<td align="right">{{number_format($total_discountvalue,2,',','.')}}</td>
				</tr>
				<tr>
					<td>DPP</td>
					<td>:</td>
					<td align="right">0,00</td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td>:</td>
					<td align="right">{{number_format($grand_total,2,',','.')}}</td>					
				</tr>
			</table>
		</div>
		
	
