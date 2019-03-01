<style type="text/css" media="print">
    @page { size: portrait; }
</style>

<?php 
	$tanggal_1 = switchBulan(explode('/', $_GET['d1'])[0]).' '.explode('/', $_GET['d1'])[1];
?>

<table width="100%">
	<thead>
		<tr>
			<td style="font-weight: 800">Laporan Neraca Lampiran</td>
		</tr>

		<tr>
			<td>{{ jurnal()->companyName }} &nbsp;- {{ $data['cabang'] }}</td>
		</tr>

		<tr>
			<td style="border-bottom: 1px solid #aaa; padding-bottom: 20px;"><small>Bulan {{ $tanggal_1 }}</small></td>
		</tr>
	</thead>
</table>

<br>

<table width="100%" style="font-size: 9pt; border-collapse: collapse;">
	<tbody>
		@foreach($data['data'] as $key => $parrent)
			<?php $totParrent = 0 ?>
			<tr>
				<td colspan="2" style="padding: 5px; font-weight: 600; font-size: 10pt; text-align: left; border: 0px solid #ccc;">
					{{ $parrent->hld_id }} - {{ $parrent->hld_nama }}
				</td>
			</tr>

			@foreach($parrent->akun as $key => $detail)
				<tr>
					<td style="padding: 5px 40px; font-weight: normal; font-size: 10pt; text-align: left; border-bottom: 1px solid #ccc;">
						{{ $detail->ak_nomor }} - {{ $detail->ak_nama }}
					</td>

					<td style="padding: 5px 20px; font-weight: normal; font-size: 10pt; text-align: right; border-bottom: 1px solid #ccc;">
						{{ ($detail->saldo_akhir < 0 ) ? '('.number_format(str_replace('-', '', $detail->saldo_akhir), 2).')' : number_format($detail->saldo_akhir, 2) }}
					</td>

					<?php 
						if(explode('.', $parrent->hld_id)[0] == 1){
							$totParrent += ($detail->ak_posisi == 'D') ? $detail->saldo_akhir : ($detail->saldo_akhir * -1);
						}else{
							$totParrent += ($detail->ak_posisi == 'K') ? $detail->saldo_akhir : ($detail->saldo_akhir * -1);
						}
					?>
				</tr>
			@endforeach

			<tr>
				<td style="padding: 5px; font-weight: 600; font-size: 10pt; text-align: left; border: 0px solid #ccc;">
					Total {{ $parrent->hld_nama }}
				</td>

				<td style="padding: 5px 20px; font-weight: 600; font-size: 10pt; text-align: right; border: 0px solid #ccc;border-top: 1px solid #ccc;">
					{{ ($totParrent < 0 ) ? '('.number_format(str_replace('-', '', $totParrent), 2).')' : number_format($totParrent, 2) }}
				</td>
			</tr>

			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
		@endforeach
	</tbody>
</table>

<script type="text/javascript">
	window.print()
</script>